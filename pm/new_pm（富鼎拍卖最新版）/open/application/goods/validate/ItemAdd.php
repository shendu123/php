<?php

namespace app\goods\validate;

use think\Validate;

class ItemAdd extends Validate {
	protected $rule = [
		['goods_id','require|number','缺少goods_id|goods_id必须为数字'],
		
	];
	


}