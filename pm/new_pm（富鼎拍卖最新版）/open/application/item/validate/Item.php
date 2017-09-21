<?php

namespace app\item\validate;

use think\Validate;

class Item extends Validate {
    protected $rule = [
		['item_name','require','商品名称不能为空'],
		['item_total','require|number','商品总量不能为空|商品总量必须为数字'],
		//['item_price','require','商品价格不能为空！！'],
		['item_sort','number'],
		['goods_thumb','require','商品封面图不能为空'],
//		['goods_pictures','require','商品轮播图不能为空'],
		['gallery_pic_url','require','商品相册不能为空'],
		['goods_content','require','商品详情不能为空']
    ];

}