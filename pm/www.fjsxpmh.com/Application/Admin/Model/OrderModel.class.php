<?php
namespace Admin\Model;
use Think\Model;
class OrderModel extends Model {
    public function listOrder($where) {

        $M = M("Goods_order");
        $auction = M("Auction");
        $member = M('Member');
        $special = M('special_auction');
        $seller_pledge = M('seller_pledge');
        $goods_user = M('goods_user');

        $seller_pledge_type = C('Auction.seller_pledge_type');


        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $M->where($where)->order('time desc')->select();

        // 分配订单金额
        $mct['odmn']= $M->where($where)->sum('price');
        // 分配佣金金额
        $mct['bkmn'] = $M->where($where)->sum('broker');
        foreach ($list as $lk => $lv) {
            $list[$lk]['pname']=$auction->where('pid='.$lv['gid'])->getField('pname');
            $list[$lk]['account']=$member->where('uid='.$lv['uid'])->getField('account');
            $list[$lk]['prcsum'] = $lv['price']+$lv['freight'];
            // 卖家保证金
            $thesell = $seller_pledge->where(array('sellerid'=>$lv['sellerid'],'pid'=>$lv['gid']))->find();
            if(!$thesell){
                $thesell = $seller_pledge->where(array('sellerid'=>$lv['sellerid'],'type'=>'disposable'))->find();
                
            }
            $list[$lk]['sell_type'] = sellpledgetype($thesell['type']);
            $list[$lk]['sell_pledge'] = $thesell['pledge'];
            $list[$lk]['sell_limsum'] = $thesell['limsum'];
            $list[$lk]['sell_freeze'] = $thesell['status'];
            // 买家保证金缴纳
            $sid = $auction->where('pid='.$lv['gid'])->getField('sid');
            if($sid){
                $sinfo = $special->where(array('sid'=>$sid))->find();
                if($sinfo['special_pledge_type']==0){
                    $g_uW = array('g-u'=>'s-u','gid'=>$sid,'uid'=>$lv['uid']);
                    $pledge_type = '专场[专场缴纳]';
                }else{
                    $g_uW = array('g-u'=>'p-u','gid'=>$lv['gid'],'uid'=>$lv['uid']);
                    $pledge_type = '专场[单品缴纳]';
                }
            }else{
                $g_uW = array('g-u'=>'p-u','gid'=>$lv['gid'],'uid'=>$lv['uid']);
                $pledge_type = '单品缴纳';
            }
            $g_uInfo = $goods_user->where($g_uW)->field('pledge,limsum')->find();
            $list[$lk]['pledge_type'] = $pledge_type;
            $list[$lk]['pledge'] = $g_uInfo['pledge'];
            $list[$lk]['limsum'] = $g_uInfo['limsum'];
            $g_uInfo = $goods_user->where($g_uW)->field('pledge,limsum')->find();
            $list[$lk]['pledge_type'] = $pledge_type;
            $list[$lk]['pledge'] = floatval($g_uInfo['pledge']);
            $list[$lk]['limsum'] = floatval($g_uInfo['limsum']);
            $gid = $auction->where('pid='.$lv['gid'])->getField('gid');
            $picarr = explode('|', M('goods')->where(array('id'=>$gid))->getField('pictures'));
            $list[$lk]['pimg'] = $picarr[0];
        }
        return $data = array('list'=>$list,'page'=>$pConf['show'],'mct'=>$mct);
    }
}

?>
