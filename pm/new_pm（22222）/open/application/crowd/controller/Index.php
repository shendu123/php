<?php
namespace app\crowd\controller;

use app\common\controller\NoAuth;
use app\crowd\model\Crowd;
use app\bi\model\Business as bi_Business;

class Index extends NoAuth {

	/**
	 * 申购列表
	 */
	public function index() {
		$get = $this->indexGet();

		$data = (new Crowd())->list_data($get['cid'],$get['bid'],$get['business_id'],$get['order'],$get['page'],$get['page_size'],$get['period']);

		if ($data) {
			return ['error'=>0] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 申购搜索
	 */
	public function search()
	{
		$get = $this->request->get();

		$get['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new Crowd())->search($get['wd'], $get['page'], $get['page_size']);
		
		if ($data) {
			return [
				'error' => 0
			] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 申购详情
	 */
	public function detail() {
		$crowd_id = (int)$this->request->get('crowd_id');
		if ($crowd_id == 0) {
			$this->_error('参数错误', 400);
		}

		$data = (new Crowd())->detail($crowd_id);

		return ['error'=>0, 'result'=>$data];
	}

	/**
	 * 下单
	 */
	public function order() {
		$this->_checkLogin();
		$crowd_id = (int)$this->request->post('crowd_id');
		$num = (int)$this->request->post('num');

		if ($crowd_id == 0 || $num == 0) {
			$this->_error('参数错误', 200);
		}

		$data = (new Crowd())->detail($crowd_id);
		if (empty($data)) {
			$this->_error('system error', 200);
		}

		if ($data['crowd_starttime'] > microtime(true)) {
			$this->_error('当前申购未开始！请刷新页面！', 200);
		}
		
		if ($data['crowd_endtime'] < microtime(true)) {
			$this->_error('当前申购已结束！请刷新页面！', 200);
		}

		$remain = $data['crowd_total'] - $data['crowd_consume'];
		if ($num > $remain) {
			$this->_error('申购数量大于可申购数量', 200);
		}

		$post_data = $this->order_post_params($num, $data);

		$pay_order_rs = curl_get_content(config("pay_api_url")."Order/create", 1, $post_data, $this->request->header('accesstoken'));

		if (empty($pay_order_rs) || $pay_order_rs->type != 'success') {
			$this->_error($pay_order_rs->tip, 200);
		}
		else {
			return ['error' => 0, 'result'=>$pay_order_rs];
		}

	}

	/**
	 * 库存变更
	 */
	public function inventory() {
		$oid = $this->request->get('oid');
		$time = $this->request->get('time');
		$key = $this->request->get('key');
		$sign_key = config('pay_sign_key');

		if (md5(md5($oid).$time.$sign_key) != $key) {
			$this->_error('Invalid AccessToken', 401);
		}

		if (empty($oid)) {
			$this->_error('参数错误', 400);
		}

		$cb = new \Couchbase(config('couchbase'));
		$data = $cb->n1ql_query("select * from order_lock USE KEYS 'crowd_{$oid}'");
		if (!empty($data->rows)) {
			$this->_error('system error', 500);
		}

		$order_status_rs = curl_get_content(config("pay_api_url")."order_info/getOrderStatus?from=2&oid={$oid}");
		
		if ($order_status_rs->status != 'success') {
			$this->_error("获取订单状态失败", 500);
		} else if ($order_status_rs->data->order_status != 2) {
			$this->_error('订单未支付', 400);
		} else {
			$order_status_rs_json = json_encode($order_status_rs);
			$cb->n1ql_query("INSERT INTO `order_lock` ( KEY, VALUE ) VALUES ('crowd_{$oid}', {$order_status_rs_json})");
		}

		$inventory = (new Crowd())->get_inventory($order_status_rs->data->detail_stuff_id);

		$abnormal = 0;
		$amount = $order_status_rs->data->detail_num;
		if ($inventory == false || $inventory['crowd_inventory'] == 0) {
			return ['error'=>1, '没有库存'];
		}
		if ($inventory['crowd_inventory'] < $order_status_rs->data->detail_num) {
			$abnormal = 1;
			$amount = $inventory['crowd_inventory'];
		}


		$rs = (new Crowd())->inventory($order_status_rs->data->detail_stuff_id, $amount);
		if ($rs && $abnormal == 0) {
			$counter = (new bi_Business())->change_sale($order_status_rs->data->business_id, $order_status_rs->data->detail_goods_price*$amount);
			return ['error'=>0,'msg'=>'库存修改成功'];
		}
		else if ($rs && $abnormal == 1) {
			return ['error'=>2,'msg'=>'库存修改成功,但库存不足'];
		}
		else {
			$this->_error('库存修改失败', 500);
		}

	}

	private function indexGet() {
		$order_arr = ['pd','pa','cd','ca'];

		$get = $this->request->get();
		$get['cid'] = isset($get['cid']) ? intval($get['cid']) : 0;
		$get['bid'] = isset($get['bid']) ? intval($get['bid']) : 0;
		$get['business_id'] = isset($get['business_id']) ? intval($get['business_id']) : 0;
		$get['period'] = isset($get['period']) ? intval($get['period']) : 0;
		$get['order'] = isset($get['order']) && in_array(trim($get['order']), $order_arr) ? trim($get['order']) : 'default';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		return $get;
	}

	private function order_post_params($num, $data) {
		$post = [];
		$post['item'][] = [
			'from' => 'SG',
			'freight' => $data['crowd_freight_price'],
			'price' => $data['crowd_price'],
			'broker' => $data['crowd_broker_price'],
			'title' => $data['crowd_name'],
			'pay_switch_id' => $data['crowd_id'],
			'sellerid' => $data['business_id'],
			'amount' => $num,
			'picurl' => $data['goods_thumb'],
		];
		$post['total_price'] = $data['crowd_price'] * $num;
		$post['total_freight'] = $data['crowd_freight_price'] * $num;
		$post['businessid'] = $data['business_id'];
		$post['title'] = $data['crowd_name'];
		$post['total_broker'] = $data['crowd_broker_price'];

		return $post;
	}
}