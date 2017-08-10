<?php
namespace Home\Model;
use Think\Model\ViewModel;
class AuctionAuditModel extends ViewModel {
    Protected $viewFields = array(
        'auction_audit' => array(
            'pid', 'gid','bidnb','type','status','pname','onset','price','nowprice','freight','pledge_type','pledge','broker_type','broker','stepsize_type','stepsize','starttime','endtime','steptime','pattern','sid','mid','succtype','succprice',
            '_type' => 'LEFT'
        ),
        'Goods' => array(
            'cid','aid','keywords','filtrate','pictures','province','city','area','description','content','sellerid',
            '_on' => 'Auction_audit.gid = Goods.id',
            '_type' => 'LEFT'
        ),
        'Member' => array(
            'organization','intro','score',
            '_on' => 'Goods.sellerid = Member.uid',
            '_type' => 'LEFT'
        ),
        'Special_auction' => array(
            'spledge',
            '_on' => 'Auction_audit.sid = Special_auction.sid',
            '_type' => 'LEFT'
        ),
        'Meeting_auction' => array(
            'mpledge',
            '_on' => 'Auction_audit.mid = Meeting_auction.mid'
        )
    );

    // 添加编辑拍品
    public function addEdit($act, $uid){
        $info = I('post.info');
        $info['business_id'] = (int) $_SESSION['business_id'];
        $info['aid'] = (int) $_SESSION['aid'];
        $info['sellerid'] = $uid;

        $order = M('Crowd_order')->where(array('crd_no' => $info['crd_no'], 'uid' => $uid))->field('crowd_id,ciid,status,auction_status')->find();
        if(empty($order)) {
            echojson(array('status' => 0, 'info' => '您的拍品所对应的申购订单不存在'));
            exit;
        }
        $auction = M('Auction_audit');
        if($info['type'] == 1 && $info['stepsize_type'] == 0){
            echojson(array('status' => 0, 'info' => '（竞标模式）下《价格浮动》应该设置为《定额》'));
            exit;
        }
        if($info['succtype'] == 1){
            if($info['type'] == 1){
                echojson(array('status' => 0, 'info' => '（竞标模式）下，《成交模式》必须为《普通模式》'));
                exit;
            }
            if($info['succprice'] < $info['price']){
                echojson(array('status' => 0, 'info' => '即时成交模式，成交价格必须大于等于保留价'));
                exit;
            }
        }
        if($act == 'edit'){
            if($order['auction_status'] > 1){
                echojson(array('status' => 0, 'info' => '拍品已提交审核禁止修改！'));
                exit;
            }
        }
        // 价格浮动方式
        if($info['stepsize_type'] == 0){
            $info['stepsize'] = $info['stepsize_ratio'].','.$info['stepsize_ratio_r'].','.$info['stepsize_ratio_s'].','.$info['stepsize_ratio_t'];
            
        }elseif ($info['stepsize_type'] == 1) {
            $info['stepsize'] = $info['step_fixation'];
        }
        unset($info['stepsize_ratio'], $info['stepsize_ratio_r'], $info['stepsize_ratio_s'], $info['stepsize_ratio_t'], $info['step_fixation']);
        $bidcof = C('Auction');
        $info['broker'] =$bidcof['broker_'.$bidcof['broker_type']];
        $info['broker_type'] = $bidcof['broker_type'];
        // 发布者id
        $info['nowprice']=$info['onset'];

        if($info['to'] == 'zc') { // 发布到专场----------------------------------------------------------
            // 判断发布商品的状态进入相应版块
            if(!$info['sid']) {
                echojson(array('status' => 0, 'info' => '请选择专场','url'=>__SELF__));
                exit;
            }
            $special_auction = M('special_auction');
            $stat = $special_auction->where(array('sid'=>$info['sid']))->find();
            if(!$stat) {
                echojson(array('status' => 0, 'info' => '专场不存在','url'=>__SELF__));
                exit;
            }
            $info['starttime']=$stat['starttime'];
            $info['endtime']=$stat['endtime'];
            if($info['starttime'] <= time()) {
                $typ='biding';
            } else {
                $typ='future';
            }
            if($stat['special_pledge_type'] == 1) {
                $info['pattern'] = 2;
            } else {
                $info['pattern'] = 1;
            }
        } else if($info['to'] == 'pmh') { // 发布到拍卖会------------------------------------------------------------------------------
            // 选择和判断专场不存在
            if(!$info['mid']){
                echojson(array('status' => 0, 'info' => '请选择拍卖会','url'=>__SELF__));
                exit;
            }
            $meeting_auction = M('meeting_auction');
            // 发布到拍卖会--------------------------------------------------------
            $stat = $meeting_auction->where(array('mid'=>$info['mid']))->find();
            if(!$stat){
                echojson(array('status' => 0, 'info' => '拍卖会不存在','url'=>__SELF__));
                exit;
            }
            $typ = 'future';
            $info['msort'] = M('Auction')->where(array('mid'=>$info['mid']))->count()+1;
            // 拍品最早开拍/结束时间
            if($info['msort'] == 1){
                $info['starttime'] = $stat['starttime'];
                $info['endtime'] = $stat['starttime']+$stat['losetime'];
            } else {
                $lastbid = M('Auction')->where(array('mid'=>$info['mid']))->order('msort desc')->find();
                $info['starttime'] = $lastbid['endtime'] + $stat['intervaltime'];
                $info['endtime'] = $info['starttime'] + $stat['losetime'];
            }

            if($stat['meeting_pledge_type'] == 1){
                $info['pattern'] = 4;
            } else {
                $info['pattern'] = 3;
            }
        } else { // 发布到单品拍------------------------------------------------------------------------
            $info['starttime'] = strtotime($info['starttime']);
            $info['endtime'] = strtotime($info['endtime']);
            // 判断拍品时间和当前时间
            if($info['endtime'] < time()){
                echojson(array('status' => 0, 'info' => '拍品结束时间应该大于当前时间', 'url' => __SELF__));
                exit;
            }
            // 判断发布商品的状态进入相应版块
            if($info['starttime'] <= time()){
                $typ = 'biding';
            }else{
                $typ = 'future';
            }
        }
        unset($info['to']);

        if($act=='add'){
            // 冻结保证金后添加拍卖
            $deduct = D('Auction')->check_freeze_pledge($uid, 1, $info['onset'], 'auction_audit');
            if($deduct['status'] == 0){
                return $deduct;
                exit;
            } else {
                unset($info['pid']);
                if($yn = $auction->add($info)){
                    $info['pid'] = $yn;
                    $auction->where('pid ='.$info['pid'])->save(array('bidnb'=>'M'.$info['pid'].'-'.time()));
                    D('CrowdOrder')->where('crd_no ="'.$info['crd_no'].'"')->save(array('auction_status' =>  2));
                    $bidObj = $auction->where('pid ='.$info['pid'])->find();
                    D('Auction')->send_freeze_sel($deduct, $bidObj);
                    $admsg = '添加';
                }
            }
        }
        if($yn || $yn === 0){
            return array('status' => 1, 'info' => $admsg.'成功<br/>'.$wresult,'url'=>U('auctionList',array('typ'=>$typ)));
            // 微信推送新品发布】
        }else{
            return array('status' => 0, 'info' => $admsg.'失败，请重试','url'=>__SELF__);
        }
    }
}
?>
