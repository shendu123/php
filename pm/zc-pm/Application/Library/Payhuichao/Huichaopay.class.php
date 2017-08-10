<?php

namespace Library\Payhuichao;

use Library\Payhuichao\CurlExecute;


/**
 * 汇潮 https://auth.yemadai.com/login
 */
class Huichaopay{

	private	$MerNo = '41659';//商户号,汇潮注册所得
	//https://gwapi.yemadai.com/merchant/gatewaySetup 这里设置密钥
	private $privateKey ='6tyg7u88';//汇潮 后台密钥设置
	private	$payType = 'B2B';//支付方式 需要回潮有开通支付方式 1003 错误

    private	$BillNo    = '';//订单号 传入
    private	$Amount    = '';// 传入
    private	$Remark = '100';//备注  传入
    private	$products = '充值支付';//物品信息  传入
    private	$ReturnURL = 'https://pay.ecpss.com/ReturnURL.htm';//支付完成后 页面跳转
    private	$AdviceURL = 'https://pay.ecpss.com/AdviceURL.htm';//服务器异步通知路径
    private	$SignInfo  = '';//签名信息  传入
    private	$OrderTime = '';//请求时间 YYYYMMDDHHMMSS 
    // private	$defaultBankNumber = 'ICBC';//银行代号
    
    private $sign_type ='MD5';
    private $SIGN ='SignInfo';
    private $METHOD_POST ='POST';
    private $payUrl ='https://gwapi.yemadai.com/pay/sslpayment';//汇潮 支付网关
	private	$timeout = 10 ;// 超时时间
	private	$input_charset = "utf-8" ;



    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildRequestForm($para_temp, $method, $button_name) {

		$sHtml = "<form id='E_FORM' name='E_FORM' action='".$this->payUrl."' method='".$method."'>";

		foreach ($para_temp as $key => $val) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
		$sHtml = $sHtml."<script>document.forms['E_FORM'].submit();</script>";
		
		return $sHtml;
	}

	/**
	 * [packData 传入数据]
	 * @param  [type] $BillNo   [订单号]
	 * @param  [type] $Amount   [金额]
	 * @param  [type] $Remark   [备注]
	 * @param  [type] $products [物品信息]
	 * @return [type]           [array]//以下参数順序 不能错 否则签名失败
	 */
	public function packData($BillNo,$Amount,$Remark,$products){
		$datas = array(
			"MerNo" 	 => $this -> MerNo,
			"BillNo" 	 => $BillNo,
			"Amount" 	 => $Amount,
			"OrderTime"  => date('YmdHis'),
			"ReturnURL"  => $this-> ReturnURL,
			"AdviceURL"  => $this-> AdviceURL,
			"payType" 	 => $this-> payType,
			"Remark" 	 => $Remark,
			"products" 	 => $products
		);

		//增加簽名信息
		$SignInfo = $this ->generateSigninfo( $datas );
		$datas['SignInfo'] = $SignInfo;

		return $datas;

	}

	public function packXmlData($value=''){
		$xmlData = "
		<xml><ToUserName><![CDATA[ad775b217]]></ToUserName >
		<FromUserName><![CDATA[tWy3zC3xUgQMR5coXif5SA]]></FromUserName >
		<CreateTime >1366181013< /CreateTime>
		<MsgType><![CDATA[text]]></MsgType >
		<Content><![CDATA[我的测试]]></Content >
		<MsgId >5867702771251151243< /MsgId>
		</xml >";
	}

	public function sendXmlRequest($sendTo,$xmlData){
		$url = $sendTo; //接收xml数据的文件
		$header[] = "Content-type: text/xml";      //定义content-type为xml,注意是数组
		$ch = curl_init ($url);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, $xmlData);
		$response = curl_exec($ch);
		if(curl_errno($ch)){
		    print curl_error($ch);
		}
		curl_close($ch);
	}



	// 汇潮退款
	public function refundByHuichao($BillNo,$Amount,$Remark,$products,$ReturnURL=null,$AdviceURL=null){
		if($ReturnURL!=null){
			$this-> ReturnURL = $ReturnURL;
			$this-> AdviceURL = $AdviceURL;
		}

		// var_dump($BillNo);
		// var_dump($Amount);
		// var_dump($Remark);
		// var_dump($products);

		$para = $this->packXmlData($BillNo,$Amount,$Remark,$products);
        return $this->sendXmlRequest($para,"post", "确认");
	}

	//汇潮支付接口
	public function payByHuichao($BillNo,$Amount,$Remark,$products,$ReturnURL=null,$AdviceURL=null){
		if($ReturnURL!=null){
			$this-> ReturnURL = $ReturnURL;
			$this-> AdviceURL = $AdviceURL;
		}

		// var_dump($BillNo);
		// var_dump($Amount);
		// var_dump($Remark);
		// var_dump($products);exit();

		$para = $this->packData($BillNo,$Amount,$Remark,$products);
        return $this->buildRequestForm($para,"post", "确认");
	}





	//合成signinfo
	public function generateSigninfo( $query = array() ){

		if( ! is_array( $query ) ){
			//exit;
		}

		//拼接參數
		$data2 = $this -> jointParam( $query );

		// 签名
		$signature = '';
		// var_dump($data2.'&'.$this->privateKey);
		if("MD5"==$this->sign_type){
			$signature = md5($data2.'&'.$this->privateKey);
		}

		$signature = strtoupper($signature);

		return $signature ;
	}



	//拼接參數 用於合成signinfo
	public function jointParam( $query ){
		if ( !$query ) {
			return null;
		}

		//重新组装参数
		$params = '';
		foreach($query as $key => $value){
			$ignore = ['payType','Remark','products'];
			if(!in_array($key,$ignore)){
				if($params==''){
					$params = $key .'='. $value ;
				}else{
					$params = $params.'&'.$key .'='. $value ;
				}
				
			}
			
		}

		// var_dump($params);

		return $params;



	}




























}