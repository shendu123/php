<?php
namespace app\basic\controller;

use app\basic\model\App;
use app\basic\model\Member;
use app\basic\model\MemberCompany;
use app\basic\controller\Alisms;
use think\controller\Rest;

use app\basic\library\Util;

use think\Session;

class Register extends Rest {


	//用户注册
	public function index(){

		$po = $this->request->post();
		$mem = new Member();
		$type = isset($po["type"])?$po["type"]:false;
		$phone = isset($po["phone"])?$po["phone"]:false;

		if(!$type||!$phone){
			$this->_error('参数错误', 200);
		}
		//检查短信验证码
		$mem = new Member();
		$resw = $mem->getCode($po['codetoken']);
		// var_dump( time()-strtotime($resw['codetime']) <60*60*60);exit();
		if(!isset($resw['code']) || $resw['code']!=$po['code']){
			return ["type"=>"error","tip"=>"短信验证码错误"];
		}
                $res = $mem->saveData($po);
                if($res=='zcgd'){
                        return ["type"=>"error","tip"=>"该手机号已经注册过"];
                }
		if($po['type']=='qiye'){
                    $po['uid'] = $res[0];
                    $po['iscom'] = 1;
                    $com = new MemberCompany();
                    $res = $com->saveData($po);
		}
                if($res){
                    $util = new Util();
                    //注册钱包
                    $wallData['uid']=$res[0];
                     $info =  $util->newCurl($this->request->header('accesstoken'),config("pay_api_url").'Pay/createWallet',true,$wallData);
                     if(isset($info->error)){
                        return ["msg"=>"注册成功,但是未正确生成钱包","uid"=>$res[0]];
                     }
                    return ["msg"=>"注册成功","uid"=>$res[0]];
                }

		
		# code...
	}


	//短信用的
	public function getCodetoken(){
		date_default_timezone_set('PRC');
        return  $units[]=md5(uniqid(md5(microtime(true)),true));
	}

	/**
     * [randomkeys 生成随机数]
     * @param  [type] $length [随机数长度]
     * @return [type] $key    [随机数]
     */
    function randomkeys($length){
        $pattern = '1235678908698966866999009899992098222';
        $key='';
        for($i=0;$i<$length;$i++){
           $key .= $pattern{mt_rand(0,35)};
        }
        return $key;
    }


	//发送短信
	public function sendAliSms(){
		$po = $this->request->Post();

		$phone = isset($po["phone"])?$po["phone"]:false;
		$which = isset($po["which"])?$po['which']:false;
		if(!$phone||!$which){
			$this->_error('参数错误', 200);
		}

		$com   = isset($po["com"])?$po['com']:null;
		$code = $this->randomkeys(4);
		//保存短信码
		$mem = new Member();
		$mem->saveCode($po['codetoken'],$code);

		// $code = Session::get('zhuce_smscode');
		// var_dump($code);exit();

		$data['code']    = $code ;
		$data['product'] = '首玺拍卖网' ;

		$sms = new Alisms();
		$res = $sms->sendSms($phone,$data,$which,$com);
		// $res = true;
		if($res){
			return ['msg'=> '发送成功'];
		}else{
			$this->_error('发送短信失败', 200);
		}
	}

	public function resetpwd(){
		$po = $this->request->Post();


		//检查短信验证码
		$mem = new Member();
		$resw = $mem->getCode($po['codetoken']);
		// var_dump( time()-strtotime($resw['codetime']) <60*60*60);exit();

		if($resw['code']!=$po['code']){
			return ["type"=>"error","tip"=>"短信验证码错误"];
		}

		$mem = new Member();
		$res = $mem->changepwd($po['phone'],$po['newpwd']);
		if($res){
			return ['msg'=>"修改成功"];
		}else{
			$this->_error("修改错误",200);
		}


	}

	public function getUserInfo(){
		$token = $this->request->header('accesstoken');
		$tArray = explode('/', $token);

		if($tArray[0]!="pythonJIUDEH783u8"){
			$this->_error("不允许的请求",200);
		}
        $mem = new Member();
        $res  = $mem->getUserInfo($tArray[1]);
        if($res){
            // $this->_error("获取用户信息错误");
            return $res;
        }else{
            $this->_error("获取用户信息错误",200);
        }
    }

	




}