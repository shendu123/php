<?php
namespace Admin\Model;

use Think\Model;

class CrowdOrderModel extends Model {
    public function listOrder($where) {
        $M = M("Crowd_order");
        $items = D("CrowdItems");
        $member = M('Member');
        $special = M('special_auction');
        $seller_pledge = M('seller_pledge');
        $goods_user = M('goods_user');

        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $list = $M->where($where)->limit($pConf['first'], $pConf['list'])->order('time desc')->select();

        // 分配订单金额
        $mct['odmn']= $M->where($where)->sum('price');
        // 分配佣金金额
        $mct['bkmn'] = $M->where($where)->sum('broker');
        foreach ($list as $lk => $lv) {
            $list[$lk]['pname'] = D('Goods')->where('id='.$lv['gid'])->getField('title');
            $list[$lk]['account'] = $member->where('uid='.$lv['uid'])->getField('account');
            $list[$lk]['prcsum'] = $lv['total_price'];
            $list[$lk]['freight'] = $lv['total_price'] - $lv['price'];
            $picarr = explode('|', M('goods')->where(array('id'=>$lv['gid']))->getField('pictures'));
            $list[$lk]['pimg'] = $picarr[0];
        }
        return $data = array('list'=>$list,'page'=>$pConf['show'],'mct'=>$mct);
    }
}

?>
