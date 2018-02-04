<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/10/20
 * Time: 15:53
 */

namespace app\mobile\controller;

use app\home\logic\UsersLogic;
use app\home\model\Message;
use app\common\logic\OrderLogic;
use think\Page;
use think\Request;
use think\Verify;
use think\db;
class Wx extends MobileBase{
    //TOKE常量
    const TOKEN = 'shendu';
    const WEB_URL = 'http://4fe17bb6.ngrok.io/mobile/';

    //微信开发者中心验证方法
    public function index(){
        //echo 1111;
//验证完要注释掉（start）    	http://www.jb51.net/article/76741.htm
//        $echoStr = $_GET["echostr"];
//        if($this->checkSignature()){
//            ob_clean();
//            echo $echoStr;
//            exit;
//        }
//验证完要注释掉（end）		
        $this->responseMsg();
    }

    
    /**
     * 开发者验证
     * @return bool
     * @throws Exception
     */
    private function checkSignature()
    {
        // you must define TOKEN by yourself
        $token = self::TOKEN;
        if (!$token) {
            throw new Exception('TOKEN is not defined!');
        }

        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 收发微信消息
     */
    public function responseMsg()
    {
        //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];//这种方式已废弃
	$postStr = file_get_contents("php://input"); 
        //extract post data
        if (!empty($postStr)){//\think\log::write('aa');
	    
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $RX_TYPE = trim($postObj->MsgType);
            switch($RX_TYPE){
                case "text":
                    $resultStr = $this->handleText($postObj);
                    break;
                case "event":
                    $resultStr = $this->handleEvent($postObj);
                    break;
                default:
                    $resultStr = "Unknow msg type: ".$RX_TYPE;
                    break;
            }
            echo $resultStr;
        }else {
            echo "";
            exit;
        }
    }

    public function handleText($postObj)
    {
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $keyword = trim($postObj->Content);
        $time = time();
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    </xml>";
        if(!empty( $keyword ))
        {
            $msgType = "text";
            switch (trim($keyword)){
                case '农村宝' :
                    $contentStr = "欢迎来到农村宝微信公众号!";
                    break;
                case '什么' :
                    $contentStr = "啥玩意啊？";
                    break;
                case '哈哈' :
                    $contentStr = "嘎嘎~";
                    break;
                case '恩':
                    $contentStr = "恩恩~";
                    break;
                default :
		    $contentStr = self::WEB_URL;
                    break;
            }

            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;
        }else{
            echo "Input something...";
        }
    }


    public function handleEvent($object)
    {
        $contentStr = "";
        $openid = $object->FromUserName;
        //$WeixinUser = new WeixinUser();
        switch ($object->Event)
        {   //加关注
            case "subscribe":
		$contentStr = "欢迎关注shendu的公众号！<br/>";
		$contentStr .= self::WEB_URL;
                break;
            //取消关注
            case "unsubscribe":
                //write_log("log.txt",$this->accessToken);
//                if($res = $WeixinUser->checkUser($openid)){
//                    $levelData = array('subscribe'=>0);
//                    $WeixinUser->editData($levelData,$res);
//                    $contentStr = '您已取消关注';
//                }
                break;
            case "SCAN":
                break;
            case "CLICK":
                $eventKey = trim($object->EventKey);
                /*if($eventKey=='V1001_GOOD'){
                    $wxUser=new WXUser();
                    $userInfo=$wxUser->getWxUserInfoByOpenID($object->FromUserName);
                    $contentStr = "欢迎您！".$userInfo['nickname']."  <a href='http://wx.178ncb.com'>请点击这里！</a>";
                    break;
                }else{
                    $contentStr="Unknow eventkey".$eventKey;
                }*/
                break;
            default :
                $contentStr = "Unknow Event: ".$object->Event;

                break;

        }
        $resultStr = $this->responseText($object, $contentStr);
        return $resultStr;
    }

    public function handleImg($postObj){
        $fromUsername = $postObj->FromUserName;
        $toUsername = $postObj->ToUserName;
        $time = time();
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Image>
					<MediaId><![CDATA[%s]]></MediaId>
					</Image>
					</xml>";
        $msgType = 'image';
        $media_id = '6yKdMmKcs8d3p0qUw4kLqLtMaY07dxxClXvDmWNG7Ug';
        $resultStr = sprintf($textTpl, $toUsername,$fromUsername,  $time, $msgType, $media_id);
        echo $resultStr;

    }


    public function responseText($object, $content, $flag=0)
    {
        $textTpl = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[%s]]></Content>
                    <FuncFlag>%d</FuncFlag>
                    </xml>";
        $resultStr = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content, $flag);
        return $resultStr;
    }

    //回复图文消息
    public function responseNews($postObj){
        $FromUserName = $postObj ->FromUserName;
        $ToUserName = $postObj->ToUserName;
        //$keyword = trim($postObj->Content);
        $picurl = 'http://mp.weixin.qq.com/s?__biz=MzIwMTMwMTMzMg==&mid=208463625&idx=1&sn=4a51db8bfc9f519db60fe478445cb7fc#rd';
        $title = 'testXu';
        $description = 'hello';
        $url = 'http://www.baidu.com';
        $time = time();
        $MsgType = 'news';
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>1</ArticleCount>
					<Articles>
					<item>
					<Title><![CDATA[%s]]></Title>
					<Description><![CDATA[%s]]></Description>
					<PicUrl><![CDATA[%s]]></PicUrl>
					<Url><![CDATA[%s]]></Url>
					</item>
					</Articles>
					</xml> ";
        $resultStr = sprintf($textTpl,$ToUserName,$FromUserName,$time,$MsgType,$title,$description,$picurl,$url);
        echo $resultStr;

    }
    //获取Memcache对象
    private function instanceMemcache(){
        $redis = Yii::$app->redis;
        if(!$redis){
            exit('没有检测到缓存对象，请检查Memcache是否开启以及参数是否正确');
        }
        $this->redis = $redis;
    }


    //获取微信access_token，并保存
    private function setAccessToken(){
            //拼接地址
            $url = Yii::$app->params['ACCESS_TOKEN_CREATE_URL'].'&appid='.Yii::$app->params['WX_APPID'].'&secret='.Yii::$app->params['WX_APPSECRET'];
            $accessTokenRes = json_decode(WeixinTool::httpGet($url), true);
            if(!isset($accessTokenRes['access_token'])){
                exit($accessTokenRes['errcode'].':'.$accessTokenRes['errmsg']);
            }
        $this->accessToken = $accessTokenRes['access_token'];
    }

}