<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends CommonController {

    public function index() {
        $M = M("Member");
        $evaluate = M('goods_evaluate');
        $goods = M('goods');
        $auction = D('Auction');
        $deliver_address = M('deliver_address');
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE')); // 分页
        $list=$M->order('uid desc')->limit($pConf['first'], $pConf['list'])->select();
        $this->page = $pConf['show'];
        foreach ($list as $lk => $lv) {
            $list[$lk]['adcount'] = $deliver_address->where(array('uid'=>$lv['uid']))->count();
            $list[$lk]['leval'] = getlevel($lv['score']);
            $list[$lk]['levalbuy'] = getlevel($lv['scorebuy'],1);
            $list[$lk]['evaluate'] = getstarval($evaluate,array('sellerid'=>$lv['uid']));
            $list[$lk]['goods_count'] = $goods->where(array('sellerid'=>$lv['uid']))->count();
            $list[$lk]['auction_count'] = $auction->where(array('sellerid'=>$lv['uid']))->count();
        }
        $this->list=$list;
        $this->display();
    }
    // 地址列表
    public function deliver_address(){
        $uid = I('get.uid');
        $info = M('Member')->where(array('uid'=>$uid))->find();
        $list = M('deliver_address')->where(array('uid'=>$uid))->select();
        $region = M('region');
        foreach ($list as $lk => $lv) {
            $province = $region->where(array('region_id'=>$lv['province']))->getField('region_name');
            $city = $region->where(array('region_id'=>$lv['city']))->getField('region_name');
            $area = $region->where(array('region_id'=>$lv['area']))->getField('region_name');
            $list[$lk]['ctstr'] = $province.'  '.$city.'  '.$area;
        }
        $this->list = $list;

        $this->info = $info;
        $this->display();
    }
    public function search(){
        $M = M("Member");
        $evaluate = M('goods_evaluate');
        $goods = M('goods');
        $auction = D('Auction');
        $deliver_address = M('deliver_address');
        $keys = I('get.');
        $where = array($keys[field]=>array('LIKE','%'.$keys['keyword'].'%'));
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); // 分页
        $list=$M->where($where)->order('uid desc')->limit($pConf['first'], $pConf['list'])->select();
        foreach ($list as $lk => $lv) {
            $list[$lk]['adcount'] = $deliver_address->where(array('uid'=>$lv['uid']))->count();
            $list[$lk]['leval'] = getlevel($lv['score']);
            $list[$lk]['levalbuy'] = getlevel($lv['scorebuy'],1);
            $list[$lk]['evaluate'] = getstarval($evaluate,array('sellerid'=>$lv['uid']));
            $list[$lk]['goods_count'] = $goods->where(array('sellerid'=>$lv['uid']))->count();
            $list[$lk]['auction_count'] = $auction->where(array('sellerid'=>$lv['uid']))->count();
        }
        $this->list=$list;
        $keys['count']=$count;
        $this->keys=$keys;
        $this->page = $pConf['show'];
        C('TOKEN_ON',false);
        if($keys['page']=='getUser'){
            $this->display('getUser');
        }else{
            $this->display('index');
        }
        
    }
    // 添加用户
    public function add(){
        if(IS_POST){
            echojson(D('Member')->addMember());
        }else{
            $this->display();
        }
    }
    // 记账单
    public function walletbill(){
        if(IS_POST){
            
        }else{
            $where = array();
            if (I('get.wallet')=='limsum') {
                $wallet = 'limsum';
                $wallet_bill = D('MemberLimsumBill');
            }else{
                $wallet_bill = D('MemberPledgeBill');
                $wallet = 'pledge';
            }
            if(I('get.')){
                $wstar = '';
                $keys=I('get.');
                $keys['start_time'] = str_replace('+', ' ', $keys['start_time']);
                $keys['end_time'] = str_replace('+', ' ', $keys['end_time']);
                if($keys['start_time']!=''){
                    $wstar .= "time >= ".strtotime($keys['start_time'])." and ";
                }
                if($keys['end_time']!=''){
                    $wstar .= "time <= ".strtotime($keys['end_time']);
                }
                if($wstar!=''){
                    $where['_string'] = $wstar;
                }
                if($keys['changetype']!=''){
                    $where['changetype'] = $keys['changetype'];
                }
                if($keys['account']!=''){
                    $where['account'] = $keys['account'];
                }
                if($keys['order_no']!=''){
                    $where['order_no'] = $keys['order_no'];
                }
                $this->keys=$keys;
            }
            $count = $wallet_bill->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE')); // 分页
            $list=$wallet_bill->where($where)->order('time desc')->limit($pConf['first'], $pConf['list'])->select();
            $this->list=$list;
            $this->wallet=$wallet;
            $this->changetype = changetype('all');
            $this->page = $pConf['show'];
            $this->display();
        }
    }


    // 用户账户管理
    public function wallet(){
        if(IS_POST){
            $info = I('post.info');
            if($info['item'] == 'pledge'){
                echojson(D('Member')->recharge_pledge($info));
            }elseif ($info['item'] == 'limsum') {
                echojson(D('Member')->recharge_limsum($info));
            }else{
                return '不存在的充值项';
            }
            
            // echojson(D('Member')->addMember());
        }else{
            $uid=I('get.uid');
            $m_member=M('Member');
            $map['uid']=$uid;
            $info=$m_member->where($map)->find();
            // 保证金
            $available = $info['wallet_pledge'] - $info['wallet_pledge_freeze'];

            $info['available'] = $available>=0 ? sprintf("%.2f", $available): 0;
            // 信用额度
            $available_limsum = $info['wallet_limsum'] - $info['wallet_limsum_freeze'];
            $info['available_limsum'] = $available_limsum>=0 ? sprintf("%.2f", $available_limsum) : 0;
            $this->info = $info;
            $this->display();
        }
    }
    // 推广反馈
    public function feedback(){
        if(IS_POST){
            echojson(D('Member')->addFeedback());
        }else{
            $M = M('feedback');
            $this->list = $M->order('count desc')->select();

            $this->display();
        }
    }
    // 用户配置
    public function set_member() {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/SetMember.php";

            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['Member'] = I('post.');
            if (set_config("SetMember", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '设置成功','url'=>__ACTION__));
            } else {
                echojson(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $mbcof = include APP_PATH . 'Common/Conf/SetMember.php';
            $this->mbcof=$mbcof['Member'];
            $this->display(); 
        }
    }
    // 编辑用户
    public function edit(){
        if(IS_POST){
            echojson(D('Member')->addMember());
        }else{
            $uid=I('get.uid');
            $m_member=M('Member');
            $map['uid']=$uid;
            $info=$m_member->where($map)->find();
            $this->info = $info;
            $this->display('add');
        }
    }
    // 删除用户
    public function del(){
        $uid=I('get.uid');
        if($uid){
            $m_member=M('Member');
            $map['uid']=$uid;
            if($m_member->where($map)->delete()){
                // 删除用户微信表
                M('member_weixin')->where($map)->delete();
                $this->success('删除成功');
            }else{
                $this->error('删除失败');
            }
        }else{
            return false;
        }
    }
    // 发送站内信
    public function sendsms(){
        if (IS_POST) {
            $data = I('post.data');
            if($data['uid']){
                $count = 0;
                $mysms = M('mysms');
                foreach ($data['uid'] as $k => $v) {
                    $dt=array(
                        'uid'=>$v,
                        'type'=>'管理员发送',
                        'aid'=>$_SESSION['my_info']['aid'],
                        'content'=>$data['content'],
                        'time'=>time()
                        );
                    if($mysms->add($dt)){
                        $count +=1; 
                    }
                }
                if($count>0){
                    echojson(array("status" => 1, "info" => '成功发送'.$count.'条站内信！','url'=>U('Member/webmail')));
                }else{
                   $this->error('发送失败请重试！'); 
                }
            }else{
                echojson(array("status" => 0, "info" => "至少需要选择一个接受用户！",'url'=>__SELF__));
            }
        }else{
            $uidstr = I('get.uid');
            $uidarr = explode('_', $uidstr);
            if($uidarr[0]!=''){
                $where['uid'] = array('in',$uidarr);
            }else{
                $this->error('不存在的用户');
            }
            $list = M('member')->where($where)->field('uid,account,nickname')->select();
            $this->list = $list;
            $this->display();
        }
        
    }
    // 站内信管理
    public function webmail(){
        $mysms = M('mysms');
        $member = M('member');
        $admin = M('admin');
        $count = $mysms->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); // 分页
        $list = $mysms->where($where)->limit($pConf['first'], $pConf['list'])->order('time desc')->select();
        foreach ($list as $k => $v) {
            if($v['sendid']==0){
                if($v['aid']==0){
                    $list[$k]['ho'] = '系统发送';
                }else{
                    $adma = $admin->where(array('aid'=>$v['aid']))->field('email')->find();
                    $list[$k]['ho'] = '管理员：'.$adma['email'];
                }
            }else{
                $user = $member->where(array('uid'=>$v['sendid']))->field('account')->find();
                $list[$k]['ho'] = '用户：'.$user['account'];
            }
            if($v['uid']==0){
                if($v['aid']!=0){
                    $adma = $admin->where(array('aid'=>$v['aid']))->field('email')->find();
                    $list[$k]['to'] = '管理员：'.$adma['email'];
                }
            }else{
                $user = $member->where(array('uid'=>$v['uid']))->field('account')->find();
                $list[$k]['to'] = '用户：'.$user['account'];
            }
        }
        $this->page = $pConf['show'];
        $this->list = $list;
        $this->display();
    }
    // 搜索站内信
    public function search_sms(){
        $mysms = M('mysms');
        $member = M('member');
        $admin = M('admin');
        // 系统发送
        if(I('get.tp')==0){
            if(I('get.to')!=''){
                $where['uid'] = $member->where(array('account'=>I('get.to')))->getField('uid');
            }
            $where['aid'] = 0;
            $where['sendid'] = 0;
        // 管理员发送
        }elseif(I('get.tp')==1){
            if(I('get.ho')!=''){
                $where['aid'] = $admin->where(array('email'=>I('get.ho')))->getField('aid');
            }
            if(I('get.to')!=''){
                $where['uid'] = $member->where(array('account'=>I('get.to')))->getField('uid');
            }
            $where['sendid'] = 0;
        // 用户发送
        }

        $count = $mysms->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE')); // 分页
        $list = $mysms->where($where)->limit($pConf['first'], $pConf['list'])->order('time desc')->select();
        foreach ($list as $k => $v) {
            if($v['sendid']==0){
                if($v['aid']==0){
                    $list[$k]['ho'] = '系统发送';
                }else{
                    $adma = $admin->where(array('aid'=>$v['aid']))->field('email')->find();
                    $list[$k]['ho'] = '管理员：'.$adma['email'];
                }
            }else{
                $user = $member->where(array('uid'=>$v['sendid']))->field('account')->find();
                $list[$k]['ho'] = '用户：'.$user['account'];
            }
            if($v['uid']==0){
                if($v['aid']!=0){
                    $adma = $admin->where(array('aid'=>$v['aid']))->field('email')->find();
                    $list[$k]['to'] = '管理员：'.$adma['email'];
                }
            }else{
                $user = $member->where(array('uid'=>$v['uid']))->field('account')->find();
                $list[$k]['to'] = '用户：'.$user['account'];
            }
        }
        $keys = I('get.');
        $keys['count'] = $count;
        $this->keys = $keys;
        $this->page = $pConf['show'];
        $this->list = $list;
        $this->display('webmail');
    }
    // 站内信设置删除状态
    public function setdelsms(){
        $sid=I('post.sid');
        if(!$sid){return false;}
        $mysms=M('mysms');
        $map['sid']=$sid;
        if(I('post.delmark')==0){
            if($mysms->where($map)->setField('delmark',1)){
                echojson(array('status' => 1, 'msg' => '已设置删除')); 
            }else{
                echojson(array('status' => 0, 'msg' => '设置删除失败')); 
            }
        }else{
           if($mysms->where($map)->setField('delmark',0)){
                echojson(array('status' => 1, 'msg' => '已取消删除')); 
            }else{
                echojson(array('status' => 0, 'msg' => '取消删除失败')); 
            } 
        }
    }
    // 删除站内信
    public function delsms(){
        if(M('mysms')->delete(I('get.sid'))){
            $this->success('删除成功！');
        }else{
            $this->error('删除失败，请重试！');
        }
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



}