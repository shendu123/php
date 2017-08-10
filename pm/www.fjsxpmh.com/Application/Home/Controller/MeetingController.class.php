<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class MeetingController extends CommonController {
    /**
    * 专场首页
    * @return [type] [description]
    */
    public function index(){
        $auction = M('Auction');
        $meeting_auction = M('meeting_auction');
        $ws = I('get.typ')?bidType(I('get.typ'),2):bidType('biding',2);
        $od = 'endtime desc';
        $count = $meeting_auction->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $meeting_auction->where($ws['bidType'])->limit($pConf['first'].','.$pConf['list'])->order($od)->select();
        if(is_array($list)){
            // 计算拍品数量,想拍人数
            foreach ($list as $ck => $cv) {
                $list[$ck]['count'] = $auction->where(array('mid'=>$cv['mid']))->count();
                // 统计想拍个数
                if(I('get.typ')=='future'){
                    $clcountArr = $auction->where(array('mid'=>$cv['mid']))->getField('clcount',true);
                    $list[$ck]['clcount'] = is_array($clcountArr)?array_sum($clcountArr):0;
                }
                // 结束专场
                if(I('get.typ')=='bidend'){
                    // 统计成交数量
                    $list[$ck]['endcount'] = $auction->where(array('mid'=>$cv['mid'],'endstatus'=>1))->count();
                    $nowpriceArr = $auction->where(array('mid'=>$cv['mid'],'endstatus'=>1))->getField('nowprice',true);
                    $list[$ck]['countprc'] = is_array($nowpriceArr)?array_sum($nowpriceArr):0;
                }
            }
        }

        $this->saytyp=$ws['saytyp'];
        $this->list=$list;
        if($ws['saytyp']['get']=='biding'){$nowstat = '正在拍卖';}elseif ($ws['saytyp']['get']=='future') {$nowstat = '即将开拍';}elseif($ws['saytyp']['get']=='bidend'){$nowstat = '历史拍卖会';}
        $this->nowstat=$nowstat;
        $this->page = $pConf['show']; //分页分配
        $this->display();
    }
    // 专场拍品列表---------------------------------------------------
    public function meetul(){
        $ism = $this->ism;
        $auction = D('Auction');
        $meeting_auction = M('meeting_auction');
        $sinfo = $meeting_auction->where(array('mid'=>I('get.mid')))->find();
        if($ism){
            $this->shimg = C('WEB_ROOT'). str_replace('./', '', C('UPLOADS_PICPATH').$sinfo['mpicture']);
        }
        // 判断状态
        // -----未开始
        if ($sinfo['starttime']>time()) {
            $sinfo['status']='future';
            $bidArr[0]['abc'] = 1;
        // 进行中
        }elseif($sinfo['endtime']>time()&&$sinfo['starttime']<=time()){
            $sinfo['status']='biding';
            $bidArr[0]['abc'] = 0;
        // 结束
        }elseif($sinfo['endtime']<=time()){
            $sinfo['status']='bidend';
            $bidArr[0]['abc'] = 2;
            // 成交总额
            $sinfo['countprc'] = array_sum($auction->where(array('mid'=>I('get.mid'),'endstatus'=>1))->getField('nowprice',true));
        }
        // 保证金收取
        $sinfo['count'] = $auction->where(array('mid'=>I('get.mid')))->count();
        // 围观次数统计
        $actionList = $auction->where(array('mid'=>I('get.mid')))->getField('clcount',true);
        $sinfo['clcount'] = is_array($actionList)?array_sum($actionList):0;
        // 根据条件获取专场下拍品
        // 筛选条件处理
        if(I('get.bc')!=''){
            if(I('get.bc')==1){
                $sbid_od = 'nowprice desc ,';
                $sinfo['bc']=0;
            }elseif (I('get.bc')==0) {
                $sbid_od = 'nowprice asc ,';
                $sinfo['bc']=1;
            }
            $sinfo['pd']='bc';
        }else{
            $sinfo['bc']=0;
        }
        if(I('get.po')!=''){
            if(I('get.po')==1){
                $sbid_od = 'bidcount desc ,';
                $sinfo['po']=0;
            }elseif (I('get.po')==0) {
                $sbid_od = 'bidcount asc ,';
                $sinfo['po']=1;
            }
            $sinfo['pd']='po';
        }else{
            $sinfo['po']=0;
        }
        $sbid_od .=' msort asc';
        // 分页配置
        $sbid_where['mid']=I('get.mid');
        $count = $auction->where($sbid_where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $bidArr[0]['bid_list'] = $auction->where($sbid_where)->limit($pConf['first'].','.$pConf['list'])->order($sbid_od)->select();
        $this->bidArr=$bidArr;
        $this->page = $pConf['show'];
        // pre($slist);
        // die;
        $this->sinfo=$sinfo;
        $this->display();
    }
    // 结论书
    public function conclusion(){
        $mid = I('get.mid');
        $auction =D('Auction');
        $member = M('member');
        $meet = M('meeting_auction')->where(array('mid'=>$mid))->find();
        // 拍品数量
        $meet['acount'] = $auction->where(array('mid'=>$mid))->count();
        // 成交数量
        $meet['acccount'] = $auction->where(array('mid'=>$mid,'endstatus'=>1))->count();
        // 流拍数量
        $meet['loscount'] = $meet['acount']-$meet['acccount'];
        $meet['accprice'] = array_sum($auction->where(array('mid'=>$mid,'endstatus'=>1))->getField('nowprice',true)) ;

        $alist = $auction->where(array('mid'=>$mid))->order('msort asc')->select();
        foreach ($alist as $ak => $av) {
            $alist[$ak]['nickname'] = $member->where(array('uid'=>$av['uid']))->getField('nickname');
            $alist[$ak]['premium'] = sprintf("%.2f", ($av['nowprice']-$av['price'])/$av['price']*100);
        }

        $this->meet=$meet;
        $this->alist=$alist;
        $this->display();
    }


    // 获取当前专场时间-------------------------------------------------
    public function ajaxmeetinggettime(){
        session_write_close();
        $rtime = M('meeting_auction')->where(array('mid'=>I('post.mid')))->field(array('starttime','endtime'))->find();
        if(I('post.ck')=='cke'){
            $cdata['cktime'] = $rtime['endtime'];
        }elseif(I('post.ck')=='cks'){
            $cdata['cktime'] = $rtime['starttime'];
        }
        $cdata['nowtime'] = time();
        echojson($cdata);
    }

    // --------专场时间结束提交地址
    public function checkmeetingsucc(){
        session_write_close();
        $sai = M('meeting_auction')->where('mid ='.I('post.mid'))->find();
        if(I('post.ck')=='cke'){
            $cktime = $sai['endtime'];
        }elseif(I('post.ck')=='cks'){
            $cktime = $sai['starttime'];
        }
        if($cktime<time()){
            echojson(array('status'=>1,'info'=>'专场《'.$sai['sname'].'》已结束！'));
        }else{
            echojson(array('status'=>0,'nowtime'=>time(),'cktime'=>$cktime));
        }
    }
}