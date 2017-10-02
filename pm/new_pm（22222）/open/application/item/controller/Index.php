<?php
namespace app\item\controller;

use app\common\controller\NoAuth;
use app\item\model\Item;
use app\bi\model\Business as bi_Business;

class Index extends NoAuth
{

	/**
	 * 商品列表
	 */
	public function index()
	{
		$get = $this->indexGet();

		$data = (new Item())->list_data($get['cid'], $get['business_cid'], $get['bid'], $get['business_id'], $get['order'], $get['page'], $get['page_size']);
		
		if ($data) {
			return [
				'error' => 0
			] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 商品搜索
	 */
	public function search()
	{
		$get = $this->request->get();

		$get['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$get['business_id'] = isset($get['business_id']) ? intval($get['business_id']) : 0;
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new Item())->search($get['wd'], $get['business_id'], $get['page'], $get['page_size']);
		
		if ($data) {
			return [
				'error' => 0
			] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 商品详情
	 */
	public function detail()
	{
		$item_id = (int) $this->request->get('item_id');
		if ($item_id == 0) {
			$this->_error('参数错误', 400);
		}
		
		$data = (new Item())->detail($item_id);
		
		return [
			'error' => 0,
			'result' => $data
		];
	}

	/**
	 * 修改库存
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
		$data = $cb->n1ql_query("select * from order_lock USE KEYS 'item_{$oid}'");
		if (!empty($data->rows)) {
			$this->_error('system error', 500);
		}

		$order_status_rs = curl_get_content(config("pay_api_url")."order_info/getOrderStatus?from=3&oid={$oid}",0,"","", 1);

		if ($order_status_rs['status'] != 'success') {
			$this->_error("获取订单状态失败", 500);
		} else if ($order_status_rs['data']['order_status'] != 2) {
			$this->_error('订单未支付', 400);
		} else {
			$order_status_rs_json = json_encode($order_status_rs);
			$cb->n1ql_query("INSERT INTO `order_lock` ( KEY, VALUE ) VALUES ('item_{$oid}', {$order_status_rs_json})");
		}

		$tmp = [];
		foreach ($order_status_rs['data']['order_detail'] as $key => $value) {
			if (empty($value['detail_goods_attr_value'])) {
				$inventory = (new Item())->get_inventory($value['detail_stuff_id']);

				$amount = $value['detail_num'];
				$abnormal = 0;
				if ($inventory == false || $inventory['item_inventory'] == 0) {
					$tmp['rs'][] = ['detail_stuff_id'=>$value['detail_stuff_id'], 'error'=>'没有库存'];
					continue;
				}
				if ($inventory['item_inventory'] < $value['detail_num']) {
					$abnormal = 1;
					$amount = $inventory['crowd_inventory'];

				}

				$rs = (new Item())->inventory($value['detail_stuff_id'], $amount);
				if ($rs && $abnormal == 0) {
					(new bi_Business())->change_sale($order_status_rs['data']['business_id'], $value['detail_goods_price']*$amount);
				}
				else if ($rs && $abnormal == 1) {
					$tmp['rs'][] = ['detail_stuff_id'=>$value['detail_stuff_id'], 'error'=>'库存不足'];
				}
				else {
					$tmp['rs'][] = ['detail_stuff_id'=>$value['detail_stuff_id'], 'error'=>'库存扣减失败'];
				}


			}
			else {
				$tmp['spec_goods']['data'][] = $value;
			}

		}

		$spec_goods_inventory_error = 0;
		if (!empty($tmp['spec_goods']['data'])) {

			$tmp['spec_goods']['business_id'] = $order_status_rs['data']['business_id'];
			$key = md5(md5($oid).$time.config('goods_sign_key'));
			$post_data = [
				'oid' => $oid,
				'time' => $time,
				'key' => $key,
				's' => json_encode($tmp['spec_goods'])
			];
			$spec_goods_inventory = curl_get_content(config("goods_api_url")."index/inventory",1,$post_data,"", 1);

			if (!empty($spec_goods_inventory['error']) && $spec_goods_inventory['error'] != 2) {
				$spec_goods_inventory_error = 1;
			}
			else if (!empty($spec_goods_inventory['error']) && $spec_goods_inventory['error'] == 2) {
				if (!empty($tmp['rs'])) {
					$tmp['rs'] = array_merge($tmp['rs'], $spec_goods_inventory['result']);
				}
				else {
					$tmp['rs'] = $spec_goods_inventory['result'];
				}
			}

		}

		if ($spec_goods_inventory_error) {
			$this->_error('库存扣减失败，请联系管理员');
		}
		if (!empty($tmp['rs'])) {
			return ['error'=>2,'msg'=>'库存修改成功,但存在异常','result'=>$tmp['rs']];
		}
		else {
			return ['error'=>0,'msg'=>'库存修改成功'];
		}


	}

	/**
	 * 自由买卖重要数据、sku数据
	 */
	public function important_data() {
		$post = json_decode(html_entity_decode($this->request->post('s')), true);
		if (empty($post)) {
			$this->_error('参数错误', 400);
		}

		$item = $tmp = $data = [];
		foreach ($post as $val) {
			if (intval($val['item_id']) == 0) {
				$this->_error('参数错误', 400);
			}
			$item[] = intval($val['item_id']);
			$val['spec_key'] = !isset($val['spec_key']) || empty($val['spec_key']) ? '' : $val['spec_key'];
			$tmp['item'][$val['item_id']]['spec_key'][] = $val['spec_key'];
		}

		$item = array_unique($item);
		$rs = (new Item())->important_data($item);
		if (! $rs) {
			$this->_error('system error', 500);
		}
		foreach ($rs as $key => $value) {
			$data[$value->item_id]['item'] = $value;
			$data[$value->item_id]['spec_goods'] = [];
			$tmp['item'][$value->item_id]['goods_id'] = $value->goods_id;
			$tmp['goods'][$value->goods_id] = $value->item_id;
		}

		$spec_goods = curl_get_content(config("goods_api_url")."index/spec_important_data",1,['s'=>json_encode($tmp['item'])]);
		if ($spec_goods->error != 0) {
			$this->_error('system error', 500);
		}

		foreach ($spec_goods->result as $key=>$value) {
			foreach ($value as $k=>$v) {
				$data[$tmp['goods'][$key]]['spec_goods'][$v->key] = $v;
			}

		}
		
		unset($tmp);

		return ['error'=>0, 'result'=>$data];
	}


	/**
	 * 自由买卖数据、sku数据
	 */
	public function sku_data() {
		$this->_checkLogin();
		$post = json_decode(html_entity_decode($this->request->post('s')), true);
		if (empty($post)) {
			$this->_error('参数错误', 400);
		}

		$item = $tmp = $data = [];
		foreach ($post as $val) {
			if (intval($val['item_id']) == 0) {
				$this->_error('参数错误', 400);
			}
			$item[] = intval($val['item_id']);
			$val['spec_key'] = !isset($val['spec_key']) || empty($val['spec_key']) ? '' : $val['spec_key'];
			$tmp['item'][$val['item_id']]['spec_key'][] = $val['spec_key'];
		}

		$item = array_unique($item);
		$rs = (new Item())->details($item);
		if (! $rs) {
			$this->_error('system error', 500);
		}
		foreach ($rs as $key => $value) {
			$data[$value->item_id]['item'] = $value;
			$data[$value->item_id]['spec_goods'] = [];
			$tmp['item'][$value->item_id]['goods_id'] = $value->goods_id;
			$tmp['goods'][$value->goods_id] = $value->item_id;
		}

		$spec_goods = curl_get_content(config("goods_api_url")."index/sku_data",1,['s'=>json_encode($tmp['item'])]);
		if ($spec_goods->error != 0) {
			$this->_error('system error', 500);
		}

		foreach ($spec_goods->result as $key=>$value) {
			foreach ($value as $k=>$v) {
				$data[$tmp['goods'][$key]]['spec_goods'][$v->key] = $v;
			}

		}
		
		unset($tmp);

		return ['error'=>0, 'result'=>$data];
	}

	private function indexGet()
	{
		$get = $this->request->get();
		$order_arr = ['pd','pa','cd','ca'];
		$get['cid'] = isset($get['cid']) ? intval($get['cid']) : 0;
		$get['business_cid'] = isset($get['business_cid']) ? intval($get['business_cid']) : 0;
		$get['bid'] = isset($get['bid']) ? intval($get['bid']) : 0;
		$get['business_id'] = isset($get['business_id']) ? intval($get['business_id']) : 0;
		$get['order'] = isset($get['order']) && in_array(trim($get['order']), $order_arr) ? trim($get['order']) : 'default';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');
		
		return $get;
	}

}