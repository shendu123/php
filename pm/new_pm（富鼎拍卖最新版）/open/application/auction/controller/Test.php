<?php
namespace app\auction\controller;

use app\common\controller\NoAuth;
use app\auction\model\Auction;

class Test extends NoAuth {

	public function __construct() {
		header("Content-Type: text/html; charset=UTF-8");
		ini_set('date.timezone','Asia/Shanghai');

		parent::__construct();

	}

	public function index() {

		$bucketName = "auction";

		// Connect to Couchbase Server
		$cluster = new \CouchbaseCluster("couchbase://192.168.71.237,192.168.71.236");
		$bucket = $cluster->openBucket($bucketName);

		// Query with parameters
		$query = \CouchbaseN1qlQuery::fromString("SELECT * FROM `crowd` WHERE crowd_id = 54");
		echo "Parameterized query:\n";
		var_dump($query);
		$rows = $bucket->query($query);
		echo "Results:\n";
		var_dump($rows);
		exit;

		/*
		$sphinx = new \SphinxRt(config('sphinx'));
		echo $sphinx->countAll();
		*/
		$cb = new \Couchbase(config('couchbase'));
		//$test = $cb->bucket->get('test');
		$test = $cb->field('email,interests')->where("'African Swallows' IN interests")->select();
		echo json_encode($test);exit;
		print_r($test);
		echo "hello world!";
	}

	public function bid_algorithm() {
		echo (new auction())->bid_algorithm($this->request->get('money'));
	}

	public function add() {
		$rt = [
			'title' => '接哦我IE他给你女性菜篮子',
			'code' => 'kdsljf-001',
			'keywords' => '给你女性',
			'content' => '菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子菜篮子',
			'auction_name' => '接哦我IE他给你女性菜篮子',
			'cat_id' => 10,
			'member_id' => 21,
			'goods_thumb' => '/upload/a.jpg',
			'auction_id' => 2,
			'auction_type' => 1,
			'auction_mode' => 11,
			'auction_flow_status' => 0,
			'auction_is_bid' => 0,
			'auction_onset_price' => '1000.00',
			'auction_starttime' => strtotime('2017-05-31 00:00:00'),
			'auction_endtime' => strtotime('2017-06-30 00:00:00'),
		];
		$srt = new \SphinxRt(config('sphinx'));
		$srt_insert = $srt->insert($rt, $rt['auction_id']);

		$cb_data = [
			'auction_id' => $rt['auction_id'],
			'goods_id' => 28,
			'goods_thumb' => '/upload/a.jpg',
			'goods_desc' => $rt['content'],
			'goods_pictures' => ['/a/b.jpg', '/c/b.jpg'],
			'business_id' => 13,
			'member_id' => 13,
			'cat_id' => $rt['cat_id'],
			'auction_name' => $rt['title'],
			'auction_type' => $rt['auction_type'],
			'auction_mode' => $rt['auction_mode'],
			'auction_bidcount' => 0,
			'auction_succtype' => 0,
			'auction_flow_status' => $rt['auction_flow_status'],
			'auction_adjust_status' => 0,
			'auction_succ_price' => 0,
			'auction_freight' => 0,
			'auction_onset_price' => $rt['auction_onset_price'],
			'auction_now_price' => 1200.00,
			'auction_stepsize_price' => 200.00,
			'auction_starttime' => $rt['auction_starttime'],
			'auction_endtime' => $rt['auction_endtime'],
			'auction_stepsize_type' => 0,
			'auction_pledge_type' => 'fixation',
			'auction_buier_price' => 123,
		];

		$cb = (new \Couchbase(config('couchbase.default')))->bucket->upsert('auction_'.$rt['auction_id'], $cb_data);
	}

	public function delete() {
		$auction_id = 35;
		$srt = new \SphinxRt(config('sphinx'));
		$srt_del = $srt->delete($auction_id);

		$cb = (new \Couchbase(config('couchbase.default')))->bucket->remove('auction_'.$auction_id);

	}
	public function record() {
		$data = [];
		for ($i = 0; $i < 35; $i++) {
			$data = [
				'uname'=>'test_'.$i,
				'money'=>1,
				'bided'=>$i+1,
				'aid'=>2,
				'uid'=>4,
				'time'=>0,
			];
			echo $i."<br />";
			$cb = (new \Couchbase(config('couchbase.auction_record')))->bucket->upsert('record_'.$i, $data);

		}


	}


}