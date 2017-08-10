<?php
namespace Home\Controller;
use Think\Controller;

use Library\Paywechat\Paywechat;

class MemberController extends CommonController {
	public function _initialize() {
		parent::_initialize();
		$this->checkLogin(1);
	}
    public function index(){
        $order = M('goods_order');
        $info=M('Member')->where(array('uid'=>$this->cUid))->find();
        $info['pledge_live']=$info['wallet_pledge']-$info['wallet_pledge_freeze'];
        $info['limsum_live']=$info['wallet_limsum']-$info['wallet_limsum_freeze'];
        $info['smsc']=M('mysms')->where(array('uid'=>$this->cUid))->count();

        // 提醒方式设置【
        $alerttype = M('member')->where(array('uid'=>$this->cUid))->getField('alerttype');
        if($alerttype){$this->alerttype = explode(',', $alerttype);}
        // 提醒方式设置】

        $waitBuyW=array(
            'uid'=>$this->cUid,
            'type'=>array('in','0,1')
        );
        $waitSelW=array(
            'sellerid'=>$this->cUid,
            'type'=>array('in','0,1')
        );
        $info['buy']['waitpay']=$order->where($waitBuyW)->where(array('status'=>0))->count();
        $info['buy']['waitgain']=$order->where($waitBuyW)->where(array('status'=>2))->count();
        $info['buy']['waiteval']=$order->where($waitBuyW)->where(array('status'=>3))->count();
        $info['sel']['waitdeliver']=$order->where($waitSelW)->where(array('status'=>1))->count();
        $info['sel']['waiteval']=$order->where($waitSelW)->where(array('status'=>5))->count();
        $this->info=$info;
        $this->display();
    }
	/**
	 * 个人信息
	 * @return [type] [description]
	 */
    public function my_info(){
        if(IS_POST){
        	$this->checkToken();
            $data = I('post.');
            $region = I('post.region');
            unset($data['region']);
            $data = array_merge($data,$region);
            if(M('Member')->save($data)){
                S('nickname'.$this->cUid,NULL);
            	echojson(array('status' => 1, 'info' => '已修改','url'=>__SELF__));
            }else{
            	echojson(array('status' => 0, 'info' => '修改失败','url'=>__SELF__));
            }
        }else{
        	$my_info = M('Member')->where(array('uid'=>$this->cUid))->find();
        	$this->my_info = $my_info;
        	$this->display();
        }
    }
    public function imseller(){
        if(IS_POST){
            $this->checkToken();
            $data = I('post.');
            if(M('Member')->save($data)){
                echojson(array('status' => 1, 'info' => '已修改','url'=>__SELF__));
            }else{
                echojson(array('status' => 0, 'info' => '修改失败','url'=>__SELF__));
            }
        }else{
            $my_info = M('Member')->where(array('uid'=>$this->cUid))->field('uid,organization,intro')->find();
            $this->my_info = $my_info;
            $this->display();
        }
    }

    /**
     * 我的收获地址
     * @return [type] [description]
     */
    function deliver_address(){
        if(IS_POST){
            $this->checkToken();
            $data = I('post.');
            $region = I('post.region');
            unset($data['region']);
            $data = array_merge($data,$region);
            $deliver_address = M('deliver_address');

            if(!$data['adid']){
                if($deliver_address->where(array('uid'=>$this->cUid))->count()>20){
                    echojson(array('status' => 0, 'info' => '添加失败，您添加的地址数量已达到20个，请选择编辑','url'=>U('Member/deliver_address')));
                    exit;
                }
                // 必须有一个默认地址
                if($deliver_address->where(array('uid'=>$this->cUid))->count()==0){
                    $data['default'] = 1;
                }elseif($data['default']==1){
                    $deliver_address->where(array('uid'=>$this->cUid))->setField('default',0);
                }//echo "<pre>";print_r($data);exit;
                unset($data['adid']);
                unset($data['__oncoo__']);
                $st = $deliver_address->add($data);
                $ts = '新增';
            }else{
                // 必须有一个默认地址
                if($data['default']==1){
                    $deliver_address->where(array('uid'=>$this->cUid))->setField('default',0);
                }
                $st = $deliver_address->save($data);
                $ts = '修改';
            }
            if($st){
                echojson(array('status' => 1, 'info' => $ts.'成功','url'=>U('Member/deliver_address')));
            }else{
                echojson(array('status' => 0, 'info' => $ts.'失败','url'=>U('Member/deliver_address')));
            }
        }else{
            $deliver_address = M('deliver_address');
            $list = $deliver_address->where(array('uid'=>$this->cUid))->select();
            $region = M('region');
            foreach ($list as $lk => $lv) {
                $province = $region->where(array('region_id'=>$lv['province']))->getField('region_name');
                $city = $region->where(array('region_id'=>$lv['city']))->getField('region_name');
                $area = $region->where(array('region_id'=>$lv['area']))->getField('region_name');
                $list[$lk]['ctstr'] = $province.'  '.$city.'  '.$area;
            }
            $count = $deliver_address->where(array('uid'=>$this->cUid))->count();

            if(I('get.adid')){
                $info =$deliver_address->where(array('adid'=>I('get.adid')))->find();
                $ts = '修改';
            }elseif(!$list){
                $info = M('Member')->field('uid,province,city,area,phone,mobile,truename,address,postalcode')->where(array('uid'=>$this->cUid))->find();
                $ts = '新增';
            }else{
                $info['uid']=$this->cUid;
                $ts = '新增';
            }
            $this->ts=$ts;
            $this->info = $info;
            $this->count= $count;
            $this->yu = 20-$count;
            $this->list=$list;
            $this->display();
        }
    }
    /**
     * 地址删除
     * @return [type] [description]
     */
    public function del_deliver_address(){
        $deliver_address = M('deliver_address');
         $list = $deliver_address->where(array('uid'=>$this->cUid))->select();
        if(M('deliver_address')->delete(I('post.adid'))){
            echojson(array('status' => 1, 'info' => '添加成功','url'=>__SELF__));
        }else{
            echojson(array('status' => 0, 'info' => '添加成功','url'=>__SELF__));
        }
    }
    /**
     * 默认地址设置
     * @return [type] [description]
     */
    public function default_deliver_address(){
        $adid = I('post.adid');
        $deliver_address = M('deliver_address');
        if($deliver_address->where(array('adid'=>$adid))->setField('default',1)){
            $deliver_address->where(array('uid'=>$this->cUid,'adid'=>array('neq',$adid)))->setField('default',0);
            echojson(array('status' => 1, 'msg' => '已设置默认地址'));
        }else{
            echojson(array('status' => 0, 'msg' => '默认地址设置失败'));
        }
    }
    /**
     * 修改头像
     * @return [type] [description]
     */
    public function my_portrait(){
        if(IS_POST){
            $this->checkToken();
            $data=array(
                'uid'=>$this->cUid,
                'avatar'=>I('post.avatar')
                );
            if(M('Member')->save($data)){
                echojson(array('status' => 1, 'info' => '已修改','url'=>__SELF__));
            }else{
                echojson(array('status' => 0, 'info' => '修改失败','url'=>__SELF__));
            }
        }else{
            $my_info = M('Member')->where(array('uid'=>$this->cUid))->field(array('uid','avatar'))->find();

            $this->my_info = $my_info;
            $this->display();
        }
    }
    /**
     * 验证邮箱和手机号
     * @return [type] [description]
     */
    public function check(){
        $member = M('Member');
        $uid =$this->cUid; 
        if(IS_POST){
            // 设置好后跳转的页面
            if(I('post.pid')){
                $url=U('Auction/details',array('pid'=>I('post.pid')));
            }else{
                $url = U('Member/index');
            }
            // 邮箱验证码提交表单
            if(I('post.type')=='email'){
                $ve = M('verify_email')->where(array('email'=>I('post.email')))->find();
                $buid = $member->where(array('email'=>I('post.email')))->getField('uid');
                if($ve['losetime']<time()){
                    echojson(array('status' => 0, 'info' => "验证码已过期，请重新发送验证"));
                }
                if($ve['code'] == I('post.email_verify')){
                        $svdata = array('uid'=>$uid,'email'=>I('post.email'),'verify_email'=>1);
                        if($member->save($svdata)){
                            // 更新提醒字段
                            upalerttype($member,$uid,'email');
                            echojson(array('status' => 1, 'info' => "认证成功！",'url'=>$url));
                        }else{
                           echojson(array('status' => 0, 'info' => "验证保存失败，请与管理员联系")); 
                        }
                }else{
                    echojson(array('status' => 0, 'info' => "验证码错误，请检查"));
                }
            }
            // 手机验证码提交表单
            if(I('post.type')=='mobile'){
                $vm = M('verify_mobile')->where(array('mobile'=>I('post.mobile')))->find();
                $buid = $member->where(array('mobile'=>I('post.mobile')))->getField('uid');
                if($vm['losetime']<time()){
                    echojson(array('status' => 0, 'info' => "验证码已过期，请重新发送验证"));
                }
                if($vm['code'] == I('post.mobile_verify')){
                    $svdata = array('uid'=>$uid,'mobile'=>I('post.mobile'),'verify_mobile'=>1);
                    if($member->save($svdata)){
                        // 更新提醒字段
                        upalerttype($member,$uid,'mobile');
                        echojson(array('status' => 1, 'info' => "认证成功！",'url'=>$url));
                    }else{
                       echojson(array('status' => 0, 'info' => "验证保存失败，请与管理员联系")); 
                    }
                }else{
                    echojson(array('status' => 0, 'info' => "验证码错误，请检查"));
                }
            }
        }else{
            $info = $member->where(array('uid'=>$uid))->find();
            if(I('get.type')=='email'){
                $type ='email';
            }
            if(I('get.type')=='mobile'){
                $type ='mobile';
            }
            $this->pid = I('get.pid');
            $this->info=$info;
            $this->type=$type;
            $this->iswx=$iswx;
            $this->display();
        }
    }
	/**
	 * 修改密码
	 * @return [type] [description]
	 */
    public function reset_pwd(){
    	if(IS_POST){
    		$this->checkToken();
            echojson(D('Member')->reset_pwd($this->cUid));
        }else{
            $pwd = M('member')->where(array('uid'=>$this->cUid))->getField('pwd');
            if($pwd==''){
                $type = 'set';
            }else{
                $type = 'reset';
            }
            $this->type=$type;
        	$this->display();
        }
    }
    /**
     * 保证金
     * @return [type] [description]
     */
    public function pledge(){
        // 保证金账单
        $where = array('uid'=>$this->cUid);
        $pledge_bill = M('member_pledge_bill');
        $count = $pledge_bill->where($where)->count();
        $pConf = page($count,10);
        $bill = $pledge_bill->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        $this->page = $pConf['show'];
        $this->bill=$bill;
        // 保证金账户余额
        $where = array('uid'=>$this->cUid);
        $pledge=M('Member')->where($where)->field('wallet_pledge,wallet_pledge_freeze')->find();
        $pledge['usable'] = $pledge['wallet_pledge'] - $pledge['wallet_pledge_freeze'];
        $this->pledge=$pledge;
    	$this->display();
    }
    // 保证金取款申请
    public function pledge_take(){
        if(IS_POST){
            // $this->checkToken();
            $info = I('post.');
            $info['uid']=$this->cUid;
            $member = M('Member');
            $pledge = $member->where('uid='.$info['uid'])->field('wallet_pledge,wallet_pledge_freeze')->find();
            $takeMoney = $pledge['wallet_pledge'] - $pledge['wallet_pledge_freeze'];
            if(!$takeMoney<=0){
                if ($takeMoney>=$info['money']) {
                    $info['time'] =  time();
                    unset($info[C('TOKEN_NAME')]);
                    $info['business_id'] = $_SESSION['business_id'];
                    if($tid = M('member_pledge_take')->add($info)){
                        // 冻结账户提现金额
                        if($member->where('uid='.$info['uid'])->setInc('wallet_pledge_freeze',$info['money'])){
                            // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                            $pledge_data = array(
                                'order_no'=>createNo('sfr'),
                                'uid'=>$info['uid'],
                                'changetype'=>'extract_freeze',
                                'time'=>time(),
                                'annotation'=>'提现暂时冻结可用余额，等待提现完成扣除！',
                                'expend'=>$info['money'],
                                );
                            if(M('member_pledge_bill')->add($pledge_data)){
                                $pledge = $member->where('uid='.$info['uid'])->field('wallet_pledge,wallet_pledge_freeze')->find();
                                $usable = $pledge['wallet_pledge'] - $pledge['wallet_pledge_freeze'];
                                // 提醒通知卖家账户增加【
                                    // 微信提醒内容
                                    $wei_extract['tpl'] = 'walletchange';
                                    $wei_extract['msg']=array(
                                        "url"=>U('Home/Member/pledge','','html',true), 
                                        "first"=>"您好，".'申请提现冻结可用余额！',
                                        "remark"=>$pledge_data['annotation'].'查看账户记录>>',
                                        "keyword"=>array('余额账户','交易收入','订单:'.$pledge_data['order_no'],'-'.$pledge_data['money'].'元',$usable.'元')
                                    );
                                    // 账户类型，操作类型、操作内容、变动额度、账户余额
                                    // 站内信提醒内容
                                    $web_extract = array(
                                        'title'=>'提现冻结',
                                        'content'=>$pledge_data['annotation']
                                        );
                                    // 短信提醒内容
                                    if(mb_strlen($info['pname'],'utf-8')>10){
                                        $newname = mb_substr($info['pname'],0,10,'utf-8').'...';
                                    }else{
                                        $newname = $info['pname'];
                                    }
                                    $note_extract = $pledge_data['annotation'].'单号'.$pledge_data['order_no'].'。冻结【'.$pledge_data['money'].'元】，可用余额【'.$usable.'元】，您可以登陆平台查看账户记录。';
                                    // 邮箱提醒内容
                                    $mail_extract['title'] = '买家确认收货“'.$newname.'”';
                                    $mail_extract['msg'] = '您好：<br/><p>'.$pledge_data['annotation'].'单号'.$pledge_data['order_no'].'。冻结【'.$pledge_data['money'].'元】，可用余额【'.$usable.'元】。'.'</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';

                                    sendRemind($member,M('Member_weixin'),array(),array($info['uid']),$web_extract,$wei_extract,$note_extract,$mail_extract,'buy');
                                // 提醒通知卖家账户增加【
                                echojson(array("status" => 1, "info" => "已提交申请，等待退款",'url' => U('Member/pledge_take')));
                            } //写入用户账户记录
                        }else{
                            echojson(array("status" => 0, "info" => "冻结提现金额失败，请重试",'url' => U('Member/pledge_take')));
                        }
                        
                    }else{
                        echojson(array("status" => 0, "info" => "提交申请失败",'url' => U('Member/pledge_take')));
                    }
                }else{
                    echojson(array("status" => 0, "info" => "可提现金额不足！请检查！",'url' => U('Member/pledge_take')));
                }
            }else{
                echojson(array("status" => 0, "info" => "可提现金额为0元，不支持提现！",'url' => U('Member/pledge_take')));
            }
        }else{
            $where = array('uid'=>$this->cUid);
            // 保证金账户余额
            $pledge=M('Member')->where($where)->field('wallet_pledge,wallet_pledge_freeze')->find();
            $pledge['usable'] = $pledge['wallet_pledge'] - $pledge['wallet_pledge_freeze'];
            $this->pledge=$pledge;
            if(I('get.take')=='form'){
                $this->display('pledge_take_form');
            }else{
                $pledge_take = M('member_pledge_take');
                // 我的提现记录
                $count = $pledge_take->where($where)->count();
                $pConf = page($count,10);
                $this->take_list = $pledge_take->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
                $this->page = $pConf['show'];
                $this->display();
            }
            
        }
    }

    /**
     * 权限额度
     * @return [type] [description]
     */
    public function limsum(){
        // 保证金账单
        $where = array('uid'=>$this->cUid);
        $limsum_bill = M('member_limsum_bill');
        $count = $limsum_bill->where($where)->count();
        $pConf = page($count,10);
        $bill = $limsum_bill->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        $this->page = $pConf['show'];
        $this->bill=$bill;
        // 保证金账户余额
        $where = array('uid'=>$this->cUid);
        $limsum=M('Member')->where($where)->field('wallet_limsum,wallet_limsum_freeze')->find();
        $limsum['usable'] = $limsum['wallet_limsum'] - $limsum['wallet_limsum_freeze'];
        $this->limsum=$limsum;
        $this->display();
    }

    /**
     * 申购订单
     */
    public function crd_payment_order() {
        if(I('get.crd_no')!=''){
            $this->_crd_order(I('get.crd_no'));
            $this->_deliver_address($this->cUid);
            $this->_user_balance($this->oinfo['total_price']);
            $this->_payment_list();

            $this->display();
        }else{
            $this->error('不存在的订单号！');
        }
    }

    private function _crd_order($crd_no) {
        $oinfo = D('CrowdOrder')->where(array('crd_no' => $crd_no))->find();

        if($oinfo && $oinfo['status'] == 0) {
            $oinfo['delivery_fee'] = $oinfo['total_price'] - $oinfo['price'];
            $oinfo['item'] = D('CrowdItems')->details($oinfo['ciid']);

            $this->oinfo = $oinfo;
        } else {
            $this->error('订单号已失效或不存在的订单号！');
        }
    }

    /**
     * 订单支付
     * @return [type] [description]
     */
    public function payment_order(){
        if(I('get.order_no')!=''){
        // 订单信息读取【
            // 商品信息
            $order = M('goods_order');
            $bidmap = D('Auction');
            $goods_user = M('goods_user');
            $oinfo = $order->where(array('order_no'=>I('get.order_no')))->find();
            $this->_deliver_address($oinfo['uid']);
            if($oinfo&&$oinfo['status']==0){
                $oinfo['bidinfo']=$bidmap->field('pid,sid,type,bidnb,pname,nowprice,broker,onset,price,pictures,pledge_type,pledge,endtime')->where('pid ='.$oinfo['gid'])->find();
            }else{
                $this->error('订单号已失效或不存在的订单号！');
            }
            // 需要支付总额
            $oinfo['total'] = $oinfo['price'] + $oinfo['freight'];
        // 订单信息读取】

        // 是否可用缴纳的保证金支付【
            // 专场还是单品拍的条件
            if($oinfo['bidinfo']['sid']!=0){
                $special = M('special_auction')->where(array('sid'=>$oinfo['bidinfo']['sid']))->find();
                // 专场扣除模式且专场已结束
                if($special['special_pledge_type']==0&&$special['endtime']<=time()){
                    // 该用户拍到多少拍品
                    $cbidw = array('g-u'=>'s-u','uid'=>$oinfo['uid'],'gid'=>$oinfo['bidinfo']['sid'],'status'=>0);
                    $frezze = $goods_user->where($cbidw)->field('limsum,pledge')->find();
                    if($frezze['pledge']>0){
                        // 用户在专场拍到的拍品id
                        $spidarr = M('Auction')->where(array('sid'=>$oinfo['bidinfo']['sid']))->getField('pid',true);
                        // 是否全部支付
                        $paystaw = array(
                            'uid'=>$oinfo['uid'],
                            'gid'=>array('in',$spidarr),
                            'status'=>0
                        );
                        // 全部支付的话进行退还
                        $paysize = $order->where($paystaw)->count();
                        // 剩余最后一个未支付的话可以用保证金支付
                        if($paysize==1){
                           $paypledge = 1;
                        }else{
                            $paypledge = 0;
                        }
                    }else{
                        $paypledge = 0;
                    }
                }else{
                   // 获取支付拍品保证金金额
                    $frezze = $goods_user->where(array('g-u'=>'p-u','uid'=>$oinfo['uid'],'gid'=>$oinfo['gid'],'status'=>0))->field('limsum,pledge')->find();
                    if($frezze['pledge']>0){
                        $paypledge = 1;
                    }else{
                        $paypledge = 0;
                    }
                }
            }else{
                // 获取支付拍品保证金金额
                $frezze = $goods_user->where(array('g-u'=>'p-u','uid'=>$oinfo['uid'],'gid'=>$oinfo['gid'],'status'=>0))->field('limsum,pledge')->find();
                if($frezze['pledge']>0){
                    $paypledge = 1;
                }else{
                    $paypledge = 0;
                }
            }
            $oinfo['pledge'] = $frezze['pledge'];
            $oinfo['limsum'] = $frezze['limsum'];
            // 保证金足够抵货款，仅能使用保证抵货款
            if ($paypledge == 1 && $frezze['pledge']>=$oinfo['total']) {
                $onlypledge = 1;
            }else{
                $onlypledge = 0;
            // 是否可用缴纳的保证金支付】
                $this->_user_balance($oinfo['total']);
                $this->_payment_list();
            }
            $this->oinfo = $oinfo;
            $this->onlypledge = $onlypledge;
            $this->paypledge = $paypledge;
            $this->display();
        }else{
            $this->error('不存在的订单号！');
        }
    }

    private function _deliver_address($uid) {
        $address = M('deliver_address')->where(array('uid'=>$uid))->order('`default` desc')->select();
        if ($address) {
            $region = M('region');
            foreach ($address as $lk => $lv) {
                $province = $region->where(array('region_id'=>$lv['province']))->getField('region_name');
                $city = $region->where(array('region_id'=>$lv['city']))->getField('region_name');
                $area = $region->where(array('region_id'=>$lv['area']))->getField('region_name');
                $address[$lk]['ctstr'] = $province.'  '.$city.'  '.$area;
            }
            $this->address=$address;
        }else{
            $this->error('请完善您的地址信息！',U('Member/deliver_address'));
        }
    }

    private function _user_balance($total) {
        $member = M('Member');
        $ufield=array('wallet_pledge','wallet_pledge_freeze');
        $uLimit = $member->where(array('uid'=>$this->cUid))->field($ufield)->find();
        // 可用余额
        $uLimit['usable'] = $uLimit['wallet_pledge']-$uLimit['wallet_pledge_freeze'];
        $uLimit['usable'] = $uLimit['usable'] > 0 ? sprintf("%.2f", $uLimit['usable']) : 0;
        // 用户可用余额】
        // 余额是否足够支付【
        if($total <= $uLimit['usable']){
            $uLimit['yfmn'] = sprintf("%.2f", $total);
            $uLimit['satisfy'] = 'y';
        }else{
            $uLimit['yfmn'] = sprintf("%.2f",$uLimit['usable']);
            $uLimit['satisfy'] = 'n';
        }
        $this->uLimit = $uLimit;
    }

    private function _payment_list() {
        foreach (C('payment.list') as $pk => $pv) {
            if($pv['status']){
                $pv['value'] = $pk;
//                if(is_weixin()){
//                    if($pv['arena']=='jsapi'){
//                        $channel[] = $pv;
//                    }
//                }else{
                    if(ismobile()){
                        if($pv['arena']=='wap'||$pv['arena']=='all'){
                            $channel[] = $pv;
                        }
                    }else{
                        if ($pv['arena']=='pc'||$pv['arena']=='all') {
                            $channel[] = $pv;
                        }
                    }
                //}
            }
        }
        $this->channel = $channel;
    }

    /**
     * 充值保证金
     * @return [type] [description]
     */
    public function payment(){
        // var_dump($_SESSION);
        // 获取支付类型
        $use=I('get.use');
        $bill=I('get.bill');

        $this->od_url=U('Home/Member/pledge');
        //读取支付配置
         $paymentList=C('payment.list');
        if(ismobile()&&!is_weixin()){
             unset($paymentList['WX_NATIVE']);
        }       
        foreach ($paymentList as $pk => $pv) {
            if($pv['status']){
                $pv['value'] = $pk;

                if ($pv['arena']=='pc'||$pv['arena']=='all') {
                    $channel[] = $pv;
                }
                // var_dump($pv);exit();

                // if(is_weixin()){
                //     if($pv['arena']=='jsapi'){
                //         $channel[] = $pv;
                //     }
                // }else{
                //     if(ismobile()){
                //         if($pv['arena']=='wap'||$pv['arena']=='all'){
                //             $channel[] = $pv;
                //         }

                //     }else{
                //         if ($pv['arena']=='pc'||$pv['arena']=='all') {
                //             $channel[] = $pv;
                //         }

                //     }
                // }
            }
        }
        $mon =  I('get.mon');
        $this->mon = $mon==""?1:$mon;
        $this->bill = $bill==""?1:$bill;
        $this->isweixin = false;

        if(is_weixin()){

            $ff = new Paywechat();
            $data = $ff->payByJsWechat('充值余额',$this->bill,$this->mon*100,'产品简介','http://www.fjsxpmh.com/Index/wechatreturn');
            $this->jsApiParameters = $data['jsApiParameters'];
            $this->editAddress = $data['editAddress'];
            $this->isweixin = true;
        }else{

            $ff = new Paywechat();
            $url = $ff->createQrUrl('充值余额',$bill,$mon*100,'产品简介','NATIVE','12321412412','http://www.fjsxpmh.com/Index/wechatreturn');
            $this->qrcodeurl = $url;

        }


        $this->channel=$channel;
        // var_dump($channel);exit();
        $this->display();
    }

    // ------地区标签使用
    public function region(){
        if (IS_POST) {
            $region = M('region');
            $field = array('region_id','region_name');
            if (I('post.tier') == 1) {
                $tier = 2;
                $selected = '——选择城市——';
            }elseif (I('post.tier') == 2) {
                $tier = 3;
                $selected = '——选择区、县——';
            }
            $option = $region->field($field)->where(array('parent_id'=>I('post.pid')))->select();
            $optionHtml = '<option selected="selected" tier="'.$tier.'" value="0">'.$selected.'</option>';
            foreach ($option as $ok => $ov) {
                $optionHtml .= '<option tier="'.$tier.'" value="'.$ov['region_id'].'">'.$ov['region_name'].'</option>';
            }
            echojson(array('status' => 1, 'msg' => $optionHtml)); 
        }
    }
    // --------关注和取消关注处理
    public function attention(){
        if (IS_POST) {
            $att = M('attention');
            $data = array(
                'gid'=>I('post.gid'),
                'rela'=>I('post.rela'),
                'uid'=>$this->cUid
            );
            if(I('post.yn')=='n'){
                if($att->add($data)){
                    echojson(array('status' => 1, 'msg' => '关注成功'));  
                }else{
                    echojson(array('status' => 0, 'msg' => '关注失败，请刷新页面重试'));
                } 
            }elseif(I('post.yn')=='y'){

                if($att->where($data)->delete()){
                    echojson(array('status' => 1, 'msg' => '已取消关注'));  
                }else{
                    echojson(array('status' => 0, 'msg' => '取消关注失败，请刷新页面重试'));
                } 
            }
        }
    }
    // 消息站内信
    public function mysms(){
        

        if (IS_POST) {
            $mysms = M('mysms');
            $sid=I('post.sid');
            $where = array('sid'=>array('in',$sid));
            if(I('post.ac')=='del'){
                $count = M('mysms')->where($where)->setField('delmark',1);
                $t = '删除';
            }elseif(I('post.ac')=='read'){
                $count = $mysms->where($where)->setField('status',1);
                $t = '设置已读';
            }
            if($count){
                echojson(array("status" => 1, "info" => $t."成功",'url' => __SELF__));
            }else{
                echojson(array("status" => 0, "info" => $t."失败，请重试",'url' => __SELF__));
            }
        }else{
            $mysms = M('mysms');
            $auction = D('Auction');
            // 用户消息
            $ucwer['_string']="(aid != 0 and uid=".$this->cUid.") or (uid=".$this->cUid." and sendid != 0)";
            // 系统消息
            $scwer = array('uid'=>$this->cUid,'sendid'=>0,'aid'=>0);
            $where = $scwer;
            if(I('get.tp')=='usend'){
                $where = $ucwer;
            }else{
                $where = $scwer;
            }
            // 统计未读
            $ucwer['status'] = 0;
            $ucwer['delmark'] = 0;
            $scwer['status'] = 0;
            $scwer['delmark'] = 0;
            $this->sc = $mysms->where($scwer)->count();
            $this->uc = $mysms->where($ucwer)->count();

            // 读取列表到页面
            $where['delmark']=0;
            $count = $mysms->where($where)->count();

            $pConf = page($count,20);
            $slist = $mysms->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
            $member = M('member');
            foreach ($slist as $k => $v) {
                $slist[$k]['user']=$member->where(array('uid'=>$v['sendid']))->field('account,nickname')->find();
                if($v['pid']){
                    $slist[$k]['auction'] = $auction->where(array('pid'=>$v['pid']))->field('pid,pname')->find();
                }
            }
            $this->tp=I('get.tp');
            $this->slist=$slist;
            $this->page = $pConf['show'];
            $this->display(); 
        }
    }
    public function mysmssdf(){
        $mysms = M('mysms');
        if (IS_POST) {
            $sid=I('post.sid');
            foreach ($sid as $pk => $pv) {
                if($mysms->where('sid='.$pv)->delete()){
                   $dcount+=1; 
                }
            }
            if($dcount==count($sid)){
                echojson(array("status" => 1, "info" => "删除成功",'url' => U('Member/mysms', array('time' => time()))));
            }else{
                echojson(array("status" => 0, "info" => "删除失败，请重试",'url' => U('Member/mysms', array('time' => time()))));
            }
        }else{
            // 设置为已读
            $smsid=$mysms->where(array('uid'=>$this->cUid))->getField('sid',true);
            foreach ($smsid as $smk => $smv) {
                $mysms->where('sid='.$smv)->setField('status',1);
            }
            // 读取列表到页面
            $count = $mysms->where(array('uid'=>$this->cUid))->count();
            $pConf = page($count,20);
            $slist = $mysms->where(array('uid'=>$this->cUid))->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
            $this->slist=$slist;
            $this->page = $pConf['show'];
            $this->display(); 
        }
    }
    // 关注列表
    public function myatt(){
        $att = M('attention');
        $bidmap = D('Auction');
        $member =M('member');
        $nowTime=time();
        // 关注的拍卖
        if(I('get.type') == 'pm'){
            
            $inPid = $att->where(array('rela'=>'p-u','uid'=>$this->cUid))->getField('gid',true);
            $swhere = array('pid'=>array('in',$inPid));
            if(I('get.st')=='future'){
                // 未开始
                $swhere['starttime'] = array('gt',$nowTime);
                $st = 'future';
            }elseif (I('get.st')=='end') {
                // 已结束
                $swhere['endtime']=array('elt',$nowTime);
                $st = 'end';
            }else{
                // 正在拍
                $swhere['starttime']=array('elt',$nowTime);
                $swhere['endtime']=array('egt',$nowTime);
                $st = 'ing';
            }
            // 分页配置
            $count = $bidmap->where($swhere)->count();
            $pConf = page($count,5);
            $alist = $bidmap->where($swhere)->limit($pConf['first'].','.$pConf['list'])->select();
            foreach ($alist as $ak => $av) {
                $alist[$ak]['nickname']=nickdis($member->where(array('uid'=>$av['uid']))->getField('nickname'));
            }
            $this->alist=$alist;
            $this->st=$st;
            $this->page = $pConf['show'];
            $this->display('myatt');
        // 关注的一口价
        }elseif (I('get.type') == 'ykj') {
            $glist = $att->where(array('rela'=>'g-u','uid'=>$this->cUid))->select();
            $this->alist=$alist;
            $this->display('myatt_goods');
        }
    }
    // 我的出价
    public function mybid(){
        $auction_record = M('auction_record');
        $bidmap = D('Auction');
        $member =M('member');
        $nowTime=time();

        $inPid = $auction_record->where(array('uid'=>$this->cUid))->getField('pid',true);
        $inPid = array_flip(array_flip($inPid));
        $swhere = array('pid'=>array('in',$inPid));
        if(I('get.st')=='end') {
            // 已结束
            $swhere['endtime']=array('elt',$nowTime);
            $st = 'end';
        }else{
            // 正在拍
            $swhere['starttime']=array('elt',$nowTime);
            $swhere['endtime']=array('egt',$nowTime);
            $st = 'ing';
        }
        // 分页配置
        $count = $bidmap->where($swhere)->count();
        $pConf = page($count,5);
        $alist = $bidmap->where($swhere)->limit($pConf['first'].','.$pConf['list'])->order('endtime desc')->select();
        foreach ($alist as $ak => $av) {
            $alist[$ak]['nickname']=nickdis($member->where(array('uid'=>$av['uid']))->getField('nickname'));
        }
        $this->alist=$alist;
        $this->st=$st;
        $this->page = $pConf['show'];
        $this->display();
    }
    // -----我的出价记录
    public function mybid_list(){
        $record = M('auction_record');
        $where = array('pid'=>I('get.pid'),'uid'=>$this->cUid);
        $count = $record->where($where)->count();
        $pConf = page($count,10);
        $list = $record->where($where)->limit($pConf['first'].','.$pConf['list'])->select();
        $this->list=$list;
        $this->page = $pConf['show'];
        $this->display();
    }
    // 我的拍到的
    public function mysucc(){
        $order = M('goods_order');
        $bidmap = D('Auction');
        $member = M('member');
        $express = M('express');
        $where = array('uid'=>$this->cUid);
        if(I('get.st')!=''){
            $where['status']=I('get.st');
        }
        $count = $order->where($where)->count();
        $pConf = page($count,5);
        $alist = $order->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        foreach ($alist as $a => $av) {
            $alist[$a]['total'] = $av['price']+$av['freight'];
            $alist[$a]['bidinfo']= $bidmap->where('pid ='.$av['gid'])->find();
            $alist[$a]['bidinfo']['organization']=$member->where(array('uid'=>$av['sellerid']))->getField('organization');
            if($alist[$a]['express']!=''){
                $alist[$a]['express']= $express->where(array('en'=>$alist[$a]['express']))->getField('ch');
            }else{
                $alist[$a]['express'] = $alist[$a]['express_other'];
            }
        }
        $this->alist=$alist;
        $this->whopage=array('name'=>'我拍到的','action'=>'mysucc','seller'=>0,'type'=>'buy');
        $this->st = I('get.st');
        $this->page = $pConf['show'];
        $this->display('order');
    }
    // 我申购到的
    public function mycrowd(){
        $express = M('express');

        $where = array('uid'=>$this->cUid);
        if(I('get.st')!=''){
            $where['status']=I('get.st');
        }
        $count = D('CrowdOrder')->where($where)->count();
        $pConf = page($count,5);

        $alist = D('CrowdOrder')->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        foreach ($alist as $a => $av) {
            $alist[$a]['item'] = M('Goods')->where(array('id' => $av['gid']))->find();
            $alist[$a]['delivery_fee'] = $av['total_price'] - $av['price'];
            if($alist[$a]['express']!=''){
                $alist[$a]['express']= $express->where(array('en'=>$alist[$a]['express']))->getField('ch');
            }else{
                $alist[$a]['express'] = $alist[$a]['express_other'];
            }
        }
        $this->alist=$alist;
        $this->whopage=array('name'=>'我申购到的','action'=>'mycrowd','seller'=>0,'type'=>'buy');
        $this->st = I('get.st');
        $this->page = $pConf['show'];
        $this->display('mycrowd');
    }

    //我的积分兑换
    public function mypoint(){
        $express = M('express');

        $where = array('uid'=>$this->cUid);
        if(I('get.st')!=''){
            $where['status']=I('get.st');
        }
        $count = D('point_order')->where($where)->count();
        $pConf = page($count,5);


        $alist = D('point_order')->where($where)->limit($pConf['first'].','.$pConf['list'])->order('createtime desc')->select();
        

        // // var_dump($where);exit();
        foreach ($alist as $a => $av) {
            if(intval($av['type'])==1){
                $alist[$a]['item'] = M('point_course')->where(array('id' => $av['ggid']))->find();
            }else{
                $alist[$a]['item'] = M('point_gift')->where(array('id' => $av['ggid']))->find();
            }
            
            // $alist[$a]['delivery_fee'] = $av['total_price'] - $av['price'];
            // if($alist[$a]['express']!=''){
            //     $alist[$a]['express']= $express->where(array('en'=>$alist[$a]['express']))->getField('ch');
            // }else{
            //     $alist[$a]['express'] = $alist[$a]['express_other'];
            // }
        }
        // var_dump($alist);exit();
        $this->alist=$alist;
        $this->whopage=array('name'=>'我申购到的','action'=>'mypoint','seller'=>0,'type'=>'buy');
        $this->st = I('get.st');
        $this->page = $pConf['show'];
        $this->display('mypoint');
    }

    // 订单详情
    public function order_details(){
        $order_no = I('get.order_no');
        $bidmap = D('Auction');
        $member = M('member');
        $express = M('express');
        $oinfo = M('goods_order')->where(array('order_no'=>$order_no))->find();
        $oinfo['pname'] = M('auction')->where(array('pid'=>$oinfo['gid']))->getField('pname');
        // 订单详情
        $oinfo['total'] = $oinfo['price']+$oinfo['freight'];
        $oinfo['bidinfo']= $bidmap->where('pid ='.$oinfo['gid'])->find();
        $oinfo['bidinfo']['organization']=$member->where(array('uid'=>$oinfo['sellerid']))->getField('organization');
        // 快递查询
        if(in_array($oinfo['status'], array(2,3))){
            if($oinfo['express']!='*'){
                $oinfo['exphtml']=getExpressHtml($oinfo['express'],$oinfo['express_no']);
            }else{
                $oinfo['exphtml']=array('status'=>2,'html'=>'<div class="buneng">快递不支持物流跟踪，请联系卖家获取物流动态！</div>');
            }
        }
        // 买家地址
        $oinfo['address']=unserialize($oinfo['address']);
        if ($oinfo['status']==0) {
            $oinfo['buy_info'] = M('member')->where(array('uid'=>$oinfo['uid']))->field('nickname,truename,mobile,verify_mobile')->find();
        }
        if($oinfo['express']!=''){
            $oinfo['express']= $express->where(array('en'=>$oinfo['express']))->getField('ch');
        }else{
            $oinfo['express'] = $oinfo['express_other'];
        }
        // 该订单属于卖家或买家【
        if ($oinfo['sellerid']==$this->cUid || $oinfo['uid']==$this->cUid) {
            if($oinfo['sellerid']==$this->cUid){
                $seller = 1;
            }else{
                $seller = 0;
            }
        }else{
            $this->error('页面不存在！');
        }
        $this->seller=$seller;
        // 该订单属于卖家或买家】
        $this->oinfo=$oinfo;
        $this->display();
    }
    public function testreturn(){
    }
    
        // 确认收货
    public function receipt(){
        if (IS_POST) {
            if(D('Payment')->order_from_by(I('post.order')) == 'zc') {
                $co = D('crowd_order')->where(array('crd_no'=>I('post.order'),'uid'=>$this->cUid))->field('total_price,status')->find();
                if($co && $co['status'] != 3){
                    if(D('crowd_order')->where(array('crd_no'=>I('post.order')))->setField(array('status'=>3,'time3'=>time()))){
                        // 订单状态提醒【
                        sendOrderRemind(I('post.order'));
                        $staz = M('member')->where(array('uid'=>$_SESSION['uid']))->setInc('point',$co['total_price']/10);
                        echojson(array('status' => 1, 'msg' => '已确认收货','url'=>U('Member/mycrowd',array('st'=>3))));
                    }else{
                        echojson(array('status' => 0, 'msg' => '操作失败请重试，请刷新页面重试'));
                    }
                }else{
                    echojson(array('status' => 0, 'msg' => '操作失败请重试，请刷新页面重试'));
                }
            } else {
                $order = M('goods_order');
                $go = $order->where(array('order_no'=>I('post.order'),'uid'=>$this->cUid))->find();
                // var_dump($go);
                if($go){
                    // 买家默认好评过期时间
                    if(C('Order.losetime4')==0||C('Order.losetime4')==''){
                        $deftime4 = 0;
                    }else{
                        $losetime4=C('Order.losetime4');
                        $deftime4 = time()+(60*60*24*$losetime4);
                    }
                    // 设置已收货、和评价时间
                    if($order->where(array('order_no'=>I('post.order')))->setField(array('status'=>3,'time3'=>time(),'deftime4'=>$deftime4))){
                        // 账户收入增加并给卖家发送提醒
                        income_send_sell(I('post.order'));
                        // 订单状态提醒【
                        sendOrderRemind(I('post.order'));
                        // 订单状态提醒【
                        // var_dump($go['price']);
                        $staz = M('member')->where(array('uid'=>$_SESSION['uid']))->setInc('point',$go['price']/10);
                        // var_dump( M('member')->getDbError());exit();
                        echojson(array('status' => 1, 'msg' => '已确认收货','url'=>U('Member/mysucc',array('st'=>3))));
                    }else{
                        echojson(array('status' => 0, 'msg' => '操作失败请重试，请刷新页面重试'));
                    }
                }else{
                    echojson(array('status' => 0, 'msg' => '操作失败请重试，请刷新页面重试'));
                }
            }
        }else{
            $this->error('页面不存在',U('Member/mysucc',array('st'=>2)));
        }
    }

    // 账号管理

    public function set_account(){
        $this->display();
    }
    // 绑定web版账号
    public function bound_web(){
        $member = M('Member');
        $uid =$this->cUid; 
        if(IS_POST){
            // 邮箱验证码提交表单
            if(I('post.type')=='email'){
                $ve = M('verify_email')->where(array('email'=>I('post.email')))->find();
                if($ve['losetime']<time()){
                    echojson(array('status' => 0, 'info' => "验证码已过期，请重新发送验证"));
                }
                if($ve['code'] == I('post.email_verify')){
                    // 获取要绑定的账户id
                    $newacc = $member->where(array('email'=>I('post.email')))->field('uid,pwd')->find();
                }else{
                    echojson(array('status' => 0, 'info' => "验证码错误，请检查"));
                }
            }
            // 手机验证码提交表单
            if(I('post.type')=='mobile'){
                $vm = M('verify_mobile')->where(array('mobile'=>I('post.mobile')))->find();
                if($vm['losetime']<time()){
                    echojson(array('status' => 0, 'info' => "验证码已过期，请重新发送验证"));
                }
                if($vm['code'] == I('post.mobile_verify')){
                    // 获取要绑定的账户id
                    $newacc = $member->where(array('mobile'=>I('post.mobile')))->field('uid,pwd')->find();
                }else{
                    echojson(array('status' => 0, 'info' => "验证码错误，请检查"));
                }
            }
            $weixin = M('member_weixin');
            // 获取当前微信openid
            $openid = $weixin->where(array('uid'=>$uid))->getField('openid');
            // 绑定web版账号
            if($weixin->where(array('openid'=>$openid))->setField('uid',$newacc['uid'])){
                // 退出当前登陆后重新发送cookie
                $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
                $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
                $shell = $newacc['uid'] . md5($newacc['pwd'] . C('AUTH_CODE'));
                $_SESSION[$loginMarked] = $shell;
                $shell.= "_" . time();
                // 发送cookie
                setcookie($loginMarked, $shell, time()+$systemConfig['TOKEN']['member_timeout'], "/");
                echojson(array('status' => 1, 'info' => "绑定成功！",'url'=>U('Member/index')));
            }else{
               echojson(array('status' => 0, 'info' => "绑定失败，请与管理员联系")); 
            }

        }else{
            $info = $member->where(array('uid'=>$uid))->find();
            if(I('get.type')!=''){
                $type=I('get.type');
            }else{
                $type = 'mobile';
            }
            $this->info=$info;
            $this->type=$type;
            $this->display();
        }
    }
    // 快递查询
    public function showExpress(){
        if(I('get.type')=='deliver'){
            $from = D('Payment')->order_from_by(I('get.order_no'));
            if($from == 'zc') {
                $odinfo = D('crowd_order')->where(array('crd_no'=>I('get.order_no')))->find();
            } else if($from == 'pm') {
                $odinfo = M('goods_order')->where(array('order_no'=>I('get.order_no')))->find();
            }
        }elseif(I('get.type')=='return'){
            $odinfo = M('goods_order_return')->where(array('order_no'=>I('get.order_no')))->find();
        }else{
            $this->error('页面不存在！');
        }
        if($odinfo){
            if($odinfo['express']!='*'){
                $info=getExpressHtml($odinfo['express'],$odinfo['express_no']);
            }else{
                $info=array('status'=>2,'html'=>'<div class="buneng">快递不支持物流跟踪，请联系卖家获取物流动态！</div>');
            }
            $this->info=$info;
        }else{
            $this->error('订单不存在！');
        }
        $this->display('showExpress');
    }
    /**
     +----------------------------------------------------------
     * 卖家操作
     +----------------------------------------------------------
     */
     // 待发布拍卖
     public function goodsList(){
        $channel = M('goods_category')->where('pid=0')->select(); //读取频道
        $this->channel=$channel; //分配频道
        $M = M("Goods");

        $where=array('sellerid'=>$this->cUid);
        $gidarr = D("Auction")->where($where)->getField('gid',true);
        if($gidarr){
            $where['id']=array('not in',$gidarr);
        }
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list'],$where);
        C('TOKEN_ON',false);
        $this->display();
     }
     //------删除商品
    public function del_goods() {
        $goods = M("Goods");
        $where = array('id'=>I('get.id'));
        if($goods->where($where)->getField('sellerid')==$this->cUid){
            $pictures = $goods->where($where)->getField('pictures');
            $picarr = explode('|', $pictures);
            $fixct = count(explode(',', C('GOODS_PIC_PREFIX')));
            $imgDelUrl = C('UPLOADS_PICPATH');
            foreach ($picarr as $pk => $pv) {
                $fixkey = 0;
                for ($i=0; $i < $fixct; $i++) { 
                    @unlink($imgDelUrl.picRep($pv,$i));
                }
                @unlink($imgDelUrl.$pv);
            }
            if ($goods->where($where)->delete()) {
                $this->success("成功删除");
               // echojson(array("status"=>1,"info"=>""));
            } else {
                $this->error("删除失败，可能是不存在该ID的记录");
            }
        }else{
            $this->error("删除失败，请刷新页面重试！");
        }
    }
     //异步获取频道下分类
    public function getcate(){
        $pid=I('post.pid');
        $cateHtml='';
        if($pid!=''){
            $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
            $cate=$cat->getList(NULL, $pid,NULL);
            $cateHtml='<dl id="cid_select"><select name="cid"><option value="">所有分类</option>';
            foreach ($cate as $ck => $cv) {
                $cateHtml.='<option value="'.$cv['cid'].'">'.$cv['fullname'].'</option>';
            }
            $cateHtml.='</select></dl>';
        }
        echojson(array("status" => 1, "htm" => $cateHtml));
    }
    // 搜索商品
        public function searchGoods(){
            $where=array('sellerid'=>$this->cUid);
            $keyW = I('get.');
            $encode = mb_detect_encoding($keyW['keyword'], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            $keyW['keyword'] = iconv($encode,"utf-8//IGNORE",$keyW['keyword']);
            $cate=M('Goods_category');
            if($keyW['pid']!=''){
                $chname=  $cate->where('cid='.$keyW['pid'])->getField('name');
                if($keyW['cid']==''){
                    $keyW['cid']=array();
                    $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                    $catecid = $cat->getList(NULL, $keyW['pid'],NULL);
                    foreach ($catecid as $cik => $civ) {
                        $keyW['cid'][$cik]=$civ['cid'];
                    }
                    array_push($keyW['cid'], $keyW['pid']); //将频道添加到条件
                    $where['cid'] = array('in',$keyW['cid']);
                    $catname = '所有'; 
                }else{
                    if($keyW['cid']!=''){
                        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                        $catecid = $cat->getList(NULL,$keyW['cid']);
                        foreach ($catecid as $cak => $cav) {
                            $catecid[$cak]=$cav['cid'];
                        }
                        $catecid[]=$keyW['cid'];
                        $where['cid'] = array('in',$catecid);
                        $catname = $cate->where('cid='.$keyW['cid'])->getField('name');
                    }else{
                        $catname = '所有'; 
                    }
                }
            }else{
                $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                $catecid = $cat->getList(NULL, 0);
                foreach ($catecid as $cik => $civ) {
                    $catecid[$cik]=$civ['cid'];
                }
                $where['cid'] = array('in',$catecid);
                $chname = '所有';
                $catname = '所有'; 
            }
            if($keyW['keyword'] != '') $where['title'] = array('LIKE', '%' . $keyW['keyword'] . '%');
            $M = M("Goods");
            $count = $M->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            
            $channel = $cate->where('pid=0')->select(); //读取频道
            $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'chname' => $chname,'catname' => $catname,'pid'=>$keyW['pid']);
            $this->keys = $keyS;
            $this->page = $pConf['show'];
            
            $this->channel=$channel; //分配频道

            $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list'],$where);
            C('TOKEN_ON',false);
            $this->display('goodsList');
    }

     // 发布商品
    public function addGoods() {
        if (IS_POST) {
            echojson(D("Goods")->addEdit('add',$this->cUid));
        } else {
            $uinfo = M('Member')->where(array('uid'=>$this->cUid))->find();
            if ($uinfo['organization']=='') {
                $this->error('请先完善卖家信息！',U('Member/imseller'));
            }
            $describe = include APP_PATH . 'Common/Conf/FieldsDescribe.php';
            $info=array(
                'province'=>$uinfo['province'],
                'city'=>$uinfo['city'],
                'area'=>$uinfo['area'],
                'layer'=>C('goods_region'),
                'content'=>stripslashes($describe['FIELDS_DESCRIBE'])
            ); //获取地区的层数并分配
            $this->info=$info;
            $this->assign("list", D("Goods")->category());
            $this->display('addGoods');
        }

    }
    // 编辑商品
    public function editGoods() {
        $M = M("Goods");
        $pid=I('get.pid');
        if (IS_POST) {
            echojson(D("Goods")->addEdit('edit',$this->cUid,$pid));
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            if ($info['pictures']) {
                $info['pictures'] = explode('|', $info['pictures']);
            }
            $info['seller'] = M('member')->where(array('uid'=>$info['sellerid']))->field('account,nickname,avatar')->find();
            $info['content']=stripslashes($info['content']);
            $info['layer']=C('goods_region'); //获取地区的层数并分配
            $this->pid=$pid;
            $this->assign("info", $info);
            $this->assign("list", D("Goods")->category());
            $this->display("addGoods");
        }
    }
    //------异步排序商品图片
    public function goodPicOrder(){
        C('TOKEN_ON',false);
        if (IS_POST) {
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => I('post.imgArr')
                );
            if(M('Goods')->save($data)){
                echojson(array('status' => 1, 'msg' => "排序成功，已保存到数据库"));
            }else{
                echojson(array('status' => 0, 'msg' => "排序失败，请刷新页面尝试操作"));
            }
        }
    }
    //------获取组合后的下级条件
    public function getChild(){
        if (IS_POST) {
            if(I('post.fid') != ''){
                echojson(array('status' => 1, 'msg' => getChildHtml(I('post.fid'))));
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
    // ------通过分类cid获取对应筛选条件
    public function getFilt(){
        echojson(array("status" => 1, "html" => getFiltrateHtmlSeller(I('post.cid'),I('post.filtStr'))));
    }
    // ------通过分类cid获取对应扩展字段
    public function getExtends(){
        $rtdata=getExtendsHtml(I('post.cid'),I('post.gid'));
        echojson(array("status" => 1, "ulhtml" => $rtdata['eUrlHtml'],"divhtml" => $rtdata['eDivHtml'],'textarr'=>$rtdata['textarea'],'region'=>$rtdata['region']));
    }
    //------异步删除商品图片
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $goodsId = I('post.goodsId'); //商品ID
        if($goodsId){
            $goods = M('Goods');
            $gd_pic = $goods->where(array('id'=>$goodsId))->find();
            //组合要写入数据
            $newPic = str_replace('||','|',trim(str_replace($imgUrl, '', $gd_pic['pictures']),'|'));
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => $newPic
                );

            if($goods->save($data)){
                $ecJson = array(
                    'status' => 1,
                    'msg' => '删除成功!'
                    );
                @unlink($imgDelUrl);
                //循环删除缩略图
                $picFix = explode(',',C('GOODS_PIC_PREFIX'));
                foreach ($picFix as $pfK => $pfV) {
                    @unlink( C('UPLOADS_PICPATH').picRep($imgUrl,$pfK));
                }
                //输出结果
                echojson($ecJson);
            }else{
                $ecJson = array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    );
                echojson($ecJson);
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从服务器删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '删除失败，请检查文件权限!'
                ));
            }
            
        }
    }

    public function crowdAuction() {
        $order = D('Auction')->where(array('crd_no' => I('get.crd_no')))->field('pid')->find();
        if(isset($order['pid'])) {
            $this->redirect(U('Auction/details',array('pid' => $order['pid'])));
        } else {
            $this->error("页面不存在！");
        }
    }

    // 发布拍卖
    public function addAuction() {
        if (IS_POST) {// 冻结卖家保证金
            $info = I('post.info');
            if(empty($info['crd_no'])) {
                echojson(D('Auction')->addEdit('add', $this->cUid));
            } else {
                echojson(D('AuctionAudit')->addEdit('add', $this->cUid));
            }
        }else{
            $uid = $this->cUid;
            // 验证保证金是否足够发布拍卖
            $uLimit = D('auction')->check_freeze_pledge($uid);
            $this->uLimit=$uLimit;

            if(!$uLimit['yn']){
                $this->display('ulimit');
            } else {
                $info['to'] = I('get.to') ? I('get.to') : 'js';
                if(I('get.crd_no')) {
                    $order = D('CrowdOrder')->where(array('crd_no' => I('get.crd_no'), 'uid' => $this->cUid))->field('gid')->find();
                    $info['gid'] = isset($order['gid']) ? $order['gid'] : 0;
                    $info['crd_no'] = I('get.crd_no');
                    $where = array('id' => $info['gid']);
                } else {
                    $info['gid'] = I('get.gid');
                    $where = array('id'=>$info['gid'], 'sellerid'=>$uid);
                }
                $gdata = M('Goods')->where($where)->field('title,price,description,sellerid')->find();
                if(empty($gdata)) {
                    $this->error("页面不存在！");
                }
                if($gdata){
                    $bidcof=C('Auction');
                    $info['pname'] = $gdata['title'];
                    $info['onset'] = $gdata['price'];
                    $info['price'] = $gdata['price'];
                    // 专场数据分配到模板
                    if($info['to']=='zc'){
                        $biding = bidType('biding',1);
                        $future = bidType('future',1);
                        $special = M('special_auction');
                        $bidingList = $special->where($biding['bidType'])->order('sid desc')->select();
                        $futureList = $special->where($future['bidType'])->order('sid desc')->select();
                        $this->bidingList=$bidingList;
                        $this->futureList=$futureList;
                    }
                    // 拍卖会数据分配到模板
                    if($info['to']=='pmh'){
                        $biding = bidType('biding',2);
                        $future = bidType('future',2);
                        $meeting = M('meeting_auction');
                        // $bidingList = $meeting->where($biding['bidType'])->order('mid desc')->select();
                        $futureList = $meeting->where($future['bidType'])->order('mid desc')->select();
                        // $this->bidingList=$bidingList;
                        $this->futureList=$futureList;
                    }
                    $info = array_merge($info,$bidcof);
                    $this->info=$info;
                    // 微信推送数据【
                    $this->weixin=array('name'=>$gdata['title'],'comment'=>$gdata['description']);
                    // 微信推送数据】
                    $this->display('addAuction');
                }else{
                    $this->error('商品不存在！');
                }
            }
        }
    }

    public function editAuction() {
        if (IS_POST) {
            echojson(D('Auction')->addEdit('edit',$this->cUid));
        }else{
            $auction = M('Auction');
            $uid = $this->cUid;
            $info = $auction->where(array('pid'=>I('get.pid')))->find();
            if(!$info){
                $this->error('拍品ID不存在！');
                exit;
            }
            if($info['bidcount']!=0){
                $this->error('当前拍品已有人出价，您不能进行编辑！');
                exit;
            }
            $bidcof=C('Auction');
            // 处理保证金
            if($info['pledge_type'] == 'ratio'){
                $info['pledge_ratio'] = $info['pledge'];
                //分配定额默认设置
                $info['pledge_fixation'] = $bidcof['pledge_fixation'];
            }elseif ($info['pledge_type'] == 'fixation') {
                $info['pledge_fixation'] = $info['pledge'];
                //分配比例默认设置
                $info['pledge_ratio'] = $bidcof['pledge_ratio'];
            }
            // 处理价格浮动
            if($info['stepsize_type'] == 0){
                $stepsize = explode(',', $info['stepsize']);

                $info['stepsize_ratio'] = $stepsize[0];
                $info['stepsize_ratio_r'] = $stepsize[1];
                $info['stepsize_ratio_s'] = $stepsize[2];
                $info['stepsize_ratio_t'] = $stepsize[3];
                //分配定额默认设置
                $info['step_fixation'] = $bidcof['step_fixation'];
            }elseif ($info['stepsize_type'] == 1) {
                $info['step_fixation'] = $info['stepsize'];
                //分配比例默认设置
                $info['stepsize_ratio'] = $bidcof['stepsize_ratio'];
            }
            unset($info['stepsize']);
            if($info['sid']!=0){
                $special = M('special_auction');
                $specfind = $special->where(array('sid'=>$info['sid']))->find();

                $ntm = time();
                if($specfind['starttime']<=$ntm && $specfind['endtime']>=$ntm){
                    $info['sse']=1;
                }elseif ($specfind['starttime']> $ntm) {
                    $info['sse']=0;
                }
                $biding = bidType('biding',1);
                $future = bidType('future',1);
                $bidingList = $special->where($biding['bidType'])->order('sid desc')->select();
                $futureList = $special->where($future['bidType'])->order('sid desc')->select();
                $this->bidingList=$bidingList;
                $this->futureList=$futureList;
                $info['to']='zc';
            }elseif ($info['mid']!=0) {
                $meeting = M('meeting_auction');
                $meetfind = $meeting->where(array('mid'=>$info['mid']))->find();
                $ntm = time();
                if($meet['starttime']<=$ntm && $meet['endtime']>=$ntm){
                    $info['mse']=1;
                }elseif ($meet['starttime']> $ntm) {
                    $info['mse']=0;
                }
                $biding = bidType('biding',2);
                $future = bidType('future',2);
                $bidingList = $meeting->where($biding['bidType'])->order('mid desc')->select();
                $futureList = $meeting->where($future['bidType'])->order('mid desc')->select();
                $this->bidingList=$bidingList;
                $this->futureList=$futureList;
                $info['to']='pmh';
            }else{
                $info['to']='js';
            }

            // 微信推送数据【
            $weixin = M('weiurl')->where(array('rid'=>I('get.pid'),'type'=>'auction'))->find();
            if (!$weixin) {
                $gdata=M('goods')->where(array('id'=>$info['gid'],'sellerid'=>$uid))->field('title,description')->find();
                $weixin=array('name'=>$gdata['title'],'comment'=>$gdata['description']);
            }
            $this->weixin=$weixin;
            // 微信推送数据】
            $this->info=$info;
            $this->display('addAuction'); 
        }
        
    }
        // 撤拍操作
    public function cancelPai(){
        if (IS_POST) {
            $pid = I('post.pid');
            $sellerid = M("Auction")->where("pid=" . $pid)->getField('sellerid');
            // 判断是否有删除权限
            if($sellerid != $this->cUid){
                echojson(array('status' => 0, 'msg'=>'您无权撤拍该拍卖！'));
                exit;
            }

            $drive = array();
            $auction = M("Auction");
            $cpinfo = $auction->where("pid=" . $pid)->find();
            // 验证
            if($cpinfo['starttime']>time()){
                $this->error('未开始拍卖请执行删除操作！');
                exit;
            }
            // 设置牌品当前状态为撤拍
            $data = array(
                'pid'=>$pid,
                'endtime'=>time(),
                'endstatus'=>4
                );

            // 整合撤拍传入workerman变更数据【
            $drive[0] = array(
                'pid'=>$pid,
                'action'=>'cancel',
                'endtime'=>time()
                );
            // 整合撤拍传入workerman变更数据】

            if($auction->save($data)){
                // 解冻卖家保证金
                $rtmsg = unfreeze_seller_pledge($sellerid,$cpinfo['pid'],'cancel');
                // 更新这个拍品的缓存
                $redata = S(C('CACHE_FIX').'bid'.$pid);
                if($redata){
                    $redata['endtime'] = $data['endtime'];
                    $redata['endstatus'] = $data['endstatus'];
                    S(C('CACHE_FIX').'bid'.$pid,$redata);
                }
                // 拍卖会
                if ($cpinfo['pattern']==4) {
                   $chazhi = $cpinfo['endtime']- $data['endtime'];
                   $mplist = $auction->where(array('mid'=>$cpinfo['mid'],'msort'=>array('gt',$cpinfo['msort']),'endstatus'=>0))->select();
                   $ct = count($mplist);
                   $meeting = M('meeting_auction');
                   // 如果撤拍不是最后一个
                   if($ct!=0){
                        foreach ($mplist as $mpk => $mpv) {
                          $updata = array(
                            'pid'=>$mpv['pid'],
                            'starttime'=>$mpv['starttime']-$chazhi,
                            'endtime'=>$mpv['endtime']-$chazhi
                            );
                          // 更新这个拍品的缓存【
                            $redata = S(C('CACHE_FIX').'bid'.$updata['pid']);
                            if($redata){
                                $redata['starttime'] = $updata['starttime'];
                                $redata['endtime'] = $updata['endtime'];
                                S(C('CACHE_FIX').'bid'.$updata['pid'],$redata);
                            }
                        // 更新这个拍品的缓存】
                          $auction->save($updata);
                          // 整合撤拍传入workerman变更数据【
                          $drive[]=array(
                            'pid'=>$mpv['pid'],
                            'action'=>'uptime',
                            'endtime'=>$updata['endtime']
                            );
                          // 整合撤拍传入workerman变更数据】
                          if($ct==$mpk+1){
                            $meeting->save(array('mid'=>$cpinfo['mid'],'endtime'=> $updata['endtime']));
                          }
                        }
                    // 如果是最后一个拍品撤拍拍卖会结束时间为当前
                   }else{
                        $meeting->save(array('mid'=>$cpinfo['mid'],'endtime'=>$data['endtime']));
                   }
                }
                // 循环退还保证金
                $uidarr = M('Goods_user')->where(array('gid'=>$cpinfo['pid']))->getField('uid',true);
                foreach ($uidarr as $uk => $uv) {
                    return_pledge($cpinfo['pid'],$cpinfo['sid'],$uv['uid'],4);
                }
                echojson(array('status' => 1, 'msg'=>'撤拍成功' ,'result' => $drive));
            }else {
                echojson(array('status' => 0, 'msg'=>'撤拍失败请刷新页面重试！'));
            }
        } else {
            E('页面不存在！');
        }
    }
    // 删除拍卖
    public function del_auction(){
        if (IS_POST) {
            $sellerid = D("Auction")->where("pid=" . $pid)->getField('sellerid');
            // 判断是否有删除权限
            if($sellerid!=$this->cUid){
                echojson(array('status' => 0, 'msg'=>'您无权删除该拍卖！'));
                exit;
            }
            $auction = M("Auction");
            $pid = I('post.pid');
            $where = array('pid'=>$pid);
            $cpinfo = $auction->where($where)->find();
            // 正在进行拍卖不能删除
            if($cpinfo['starttime']<=time()&&$cpinfo['endtime']>time()){
                echojson(array('status' => 0, 'msg'=>'已开始拍卖请执行撤拍操作！'));
                exit;
            }
            if($cpinfo['endstatus']==1){
                echojson(array('status' => 0, 'msg'=>'成交拍卖不能删除！'));
                exit;
            }
            // 已结束的需要等拍卖会结束了才可以删除
            if($cpinfo['endtime']<time()){
                if($cpinfo['mid']){
                    $endyn = $auction->where(array('mid'=>$cpinfo['mid']))->order('endtime desc')->getField('endtime');
                    if($endyn>time()){
                        echojson(array('status' => 0, 'msg'=>'需要等拍卖会结束后才能删除！'));
                        exit;
                    }
                }
            }
            // 整合变动数据传入workerman变更数据【
            $drive[0] = array(
                'pid'=>$pid,
                'action'=>'delete',
                'starttime'=>0,
                'endtime'=>0
                );
            // 整合变动数据传入workerman变更数据】
            if ($auction->where($where)->delete()) {
                // 解冻卖家保证金
                $rtmsg = unfreeze_seller_pledge($sellerid,$cpinfo['pid'],'del');
                // 删除拍品的缓存
                S(C('CACHE_FIX').'bid'.$pid,null);
                // 如果拍卖会未结束
    // 拍卖会--------------------------------------------
                // 拍卖会未开始的做本次操作
                if ($cpinfo['pattern']==4&&$cpinfo['endtime']>time()) {
                   $mplist = $auction->where(array('mid'=>$cpinfo['mid'],'msort'=>array('gt',$cpinfo['msort']),'endstatus'=>0))->select();
                   $ct = count($mplist);
                   $meeting = M('meeting_auction');
                   $them = $meeting->where(array('mid'=>$cpinfo['mid']))->find();
                   $thetime = $them['losetime']+$them['intervaltime'];
                   // 如果删除不是最后一个，该拍品后拍品开始结束时间变更
                   if($ct!=0){
                        foreach ($mplist as $mpk => $mpv) {
                          $updata = array(
                            'pid'=>$mpv['pid'],
                            'starttime'=>$mpv['starttime']-$thetime,
                            'endtime'=>$mpv['endtime']-$thetime
                            );

                            // 更新这个拍品的缓存【
                            $redata = S(C('CACHE_FIX').'bid'.$updata['pid']);
                            if($redata){
                                $redata['starttime'] = $updata['starttime'];
                                $redata['endtime'] = $updata['endtime'];
                                S(C('CACHE_FIX').'bid'.$updata['pid'],$redata);
                            }
                            // 更新这个拍品的缓存】

                          $auction->save($updata);
                          // 整合撤拍传入workerman变更数据【
                          $drive[]=array(
                            'pid'=>$mpv['pid'],
                            'action'=>'uptime',
                            'starttime'=>$updata['starttime'],
                            'endtime'=>$updata['endtime']
                            );
                          // 整合撤拍传入workerman变更数据】

                          if($ct==$mpk+1){
                            $meeting->save(array('mid'=>$cpinfo['mid'],'endtime'=> $updata['endtime']));
                          }
                        }
                    // 如果删除是最后一个拍品，拍卖会结束时间减去拍品占用时间
                   }else{
                        $meeting->save(array('mid'=>$cpinfo['mid'],'endtime'=>$them['endtime']-$thetime));
                   }
                }
    // 拍卖会--------------------------------------------end
                echojson(array('status' => 1, 'msg'=>'删除成功!'.$rtmsg ,'result' => $drive));
            } else {
                echojson(array('status' => 0, 'msg'=>'删除失败，可能是不存在该PID的记录'));
            }
        }else{
            E('页面不存在！');
        }
    }


    public function auctionList(){
        $channel = M('goods_category')->where('pid=0')->select(); //读取频道
        $this->channel=$channel; //分配频道
        $ws = I('get.typ')?bidType(I('get.typ')):bidType('biding');
        $od = 'pid desc';
        $auction = D("Auction");
        $where = $ws['bidType'];
        $where['Auction.sellerid']=$this->cUid;
        $count = $auction->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = $auction->listAuction($pConf['first'], $pConf['list'],$where,$od);
        $this->saytyp=$ws['saytyp'];
        $this->display('auctionList'); 
    }


    // 搜索拍卖
    public function searchAuction(){
        if(!I('get.gid')){
            $ws = bidType(I('get.typ'));
            $this->saytyp=$ws['saytyp']; //分配拍卖类型到模板 
            $where = $ws['bidType'];
        }else{
           $where['gid']= I('get.gid');
           $this->ginfo=M('goods')->where(array('id'=>I('get.gid')))->field('id,title')->find();
        }
        $keyW = I('get.');
        $encode = mb_detect_encoding($keyW['keyword'], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
        $keyW['keyword'] = iconv($encode,"utf-8//IGNORE",$keyW['keyword']);
        $cate=M('Goods_category');
        if($keyW['type']!=''){
            $where['type'] = $keyW['type'];
            $tname = $keyW['type']==0 ?'竞拍模式':'竞价模式';
        }else{
            $tname = '所有模式';
        }
        if($keyW['pid']!=''){
            $chname=  $cate->where('cid='.$keyW['pid'])->getField('name');
            if($keyW['cid']==''){
                $keyW['cid']=array();
                $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                $catecid = $cat->getList(NULL, $keyW['pid'],NULL);
                foreach ($catecid as $cik => $civ) {
                    $keyW['cid'][$cik]=$civ['cid'];
                }
                array_push($keyW['cid'], $keyW['pid']); //将频道添加到条件
                $where['cid'] = array('in',$keyW['cid']);
                $catname = '所有'; 
            }else{
                if($keyW['cid']!=''){
                    $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                    $catecid = $cat->getList(NULL,$keyW['cid']);
                    foreach ($catecid as $cak => $cav) {
                        $catecid[$cak]=$cav['cid'];
                    }

                    $catecid[]=$keyW['cid'];
                    $where['cid'] = array('in',$catecid);
                    $catname = $cate->where('cid='.$keyW['cid'])->getField('name');
                }else{
                    $catname = '所有'; 
                }
            }
        }else{
            $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
            $catecid = $cat->getList(NULL, 0,NULL);
            foreach ($catecid as $cik => $civ) {
                $keyW['cid'][$cik]=$civ['cid'];
            }
            $where['cid'] = array('in',$keyW['cid']);
            $chname = '所有';
            $catname = '所有'; 
        }
        if($keyW['keyword'] != '') $where['pname'] = array('LIKE', '%' . $keyW['keyword'] . '%');
        $D = D("Auction");
        $count = $D->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));

        $channel = $cate->where('pid=0')->select(); //读取频道
        $this->channel=$channel; //分配频道
        
        
        $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'type'=>$keyW['type'],'tname'=>$tname,'chname' => $chname,'catname' => $catname,'pid'=>$keyW['pid']);
        $this->keys = $keyS;

        $this->page = $pConf['show']; //分配分页
        $this->list= D("Auction")->listAuction($pConf['first'], $pConf['list'],$where);
        
        C('TOKEN_ON',false);
        $this->display('auctionList');
    }
    // 发送消息
    public function sendmsg(){
        if (IS_POST) {
            $mysms = M('mysms');
            $info = I('post.info');
            // 群组发送
            if(I('post.tp')=='gp'){
                $scount = 0;
                $sendst = 0;
                switch (I('post.gp')) {
                    case '0':
                        $uidarr = array_unique(M('attention_seller')->where(array('sellerid'=>$this->cUid))->getField('uid',true));
                        break;
                    case '1':
                        $uidarr = array_unique(M('goods_order')->where(array('sellerid'=>$this->cUid))->getField('uid',true));
                        # code...
                        break;
                    case '2':
                        $uidarr = M('member')->getField('uid',true);
                        break;
                }
                $data['content'] = $info['content'];
                $data['sendid']=$this->cUid;
                $data['time'] = time();
                $data['type'] = '用户发送';
                if(count($uidarr)>0){
                    foreach ($uidarr as $k => $v) {
                        if($v!=$this->cUid){
                            $data['uid'] = $v;
                            if($mysms->add($data)){
                                $scount+=1;
                            }
                        }
                    }
                    if($scount>0){
                        $alert = '成功发送'.$scount.'条站内信';
                        $sendst = 1;
                    } 
                }else{
                    echojson(array("status" => 0, "info" => "没有接受的用户，发送消息失败",'url'=>__SELF__));
                    exit;
                }
            }else{
            // 一对一发送
                if(I('get.sid')!=0){
                    $sms = $mysms->where(array('sid'=>I('get.sid')))->find();
                    $data['rsid'] = $sms['sid'];
                    $data['uid'] = $sms['sendid'];
                    $data['pid'] = $sms['pid'];
                    if($info['aid']!=0){
                        $data['aid'] = $sms['aid'];
                    }
                }elseif(I('get.uid')!=''){
                    $data['uid'] = I('get.uid');
                    if(I('post.topid')==1){
                        $data['pid'] = $info['pid'];
                    }
                }
                $data['content'] = $info['content'];
                $data['sendid']=$this->cUid;
                $data['time'] = time();
                $data['type'] = '用户发送';
                $sendst = $mysms->add($data);
                $alert = '已发送消息';
            }
            if($sendst){
                echojson(array("status" => 1, "info" => $alert,'url'=>U('Member/sendlist')));
            }else{
                echojson(array("status" => 0, "info" => "发送失败请重试",'url'=>__SELF__));
            }
        }else{
            // 回复或发送信息
            if(I('get.sid')!='' || I('get.uid')!=''){
                $mysms = M('mysms');
                if(I('get.sid')!=''){
                    $uid = $mysms->where(array('sid'=>I('get.sid')))->getField('sendid');
                    $pid = $mysms->where(array('sid'=>I('get.sid')))->getField('pid');
                    $auction = D('Auction')->where(array('pid'=>$pid))->find();
                    $mysms->where(array('sid'=>I('get.sid')))->setField('status',1);
                    $sid=I('get.sid');
                }elseif(I('get.uid')!=''){
                    $uid = I('get.uid');
                    $sid = 0;
                    $pid = I('get.pid');
                }
                $auction = D('Auction')->where(array('pid'=>$pid,'sellerid'=>$uid))->find();
                // 商品存在
                if($auction){
                    $this->auction=$auction;
                }
                $info = M('Member')->where(array('uid'=>$uid))->field('uid,account,nickname,organization')->find();
                $info['rsid'] = $sid;
                $this->info = $info;
            // 群组发送消息
            }else{
                $sendct[0] = count(array_unique(M('attention_seller')->where(array('sellerid'=>$this->cUid))->getField('uid',true)));
                $sendct[1] = count(array_unique(M('goods_order')->where(array('sellerid'=>$this->cUid,'uid'=>array('neq',$this->cUid)))->getField('uid',true)));
                $sendct[2] = count(M('member')->getField('uid',true))-1;
                $this->sendct=$sendct;
                $this->tp='gp';
            }
            $this->display();
        }
    }
    // 已发送站内信
    public function sendlist(){
        $mysms = M('mysms');
        $member = M('member');
        $auction = D('Auction');
        $where = array('sendid'=>$this->cUid,'status'=>array('neq',2));
        $count = $mysms->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $mysms->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        foreach ($list as $k => $v) {
            $list[$k]['user']=$member->where(array('uid'=>$v['uid']))->field('account,nickname')->find();
            if($v['pid']){
                $list[$k]['auction'] = $auction->where(array('pid'=>$v['pid']))->field('pid,pname')->find();
            }
        }
        $this->list=$list;
        $this->page = $pConf['show']; 
        $this->display('sendlist');
    }
// 会话记录
    public function exchange(){
        $member = M('member');
        $mysms = M('mysms');
        $idarr = $mysms->where(array('sid'=>I('get.sid')))->field('uid,sendid,pid')->find();
        // 获取对话人id
        if($idarr['uid']==$this->cUid){
            $sellerid = $idarr['sendid'];
        }
        if($idarr['sendid']==$this->cUid){
            $sellerid = $idarr['uid'];
        }
        if($idarr['pid']){
            $this->auction = M('auction')->where(array('pid'=>$idarr['pid']))->field('pname,pid')->find();
        }
        $guest = $member->where(array('uid'=>$sellerid))->field('account,nickname')->find();
        $this->guest=$guest;

        // 会话列表
        $where['_string'] = "((uid = ".$idarr['uid']." and sendid=".$idarr['sendid'].") or (uid=".$idarr['sendid']." and sendid = ".$idarr['uid'].") and (status != 2))";
        // 如果后台发的私信需要添加该条件
        if($sellerid==0){
            $where['aid'] = array('neq',0);
        }
        $list = $mysms->where($where)->order('time desc')->select();

        $this->myid = $this->cUid;
        $this->list = $list;
        $this->display();
    }

    // 拍卖订单
    public function myorder(){
        $order = M('goods_order');
        $bidmap = D('Auction');
        $member = M('member');
        $express = M('express');
        $where = array('sellerid'=>$this->cUid);
        if(I('get.st')!=''){
            $where['status']=I('get.st');
        }
        $count = $order->where($where)->count();
        $pConf = page($count,5);
        $alist = $order->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        foreach ($alist as $a => $av) {
            $alist[$a]['total'] = $av['price']+$av['freight'];
            $alist[$a]['bidinfo']= $bidmap->where('pid ='.$av['gid'])->find();
            if($alist[$a]['express']!=''){
                $alist[$a]['express']= $express->where(array('en'=>$alist[$a]['express']))->getField('ch');
            }else{
                $alist[$a]['express'] = $alist[$a]['express_other'];
            }
        }

        $this->alist=$alist;
        $this->whopage=array('name'=>'拍卖订单','action'=>'myorder','seller'=>1,'type'=>'buy');
        $this->st = I('get.st');
        $this->page = $pConf['show'];
        $this->display('order');
    }
    // 卖家发货处理
    public function deliver(){
        $M = M("Goods_order");
        if (IS_POST) {
            $data =I('post.info');
            // 计算收货过期时间
            if(C('Order.losetime3')==0||C('Order.losetime3')==''){
                $deftime3 = 0;
            }else{
                $losetime3=C('Order.losetime3');
                $deftime3 = time()+(60*60*24*$losetime3);
            }
            // 设置收货过期时间
            $data['deftime3'] = $deftime3;
            $data['status'] = 2;
            $data['time2'] = time();
            if($M->save($data)){
                // 订单状态提醒【
                    sendOrderRemind($data['order_no']);
                // 订单状态提醒【
                echojson(array('status' => 1, 'info' => '已提交发货'.$rs,'url' => U('Member/myorder',array('st'=>2)))); 
            }else{
                echojson(array('status' => 0, 'info' => '提交发货失败，请检查'));
            }
        } else {
            $info = M('goods_order')->where(array('order_no'=>I('get.order_no')))->find();
            $this->address = unserialize($info['address']);
            // 快递选择
            $this->express_list=expressCompany();
            $this->info=$info;
            $this->display();
        }
    }

// 商品评价
    public function evaluate(){
        $evaluate = M('goods_evaluate');
        
        if (IS_POST) {
            $data = I('post.info');
            $where = array('order_no'=>$data['order_no']);
            if($evaluate->where('$where')->find()){
                echojson(array('status' => 0, 'info' => '您已做过评价！','url'=>__SELF__));
                exit;
            }
            if(!$data['service_evaluate']){echojson(array('status' => 0, 'info' => '请填写【评价服务】')); exit;}
            if(!$data['conform_evaluate']){echojson(array('status' => 0, 'info' => '请填写【评价商品】')); exit;}
            if(!$data['conform']){echojson(array('status' => 0, 'info' => '请为【描述相符】打分')); exit;}
            if(!$data['service']){echojson(array('status' => 0, 'info' => '请为【卖家服务】打分')); exit;}
            if(!$data['express']){echojson(array('status' => 0, 'info' => '请为【物流服务】打分')); exit;}
            $goods_order = M('goods_order');

            $oinfo = $goods_order->where($where)->find();
            if($oinfo&&$oinfo['uid']==$this->cUid&&$oinfo['status']==3){
                $data['uid']=$oinfo['uid'];
                $data['pid']=$oinfo['gid'];
                $data['sellerid']=$oinfo['sellerid'];
                $data['time']=time();
                if($evaluate->add($data)){
                    // 卖家默认好评过期时间
                    if(C('Order.losetime10')==0||C('Order.losetime10')==''){
                        $deftime10 = 0;
                    }else{
                        $losetime10=C('Order.losetime10');
                        $deftime10 = time()+(60*60*24*$losetime10);
                    }
                    // 设置已评价和卖家默认评价时间
                    if($goods_order->where($where)->setField(array('status'=>'4','time4'=>time(),'deftime10'=>$deftime10))){
                        // 订单状态提醒【
                            sendOrderRemind($data['order_no']);
                        // 订单状态提醒【
                    }
                    // 为用户等级加分数
                    $score = $data['conform']+$data['service']+$data['express'];
                    M('member')->where(array('uid'=>$data['sellerid']))->setInc('score',$score);
                    echojson(array('status' => 1, 'info' => '评价成功','url'=>U('Member/mysucc',array('st'=>4))));
                }else{
                    echojson(array('status' => 0, 'info' => '评价失败','url'=>__SELF__));
                }
            }else{
                echojson(array('status' => 0, 'info' => '不存在的订单或该订单不接收您的评价','url'=>U('Member/mysucc',array('st'=>3))));
            }
            
        }else{
            $where = array('order_no'=>I('get.order_no'));
            if($evaluate->where($where)->find()){
                $this->error('页面已过期');
                exit;
            }
            $oinfo = M('goods_order')->where($where)->field('gid,uid,sellerid')->find();
            if($oinfo['uid']!=$this->cUid){
                $this->error('页面不存在！');
            }
            $ainfo = D('auction')->where(array('pid'=>$oinfo['gid']))->find();
            $ainfo['member'] = M('member')->where(array('uid'=>$oinfo['sellerid']))->field('nickname,uid')->find();
            $ainfo['member']['role'] = '卖家';
            $this->seller = 0;
            $this->info = array('order_no'=>I('get.order_no'));
            $this->ainfo = $ainfo;
            $this->display();
        }
    }
    // 查看评价
    public function evaluate_show(){
        $where = array('order_no'=>I('get.order_no'));
        $oinfo = M('goods_order')->where($where)->field('gid,uid,sellerid')->find();
        $ainfo = D('auction')->where(array('pid'=>$oinfo['gid']))->find();
        $info = M('goods_evaluate')->where($where)->find();
        $ainfo['member'] = M('member')->where(array('uid'=>$oinfo['sellerid']))->field('nickname,uid')->find();
        $ainfo['member']['role'] = '卖家';
        $this->info = $info;
        $this->ainfo = $ainfo;
        $this->display('evaluate');
    }
    // 评价买家
    public function seller_evaluate(){
        $evaluate = M('member_evaluate');
        if (IS_POST) {
            $data = I('post.info');
            $where = array('order_no'=>$data['order_no']);
            if($data['evaluate']==''){
                echojson(array('status' => 0, 'info' => '请填写评价内容！','url'=>__SELF__));
                exit;
            }
            if($evaluate->where($where)->find()){
                echojson(array('status' => 0, 'info' => '您已做过评价！','url'=>__SELF__));
                exit;
            } 
            $goods_order = M('goods_order');
            $oinfo = $goods_order->where($where)->find();
            $data['pid']=$oinfo['gid'];
            $data['sellerid'] = $oinfo['sellerid'];
            $data['uid'] = $oinfo['uid'];
            $data['time'] = time();
            if($evaluate->add($data)){
                if ($goods_order->where($where)->setField(array('status'=>'10','time10'=>time()))) {
                    // 订单状态提醒【
                        sendOrderRemind($data['order_no']);
                    // 订单状态提醒【
                }
                M('member')->where(array('uid'=>$data['uid']))->setInc('scorebuy',$data['score']);
                echojson(array('status' => 1, 'info' => '评价成功','url'=>U('Member/myorder',array('st'=>10))));
            }else{
                echojson(array('status' => 0, 'info' => '评价失败,请重试','url'=>__SELF__));
            }   
        }else{
            $where = array('order_no'=>I('get.order_no'));
            if($evaluate->where($where)->find()){
                $this->error('页面已过期');
            } 
            $oinfo = M('goods_order')->where($where)->field('gid,uid,sellerid')->find();
            if($oinfo['sellerid']!=$this->cUid){
                $this->error('页面不存在！');
            }
            $ainfo = D('auction')->where(array('pid'=>$oinfo['gid']))->find();
            $ainfo['member'] = M('member')->where(array('uid'=>$oinfo['sellerid']))->field('nickname,uid')->find();
            $ainfo['member']['role'] = '买家';
            $this->seller = 1;
            $this->info = array('order_no'=>I('get.order_no'));
            $this->ainfo = $ainfo;
            $this->display();
        }
    }
// 我收到的评价
    public function seller_myevaluate(){
        $evaluate = M('goods_evaluate');
        $member = M('member');
        $auction = D('auction');
        $order = M('goods_order');
        $where = array('sellerid'=>$this->cUid);
        $einfo['credit_score'] = getstarval($evaluate,$where);
        $elist = $evaluate->where($where)->select();
        $ntm = time();
        $watm = $ntm+(3600*7);
        $wbtm = $ntm+(3600*30);
        $wctm = $ntm+(3600*186);
        $einfo['scoreZC'] = 0;$einfo['scoreZZ'] = 0;$einfo['scoreZH'] = 0;
        $einfo['scoreAC'] = 0;$einfo['scoreAZ'] = 0;$einfo['scoreAH'] = 0;
        $einfo['scoreBC'] = 0;$einfo['scoreBZ'] = 0;$einfo['scoreBH'] = 0;
        $einfo['scoreCC'] = 0;$einfo['scoreCZ'] = 0;$einfo['scoreCH'] = 0;
        $einfo['scoreDC'] = 0;$einfo['scoreDZ'] = 0;$einfo['scoreDH'] = 0;
        foreach ($elist as $ek => $ev) {
            $zf = $ev['conform']+$ev['service']+$ev['express'];
            if($ev['time']<$watm){
                if($zf<=6){
                    $einfo['scoreAC']+=1; $einfo['scoreZC']+=1; 
                }elseif($zf>6&&$zf<=12){
                    $einfo['scoreAZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($zf>12&&$zf<=15){
                    $einfo['scoreAH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$watm&&$ev['time']>$wbtm){
                if($zf<=6){
                    $einfo['scoreBC']+=1; $einfo['scoreZC']+=1; 
                }elseif($zf>6&&$zf<=12){
                    $einfo['scoreBZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($zf>12&&$zf<=15){
                    $einfo['scoreBH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$wbtm&&$ev['time']>$wctm){
                if($zf<=6){
                    $einfo['scoreCC']+=1; $einfo['scoreZC']+=1; 
                }elseif($zf>6&&$zf<=12){
                    $einfo['scoreCZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($zf>12&&$zf<=15){
                    $einfo['scoreCH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$wctm){
                if($zf<=6){
                    $einfo['scoreDC']+=1; $einfo['scoreZC']+=1;
                }elseif($zf>6&&$zf<=12){
                    $einfo['scoreDZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($zf>12&&$zf<=15){
                    $einfo['scoreDH']+=1; $einfo['scoreZH']+=1; 
                }
            }
        }
        $einfo['scoreALZ'] = $einfo['scoreZC']+$einfo['scoreZZ']+$einfo['scoreZH'];
        $einfo['scoreALA'] = $einfo['scoreAC']+$einfo['scoreAZ']+$einfo['scoreAH'];
        $einfo['scoreALB'] = $einfo['scoreBC']+$einfo['scoreBZ']+$einfo['scoreBH'];
        $einfo['scoreALC'] = $einfo['scoreCC']+$einfo['scoreCZ']+$einfo['scoreCH'];
        $einfo['scoreALD'] = $einfo['scoreDC']+$einfo['scoreDZ']+$einfo['scoreDH'];
        $einfo['scorePER'] = wipezero($einfo['scoreZH']/$einfo['scoreALZ']*100)."%";
        $count = $evaluate->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $evaluate->where($where)->limit($pConf['first'].','.$pConf['list'])->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['nickname'] = $member->where(array('uid'=>$lv['uid']))->getField('nickname');
            $list[$lk]['pname'] = $auction->where(array('pid'=>$lv['pid']))->getField('pname');
            $list[$lk]['pictures'] = $auction->where(array('pid'=>$lv['pid']))->getField('pictures');
            $list[$lk]['price'] =  $order->where(array('order_no'=>$lv['order_no']))->getField('price');
            $zongfen = $lv['conform']+$lv['service']+$lv['express'];
            if($zongfen>=0&&$zongfen<=6){
                $list[$lk]['pingjia'] = 0;
            }elseif($zongfen>=7&&$zongfen<=12){
                $list[$lk]['pingjia'] = 1;
            }elseif($zongfen>=13){
                $list[$lk]['pingjia'] = 2;
            }
        }
        $this->page = $pConf['show']; 
        $this->einfo=$einfo;
        $this->list=$list;
        $this->display();
    }
// 我评价的卖家
    public function my_evaluate(){
        $evaluate = M('goods_evaluate');
        $member = M('member');
        $auction = D('auction');
        $order = M('goods_order');
        $count = $evaluate->where(array('uid'=>$this->cUid))->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $evaluate->where(array('uid'=>$this->cUid))->limit($pConf['first'].','.$pConf['list'])->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['organization'] = $member->where(array('uid'=>$lv['sellerid']))->getField('organization');
            $list[$lk]['pname'] = $auction->where(array('pid'=>$lv['pid']))->getField('pname');
            $list[$lk]['pictures'] = $auction->where(array('pid'=>$lv['pid']))->getField('pictures');
            $list[$lk]['price'] =  $order->where(array('order_no'=>$lv['order_no']))->getField('price');
            $zongfen = $lv['conform']+$lv['service']+$lv['express'];
            if($zongfen>=0&&$zongfen<=6){
                $list[$lk]['pingjia'] = 0;
            }elseif($zongfen>=7&&$zongfen<=12){
                $list[$lk]['pingjia'] = 1;
            }elseif($zongfen>=13){
                $list[$lk]['pingjia'] = 2;
            }
            $list[$lk]['nickname']=$member->where(array('uid'=>$lv['sellerid']))->getField('nickname');
        }
        $this->page = $pConf['show']; 
        $this->einfo=$einfo;
        $this->list=$list;
        $this->display();
    }
    // 我评价的买家
    
    public function my_evaluatebuy(){
        $evaluate = M('member_evaluate');
        $member = M('member');
        $auction = D('auction');
        $order = M('goods_order');
        $count = $evaluate->where(array('sellerid'=>$this->cUid))->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $evaluate->where(array('sellerid'=>$this->cUid))->limit($pConf['first'].','.$pConf['list'])->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['nickname'] = $member->where(array('uid'=>$lv['uid']))->getField('nickname');
            $list[$lk]['pname'] = $auction->where(array('pid'=>$lv['pid']))->getField('pname');
            $list[$lk]['pictures'] = $auction->where(array('pid'=>$lv['pid']))->getField('pictures');
            $list[$lk]['price'] =  $order->where(array('order_no'=>$lv['order_no']))->getField('price');
            $list[$lk]['nickname']=$member->where(array('uid'=>$lv['uid']))->getField('nickname');
        }

        $this->page = $pConf['show']; 
        $this->einfo=$einfo;
        $this->list=$list;
        $this->display();
    }
    // 收到卖家的评价
    public function buy_myevaluate(){
        $evaluate = M('member_evaluate');
        $member = M('member');
        $auction = D('auction');
        $order = M('goods_order');
        $where = array('uid'=>$this->cUid);
        $elist = $evaluate->where($where)->select();
        $ntm = time();
        $watm = $ntm+(3600*7);
        $wbtm = $ntm+(3600*30);
        $wctm = $ntm+(3600*186);
        $einfo['scoreZC'] = 0;$einfo['scoreZZ'] = 0;$einfo['scoreZH'] = 0;
        $einfo['scoreAC'] = 0;$einfo['scoreAZ'] = 0;$einfo['scoreAH'] = 0;
        $einfo['scoreBC'] = 0;$einfo['scoreBZ'] = 0;$einfo['scoreBH'] = 0;
        $einfo['scoreCC'] = 0;$einfo['scoreCZ'] = 0;$einfo['scoreCH'] = 0;
        $einfo['scoreDC'] = 0;$einfo['scoreDZ'] = 0;$einfo['scoreDH'] = 0;
        foreach ($elist as $ek => $ev) {
            if($ev['time']<$watm){
                if($ev['score']==0){
                    $einfo['scoreAC']+=1; $einfo['scoreZC']+=1; 
                }elseif($ev['score']==1){
                    $einfo['scoreAZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($ev['score']==2){
                    $einfo['scoreAH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$watm&&$ev['time']>$wbtm){
                if($ev['score']==0){
                    $einfo['scoreBC']+=1; $einfo['scoreZC']+=1; 
                }elseif($ev['score']==1){
                    $einfo['scoreBZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($ev['score']==2){
                    $einfo['scoreBH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$wbtm&&$ev['time']>$wctm){
                if($ev['score']==0){
                    $einfo['scoreCC']+=1; $einfo['scoreZC']+=1; 
                }elseif($ev['score']==1){
                    $einfo['scoreCZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($ev['score']==2){
                    $einfo['scoreCH']+=1; $einfo['scoreZH']+=1;
                }
            }elseif($ev['time']<$wctm){
                if($ev['score']==0){
                    $einfo['scoreDC']+=1; $einfo['scoreZC']+=1;
                }elseif($ev['score']==1){
                    $einfo['scoreDZ']+=1; $einfo['scoreZZ']+=1; 
                }elseif($ev['score']==2){
                    $einfo['scoreDH']+=1; $einfo['scoreZH']+=1; 
                }
            }
        }
        $einfo['scoreALZ'] = $einfo['scoreZC']+$einfo['scoreZZ']+$einfo['scoreZH'];
        $einfo['scoreALA'] = $einfo['scoreAC']+$einfo['scoreAZ']+$einfo['scoreAH'];
        $einfo['scoreALB'] = $einfo['scoreBC']+$einfo['scoreBZ']+$einfo['scoreBH'];
        $einfo['scoreALC'] = $einfo['scoreCC']+$einfo['scoreCZ']+$einfo['scoreCH'];
        $einfo['scoreALD'] = $einfo['scoreDC']+$einfo['scoreDZ']+$einfo['scoreDH'];
        $einfo['scorePER'] = wipezero($einfo['scoreZH']/$einfo['scoreALZ']*100)."%";
        $this->einfo=$einfo;

        $count = $evaluate->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $evaluate->where($where)->limit($pConf['first'].','.$pConf['list'])->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['organization'] = $member->where(array('uid'=>$lv['sellerid']))->getField('organization');
            $list[$lk]['pname'] = $auction->where(array('pid'=>$lv['pid']))->getField('pname');
            $list[$lk]['pictures'] = $auction->where(array('pid'=>$lv['pid']))->getField('pictures');
            $list[$lk]['price'] =  $order->where(array('order_no'=>$lv['order_no']))->getField('price');
        }
        $this->list=$list;
        $this->display();
    }

    // 微信图文
    public function weisend(){
        $weiurl = M('Weiurl');
        $member = M('member');
        $where = array('sellerid'=>$this->cUid);
        $count = $weiurl->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $weiurl->where($where)->order('id desc')->select();
        $this->list=$list;
        $this->display();
    }
    // 选择推送
    public function weipush(){
        if(C('Weixin.appid')&&C('Weixin.appsecret')){
            $uid = $this->cUid;
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
                foreach ($wlist as $wk => $wv) {
                    $news_arr[$lk][0] = $wv['name'];
                    $news_arr[$lk][1] = $wv['comment'];
                    // 地址替换
                    $news_arr[$lk][2] = $wv['url'];
                    // 图片选择
                    if($lk==0){
                        $news_arr[$lk][3] = C('WEB_ROOT').__ROOT__.trim(C('UPLOADS_PICPATH'),'.').$wv['toppic'];
                    }else{
                        $news_arr[$lk][3] = C('WEB_ROOT').__ROOT__.trim(C('UPLOADS_PICPATH'),'.').$wv['picture'];
                    }
                    $lk+=1;
                }
                $uidarr = eligibility($uid,1);
                if(!empty($uidarr)){
                    $retmsg = D('Weixin')->sendNews(array('uid'=>array('in',$uidarr)),$news_arr,$widarr);
                    echojson(array('status'=>1,'info'=>$retmsg));
                }else{
                    echojson(array('status'=>0,'info'=>'没有符合条件的推送用户。'));
                }
            }
        }else{
            echojson(array('status'=>1,'info'=>'没有配置微信，请先配置微信。'));
        }
    }
    // 编辑图文消息
    public function editweisend() {
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
            $this->display();
        }
    }
    //删除图文消息
    public function delweisend() {

        if (M("Weiurl")->where(array('id'=>I('get.id'),'sellerid'=>$this->cUid))->delete()) {
            $this->success("成功删除");
            //echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

    public function settixing(){
        if (IS_POST) {
            $data = I('post.');
            $dt = array();
            if($data){
                foreach ($data as $dk => $dv) {
                    if($dv!=0){
                        $dt[]=$dk;
                    }
                }
                if($dt){
                    $str = implode($dt, ',');
                }
                if($str){
                    if(M('Member')->save(array('uid'=>$this->cUid,'alerttype'=>$str))!==false){
                        echojson(array('status' => 1, 'info' => '设置成功！','url'=>'Member/index'));
                    }else{
                        echojson(array('status' => 0, 'info' => '设置失败！','url'=>__SELF__));
                    }
                }else{
                    echojson(array('status' => 0, 'info' => '请选择提醒方式！','url'=>__SELF__));
                }

                
            }else{
                echojson(array('status' => 0, 'info' => '设置失败！','url'=>__SELF__));
            }
        } else {
            $myinfo = M('Member')->where(array('uid'=>$this->cUid))->field('email,verify_email,mobile,verify_mobile')->find();
            // 是否关联有微信【
            if(C('Weixin.appid')&&C('Weixin.appsecret')){
                if(M('member_weixin')->where(array('uid'=>$this->cUid))->find()){
                    $myinfo['verify_weixin'] = 1;
                }else{
                    $myinfo['verify_weixin'] = 0;
                }
            }
            // 提醒方式设置【
            $alerttype = M('member')->where(array('uid'=>$this->cUid))->getField('alerttype');
            if($alerttype){$this->alerttype = explode(',', $alerttype);}
            // 提醒方式设置】
            if(I('get.pid')){$this->pid = I('get.pid');}else{$this->pid = 0;}
            
            // 是否关联有微信】
            $this->myinfo=$myinfo;
            C('TOKEN_ON',false);
            $this->display();
        }
    }

        function point_record(){
            $pRecord=M('point_record');
            $where['uid']=$this->cUid;
            $count = $pRecord->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));            
            $list=$pRecord->where($where)->order('id desc')->limit($pConf['first'].','.$pConf['list'])->select();//print_r($list);exit;
            foreach($list as $k=>$v){
                if($v['type']==1){
                    $list[$k]['expend']=$v['point_change'];
                }else{
                    $list[$k]['income']=$v['point_change'];
                }
            }
            $this->mInfo=M('Member')->where(array('uid'=>$this->cUid))->find();
            $this->list=$list;
            $this->page = $pConf['show'];
            $this->display();
        }







}