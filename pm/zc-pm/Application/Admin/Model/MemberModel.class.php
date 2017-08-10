<?php
namespace Admin\Model;
use Think\Model;
class MemberModel extends Model {
    public function addMember(){
        // var_dump($_SESSION['my_info']['aid']);exit();
        $m_member=M('Member');
        $data=I('post.info');
        $region=I('post.region');
        $uid=I('post.uid');
        $sm['email']=$data['email'];
        $sm['uid']=array('neq',$uid);
        $data['province'] = $region['province'];
        $data['city'] = $region['city'];
        $data['area'] = $region['area'];
        $data['business_id'] = $_SESSION['business_id'];

        if($data['email']!=''){
            if($m_member->where($sm)->count()){
                return array("status" => 0, "info" => "邮箱地址已存在！");
                exit;
            }
            if(!is_email($data['email'])){
                return array("status" => 0, "info" => "邮箱格式错误！");
                exit;
            }
        }
        if($data['pwd']){
            if(strlen($data['pwd'])<6){
                return array("status" => 0, "info" => "密码少于6位！");
                exit;
            }
            $data['pwd']=encrypt( $data['pwd']);
        }else{
            unset($data['pwd']);
        }
        if($uid){
            $map['uid']=$uid;
            if($m_member->where($map)->save($data)){
                return array("status" => 1, "info" => "修改会员成功",'url'=>U('Member/index'));
                exit;
            }else{
                return array("status" => 0, "info" => "修改会员失败");
                exit;
            }
        }else{
            if(empty($data['pwd'])){
                return array("status" => 0, "info" => "请输入密码！");
                exit;
            }
            $data['aid'] = $_SESSION['my_info']['aid'];
            if($m_member->add($data)){
                return array("status" => 1, "info" => "添加会员成功",'url'=>U('Member/index'));
                exit;
            }else{
                return array("status" => 0, "info" => "添加会员失败");
                exit;
            }
        }
    }
    public function addFeedback(){
        $data = I('post.data');
        $act = I('post.act');
        $M = M('feedback');
        if ($act == "add") { //添加推广类型
            if ($M->where($data)->count() == 0) {
                return ($M->add($data)) ? array('status' => 1, 'info' => '分类 ' . $data['name'] . ' 已经成功添加到系统中', 'url' => U('Member/feedback', array('time' => time()))) : array('status' => 0, 'info' => '推广类型 ' . $data['name'] . ' 添加失败');
            } else {
                return array('status' => 0, 'info' => '系统中已经存在推广类型 ' . $data['name']);
            }
        } else if ($act == "edit") {
            return ($M->save($data)) ? array('status' => 1, 'info' => '推广类型 ' . $data['name'] . ' 已经成功更新', 'url' => U('Member/feedback', array('time' => time()))) : array('status' => 0, 'info' => '推广类型 ' . $data['name'] . ' 更新失败');
        } else {
            unset($data['name']);
            return ($M->where($data)->delete()) ? array('status' => 1, 'info' => '推广类型 ' . $data['name'] . ' 已经成功删除', 'url' => U('Member/feedback', array('time' => time()))) : array('status' => 0, 'info' => '推广类型 ' . $data['name'] . ' 删除失败');
        }

        
        
    }
    // 保证金充值
    public function recharge_pledge($info){
        $member = M('member');
        $wr = array('uid'=>$info['uid']);
        $wallet = $member->where($wr)->field('wallet_pledge,wallet_pledge_freeze')->find();
        $usable = sprintf("%.2f",$wallet['wallet_pledge']-$wallet['wallet_pledge_freeze']);
        switch ($info['act']) {
            case 'add':
                if($member->where(array('uid'=>$info['uid']))->setInc('wallet_pledge',$info['money'])){
                    // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                    $pledge_data = array(
                        'order_no'=>createNo('aad'),
                        'uid'=>$info['uid'],
                        'changetype'=>'admin_deposit',
                        'time'=>time(),
                        'annotation'=>$info['remark'],
                        'income'=>$info['money'],
                        );
                    $ac = '充值';
                    $usable = $usable+$info['money'];
                }
                break;
            case 'minus':
                if($usable>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where(array('uid'=>$info['uid']))->setDec('wallet_pledge',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $pledge_data = array(
                            'order_no'=>createNo('ami'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_deduct',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'expend'=>$info['money'],
                            );
                        $ac = '扣除';
                        $usable = $usable-$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可扣除（可用资金）不足，扣除失败','url'=>__SELF__);
                }
                break;
            case 'freeze':
                if($usable>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where($wr)->setInc('wallet_pledge_freeze',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $pledge_data = array(
                            'order_no'=>createNo('afr'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_freeze',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'expend'=>$info['money'],
                            );
                        $ac = '冻结';
                        $usable = $usable-$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可冻结（可用资金）不足，冻结失败','url'=>__SELF__);
                }
                break;
            case 'unfeeze':
                if($wallet['wallet_pledge_freeze']>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where($wr)->setDec('wallet_pledge_freeze',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $pledge_data = array(
                            'order_no'=>createNo('auf'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_unfreeze',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'income'=>$info['money'],
                            );
                        $ac = '解冻';
                        $usable = $usable+$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可解冻资金不足，解冻失败','url'=>__SELF__);
                }
                break;
            default:
                # code...
                break;
        }
        if ($pledge_data) {
            if (M('member_pledge_bill')->add($pledge_data)) {
                // 提醒通知冻结保证金【
                    // 微信提醒内容
                    $wei_pledge_freeze['tpl'] = 'walletchange';
                    $wei_pledge_freeze['msg']=array(
                        "url"=>U('Home/Member/pledge','','html',true), 
                        "first"=>'您好，管理员后台'.$ac.'余额！',
                        "remark"=>'查看账户记录>>',
                        "keyword"=>array('余额账户',$ac.'余额','管理员'.$ac,$info['money'].'元',$usable.'元')
                    );
                    // 账户类型，操作类型、操作内容、变动额度、账户余额
                    // 站内信提醒内容
                    $web_pledge_freeze = array(
                        'title'=>'管理员'.$ac,
                        'content'=>'管理员'.$ac.'余额【'.$info['money'].'元】，单号'.$pledge_data['order_no']
                        );
                    // 短信提醒内容
                    $note_pledge_freeze = '管理员'.$ac.'余额【'.$info['money'].'元】，'.'单号'.$pledge_data['order_no'].'，您可以登陆平台查看账户记录。';
                    // 邮箱提醒内容
                    $mail_pledge_freeze['title'] = '管理员'.$ac.'余额【'.$info['money'].'元】';
                    $mail_pledge_freeze['msg'] = '您好：<br/><p>'.'管理员'.$ac.'余额【'.$info['money'].'元】'.'</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';
                    sendRemind($member,M('Member_weixin'),array(),array($info['uid']),$web_pledge_freeze,$wei_pledge_freeze,$note_pledge_freeze,$mail_pledge_freeze,'buy');
                // 提醒通知冻结保证金【
                return array('status' => 1, 'info' => '已成功'.$ac.$info['money'],'url'=>__SELF__);
            }else{
                return array('status' => 0, 'info' => '更新数据失败，请联系管理员解决！','url'=>__SELF__);
            }
        }
    }
    // 信用充值
    public function recharge_limsum($info){
        $member = M('member');
        $wr = array('uid'=>$info['uid']);
        $wallet = $member->where(array('uid'=>$info['uid']))->field('wallet_limsum,wallet_limsum_freeze')->find();
        $usable = sprintf("%.2f",$wallet['wallet_limsum']-$wallet['wallet_limsum_freeze']);
        switch ($info['act']) {
            case 'add':
                if($member->where(array('uid'=>$info['uid']))->setInc('wallet_limsum',$info['money'])){
                    // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                    $limsum_data = array(
                        'order_no'=>createNo('aad'),
                        'uid'=>$info['uid'],
                        'changetype'=>'admin_deposit',
                        'time'=>time(),
                        'annotation'=>$info['remark'],
                        'income'=>$info['money'],
                        );
                    $ac = '充值';
                    $usable = $usable+$info['money'];
                }
                break;
            case 'minus':
                if($usable>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where(array('uid'=>$info['uid']))->setDec('wallet_limsum',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $limsum_data = array(
                            'order_no'=>createNo('ami'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_deduct',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'expend'=>$info['money'],
                            );
                        $ac = '扣除';
                        $usable = $usable-$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可扣除（可用资金）不足，扣除失败','url'=>__SELF__);
                }
                
                break;
            case 'freeze':
                if($usable>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where($wr)->setInc('wallet_limsum_freeze',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $limsum_data = array(
                            'order_no'=>createNo('afr'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_freeze',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'expend'=>$info['money'],
                            );
                        $ac = '冻结';
                        $usable = $usable-$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可冻结（可用资金）不足，冻结失败','url'=>__SELF__);
                }
                break;
            case 'unfeeze':
                if($wallet['wallet_limsum_freeze']>=$info['money']){ //判断账户资金是否大于要扣除资金
                    if($member->where($wr)->setDec('wallet_limsum_freeze',$info['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $limsum_data = array(
                            'order_no'=>createNo('auf'),
                            'uid'=>$info['uid'],
                            'changetype'=>'admin_unfreeze',
                            'time'=>time(),
                            'annotation'=>$info['remark'],
                            'income'=>$info['money'],
                            );
                        $ac = '解冻';
                        $usable = $usable+$info['money'];
                    }
                }else{
                    return array('status' => 0, 'info' => '账户可解冻资金不足，解冻失败','url'=>__SELF__);
                }
                break;
            default:
                # code...
                break;
        }
        if ($limsum_data) {
            $limsum_data['business_id'] = $_SESSION['business_id'];
            if (M('member_limsum_bill')->add($limsum_data)) {
                // 提醒通知冻结保证金【
                    // 微信提醒内容
                    $wei_limsum_freeze['tpl'] = 'walletchange';
                    $wei_limsum_freeze['msg']=array(
                        "url"=>U('Home/Member/limsum','','html',true), 
                        "first"=>'您好，管理员后台'.$ac.'信用额度！',
                        "remark"=>'查看账户记录>>',
                        "keyword"=>array('信用额度账户','冻结信用额度','管理员'.$ac,$info['money'].'元',$usable.'元')
                    );
                    // 账户类型，操作类型、操作内容、变动额度、账户信用额度
                    // 站内信提醒内容
                    $web_limsum_freeze = array(
                        'title'=>'管理员'.$ac,
                        'content'=>'管理员'.$ac.'信用额度【'.$info['money'].'元】，单号'.$limsum_data['order_no']
                        );
                    // 短信提醒内容
                    $note_limsum_freeze = '管理员'.$ac.'信用额度【'.$info['money'].'元】，'.'单号'.$limsum_data['order_no'].'，您可以登陆平台查看账户记录。';
                    // 邮箱提醒内容
                    $mail_limsum_freeze['title'] = '管理员'.$ac.'信用额度【'.$info['money'].'元】';
                    $mail_limsum_freeze['msg'] = '您好：<br/><p>'.'管理员'.$ac.'信用额度【'.$info['money'].'元】'.'</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';
                    sendRemind($member,M('Member_weixin'),array(),array($info['uid']),$web_limsum_freeze,$wei_limsum_freeze,$note_limsum_freeze,$mail_limsum_freeze,'buy');
                // 提醒通知冻结保证金【
                return array('status' => 1, 'info' => '已成功'.$ac.$info['money'],'url'=>__SELF__);
            }else{
                return array('status' => 0, 'info' => '更新数据失败，请联系管理员解决！','url'=>__SELF__);
            }
        }
    }
}
?>
