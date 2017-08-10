<?php
namespace Home\Model;
use Think\Model\ViewModel;
class PaymentModel extends ViewModel {
    // 余额支付
    public function yuepaySend($ainfo,$money,$order_no,$uid){
        $member = M('Member');
        $mod = '商品：“<a href="'.U('Home/Auction/details',array('pid'=>$ainfo['pid'],'aptitude'=>1)).'">'.$ainfo['pname'].'</a>”';
        $omode = '订单号：“<a href="'.U('Home/Member/order_details',array('order_no'=>$order_no,'aptitude'=>1)).'">'.$order_no.'</a>”';
        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
        $pledge_data = array(
            'order_no'=>$order_no,
            'uid'=>$uid,
            'changetype'=>'pay_deduct',
            'time'=>time(),
            'annotation'=>'支付'.$mod.$omode.'，支付成功！',
            'expend'=>$money,
            );
        //写入用户账户记录
        if(M('member_pledge_bill')->add($pledge_data)){
        // 提醒通知支付成功【
            $wallet = $member->where(array('uid'=>$uid))->field('wallet_pledge,wallet_pledge_freeze')->find();
            $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
            // 微信提醒内容
            $wei_yupay['tpl'] = 'walletchange';
            $wei_yupay['msg']=array(
                "url"=>U('Member/pledge','','html',true), 
                "first"=>"您好，".'使用【账户余额】支付拍卖订单成功！',
                "remark"=>'查看账户记录>>',
                "keyword"=>array('余额账户','支付拍品订单扣除余额','商品订单:'.$order_no,'-'.$money.'元',$usable.'元')
            );
            // 账户类型，操作类型、操作内容、变动额度、账户余额
            // 站内信提醒内容
            $web_yupay = array(
                'title'=>'支付订单',
                'content'=>'支付'.$mod.$omode.'扣除余额'.$money.'元'
                );
            // 短信提醒内容
            if(mb_strlen($ainfo['pname'],'utf-8')>10){
                $newname = mb_substr($ainfo['pname'],0,10,'utf-8').'...';
            }else{
                $newname = $ainfo['pname'];
            }
            $note_yupay = '使用余额支付商品“'.$newname.'”订单号'.$order_no.'扣除【'.$money.'元】，账户可用余额【'.$usable.'元】您可以登陆平台查看账户记录。';
            // 邮箱提醒内容
            $mail_yupay['title'] = '支付订单成功';
            $mail_yupay['msg'] = '您好：<br/><p>'.$pledge_data['annotation'].'</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';

            sendRemind($member,M('Member_weixin'),array(),array($uid),$web_yupay,$wei_yupay,$note_yupay,$mail_yupay,'buy');
            return 1;
        // 提醒通知支付成功【
        }else{
            return 0;
        }
    }
    // 保证金抵货款支付
    public function pledgepaySend($ainfo,$pledge,$order_no,$uid){
        $member = M('Member');
        $mod = '商品：“<a href="'.U('Home/Auction/details',array('pid'=>$ainfo['pid'],'aptitude'=>1)).'">'.$ainfo['pname'].'</a>”';
        $omode = '订单号：“<a href="'.U('Home/Member/order_details',array('order_no'=>$order_no,'aptitude'=>1)).'">'.$order_no.'</a>”';
        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
        $pledge_data = array(
            'order_no'=>$order_no,
            'uid'=>$uid,
            'changetype'=>'pay_pledge',
            'time'=>time(),
            'annotation'=>'保证金抵'.$mod.'货款【'.$pledge.'元】！'.$omode,
            'expend'=>$pledge,
            );
        //写入用户账户记录
        if(M('member_pledge_bill')->add($pledge_data)){
            // 提醒通知保证金抵货款成功【
                $wallet = $member->where(array('uid'=>$uid))->field('wallet_pledge,wallet_pledge_freeze')->find();
                $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
                // 微信提醒内容
                $wei_pledgepay['tpl'] = 'walletchange';
                $wei_pledgepay['msg']=array(
                    "url"=>U('Member/pledge','','html',true), 
                    "first"=>"您好，".'【保证金抵货款】抵款成功！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('冻结的保证金','保证金抵货款','商品订单:'.$order_no,'-'.$pledge.'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_pledgepay = array(
                    'title'=>'保证金抵货款',
                    'content'=>$pledge_data['annotation']
                    );
                // 短信提醒内容
                if(mb_strlen($bidinfo['pname'],'utf-8')>10){
                    $newname = mb_substr($bidinfo['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidinfo['pname'];
                }
                $note_pledgepay = '保证金抵商品“'.$newname.'”货款【'.$pledge.'元】，订单号'.$order_no.'货款，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_pledgepay['title'] = '保证金抵货款';
                $mail_pledgepay['msg'] = '您好：<br/><p>'.$pledge_data['annotation'].'</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';

                sendRemind($member,M('Member_weixin'),array(),array($uid),$web_pledgepay,$wei_pledgepay,$note_pledgepay,$mail_pledgepay,'buy');
            // 提醒通知保证金抵货款成功【
                return 1;
        }else{
            return 0;
        }
    }
    // 余额支付
    public function onlinepaySend(){

    }
}
?>
