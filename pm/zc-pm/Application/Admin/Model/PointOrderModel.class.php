<?php
namespace Admin\Model;

use Think\Model;

class PointOrderModel extends Model {

    public function lists($firstRow = 0, $listRows = 20, $where,$od) {
        $list = $this->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        $uid = '';
        $vv  = array();
        foreach ($list as  $v) {
           
            if(!in_array($v['uid'], $vv)){
                $vv[] = $v['uid'];
                if($uid==''){
                    $uid = $v['uid'];
                }else{
                    $uid = $uid.','.$v['uid'];            
                }
            }
            
        }

        $cond['uid']=array('in',$uid);
        $aidArrb = M("member");
        $aidArr = $aidArrb->field("`uid`,`account`,`nickname`,`mobile`,`email`")->where($cond)->select();

        foreach ($aidArr as $k) {
            $abs[$k['uid']] = $k;
        }



        foreach ($list as $v => $k) {
            $list[$v]['nickname'] = $abs[$k['uid']]['account'];
            $list[$v]['phone'] = $abs[$k['uid']]['mobile'];
            $list[$v]['email'] = $abs[$k['uid']]['email'];
        }

        return $list;
    }
}

