<?php

namespace app\crowd\validate;

use think\Validate;

class Crowd extends Validate {
    protected $rule = [
		['crowd_name','require|unique:Crowd,crowd_name','申购名称不能为空！|申购名称已存在！'],
		['crowd_total','require|number','申购数量不能为空|申购数量必须为数字'],
		['crowd_price','require|regex:\d{1,10}(\.\d{1,2})?$','申购价不能为空|申购价格式不对。'],
		['crowd_broker_price','require|regex:\d{1,10}(\.\d{1,2})?$','佣金不能为空|佣金格式不对'],
		['crowd_seller_price','require|regex:\d{1,10}(\.\d{1,2})?$','卖家保证金不能为空|卖家保证金格式不对'],
		['crowd_starttime','require','开始时间不能为空'],
		['crowd_endtime','require|checkTime','结束时间不能为空|结束时间不能早于开始时间'],
//		['crowd_apply_stuff','require','卖家申请材料不能为空'],
		['goods_thumb','require','商品封面图不能为空'],
		['goods_pictures','require','商品轮播图不能为空'],
		['gallery_pic_url','require','商品相册不能为空'],
		['goods_content','require','商品详情不能为空']
    ];
	
	function checkTime($value , $rule , $data){
		return ($value < $data['crowd_starttime']) ? false : true;
	}

}