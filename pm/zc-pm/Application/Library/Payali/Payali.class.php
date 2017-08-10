<?php
namespace Library\Payali;


//导入支付宝
use Library\Payali\lib\AlipaySubmit;
use Library\Util\Util;

/**
 * Payali 阿里支付
 * https://open.alipay.com
 */
class Payali{


    public function payByAlipay($money,$orderID,$orderName,$orderDetail,$orderURL){

        require_once __DIR__ .'/alipay.config.php';

        /**************************请求参数**************************/
        //支付类型
        $payment_type = "1";
        //必填，不能修改
        //服务器异步通知页面路径
        $notify_url = "http://www.fjsxpmh.com/user/completeAlipay/";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = "http://www.fjsxpmh.com/user/completeAlipay";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/
       
        //商品展示地址
        $show_url = $orderURL;
        //需以http://开头的完整路径，例如：http://www.商户网址.com/myorder.html

        //防钓鱼时间戳
        $anti_phishing_key = '';
        //若要使用请调用类文件submit中的query_timestamp函数
        $uu = new Util();

        //客户端的IP地址
        $exter_invoke_ip = $uu->getClientIp();
        //非局域网的外网IP地址，如：221.0.0.1

        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
                "service"           => "create_direct_pay_by_user",
                "partner"           => trim($alipay_config['partner']),
                "seller_email"      => trim($alipay_config['seller_email']),
                "payment_type"      => $payment_type,
                "notify_url"        => $notify_url,
                "return_url"        => $return_url,
                "out_trade_no"      => $orderID,
                "subject"           => $orderName,
                "total_fee"         => $money,
                "body"              => $orderDetail,
                "show_url"          => $orderURL,
                "anti_phishing_key" => $anti_phishing_key,
                "exter_invoke_ip"   => $exter_invoke_ip,
                "_input_charset"    => trim(strtolower($alipay_config['input_charset']))
        );

        //建立请求
        $alipaySubmit = new AlipaySubmit($alipay_config);
        $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
        echo $html_text;

	}

}