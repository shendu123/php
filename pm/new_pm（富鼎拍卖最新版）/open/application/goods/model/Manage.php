<?php
namespace app\goods\model;

use think\Db;

class Manage {

	public function add($data) {
		if (empty($data) || empty($data['goods']) || empty($data['goods_detail'])) {
			return false;
		}

		Db::startTrans();
		try{

			$goods_id = Db::name('goods')->insertGetId($data['goods']);
			$data['goods_detail']['goods_id'] = $goods_id;
			Db::name('goods_detail')->insert($data['goods_detail']);

			Db::commit();

		} catch (\Exception $e) {

			Db::rollback();

		}

		return $goods_id > 0 ? $goods_id : false;

	}

	public function detail($gid, $uid) {
		if ($gid == 0 || $uid == 0) {
			return false;
		}

		$goods = Db::name('goods')->field('id,cat_id,goods_name,goods_title,goods_price,goods_thumb')->where(['id'=>$gid, 'member_id'=>$uid])->select();
		if (empty($goods)) {
			return false;
		}

		$goods_detail = Db::name('goods_detail')->field('goods_keywords,goods_pictures,goods_content')->where('goods_id', $goods[0]['id'])->select();
		if (empty($goods_detail)) {
			return false;
		}

		return $goods[0]+$goods_detail[0];
	}
	
}
