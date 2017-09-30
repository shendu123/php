<?php

namespace app\news\validate;

use think\Validate;

class NewsArticle extends Validate {
    protected $rule = [
		['cid','require|number','请选择分类id|cid必须为数字'],
        ['title','require|unique:NewsArticle,title','文章名称不能为空！|文章名称已存在！'],
		['sort','number'],
		['is_show','integer|between:0,1'],
    ];

}