<?php
namespace Home\Controller;

use Think\Controller;
use Com\WechatAuth;
use Com\JsSdk;

class CommonController extends Controller {
    public $loginMarked;
    public $cUid;
    public $subscribe;
    public $ism;
    /**
      +----------------------------------------------------------
     * 初始化
     * 如果 继承本类的类自身也需要初始化那么需要在使用本继承类的类里使用parent::_initialize();
      +----------------------------------------------------------
     */
    public function _initialize() {
        error_reporting(0);
        ini_set("error_reporting","E_ALL & ~E_NOTICE"); 
        header('Access-Control-Allow-Origin:*');
        $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
        if (empty($systemConfig['TOKEN']['member_marked'])) {
            $systemConfig['TOKEN']['admin_marked'] = "admin.oncoo.net";
            $systemConfig['TOKEN']['admin_timeout'] = 3600;
            $systemConfig['TOKEN']['member_marked'] = "home.oncoo.net";
            $systemConfig['TOKEN']['member_timeout'] = 3600;
            set_config("systemConfig", $systemConfig, APP_PATH . "/Common/Conf/");
        }
        // checkKey();
        // 定义模板【
        // 1:电脑版 2手机版 0自动切换
        $who = defineView(0);
        $this->ism=$who['mobile'];
        C('DEFAULT_THEME',$who['view']);
        $this->webroot=C('WEB_ROOT');
        // 定义模板】
        $this->loginMarked = md5($systemConfig['TOKEN']['member_marked']);
        // 获取当前用户id
        // 登录信息分配到模板
        if ($this->login = $this->checkLogin(0)) {
            $markedArr = explode('_', $_COOKIE[$this->loginMarked]);
            $this->cUid = substr($markedArr[0],0,-32);
        }
        // 微信浏览器需要关注微信公众号，或者直接登陆【
        $this->iswei = 0;
        if(false && is_weixin()){
            $this->iswei = 1;
            $this->showcodemap = 1;
            $jssdk = new JsSdk(C('Weixin.appid'),C('Weixin.appsecret'));
            //$jssdk->debug = true;
            $signPackage = $jssdk->GetSignPackage();
            $this->sharelink = $signPackage['url'];
            $this->shareimg = C('WEB_ROOT'). str_replace('./', '', C('Weixin.shareimg'));
            $this->signPackage = $signPackage;
            // 未登录跳转到登陆绑定页面
            if(!$this->login){
                // 如果get方式访问进入登录页面
                if (IS_GET && I('get.gol')!=1) {
                    $scope = C('Weixin.scope');
                    if(I('get.state')=='winlogin'){
                        $this->winlogin($scope);
                    }else{
                        $winoauth = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.C('Weixin.appid').'&redirect_uri='.urlencode($signPackage['url']).'&response_type=code&scope='.$scope.'&state=winlogin#wechat_redirect';
                        header("Location:".$winoauth);
                        exit();
                    }
                }
            }else{
                $member_weixin = M('member_weixin');
                $member = M('member');
                // 更新微信登陆时间和登陆方式
                $member_weixin->where(array('uid'=>$this->cUid))->setField('weitime',time()+172800);
                // 如果开启关注二维码提示
                if(C('Weixin.codemap')==1){
                    $openid = $member_weixin->where(array('uid'=>$this->cUid))->getField('openid');
                    // snsapi_base获取用户信息（公众号获取用户信息）
                    $WechatAuth = new WechatAuth(C('Weixin.appid'), C('Weixin.appsecret'));
                    $temuserinfo = $WechatAuth->userInfo($openid);
                    // 更新提醒字段
                    if($temuserinfo['subscribe']){
                        upalerttype($member,$this->cUid,'weixin');
                    }else{
                        upalerttype($member,$this->cUid,'weixin',1);
                    }
                    // 分配关注公众号状态
                    $this->subscribe=$temuserinfo['subscribe'];

                    // 分配公众号二维码地址
                    $this->codemapimg = C('WEB_ROOT'). str_replace('./', '', C('Weixin.codemapimg'));
                }
            }
        }
        // 微信浏览器需要关注微信公众号，或者直接登陆】
        $this->uid = $this->cUid;
        // 手机模板
        $this->ismobile=$who['mobile'];
        // 关注提醒状态开启状态
        $this->mapstate = $this->subscribe;
        
        if($this->login){
            //当前用户用户名分配到模板 
            $this->nickname = M('Member')->where('uid ='.$this->cUid)->getField('nickname');
            // 获取未读信息
            $this->smsc = M('mysms')->where(array('uid'=>$this->cUid,'status'=>0,'delmark'=>0))->count();
        }
        // 为结束的生成订单
        $this->foreach_order();
        // 当前时间分配到模板
        $this->nowtime = time();
        // 图片上传路径
        $this->upWholeUrl = '//static.fjsxpmh.com'.trim(C('UPLOADS_PICPATH'),'.');
        // 频道导航
        $cate = M('Goods_category');
        $this->channelMenu=$cate->where(array('pid'=>0))->order('sort desc')->limit(4)->select();
        $this->assign("site", $systemConfig);
    }

    // 单品拍卖订单
    public function foreach_order() {
        $ncow = array(
            'endtime'=>array('lt',time()),
            'endstatus'=>0,
        );
        $nco = D('Auction')->where($ncow)->select();
        // 查找数组内相同值的保留一个
        if(is_array($nco)){
            // 生成订单进入开关
            foreach ($nco as $n => $nv) {
                create_order($nv);
            }
        }
    }
    // 微信浏览器打开公众号关注用户登陆提醒关注公众号
    public function winlogin($scope){
            // 微信登录【
            if(I('get.code')) {
                $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                // 获取openid、access_token【
                $code = I('get.code');
                $url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.C('Weixin.appid').'&secret='.C('Weixin.appsecret').'&code='.$code.'&grant_type=authorization_code';
                $data=file_get_contents($url);
                $data = json_decode($data);
                $openid = $data->openid;
                $access_token = $data->access_token;
                // 获取openid、access_token】
                // 如果获取到openid【
                if($openid){
                    // 用户点开分享链接跳转到关注公众号引导页面
                    if($scope == 'snsapi_base'){
                        $WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'));
                        $userInfo = $WechatAuth->userInfo($openid);
                        // 整合信息写入数据库
                        // 如果关注过公众号
                        if(!$userInfo['subscribe']){// 提示关注公众号
                            header("Location:".C('Weixin.attention'));
                            exit();
                        }
                    }
                    // 获取微信用户信息【 
                    $member_weixin = M('member_weixin');
                    $member = M('member');
                    // 查询本地存在用户
                    $wuser_info = $member_weixin->where(array('openid'=>$openid))->find();
                    // GET方式传递地址会出错所以写入缓存调用缓存名称【
                    $suname = time().substr(microtime(), 2,3);
                    $uarr = explode('?code=', get_url());
                    S($suname,$uarr[0],3600);
                    // GET方式传递地址会出错所以写入缓存调用缓存名称】
                    if($wuser_info){
                        $info = $member->where(array('uid'=>$wuser_info['uid']))->field(array('uid','business_id','verify_mobile','mobile', 'aid', 'pwd', 'weiauto'))->find();
                        // 如果设置了微信自动登陆，进行登陆操作
                        if($info['weiauto']){
                            // 更新用户数据
                            $data = array(
                                'uid'=>$wuser_info['uid'],
                                'login_time'=>time(),
                                'login_ip'=>get_client_ip()
                            );
                            if($member->save($data)){
                                // 更新微信数据
                                $member_weixin->where(array('openid'=>$userInfo['openid']))->setField('weitime',time()+172800);
                                $_SESSION["business_id"] = $info['business_id'];
                                $_SESSION["aid"] = $info['aid'];
                                $_SESSION["uid"] = $info['uid'];
                                $_SESSION["verify_mobile"] = $info['verify_mobile'];
                                $_SESSION["mobile"] = $info['mobile'];

                                // 写入cookie
                                $shell = $wuser_info['uid'] . md5($info['pwd'] . C('AUTH_CODE'));
                                $_SESSION[$this->loginMarked] = $shell;
                                $shell.= "_" . time();
                                // 发送cookie
                                setcookie($this->loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                                redirect(S($suname),0,'登陆中...');
                                exit();
                            }else{
                                $this->error('更新数据失败，请返回重试！');
                            }
                        }else{
                            $this->redirect("Login/index",array('gol'=>1,'openid'=>$openid,'access_token'=>$access_token,'suname'=>$suname,'diversity'=>1),0,'跳转中...');
                        }
                    // 添加该用户到本站
                    }else{
                        // 是否微信绑定登录
                        if (C('Weixin.diversity')==1||C('Weixin.diversity')!=0) {
                            $this->redirect("Login/index",array('gol'=>1,'openid'=>$openid,'access_token'=>$access_token,'suname'=>$suname,'bound'=>'checked'),0,'跳转中...');
                        }else{
                            $gourl = U("Login/weioauth",array('gol'=>1,'openid'=>$openid,'access_token'=>$access_token,'suname'=>$suname,'create'=>'auto'),'html',true);
                            Header("Location: ".$gourl);
                        }
                    }
                }else{
                    $this->error('获取openid失败！');
                }
                // 如果获取到openid】
            }else{
                $this->error('获取code失败！');
            }
            // 微信登录】
    }
    // 判断登陆状态$type:1跳转，0返回登录状态
    public function checkLogin($type) {
        if (isset($_COOKIE[$this->loginMarked])) {
            $cookie = explode("_", $_COOKIE[$this->loginMarked]);
            $timeout = C("TOKEN");
            if (time() > (end($cookie) + $timeout['member_timeout'])) {
                setcookie($this->loginMarked, NULL, -$timeout['member_timeout'], "/");
                unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                if($type){
                    $this->error("登录超时，请重新登录", U("Login/index"));
                }else{
                    return 0;
                }
            } else {
                if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                    setcookie($this->loginMarked, $cookie[0] . "_" . time(), 0, "/");
                } else {
                    setcookie($this->loginMarked, NULL, -$timeout['member_timeout'], "/");
                    unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    if($type){
                        $this->error("帐号异常，请重新登录", U("Login/index"));
                    }else{
                        return 0;
                    } 
                }
            }
        } else {
            if($type){
                $this->redirect("Login/index");
            }else{
                return 0;
            } 
        }
        return 1;
    }

    //用于有支付的页面
    public function checkLoginB($type) {

        $url = explode("/",$_SERVER["REQUEST_URI"]);
        $Controller = ['Payment'];
        $Action = ['index','online'];
        if(in_array($url[count($url)-2], $Controller)){
            if(in_array($url[count($url)-2], $Action)){
                return 1;
            }
        }else{

            if (isset($_COOKIE[$this->loginMarked])) {
                $cookie = explode("_", $_COOKIE[$this->loginMarked]);
                $timeout = C("TOKEN");
                if (time() > (end($cookie) + $timeout['member_timeout'])) {
                    setcookie($this->loginMarked, NULL, -$timeout['member_timeout'], "/");
                    unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                    if($type){
                        $this->error("登录超时，请重新登录", U("Login/index"));
                    }else{
                        return 0;
                    }
                } else {
                    if ($cookie[0] == $_SESSION[$this->loginMarked]) {
                        setcookie($this->loginMarked, $cookie[0] . "_" . time(), 0, "/");
                    } else {
                        setcookie($this->loginMarked, NULL, -$timeout['member_timeout'], "/");
                        unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
                        if($type){
                            $this->error("帐号异常，请重新登录", U("Login/index"));
                        }else{
                            return 0;
                        } 
                    }
                }
            } else {
                if($type){
                    $this->redirect("Login/index");
                }else{
                    return 0;
                } 
            }
        }
        return 1;
    }

    /**
      +----------------------------------------------------------
     * 验证token信息
      +----------------------------------------------------------
     */
    protected function checkToken() {
        if (IS_POST) {
            if (!M("Admin")->autoCheckToken($_POST)) {
                die(echojson(array('status' => 0, 'info' => '重复提交数据，请刷新页面重试！','msg' => '重复提交数据！')));
            }
            unset($_POST[C("TOKEN_NAME")]);
        }
    }

}