<?php
namespace app\goods\controller;

use app\common\controller\NoAuth;
use app\goods\model\Cart as Cart_model;

class Cart extends NoAuth {

	public function __construct(){
		parent::__construct();
		$this->_checkLogin();
	}
	
	/**
	 * 查询购物车
	 */
	public function index() {
		$rs = (new Cart_model())->list($this->_uid);

		return $rs ? ['error'=>0, 'result'=>$rs] : $this->_error('system error', 500);
	}

	/**
	 * 添加购物车
	 */
	public function add() {
		$data = $this->_checkAdd();
		$isincart_rs = (new Cart_model())->isincart($this->_uid, $data['product_id'], $data['spec_key'], $data['type']);

		$isincart = !empty($isincart_rs) && $isincart_rs['id'] > 0 ? 1 : 0;
		if ($isincart) {
			$this->_error('该商品已在购物车内', 400);
		}

		$rs = (new Cart_model())->add($data);

		
		return $rs ? ['error'=>0, 'cart_id'=>$rs] : $this->_error('商品添加失败', 500);
		
	}

	/**
	 * 编辑购物车商品属性
	 */
	public function edit_spec_goods() {
		$cart_id = (int)$this->request->post('cart_id');
		$spec_key = $this->request->post('spec_key');
		$spec_key_name = $this->request->post('spec_key_name');
		if ($cart_id == 0 || empty($spec_key) || empty($spec_key_name)) {
			$this->_error('参数错误',  400);
		}

		$data = [
			'spec_key' => $spec_key,
			'spec_key_name' => $spec_key_name
		];

		$rs = (new Cart_model())->edit_spec_goods($this->_uid, $cart_id, $data);

		
		return $rs ? ['error'=>0, 'msg'=>''] : $this->_error('购物车商品规格更新失败', 500);
		
	}

	/**
	 * 编辑购物车商品数量
	 */
	public function edit_goods_num() {
		$cart_id = (int)$this->request->post('cart_id');
		$goods_num = (int)$this->request->post('goods_num');
		if ($cart_id == 0 || $goods_num < 0) {
			$this->_error('参数错误', 400);
		}


		$rs = (new Cart_model())->edit_goods_num($this->_uid, $cart_id, $goods_num);

		
		return $rs ? ['error'=>0, 'msg'=>''] : $this->_error('购物车商品数量更新失败', 500);
		
	}

	/**
	 * 删除购物车商品
	 */
	public function del() {
		$cart_ids = $this->request->get('cart_ids');
		if (empty($cart_ids)) {
			$this->_error('参数错误', 400);
		}

		$rs = (new Cart_model())->del($this->_uid, $cart_ids);

		
		return $rs ? ['error'=>0, 'msg'=>''] : $this->_error('商品添加失败', 500);
		
	}

	/**
	 * 添加购物车参数验证
	 */
	private function _checkAdd() {
		if(true !== ($validate = $this->validate($this->request->post(), 'CartAdd'))) {
			$this->_error($validate, 400);
		}

		$post = $this->request->post();

		$data['uid'] = $this->_uid;
		$data['business_id'] = $post['business_id'];
		$data['product_id'] = $post['product_id'];
		$data['goods_id'] = $post['goods_id'];
		$data['goods_name'] = $post['goods_name'];
		$data['product_name'] = $post['product_name'];
		$data['market_price'] = $post['market_price'];
		$data['goods_price'] = $post['goods_price'];
		$data['member_goods_price'] = $post['member_goods_price'];
		$data['goods_sn'] = $post['goods_sn'];
		$data['goods_num'] = $post['goods_num'];
		$data['spec_key'] = isset($post['spec_key']) ? $post['spec_key'] : '';
		$data['spec_key_name'] = isset($post['spec_key_name']) ? $post['spec_key_name'] : '';
		$data['type'] = $post['type'];
		$data['goods_thumb'] = $post['goods_thumb'];
		$data['add_time'] = time();

		unset($post);

		return $data;
	}

}