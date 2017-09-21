<?php
namespace app\crowd\controller;

use app\common\controller\NoAuth;

class Test extends NoAuth {

	public function index() {

	}

	public function add() {
		$rt = [
			'title' => '接哦我IE他给你女性菜篮子',
			'code' => 'kdsljf-002',
			'keywords' => '给你女性',
			'content' => '菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子',
			'crowd_name' => '接哦我IE他给你女性菜篮子',
			'cat_id' => 10,
			'crowd_code' => 'kdsljf-002',
			'crowd_onsale' => 1,
			'crowd_id' => 1,
			'crowd_price' => 1000,
			'crowd_total' => 100,
			'crowd_sort' => 0,
			'goods_price' => 1200,
			'crowd_starttime' => strtotime('2017-05-31 00:00:00'),
			'crowd_endtime' => strtotime('2017-06-30 00:00:00'),
		];

		$srt = new \SphinxRt(config('sphinx'));
		$srt_insert = $srt->insert($rt, $rt['crowd_id']);
		print_r($srt_insert);exit;

		$cb_data = [
			'crowd_id' => $rt['crowd_id'],
			'goods_id' => 28,
			'goods_thumb' => '/upload/a.jpg',
			'goods_desc' => $rt['content'],
			'goods_pictures' => ['/a/b.jpg', '/c/b.jpg'],
			'business_id' => 13,
			'member_id' => 13,
			'crowd_name' => $rt['title'],
			'crowd_total' => $rt['crowd_total'],
			'crowd_consume' => 0,
			'crowd_onsale' => $rt['crowd_onsale'],
			'crowd_price' => $rt['crowd_price'],
			'crowd_broker_price' => 100,
			'crowd_seller_price' => 100,
			'crowd_starttime' => $rt['crowd_starttime'],
			'crowd_endtime' => $rt['crowd_endtime'],
			'crowd_freight_price' => 10,
			'goods_price' => $rt['goods_price'],
		];

		$cb = (new \Couchbase(config('couchbase.default')))->bucket->upsert('crowd_'.$rt['crowd_id'], $cb_data);
	}

	public function delete() {
		$crowd_id = 18;
		$srt = new \SphinxRt(config('sphinx'));
		$srt_del = $srt->delete($crowd_id);

		$cb = (new \Couchbase(config('couchbase.default')))->bucket->remove('crowd_'.$crowd_id);

	}
}