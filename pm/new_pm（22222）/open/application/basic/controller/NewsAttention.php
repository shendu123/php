<?php

namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\NewsAttention as NewsAttention_model;

class NewsAttention extends NoAuth {

	/**
	 * 关注列表
	 */
	public function index() {
		$this->_checkLogin();

		$get = $this->request->get();

		$get['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new NewsAttention_model())->search($this->_uid, $get['page'], $get['page_size'],$get['wd']);
		
		return [
			'error' => 0,
			'result' => $data
		];

	}

	/**
	 * 是否关注文章
	 */
	public function isattention() {
		$this->_checkLogin();
		
		$newsid = (int)$this->request->get('newsid');
		if ($newsid == 0) {
			$this->_error('参数错误', 400);
		}

		$rs = (new NewsAttention_model())->isattention($this->_uid, $newsid);

		$isattention = !empty($rs) && $rs['id'] > 0 ? 1 : 0;
		$id = !empty($rs) && $rs['id'] > 0 ? $rs['id'] : 0;

		return ['error'=>0, 'isattention'=> $isattention, 'id'=>$id];

	}

	/**
	 * 添加文章关注
	 */
	public function add() {
		$this->_checkLogin();

		if(true !== ($validate = $this->validate($this->request->post(), 'NewsAttentionAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();

		$data = [
			'newsid'=>$post['newsid'],
			'title'=>$post['title'],
			'picurl'=>isset($post['picurl']) ? $post['picurl'] : '',
			'author'=>$post['author'],
			'uid'=>$this->_uid,
		];

		$isattention_rs = (new NewsAttention_model())->isattention($this->_uid, $post['newsid']);

		$isattention = !empty($isattention_rs) && $isattention_rs['id'] > 0 ? 1 : 0;
		if ($isattention) {
			$this->_error('文章关注过了', 400);
		}

		$rs = (new NewsAttention_model())->add($data);

		return $rs ? ['error'=>0, 'id'=>$rs] : $this->_error('文章关注失败', 500);

	}

	/**
	 * 取消关注
	 */
	public function del() {
		$this->_checkLogin();

		$naids = $this->request->get('naids');
		if (empty($naids)) {
			$this->_error('参数错误', 400);
		}
		$naids_arr = explode(',', $naids);
		foreach ($naids_arr as $key => $value) {
			if (intval($value) == 0) {
				$this->_error('参数错误', 400);
			}

			$naids_arr[$key] = intval($value);
		}

		$rs = (new NewsAttention_model())->del($this->_uid, $naids_arr);

		return $rs ? ['error'=>0, 'msg'=>'取消关注成功'] : $this->_error('取消关注失败', 500);
	}
}