<?php
namespace Admin\Controller;
use Think\Controller;
class AuctionController extends CommonController {
    /**
     * 正在拍卖列表
     * @return [type] [description]
     */
    public function index() {
        $channel = M('goods_category')->where('pid=0')->select(); //读取频道
        $this->channel=$channel; //分配频道
        $ws = I('get.typ')?bidType(I('get.typ')):bidType('biding');
        $od = 'pid desc';
        $M = M("Auction");

        $count = $M->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = D("Auction")->listAuction($pConf['first'], $pConf['list'],$ws['bidType'],$od);
        $this->saytyp=$ws['saytyp'];
        $this->display(); 
    }
    /**
     +----------------------------------------------------------
     * 搜索商品
     +----------------------------------------------------------
     */
    public function search(){
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
        $this->display('index');
    }
    /**
     * 发布拍卖
     * @return [type] [description]
     */
    public function add() {
        if (IS_POST) {
            echojson(D('Auction')->addEdit('add'));
        }else{
            $goods= M('Goods');
            $info['to'] = I('get.to')?I('get.to'):'js';
            $info['gid'] = I('get.gid');
            $gdata=$goods->where('id ='.$info['gid'])->field('title,price,description')->find();
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
                $this->display();
            }else{
                $this->error('商品不存在！');
            }
        }
        
    }
    /**
     * 编辑拍卖
     * @return [type] [description]
     */
    public function edit() {
        if (IS_POST) {
            echojson(D('Auction')->addEdit('edit'));
        }else{
            C('TOKEN_ON',false);
            $auction = M('Auction');
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
            // 处理保证金
            if($info['broker_type'] == 'ratio'){
                $info['broker_ratio'] = $info['broker'];
                //分配定额默认设置
                $info['broker_fixation'] = $bidcof['broker_fixation'];
            }elseif ($info['broker_type'] == 'fixation') {
                $info['broker_fixation'] = $info['broker'];
                //分配比例默认设置
                $info['broker_ratio'] = $bidcof['broker_ratio'];
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
            $this->weixin=$weixin;
            // 微信推送数据】


            $this->info=$info;
            $this->display('add'); 
        }
        
    }
    public function showset(){
        $auction = M('Auction');
            $info = $auction->where(array('pid'=>I('get.pid')))->find();
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
            // 处理保证金
            if($info['broker_type'] == 'ratio'){
                $info['broker_ratio'] = $info['broker'];
                //分配定额默认设置
                $info['broker_fixation'] = $bidcof['broker_fixation'];
            }elseif ($info['broker_type'] == 'fixation') {
                $info['broker_fixation'] = $info['broker'];
                //分配比例默认设置
                $info['broker_ratio'] = $bidcof['broker_ratio'];
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
            $ntm = time();
            if($info['sid']!=0){
                $special = M('special_auction');
                $info['special'] = $special->where(array('sid'=>$info['sid']))->find();
                if($info['special']['starttime']<=$ntm && $info['special']['endtime']>=$ntm){
                    $info['special']['nowtype'] = 'ing';
                }elseif ($info['special']['starttime']> $ntm) {
                    $info['special']['nowtype'] = 'fut';
                }elseif ($info['special']['endtime']<= $ntm) {
                    $info['special']['nowtype'] = 'end';
                }
                $info['to'] = 'zc';
            }elseif ($info['mid']!=0) {
                $meeting = M('meeting_auction');
                $info['meeting'] = $meeting->where(array('mid'=>$info['mid']))->find();
                if($info['meeting']['starttime']<=$ntm && $info['meeting']['endtime']>=$ntm){
                    $info['meeting']['nowtype'] = 'ing';
                }elseif ($info['meeting']['starttime']> $ntm) {
                    $info['meeting']['nowtype'] = 'fut';
                }elseif ($info['meeting']['endtime']<= $ntm) {
                    $info['meeting']['nowtype'] = 'end';
                }
                $info['to'] = 'pmh';
            }else{
                $info['to'] = 'js';
            }
        if($info['starttime']<=$ntm && $info['endtime']>=$ntm){
            $info['nowtype'] = 'ing';
        }elseif ($info['starttime']> $ntm) {
            $info['nowtype'] = 'fut';
        }elseif ($info['endtime']<= $ntm) {
            $info['nowtype'] = 'end';
        }
        $aRecord = M('Auction_record');
        $member = M('member');
        $recWhere = array('pid'=>I('get.pid'));
        $count = $aRecord->where($recWhere)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $bidRecord = $aRecord->where($recWhere)->order('time desc,bided desc')->select();
        foreach ($bidRecord as $mk => $mv) {
          $bidRecord[$mk]['nickname'] = $member->where('uid='.$mv['uid'])->getField('nickname');
        }
        if($info['uid']){
            $info['nickname'] = $member->where('uid='.$info['uid'])->getField('nickname');
        }else{
            $info['nickname'] = 无;
        }
        
        $this->bidRecord=$bidRecord;
        $this->count=$count;
        $this->info=$info;
        $this->display();
    }
    /**
     * 拍卖配置
     * @return [type] [description]
     */
    public function set_auction() {
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/SetAuction.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data['Auction'] = I('post.Auction');
            if (set_config("SetAuction", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '设置成功','url'=>__SELF__));
            } else {
                echojson(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->bidcof=C('Auction');
            $this->display(); 
        }
    }
// 撤拍操作
    public function cancelPai(){
        if (IS_POST) {
            $drive = array();
            $auction = M("Auction");
            $pid = I('post.pid');
            $cpinfo = D("Auction")->where("pid=" . $pid)->find();
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
                $rtmsg = unfreeze_seller_pledge($cpinfo['sellerid'],$cpinfo['pid'],'cancel');
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
        }else{
            E('页面不存在！');
        }
    }
// 删除操作
    public function del(){
        if (IS_POST) {
            $auction = D("Auction");
            $pid = I('post.pid');
            $where = array('pid'=>$pid);
            $cpinfo = $auction->where($where)->find();
            // 验证
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
                $rtmsg = unfreeze_seller_pledge($cpinfo['sellerid'],$cpinfo['pid'],'del');
                // 更新这个拍品的缓存
                S(C('CACHE_FIX').'bid'.$pid,null);
    // 拍卖会--------------------------------------------
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
                echojson(array('status' => 1, 'msg'=>'删除成功！'.$rtmsg ,'result' => $drive));
            } else {
                echojson(array('status' => 1, 'msg'=>'删除失败，可能是不存在该PID的记录'));
            }
        }else{
            E('页面不存在！');
        }
    }
//以下专场相关-----------------------------------------------------------------------------------------
    /**
     * 专场管理
     * @return [type] [description]
     */
    public function special(){
        $M = M('special_auction');
        $ws = I('get.typ')?bidType(I('get.typ'),1):bidType('biding',1);
        $od = 'sid desc';
        $count = $M->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = D("Auction")->listSpecial($pConf['first'], $pConf['list'],$ws['bidType'],$od);
        $this->list=$list;
        $this->saytyp=$ws['saytyp'];
        $this->display();
    }
    /**
     +----------------------------------------------------------
     * 搜索专场
     +----------------------------------------------------------
     */
    public function search_special(){
        $M = M('special_auction');
        $keyW = I('get.');
        $ws = bidType(I('get.typ'),1);
        if($keyW['keyword'] != ''){
            $encode = mb_detect_encoding($keyW['keyword'], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            $keyW['keyword'] = iconv($encode,"utf-8//IGNORE",$keyW['keyword']);
            $where['sname'] = array('LIKE', '%' . $keyW['keyword'] . '%');
        }
        if($keyW['special_pledge_type']!='') $where['special_pledge_type'] = $keyW['special_pledge_type'];
        if(is_array($where)){
            $where = array_merge($where,$ws['bidType']);
        }else{
            $where = $ws['bidType'];
        }
        $where = array_merge($where,$ws['bidType']);

        $count = $M->where($where)->count();

        $pConf = page($count,C('PAGE_SIZE'));
        $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'type'=>$keyW['special_pledge_type']);
        $this->keys = $keyS;
        $this->page = $pConf['show']; //分配分页
        $this->list= D("Auction")->listSpecial($pConf['first'], $pConf['list'],$where);
        $this->saytyp=$ws['saytyp']; //分配关键词
        C('TOKEN_ON',false);
        $this->display('special');
    }
    /**
     * 添加专场
     * @return [type] [description]
     */
    public function add_special(){
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);

            if($info['endtime']<time()){
                echojson(array('status' => 0, 'info' => '结束时间应该大于当前时间'));
                exit;
            }
            if($info['endtime']<$info['starttime']){
                echojson(array('status' => 0, 'info' => '结束时间应大于开始时间'));
                exit;
            }
            
            // 发布者id
            $info['aid'] = $_SESSION['my_info']['aid'];
            unset($info['sid']);
            if(M('special_auction')->add($info)){
                echojson(array('status' => 1, 'info' => '添加成功','url'=>U('Auction/special')));
            }else{
                echojson(array('status' => 0, 'info' => '添加失败，请重试'));
            }
        }else{
            $this->display();  
        }
    }
    /**
     * 编辑专场
     * @return [type] [description]
     */
    public function edit_special() {
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            if(M('special_auction')->save($info)){
                if ($info['starttime']<=time() && $info['endtime']>=time()) {
                    $typ = 'biding';
                }elseif ($info['endtime']<time()) {
                    $typ = 'bidend';
                }elseif ($info['starttime']>time()) {
                    $typ = 'future';
                }

                echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Auction/special',array('typ'=>$typ))));
            }else{
                echojson(array('status' => 0, 'info' => '更新失败，请重试'));
            }
        }else{
            $info = M('Special_auction')->where(array('sid'=>I('get.sid')))->find();
            // 未开始专场可以编辑
            if ($info['starttime']>time()) {
                $edit = 0;
            }else{
                $edit = 1;
            }
            $this->edit = $edit;
            $this->info=$info;
            $this->display('add_special'); 
        }
        
    }
    public function del_special(){
        if (M("Special_auction")->where("sid=" . (int) $_GET['sid'])->delete()) {
            $auction = M('Auction');
            $alist = $auction->where("sid=" . (int) $_GET['sid'])->select();
            foreach ($alist as $ak => $av) {
                if($av['endtime']>time()){
                    $auction->save(array('pid'=>$av['pid'],'endtime'=>time(),'sid'=>0,'sid'=>0,'pattern'=>0));
                }
            }
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
        //异步删除文章图片
    public function del_specpic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $spesId = I('post.spesId');
        $M = M('Special_auction');
        $data = array(
            'sid' => $spesId,
            I('post.picw') =>''
        );
        if($spesId){
            if($M->save($data)){
                if(@unlink($imgDelUrl)){
                    echojson(array(
                    'status' => 1,
                    'msg' => '已从数据库删除成功!'
                    ));
                }else{
                    echojson(array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    ));
                }
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从磁盘删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '磁盘文件删除失败，请检查文件是否存在或磁盘权限!'
                ));
            }
            
        }
    }
//以下拍卖会相关-----------------------------------------------------------------------------------------
    /**
     * 专场管理
     * @return [type] [description]
     */
    public function meeting(){
        $M = M('meeting_auction');
        $ws = I('get.typ')?bidType(I('get.typ'),2):bidType('biding',2);
        $od = 'mid desc';
        $count = $M->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = D("Auction")->listMeeting($pConf['first'], $pConf['list'],$ws['bidType'],$od);
        $this->list=$list;
        $this->saytyp=$ws['saytyp'];
        $this->display();
    }
    /**
     * 搜索专场
     */
    public function search_meeting(){
        $M = M('meeting_auction');
        $keyW = I('get.');
        $ws = bidType(I('get.typ'),2);

        if($keyW['keyword'] != ''){
            $encode = mb_detect_encoding($keyW['keyword'], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            $keyW['keyword'] = iconv($encode,"utf-8//IGNORE",$keyW['keyword']);
            $where['mname'] = array('LIKE', '%' . $keyW['keyword'] . '%');
        }
        if($keyW['meeting_pledge_type']!='') $where['meeting_pledge_type'] = $keyW['meeting_pledge_type'];
        if(is_array($where)){
            $where = array_merge($where,$ws['bidType']);
        }else{
            $where = $ws['bidType'];
        }

        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'type'=>$keyW['meeting_pledge_type']);
        $this->keys = $keyS;
        $this->page = $pConf['show']; //分配分页
        $this->list= D("Auction")->listMeeting($pConf['first'], $pConf['list'],$where);
        $this->saytyp=$ws['saytyp']; //分配关键词
        C('TOKEN_ON',false);
        $this->display('meeting');
    }
    /**
     * 添加专场
     * @return [type] [description]
     */
    public function add_meeting(){
        if (IS_POST) {
            $this->checkToken();
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            if($info['starttime']<=time()){
               echojson(array('status' => 0, 'info' => '您不能设置开始时间为已开始！<br/>因为新拍卖会下没有拍品'));
               exit; 
            }
            // 发布者id
            $info['aid'] = $_SESSION['my_info']['aid'];
            unset($info['mid']);
            if(M('meeting_auction')->add($info)){
                echojson(array('status' => 1, 'info' => '添加成功','url'=>U('Auction/meeting',array('typ'=>'future'))));
            }else{
                echojson(array('status' => 0, 'info' => '添加失败，请重试'));
            }
        }else{
            $this->display();  
        }
    }
    /**
     * 编辑专场
     * @return [type] [description]
     */
    public function edit_meeting() {
        if (IS_POST) {
            $info = I('post.info');
            if(M('Auction')->where(array('mid'=>$info['mid']))->count()){
                echojson(array('status' => 0, 'info' => '拍卖会下有拍品，系统禁止编辑！'));
                exit;
            }
            $info['starttime']=strtotime($info['starttime']);
            if(M('meeting_auction')->save($info)){
                echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Auction/meeting')));
            }else{

                echojson(array('status' => 0, 'info' => '更新失败，请重试'));
            }
        }else{
            $info = M('Meeting_auction')->where(array('mid'=>I('get.mid')))->find();
            $this->info=$info;
            $this->display('add_meeting'); 
        }
        
    }
    public function del_meeting(){
        if (M("meeting_auction")->where("mid=" . (int) $_GET['mid'])->delete()) {
            $auction = M('Auction');
            $alist = $auction->where("mid=" . (int) $_GET['mid'])->select();
            foreach ($alist as $ak => $av) {
                if($av['endtime']>time()){
                    $auction->save(array('pid'=>$av['pid'],'endtime'=>time(),'mid'=>0,'sid'=>0,'pattern'=>0));
                }
            }
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
        //异步删除文章图片
    public function del_meetpic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $mettId = I('post.mettId');
        $M = M('Special_auction');
        $data = array(
            'sid' => $mettId,
            I('post.picw') =>''
        );
        if($mettId){
            if($M->save($data)){
                if(@unlink($imgDelUrl)){
                    echojson(array(
                    'status' => 1,
                    'msg' => '已从数据库删除成功!'
                    ));
                }else{
                    echojson(array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    ));
                }
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从磁盘删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '磁盘文件删除失败，请检查文件是否存在或磁盘权限!'
                ));
            }
            
        }
    }


    // 卖家保证金
    public function seller_pledge(){
        $seller_pledge = D('SellerPledge');
        $member = M('Member');
        if(I('get.')){
            if(I('get.start_time')!=''){
                $wstar .= "time >= ".strtotime(I('get.start_time'))." and ";
            }
            if(I('get.end_time')!=''){
                $wstar .= "time <= ".strtotime(I('get.end_time'));
            }
            if($wstar!=''){
                $where['_string'] = $wstar;
            }
            if(I('get.account')!=''){
                $user = $member->where(array('account'=>I('get.account')))->field('uid,nickname,account')->find();
                if ($user) {
                    $where['sellerid'] = $user['uid'];
                }else{
                    $this->error('用户不存在！',U('Index/statistics'));
                }
            }
            if(I('get.sellpledgetype')!=''){
                $where['type'] = I('get.sellpledgetype');
            }
            if(I('get.status')!=''){
                $where['status'] = I('get.status');
            }
            $keys= I('get.');
            $this->keys = $keys;
        }
        $count = $seller_pledge->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $list = $seller_pledge->where($where)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
        $this->sellpledgetype = sellpledgetype('all');
        $this->list=$list;
        $this->display();
    }


}