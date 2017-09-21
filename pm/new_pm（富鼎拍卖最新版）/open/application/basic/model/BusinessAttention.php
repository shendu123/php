<?php
namespace app\basic\model;

use think\Db;

class BusinessAttention {

	public function search($uid, $page, $page_size,$wd='') {
		if ($uid == 0) {
			return false;
		}

		$where_str = '';
		if (!empty($wd)) {
			$where_str = " and name like '%{$wd}%'";
		}

		$start = ($page-1)*$page_size;

		return Db::name('member_business_attention')->field('id,picurl,business_id,name')->where("uid = {$uid} and isdelete = 0 {$where_str}")->limit($start, $page_size)->order('id desc')->select();

	}

	public function isattention($uid, $business_id) {
		if ($uid == 0 || $business_id == 0) {
			return false;
		}

		return Db::name('member_business_attention')->field('id')->where("uid = {$uid} and isdelete = 0 and business_id = {$business_id}")->find();
	}

	public function get_business_id($ids) {
		if (is_array($ids) && !empty($ids)) {
			$ids_str = join(',', $ids);
		}
		else {
			return false;
		}
		return Db::name('member_business_attention')->field('business_id')->where("id in ({$ids_str}) and isdelete = 0")->select();
	}

	public function add($data) {
		if (empty($data)) {
			return false;
		}

		$isattention = $this->isattention($data['uid'], $data['business_id']);
		if (!empty($isattention)) {
			return false;
		}

		$id = Db::name('member_business_attention')->insertGetId($data);

		return $id > 0 ? $id : false;

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

		return Db::name('member_business_attention')->where("uid = {$uid} and id in ({$ids_str}) and isdelete = 0")->update(['isdelete' => '1']);

	}
}
