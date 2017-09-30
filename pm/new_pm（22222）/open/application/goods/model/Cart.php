<?php
namespace app\goods\model;

use think\Db;

class Cart {

	public function list($uid) {
		if ($uid == 0) {
			return false;
		}

		$list = Db::name('cart')->where("uid = $uid")->order('business_id desc')->select();
	}

	public function add($data) {
		if (empty($data)) {
			return false;
		}

		$cart_id = Db::name('cart')->insertGetId($data);

		return $cart_id > 0 ? $cart_id : false;

	}

	public function isincart($uid, $product_id, $spec_key, $type = 0) {
		if ($uid == 0 || $product_id == 0 || empty($spec_key)) {
			return false;
		}

		return Db::name('cart')->field('id')->where("uid = {$uid} and product_id = {$product_id} and spec_key = '{$spec_key}' and type = {$type}")->find();
	}

	public function edit_spec_goods($uid, $cart_id, $data) {
		if ($uid == 0 || $cart_id == 0 || empty($data)) {
			return false;
		}

		return Db::name('cart')->where("uid = $uid  and id = $cart_id")->update($data);
	}

	public function edit_goods_num($uid, $cart_id, $goods_num) {
		if ($uid == 0 || $cart_id == 0 || $goods_num < 0) {
			return false;
		}

		return Db::name('cart')->where("uid = $uid  and id = $cart_id")->update(['goods_num' => $goods_num]);
	}

	public function del($uid, $cart_ids) {
		if ($uid == 0 || empty($cart_ids)) {
			return false;
		}

		return Db::name('cart')->where("uid = $uid  and id in ($cart_ids)")->delete();
	}

}