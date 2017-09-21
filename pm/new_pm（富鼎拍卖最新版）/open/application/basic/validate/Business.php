<?php

namespace app\basic\validate;

use think\Validate;

class Business extends Validate {
    protected $rule = [
		['name','require|unique:Business,name','店铺名称不能为空！|店铺名称已存在！'],
		['business_account','require|unique:Business,business_account','店铺账号不能为空！|店铺账号已存在！'],
		['business_broker','require','佣金比例不能为空！'],
		['business_starttime','require','开店开始时间不能为空'],
		['business_endtime','require|checkTime','开店结束时间不能为空|结束时间不能早于开始时间'],
    ];
	
	function checkTime($value , $rule , $data){
		return ($value < $data['business_starttime']) ? false : true;
	}
}