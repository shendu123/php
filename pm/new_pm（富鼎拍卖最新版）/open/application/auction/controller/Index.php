<?php
namespace app\auction\controller;

use app\common\controller\NoAuth;
use app\auction\model\Auction;
use app\bi\model\Business as bi_Business;
use app\bi\model\Auction as bi_Auction;

class Index extends NoAuth
{

	/**
	 * 拍品列表
	 */
	public function index()
	{
		$get = $this->indexGet();

		$data = (new Auction())->list_data($get['mode'], $get['cid'], $get['bid'], $get['business_id'], $get['order'], $get['page'], $get['page_size'], $get['period']);
		
		if ($data) {
			return [
				'error' => 0
			] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 拍品搜索
	 */
	public function search()
	{
		$get = $this->request->get();

		$get['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new Auction())->search($get['wd'], $get['page'], $get['page_size']);
		
		if ($data) {
			return [
				'error' => 0
			] + $data;
		} else {
			$this->_error('system error', 500);
		}
	}

	/**
	 * 拍品详情
	 */
	public function detail()
	{
		$aid = (int) $this->request->get('aid');
		if ($aid == 0) {
			$this->_error('参数错误', 400);
		}
		
		$data = (new Auction())->detail($aid);
		
		(new bi_Auction())->change_onlookers($aid);

		return [
			'error' => 0,
			'result' => $data
		];
	}

	/**
	 * 出价
	 */
	public function bid()
	{
		$auction_detail = $this->_checkbid();

		$userInfo = curl_get_content(config('basic_api_url') . 'Util/getUserInfo', 0, [], $this->request->header('accesstoken'));

		$rs = (new Auction())->bid((int) $this->request->post('aid'), (int) $this->request->post('multiple'), $this->_uid, $userInfo->nickname, $userInfo->avatar, $auction_detail);
		
		unset($auction_detail);

		if ($rs['status'] == 1) {
			return [
				'error' => 0,
				'msg' => '出价成功',
				'order_no'=> ''
			];
		}
		else if ($rs['status'] == 2) {
			return [
				'error' => 0,
				'msg' => '出价成功',
				'order_no' => $rs['order_no']
			];
		}
		else {
			$this->_error('系统出错', 500);
		}
		
	}

	/**
	 * 我是否竞拍到拍品
	 */
	public function is_bid()
	{
		if ($this->_uid == 0) {
			$this->_error('Forbidden', 403);
		}
		$aid = (int) $this->request->get('aid');
		if ($aid == 0) {
			$this->_error('参数错误', 400);
		}
		
		$data = (new Auction())->is_bid($aid, $this->_uid);
		
		if ($data === false) {
			$this->_error('system error', 500);
		}

		return [
			'error' => 0,
			'result' => $data
		];
		
	}
	/**
	 * 出价记录
	 */
	public function bid_record()
	{
		$aid = (int) $this->request->get('aid');
		$my_record = (int) $this->request->get('my_record');
		
		$data = (new Auction())->bid_record($aid, $my_record, $this->_uid);
		
		return [
			'error' => 0,
			'result' => $data
		];
	}

	/**
	 * 我的竞价
	 */
	public function my_bid_record()
	{
		if ($this->_uid == 0) {
			$this->_error('Forbidden', 200);
		}
		$get = $this->request->get();
		$status = isset($get['status']) ? intval($get['status']) : 10;
		$page = isset($get['page']) ? intval($get['page']) : 1;
		$page_size = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new Auction())->my_bid_record($status, $this->_uid, $page, $page_size);
		
		return [
			'error' => 0
		] + $data;

	}

	/**
	 * 修改我的竞价里的支付状态
	 */
	public function ispay() {
		$oid = $this->request->get('oid');
		$time = $this->request->get('time');
		$key = $this->request->get('key');
		$sign_key = config('pay_sign_key');

		if (md5(md5($oid).$time.$sign_key) != $key) {
			$this->_error('Forbidden', 403);
		}

		if (empty($oid)) {
			$this->_error('参数错误', 400);
		}

		$order_status_rs = curl_get_content(config("pay_api_url")."Order/getStateByOTotalid?from=PM&oid={$oid}");

		if ($order_status_rs->type != 'success') {
			$this->_error($order_status_rs->tip, 500);
		} else if ($order_status_rs->data->ispay != 3) {
			$this->_error('订单未支付', 400);
		}

		$counter = (new bi_Business())->change_sale($order_status_rs->data->sellerid, $order_status_rs->data->price/100);

		$cb = new \Couchbase(config('couchbase.auction_my_record'));
		$rs = $cb->n1ql_query('UPDATE '.$cb->bucketName.' SET ispay=1 where order_no = "'.$oid.'"');

		return $rs->status == 'success' ? ['error'=>0,'msg'=>'修改成功'] : $this->_error('修改失败', 500);
	}

	private function indexGet()
	{
		$get = $this->request->get();
		$order_arr = ['pd','pa','bd','ba','ed','ea'];
		$get['mode'] = isset($get['mode']) ? intval($get['mode']) : - 1;
		$get['cid'] = isset($get['cid']) ? intval($get['cid']) : 0;
		$get['bid'] = isset($get['bid']) ? intval($get['bid']) : 0;
		$get['business_id'] = isset($get['business_id']) ? intval($get['business_id']) : 0;
		$get['period'] = isset($get['period']) ? intval($get['period']) : 0;
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['order'] = isset($get['order']) && in_array(trim($get['order']), $order_arr) ? trim($get['order']) : 'ea';
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');
		
		return $get;
	}

	private function _checkbid()
	{
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '200');
		}
		
		$aid = (int) $this->request->post('aid');
		$multiple = (int) $this->request->post('multiple');
		if ($multiple == 0 || $aid == 0) {
			$this->_error('参数错误', '200');
		}
		$auction_detail = (new Auction())->detail($aid);
		if (! $auction_detail) {
			$this->_error('system error', 200);
		}
		
		if ($auction_detail['member_id'] == $this->_uid) {
			$this->_error('您不能参拍自己的拍品！', '200');
		}
		
		if (strtotime($auction_detail['auction_starttime']) > microtime(true)) {
			$this->_error('当前拍品未开始！请刷新页面！', '200');
		}

		if (strtotime($auction_detail['auction_endtime']) < microtime(true) || $auction_detail['auction_flow_status'] > 10) {
			$this->_error('当前拍品已结束！请刷新页面！', '200');
		}
		
		/* 待新街口开发
		$pay_buier_price_rs = curl_get_content(config("pay_api_url") . "Order/isNeeddeposit", 1, [
			'switch_id' => $aid,
			'from' => 'PM'
			// 'from' => config("pay_from.{$auction_detail['auction_mode']}")
		], $this->request->header('accesstoken'));
		if (! $pay_buier_price_rs->type) {
			$this->_error('请先缴纳保证金！', '200');
		}
		*/
		
		$user_bid_record = (new Auction())->bid_record($aid, 1, $this->_uid);
		if (!empty($user_bid_record) && $user_bid_record[0]->bided >= $auction_detail['auction_now_price']) {
			$this->_error('您已是当前出价最高的，无需重复出价！', '200');
		}
		
		if ($auction_detail['auction_type'] && $user_bid_record) {
			$this->_error('竞标仅限出价一次，您已经出过一次价了！', '200');
		}
		
		return $auction_detail;
	}
}