<?php

namespace app\basic\validate;

use think\Validate;

class BusinessAttentionAdd extends Validate {
	protected $rule = [
		"business_id|店铺id" => "require|integer|gt:0",
		"name|店铺名字" => "require",
		"picurl|店铺图片url" => "require",
	];


}