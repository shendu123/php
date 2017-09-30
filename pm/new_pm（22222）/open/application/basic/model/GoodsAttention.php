<?php
namespace app\basic\model;

use think\Db;

class GoodsAttention {

	public function counter($uid) {
		if ($uid == 0) {
			return false;
		}

		return Db::name('member_goods_attention')->where("uid = {$uid} and isdelete = 0")->count('id');
	}

	public function search($uid, $page, $page_size,$wd='') {
		if ($uid == 0) {
			return false;
		}

		$where_str = '';
		if (!empty($wd)) {
			$where_str = " and name like '%{$wd}%'";
		}

		$start = ($page-1)*$page_size;

		return Db::name('member_goods_attention')->field('id,picurl,goodsid,price,name,type,business_id')->where("uid = {$uid} and isdelete = 0 {$where_str}")->limit($start, $page_size)->order('id desc')->select();

	}

	public function isattention($uid, $goodid, $type) {
		if ($uid == 0 || $goodid == 0) {
			return false;
		}

		return Db::name('member_goods_attention')->field('id')->where("uid = {$uid} and type = {$type} and isdelete = 0 and goodsid = {$goodid}")->find();
	}

	public function add($data) {
		if (empty($data)) {
			return false;
		}

		$id = Db::name('member_goods_attention')->insertGetId($data);

		return $id > 0 ? $id : false;

	}

	public function batch_add($data) {
		if (empty($data)) {
			return false;
		}

		$num = Db::name('member_goods_attention')->insertAll($data);

		return $num > 0 ? true : false;

	}

	public function del($uid, $ids) {
		if ($uid == 0) {
			return false;
		}
		$ids_str = '';

		if (is_array($ids) && !empty($ids)) {
			$ids_str = join(',', $ids);
		}
		else if ($ids > 0) {
			$ids_str = $ids;
		}
		else {
			return false;
		}

		return Db::name('member_goods_attention')->where("uid = {$uid} and id in ({$ids_str}) and isdelete = 0")->update(['isdelete' => '1']);

	}
}
