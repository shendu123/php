<?php

namespace app\adv\validate;

use think\Validate;

class AdvPosition extends Validate {
    protected $rule = [
        ['name','require|unique:AdvPosition,name','广告位名称不能为空！|广告位名称已存在！'],
		['width','require|number','请输入宽！|宽度须为数字！'],
		['height','require|number','请输入高！|高度须为数字！'],
		['status','integer|between:0,1'],
    ];

}