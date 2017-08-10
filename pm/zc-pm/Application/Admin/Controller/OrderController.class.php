<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
    /**
     * 有效订单
     * @return [type] [description]
     */
    public function index() {
        $where = array();
        if (I('get.field')) {
            $where[I('get.field')] = I('get.val');
        }
        //if($_SESSION['email']!='3004631675@qq.com'){
            //增加企业id
            $where['business_id'] = array('in', $_SESSION['business_id']);            
        //} 
        $this->where = $where;
        // 网站发布条件
        $data = D('Order')->listOrder($where);
        $this->mct = $data['mct'];
        $this->list = $data['list'];
        $this->page = $data['page'];
        $this->display(); 
    }
    /**
     * 订单搜索
     * @return [type] [description]
     */
    public function search(){
        if(I('get.account')!=''){
            $uidarr = M('member')->where(array('account'=>array('LIKE', '%' . I('get.account') . '%')))->getField('uid',true);
            $where['uid'] = array('in',$uidarr);
        }
        // 订单号
        if(I('get.order_no')!=''){
            $where['order_no']=array('LIKE', '%' . I('get.order_no') . '%');
        }
        // 类型
        if(I('get.type')!=''){
            $where['type']=I('get.type');
        }
        // 状态
        if(I('get.status')!=''){
            $where['status']=I('get.status');
        }

        //if($_SESSION['email']!='3004631675@qq.com'){
            //增加企业id
            $where['business_id'] = array('in', $_SESSION['business_id']);            
        //} 

        $data = D('Order')->listOrder($where);
        $this->mct = $data['mct'];
        $this->list = $data['list'];
        $this->page = $data['page'];
        C('TOKEN_ON',false);
        $this->display('index');
            
    }

    public function crowd() {
        // 订单号
        if(I('get.crd_no') != '') {
            $where['crd_no'] = array('LIKE', '%' . I('get.crd_no') . '%');
        }
        //手机号
        if(I('get.mobile') != '') {
            $where['mobile'] = I('get.mobile');
        }
        // 状态
        if(I('get.status') != '') {
            $where['status'] = I('get.status');
        }
        //if($_SESSION['email']!='3004631675@qq.com'){
            //增加企业id
            $where['business_id'] = array('in', $_SESSION['business_id']);            
        //}
        $data = D('CrowdOrder')->listOrder($where);
        $this->mct = $data['mct'];
        $this->list = $data['list'];
        $this->page = $data['page'];
        $this->where = $where;

        $this->display();
    }

    public function crowd_edit() {
        $M = D("CrowdOrder");
        if (IS_POST) {
            $pow =I('post.info');
            if($pow['status']=='2'){
                if($pow['express']=='' and $pow['express_no']==''){
                    echojson(array('status' => 0, 'info' => '已发货状态请填写快递信息！'));
                    exit;
                }else{
                    $data['express'] = $pow['express'];
                    $data['express_other'] = $pow['express_other'];
                    $data['express_no'] = $pow['express_no'];
                }
            }
            $odarr = explode('_', $pow['crd_no']);
            $ct = 0;
            foreach ($odarr as $ok => $ov) {
                $where = array('crd_no'=>$ov);
                $data['remark']=$pow['remark'];
                $data['status'] = $pow['status'];

                if($data['status'] != 0){
                    $data['time'.$data['status']] = time();
                }
                $M->where($where)->save($data);
                $ct+=1;
            }
            $sysLog=D('system_log');          
            $logdata['action']="订单管理->申购订单->编辑";
            $logdata['description']="编辑订单号为".I('get.crd_no')."的申购订单";
            if($ct>0){
                $logdata['status']=1;
                $sysLog->addLog($logdata);
                echojson(array('status' => 1, 'info' => '编辑成功<br/>', 'url' => U('Order/crowd')));
            }else{
                $logdata['status']=0;
                $sysLog->addLog($logdata);
                echojson(array('status' => 0, 'info' => '编辑失败，请检查'));
            }
        } else {
            if(count(explode('_', I('get.crd_no')))==1){
                $info = $M->where(array('crd_no'=>I('get.crd_no')))->find();
            }else{
                $info = array('crd_no'=>I('get.crd_no'));
            }

            // 快递选择
            $this->express_list=expressCompany();
            $this->info=$info;
            $this->display();
        }
    }

    public function crowd_cancel() {

        if (IS_POST) {
            $pow =I('post.info');
            $pows =$_POST;

            $returnLoginInfo = D("Public")->authPass($pows);
            // var_dump($returnLoginInfo);
            if ($returnLoginInfo['status'] == 0) {
                echojson($returnLoginInfo);
                exit();
            }

            if($pow['status']==''){
                echojson(array('status' => 0, 'info' => '请选择操作'));
                exit;
            }
            
            if($pow['remark']==''){
                echojson(array('status' => 0, 'info' => '填写取消订单原因'));
                exit;
            }else{
                $data['remark'] = $pow['remark'];
            }        

            
            $odarr = explode('_', $pow['crd_no']);
            $ct = 0;
            foreach ($odarr as $ok => $ov) {           
                $M = D("CrowdOrder");
                $M->startTrans();
                // $where = array('crd_no'=>$ov);
                $where = " crd_no = '".$ov."' and status not in  (4,'4') ";

                $data['remark']=$pow['remark'];
                $data['status'] = $pow['status'];
                // var_dump($_SESSION);

                //退款
                if(isset($_SESSION['order_uid_cancel'])&&$_SESSION['order_uid_cancel']!=''){
                    $uid =  $_SESSION['order_uid_cancel'];
                    $_SESSION['order_uid_cancel']=='';
                }else{
                    echojson(array('status' => 0, 'info' => '没有订单'));exit();
                }

                $member = D('member');

                $datamoney = $_SESSION['total_price'];
                // var_dump($datamoney);
                // exit();

                $re1  = $member->where(array('uid'=>$uid))->setInc('wallet_pledge',$datamoney);
                

                $uinh = $M->where($where)->select();


                $dataui = D('Crowd')->where(array('crowd_id' => $uinh[0]['crowd_id']))->select();
                $datai['support_count'] = $dataui[0]['support_count']-1;
                $datai['support_money'] = $dataui[0]['support_money']-$uinh[0]['total_price'];
                $re3 = D('Crowd')->where(array('crowd_id' => $uinh[0]['crowd_id']))->save($datai);

                $datauir = D('CrowdItems')->where(array('ciid' => $uinh[0]['ciid']))->select();
                $datair['support_count'] = $datauir[0]['support_count']-1;
                $datair['support_money'] = $datauir[0]['support_money']-$uinh[0]['total_price'];
                $re3 = D('CrowdItems')->where(array('ciid' => $uinh[0]['ciid']))->save($datair);

                $data['is_refund'] ='1';

                if($data['status'] != 0){
                    $data['time'.$data['status']] = time();
                }
                $re2 = $M->where($where)->save($data);
                $sysLog=D('system_log');          
                $logdata['action']="订单管理->申购订单->取消";
                $logdata['description']="取消订单号为".$pow['crd_no']."的申购订单";               
                if($re1 && $re2){
                    $M->commit();
                    $logdata['status']=1;
                    $sysLog->addLog($logdata);
                    // 微信提醒内容
                    $wei_surpass['tpl'] = 'surpass';
                    $wei_surpass['msg']=array(
                        "url"=>U('Auction/details',array('pid'=>$info['pid']),'html',true), 
                        "first"=>"您好，您的订单【".$pow['crd_no']."已经取消。",
                        "remark"=>'...',
                        "keyword"=>array($info['pname'],$info['nowprice'].'元'),
                    );
                    // 站内信提醒内容
                    $web_surpass = array(
                        'title'=>'订单取消',
                        'content'=>'您的'.$pow['crd_no'].'订单，已经取消，金额退回到您的账户，谢谢合作'
                    );
                    // 短信提醒内容
                    $note_surpass = '您的订单“'.$pow['crd_no'].'”已经取消';
                    // 邮箱提醒内容
                    $mail_surpass['title'] = '您的订单已经取消';
                    $mail_surpass['msg'] = '您好：<br/><p>您参与竞拍'.$link.'的出价【'.$recordB['bided'].'元】被超越。</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站继续加价！</p>';

                    sendRemind(M('Member'),M('Member_weixin'),array(),array($uid),$web_surpass,$wei_surpass,$note_surpass,$mail_surpass,'buy');


                    echojson(array('status' => 1, 'info' => '订单取消成功<br/>'));exit();
                }else{
                    $logdata['status']=0;
                    $sysLog->addLog($logdata);                    
                    $M->rollback();
                    echojson(array('status' => 0, 'info' => '订单取消失败，可能该订单已取消过，请检查'));exit();
                }

                $ct+=1;
            }
  
        } else {
            $M = D("CrowdOrder");
            if(count(explode('_', I('get.crd_no')))==1){
                $info = $M->where(array('crd_no'=>I('get.crd_no')))->find();
            }else{
                $info = array('crd_no'=>I('get.crd_no'));
            }

            $_SESSION['order_uid_cancel'] =  $info['uid'];
            $_SESSION['total_price'] =  $info['total_price'];


            $this->business_id = $_SESSION['business_id'];
            $this->email = $_SESSION['email'];

            // 快递选择
            $this->express_list=expressCompany();
            $this->info=$info;
            $this->display();
        }
    }

    // 订单配置
    public function set_order(){
        if (IS_POST) {
            $this->checkToken();
            $data['Order'] = I('post.order');
            $sysLog=D('system_log');         
            $logdata['action']="订单管理->订单配置";
            $logdata['description']="订单管理中的订单配置";
            if (set_config("SetOrder", $data, APP_PATH . "Common/Conf/")) {
                $logdata['status']=1;
                $sysLog->addLog($logdata);
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '设置成功'));
            } else {
                $logdata['status']=0;
                $sysLog->addLog($logdata);
                echojson(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->order=C('Order');
            $this->display();
        }
    }
    // 订单编辑
    public function edit(){
        $M = M("Goods_order");
        if (IS_POST) {
            $pow =I('post.info');
            if($pow['status']=='2'){
                if($pow['express']=='' and $pow['express_no']==''){
                    echojson(array('status' => 0, 'info' => '已发货状态请填写快递信息！'));
                    exit;
                }else{
                    $data['express'] = $pow['express']; 
                    $data['express_other'] = $pow['express_other'];
                    $data['express_no'] = $pow['express_no']; 
                }
            }
            $odarr = explode('_', $pow['order_no']);
            $ct = 0;
            foreach ($odarr as $ok => $ov) {
                $where = array('order_no'=>$ov);
                $order = $M->where($where)->find();
                if ($pow['deftime']!='') {
                    if($pow['act']!=''){
                        if($pow['act']=='add'){
                            $data[$pow['deftime']] = $order[$pow['deftime']]+(60*60*24*$pow['day']);
                        }
                        if($pow['act']=='sub'){
                            $data[$pow['deftime']] = $order[$pow['deftime']]-(60*60*24*$pow['day']);
                        }
                    }
                }
                if($pow['downpay']==1){
                    if($pow['status']==0){
                        $data['status'] = 1;
                    }else{
                       $data['status'] = $pow['status'];
                    }
                    $data['remark']='管理员确认线下已支付';
                    $data['downpay']=1;
                    $data['time1']=time();
                    // 退还保证金
                    $rs = payBidUnfreeze(I('get.order_no'),1);
                }else{
                   $data['remark']=$pow['remark'];
                   $data['status'] = $pow['status']; 
                }
                if($data['status']!=0){
                    $data['time'.$data['status']] = time();
                }
                $M->where($where)->save($data);
                $ct+=1;
            }
            $sysLog=D('system_log');         
            $logdata['action']="订单管理->拍卖订单->编辑";
            $logdata['description']="编辑订单号为".I('get.order_no')."的拍卖订单";
            if($ct>0){
                $logdata['status']=1;
                $sysLog->addLog($logdata);
                echojson(array('status' => 1, 'info' => '编辑成功<br/>'.$rs,'url' => U('Order/index'))); 
            }else{
                $logdata['status']=0;
                $sysLog->addLog($logdata);
                echojson(array('status' => 0, 'info' => '编辑失败，请检查'));
            }
        } else {
            if(count(explode('_', I('get.order_no')))==1){
                $info = $M->where(array('order_no'=>I('get.order_no')))->find();
                $info=$info;

            }else{
                $info = array('order_no'=>I('get.order_no'));
            }
            $info['address']=unserialize($info['address']);

            // 快递选择
            $this->express_list=expressCompany();
            $this->info=$info;
            $this->display();
        }
    }
    // 删除文章
    public function del() {  
        $sysLog=D('system_log');
        $info['action']="订单管理->拍卖订单->删除";
        $info['description']="删除订单号为{$_GET['order_no']}的拍卖订单";
        if (M("Goods_order")->where(array('order_no'=>$_GET['order_no']))->delete()) {
            $info['status']=1;
            $sysLog->addLog($info);
            $this->success("成功删除");
        } else {
            $info['status']=0;
            $sysLog->addLog($info);
            $this->error("删除失败，可能是不存在该订单号的记录");
        }
    }

    public function crowd_del() {
        $sysLog=D('system_log');
        $info['action']="订单管理->申购订单->删除";
        $info['description']="删除订单号为".I('get.crd_no')."的申购订单";
        if (M("Crowd_order")->where(array('crd_no'=>$_GET['crd_no']))->delete()) {
            $info['status']=1;
            $sysLog->addLog($info);
            $this->success("成功删除");
        } else {
            $info['status']=0;
            $sysLog->addLog($info);
            $this->error("删除失败，可能是不存在该订单号的记录");
        }
    }
    
     
}