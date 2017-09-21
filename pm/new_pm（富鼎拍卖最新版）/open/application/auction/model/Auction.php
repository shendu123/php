<?php
namespace app\auction\model;

use think\Model;
use think\Db;

class Auction extends model {

	public function list_data($mode, $cid, $bid, $business_id, $order='ea', $page, $page_size, $period = 0) {
		$sphinx = new \SphinxRt(config('sphinx'));

		$order_arr = [
			'pd'=>'auction_now_price desc',
			'pa'=>'auction_now_price asc',
			'bd'=>'auction_bidcount desc',
			'ba'=>'auction_bidcount asc',
			'ed'=>'auction_endtime desc',
			'ea'=>'auction_endtime asc'
		];

		$w_arr = [];
		$w_arr[] = 'auction_onsale = 1';
		$w_arr = $this->period($period);

		$mode >= 0 ? $w_arr[] = "auction_mode = {$mode}" : '';
		$cid > 0 ? $w_arr[] = "cat_id = {$cid}" : '';
		$bid > 0 ? $w_arr[] = "brand_id = {$bid}" : '';
		$business_id > 0 ? $w_arr[] = "business_id = {$business_id}" : '';
		$w_str = join(' and ', $w_arr);
		$start = ($page-1)*$page_size;

		$q = $sphinx->field('auction_id,auction_name,goods_thumb,auction_endtime,auction_onset_price,auction_now_price,auction_bidcount,auction_pledge_type,auction_buier_price')->where($w_str)->order($order_arr[$order])->limit("{$start},{$page_size}")->search();
		if ($q && !empty($q['result'])) {
			foreach ($q['result'] as $k => $v) {
				$q['result'][$k]['auction_endtime'] = date("Y-m-d H:i:s", $q['result'][$k]['auction_endtime']);
				$q['result'][$k]['auction_onset_price'] = number_format($q['result'][$k]['auction_onset_price'],2,".","");
				$q['result'][$k]['auction_now_price'] = number_format($q['result'][$k]['auction_now_price'],2,".","");
				$q['result'][$k]['auction_buier_price'] = number_format($q['result'][$k]['auction_buier_price'],2,".","");
			}
		}

		unset($w_arr, $w_str);

		return $q;
	}

	public function search($wd, $page, $page_size) {
		$sphinx = new \SphinxRt(config('sphinx'));
		
		$wd = addslashes($wd);
		$w_str = "match('$wd') and auction_onsale = 1";
		$start = ($page-1)*$page_size;

		$q = $sphinx->field('auction_id,auction_name,goods_thumb,auction_endtime,auction_onset_price,auction_now_price,auction_bidcount,auction_pledge_type,auction_buier_price')->where($w_str)->limit("{$start},{$page_size}")->search();
		if ($q && !empty($q['result'])) {
			foreach ($q['result'] as $k => $v) {
				$q['result'][$k]['auction_endtime'] = date("Y-m-d H:i:s", $q['result'][$k]['auction_endtime']);
				$q['result'][$k]['auction_onset_price'] = number_format($q['result'][$k]['auction_onset_price'],2,".","");
				$q['result'][$k]['auction_now_price'] = number_format($q['result'][$k]['auction_now_price'],2,".","");
				$q['result'][$k]['auction_buier_price'] = number_format($q['result'][$k]['auction_buier_price'],2,".","");
			}
		}


		unset($w_str);

		return $q;
	}

	public function detail($aid, $no_desc = 0) {
		if ($aid == 0) {
			return false;
		}

		$data = (new \Couchbase(config('couchbase')))->where("auction_id = {$aid}")->select();
		if (empty($data)) {
			return false;
		}
		$data[0] = get_object_vars($data[0]);

		$data[0]['auction_flow_status'] == 10 && $data[0]['auction_starttime'] < time() ? 9 : 10;

		$data[0]['auction_starttime_int'] = $data[0]['auction_starttime'];
		$data[0]['auction_starttime'] = date("Y-m-d H:i:s", $data[0]['auction_starttime']);
		$data[0]['auction_endtime'] = date("Y-m-d H:i:s", $data[0]['auction_endtime']);
		if ($no_desc) {
			unset($data[0]['goods_desc']);
		}
		return $data[0];
	}

	public function bid($aid, $multiple, $uid,  $username, $avatar, $detail) {
		if ($aid == 0 || $uid == 0 || empty($username)) {
			return false;
		}

		$now_price = $detail['auction_now_price'] > 0 ? $detail['auction_now_price'] : $detail['auction_onset_price'];
		$money = $this->bid_algorithm($detail['auction_stepsize_price'], $multiple);
		$bid_record = $this->bid_record($aid, 0, $uid, 1);
		if (!empty($bid_record) && $bid_record[0]->bided > $now_price) {
			$now_price = $bid_record[0]->bided;
		}
		$bided = $now_price + $money;

		$auction_data = [];
		$auction_cb = '';
		$auction_flow_status = 10;
		if (!$detail['auction_type'] && $detail['auction_succtype'] && $bided >= $detail['auction_succ_price']) {
			$auction_flow_status = 11;
			$auction_data['auction_flow_status'] = 11;
			$auction_cb = ',auction_flow_status=11';
		}
		$auction_data['auction_bidcount'] = ['exp', 'auction_bidcount+1'];
		$auction_data['auction_now_price'] = $bided;

		$cb = new \Couchbase(config('couchbase'));
		$record_data = json_encode([
			'aid'=>$aid,
			'uid'=>$uid,
			'username'=>$username,
			'avatar'=>$avatar,
			'time'=>time(),
			'money'=>$money,
			'bided'=> $bided
		]);

		$my_bid = $this->bid_record($aid, 1, $uid);

		$rs = 0;
		$record_rs = $cb->n1ql_query("INSERT INTO `auction_record` ( KEY, VALUE ) VALUES ('record_{$aid}_{$bided}', {$record_data} )");
		if ($record_rs->status == 'success') {
			$rs = 1;
			Db::name('auction')->where('id', $aid)->update($auction_data);
			$update_auction_rs = $cb->n1ql_query('UPDATE `auction` SET auction_bidcount=auction_bidcount+1,bid_last_uid='.$uid.',auction_now_price='.$bided.$auction_cb.' where auction_id = '.$aid);
			if (ENVIRONMENT == 1) {
				error_log('UPDATE `auction` SET auction_bidcount=auction_bidcount+1,bid_last_uid='.$uid.',auction_now_price='.$bided.$auction_cb.' where auction_id = '.$aid."\r\n".print_r($update_auction_rs,true), 3, '/tmp/auction_bid.log');
			}

			if (empty($my_bid)) {
				$auction_my_record_data = json_encode([
					'aid'=>$aid,
					'uid'=>$uid,
					'auction_flow_status'=>$auction_flow_status,
					'order_no'=>'',
					'ispay'=>0
				]);
				$auction_my_record_rs = $cb->n1ql_query("INSERT INTO `auction_my_record` ( KEY, VALUE ) VALUES ('my_record_{$aid}_{$uid}', {$auction_my_record_data} )");
			}

			if ($auction_flow_status == 11) {
				$cb->n1ql_query("UPDATE `auction_my_record` SET auction_flow_status={$auction_flow_status} where aid = {$aid}");
			}

			(new \SphinxRt(config('sphinx')))->update(['auction_now_price'=>$bided,'auction_flow_status'=>$auction_flow_status,'auction_bidcount'=>$detail['auction_bidcount']+1],$aid,false);
		}

		if ($auction_flow_status == 11) {
			$order = $this->order($aid);
			if ($order->type == 'success') {
				$cb->n1ql_query("UPDATE `auction_my_record` SET order_no={$order->data} where aid = {$aid} and uid = {$uid}");
				return ['status'=>2, 'order_no'=>$order->data];
			}
			else {
				return ['status'=>0];
			}
		}
		else {
			return $rs ? ['status'=>1] : ['status'=>0];
		}

	}

	public function bid_record($aid, $my_record = 0, $uid = 0, $limit = 10) {
		if ($aid == 0 || ($my_record ==1 && $uid == 0)) {
			return false;
		}
		$w_arr = ["aid = {$aid}"];
		if ($my_record) {
			$w_arr[] = "uid = {$uid}";
		}
		$w_str = join(" and ", $w_arr);

		$data = (new \Couchbase(config('couchbase')))->bucket('auction_record')->where($w_str)->order('bided desc')->limit($limit)->select();

		return $data;
	}

	public function my_bid_record($status, $uid, $page, $page_size) {
		if ($status == 11) {
			$w_str = "auction_flow_status >= {$status} and uid = {$uid}";
		}
		else {
			$w_str = "auction_flow_status = {$status} and uid = {$uid}";
		}

		$start = ($page-1)*$page_size;

		$cb = new \Couchbase(config('couchbase'));
		$total = $cb->bucket('auction_my_record')->where($w_str)->field('count(*) as total')->select();

		$aid_rs = $cb->bucket('auction_my_record')->where($w_str)->field('aid,ispay,order_no')->order('aid desc')->limit($page_size)->offset($start)->select();

		$rs = [];
		foreach ($aid_rs as $key => $val) {
			$detail = $this->detail($val->aid, 1);
			if (empty($detail)) {
				continue;
			}
			$rs[$key] = $detail;
			$rs[$key]['ispay'] = $val->ispay;
			$rs[$key]['order_no'] = $val->order_no;
			unset($detail);
		} 

		return ['result'=> $rs, 'total'=> $total[0]->total];

	}

	public function is_bid($auction_id, $uid) {
		if ($auction_id == 0 || $uid == 0) {
			return false;
		}

		$cb = new \Couchbase(config('couchbase'));
		$data = $cb->bucket('auction_my_record')->where("aid = {$auction_id} and uid = {$uid}")->field('order_no')->select();

		return !empty($data) ? $data[0]->order_no : '';

	}

	public function bid_algorithm($step, $multiple) {
		return bcmul($step, $multiple, 2);

	}

	public function bid_algorithm_old($money) {
		$a = $money/20;
		if ($a < 1) {
			return 1;
		}
		else {
			$a = ceil($a);
			$b = strlen($a);
			return $b > 5 ? round($a, -4) : round($a, -($b-1));
		}

	}

	private function period($t_type) {
		$rs = [];
		$now = time();
		if ($t_type == 1) {
			$rs = ["auction_flow_status = 10", "auction_starttime > {$now}"];
		}
		elseif ($t_type == 2) {
			$rs = ["auction_flow_status in (11,12)", "auction_endtime < {$now}"];

		}
		else {
			$rs = ["auction_flow_status = 10", "auction_starttime < {$now}", "auction_endtime > {$now}"];
		}

		return $rs;
	}

	private function order($aid) {
		$data = $this->detail($aid);

		$post = [];
		$post['item'][] = [
			'from' => 'PM',
			'freight' => $data['auction_freight_price'],
			'price' => $data['auction_now_price'],
			'broker' => $data['auction_broker_price'],
			'title' => $data['auction_name'],
			'pay_switch_id' => $data['auction_id'],
			'sellerid' => $data['business_id'],
			'amount' => 1,
			'picurl' => $data['goods_thumb'],
		];
		$post['total_price'] = $data['auction_now_price'];
		$post['total_freight'] = $data['auction_freight_price'];
		$post['businessid'] = $data['business_id'];
		$post['title'] = $data['auction_name'];
		$post['total_broker'] = $data['auction_broker_price'];

		$pay_order_rs = curl_get_content(config("pay_api_url")."Order/create", 1, $post, request()->header('accesstoken'));
		if (empty($pay_order_rs) || $pay_order_rs->type != 'success') {
			return $pay_order_rs;
		}
		else {
			return false;
		}

	}

}