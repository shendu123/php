<?php
namespace Library\Paywechat;

require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'lib/WxPay.Data.php';
require_once 'Log.class.php';


use Library\Paywechat\lib\WxPayNotify;
use Library\Paywechat\lib\WxPayNotifyReply;
use Library\Paywechat\lib\WxPayOrderQuery;
use Library\Paywechat\lib\WxPayApi;
use Library\Paywechat\CLogFileHandler;

ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
//初始化日志
// $logHandler= new CLogFileHandler("/usr/html/www/paimai/Application/Library/Paywechat/logs/".date('Y-m-d').'.log');
$logHandler= new CLogFileHandler("wechat2.log");
// $logHandler= new CLogFileHandler("/usr/html/www/paimai/Application/Library/Paywechat/logs/test.log");
// var_dump($logHandler);
$log = Log::Init($logHandler, 15);

class Notify extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		// Log::DEBUG("transaction_id:" .$transaction_id );
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		// Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)&& array_key_exists("result_code", $result)&& $result["return_code"] == "SUCCESS"&& $result["result_code"] == "SUCCESS"){
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		Log::DEBUG("msg:-----------------------");
		// "appid":"wx54a365c9cd47deb5",
		// "attach":"czy149417097372915",
		// "bank_type":"CFT",
		// "cash_fee":"1",
		// "fee_type":"CNY",
		// "is_subscribe":"Y",
		// "mch_id":"1460161402",
		// "nonce_str":"yci1uu6d564y1hookweigj6zbkbt8dro",
		// "openid":"oEG6B1YsfGiWZnbx2RDcDv6rXbKw",
		// "out_trade_no":"146016140220170505172225",
		// "result_code":"SUCCESS",
		// "return_code":"SUCCESS",
		// "sign":"F87D7696AE840B02EE8F261F56585158",
		// "time_end":"20170505172240",
		// "total_fee":"1",
		// "trade_type":"NATIVE",
		// "transaction_id":"4005412001201705059678643495"


		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			Log::DEBUG("msg:" . $msg);
			return false;
		}
		// Log::DEBUG("msg:0-------------------0");
		//查询订单，判断订单真实性
		// $bb =$this->Queryorder($data["transaction_id"]);

		// Log::DEBUG("transaction_id:" .$data["transaction_id"] );
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($data["transaction_id"]);
		$result = WxPayApi::orderQuery($input);
		// Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)&& array_key_exists("result_code", $result)&& $result["return_code"] == "SUCCESS"&& $result["result_code"] == "SUCCESS"){

		}else{
			return false;
		}
		

		// if(!$bb){
		// 	$msg = "订单查询失败";
		// 	Log::DEBUG("msg:" . $msg);
		// 	return false;
		// }
	    // Log::DEBUG("msg:00000000000");

		$postValues = array(
			"MerNo"=> $data['appid'] ,
			"BillNo"=>  $data['attach'] ,
			"Amount"=> $data['total_fee']/100,
			"Succeed"=> $data['result_code'] ,
			"OrderNo"=>  $data['out_trade_no'] ,
			"Result"=> $data['result_code'] ,
			"SignInfo"=>  $data['sign']
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'http://www.fjsxpmh.com/Home/Payment/webhookNew?type=wechat&bid='.$_SESSION['business_id']);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postValues);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_COOKIEJAR, COOKIE_FILE);
        curl_setopt($curl, CURLOPT_USERAGENT, USER_AGENT);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_REFERER, LOGIN_FORM_URL);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_exec($curl);

        if(curl_errno($curl)){
        	Log::DEBUG("res:fail");
            // throw new Exception(curl_error($curl));
        }
        $res =  curl_exec($curl);
        Log::DEBUG("res:" . $res);
        // return mb_convert_encoding($res, 'utf-8', 'GBK,UTF-8,ASCII');












		Log::DEBUG("msg:" . $msg);
		return "success";
	}
}

Log::DEBUG("begin notify");
// $notify = new Notify();
// $notify->Handle(false);
