<?php
namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac;
class PublicController extends Controller {

    public $loginMarked;

    /**
      +----------------------------------------------------------
     * 初始化
      +----------------------------------------------------------
     */
    public function _initialize() {
        header('Content-Type:application/json; charset=utf-8');
        $loginMarked = C("TOKEN");
        $this->loginMarked = md5($loginMarked['admin_marked']);
    }

    /**
      +----------------------------------------------------------
     * 验证token信息
      +----------------------------------------------------------
     */
    private function checkToken() {
        if (!M("Admin")->autoCheckToken($_POST)) {
            die(json_encode(array('status' => 0, 'info' => '令牌验证失败')));
        }
        unset($_POST[C("TOKEN_NAME")]);
    }

    public function index() {            
        //选择加盟商
        $busi = M('business');


        if (IS_POST) {
          //  $this->checkToken();
            $returnLoginInfo = D("Public")->auth();
            //生成认证条件
            if ($returnLoginInfo['status'] == 1) {
                $map = array();
                // 支持使用绑定帐号登录
                $map['email'] = I('post.email');
               // import('Org.Util.Rbac');
                $authInfo = Rbac::authenticate($map);
                $_SESSION[C('USER_AUTH_KEY')] = $authInfo['aid'];
                $_SESSION['email'] = $authInfo['email'];
                $_SESSION['business_id'] = $_POST['business_id'];


                if ($authInfo['email'] == C('ADMIN_AUTH_KEY')) {
                    $_SESSION[C('ADMIN_AUTH_KEY')] = true;
                }
                // 缓存访问权限
                RBAC::saveAccessList();
            }
            echojson($returnLoginInfo);
        } else {
            if (isset($_COOKIE[$this->loginMarked])) {
                $this->redirect("Index/index");
            }
            $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
            
            $this->busi = $busi->select();
            $this->assign("site", $systemConfig);
            $this->display("Common:login");
        }
    }
    public function scheduled(){
        S(C('CACHE_FIX').'scheduled',time());
        $auction = M('Auction');
        $scheduled = M('scheduled');
        $member = M('Member');
        $member_weixin = M('member_weixin');
    // 结束提醒【
        // 被设置过结束提醒的拍卖(条件为未提醒过的结束提醒)
        $endpid = $scheduled->where(array('stype'=>'ing','time'=>0))->getField('pid',true);
        // 需要推送的拍品id集合(删除重复的pid)
        $endpid = array_flip(array_flip($endpid));
        // 符合结束提醒的拍卖
        $end = $auction->where(array('_string'=>'`endtime`-300 < '.time().' AND `endtime` > '.time(),'pid'=>array('in',$endpid)))->select();
        
        foreach ($end as $ek => $ev) {
            // 剩余时间时分秒
            $diffstr = timediff(time(),$ev['endtime'],'str');
            // 有设置提醒的用户
            if($uidarr = $scheduled->where(array('pid'=>$ev['pid'],'stype'=>'ing','time'=>0))->getField('uid',true)){
                if(mb_strlen($ev['pname'],'utf-8')>15){
                    $newname = mb_substr($ev['pname'],0,15,'utf-8').'...';
                }else{
                    $newname = $ev['pname'];
                }
                // 微信模板消息【
                $weimsg['tpl'] = 'bidstatus';
                $weimsg['msg']=array(
                    "url"=>U('Home/Auction/details',array('pid'=>$ev['pid']),'html',true), 
                    "first"=>'您好，拍卖即将结束，请尽快出价！',
                    "remark"=>"立即前往出价>>",
                    "keyword"=>array($ev['pname'],$ev['nowprice'].'元【当前价】',$diffstr.'后【结拍】',date('y年m月d日 H:i',$ev['endtime']).'【结束】',percent($ev['pledge_type'],$ev['onset'],$ev['pledge']).'元'),
                );
                // 短信提醒内容
                $notemsg = '拍品“'.$newname.'”在'.$diffstr.'后结束，请尽快登陆网站进行出价';
                // 邮箱提醒内容
                $mailmsg['title'] = "【结束提醒】";
                $mailmsg['msg'] = '您好：<br/><p>拍品“<a target="_blank" href="'.U('Home/Auction/details',array('pid'=>$ev['pid']),'html',true).'">'.$ev['pname'].'</a>”在'.$diffstr.'后结束！</p><p>请尽快<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站进行出价！</p>';
                // 发送消息函数
                sendRemind($member,$member_weixin,$ev,$uidarr,$webmsg,$weimsg,$notemsg,$mailmsg,'ing');
            }
            
        }
    // 结束提醒】
    // 开拍提醒【
        // 被设置过开拍提醒的拍卖(条件为未提醒过的开拍提醒)
        $startpid = $scheduled->where(array('stype'=>'fut','time'=>0))->getField('pid',true);
        // 需要推送的拍品id集合(删除重复的pid)
        $startpid = array_flip(array_flip($startpid));
        if(count($startpid)!=0){
            // 符合开拍提醒的拍卖
            $start = $auction->where(array('_string'=>'`starttime`-300 < '.time().' AND `starttime` > '.time(),'pid'=>array('in',$startpid)))->select();
            foreach ($start as $sk => $sv) {
                // 剩余时间时分秒
                $diffstr = timediff(time(),$sv['starttime'],'str');
                // 有设置提醒的用户
                if($uidarr = $scheduled->where(array('pid'=>$sv['pid'],'stype'=>'fut','time'=>0))->getField('uid',true)){
                    // 微信模板消息【
                    $wei['tpl'] = 'bidstatus';
                    $wei['msg']=array(
                        "url"=>U('Home/Auction/details',array('pid'=>$sv['pid']),'html',true), 
                        "first"=>'您好，拍卖即将开始，请准备出价！',
                        "remark"=>"不设置“结拍提醒”则不提醒！立即前往出价>>",
                        "keyword"=>array($sv['pname'],$sv['onset'].'元【起拍】',$diffstr.'后【开拍】',date('y年m月d日 H:i',$sv['endtime']).'【结束】',percent($sv['pledge_type'],$sv['onset'],$sv['pledge']).'元'),
                    );
                    // 短信提醒内容
                    $notemsg = '拍品“'.$newname.'”在'.$diffstr.'开拍，请登陆网站准备出价';
                    // 邮箱提醒内容
                    $mailmsg['title'] = "【结束提醒】";
                    $mailmsg['msg'] = '您好：<br/><p>拍品“<a target="_blank" href="'.U('Home/Auction/details',array('pid'=>$sv['pid']),'html',true).'">'.$sv['pname'].'</a>”在'.$diffstr.'后开拍！</p><p>请尽快<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站进行出价！</p>';
                    // 发送消息函数
                    sendRemind($member,$member_weixin,$sv,$uidarr,$webmsg,$wei,$notemsg,$mailmsg,'fut');
                }
            }
        }
    // 开拍提醒】

    // 订单默认期限到期操作【
        order_dispose_default();
    // 订单默认期限到期操作】
    }

    public function verify_code(){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 17;
        $Verify->length   = 4;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }
    public function loginOut() {
        $timeout = C("TOKEN");
        setcookie($this->loginMarked, NULL, -$timeout['admin_timeout'], "/");
        unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
        if (isset($_SESSION[C('USER_AUTH_KEY')])) {
            unset($_SESSION[C('USER_AUTH_KEY')]);
            unset($_SESSION);
            session_destroy();
        }
        $this->redirect("Index/index");
    }

    public function findPwd() {
        $M = M("Admin");
        if (IS_POST) {
            $this->checkToken();
            echojson(D("Public")->findPwd());
        } else {
            $timeout = C("TOKEN");
            setcookie($this->loginMarked, NULL, -$timeout['admin_timeout'], "/");
            unset($_SESSION[$this->loginMarked], $_COOKIE[$this->loginMarked]);
            $cookie =I('get.code');
            $shell = substr($cookie, -32);
            $aid = (int) str_replace($shell, '', $cookie);
            $info = $M->where(array('aid'=>$aid))->find();
            if ($ev['status'] == 0) {
                $this->error("你的账号被禁用，有疑问联系管理员吧", __APP__);
            }
            if (md5($ev['find_code']) == $shell) {
                $this->assign("info", $info);
                $_SESSION['aid'] = $aid;
                $systemConfig = include APP_PATH . 'Common/Conf/systemConfig.php';
                $this->assign("site", $systemConfig);
                $this->display("Common:findPwd");
            } else {
                $this->error("验证地址不存在或已失效", __APP__);
            }
        }
    }

}