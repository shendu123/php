<?php
namespace Home\Controller;
use Think\Controller;
class SellerController extends CommonController {
    public function index(){
        $uid = $this->cUid;
        $sellerid = I('get.sellerid');
        if($sellerid){
            $type = I('get.type');
            $attention = M('attention_seller');
            $member = M('member');
            $bidMap = D('Auction');
            $nowTime = time();

            $seller = $member->where(array('uid'=>$sellerid))->field('uid,account,organization,avatar,reg_date,score')->find();
            if($ism){
                $this->shimg = C('WEB_ROOT'). ltrim(getuserpic($seller['uid'],0),'/');
            }
            $seller['leval'] = getlevel($seller['score']);
            $credit_score = getstarval(M('goods_evaluate'),array('sellerid'=>$sellerid));

            $this->seller=$seller;
            $this->credit_score=$credit_score;
            // 分配关注状态
            if($attention->where(array('uid'=>$uid,'sellerid'=>$sellerid))->count()){$usgz=1;}else{$usgz=0;}
            $this->usgz=$usgz;
            // fans统计
            $fanscount = $attention->where(array('sellerid'=>$sellerid))->count();
            $this->fanscount=$fanscount;
            // 卖家拍品列表
            if($type=='wait'){
                $bid_where = foreshow(5);
                $bid_od = 'starttime';
                $list[0]['abc']=1;
                $type = 'wait';
            }elseif($type=='end'){
                $bid_where = array('endtime'=>array('elt',$nowTime));
                $bid_od = 'endtime';
                $list[0]['abc']=2;
                $type = 'end';
            }else{
                $bid_where = bidSection(5);
                $bid_od = 'endtime';
                $list[0]['abc']=0;
                $type = 'ing';
            }
            // 拍品各个阶段统计
            $bid_count['wait'] = $bidMap->where(foreshow(5))->where(array('sellerid'=>$sellerid))->count();
            $bid_count['end'] = $bidMap->where(array('sellerid'=>$sellerid,'endtime'=>array('elt',$nowTime)))->count();
            $bid_count['ing'] = $bidMap->where(bidSection(5))->where(array('sellerid'=>$sellerid))->count();
            $bid_count['all'] = $bid_count['wait']+$bid_count['end']+$bid_count['ing'];
            // 结束统计计算成交率
            $cjc = $bidMap->where(array('sellerid'=>$sellerid,'endstatus'=>1))->count();
            $yjs = $bidMap->where(array('sellerid'=>$sellerid,'endstatus'=>array('neq',0)))->count();
            $bid_count['cjl'] = round($cjc/$yjs*100).'%';

            $this->bid_count=$bid_count;
            // 拍品列表
            $bid_where['sellerid'] = $sellerid;
            $count = $bidMap->where($bid_where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            $list[0]['blist'] = $bidMap->where($bid_where)->limit($pConf['first'].','.$pConf['list'])->order($bid_od)->select();
            $this->page = $pConf['show']; 
            $this->list=$list;
            $this->type=$type;
            $this->sellerid=$sellerid;
            $this->display();
        }else{
            $this->error('不存在的卖家');
        }
        
    }

    // 商家页面关注商家
    public function attention(){
        if(IS_POST){
            if($this->cUid){
                if($this->cUid!=I('post.sellerid')){
                    $att=M('attention_seller');
                    $data = array(
                        'sellerid'=>I('post.sellerid'),
                        'uid'=>$this->cUid
                        );
                    if(!$att->where($data)->count()){
                        $data['time'] = time();
                        if($att->add($data)){
                            echojson(array('status'=>1,'msg'=>'已关注卖家'));
                        }
                    }else{
                        if($att->where($data)->delete()){
                            echojson(array('status'=>1,'msg'=>'已取消关注卖家'));
                        }
                    }
                }else{
                    echojson(array('status'=>0,'msg'=>'您不能关注您自己'));
                }
                
            }else{
                echojson(array('status'=>0,'msg'=>'您没有登陆，请登录后进行设置！'));
            }
        }
    }
}