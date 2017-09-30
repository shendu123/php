<?php
namespace app\basic\model;

use think\Model;
use think\Db;

class Myauction extends Model {


	public function saveData($po,$uid){

        $da['aid']    = $this->issetData($po['aid'],"-");
        $da['status'] = $this->issetData($po['status'],0);
        $da['price']  = $this->issetData($po['price'],0);
        $da['uid']    = $this->issetData($uid,0);

        $res = Db::table('opb_myacution')->insert($da);

        if($res){
            return  1;
        }else{
            return 0;
        }
        
	}
    
	public function changeMyaStatus($id,$new){
		$res = Db::table('opb_myacution')->where("id = '" . $id . "'")->setField("status", $new);
        return $res;

	}

    public function findByUid($uid){
        $res = Db::table('opb_myacution')->where('uid', $uid)->column('aid');
        if($res){
            return $res;
        }else{
            return 0;
        }

    }





    public function issetData(&$a, $b){
        return isset($a) ? $a : $b;
    }



  

}