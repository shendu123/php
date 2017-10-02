<?php
/**
 * @class 支付模块验证
 * @author ljx
 */
namespace app\finance\validate;

use think\Validate;

class Pay extends Validate
{
    protected $rule = [
        "order_id|订单id" => "require|integer|gt:0",
        "stuff_type|订单类型" => "require|integer|between:1,5",
        "order_pay_type|支付方式" => "require|integer|egt:0",
        "order_paytotal_price|支付金额" => "require|integer|egt:0"
    ];
}