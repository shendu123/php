<?php
namespace Home\Model;
use Think\Model\ViewModel;
class AuctionModel extends ViewModel {
    Protected $viewFields = array(
        'Auction' => array(
            'pid', 'gid','bidnb','type','status','pname','onset','price','nowprice','freight','pledge_type','pledge','broker_type','broker','stepsize_type','stepsize','starttime','endtime','uid','bidcount','endstatus','steptime','deferred','clcount','pattern','sid','mid','msort','succtype','succprice','agency_uid','agency_price',
            '_type' => 'LEFT'
            ),
        'Goods' => array(
            'cid','aid','keywords','filtrate','pictures','province','city','area','description','content','sellerid',
            '_on' => 'Auction.gid = Goods.id',
            '_type' => 'LEFT'
            ),
        'Member' => array(
            'organization','intro','score',
            '_on' => 'Goods.sellerid = Member.uid',
            '_type' => 'LEFT'
            ),
        'Special_auction' => array(
            'spledge',
            '_on' => 'Auction.sid = Special_auction.sid',
            '_type' => 'LEFT'
            ),
        'Meeting_auction' => array(
            'mpledge',
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
        $member = M('member');
        $goods_order = M('goods_order');
        $auction_record = M('auction_record');
        $cidArr = M("Goods_category")->field("`cid`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($cidArr);
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
        foreach ($list as $k => $v) {
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
                    $list[$k]['order_no'] = $goods_order->where(array('gid'=>$v['pid'],'sellerid'=>$v['sellerid'],'uid'=>$v['uid']))->getField('order_no');
                }elseif ($v['endstatus']==2||$v['endstatus']==3) {
                    $list[$k]['st'] = '流拍';
                }elseif ($v['endstatus']==4) {
                    $list[$k]['st'] = '撤拍';
                }
            }elseif ($v['starttime']>$ntime) {
                $list[$k]['st'] = '待拍';
            }
            if ($auction_record->where(array('pid'=>$v['pid']))->count()||$v['endstatus']==0) {
                $list[$k]['bid'] = 0;
            }else{
                $list[$k]['bid'] = 1;
            }
            
        }
        return $list;
    }
    // 检查卖家保证金和冻结操作
    //$uid:用户id,
    //$freeze：是否冻结：0仅验证，1冻结保证金;
    //$onset起拍价
    //$from auction : 拍卖表，auction_audit 拍卖审核表
    public function check_freeze_pledge($uid,$freeze=0,$onset = 0, $from ='auction'){
        // 判断发布商品的权限[seller_pledge_disposable]一次性缴纳；[seller_pledge_every]每件缴纳；[seller_pledge_proportion]按照起拍比例缴纳
        $seller_pledge = M('seller_pledge');
        // 检查是否已经缴纳过一次性保证金；如果缴纳过一次性保证金通过验证
        if($spid = $seller_pledge->where(array('sellerid'=>$uid,'type'=>'disposable','status'=>'1'))->find()){
            $uLimit['yn']=1;
        // 读取后台设置缴纳方式
        }else{
            // 读取保证金收取方式和金额
            $pledge_type = C('Auction.seller_pledge_type');
            $pledge = C('Auction.'.$pledge_type);
            $uLimit = getwallet($uid);
            $uLimit['yn']=0;
            $uLimit['maxprice'] = 0;
            switch ($pledge_type) {
                // 一次缴纳保证金任意发布拍卖
                case 'seller_pledge_disposable':
                    if($uLimit['count']<$pledge){
                        $uLimit['msg'] = '发布拍卖只需一次性缴纳<span>'.$pledge.'元</span>保证金，便可以任意发布拍卖!';
                    }else{
                        $uLimit['yn']=1;
                        $uLimit['alert'] = '发布拍卖冻结您保证金<span>'.$pledge.'元</span>，冻结后将不限制您发布拍卖的数量！';
                        $fpledge = $pledge;
                    }
                    $uLimit['pledge_type'] = 'disposable';
                    break;
                // 每发布一件拍卖冻结保证金
                case 'seller_pledge_every':
                    if($uLimit['count']<$pledge){
                        $uLimit['msg'] = '每发布一件拍卖需缴纳保证金<span>'.$pledge.'元</span>！';
                    }else{
                        $uLimit['yn']=1;
                        $uLimit['alert'] = '本次发布拍卖将冻结您保证金<span>'.$pledge.'元</span>！';
                        $fpledge = $pledge;
                    }
                    $uLimit['pledge_type'] = 'every';
                    break;
                // 按照起拍价比例冻结保证金
                case 'seller_pledge_proportion':
                    if($uLimit['count']<=0){
                        $uLimit['msg'] = '请充值保证金！';
                    }else{
                        $uLimit['yn']=1;
                        // 可发布拍品起拍价
                        $uLimit['maxprice'] = $uLimit['count']/($pledge/100);
                        $uLimit['alert'] = '发布本次拍卖冻结起拍价的<span>'.$pledge.'%</span>作为保证金，'.'当前余额限定您的起拍价不得超过<span>'.$uLimit['maxprice'].'元</span>！您可以充值余额来提高起拍价！';
                        $fpledge = $onset*($pledge/100);
                        // 在冻结请求下需要冻结金额大于账户余额时候返回假

                        if($freeze&&$fpledge>$uLimit['count']){
                            $uLimit['yn']=0;
                            $uLimit['msg'] = '您的余额不足以发布起拍价为'.$onset.'元的拍品！';
                        }
                    }
                    $uLimit['pledge_type'] = 'proportion';
                    break;
            }
        }
        if (C('Auction.broker_type')=='ratio') {
            $uLimit['alert'] = $uLimit['alert'].'成交后平台将收取成交价的<span>'.C('Auction.broker_'.C('Auction.broker_type')).'%</span>作为'.C('Auction.broker_name').'！';
        }else{
            $uLimit['alert'] = $uLimit['alert'].'成交后平台将收取'.C('Auction.broker_name').'<span>'.C('Auction.broker_'.C('Auction.broker_type')).'元</span>！';
        }
        if ($freeze) {
            // 如果没有缴纳过一次冻结保证金的disposable类型实行冻结保证金
            if(!$spid){
                // 冻结保证金操作
                if($uLimit['yn']){
                    $member = M('member');
                    // 优先冻结信誉额度
                    $chazhi = $uLimit['limsum'] - $fpledge;
                    $uwhere = array('uid'=>$uid);
                    $authdata=array(
                        'sellerid'=>$uid,
                        'type'=>$uLimit['pledge_type'],
                        'time'=>time(),
                        'status'=>1,
                        'from' => $from
                    );
                    if($chazhi>=0){
                        $authdata['limsum'] = $fpledge;
                        $authdata['pledge'] = '';
                    }else{
                        if($uLimit['limsum']>0){
                            $authdata['pledge'] = abs($chazhi);
                            $authdata['limsum'] = $uLimit['limsum'];
                            // 冻结保证金
                        }else{
                            $authdata['pledge'] = $fpledge;
                            $authdata['limsum'] = '';
                        }
                    }
                    // 冻结卖家信誉额度
                    if(($authdata['limsum']>0&&$member->where('uid='.$uid)->setInc('wallet_limsum_freeze',$authdata['limsum']))||$authdata['limsum']==0){
                        $limsum_data = array(
                            'order_no'=>createNo('add'),
                            'uid'=>$uid,
                            'changetype'=>'add_freeze',
                            'time'=>time(),
                            'expend'=>$authdata['limsum'],
                            );
                        $limsum_bill = M('member_limsum_bill')->add($limsum_data);
                    }
                    // 冻结卖家保证金
                    if(($authdata['pledge']>0&&$member->where('uid='.$uid)->setInc('wallet_pledge_freeze',$authdata['pledge']))||$authdata['pledge']==0){
                        $pledge_data = array(
                            'order_no'=>createNo('add'),
                            'uid'=>$uid,
                            'changetype'=>'add_freeze',
                            'time'=>time(),
                            'expend'=>$authdata['pledge'],
                            );
                        $pledge_bill = M('member_pledge_bill')->add($pledge_data);
                    }
                    if($pledge_bill||$limsum_bill){
                        $spid = M('seller_pledge')->add($authdata);
                        return array('status'=>1,'info'=>'冻结保证金成功！','spid'=>$spid,'order_no'=>array('limsum'=>$limsum_data['order_no'],'pledge'=>$pledge_data['order_no']));
                    }else{
                        return array('status'=>0,'info'=>'冻结保证金失败，请联系管理员进行解决！');
                    }
                }else{
                    return array('status'=>0,'info'=>$uLimit['msg'].'请充值！','url'=>U('Member/payment'));
                }
            }else{
                return array('status'=>1,'info'=>'属于一次缴纳保证金任意发布拍卖类型','spid'=>$spid);
            }
        }else{
            return $uLimit;
        }
        
    }
    // 冻结卖家保证金和信誉额度
    public function send_freeze_sel($deduct,$bidObj){
        $member = M('Member');
        // $deduct['order_no']['limsum']
        // $deduct['order_no']['pledge']
        $seller_pledge = M('seller_pledge');
        $pledge_bill = M('member_pledge_bill');
        $limsum_bill = M('member_limsum_bill');
        $seller_pledge->save(array('id'=>$deduct['spid'],'pid'=>$bidObj['pid']));
        $info = $seller_pledge->where(array('id'=>$deduct['spid']))->find();
        if($info['from'] == 'auction') {
            $annotation = '发布拍卖：【<a href="'.U('Auction/details',array('pid'=>$bidObj['pid'],'aptitude'=>1)).'">'.$bidObj['pname'].'</a>】';
        } else {
            $annotation = '发布拍卖：【'.$bidObj['pname'].'】';
        }

        // 是否记录有保证金
        if($deduct['order_no']['limsum']){
            $limsum_updata=$annotation.'冻结信誉额度【'.$info['limsum'].'元】！';
            $limsum_bill->where(array('order_no'=>$deduct['order_no']['limsum']))->setField('annotation',$limsum_updata);
            $wallet = $member->where(array('uid'=>$info['sellerid']))->field('wallet_limsum,wallet_limsum_freeze')->find();
            $usable = $wallet['wallet_limsum']-$wallet['wallet_limsum_freeze'];
            // 提醒通知冻结信誉额度【
                // 微信提醒内容
                $wei_limsum_freeze['tpl'] = 'walletchange';
                $wei_limsum_freeze['msg']=array(
                    "url"=>U('Member/limsum','','html',true), 
                    "first"=>"您好，".'发布拍卖“'.$bidObj['pname'].'”冻结信誉额度！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('信誉额度账户','发布拍卖冻结信誉额度','订单:'.$deduct['order_no']['limsum'],'-'.$info['limsum'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_limsum_freeze = array(
                    'title'=>'发布拍卖冻结信誉额度',
                    'content'=>$annotation.'冻结信誉额度【'.$info['limsum'].'元】'
                    );
                // 短信提醒内容
                if(mb_strlen($bidObj['pname'],'utf-8')>10){
                    $newname = mb_substr($bidObj['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidObj['pname'];
                }
                $note_limsum_freeze = '发布拍卖“'.$newname.'”冻结信誉额度【'.$info['limsum'].'元】，单号'.$deduct['order_no']['limsum'].'，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_limsum_freeze['title'] = '发布拍卖冻结信誉额度';
                $mail_limsum_freeze['msg'] = '您好：<br/><p>'.$limsum_updata.'</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';

                sendRemind(M('member'),M('Member_weixin'),array(),array($info['sellerid']),$web_limsum_freeze,$wei_limsum_freeze,$note_limsum_freeze,$mail_limsum_freeze,'sel');
            // 提醒通知冻结信誉额度【
        }
        // 是否记录有信誉额度
        if($deduct['order_no']['pledge']){
            $pledge_updata = $annotation.'冻结保证金【'.$info['pledge'].'元】！';
            $pledge_bill->where(array('order_no'=>$deduct['order_no']['pledge']))->setField('annotation',$pledge_updata);

            $wallet = $member->where(array('uid'=>$info['sellerid']))->field('wallet_pledge,wallet_pledge_freeze')->find();
            $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
            // 提醒通知冻结保证金【
                // 微信提醒内容
                $wei_pledge_freeze['tpl'] = 'walletchange';
                $wei_pledge_freeze['msg']=array(
                    "url"=>U('Member/pledge','','html',true), 
                    "first"=>"您好，".'发布拍卖“'.$bidObj['pname'].'”冻结保证金！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('余额账户','发布拍卖冻结信誉额度','订单:'.$deduct['order_no']['pledge'],'-'.$info['pledge'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_pledge_freeze = array(
                    'title'=>'发布拍卖冻结保证金',
                    'content'=>$annotation.'冻结保证金【'.$info['pledge'].'元】'
                    );
                // 短信提醒内容
                if(mb_strlen($bidObj['pname'],'utf-8')>10){
                    $newname = mb_substr($bidObj['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidObj['pname'];
                }
                $note_pledge_freeze = '发布拍卖冻结“'.$newname.'”冻结保证金【'.$info['pledge'].'元】，单号'.$deduct['order_no']['pledge'].'，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_pledge_freeze['title'] = '发布拍卖冻结保证金';
                $mail_pledge_freeze['msg'] = '您好：<br/><p>'.$pledge_updata.'</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';

                sendRemind(M('member'),M('Member_weixin'),array(),array($info['sellerid']),$web_pledge_freeze,$wei_pledge_freeze,$note_pledge_freeze,$mail_pledge_freeze,'sel');
            // 提醒通知冻结保证金【
        }
    }
    // 添加编辑拍品
    public function addEdit($act,$uid){
        $info = I('post.info');
        $info['business_id'] = (int) $_SESSION['business_id'];
        $info['aid'] = (int) $_SESSION['aid'];
        $info['sellerid'] = $uid;

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
            
        }elseif ($info['stepsize_type'] == 1) {
            $info['stepsize'] = $info['step_fixation'];
            
        }
        unset($info['stepsize_ratio'],$info['stepsize_ratio_r'],$info['stepsize_ratio_s'],$info['stepsize_ratio_t'],$info['step_fixation']);
        $bidcof=C('Auction');
        $info['broker'] =$bidcof['broker_'.$bidcof['broker_type']];
        $info['broker_type'] = $bidcof['broker_type'];
        // 发布者id
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
            if (M('auction_record')->where(array('pid'=>$info['pid']))->count()==0) {
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
                return array('status' => 0, 'info' => '已有人出价禁止编辑拍卖','url'=>__SELF__);
            }
        }
        if($act=='add'){
            // 冻结保证金后添加拍卖
            $deduct = $this->check_freeze_pledge($uid,1,$info['onset']);
            if($deduct['status']==0){
                return $deduct;
                exit;
            }else{
                unset($info['pid']);
                if($yn = $auction->add($info)){
                    $info['pid'] = $yn;
                    $auction->where('pid ='.$info['pid'])->save(array('bidnb'=>'M'.$info['pid'].'-'.time()));
                    $bidObj = $auction->where('pid ='.$info['pid'])->find();
                    $this->send_freeze_sel($deduct,$bidObj);
                    $admsg = '添加';
                }
            }
        }
        if($yn || $yn === 0){
            // 微信推送新品发布【
            if(C('Weixin.appid')&&C('Weixin.appsecret')){
                // 拍卖上架提醒【
                auction_putaway($uid,$info);
                // 拍卖上架提醒】
                // 图文推送
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
                    $post_weixin['rid'] = $info['pid'];
                    $post_weixin['url'] = U('Home/Auction/details',array('pid'=>$info['pid']),'html',true);
                    $post_weixin['sellerid'] = $uid;
                    if($post_weixin['id']){
                        $wid = $post_weixin['id'];
                        $wyn = M('weiurl')->save($post_weixin);
                    }else{
                        $wyn = M('weiurl')->add($post_weixin);
                        $wid = $wyn;
                    }
                    if($wyn){
                        if($send==2){
                            $senddata = array($post_weixin['name'],$post_weixin['comment'],$post_weixin['url'],$webroot.trim(C('UPLOADS_PICPATH'),'./').'/'.$post_weixin['toppic']);
                            // 获取符合条件的推送用户
                            $uidarr = eligibility($uid,1);
                            if(!empty($uidarr)){
                                $wresult = D('Weixin')->sendNews(array('uid'=>array('in',$uidarr)),array($senddata),$wid);
                            }else{
                                $wresult = '没有符合推动条件的用户！';
                            }
                        }
                    }
                }
            }
            return array('status' => 1, 'info' => $admsg.'成功<br/>'.$wresult,'url'=>U('auctionList',array('typ'=>$typ)));
            // 微信推送新品发布】
        }else{
            return array('status' => 0, 'info' => $admsg.'失败，请重试','url'=>__SELF__);
        }
    }
    /**
     * [catList 频道分类列表]
     * @param  [type] $gt        [获取的get值]
     * @param  [type] $cat_inCid [频道下的所有分类]
     * @return [type]            [返回频道下分类列表]
     */
    public function catList($gt,$catW,$bidTp = 'ing'){
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name'));
        switch ($bidTp) {
          case 'wait':
            $bidTpFun = foreshow(0);
            break;
          case 'end':
            $bidTpFun = endbid(0);
            break;
          default:
            $bidTpFun = bidSection(0);
            break;
        }

        $cate_where = array_merge($bidTpFun,$catW);

        $bid_cid = $this->where($cate_where)->getField('cid',true);
        $clist = array();
        $cate_arr = array();
        if ($bid_cid) {
            foreach ($bid_cid as $bidk => $bcid) {
                    $catPath = $cat->getPath($bcid);
                    if(!in_array($catPath[1],$cate_arr)&&count($catPath)!=1){
                        $clist[] = array_merge($catPath[1],array('gt'=>$catPath[1]['cid'].'-'.$gt[1].'-'.$gt[2].'-'.$gt[3].'-'.getTopField($catPath[1]['cid']).'-'.$gt[5].'-'.$gt[6]));
                    }
                    $cate_arr[] = $catPath[1]; //如果获取过该分类的顶级分类id，就不在循环获取
            }
        }
        return $clist;
    }
    /**
     * [set_page 生成设置分页数量列表]
     * @param [type] $gt [获取的get值]
     */
    public function set_page($gt){
        return array(
        array('key'=>12,'sz'=>'12','href'=>U(ACTION_NAME,array('gt'=>$gt[0].'-'.'12'.'-'.$gt[2].'-'.$gt[3].'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]))),
        array('key'=>16,'sz'=>'16','href'=>U(ACTION_NAME,array('gt'=>$gt[0].'-'.'16'.'-'.$gt[2].'-'.$gt[3].'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]))),
        array('key'=>20,'sz'=>'20','href'=>U(ACTION_NAME,array('gt'=>$gt[0].'-'.'20'.'-'.$gt[2].'-'.$gt[3].'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]))),
        array('key'=>40,'sz'=>'40','href'=>U(ACTION_NAME,array('gt'=>$gt[0].'-'.'40'.'-'.$gt[2].'-'.$gt[3].'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]))),
        );
    }
    /**
     * [end_section 生成正在拍卖时间段筛选]
     * @param  [type] $gt        [获取GET值]
     * @param  [type] $gt0       [频道]
     * @param  [type] $merW      [分类条件]
     * @return [type]            [返回时间段结束列表和统计]
     */
    public function end_section($gt,$gt0,$merW){
        return array(
        array('key'=>0,'name'=>'全部','href'=>U('Auction/index',array('gt'=>$gt0.'-'.$gt[1].'-'.'0'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(bidSection(0),$merW))->count()),
        array('key'=>1,'name'=>'今天结束','href'=>U('Auction/index',array('gt'=>$gt0.'-'.$gt[1].'-'.'1'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(bidSection(1),$merW))->count()),
        array('key'=>2,'name'=>'明天结束','href'=>U('Auction/index',array('gt'=>$gt0.'-'.$gt[1].'-'.'2'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(bidSection(2),$merW))->count()),
        array('key'=>3,'name'=>'后天结束','href'=>U('Auction/index',array('gt'=>$gt0.'-'.$gt[1].'-'.'3'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(bidSection(3),$merW))->count()),
        array('key'=>4,'name'=>'其他结束','href'=>U('Auction/index',array('gt'=>$gt0.'-'.$gt[1].'-'.'4'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(bidSection(4),$merW))->count())
        );
    }
    /**
     * [end_section 生成即将拍卖时间段筛选]
     * @param  [type] $gt        [获取GET值]
     * @param  [type] $gt0       [频道]
     * @param  [type] $merW      [分类条件]
     * @return [type]            [返回时间段结束列表和统计]
     */
    public function wait_section($gt,$gt0,$merW){
        return array(
        array('key'=>0,'name'=>'全部','href'=>U('Auction/waitbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'0'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(foreshow(0),$merW))->count()),
        array('key'=>1,'name'=>'即将开拍','href'=>U('Auction/waitbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'1'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(foreshow(1),$merW))->count()),
        array('key'=>2,'name'=>'明天开拍','href'=>U('Auction/waitbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'2'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(foreshow(2),$merW))->count()),
        array('key'=>3,'name'=>'后天开拍','href'=>U('Auction/waitbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'3'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(foreshow(3),$merW))->count()),
        array('key'=>4,'name'=>'其他开拍','href'=>U('Auction/waitbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'4'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(foreshow(4),$merW))->count())
        );
    }
    /**
     * [end_section 生成已成交时间段筛选]
     * @param  [type] $gt        [获取GET值]
     * @param  [type] $gt0       [频道]
     * @param  [type] $merW      [分类条件]
     * @return [type]            [返回时间段结束列表和统计]
     */
    public function endbid_section($gt,$gt0,$merW){
        return array(
        array('key'=>0,'name'=>'全部','href'=>U('Auction/endbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'0'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(endbid(0),$merW))->count()),
        array('key'=>1,'name'=>'今天成交','href'=>U('Auction/endbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'1'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(endbid(1),$merW))->count()),
        array('key'=>2,'name'=>'昨天成交','href'=>U('Auction/endbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'2'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(endbid(2),$merW))->count()),
        array('key'=>3,'name'=>'前天成交','href'=>U('Auction/endbid',array('gt'=>$gt0.'-'.$gt[1].'-'.'3'.'-'.'0_0_0'.'-'.getTopField($gt[0]).'-'.$gt[5].'-'.$gt[6])),
          'count'=>$this->where(array_merge(endbid(3),$merW))->count()),
        );
    }
    /**
     * [regionList 符合条件拍品所在地区及数量]
     * @param  [type] $gt   [获取GET值]
     * @param  [type] $rg_w [条件]
     * @return [type]       [放回组合后的数据]
     */
    public function regionList($gt,$rg_w){
        $aList = $this->where($rg_w)->field(array('pid','province','city','area'))->select();
        $regionM = M('region');
        // 获取到有几个省
        $region = array();
        $rk = 0;
        $province = array();
        //省级统计
        if ($aList) {
            foreach ($aList as $alk => $alv) {
                if($alv['province'] > 1){
                  if(!in_array($alv['province'], $province)){
                    $province[] = $alv['province']; //存储省级id
                    $region[$rk]['mark'] = $alv['province'];
                    $region[$rk]['href'] = U(ACTION_NAME,array('gt'=>$gt[0].'-'.$gt[1].'-'.$gt[2].'-'.$alv['province'].'_0_0'.'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]));
                    $region[$rk]['name'] = $regionM->where(array('region_id'=>$alv['province']))->getField('region_name');
                    $region[$rk]['count'] = $this->where(array_merge($rg_w,array('province'=>$alv['province'])))->count();
                      //市级统计
                      $bk = 0;
                      $city = array();
                      foreach ($aList as $blk => $blv) {
                        if($blv['city'] > 1 && $blv['province']== $alv['province']){
                          if(!in_array($blv['city'], $city)){
                            $city[] = $blv['city']; //存储市级id
                            $region[$rk]['city'][$bk]['mark'] = $blv['city'];
                            $region[$rk]['city'][$bk]['href'] = U(ACTION_NAME,array('gt'=>$gt[0].'-'.$gt[1].'-'.$gt[2].'-'.$alv['province'].'_'.$blv['city'].'_0'.'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]));
                            $region[$rk]['city'][$bk]['name'] = $regionM->where(array('region_id'=>$blv['city']))->getField('region_name');
                            $region[$rk]['city'][$bk]['count'] = $this->where(array_merge($rg_w,array('city'=>$blv['city'])))->count();
                            //
                            //地区统计
                            $ck = 0;
                            $area = array();
                            foreach ($aList as $clk => $clv) {
                              if($clv['area'] > 1 && $clv['city']== $blv['city']){
                                if(!in_array($clv['area'], $area)){
                                  $area[] = $clv['area']; //存储县级id
                                  $region[$rk]['city'][$bk]['area'][$ck]['mark'] = $clv['area'];
                                  $region[$rk]['city'][$bk]['area'][$ck]['href'] = U(ACTION_NAME,array('gt'=>$gt[0].'-'.$gt[1].'-'.$gt[2].'-'.$alv['province'].'_'.$blv['city'].'_'.$clv['area'].'-'.$gt[4].'-'.$gt[5].'-'.$gt[6]));
                                  $region[$rk]['city'][$bk]['area'][$ck]['name'] = $regionM->where(array('region_id'=>$clv['area']))->getField('region_name');
                                  $region[$rk]['city'][$bk]['area'][$ck]['count'] = $this->where(array_merge($rg_w,array('area'=>$clv['area'])))->count();
                                  $ck+=1;
                                } 
                              }
                            }
                            //
                            $bk+=1;
                          } 
                        }
                      }
                    $rk+=1;
                  }
                }
            }
        }
        
        return $region;
    }
    /**
     * 机器人定时(早上9-12点)出价
     */
    public function bidrobot(){
        $bidMap = M('Auction');
        $member = M('Member');
        $record = M('Auction_record');
        $where['account']=['like','rob%'];
        $where['status']=1;
        $memberList=$member->where($where)->field('uid,account,nickname')->select();
        foreach($memberList as $k=>$v){
            $uidList[]=$v['uid'];
        }
        $bidWhere['endtime']=['gt',time()];//拍卖结束之前
        $bidWhere['endstatus']=0;//没成交
        $bidList=$bidMap->where($bidWhere)->field('pid')->select();
        foreach($bidList as $k=>$v){
            $pidList[]=$v['pid'];
        }
        $random_uid_keys=array_rand($uidList,1);
        $uid=$uidList[$random_uid_keys];
        $random_pid_keys=array_rand($pidList,1);
        $pid=$pidList[$random_pid_keys];        
        $postData['uid']=$uid;
        $postData['pid']=$pid;
        $postData['bidType']='sd';
        $postData['agr'] = 'robot';//print_r($postData);exit;
        return $this->bidprc($postData);
    }
    /**
    * 竞拍出价
    * @param  [type] $postData [post值]
    * @return [type]           [description]
    */
    public function bidprc($postData){
        $bidMap = M('Auction');
        $member = M('Member');
        $record = M('Auction_record');
        $agency = M('auction_agency');
        $bidObj=$bidMap->where(array('pid'=>$postData['pid']))->find();
        // 浮动价格
        $stepint = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['nowprice']);

        // 竞拍处理出价--------------------------------------------------------------------------
        if($bidObj['type']==0){
            // 非首次出价，出价必须大于当前价加步长
            if($bidObj['uid']){
                $reference = $bidObj['nowprice'] + $stepint;
            }else{
                // 首次出价起拍价大于0或者其派件小于步长，出价为起拍价
                if($info['onset']>0||$info['onset']<$stepint){
                    $reference = $bidObj['onset'];
                // 等于小于0出价必须为步长
                }else{
                    $reference = $stepint;
                }
            }
            // 判断是否符合出价要求
            if(bccomp($postData['bidPric'],99999999.99,2) == 1){
                return array("status" => 2, "msg" => '出价太大了！');
                exit;
            }
            //机器人定时(早上9-12点)出价
            $start   = strtotime(date("Y-m-d 9:00:00"));
            $end   = strtotime(date("Y-m-d 12:00:00"));
            if($postData['agr']=='robot'){//die;
                $step['stepsize'] = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['nowprice']);
                $postData['bidPric'] = $bidObj['nowprice']+$step['stepsize'];                
            }
//            if($postData['agr']=='robot' && time() > $start && time() < $end){     die;          
//                $step['stepsize'] = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['nowprice']);
//                $postData['bidPric'] = $bidObj['nowprice']+$step['stepsize'];
//                //机器人随机账号
//                $where['account']=['like','rob%'];
//                $where['status']=1;
//                $memberList=M('Member')->where($where)->field('uid,account,nickname')->select();
//                foreach($memberList as $k=>$v){
//                    $uidList[]=$v['uid'];
//                }
//                $random_uid_keys=array_rand($uidList,1);
//                $postData['uid']=$uidList[$random_uid_keys];
//                // 全部出价记录
////                $recWhere = array('pid'=>$postData['pid']);
////                $bidRecord = M('Auction_record')->where($recWhere)->order('time desc,bided desc')->limit(10)->select();
////                if($bidRecord){
////                    foreach ($bidRecord as $mk => $mv) {
////                        $bidRecord[$mk]['nickname'] = nickdis(M('member')->where('uid='.$postData['uid'])->getField('nickname'));
////                    }
////                }
//                
//            }
            // 获取加价
            $postData['money'] = sprintf("%.2f",$postData['bidPric']-$bidObj['nowprice']);            
            // 判断是否符合出价要求
            if(bccomp($postData['bidPric'],$reference,2) == -1 && $postData['bidType']=='sd'){
                return array("status" => 2, "msg" => '出价必须大于等于'.$reference);
                exit;
            }
            // 代理出价价格限制
            if($postData['bidType']=='zd'){
                $myagprice=$bidObj['nowprice']+thricebid($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['nowprice'],0);
                if(bccomp($postData['bidPric'],$myagprice,2) == -1){
                    return array("status" => 2, "msg" => '代理出价必须大于等于'.$myagprice);
                    exit;
                }
            }
            // 判断是否重复出价
            if($postData['bidType']=='sd'&&$bidObj['uid']==$postData['uid']){
                return array("status" => 2, "msg" => '您已是当前出价最高的，无需重复出价！<br/>您可以选择设置代理出价！');
                exit;
            }
// 即时成交条件成立【
            if($bidObj['succtype']==1 and bccomp($postData['bidPric'],$bidObj['succprice'],2) != -1){
                $recordList[]=array(
                    'pid' =>$postData['pid'],
                    'uid' =>$postData['uid'],
                    'time' =>time(),
                    'type' =>'代理',
                    'money' =>wipezero($postData['money']),
                    'bided' =>wipezero($postData['bidPric'])
                );
                $operation = meetingOperation($bidObj,1);
                $data['nowprice'] = $bidObj['succprice'];
                $data['bidcount'] = $bidObj['bidcount']+1;
                $data['endtime'] = $operation['endtime'];
                $data['uid'] = $postData['uid'];
            }else{
// 即时成交不成立进入代理操作】
    // 代理出价操作【
                if($postData['bidType']=='zd'){
                    $tname ='设置代理出价';
                    // 已有人设置代理出价且代理代理出价设置者不是该出价用户
                    if($bidObj['agency_uid']&&$bidObj['agency_uid']!=$postData['uid']){
                        // 代理出价小于当前最高代理价
                        if(bccomp($postData['bidPric'],$bidObj['agency_price'],2) == -1){
                            // 一次
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$postData['uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>wipezero($postData['money']),
                                'bided' =>wipezero($postData['bidPric'])
                            );
                            $agency_loser[] = array(
                                'uid' => $postData['uid'],
                                'msg' => '您设置的代理价'.wipezero($postData['bidPric']).'被超越，您已出局！'
                                );
                            // 写入代理出价表设置为2被超越
                            $agency_data = array('pid'=>$postData['pid'],'uid'=>$postData['uid'],'price'=>$postData['bidPric'],'status'=>2,'time'=>time());
                            $agency->add($agency_data);
                            // 第二次出价
                            // 三次出价后价格
                            $thricepric = thricebid($bidObj['stepsize_type'],$bidObj['stepsize'],$postData['bidPric']);
                            // 浮动价格
                            $stepintA = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$postData['bidPric']);
                            // 剩余出价大于等于三次，按照阶梯出价
                            if($bidObj['agency_price']>=$thricepric){
                                $aut['money'] = wipezero($stepintA);
                                $aut['bided'] = wipezero($postData['bidPric']+$stepintA);
                            // 小于三次出价，全部出价
                            }else{
                                $aut['money'] = wipezero($bidObj['agency_price']-$postData['bidPric']);
                                $aut['bided'] = wipezero($bidObj['agency_price']);
                                $agency_loser[] = array(
                                    'uid' => $bidObj['agency_uid'],
                                    'msg' => '已达到您设置的代理价'.wipezero($bidObj['agency_price'])
                                    );
                                // 清空最高代理
                                $data['agency_uid']=0;
                                $data['agency_price']=0;
                                // 代理失效
                                $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',1);
                            }
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>$aut['money'],
                                'bided' =>$aut['bided']
                            );
                            // 更新数据

                            $data['bidcount'] = $bidObj['bidcount']+2;
                            $data['uid'] = $bidObj['agency_uid'];
                            $data['nowprice'] = $aut['bided'];
                    // 代理出价等于当前最高代理价
                        }elseif(bccomp($postData['bidPric'],$bidObj['agency_price'],2) == 0){
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>wipezero($bidObj['agency_price']-$bidObj['nowprice']),
                                'bided' =>wipezero($bidObj['agency_price'])
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+1;
                            $data['uid'] = $bidObj['agency_uid'];
                            $data['nowprice'] = $bidObj['agency_price'];

                            // 清空最高代理
                            $data['agency_uid']=0;
                            $data['agency_price']=0;

                            $agency_loser[]=array(
                                'uid'=>$postData['uid'],
                                'msg'=>'代理出价'.$postData['bidPric'].'已有人设置，并出价。先设置代理优先，请重新设置！'
                                );
                            // 代理失效
                            $agency->where(array('pid'=>$postData['pid'],'uid'=>$postData['uid']))->setField('status',2);
                            $agency_loser[]=array(
                                'uid'=>$bidObj['agency_uid'],
                                'msg'=>'已达到您设置的代理价'.wipezero($postData['bidPric'])
                                );
                            // 代理失效
                            $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',1);
                    // 代理出价大于当前最高代理价
                        }else{
                            // 第一次出价
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'手动',
                                'money' =>wipezero($bidObj['agency_price']-$bidObj['nowprice']),
                                'bided' =>wipezero($bidObj['agency_price'])
                            );
                            $agency_loser[]=array(
                                'uid'=>$bidObj['agency_uid'],
                                'msg'=>'您设置的代理价'.$bidObj['agency_price'].'被超越，您已出局！'
                                );
                            // 代理失效
                            $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',2);
                            // 第二次出价
                            // 三次出价后价格
                            $thricepric = thricebid($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['agency_price']);
                            // 浮动价格
                            $stepintA = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['agency_price']);

                            if(bccomp($postData['bidPric'],$thricepric,2) != -1){
                                $aut['money'] = wipezero($stepintA);
                                $aut['bided'] = wipezero($bidObj['agency_price']+$stepintA);
                                // 设置最高代理
                                $data['agency_uid']=$postData['uid'];
                                $data['agency_price']=$postData['bidPric'];

                                // 代理价设置成功
                                $agency_succ['uid'] = $postData['uid'];
                                $agency_succ['msg'] = '已设置代理价'.$postData['bidPric'].'元。<br/>系统会在代理价范围内自动出价！';
                            // 小于三次出价，全部出价
                            }else{
                                $aut['money'] = wipezero($postData['bidPric']-$bidObj['agency_price']);
                                $aut['bided'] = wipezero($postData['bidPric']);
                                $agency_loser = array(
                                    'uid'=>$postData['uid'],
                                    'msg'=>'已达到您设置的代理价'.wipezero($postData['bidPric'])
                                    );
                                // 清空最高代理
                                $data['agency_uid']=0;
                                $data['agency_price']=0;
                                // 代理失效
                                $agency->where(array('pid'=>$postData['pid'],'uid'=>$postData['uid']))->setField('status',1);
                            }
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$postData['uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>$aut['money'],
                                'bided' =>$aut['bided']
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+2;
                            $data['uid'] = $postData['uid'];
                            $data['nowprice'] = $aut['bided'];
                        }
                        // 最高代理不是该次设置者】
                    // 无人设置代理出价(设置代理出价)
                    }else{
                        // 写入代理出价表
                        $agency_data = array('pid'=>$postData['pid'],'uid'=>$postData['uid'],'price'=>$postData['bidPric'],'time'=>time());
                        $agency->add($agency_data);
                        // 领先者为该代理出价者（设置代理）
                        if($bidObj['uid']==$postData['uid']){
                            $data['agency_uid'] = $postData['uid'];
                            $data['agency_price'] = $postData['bidPric'];
                            // 代理价设置成功
                            $agency_succ['uid'] = $postData['uid'];
                            $agency_succ['msg'] = '已设置代理价'.$postData['bidPric'].'元。<br/>系统会在代理价范围内自动出价！';
                        
                        // 领先者不是该代理出价者（出价后设置代理）
                        }else{
                            // 三次出价后价格
                            $thricepric = thricebid($bidObj['stepsize_type'],$bidObj['stepsize'],$bidObj['nowprice']);

                            if(bccomp($postData['bidPric'],$thricepric,2) != -1){
                                $aut['money'] = wipezero($stepint);
                                $aut['bided'] = wipezero($bidObj['nowprice']+$stepint);

                                // 设置最高代理
                                $data['agency_uid']=$postData['uid'];
                                $data['agency_price']=$postData['bidPric'];
                                // 代理设置成功
                                $agency_succ['uid'] = $postData['uid'];
                                $agency_succ['msg'] = '已设置代理价'.$postData['bidPric'].'元。<br/>系统会在代理价范围内自动出价！';
                            }else{
                                $aut['money'] = wipezero($postData['bidPric']-$bidObj['nowprice']);
                                $aut['bided'] = wipezero($postData['bidPric']);

                                // 清空最高代理
                                $data['agency_uid']=0;
                                $data['agency_price']=0;
                                // 代理失败返回
                                $agency_loser[] = array(
                                    'uid'=>$postData['pid'],
                                    'msg'=>'已达到您设置的代理价'.wipezero($postData['bidPric'])
                                    );
                                // 代理失效
                                $agency->where(array('pid'=>$postData['pid'],'uid'=>$postData['uid']))->setField('status',1);
                            }
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$postData['uid'],
                                'time' =>time(),
                                'type' =>'手动',
                                'money' =>$aut['money'],
                                'bided' =>$aut['bided']
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+2;
                            $data['uid'] = $postData['uid'];
                            $data['nowprice'] = $aut['bided'];
                        }
                    }
    // 代理出价操作】

    // 手动出价操作【
                }else{
                    $tname = '手动出价';
                    // 已有人设置代理出价
                    if($bidObj['agency_uid']){
                    // 出价小于当前代理出价
                        if(bccomp($postData['bidPric'],$bidObj['agency_price'],2) == -1){
                            // 第一次出价
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$postData['uid'],
                                'time' =>time(),
                                'type' =>'手动',
                                'money' =>wipezero($postData['money']),
                                'bided' =>wipezero($postData['bidPric'])
                            );

                            // 第二次出价
                            // 三次出价后价格
                            $thricepric = thricebid($bidObj['stepsize_type'],$bidObj['stepsize'],$postData['bidPric']);
                            // 浮动价格
                            $stepintA = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$postData['bidPric']);
                            // 剩余出价大于等于三次，按照阶梯出价

                            if($bidObj['agency_price']>=$thricepric){
                                $aut['money'] = wipezero($stepintA);
                                $aut['bided'] = wipezero($postData['bidPric']+$stepintA);
                            // 小于三次出价，全部出价
                            }else{
                                $aut['money'] = wipezero($bidObj['agency_price']-$postData['bidPric']);
                                $aut['bided'] = wipezero($bidObj['agency_price']);
                                // 清空最高代理
                                $data['agency_uid']=0;
                                $data['agency_price']=0;
                                $agency_loser[] = array(
                                    'uid'=>$bidObj['agency_uid'],
                                    'msg'=>'已达到您设置的代理价'.wipezero($bidObj['agency_price'])
                                    );
                                // 代理失效
                                $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',1);
                            }
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>$aut['money'],
                                'bided' =>$aut['bided']
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+2;
                            $data['uid'] = $bidObj['agency_uid'];
                            $data['nowprice'] = $aut['bided'];

                    // 出价等于当前代理出价代，代理进行出价
                        }elseif(bccomp($postData['bidPric'],$bidObj['agency_price'],2) == 0){
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'代理',
                                'money' =>wipezero($postData['money']),
                                'bided' =>wipezero($postData['bidPric'])
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+1;
                            $data['uid'] = $bidObj['agency_uid'];
                            $data['nowprice'] = $postData['bidPric'];

                            $bid_err['uid'] = $postData['pid'];
                            $bid_err['msg'] = '出价失败，请重新出价。<br/>出价与其他用户代理价格相同，代理出价优先！';

                            // 清空最高代理
                            $data['agency_uid']=0;
                            $data['agency_price']=0;

                            $agency_loser[]=array(
                                'uid'=>$bidObj['agency_uid'],
                                'msg'=>'已达到您设置的代理价'.wipezero($postData['bidPric'])
                                );
                            // 代理失效
                            $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',1);
                    // 出价大于当前代理出价
                        }else{
                            // 一次
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$bidObj['agency_uid'],
                                'time' =>time(),
                                'type' =>'手动',
                                'money' =>wipezero($bidObj['agency_price']-$bidObj['nowprice']),
                                'bided' =>wipezero($bidObj['agency_price'])
                            );
                            // 清空最高代理
                            $data['agency_uid']=0;
                            $data['agency_price']=0;
                            
                            $agency_loser[]=array(
                                'uid'=>$bidObj['agency_uid'],
                                'msg'=>'您设置的代理价'.$bidObj['agency_price'].'被超越，您已出局！'
                                );
                            // 代理失效
                            $agency->where(array('pid'=>$postData['pid'],'uid'=>$bidObj['agency_uid']))->setField('status',2);
                            // 二次
                            $recordList[]=array(
                                'pid' =>$postData['pid'],
                                'uid' =>$postData['uid'],
                                'time' =>time(),
                                'type' =>'手动',
                                'money' =>wipezero($postData['bidPric']-$bidObj['agency_price']),
                                'bided' =>wipezero($postData['bidPric'])
                            );
                            // 更新数据
                            $data['bidcount'] = $bidObj['bidcount']+2;
                            $data['uid'] = $postData['uid'];
                            $data['nowprice'] = $postData['bidPric'];
                        }

                    // 无人设置代理出价
                    }else{
                        $recordList[]=array(
                            'pid' =>$postData['pid'],
                            'uid' =>$postData['uid'],
                            'time' =>time(),
                            'type' =>'手动',
                            'money' =>wipezero($postData['money']),
                            'bided' =>wipezero($postData['bidPric'])
                        );
                        // 更新数据
                        $data['bidcount'] = $bidObj['bidcount']+1;
                        $data['uid'] = $postData['uid'];
                        $data['nowprice'] = $postData['bidPric'];
                    }
                }
                $operation = meetingOperation($bidObj,0);
                $data['endtime'] = $operation['endtime'];
    // 手动出价操作】
            }
            // 更新拍品信息 
            if($bidMap->where(array('pid'=>$postData['pid']))->save($data)){
                // 如果有出价记录
                if($recordList){
                    // 为专场拍卖实例化专场
                    if($bidObj['sid']!=0){
                        $special_auction = M('Special_auction');
                    }
                    // 写入拍卖记录 返回出价结果
                    foreach ($recordList as $rlk => $rlv) {
                        if($record->add($rlv)){
                            $recordList[$rlk]['time'] = date('m-d H:i:s', $rlv['time']);
                            $recordList[$rlk]['nickname'] = nickdis($member->where(array('uid'=>$rlv['uid']))->getField('nickname'));
                            //如果拍品属于专场 
                            if($bidObj['sid']!=0){
                                // 获取最大时间存入专场结束时间
                                $stimeArr = $bidMap->where(array('sid'=>$bidObj['sid']))->getField('endtime',true);
                                $special_auction->where(array('sid'=>$bidObj['sid']))->setField('endtime',max($stimeArr));
                                // 专场出价次数加1
                                $special_auction->where(array('sid'=>$bidObj['sid']))->setInc('scount',1);
                            }
                        }
                    }
                    // 获取新的步长值
                    $thisS['stepsize'] = setStep($bidObj['stepsize_type'],$bidObj['stepsize'],$data['nowprice']);
                    // 获取出价次数
                    $thisS['bidcount'] = $data['bidcount'];
                    // 当前出价用户uid
                    $thisS['uid'] = $data['uid'];
                    // 当前价
                    $thisS['nowprice'] = wipezero($data['nowprice']);
                    // 下次出价
                    $thisS['bidprice'] = wipezero($thisS['nowprice']+$thisS['stepsize']);
                    // 最低加价
                    $thisS['stped'] = wipezero($thisS['nowprice']+$thisS['stepsize']);
                    // 拍品结束时间
                    $thisS['endtime'] = $data['endtime'];
                    // 出价记录
                    $thisS['recordList'] = my_sort($recordList,'bided',SORT_DESC,SORT_NUMERIC);
                    
                }
                // 代理设置成功
                $thisS['bid_err'] = $bid_err;
                // 失败的代理(二维数组arr(uid，price))
                $thisS['agency_loser'] = $agency_loser;
                // 代理设置成功（数组：uid，price）
                $thisS['agency_succ'] = $agency_succ;
                // 当前时间
                $thisS['nowtime'] = time();
                // 必要数据写入缓存【
                // 更新这个拍品的缓存【
                $redata = S(C('CACHE_FIX').'bid'.$postData['pid']);
                if($redata){
                    $redata['uid'] = $thisS['uid'];
                    $redata['nowprice'] = $thisS['nowprice'];
                    $redata['nickname'] = nickdis($member->where(array('uid'=>$thisS['uid']))->getField('nickname'));
                    $redata['endtime'] = $thisS['endtime'];
                    S(C('CACHE_FIX').'bid'.$postData['pid'],$redata);
                }
                // 更新这个拍品的缓存】
                // 获取需要变更其他拍卖的数据
                if (!empty($operation['drive'])) {
                  $thisS['drive'] = $operation['drive'];
                }
                // 返回出价信息
                return array("status" => 1, "msg" => $tname.'成功','thisS'=>$thisS,'bidRecord'=>$bidRecord);
            }else{
                return array("status" => 0, "msg" => $tname.'失败，请刷新页面重试');
            }
        //竞标处理出价----------------------------------------------------------------------------
        }elseif ($bidObj['type']==1) {
            // 判断出价是否大于起拍价
            if(bccomp($postData['bidPric'],$bidObj['onset'],2) == -1){
                return array("status" => 2, "msg" => '出价必须大于等于'.$bidObj['onset']);
                exit;
            }
            // 判断是否已经出价
            if($record->where(array('uid'=>$postData['uid'], 'pid'=>$postData['pid']))->count()>0){
                return array("status" => 2, "msg" => '竞标仅限出价一次，您已经出过一次价了！');
                exit;
            }
            // 判断出价价格是否有人出过
            if($record->where(array('pid'=>$postData['pid'],'money'=>$postData['bidPric']))->count()>0){
                return array("status" => 2, "msg" => '已经有人出过<em class="red1 fb f16">'.$postData['bidPric'].'</em>这个价格！请重新出价');
                exit;
            }
            // 写入拍卖记录 返回出价结果
            $recordData = array(
                'pid' =>$postData['pid'],
                'uid' =>$postData['uid'],
                'time' =>time(),
                'bided' =>$postData['bidPric'],
                'type'=>'竞标',
            );
            if($record->add($recordData)){
                // 写入拍卖商品表
                // 获取最大的那条数据
                $maxPric = $record->where(array('pid'=>$postData['pid']))->order('bided desc')->find();
                // 修改拍品数据并写入数据
                $data = array(
                    'pid'=>$postData['pid'],
                    'nowprice'=>$maxPric['bided'],
                    'bidcount'=>$bidObj['bidcount']+1,
                    'uid'=>$maxPric['uid']
                );
                $bidMap->save($data);

                // 返回客户端数据并写入缓存
                $recordData['time']=date('m-d H:i:s', $recordData['time']);
                $thisS = array(
                    'pid' => $data['pid'],
                    'uid' => $postData['uid'],
                    'time' => $recordData['time'],
                    'type' => '竞标',
                    'bided' =>$postData['bidPric'],
                    'bidcount'=>$data['bidcount']
                );

                // 更新这个拍品的缓存【
                $redata = S(C('CACHE_FIX').'bid'.$postData['pid']);
                if($redata){
                    $redata['uid'] = $thisS['uid'];
                    $redata['nowprice'] = $data['nowprice'];
                    $redata['nickname'] = nickdis($member->where(array('uid'=>$data['uid']))->getField('nickname'));
                    S(C('CACHE_FIX').'bid'.$postData['pid'],$redata);
                }
                // 更新这个拍品的缓存】
                // 返回出价信息
                return array("status" => 1, "msg" =>'竞标出价成功','thisS'=>$thisS);
            }else{
                return array("status" => 0, "msg" =>'出价失败，请刷新页面重试');
            }

        }
    }
// 冻结买家保证金和信誉额度
    public function freeze_pledge_buy($member,$g_uMap,$bidObj,$pledge,$limsum,$g_uW){
        $auth = 0;
        if($g_uW['g-u']=='s-u'){
            $actype = '冻结专场';
        }else{
            $actype = '冻结';
        }
        $annotation = '参拍“<a href="'.U('Auction/details',array('pid'=>$bidObj['pid'],'aptitude'=>1)).'">'.$bidObj['pname'].'</a>”';
        if(($pledge>0&&$member->where('uid='.$g_uW['uid'])->setInc('wallet_pledge_freeze',$pledge))||$pledge===0){
            $pledge_data = array(
                'order_no'=>createNo('plg'),
                'uid'=>$g_uW['uid'],
                'changetype'=>'bid_freeze',
                'time'=>time(),
                'annotation'=>$annotation.$actype.'保证金！',
                'expend'=>$pledge,
                );
            $pledge_bill = M('member_pledge_bill')->add($pledge_data);
        }
        if(($limsum>0&&$member->where('uid='.$g_uW['uid'])->setInc('wallet_limsum_freeze',$limsum))||$limsum===0){
            $limsum_data = array(
                'order_no'=>createNo('plg'),
                'uid'=>$g_uW['uid'],
                'changetype'=>'bid_freeze',
                'time'=>time(),
                'annotation'=>$annotation.$actype.'信誉额度！',
                'expend'=>$limsum,
                );
            $limsum_bill = M('member_limsum_bill')->add($limsum_data);
        }
        if($pledge_bill||$limsum_bill){
            $g_uW['time']=time();
            $g_uW['limsum'] = $limsum;
            $g_uW['pledge'] = $pledge;
            $g_uMap->add($g_uW);
            $auth = 1;
        }
        return $auth;
    }




    public function ceshi(){
        pre(dsfsdafadfasdf);
        die;
    }
}
?>
