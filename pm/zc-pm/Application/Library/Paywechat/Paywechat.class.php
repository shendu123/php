<?php


namespace Library\Paywechat;



use Library\Paywechat\lib\WxPayApi;
use Library\Paywechat\lib\WxPayUnifiedOrder;
use Library\Paywechat\NativePay;
use Library\Paywechat\lib\WxPayConfig;
use Library\Paywechat\CLogFileHandler;
use Library\Paywechat\JsApiPay;

ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);

require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once "WxPay.NativePay.php";
require_once "Log.php";

class Paywechat{

	//扫码支付获取 二维码地址
	public function createQrUrl($title,$title2,$money,$goodtag,$type,$productid,$return_url){
		$notify = new NativePay();
		$input = new WxPayUnifiedOrder();
		$input->SetBody($title);
		$input->SetAttach($title2);
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee($money);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag($goodtag);
		$input->SetNotify_url($return_url);
		$input->SetTrade_type($type);//NATIVE
		$input->SetProduct_id($productid);
		$result = $notify->GetPayUrl($input);

		if($result["return_code"]=='FAIL'){
			$url = $result["return_msg"];
		}else{
			$url = $result["code_url"];
		}
		
		$url = urlencode($url);

		return "http://paysdk.weixin.qq.com/example/qrcode.php?data=".$url;
	}

	//微信环境下 web页面支付
	public function payByJsWechat($title,$title2,$money,$goodtag,$return_url){
        //①、获取用户openid
        $tools = new JsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($title);
        $input->SetAttach($title2);
        $input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
        $input->SetTotal_fee($money);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($goodtag);
        $input->SetNotify_url($return_url);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        // var_dump($input);
        $order = WxPayApi::unifiedOrder($input);
        // echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
        // printf_info($order);
        // var_dump($order);exit();
        // 

        $data['jsApiParameters'] = $jsApiParameters = $tools->GetJsApiParameters($order);
        //获取共享收货地址js函数参数
        $data['editAddress'] = $editAddress = $tools->GetEditAddressParameters();

        return $data;
		
	}







}
