<?php

namespace app\goods\validate;

use think\Validate;

class CartAdd extends Validate {
	protected $rule = [
		"business_id|商家id" => "require|number|min:1",
		"product_id|产品id" => "require|number|min:1",
		"goods_id|商品id" => "require|number|min:1",
		"goods_name|商品名称" => "require",
		"product_name|产品名称" => "require",
		"market_price|市场价" => "number",
		"goods_price|商品价格" => "number",
		"member_goods_price|会员折扣价" => "number",
		"goods_sn|商品编码" => "require",
		"goods_num|商品照片" => "require|number|min:1",
		"type|商品类型" => "require|number",
		"goods_thumb|商品图片地址" => "require",
	];

}