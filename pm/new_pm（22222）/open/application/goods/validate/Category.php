<?php

namespace app\goods\validate;

use think\Validate;

class Category extends Validate {
	protected $rule = [
		['cat_name','require|unique:GoodsCategory,cat_name','分类名称不能为空！|分类名称已存在！'],
		
	];
	


}