<?php

namespace app\news\validate;

use think\Validate;

class NewsCategory extends Validate {
    protected $rule = [
        ['name','require|unique:NewsCategory,name','分类名称不能为空！|分类名称已存在！'],
		['is_show','integer|between:0,1'],
		['sort','number'],
    ];

}