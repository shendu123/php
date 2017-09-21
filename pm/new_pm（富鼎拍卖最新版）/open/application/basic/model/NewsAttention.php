<?php
namespace app\basic\model;

use think\Db;

class NewsAttention {

	public function search($uid, $page, $page_size,$wd='') {
		if ($uid == 0) {
			return false;
		}

		$where_str = '';
		if (!empty($wd)) {
			$where_str = " and title like '%{$wd}%'";
		}

		$start = ($page-1)*$page_size;

		return Db::name('member_news_attention')->field('id,picurl,newsid,title,author')->where("uid = {$uid} and isdelete = 0 {$where_str}")->limit($start, $page_size)->order('id desc')->select();

	}

	public function isattention($uid, $newsid) {
		if ($uid == 0 || $newsid == 0) {
			return false;
		}

		return Db::name('member_news_attention')->field('id')->where("uid = {$uid} and isdelete = 0 and newsid = {$newsid}")->find();
	}

	public function add($data) {
		if (empty($data)) {
			return false;
		}

		$id = Db::name('member_news_attention')->insertGetId($data);

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

		return Db::name('member_news_attention')->where("uid = {$uid} and id in ({$ids_str}) and isdelete = 0")->update(['isdelete' => '1']);

	}
}
