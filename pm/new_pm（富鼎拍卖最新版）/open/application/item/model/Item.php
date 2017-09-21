<?php
namespace app\item\model;

use think\Model;
use think\Db;

class Item extends model {

	public function list_data($cid, $business_cid, $bid, $business_id, $order='default', $page, $page_size) {
		$sphinx = new \SphinxRt(config('sphinx'));

		$order_arr = [
			'pd'=>'item_price desc',
			'pa'=>'item_price asc',
			'cd'=>'item_consume desc',
			'ca'=>'item_consume asc',
			'id'=>'item_id desc',
			'ia'=>'item_id asc',
			'default'=>'item_sort desc',
		];

		$w_arr = $tmp = [];
		$w_arr[] = 'item_onsale = 1';
		$w_arr[] = 'item_inventory > 0';
		$cid > 0 ? $w_arr[] = "cat_id = {$cid}" : '';
		$business_cid > 0 ? $w_arr[] = "item_business_cat_id = {$business_cid}" : '';
		$bid > 0 ? $w_arr[] = "brand_id = {$bid}" : '';
		$business_id > 0 ? $w_arr[] = "business_id = {$business_id}" : '';
		$w_str = join(' and ', $w_arr);
		$start = ($page-1)*$page_size;

		$q = $sphinx->field('item_id,business_id,item_name,item_code,item_total,item_price,goods_price,item_inventory,goods_thumb')->where($w_str)->order($order_arr[$order])->limit("{$start},{$page_size}")->search();

		unset($w_arr, $w_str);

		return $q;
	}

	public function search($wd, $business_id = 0, $page, $page_size) {
		$sphinx = new \SphinxRt(config('sphinx'));

		$wd = addslashes($wd);

		$w_str = "match('$wd')";
		if ($business_id > 0) {
			$w_str .= " and business_id = {$business_id}";
		}

		$start = ($page-1)*$page_size;

		$q = $sphinx->field('item_id,business_id,item_name,item_code,item_total,item_price,goods_price,item_inventory,goods_thumb')->where($w_str)->limit("{$start},{$page_size}")->search();

		unset($w_str);

		return $q;
	}

	public function detail($item_id, $no_desc = 0) {
		if ($item_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('couchbase')))->where("item_id = {$item_id}")->select();
		if (empty($data)) {
			return false;
		}
		$data[0] = get_object_vars($data[0]);

		return $data[0];
	}

	public function details($item_ids) {
		if (empty($item_ids)) {
			return false;
		}

		$item_ids_json = json_encode($item_ids);

		$data = (new \Couchbase(config('couchbase')))->field('item_id,goods_id,business_id,item_name,item_code,item_total,item_price,goods_price,item_inventory,goods_thumb')->where("item_id in {$item_ids_json}")->select();
		if (empty($data)) {
			return false;
		}

		return $data;

	}

	public function get_inventory($item_id) {
		if ($crowd_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('couchbase')))->field('item_inventory')->where("item_id = {$item_id}")->select();
		if (empty($data)) {
			return false;
		}
		$data[0] = get_object_vars($data[0]);

		return $data[0];
	}

	public function inventory($item_id, $num) {
		if ($item_id == 0 || $num == 0) {
			return false;
		}


		$commit = 1;
		Db::startTrans();
		try{
			Db::name('item')->where('id', $item_id)->update(['item_consume'=>['exp', "item_consume+
				{$num}"], 'iteminventory'=>['exp', "item_inventory-{$num}"]]);

			Db::commit();

		} catch (\Exception $e) {
			Db::rollback();
			$commit = 0;
		}

		if ($commit) {
			$cb = new \Couchbase(config('couchbase'));
			$cb->n1ql_query("UPDATE item SET item_consume=item_consume+{$num},item_inventory=item_inventory-{$num} where item_id = {$item_id}");
			$detail = $this->detail($item_id);

			(new \SphinxRt(config('sphinx')))->update(['item_consume'=>$detail['item_consume'],'item_inventory'=>$detail['item_inventory']],$item_id,false);
			unset($detail);
		}

		return $commit ? true : false;


	}

	public function important_data($item_ids) {
		if (empty($item_ids)) {
			return false;
		}

		$item_ids_json = json_encode($item_ids);

		$data = (new \Couchbase(config('couchbase')))->field('item_id,goods_id,business_id,item_onsale,item_price,item_inventory')->where("item_id in {$item_ids_json}")->select();
		if (empty($data)) {
			return false;
		}

		return $data;

	}
}