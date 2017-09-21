<?php
namespace app\finance\model;

use app\finance\model\InitModel;
use think\Db;

class WalletAction extends InitModel {
    protected $table = 'op_pay.opa_wallet_action';

    public function issetData(&$a,$b){
        return isset($a)?$a:$b;
    }

	public function saveData($po){

        $da['uid']           = $this->issetData($po['uid'],0);
        $da['pay_wa_time_id'] = $this->util->getUID();
        $da['pay_ototal_id']        = $this->issetData($po['pay_ototal_id'],0);
        $da['money']        = $this->issetData($po['money'],0);
        $da['toid']        = $this->issetData($po['toid'],0);
        $da['desc']          = $this->issetData($po['desc'],'余额充值');
        $da['money_type']   = $this->issetData($po['money_type'],'YE');
        $da['from']       = $this->issetData($po['from'],'CZ');
        $da['point']       = $this->issetData($po['point'],0);
        $da['createtime']   =  date('Y-m-d H:i:s',time());
        $res = Db::table('opa_wallet_action')->insert($da);

        if($res){
            return 1;
        }else{
            return $this->util->tip('N',"生成钱包操作记录错误",$res);
        }
        
	}
        
    public function getListByUid($page,$where){
        $res=Db::table('op_pay.opa_wallet_action')->where($where)->order('createtime desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
        $count=Db::table('op_pay.opa_wallet_action')->where($where)->count();
        $list=[
            'data'=>$res,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count,
        ];
        return $list;
    }


    public function getFListByUid($uid){
        $list=Db::table('opa_wallet_action')->where("id = '{$uid}'' ")->order('createtime desc')->select();
        return $list;
    }

    public function findByUidAll($uid,$page){
       $list=Db::table('opa_wallet_action')->where("uid = '{$uid}' OR toid = '{$uid}' ")->order('createtime desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
       $count= Db::table('opa_wallet_action')->where("uid = '{$uid}' OR toid = '{$uid}' ")->count();
       $pageCount=ceil($count/$page['pageSize']);
        return $this->jsonData($list,$count,$pageCount); 
    }

    public function findByUidCz($uid,$page){
       $list=Db::table('opa_wallet_action')->where("toid = '{$uid}' AND `from`='CZ' ")->order('createtime desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
       $count= Db::table('opa_wallet_action')->where("toid = '{$uid}' AND `from`='CZ' ")->count();
       $pageCount=ceil($count/$page['pageSize']);
        return $this->jsonData($list,$count,$pageCount);
        
    }

    public function findByUidZc($uid,$page){
       $list=Db::table('opa_wallet_action')->where("uid = '{$uid}' AND `isadd`=1 ")->order('createtime desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
       $count= Db::table('opa_wallet_action')->where("uid = '{$uid}' AND `isadd`=1 ")->count();
       $pageCount=ceil($count/$page['pageSize']);
       return $this->jsonData($list,$count,$pageCount); 
    }

    public function findByUidDj($uid,$page){
       $list=Db::table('opa_wallet_action')->where("uid = '{$uid}' AND `money_type`='DJYE' ")->order('createtime desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
       $count= Db::table('opa_wallet_action')->where("uid = '{$uid}' AND `money_type`='DJYE' ")->count();
       $pageCount=ceil($count/$page['pageSize']);
       return $this->jsonData($list,$count,$pageCount);
    }
    public function jsonData($list,$count,$pageCount){
        if($list){
            $return['type']='success';
            $return['tip']='获取成功';
            $return['page']=['page_count'=>$pageCount,'total'=>$count];
            $return['data']=$list;         
        }else{
            $return['type']='error';
            $return['tip']='获取失败';
        }
        echo json_encode($return,JSON_UNESCAPED_UNICODE);exit;
    }






















}