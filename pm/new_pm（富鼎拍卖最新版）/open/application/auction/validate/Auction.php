<?php

namespace app\auction\validate;

use think\Validate;

class Auction extends Validate {
	protected $rule = [
		['auction_name','require|unique:Auction,auction_name','拍卖名称不能为空！|拍卖名称已存在！'],
		['auction_code','require|unique:Auction,auction_code','拍卖编码不能为空！|拍卖编码已存在！'],
		['auction_starttime','require','开始时间不能为空'],
		['auction_endtime','require|checkTime','结束时间不能为空|结束时间不能早于开始时间'],
		['auction_onset_price','require|regex:\d{1,10}(\.\d{1,2})?$','起拍价不能为空|起拍价格式不对。'],
		['auction_stepsize_price','require|number','加价幅度不能为空|加价幅度必须为数字'],
		['auction_buier_price','require|number','买家保证金不能为空|买家保证金必须为数字'],
		['auction_reserve_price','number'],
		['auction_apply_stuff','require','卖家申请材料不能为空'],
		['goods_thumb','require','商品封面图不能为空'],
		['goods_pictures','require','商品轮播图不能为空'],
		['gallery_pic_url','require','商品相册不能为空'],
		['goods_content','require','商品详情不能为空']
		
		
	];
	//验证时间
	function checkTime($value , $rule , $data){
		return (strtotime($value) < strtotime($data['auction_starttime'])) ? false : true;
	}


}