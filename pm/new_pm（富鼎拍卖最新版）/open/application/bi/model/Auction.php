<?php
namespace app\bi\model;

class Auction extends Base {
	/**
	 * 拍卖计数器读取
	 */
	public function show($auction_id)
	{
		if ($auction_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('biCouchbases', null, 'bi')))->bucket('bi_auction_counter')->where("auction_id = {$auction_id}")->select();

		if (empty($data)) {
			$data[0] = [];
		}
		else {
			$data[0] = get_object_vars($data[0]);
		}

		return $data[0];
	}

	/**
	 * 添加拍卖计数器
	 * @param int $auction_id 拍卖id 
	 * @return boolean 返回类型
	 */
	public function insert($auction_id) {
		if (intval($auction_id) == 0) {
			return false;
		}

		$counter = $this->show($auction_id);
		if (!empty($counter)) {
			return true;
		}

		$data = json_encode([
			'auction_id'=>(int)$auction_id,
			'onlookers'=>0,
			'sign_up'=>0,
			'remind'=>0,
			'update'=>0
		]);

		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));

		$rs = $cb->n1ql_query("INSERT INTO `bi_auction_counter` ( KEY, VALUE ) VALUES ('auction_counter_{$auction_id}', {$data})");

		return $rs->status == 'success' ? true : false;

	}

	/**
	 * 修改拍卖围观
	 * @param int $auction_id 拍卖id 
	 * @return boolean 返回类型
	 */
	public function change_onlookers($auction_id)
	{
		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));
		
		$rs = $cb->n1ql_query("UPDATE bi_auction_counter SET onlookers = onlookers + 1, `update` = 1 where auction_id = {$auction_id}");

		return $rs->status == 'success' ? true : false;
	}

	/**
	 * 修改拍卖报名
	 * @param int $auction_id 拍卖id 
	 * @return boolean 返回类型
	 */
	public function change_sing_up($auction_id)
	{
		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));
		
		$rs = $cb->n1ql_query("UPDATE bi_auction_counter SET sing_up = sing_up + 1, `update` = 1 where auction_id = {$auction_id}");

		return $rs->status == 'success' ? true : false;
	}

	/**
	 * 修改拍卖提醒
	 * @param int $auction_id 拍卖id 
	 * @return boolean 返回类型
	 */
	public function change_remind($auction_id)
	{
		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));
		
		$rs = $cb->n1ql_query("UPDATE bi_auction_counter SET remind = remind + 1, `update` = 1 where auction_id = {$auction_id}");

		return $rs->status == 'success' ? true : false;
	}	
}