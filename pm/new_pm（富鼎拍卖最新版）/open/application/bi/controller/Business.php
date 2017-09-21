<?php
namespace app\bi\controller;

use app\common\controller\NoAuth;
use app\bi\model\Business as Business_model;

class Business extends NoAuth {
	/**
	 * 商户计数器查询
	 */
	public function index() {
		$business_id = (int) $this->request->get('business_id');
		if ($business_id == 0) {
			$this->_error('参数错误', 400);
		}

		$data = (new Business_model())->show($business_id);

		return ['error'=>0, 'result'=>$data];
	}


}