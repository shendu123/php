<?php

namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\GoodsAttention as GoodsAttention_model;

class GoodsAttention extends NoAuth {

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

		$data = (new Goodsattention_model())->search($this->_uid, $get['page'], $get['page_size'],$get['wd']);
		
		return [
			'error' => 0,
			'result' => $data
		];

	}

	/**
	 * 是否关注商品
	 */
	public function isattention() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}
		
		$goodid = (int)$this->request->get('goodid');
		$type = (int)$this->request->get('type');
		if ($goodid == 0) {
			$this->_error('参数错误', 400);
		}

		$rs = (new Goodsattention_model())->isattention($this->_uid, $goodid, $type);

		$isattention = !empty($rs) && $rs['id'] > 0 ? 1 : 0;
		$id = $isattention ? $rs['id'] : 0;

		return ['error'=>0, 'isattention'=> $isattention, 'id'=>$id];

	}

	/**
	 * 添加商品关注
	 */
	public function add() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		if(true !== ($validate = $this->validate($this->request->post(), 'GoodsAttentionAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();

		$data = [
			'goodsid'=>$post['goodsid'],
			'name'=>$post['name'],
			'picurl'=>$post['picurl'],
			'price'=>$post['price'],
			'type'=>$post['type'],
			'business_id'=>$post['business_id'],
			'uid'=>$this->_uid,
		];

		$isattention_rs = (new Goodsattention_model())->isattention($this->_uid, $post['goodsid'], $post['type']);

		$isattention = !empty($isattention_rs) && $isattention_rs['id'] > 0 ? 1 : 0;
		if ($isattention) {
			$this->_error('商品关注过了', 400);
		}

		$rs = (new Goodsattention_model())->add($data);

		return $rs ? ['error'=>0, 'id'=>$rs] : $this->_error('商品关注失败', 500);

	}

	/**
	 * 批量添加商品关注
	 */
	public function batch_add() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		$post = $this->request->post('data/a');
		if (empty($post)) {
			$this->_error('参数错误', 400);
		}

		$data = [];
		foreach ($post as $key => $value) {
			if(true !== ($validate = $this->validate($value, 'GoodsAttentionAdd'))) {
				$this->_error($validate, 400);
			}

			$isattention_rs = (new Goodsattention_model())->isattention($this->_uid, $value['goodsid'], $value['type']);

			$isattention = !empty($isattention_rs) && $isattention_rs['id'] > 0 ? 1 : 0;
			if ($isattention) {
				continue;
			}

			$data[] = [
				'goodsid'=>$value['goodsid'],
				'business_id'=>$value['business_id'],
				'name'=>$value['name'],
				'picurl'=>$value['picurl'],
				'price'=>$value['price'],
				'type'=>$value['type'],
				'uid'=>$this->_uid,
			];
		}

		if (empty($data)) {
			$this->_error('商品已关注过', 500);
		}
		else {
			$rs = (new Goodsattention_model())->batch_add($data);

			return $rs ? ['error'=>0, 'msg'=>'商品关注成功'] : $this->_error('商品关注失败', 500);
		}		
	}

	/**
	 * 取消关注
	 */
	public function del() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		$gaids = $this->request->get('gaids');
		if (empty($gaids)) {
			$this->_error('参数错误', 400);
		}
		$gaids = explode(',', $gaids);
		foreach ($gaids as $key => $value) {
			if (intval($value) == 0) {
				$this->_error('参数错误', 400);
			}

			$gaids[$key] = intval($value);
		}

		$rs = (new Goodsattention_model())->del($this->_uid, $gaids);

		return $rs ? ['error'=>0, 'msg'=>'取消关注成功'] : $this->_error('取消关注失败', 500);
	}
}