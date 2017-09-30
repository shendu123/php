<?php
namespace app\crowd\model;

use think\Model;
use think\Db;

class Crowd extends model {

	public function list_data($cid, $bid, $business_id, $order, $page, $page_size, $period = 0) {
		$sphinx = new \SphinxRt(config('sphinx'));

		$order_arr = [
			'pd'=>'crowd_price desc',
			'pa'=>'crowd_price asc',
			'cd'=>'crowd_consume desc',
			'ca'=>'crowd_consume asc',
			'default'=>'crowd_sort desc',
		];

		$w_arr = $tmp = [];
		$w_arr = $this->period($period);
		$w_arr[] = 'crowd_onsale = 1';
		$w_arr[] = 'crowd_inventory > 0';
		$cid > 0 ? $w_arr[] = "cat_id = {$cid}" : '';
		$bid > 0 ? $w_arr[] = "brand_id = {$bid}" : '';
		$business_id > 0 ? $w_arr[] = "business_id = {$business_id}" : '';
		$w_str = join(' and ', $w_arr);
		$start = ($page-1)*$page_size;

		$q = $sphinx->field('crowd_id,crowd_name,crowd_code,crowd_total,crowd_price,goods_price,crowd_premium,crowd_inventory,crowd_starttime,crowd_endtime,goods_thumb')->where($w_str)->order($order_arr[$order])->limit("{$start},{$page_size}")->search();

		if ($q && !empty($q['result'])) {
			foreach ($q['result'] as $k => $v) {
				$q['result'][$k]['crowd_starttime'] = date("Y-m-d H:i:s", $q['result'][$k]['crowd_starttime']);
				$q['result'][$k]['crowd_endtime'] = date("Y-m-d H:i:s", $q['result'][$k]['crowd_endtime']);
			}
		}

		unset($w_arr, $w_str);

		return $q;
	}

	public function search($wd, $page, $page_size) {
		$sphinx = new \SphinxRt(config('sphinx'));

		$wd = addslashes($wd);
		$w_str = "match('$wd') and crowd_onsale = 1";
		$start = ($page-1)*$page_size;

		$q = $sphinx->field('crowd_id,crowd_name,crowd_code,crowd_total,crowd_price,goods_price,crowd_premium,crowd_inventory,crowd_endtime,goods_thumb')->where($w_str)->limit("{$start},{$page_size}")->search();

		if ($q && !empty($q['result'])) {
			foreach ($q['result'] as $k => $v) {
				$q['result'][$k]['crowd_endtime'] = date("Y-m-d H:i:s", $q['result'][$k]['crowd_endtime']);
			}
		}

		unset($w_str);

		return $q;
	}

	public function detail($crowd_id) {
		if ($crowd_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('couchbase')))->where("crowd_id = {$crowd_id}")->select();
		if (empty($data)) {
			return false;
		}
		$data[0] = get_object_vars($data[0]);
		$data[0]['crowd_endtime'] = date("Y-m-d H:i:s", $data[0]['crowd_endtime']);


		return $data[0];
	}

	public function get_inventory($crowd_id) {
		if ($crowd_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('couchbase')))->field('crowd_inventory')->where("crowd_id = {$crowd_id}")->select();
		if (empty($data)) {
			return false;
		}
		$data[0] = get_object_vars($data[0]);

		return $data[0];
	}

	public function inventory($crowd_id, $num) {
		if ($crowd_id == 0 || $num == 0) {
			return false;
		}


		$commit = 1;
		Db::startTrans();
		try{
			Db::name('crowd')->where('id', $crowd_id)->update(['crowd_consume'=>['exp', "crowd_consume+
				{$num}"], 'crowd_inventory'=>['exp', "crowd_inventory-{$num}"]]);

			Db::commit();

		} catch (\Exception $e) {
			Db::rollback();
			$commit = 0;
		}

		if ($commit) {
			$cb = new \Couchbase(config('couchbase'));
			$cb->n1ql_query("UPDATE crowd SET crowd_consume=crowd_consume+{$num},crowd_inventory=crowd_inventory-{$num} where crowd_id = {$crowd_id}");
			$detail = $this->detail($crowd_id);

			(new \SphinxRt(config('sphinx')))->update(['crowd_consume'=>$detail['crowd_consume'],'crowd_inventory'=>$detail['crowd_inventory']],$crowd_id,false);
			unset($detail);
		}

		return $commit ? true : false;


	}

	private function period($t_type) {
		$rs = [];
		$now = time();
		if ($t_type == 1) {
			$rs = ["crowd_starttime > {$now}"];
		}
		elseif ($t_type == 2) {
			$rs = ["crowd_endtime < {$now}"];
		}
		else {
			$rs = ["crowd_starttime < {$now}", "crowd_endtime > {$now}"];
		}

		return $rs;
	}

}