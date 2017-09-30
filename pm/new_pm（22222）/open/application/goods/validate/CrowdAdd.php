<?php

namespace app\goods\validate;

use think\Validate;

class CrowdAdd extends Validate {
	protected $rule = [
		['goods_id','require|number','缺少goods_id|goods_id必须为数字'],
		['crowd_total','require|number','申购数量不能为空|申购数量必须为数字'],
		['crowd_starttime','require','开始时间不能为空'],
		['crowd_endtime','require|checkTime','结束时间不能为空|结束时间不能早于开始时间'],
		
	];
	
	function checkTime($value , $rule , $data){
		return ($value < $data['crowd_starttime']) ? false : true;
	}


}