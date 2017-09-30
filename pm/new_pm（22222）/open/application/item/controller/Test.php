<?php
namespace app\item\controller;

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
			'item_name' => '接哦我IE他给你女性菜篮子',
			'cat_id' => 10,
			'brand_id' => 10,
			'business_id' => 1,
			'item_business_cat_id' => 101,
			'item_code' => 'kdsljf-002',
			'item_onsale' => 1,
			'item_id' => 1,
			'item_price' => 1000,
			'item_total' => 100,
			'item_sort' => 0,
			'item_inventory' => 100,
			'item_consume' => 8,
			'goods_thumb' => 'http://www.wode-mall.com/a.jpg',
			'goods_price' => 1200,
		];

		$srt = new \SphinxRt(config('sphinx'));
		$srt_insert = $srt->insert($rt, $rt['item_id']);
		// print_r($srt_insert);exit;

		$cb_data = [
			'item_id' => $rt['item_id'],
			'goods_id' => 28,
			'brand_id' => $rt['brand_id'],
			'goods_thumb' => '/upload/a.jpg',
			'goods_desc' => '简介',
			'goods_content' => $rt['content'],
			'goods_pictures' => ['/a/b.jpg', '/c/b.jpg'],
			'business_id' => 13,
			'item_name' => $rt['title'],
			'item_code' => $rt['item_code'],
			'item_total' => $rt['item_total'],
			'item_consume' => $rt['item_consume'],
			'item_inventory' => $rt['item_inventory'],
			'item_onsale' => $rt['item_onsale'],
			'item_price' => $rt['item_price'],
			'item_freight_price' => 10,
			'goods_price' => $rt['goods_price'],
		];
		$cb = (new \Couchbase(config('couchbase.item')))->bucket->insert('item_'.$rt['item_id'], $cb_data);
	}

	public function delete() {
		$item_id = 18;
		$srt = new \SphinxRt(config('sphinx'));
		$srt_del = $srt->delete($item_id);

		$cb = (new \Couchbase(config('couchbase.item')))->bucket->remove('item_'.$item_id);

	}
}