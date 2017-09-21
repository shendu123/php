<?php
namespace app\finance\controller;

use think\Request;

/**
 * @class 第三方支付查询
 * @author zsq 
 */
class Payquery
{
	/**
     * @function 微信查询接口
     * @author zsq
     */
    public function wechat($orderCode)
    {
       	require_once APP_PATH . "/finance/library/wechat/lib/WxPay.Api.php";
        $input = new \WxPayOrderQuery();
        $input->SetOut_trade_no($orderCode);
       	
        $api = new \WxPayApi(); 
        $result = $api::orderQuery($input);
    	
        return $result;
    }

    
    /**
     * @function 支付宝查询
     * @author zsq
     */
    public function alipay()
    {
    }

    /**
     * @function 汇潮查询
     * @author zsq
     */
    public function huichao()
    {
    }
}		