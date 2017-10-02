<?php

namespace app\goods\validate;

use think\Validate;

class GoodsAdd extends Validate {
	protected $rule = [
		"goods_name|名称" => "require",
		"goods_title|标题" => "require",
		"goods_price|商品价值" => "number",
		"cat_id|所属分类" => "require|number",
		"goods_pictures|商品照片" => "require",
		"goods_thumb|商品封面照片" => "require",
		"goods_content|商品描述" => "require",
	];


}