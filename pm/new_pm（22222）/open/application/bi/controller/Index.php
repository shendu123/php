<?php
namespace app\bi\controller;

use app\common\controller\NoAuth;
use app\bi\model\Business;

class Index extends NoAuth {
	/**
	 * 商户计数器查询
	 */
	public function business_attention_recommend() {

		$data = (new Business())->attention_recommend();

		return ['error'=>0, 'result'=>$data];
	}


}