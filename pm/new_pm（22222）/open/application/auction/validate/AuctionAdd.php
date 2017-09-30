<?php

namespace app\auction\validate;

use think\Validate;

class AuctionAdd extends Validate {
	protected $rule = [
		"mode|拍卖模式" => "require|integer|between:10,14",
		"name|名称" => "require",
		"cat_id|所属分类" => "require|integer",
		"goods_price|商品价值" => "number",
		"auction_type|拍卖类型" => "require|integer|between:0,1",
		"auction_succtype|成交模式" => "require|integer|between:0,1|_checksucctype:1",
		"auction_starttime|拍卖开始时间" => "require|date",
		"auction_endtime|拍卖结束时间" => "require|date",
		"auction_onset_price|起拍价" => "require|number",
		"auction_reserve_price|保留价" => "require|number",
		"goods_pictures|商品照片" => "require",
		"goods_thumb|商品封面照片" => "require",
		"goods_content|商品描述" => "require",
		"auction_apply_stuff|申请书" => "require",
		"auction_buier_price|买家保证金" => "require|number",
		"auction_seller_price|卖家保证金" => "require|number",
		"auction_broker_price|交易佣金" => "require|number",
	];

	protected function _checksucctype($value, $rule, $data) {
		return $value == 1 && ( !isset($data['auction_succ_price']) || $data['auction_succ_price'] < $data['auction_onset_price']) ? "即时成交价设置错误" : true;
	}

}