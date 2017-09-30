<?php

namespace app\adv\validate;

use think\Validate;

class Adv extends Validate {
    protected $rule = [
		['pid','require|number','请选择广告位|pid必须为数字'],
		['adv_name','require|unique:Adv,adv_name','广告名称不能为空！|广告名称已存在！'],
		['adv_pic','require','请上传图片！'],
		['is_show','integer|between:0,1'],
		['link_url','require','广告链接不能为空'],
		['sort','number'],
		['start_time','require','开始时间不能为空'],
		['end_time','require|checkTime','结束时间不能为空|结束时间不能早于开始时间'],
    ];
	
	function checkTime($value , $rule , $data){
		return ($value < $data['start_time']) ? false : true;
	}

}