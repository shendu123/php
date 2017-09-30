<?php

namespace app\finance\validate;

use think\Validate;

class BusinessPay extends Validate {
    protected $rule = [
		['business_id','require|number','运营商id不能为空！|运营商id必须为数字！'],
		['money','require|number','金额不能为空！|金额必须为数字！'],
		['pay_time','require','付款时间不能为空！'],
    ];
	

}