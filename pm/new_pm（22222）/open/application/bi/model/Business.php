<?php
namespace app\bi\model;

class Business extends Base {
	/**
	 * 商户计数器读取
	 */
	public function show($business_id)
	{
		if ($business_id == 0) {
			return false;
		}

		$data = (new \Couchbase(config('biCouchbases', null, 'bi')))->bucket('bi_business_counter')->where("business_id = {$business_id}")->select();

		if (empty($data)) {
			$data[0] = [];
		}
		else {
			$data[0] = get_object_vars($data[0]);
		}

		return $data[0];
	}

	/**
	 * 文章商户推荐关注读取
	 */
	public function attention_recommend()
	{
		return (new \Couchbase(config('biCouchbases', null, 'bi')))->bucket('bi_business_counter')->order("article_recommend desc")->limit(10)->select();

	}


	/**
	 * 修改商户销售数据
	 * @param int $business_id 商户id 
	 * @param float $sale_price 成交金额 
	 * @param int $type 类型0为增加，1为减少 
	 * @param int $sale_num 成交笔数
	 * @return boolean 返回类型
	 */
	public function change_sale($business_id, $sale_price, $type = 0, $sale_num = 1)
	{
		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));
		
		$set_str = '';
		if ($type == 0) {
			$set_str = "count_sale_num = count_sale_num + $sale_num, count_sale_price = count_sale_price + $sale_price";
		}
		else if ($type == 1) {
			$set_str = "count_sale_num = count_sale_num - $sale_num, count_sale_price = count_sale_price - $sale_price";
		}

		$rs = $cb->n1ql_query("UPDATE bi_business_counter SET {$set_str}, `update` = 1 where business_id = {$business_id}");

		return $rs->status == 'success' ? true : false;
	}

	/**
	 * 修改商户关注数据
	 * @param string $business_ids 商户id 如：11,12
	 * @param int $type 类型0为增加，1为减少 
	 * @return boolean 返回类型
	 */
	public function change_attention_num($business_ids, $type = 0)
	{
		$cb = new \Couchbase(config('biCouchbases', null, 'bi'));

		$ids = explode(',', $business_ids);
		
		$keys = [];
		foreach ($ids as $id) {
			$keys[] = "business_counter_{$id}";
		}
		$keys_json = json_encode($keys);

		$set_str = '';
		if ($type == 0) {
			$set_str = "count_attention_num = count_attention_num + 1";
		}
		else if ($type == 1) {
			$set_str = "count_attention_num = count_attention_num - 1";
		}

		$rs = $cb->n1ql_query("UPDATE bi_business_counter USE KEYS {$keys_json} SET {$set_str}, `update` = 1");

		return $rs->status == 'success' ? true : false;
	}
}