<?php
/**
 * @class 缴纳保证金验证
 * @author ljx
 */
namespace app\finance\validate;

use think\Validate;

class Deposit extends Validate
{
    protected $rule = [
        "order_paytotal_price|支付金额" => "require|integer|egt:0",
        "address_id|收货人地址id" => "require|integer|gt:0"
    ];
}