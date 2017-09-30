<?php

namespace app\goods\validate;

use think\Validate;

class AuctionAdd extends Validate {
	protected $rule = [
		['goods_id','require|number','缺少goods_id|goods_id必须为数字'],
		['auction_starttime','require','开始时间不能为空'],
		['auction_endtime','require|checkTime','结束时间不能为空|结束时间不能早于开始时间'],
		['auction_onset_price','require|regex:\d{1,10}(\.\d{1,2})?$','起拍价不能为空|起拍价格式不对。'],
		['auction_stepsize_price','require|number','加价幅度不能为空|加价幅度必须为数字'],
		['auction_buier_price','require|number','买家保证金不能为空|买家保证金必须为数字'],
		['auction_reserve_type','require|between:0,1|checkReserveType','请选择是否有保留价|类型必须在0，1之间|保留价不能为空'],
		['auction_reserve_price','number'],
		
		
	];
	//验证时间
	function checkTime($value , $rule , $data){
		return (strtotime($value) < strtotime($data['auction_starttime'])) ? false : true;
	}
	//判断是否有保留价
	function checkReserveType($value , $rule , $data){
		if($value == 1 && empty($data['auction_reserve_price'])){
			return false;
		}
		return true;
	}


}