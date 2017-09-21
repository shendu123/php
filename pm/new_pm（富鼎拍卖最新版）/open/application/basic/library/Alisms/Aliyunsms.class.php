<?php

namespace Library\Aliyunsms;

include_once 'aliyun-php-sdk-core/Config.php';  
use Sms\Request\V20160927 as Sms;  
use Profile\DefaultProfile;  
use Aliyun\DefaultAcsClient;  



class Aliyunsms{



	/**
	 * @param  [手机号码]
	 * @param  [验证吗]
	 * @param  [短信模版 --需要阿里后台注册]
	 * @param  [公司签名 --需要阿里后台注册]
	 * @return [type]
	 */
	public function sendSms($phone,$code,$which,$com=''){
		if($com==''){
			$com = '首玺拍卖';
		}
		switch ($which) {
		    case 'zhuce':
		        $tem = 'SMS_47210042';
		        break;
		    case 'xiugai':
		        $tem = 'SMS_47210040';
		        break;
		    case 'dengru':
		        $tem = 'SMS_47210044';
		        break;
		    case 'duihuan':
		    	// 尊敬的${name}，您已成功购买股票培训高级课，请通过账号：${uname}，密码：${passa}，在http://gp.qianjingtv.com 登录，房间密码：${passb}
		    	$tem = 'SMS_66780267';
		    	break;
		    default:
		        return false;
		        break;
		}

		$AKID ='LTAIXfnvFYfyedvW';//阿里云后台 api 接口 打开“我的Access Key”页面，页面地址：https://ak-console.aliyun.com/#/accesskey/
		$ASecret ='ffg42c69MXuL9MA3055631YewjkASb';//需要阿里后台获取


	    $iClientProfile = DefaultProfile::getProfile("cn-hangzhou",$AKID,$ASecret );
	    DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", "Sms",  "sms.aliyuncs.com");

	    $client = new DefaultAcsClient($iClientProfile);    

	    $request = new Sms\SingleSendSmsRequest();

	    $request->setSignName($com);
	    $request->setTemplateCode($tem);
	    $request->setRecNum($phone);
	    $string = '';
	    foreach ($code as $k => $v) {
	    	if($string==''){
				$string = "\"".$k."\":\"".$v."\"";
	    	}else{
	    		$string = $string.",\"".$k."\":\"".$v."\"";
	    	}
	    	
	    }

	    $string = "{".$string."}";/*模板变量，数字一定要转换为字符串*/
	    $request->setParamString($string);
	    // var_dump('expression');
	
	    try {
	        $response = $client->getAcsResponse($request);
	        if(isset($response->Code)){
	        	// var_dump($response);
	        	return false;
	        }else{
		        return true;//$response->RequestId;  	
	        }
	    }
	    catch (ClientException  $e) {
	    	// return false;
	    	// var_dump($e->getErrorMessage());
	        return $e->getErrorCode();   
	        // print_r($e->getErrorMessage());   
	    }
	    catch (ServerException  $e) { 
		    // return false;     
		    // var_dump($e->getErrorMessage()); 
	        return $e->getErrorCode();   
	        // print_r($e->getErrorMessage());
	    }

	}


























}