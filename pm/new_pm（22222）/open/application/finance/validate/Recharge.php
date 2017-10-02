<?php
/**
 * @class 充值验证
 * @author ljx
 */
namespace app\finance\validate;

use think\Validate;

class Recharge extends Validate
{
    protected $rule = [
        "order_amount_price|充值金额" => "require|integer|gt:0|checkAmount:1",
        "order_paytotal_price|支付金额" => "require|integer|egt:0",
        "order_youhui_price|优惠金额" => "integer|egt:0"
    ];
    
    protected function checkAmount($value, $rule, $data){
        if($data['order_paytotal_price'] + $data['order_youhui_price'] != $data['order_amount_price']){
            return "支付金额+优惠金额不等于充值金额";
        }else{
            return true;
        }
    }
}