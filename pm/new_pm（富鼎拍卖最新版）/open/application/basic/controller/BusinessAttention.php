<?php

namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\BusinessAttention as BusinessAttention_model;
use app\bi\model\Business as Business_bi_modle;

class BusinessAttention extends NoAuth {

	/**
	 * 关注列表
	 */
	public function index() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		$get = $this->request->get();

		$get['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new BusinessAttention_model())->search($this->_uid, $get['page'], $get['page_size'],$get['wd']);
		
		return [
			'error' => 0,
			'result' => $data
		];

	}

	/**
	 * 是否关注店铺
	 */
	public function isattention() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}
		
		$businessid = (int)$this->request->get('business_id');
		if ($businessid == 0) {
			$this->_error('参数错误', 400);
		}

		$rs = (new BusinessAttention_model())->isattention($this->_uid, $businessid);

		$isattention = !empty($rs) && $rs['id'] > 0 ? 1 : 0;
		$id = $isattention ? $rs['id'] : 0;

		return ['error'=>0, 'isattention'=> $isattention, 'id'=>$id];

	}

	/**
	 * 添加店铺关注
	 */
	public function add() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		if(true !== ($validate = $this->validate($this->request->post(), 'BusinessAttentionAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();

		$data = [
			'business_id'=>$post['business_id'],
			'name'=>$post['name'],
			'picurl'=>$post['picurl'],
			'uid'=>$this->_uid,
		];

		$isattention_rs = (new BusinessAttention_model())->isattention($this->_uid, $post['business_id']);

		$isattention = !empty($isattention_rs) && $isattention_rs['id'] > 0 ? 1 : 0;
		if ($isattention) {
			$this->_error('店铺关注过了', 400);
		}


		$rs = (new BusinessAttention_model())->add($data);

		if ($rs) {
			$counter = (new Business_bi_modle())->change_attention_num($data['business_id']);
		}

		return $rs ? ['error'=>0, 'id'=>$rs] : $this->_error('店铺关注失败', 500);

	}

	/**
	 * 取消关注
	 */
	public function del() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		$baids = $this->request->get('baids');
		if (empty($baids)) {
			$this->_error('参数错误', 400);
		}
		$baid_arr = explode(',', $baids);
		foreach ($baid_arr as $key => $value) {
			if (intval($value) == 0) {
				$this->_error('参数错误', 400);
			}

			$baid_arr[$key] = intval($value);
		}

		$business_ids = (new BusinessAttention_model())->get_business_id($baid_arr);
		$business_id_arr = [];
		foreach ($business_ids as $business_id) {
			$business_id_arr[] = $business_id['business_id'];
		}

		$rs = (new BusinessAttention_model())->del($this->_uid, $baid_arr);

		if ($rs) {
			$business_id_str = join(',', $business_id_arr);
			$counter = (new Business_bi_modle())->change_attention_num($business_id_str, 1);
		}

		return $rs ? ['error'=>0, 'msg'=>'取消关注成功'] : $this->_error('取消关注失败', 500);
	}
}