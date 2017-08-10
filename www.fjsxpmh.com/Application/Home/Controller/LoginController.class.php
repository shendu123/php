<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends CommonController {
    // get方式进入该该控制器的方法如已登录将跳转至用户中心页面
    public function _initialize() {
        parent::_initialize();
        if (IS_GET) {
            if($this->checkLogin(0)){
                if (I('get.suname')==U('Login/index','','html',true)||I('get.suname')==U('Login/register','','html',true)) {
                    $referer = U('Member/index','','',true);
                }else{
                    $referer = I('get.suname');
                }
                header('Content-Type:application/json; charset=utf-8');
                redirect($referer,'','页面正在跳转...');
            }
        }
    }
    public function index(){
        if(IS_POST){
            $member = M('member');
            $mbcof = C('Member');
            $openid = I('post.openid');
            $access_token = I('post.access_token');
            if (I('post.suname')) {
                $referer = S(I('post.suname'));
            }else{
                $referer = U('Member/index','','html',true);
            }
            if(preg_match('/^[a-zA-Z][\w]{3,16}$/', I('post.account'))&&$mbcof['register']['account']=='on'){
                $where=array('account'=>I('post.account'));
                $msg = '账号';
            }elseif(preg_match('/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i', I('post.account'))&&$mbcof['register']['email']=='on'){
                $where=array('email'=>I('post.account'),array('verify_email'=>1));
                $msg = '邮箱';
            }elseif(preg_match('/^1[358]\d{9}$/', I('post.account'))&&$mbcof['register']['mobile']=='on'){
                $where=array('mobile'=>I('post.account'),array('verify_mobile'=>1));
                $msg = '手机号';
            }else{
                echojson(array('status' => 0, 'info' => '账号格式不正确'));
                exit;
            }
            $info = $member->field(array('uid','pwd','status','alerttype'))->where($where)->find();
            if(empty($info)){
                echojson(array('status' => 0, 'info' => I('post.account').$msg.'不存在，要不注册一个吧'));
                exit;
            }elseif (!check_verify(I('post.verify_code'))) {
                if (!is_weixin()) {
                    echojson(array('status' => 0, 'info' => '验证码错了,重新输入吧'));
                    exit;
                }
            }elseif ($info['pwd']!=encrypt(I('post.pwd'))) {
                echojson(array('status' => 0, 'info' => '密码错误，重新输一次吧'));
                exit;
            }
            elseif ($info['status']==0) {
                echojson(array('status' => 0, 'info' => '账号被禁用了，请和管理员联系'));
                exit;
            }
            // 更新用户数据
            $data = array(
                'uid'=>$info['uid'],
                'login_time'=>time(),
                'login_ip'=>get_client_ip()
                );
            if ($openid!='') {
                $data['weiauto'] = I('post.weiauto');
            }
            if($member->save($data)){
                // 如果勾选绑定微信且微信openid存在
                if (I('post.bound')==1 && $openid!='') {
                    $member_weixin = M('member_weixin');
                    // 获取本地微信用户信息
                    $wuser_info = $member_weixin->where(array('openid'=>$openid))->find();
                    // 如果存在实行保存操作
                    if ($wuser_info) {
                        // 微信数据uid和当前登陆uid不同
                        if ($wuser_info['uid']!=$data['uid']) {
                            // 如果该账号绑定过其他微信号进行解绑操作
                            $member_weixin->where(array('uid'=>$data['uid']))->setField('uid',0);
                            // 绑定当前微信用户
                            $wuser_info['uid'] = $data['uid'];
                        }
                        $wuser['weitime'] =  time()+172800;
                        if(!$member_weixin->where(array('openid'=>$openid))->save($wuser)){
                            echojson(array('status' => 0, 'info' => '微信数据更新失败，请重试！','url' => $referer));
                            exit();
                        }else{
                            if (I('post.alertadd')==1) {
                                // 更新提醒字段
                                upalerttype($member,$info['uid'],'weixin');
                            }
                        }
                    // 不存在实行添加操作
                    }else{
                        $scope = C('Weixin.scope');
                        // 用户点开分享链接链接显示授权登陆
                        if($scope == 'snsapi_userinfo'){
                            // snsapi_userinfo获取用户信息（网页授权获取用户信息）
                            $userInfo = getJson("https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
                        }
                        // 用户点开分享链接跳转到关注公众号引导页面
                        if($scope == 'snsapi_base'){
                            // snsapi_base获取用户信息（公众号获取用户信息）
                            if(S('S_accessToken')){
								$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'),S('S_accessToken'));
							}else{
								$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'));
								$S_accessToken=$WechatAuth->getAccessToken();
								if ($S_accessToken && is_array($S_accessToken)) {
									S('S_accessToken',$S_accessToken['access_token'],7200);//2小时过期
								}
							}
                            $userInfo = $WechatAuth->userInfo($openid);
                            // 整合信息写入数据库
                            // $wuser['subscribe'] = $userInfo['subscribe'],
                            $wuser['subscribe_time']=$userInfo['subscribe_time'];
                            $wuser['groupid']=$userInfo['groupid'];
                            $wuser['remark']=$userInfo['remark'];
                        }
                        if (!$userInfo) {
                            echojson(array('status' => 0, 'info' => '获取用户微信信息失败，请重试！','url' => $referer));
                            exit();
                        }
                        $wuser['openid'] = $openid;
                        $wuser['nickname'] = $userInfo['nickname'];
                        $wuser['sex'] = $userInfo['sex'];
                        $wuser['language'] = $userInfo['language'] ;
                        $wuser['city'] = $userInfo['city'] ;
                        $wuser['province'] = $userInfo['province'] ;
                        $wuser['country'] = $userInfo['country'] ;
                        $wuser['headimgurl'] = $userInfo['headimgurl'] ;
                        $wuser['weitime'] =  time()+172800;
                        // $wuser['tagid_list'] = $userInfo['tagid_list'];
                        // 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
                        if($userInfo['unionid']){
                            $wuser['unionid']=$userInfo['unionid'];
                        }
                        $wuser['uid']=$info['uid'];
                        // 添加并绑定微信
                        if(M('member_weixin')->add($wuser)){
                            if (I('post.alertadd')==1) {
                                // 更新提醒字段
                                upalerttype($member,$info['uid'],'weixin');
                            }
                        }else{
                            echojson(array('status' => 0, 'info' => '微信数据保存失败，请重试！','url' => $referer));
                            exit();
                        }
                    }
                }
                // 写入cookie
                $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
                $shell = $info['uid'] . md5($info['pwd'] . C('AUTH_CODE'));
                $_SESSION[$loginMarked] = $shell;
                $shell.= "_" . time();
                // 发送cookie
                setcookie($loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                S(I('post.suname'),null);
                // 返回注册成功信息
                echojson(array('status' => 1, 'info' => '登录成功','url' => $referer));
            }else{
                echojson(array('status' => 0, 'info' => '登录失败，请重试！','url' => $referer));
            }
        }else{
            $gol = I('get.gol');
            if ($gol==1) {
                if (!is_weixin()) {
                    $this->error('请在微信内打开页面');
                }
            }
            $mbcof=C('Member');
            foreach ($mbcof['register'] as $rek => $rev) {
                if($rek=='account'){$ltr='账号，';}
                if ($rek=='email') {$ltr.='邮箱，';}
                if ($rek=='mobile') {$ltr.='手机号';}
            }
            $this->ltr=$ltr;
            if ($openid = I('get.openid')) {
                $uid = M('member_weixin')->where(array('openid'=>I('get.openid')))->getField('uid');
                $this->account = M('member')->where(array('uid'=>$uid))->getField('account');
                $this->openid = $openid;
            }
            
            $this->bound = I('get.bound');
            $this->diversity = I('get.diversity');
            $this->access_token = I('get.access_token');
            $this->gol = $gol;
            if (I('get.suname')) {
                $this->suname = $suname;
            }
            // 不显示弹窗二维码
            $this->showcodemap = 0;
        	$this->display();
        }
    }
    public function weioauth(){
        if (is_weixin()) {
            $openid = I('get.openid');
            $access_token = I('get.access_token');
            if (I('get.suname')) {
                $referer = S(I('get.suname'));
                S(I('get.suname'),null);
            }else{
                $referer = U('Member/index','','',true);
            }
            // 获取微信用户信息【 
            $member_weixin = M('member_weixin');
            $member = M('member');
            // 查询本地存在用户
            $wuser_info = $member_weixin->where(array('openid'=>$openid))->find();
            if($wuser_info){
                $info = $member->where(array('uid'=>$wuser_info['uid']))->field('uid,pwd,weiauto')->find();
                // 更新用户数据
                $data = array(
                    'uid'=>$wuser_info['uid'],
                    'login_time'=>time(),
                    'login_ip'=>get_client_ip()
                    );
                if($member->save($data)){
                    // 更新微信数据
                    $member_weixin->where(array('openid'=>$openid))->setField('weitime',time()+172800);
                    // 写入cookie
                    $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                    $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
                    $shell = $info['uid'] . md5($info['pwd'] . C('AUTH_CODE'));
                    $_SESSION[$loginMarked] = $shell;
                    $shell.= "_" . time();
                    // 发送cookie
                    setcookie($loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                    Header("Location: ".$referer);
                    exit();
                }else{
                    $this->error('更新数据失败，请返回重试！');
                }
            
            }else{
                // 添加该用户到本站
                if (I('get.create')=='auto') {
                    $scope = C('Weixin.scope');
                    // 用户点开分享链接链接显示授权登陆
                    if($scope == 'snsapi_userinfo'){
                        // snsapi_userinfo获取用户信息（网页授权获取用户信息）
                        $userInfo = getJson("https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
                    }
                    // 用户点开分享链接跳转到关注公众号引导页面
                    if($scope == 'snsapi_base'){
                        // snsapi_base获取用户信息（公众号获取用户信息）
                        if(S('S_accessToken')){
							$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'),S('S_accessToken'));
						}else{
							$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'));
							$S_accessToken=$WechatAuth->getAccessToken();
							if ($S_accessToken && is_array($S_accessToken)) {
								S('S_accessToken',$S_accessToken['access_token'],7200);//2小时过期
							}
						}
                        $userInfo = $WechatAuth->userInfo($openid);
                        // 整合信息写入数据库
                        // $wuser['subscribe'] = $userInfo['subscribe'],
                        $wuser['subscribe_time']=$userInfo['subscribe_time'];
                        $wuser['groupid']=$userInfo['groupid'];
                        $wuser['remark']=$userInfo['remark'];
                    }
                    if (!$userInfo) {
                        echojson(array('status' => 0, 'info' => '获取用户微信信息失败，请重试！','url' => $referer));
                        exit();
                    }
                    $wuser['openid'] = $openid;
                    $wuser['nickname'] = $userInfo['nickname'];
                    $wuser['sex'] = $userInfo['sex'];
                    $wuser['language'] = $userInfo['language'] ;
                    $wuser['city'] = $userInfo['city'] ;
                    $wuser['province'] = $userInfo['province'] ;
                    $wuser['country'] = $userInfo['country'] ;
                    $wuser['headimgurl'] = $userInfo['headimgurl'] ;
                    $wuser['weitime'] =  time()+172800;
                    // $wuser['tagid_list'] = $userInfo['tagid_list'];
                    // 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
                    if($userInfo['unionid']){
                        $wuser['unionid']=$userInfo['unionid'];
                    }
                    $rgid = M('region')->where(array('region_name'=>array('LIKE', '%' . $wuser['city'] . '%')))->field('region_id,parent_id')->find();
                    $data = array(
                        'nickname'=>$wuser['nickname'],
                        'sex'=>$wuser['sex'],
                        'province'=>$rgid['parent_id'],
                        'city'=>$rgid['region_id'],
                        'reg_date'=>time(),
                        'reg_ip' => get_client_ip(),
                        'login_time'=>time(),
                        'login_ip'=>get_client_ip(),
                        'avatar'=>'headimgurl',
                        'weiauto'=>1
                        );
                    if($uid = $member->add($data)){
                        // 设置不重复的账号【
                        $i = '';
                        do {
                            $nb = $uid.$i;
                            if(strlen($nb)<4){
                                $nb = sprintf("%04d", $nb);
                            }
                            $account = 'wx'.$nb;
                            if(!$member->where(array('account'=>$account))->find()){
                                $data['account'] = $account;
                                $member->where(array('uid'=>$uid))->setField('account',$account);
                                $i = 1;
                            }else{
                                $i = 0;
                            }
                        } while ( $i = 0);
                        // 设置不重复的账号】
                        $wuser['uid'] = $uid;
                        // 设置微信登陆时间
                        if($member_weixin->add($wuser)){
                            // 写入cookie
                            $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                            $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
                            $shell = $uid . md5(C('AUTH_CODE'));
                            $_SESSION[$loginMarked] = $shell;
                            $shell.= "_" . time();
                            // 发送cookie
                            setcookie($loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                            Header("Location: ".$referer);
                            exit();
                        }else{
                            $this->error('微信登陆失败，请返回重试！');
                        }
                    }else{
                        $this->error('微信注册失败，请返回重试！');
                    }
                }else{
                    $this->error('没有读取到本地微信数据！');
                }
            }
        }else{
            $this->error('请在微信内打开页面');
        }
        
    }
    // public function creatpwd(){
    //     pre(md5('HVbUPg' . md5('admin')));
    // }

    // 用户注册
    public function register(){
    	if(IS_POST){
            // 微信openid
            $openid = I('post.openid');
            $access_token = I('post.access_token');
            if (I('post.pwd')!=I('post.pwded')) {
                echojson(array('status' => 0, 'info' => '两次密码不一致，再输一遍吧'));
                exit;
            }
            if (!check_verify(I('post.verify_code'))&&!is_weixin()) {
                echojson(array('status' => 0, 'info' => '验证码错了,重新输入吧'));
                exit;
            }
            if (I('post.suname')) {
                $referer = S(I('post.suname'));
            }else{
                $referer = U('Member/index','','html',true);
            }
            // 整合数据
            $data = array(
                'truename' => I('post.truename'),
                'pwd' => encrypt(I('post.pwd')),
                'reg_date'=>time(),
                'reg_ip' => get_client_ip(),
                'login_time'=>time(),
                'login_ip'=>get_client_ip()
                );
            // 微信注册
            if ($openid == '') {
                $data['nickname'] = I('post.nickname');
            }
            $member = M('member');
            // 写入前验证一次
            switch (I('post.registerType')) {
                case 'account':
                    if($member->where(array('account'=>I('post.account')))->count()!=0){
                        echojson(array('status' => 0, 'info' => I('post.account').'账号已存在，换一个吧'));
                        exit;
                    }
                    $data['account']=I('post.account');
                    // 微信注册
                    if ($openid == '') {
                        $data['mobile'] = I('post.mobile');
                    }
                    break;
                case 'email':
                    $ve = M('verify_email')->where(array('email'=>I('post.email')))->find();
                    if($ve['losetime']<time()){
                        echojson(array('status' => 0, 'info' => '验证码已过期，请重新注册'));
                        exit;
                    }
                    if($ve['code']!=I('post.email_verify')){
                        echojson(array('status' => 0, 'info' => '邮箱验证码错误，请确认'));
                        exit;
                    }
                    $data['account']=substr('on'.'_'.strstr(I('post.email'), '@', TRUE),0,16);
                    
                    $data['email'] = I('post.email');
                    $data['verify_email'] = 1;
                    // 微信注册
                    if ($openid == '') {
                        $data['mobile'] = I('post.mobile');
                        $data['alerttype'] = 'email';
                    }
                    break;
                case 'mobile':
                    $vm = M('verify_mobile')->where(array('mobile'=>I('post.mobile')))->find();
                    if($vm['losetime']<time()){
                        echojson(array('status' => 0, 'info' => '验证码已过期，请重新注册'));
                        exit;
                    }
                    if($vm['code']!=I('post.mobile_verify')){
                        echojson(array('status' => 0, 'info' => '短信验证码错误，请确认'));
                        exit;
                    }
                    $data['account']=substr('on'.'_'.I('post.mobile'),0,16);
                    
                    $data['mobile'] = I('post.mobile');
                    $data['verify_mobile'] = 1;
                    // 微信注册
                    if ($openid == '') {
                        $data['email'] = I('post.email');
                        $data['alerttype'] = 'mobile';
                    }
                    break;
                default:
                    echojson(array('status' => 0, 'info' => '不存在的注册方式'));
                    break;
            }
            // 如果勾选绑定微信且微信openid存在
            if (I('post.bound')==1 && $openid!='') {
                $member_weixin = M('member_weixin');
                // 获取本地微信用户信息
                $wuser_info = $member_weixin->where(array('openid'=>$openid))->find();
                //不存在实行添加操作 
                if (!$wuser_info) {
                    $scope = C('Weixin.scope');
                    // 用户点开分享链接链接显示授权登陆
                    if($scope == 'snsapi_userinfo'){
                        // snsapi_userinfo获取用户信息（网页授权获取用户信息）
                        $userInfo = getJson("https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN");
                    }
                    // 用户点开分享链接跳转到关注公众号引导页面
                    if($scope == 'snsapi_base'){
                        // snsapi_base获取用户信息（公众号获取用户信息）
                        if(S('S_accessToken')){
							$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'),S('S_accessToken'));
						}else{
							$WechatAuth = new WechatAuth(C('Weixin.appid'),C('Weixin.appsecret'));
							$S_accessToken=$WechatAuth->getAccessToken();
							if ($S_accessToken && is_array($S_accessToken)) {
								S('S_accessToken',$S_accessToken['access_token'],7200);//2小时过期
							}
						}
                        $userInfo = $WechatAuth->userInfo($openid);
                        // 整合信息写入数据库
                        // $wuser['subscribe'] = $userInfo['subscribe'],
                        $wuser['subscribe_time']=$userInfo['subscribe_time'];
                        $wuser['groupid']=$userInfo['groupid'];
                        $wuser['remark']=$userInfo['remark'];
                    }
                    if (!$userInfo) {
                        echojson(array('status' => 0, 'info' => '获取用户微信信息失败，请重试！','url' => $referer));
                        exit();
                    }
                    $wuser['openid'] = $userInfo['openid'];
                    $wuser['nickname'] = $userInfo['nickname'];
                    $wuser['sex'] = $userInfo['sex'];
                    $wuser['language'] = $userInfo['language'] ;
                    $wuser['city'] = $userInfo['city'] ;
                    $wuser['province'] = $userInfo['province'] ;
                    $wuser['country'] = $userInfo['country'] ;
                    $wuser['headimgurl'] = $userInfo['headimgurl'] ;
                    // $wuser['tagid_list'] = $userInfo['tagid_list'];
                    // 只有在用户将公众号绑定到微信开放平台帐号后，才会出现该字段。
                    if($userInfo['unionid']){
                        $wuser['unionid']=$userInfo['unionid'];
                    }
                    $act = 'add';
                    $city = $wuser['city'];
                    $data['nickname'] = $wuser['nickname'];
                    $data['sex'] = $wuser['sex'];
                }else{
                    $act = 'save';
                    $city = $wuser_info['city'];
                    $data['nickname'] = $wuser_info['nickname'];
                    $data['sex'] = $wuser_info['sex'];
                }
                $rgid = M('region')->where(array('region_name'=>array('LIKE', '%' . $wuser['city'] . '%')))->field('region_id,parent_id')->find();
                // member表数据整合
                $data['province'] = $rgid['parent_id'];
                $data['city'] = $rgid['region_id'];
                $data['avatar'] = 'headimgurl';
                $data['weiauto'] = I('post.weiauto');
            }
            if($uid = $member->add($data)){
                if (I('post.bound')==1 && $openid!='') {
                    $wuser['uid'] = $uid;
                    $wuser['weitime'] =  time()+172800;
                    if ($act == 'save') {
                        $suc = M('member_weixin')->where(array('openid'=>$openid))->save($wuser);
                    }
                    if ($act == 'add') {
                        $suc = M('member_weixin')->add($wuser);
                    }
                    if($suc){
                        if (I('post.alertadd')==1) {
                            // 更新提醒字段
                            upalerttype($member,$uid,'weixin');
                        }
                    }else{
                        echojson(array('status' => 0, 'info' => '微信数据添加失败，请重试！','url' => $referer));
                        exit;
                    }
                    if (I('post.alertadd')==1) {
                        // 更新提醒字段
                        upalerttype($member,$uid,'weixin');
                    }
                }
                // 推广统计
                M('feedback')->where(array('id'=>I('post.feedback')))->setInc('count');
                // 写入cookie
                $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
                $shell = $uid . md5($data['pwd'] . C('AUTH_CODE'));
                $_SESSION[$loginMarked] = $shell;
                $shell.= "_" . time();
                setcookie($loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                S(I('post.suname'),null);
                // 返回注册成功信息
                echojson(array('status' => 1, 'info' => '注册成功','url' => U('Member/index')));
            }else{
                echojson(array('status' => 0, 'info' => '注册失败，请与网站管理员联系'));
            }
        }else{
            $gol = I('get.gol');
            if ($gol==1) {
                if (!is_weixin()) {
                    $this->error('请在微信内打开页面');
                }
            }
            $mf = M('feedback');
            $mbcof=C('Member');
            $this->rtype = $mbcof['register'];
	    	$this->feedback = $mf->select();
            // 有哪些注册方式
            $ltype = array('account','email','mobile','');
            // 开启了哪些注册方式【
            foreach ($mbcof['register'] as $mck => $mcv) {
                $mkarr[]=$mck;
            }
            // 开启了哪些注册方式【
            // 设置默认注册方式

            if(in_array(I('get.registerType'), $ltype)){
                if(I('get.registerType')==''){
                    $registerType = $mkarr[0];
                }
                if(in_array(I('get.registerType'),$mkarr)){
                    $registerType = I('get.registerType');
                }
            }else{
                $this->error('页面不存在！');
            }
            $this->openid = I('get.openid');
            $this->bound = I('get.bound');
            $this->access_token = I('get.access_token');
            $this->registerType=$registerType;
            $this->gol = $gol;
            if (I('get.suname')) {
                $this->suname = $suname;
            }
            // 不显示弹窗二维码
            $this->showcodemap = 0;
	    	$this->display();
        }
    }
    // 忘记密码
    public function findPwd(){
        if(IS_POST){
            if(I('post.pwd')!=I('post.pwded')){
                $this->error('两次密码不一致，请检查');
                exit; 
            }
            $member = M('member');
            if(I('post.findType')=='email'){
                if(!$info = $member->where(array('email'=>I('post.email'),'verify_email'=>1))->field(array('uid','pwd'))->find()){
                    $this->error('该邮箱未注册，或未进行过认证！');
                    exit;
                }else{
                    M('verify_email')->where(array('email'=>I('post.email')))->delete();
                }
            }elseif(I('post.findType')=='mobile'){
                if(!$info = $member->where(array('mobile'=>I('post.mobile'),'verify_mobile'=>1))->field(array('uid','pwd'))->find()){
                    $this->error('该手机号未注册，或未进行过认证！');
                    exit;
                }else{
                    M('verify_mobile')->where(array('mobile'=>I('post.mobile')))->delete();
                }
            }
            $pwd = encrypt(I('post.pwd'));
            if($info['pwd']!=$pwd){
                if($member->where(array('uid'=>$info['uid']))->setField('pwd',$pwd)){
                    // 删除验证中的
                    $this->success('修改密码成功，请登录',U('Login/index'));
                }else{
                    $this->error('修改密码失败，请与管理员联系');
                }
            }else{
                $this->error('设置的密码不能和之前的密码一样');
            }
            
        }else{
            if(I('get.findType')==''){
                $findType='email';
            }else{
                $findType=I('get.findType');
            }
            $this->findType=$findType;
            $this->display('findPwd');
        }
    }
    // 邮箱注册发送验证码
    public function sendCode(){
        $checkadr = I('post.checkadr');
        if(I('post.checktp')=='email'){
            if(is_email(I('post.checktp'))){
                echojson(array('status' => 0, 'info' => "邮箱格式不正确"));
                exit;
            }
            $mwhere['email'] = $checkadr;
            $ckname='邮箱';
            $rc = randCode(5);
        }elseif(I('post.checktp')=='mobile'){
           $mwhere['mobile'] = $checkadr;
           $ckname='手机号';
           $rc = randCode(5,1);
        }
        if(I('post.checktp')=='email'){
            $verifyME  = verifyME('email',I('post.how'),$checkadr,$this->cUid);
            if($verifyME['status']){
                $body = "您的验证码为:".$rc."<br/>验证码24小时内有效！<br/>".C('SITE_INFO.name').C('SITE_INFO.summary');
                $return = send_mail($checkadr, "", "验证邮箱-".C('SITE_INFO.name'), $body);
                if ($return == 1) {
                    $vemail = M('verify_email');
                    $verifyData=array(
                        'email'=>$checkadr,
                        'code'=>$rc,
                        'time'=>time(),
                        'losetime'=>time()+(3600*C('SEND_LOSE_TIME'))
                        );
                    $vemail->where(array('email'=>$checkadr))->delete();
                    if($vemail->add($verifyData)){
                        echojson(array('status' => 1, 'info' => "注册验证码已发送到您的邮箱" . $checkadr . "中，请注意查收"));
                        exit;
                    }
                } else {
                    echojson(array('status' => 0, 'info' => $return));
                    exit;
                }
            }else{
                echojson($verifyME);
                exit;
            }
        }elseif(I('post.checktp')=='mobile'){
            $verifyME  = verifyME('mobile',I('post.how'),$checkadr,$this->cUid);
            if($verifyME['status']){
                $body = "您的验证码为:".$rc."，验证码24小时内有效！".C('SITE_INFO.name').",".C('SITE_INFO.summary');
                $noteStatus = sendNote($checkadr,$body);
                if ($noteStatus['status'] == 1) {
                    $vmobile = M('verify_mobile');
                    $verifyData=array(
                        'mobile'=>$checkadr,
                        'code'=>$rc,
                        'time'=>time(),
                        'losetime'=>time()+(3600*C('SEND_LOSE_TIME'))
                        );
                    $vmobile->where(array('mobile'=>$checkadr))->delete();
                    if($vmobile->add($verifyData)){
                        echojson(array('status' => 1, 'info' => "验证码已发送到您的手机" . $loginMobile . "中，请注意查收"));
                        exit;
                    }
                }else{
                    echojson($noteStatus);
                    exit;
                }
            }else{
                echojson($verifyME);
                exit;
            }
        }
    }
    // ---异步验证邮箱验证码
    public function checkEmailCode(){
        if(I('post.email_verify')!=''){
            $code = M('verify_email')->where(array('email'=>I('post.email')))->getField('code');
            if($code==I('post.email_verify')){
                echo 'true';
            } else {
                echo 'false';
            }
        }else{
            echo 'false';
        }
    }
    // ---异步验证手机验证码
    public function checkMobileCode(){
        if(I('post.mobile_verify')!=''){
            $code = M('verify_mobile')->where(array('mobile'=>I('post.mobile')))->getField('code');
            if($code==I('post.mobile_verify')){
                echo 'true';
            } else {
                echo 'false';
            }
        }else{
            echo 'false';
        }
        
    }
    // ---异步验证用户名是否存在
    public function checkAccount(){
        header('Access-Control-Allow-Origin:*');
    	if(M('member')->where(array('account'=>I('post.account')))->count()!=0){
    		echo 'false';
		} else {
			echo 'true';
		}
    }
    // ---异步验证码验证
    public function checkVerify(){
    	if(check_verify(I('post.verify_code'),'',false)){
    		echo 'true';
		} else {
			echo 'false';
		}
    }

    // ---异步验证手机号是否存在
    public function checkMobile(){
        $verifyME  = verifyME('mobile',I('post.how'),I('post.mobile'),$this->cUid);
        if($verifyME['status']){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    
    // ---异步验证邮箱是否存在
    public function checkEmail(){
        $verifyME  = verifyME('email',I('post.how'),I('post.email'),$this->cUid);
        if($verifyME['status']){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    // ---异步验证手机号是否存在2用户绑定账号
    public function checkMobileA(){
        if($uid = M('member')->where(array('mobile'=>I('post.email')))->getField('uid')){
            if(I('post.exc')==1&&$uid==$this->cUid){
                if(I('post.ech')=='json'){
                    echojson('0');
                }else{
                   echo 'false'; 
                }
            }else{
                if(I('post.ech')=='json'){
                    echojson('1');
                }else{
                   echo 'true'; 
                }
            }
        } else {
            if(I('post.ech')=='json'){
                echojson('0');
            }else{
               echo 'false'; 
            }
        }
    }
    // ---异步验证邮箱是否存在
    public function checkEmailA(){
        if($uid = M('member')->where(array('email'=>I('post.email')))->getField('uid')){
            if(I('post.exc')==1&&$uid==$this->cUid){
                if(I('post.ech')=='json'){
                    echojson('0');
                }else{
                   echo 'false'; 
                }
            }else{
                if(I('post.ech')=='json'){
                    echojson('1');
                }else{
                   echo 'true'; 
                }
            }
        } else {
            if(I('post.ech')=='json'){
                echojson('0');
            }else{
               echo 'false'; 
            }
        }
    }
    // ---找回密码异步验证手机号是否存在
    public function findCheckMobile(){
        $verifyME  = verifyME('mobile',I('post.how'),I('post.mobile'),$this->cUid);
        if($verifyME['status']){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    // ---找回密码异步验证邮箱是否存在
    public function findCheckEmail(){
        $verifyME  = verifyME('email',I('post.how'),I('post.email'),$this->cUid);
        if($verifyME['status']){
            echo 'true';
        }else{
            echo 'false';
        }
    }

}