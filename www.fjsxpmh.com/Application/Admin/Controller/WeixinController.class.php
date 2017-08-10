<?php
namespace Admin\Controller;
use Think\Controller;
use Com\Wechat;
use Com\WechatAuth;
class WeixinController extends CommonController {
    // 图文列表
    public function index() {
        $weiurl = M('Weiurl');
        $member = M('member');
        $count = $weiurl->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $weiurl->order('id desc')->select();
        foreach ($list as $k => $v) {
            if ($v['sellerid']) {
                $list[$k]['seller'] = $member->where(array('uid'=>$v['sellerid']))->field('account,nickname,avatar')->find();
            }
        }
        $this->list=$list;
        $this->display();
    }
    public function addurl(){
        if (IS_POST) {
            $this->checkToken();
            echojson(D('Weixin')->addEdit('add'));
        } else {
            $weixin['type']='admin';
            $this->weixin = $weixin;
            $this->display();
        }
    }
    // 编辑图文消息
    public function editurl() {
        $M = M('Weiurl');
        if (IS_POST) {
            echojson(D('Weixin')->addEdit('edit'));
        } else {
            $weixin = $M->where("id=" . (int) $_GET['id'])->find();
            if ($weixin['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("weixin", $weixin);
            C('TOKEN_ON',false);
            $this->display('addurl');
        }
    }

    // 选择推送
    public function weipush(){
        if(C('Weixin.appid')&&C('Weixin.appsecret')){
            if (I('post.type')=='image-text') {
                $widarr = I('post.wid');
                if(count($widarr)>4){
                    echojson(array('status' => 1, 'info' => '最多可选择4条图文进行发送！<br/>'.$resultmsg));
                    exit;
                }
                $weiurl = M('Weiurl');
                $wlist = $weiurl->where(array('id'=>array('in',$widarr)))->select();
                // 生成图文数据
                $news_arr = array();
                $lk = 0;
                $webroot = C('WEB_ROOT');
                foreach ($wlist as $wk => $wv) {
                    $news_arr[$lk][0] = $wv['name'];
                    $news_arr[$lk][1] = $wv['comment'];
                    // 地址替换
                    $news_arr[$lk][2] = $wv['url'];
                    // 图片选择
                    if($lk==0){
                        $news_arr[$lk][3] = $webroot.__ROOT__.trim(C('UPLOADS_PICPATH'),'.').$wv['toppic'];
                    }else{
                        $news_arr[$lk][3] = $webroot.__ROOT__.trim(C('UPLOADS_PICPATH'),'.').$wv['picture'];
                    }
                    $lk+=1;
                }
                // 获取微信登陆该站小于48小时的用户
                $uidarr = M('member_weixin')->where(array('weitime'=>array('gt',time())))->getField('uid',true);
                $retmsg = D('Weixin')->sendNews(array('uid'=>array('in',$uidarr)),$news_arr,$widarr);
                echojson(array('status'=>1,'info'=>$retmsg));
            }
        }else{
            echojson(array('status'=>1,'info'=>'没有配置微信，请先配置微信。'));
        }
    }


    //删除图文消息
    public function delurl() {
        if (M("Weiurl")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            //echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    // 微信自定义菜单
    public function weimenu(){
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/WeixinMenu.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['weimenu'] = I('post.weimenu');
            if (set_config("WeixinMenu", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                if(I('post.update')==1){
                    // 设置微信菜单【
                    foreach ($data['weimenu'] as $wmk => $wmv) {
                        foreach ($wmv as $mvk => $mvv) {
                            $mnli = array('name'=>$mvv['name'],'type'=>$mvv['type'],'url'=>$mvv['url']);
                            if($mvv['name']!=''){
                                if($mvk==0){
                                    $button[$wmk] = $mnli;
                                }else{
                                    $button[$wmk]['sub_button'][] = $mnli;
                                }
                            }
                            
                        }
                    }
                    $appid = C('Weixin.appid'); //AppID(应用ID)
                    $secret = C('Weixin.appsecret'); //微信后台填写的TOKEN
                    
                    if(S('S_accessToken')){
						$WechatAuth = new WechatAuth($appid,$secret,S('S_accessToken'));
                    }else{
						$WechatAuth = new WechatAuth($appid,$secret);
                        $S_accessToken=$WechatAuth->getAccessToken();
                        if ($S_accessToken && is_array($S_accessToken)) {
                              S('S_accessToken',$S_accessToken['access_token'],7200);//2小时过期
                        }
					}
                    $result = $WechatAuth->menuCreate($button);
                    if($result['errcode']==0){
                        $resultmsg = "微信菜单更成功";
                    }else{
                        $resultmsg = "微信菜单更新失败，错误代码".$result['errcode']."错误信息".$result['errmsg'];
                    }
                    // 设置微信菜单】
                }
                echojson(array('status' => 1, 'info' => '本地数据保存成功！<br/>'.$resultmsg));
            } else {
                echojson(array('status' => 0, 'info' => '本地数据保存失败，请检查'));
            }
        }else{
            $config = APP_PATH . "Common/Conf/WeixinMenu.php";
            $config = file_exists($config) ? include "$config" : array();
            $this->weimenu=$config['weimenu'];
            $this->display();
        }
    }

    // 微信配置
    public function weiconfig(){
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/SetWeixin.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['Weixin'] = I('post.Weixin');
            $data['Weipay'] = I('post.Weipay');
            if (set_config("SetWeixin", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '设置成功', 'url'=>U('Weixin/weiconfig')) );
            } else {
                echojson(array('status' => 0, 'info' => '设置失败，请检查', 'url'=>U('Weixin/weiconfig')) );
            }
        } else {
            $weixin = C('Weixin');
            $weipay = C('Weipay');
            $weixin['url'] = U('/Weixin/index','','html',true);
            $this->weixin=$weixin;
            $this->weipay=$weipay;
            $this->display(); 
        }
    }
    // 用户分享记录
    public function sharerecord(){
        $weiurl = M('share');
        $member = M('member');
        $count = $weiurl->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $weiurl->order('time desc')->select();
        foreach ($list as $lk => $lv) {
            if($lv['uid']){
                $uinfo = $member ->where(array('uid'=>$lv['uid']))->field('account,nickname')->find();
                $list[$lk]['account'] = $uinfo['account'];
                $list[$lk]['nickname'] = $uinfo['nickname'];
            }else{
                $list[$lk]['account'] = '游客';
            }
            
            $list[$lk]['sharename'] = sharename($lv['terrace']);
        }
        $this->list=$list;

        $this->display();
    }

}