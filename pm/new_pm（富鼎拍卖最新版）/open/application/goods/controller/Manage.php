<?php
namespace app\goods\controller;

use app\common\controller\NoAuth;
use app\goods\model\Manage as Good_Manage;
class Manage extends NoAuth {

	/**
	 * 添加商品
	 */
	public function add() {
		$data = $this->_checkAdd();

		$rs = (new Good_Manage())->add($data);

		unset($data);
		
		return $rs ? ['error'=>0, 'goods_id'=>$rs] : $this->_error('商品添加失败', 500);
	}

	/**
	 * 商品详情
	 */
	public function detail() {
		$gid = (int)$this->request->get('gid');
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		$data = (new Good_Manage())->detail($gid, $this->_uid);

		return $data ? ['error'=>0, 'result'=>$data] : $this->_error('商品详情获取失败', 500);
	}

	/**
	 * 商品添加参数验证
	 */
	private function _checkAdd() {
		if ($this->_uid == 0) {
			$this->_error('Forbidden', '403');
		}

		if(true !== ($validate = $this->validate($this->request->post(), 'GoodsAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();

		$data['goods']['cat_id'] = $post['cat_id'];
		$data['goods']['member_id'] = $this->_uid;
		$data['goods']['goods_oprid'] = $this->_uid;
		$data['goods']['goods_price'] = $post['goods_price'];
		$data['goods']['goods_thumb'] = $post['goods_thumb'];
		$data['goods']['goods_name'] = $data['goods']['goods_title'] = $post['goods_name'];
		$data['goods']['goods_intime'] = time();

		$data['goods_detail']['goods_keywords'] = $post['goods_keywords'];
		$data['goods_detail']['goods_pictures'] = $post['goods_pictures'];
		$data['goods_detail']['goods_content'] = $post['goods_content'];

		unset($post);

		return $data;
	}

}