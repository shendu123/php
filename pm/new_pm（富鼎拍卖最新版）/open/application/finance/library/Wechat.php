<?php
require_once APP_PATH . "/finance/library/wechat/lib/WxPay.Data.php";
require_once APP_PATH . "/finance/library/wechat/lib/WxPay.Api.php";
require_once APP_PATH . "/finance/library/wechat/example/WxPay.JsApiPay.php";

/**
 * @class 微信支付
 * @author ljx
 */
class Wechat
{
    // 微信目前的支付类型 2017-08-03
    public $trade_types = array(
        'APP', // APP支付
        'JSAPI', // 公众号支付 以及 小程序支付
        'NATIVE', // 原生扫码支付
        'MWEB', // H5支付
        'MICROPAY'/*刷卡支付*/ 
    );

    public function __construct()
    {
    }

    /**
     * @function APP支付、公众号支付、原生扫码支付、H5支付、小程序支付 五种支付方式的统一下单接口
     * @author ljx
     */
    public function createOrder($tradeData = array())
    {
        // case 交易数据检查
        $result_check = $this->checkTradeData($tradeData);
        if($result_check['status'] == '404'){
            return $result_check;
        }
        
        $input = new WxPayUnifiedOrder();
        
        // case 必填参数设置
        // 统一下单接口已内部设置的必传参数有 appid mch_id nonce_str sign spbill_create_ip
        $input->SetOut_trade_no($tradeData['out_trade_no']); // 商户订单号
        $input->SetBody($tradeData['body']); // 商品描述
        $input->SetTotal_fee($tradeData['total_fee']); // 订单金额 或 总金额 或 标价金额
        $input->SetTrade_type($tradeData['trade_type']); // 交易类型
        $input->SetNotify_url($tradeData['notify_url']); // 接收微信支付异步通知回调地址，通知url必须为直接可访问的url，不能携带参数。
        
        // case 指定交易方式必填参数设置
        if ($tradeData['trade_type'] == 'JSAPI') {
            // 公众号支付 以及 小程序支付
            $input->SetOpenid($tradeData['openid']);
        }
        if ($tradeData['trade_type'] == 'NATIVE') {
            // 原生扫码支付
            $input->SetProduct_id($tradeData['product_id']);
        }
        if ($tradeData['trade_type'] == 'MWEB') {
            // H5支付时 场景信息必传
            $input->SetScene_info($tradeData['scene_info']);
        }
        
        // case 非必填参数设置
        if (isset($tradeData['device_info']) && ! empty($tradeData['device_info'])) {
            // 自定义参数，可以为终端设备号(门店号或收银设备ID)，PC网页或公众号内支付可以传"WEB"
            $input->SetDevice_info($tradeData['device_info']);
        }
        if (isset($tradeData['sign_type']) && ! empty($tradeData['sign_type'])) {
            // 签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
            // 暂不支持此属性设置
        }
        if (isset($tradeData['detail']) && ! empty($tradeData['detail'])) {
            // 商品详细描述，对于使用单品优惠的商户，改字段必须按照规范上传，详见“单品优惠参数说明”
            $input->SetDetail($tradeData['detail']);
        }
        if (isset($tradeData['attach']) && ! empty($tradeData['attach'])) {
            // 附加数据，在查询API和支付通知中原样返回，该字段主要用于商户携带订单的自定义数据
            $input->SetAttach($tradeData['attach']);
        }
        if (isset($tradeData['fee_type']) && ! empty($tradeData['fee_type'])) {
            // 符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
            $input->SetFee_type($tradeData['fee_type']);
        }
        if (isset($tradeData['time_start']) && ! empty($tradeData['time_start'])) {
            // 订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。其他详见时间规则
            $input->SetTime_start($tradeData['time_start']);
        }
        if (isset($tradeData['time_expire']) && ! empty($tradeData['time_expire'])) {
            // 订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。其他详见时间规则 注意：最短失效时间间隔必须大于5分钟
            $input->SetTime_expire($tradeData['time_expire']);
        }
        if (isset($tradeData['goods_tag']) && ! empty($tradeData['goods_tag'])) {
            // 商品标记，代金券或立减优惠功能的参数，说明详见代金券或立减优惠
            $input->SetGoods_tag($tradeData['goods_tag']);
        }
        if (isset($tradeData['limit_pay']) && ! empty($tradeData['limit_pay'])) {
            // no_credit--指定不能使用信用卡支付
            // 暂不支持此属性设置
        }
        
        // case 下单
        $order = WxPayApi::unifiedOrder($input);
        
        return $order;
    }

    /**
     * @function 交易数据检查
     * @author ljx
     * @see 微信统一下单文档地址 https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
     *      必传参数
     * @param 签名 sign
     * @param 商品描述 body
     * @param 商户订单号 out_trade_no
     * @param 总金额 total_fee
     * @param 终端IP spbill_create_ip
     * @param 通知地址 notify_url
     * @param 交易类型 trade_type
     */
    private function checkTradeData($tradeData = array())
    {
        $returnData = array();
        if(!isset($tradeData['out_trade_no']) || empty($tradeData['out_trade_no'])){
            $returnData = array(
                'status' => '400',
                'msg' => '商户订单号    out_trade_no 不能为空'
            );
        }
        if(!isset($tradeData['body']) || empty($tradeData['body'])){
            $returnData = array(
                'status' => '400',
                'msg' => '商品描述    body 不能为空'
            );
        }
        if(!isset($tradeData['total_fee']) || empty($tradeData['total_fee'])){
            $returnData = array(
                'status' => '400',
                'msg' => '订单金额 或 总金额 或 标价金额    total_fee 不能为空'
            );
        }
        if(!isset($tradeData['trade_type']) || empty($tradeData['trade_type'])){
            $returnData = array(
                'status' => '400',
                'msg' => '交易类型    trade_type 不能为空'
            );
        }
        if(!isset($tradeData['notify_url']) || empty($tradeData['notify_url'])){
            $returnData = array(
                'status' => '400',
                'msg' => '接收微信支付异步通知回调地址    notify_url 不能为空'
            );
        }
        
        return array(
            'status' => '200',
            'msg' => '参数验证成功'
        );
    }
}