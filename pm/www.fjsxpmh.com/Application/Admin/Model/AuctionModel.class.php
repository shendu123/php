<?php
namespace Admin\Model;
use Think\Model\ViewModel;
use Com\Wechat;
use Com\WechatAuth;
class AuctionModel extends ViewModel {
    Protected $viewFields = array(
        'Auction' => array(
            'pid', 'gid','type','pname','starttime','endtime','endstatus','uid','aid','pattern','sid','mid',
            '_type' => 'LEFT'
            ),
        'Goods' => array(
            'cid','pictures','sellerid',
            '_on' => 'Auction.gid = Goods.id',
            '_type' => 'LEFT'
            ),
        'Special_auction' => array(
            'sname',
            '_on' => 'Auction.sid = Special_auction.sid',
            '_type' => 'LEFT'
            ),
        'Meeting_auction' => array(
            'mname',
            '_on' => 'Auction.mid = Meeting_auction.mid'
            )
    );
    
    /**
     * [listAuction description]
     * @param  integer $firstRow [分页起始]
     * @param  integer $listRows [分页结束]
     * @param  [type]  $where    [筛选条件]
     * @return [type]            [拍品列表]
     */
    public function listAuction($firstRow = 0, $listRows = 20, $where,$od) {
        $list = $this->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        $member=M('member');
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        $cidArr = M("Goods_category")->field("`cid`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($cidArr);
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
            $list[$k]['cidName'] = $cids[$v['cid']]['name'];
            $uPath = $cat->getPath($v['cid']);
            $list[$k]['pidName'] = $uPath[0]['name'];
            $picarr = explode('|', $v['pictures']);
            $list[$k]['pimg'] = $picarr[0];
            // 拍品状态
            $ntime = time();
            if($v['starttime']<=$ntime&&$v['endtime']>=$ntime){
                $list[$k]['st'] = '在拍';
            }elseif ($v['endtime']<$ntime) {
                if($v['endstatus']==1){
                    $list[$k]['st'] = '成交';
                }elseif ($v['endstatus']==2||$v['endstatus']==3) {
                    $list[$k]['st'] = '流拍';
                }elseif ($v['endstatus']==4) {
                    $list[$k]['st'] = '撤拍';
                }
            }elseif ($v['starttime']>$ntime) {
                $list[$k]['st'] = '待拍';
            }
            $list[$k]['seller'] = $member->where(array('uid'=>$v['sellerid']))->field('account,nickname,avatar')->find();
        }
        return $list;
    }
    // 添加编辑拍品
    public function addEdit($act){
        $info = I('post.info');
        $auction = M('Auction');
        if($info['type']==1&&$info['stepsize_type']==0){
            echojson(array('status' => 0, 'info' => '（竞标模式）下《价格浮动》应该设置为《定额》'));
            exit;
        }
        if($info['succtype']==1){
            if($info['type']==1){
                echojson(array('status' => 0, 'info' => '（竞标模式）下，《成交模式》必须为《普通模式》'));
                exit;
            }
            if($info['succprice']<$info['price']){
                echojson(array('status' => 0, 'info' => '即时成交模式，成交价格必须大于等于保留价'));
                exit;
            }
        }
        if($act=='edit'){
            $nowsta = $auction->where(array('pid'=>$info['pid']))->getField('endstatus');
            if($nowsta!=0){
                echojson(array('status' => 0, 'info' => '拍品已结束禁止编辑！'));
                exit;
            }
        }
        // 价格浮动方式
        if($info['stepsize_type'] == 0){
            $info['stepsize'] = $info['stepsize_ratio'].','.$info['stepsize_ratio_r'].','.$info['stepsize_ratio_s'].','.$info['stepsize_ratio_t'];
            unset($info['stepsize_ratio']);
            unset($info['stepsize_ratio_r']);
            unset($info['stepsize_ratio_s']);
            unset($info['stepsize_ratio_t']);
        }elseif ($info['stepsize_type'] == 1) {
            $info['stepsize'] = $info['step_fixation'];
            unset($info['step_fixation']);
        }
        // 发布者id
        $info['aid'] = $_SESSION['my_info']['aid'];
        $info['nowprice']=$info['onset'];

        // 发布到专场----------------------------------------------------------
        if($info['to']=='zc'){
            // 判断发布商品的状态进入相应版块
            if(!$info['sid']){
                echojson(array('status' => 0, 'info' => '请选择专场','url'=>__SELF__));
                exit;
            }
            $special_auction = M('special_auction');
            $stat = $special_auction->where(array('sid'=>$info['sid']))->find();
            if(!$stat){
                echojson(array('status' => 0, 'info' => '专场不存在','url'=>__SELF__));
                exit;
            }
            $info['starttime']=$stat['starttime'];
            $info['endtime']=$stat['endtime'];
            if($info['starttime']<=time()){
                $typ='biding';
            }else{
                $typ='future';
            }
            if($stat['special_pledge_type']==1){
                $info['pattern']=2;
            }else{
                $info['pattern']=1;
            }
        // 发布到拍卖会------------------------------------------------------------------------------
        }elseif($info['to']=='pmh'){
            // 选择和判断专场不存在
            if(!$info['mid']){
                echojson(array('status' => 0, 'info' => '请选择拍卖会','url'=>__SELF__));
                exit;
            }
            $meeting_auction = M('meeting_auction');
            // 发布到拍卖会--------------------------------------------------------
            $stat =$meeting_auction->where(array('mid'=>$info['mid']))->find();
            if(!$stat){
                echojson(array('status' => 0, 'info' => '拍卖会不存在','url'=>__SELF__));
                exit;
            }
            $typ='future';
            $info['msort'] = $auction->where(array('mid'=>$info['mid']))->count()+1;
            // 拍品最早开拍/结束时间
            if($info['msort']==1){
                $info['starttime'] = $stat['starttime'];
                $info['endtime'] = $stat['starttime']+$stat['losetime'];
            }else{
                $lastbid = $auction->where(array('mid'=>$info['mid']))->order('msort desc')->find();
                $info['starttime'] = $lastbid['endtime'] + $stat['intervaltime'];
                $info['endtime'] =$info['starttime']+$stat['losetime'];

            }
            // 设置拍品最短结束时间
            $mtenftime = $info['endtime'];
            $meeting_auction->save(array('mid'=>$info['mid'],'endtime'=>$mtenftime));
            
            if($stat['meeting_pledge_type']==1){
                $info['pattern']=4;
            }else{
                $info['pattern']=3;
            }
        }else{
        // 发布到单品拍------------------------------------------------------------------------
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            // 判断拍品时间和当前时间
            if($info['endtime']<time()){
                echojson(array('status' => 0, 'info' => '拍品结束时间应该大于当前时间','url'=>__SELF__));
                exit;
            }
            // 判断发布商品的状态进入相应版块
            if($info['starttime']<=time()){
                $typ='biding';
            }else{
                $typ='future';
            }
        }
        unset($info['to']);
        if($act=='edit'){
            if($yn = $auction->save($info)){
                // 更新这个拍品的缓存【
                $redata = S(C('CACHE_FIX').'bid'.$info['pid']);
                if($redata){
                    $redata['pname'] = $info['pname'];
                    $redata['price'] = $info['price'];
                    $redata['nowprice'] = $info['nowprice'];
                    $redata['starttime'] = $info['starttime'];
                    $redata['endtime'] = $info['endtime'];
                    S(C('CACHE_FIX').'bid'.$info['pid'],$redata);
                }
                // 更新这个拍品的缓存】
                $pid = $info['pid'];
                $admsg = '更新';
            }
        }else{
            if($yn = $auction->add($info)){
                $pid = $yn;
                $auction->where('pid ='.$pid)->save(array('bidnb'=>'M'.$pid.'-'.time()));
                $admsg = '添加';
            }
        }
        if($yn){
            // 微信推送新品发布【
            if(C('Weixin.appid')&&C('Weixin.appsecret')){
                $post_weixin = I('post.weixin');
                $send = $post_weixin['send'];
                // 是否设置推送信息 设置推送则保存或者直接推送
                if($send){
                    unset($post_weixin['send']);
                    $gdata = M('Goods')->where('id ='.$info['gid'])->field('description,pictures')->find();
                    $pictures = explode('|', $gdata['pictures']);
                    $webroot = C('WEB_ROOT');
                    if($post_weixin['name']==''){
                        $post_weixin['name'] = $info['pname'];
                    }
                    if($post_weixin['comment']==''){
                        $post_weixin['comment'] = $gdata['description'];
                    }
                    if($post_weixin['toppic']==''){
                        $post_weixin['toppic'] = picRep($pictures[0],1);
                    }
                    if($post_weixin['picture']==''){
                        $post_weixin['picture'] = picRep($pictures[0],1);
                    }
                    $post_weixin['type'] = 'auction';
                    $post_weixin['rid'] = $pid;
                    $post_weixin['url'] = $webroot.U('Home/Auction/details',array('pid'=>$pid));
                    if($act=='edit'){
                        $wyn = M('weiurl')->save($post_weixin);
                        $wid = $post_weixin['id'];
                    }else{
                        $wyn = M('weiurl')->add($post_weixin);
                        $wid = $wyn;
                    }
                    if($wyn){
                        if($send==2){
                            $senddata = array($post_weixin['name'],$post_weixin['comment'],$post_weixin['url'],$webroot.__ROOT__.trim(C('UPLOADS_PICPATH'),'.').$post_weixin['toppic']);
                            // 给全部用户发送图文
                            // 获取微信登陆该站小于48小时的用户
                            $uidarr = M('member_weixin')->where(array('weitime'=>array('gt',time())))->getField('uid',true);
                            $wresult = D('Weixin')->sendNews(array('uid'=>array('in',$uidarr)),array($senddata),$wid);
                        }
                    }
                }
            }
            return array('status' => 1, 'info' => $admsg.'成功<br/>'.$wresult,'url'=>U('Auction/index',array('typ'=>$typ)));
            // 微信推送新品发布】
        }else{
            return array('status' => 0, 'info' => $admsg.'失败，请重试','url'=>__SELF__);
        }
        
    }


    /**
     * [listSpecial description]
     * @param  integer $firstRow [分页起始]
     * @param  integer $listRows [分页结束]
     * @param  [type]  $where    [筛选条件]
     * @return [type]            [拍品列表]
     */
    public function listSpecial($firstRow = 0, $listRows = 20, $where,$od) {
        $list = M('special_auction')->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
        }
        return $list;
    }
    /**
     * [listSpecial description]
     * @param  integer $firstRow [分页起始]
     * @param  integer $listRows [分页结束]
     * @param  [type]  $where    [筛选条件]
     * @return [type]            [拍品列表]
     */
    public function listMeeting($firstRow = 0, $listRows = 20, $where,$od) {
        $list = M('meeting_auction')->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
        }
        return $list;
    }
}

?>
