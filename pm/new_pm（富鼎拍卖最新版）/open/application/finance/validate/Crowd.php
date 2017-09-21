<?php
/**
 * @class Crowd验证
 * @author ljx
 */
namespace app\finance\validate;

use think\Validate;

class Crowd extends Validate
{
    protected $rule = [
        //"express_id|快递公司id" => "require|integer|gt:0",
        "address_id|收货地址id" => "require|integer|gt:0",
        "order_amount_price|订单总金额" => "require|integer|gt:0",
        "order_paytotal_price|支付金额" => "require|integer|egt:0",
        "order_youhui_price|优惠金额" => "integer|egt:0",
        "order_freight_price|运费金额" => "integer|egt:0",
        "order_integral_price|积分抵扣总额" => "integer|egt:0",
        "order_stuff_num|物品总数" => "integer|gt:0",
        "order_integral|抵扣积分总数" => "integer|egt:0",
    ];
}