<?php

namespace app\basic\validate;

use think\Validate;

class GoodsAttentionAdd extends Validate {
	protected $rule = [
		"goodsid|商品id" => "require|integer",
		"business_id|店铺id" => "require|integer",
		"name|商品名字" => "require",
		"picurl|商品图片url" => "require",
		"price|商品价格" => "number",
		"type|商品类型" => "integer",
	];


}