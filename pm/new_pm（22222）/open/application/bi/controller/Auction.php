<?php
namespace app\bi\controller;

use app\common\controller\NoAuth;
use app\bi\model\Auction as Auction_model;

class Auction extends NoAuth {
	/**
	 * 商户计数器查询
	 */
	public function index() {
		$auction_id = (int) $this->request->get('auction_id');
		if ($auction_id == 0) {
			$this->_error('参数错误', 400);
		}

		$data = (new Auction_model())->show($auction_id);

		return ['error'=>0, 'result'=>$data];
	}


}