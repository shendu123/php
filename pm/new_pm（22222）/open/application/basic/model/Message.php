<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class Message extends Model {


	public function getMesByReid($uid,$po){
		$where = " 1 = 1 ";

		if(isset($po['type'])){
			switch ($po['type']) {
				case 'yidu':
					$where = $where." AND isread = 3";
					break;
				case 'weidu':
					$where = $where." AND isread = 2";
					break;
				default:
					# code...
					break;
			}
		}
// var_dump($po);exit();
		if(isset($po['type2'])){
			switch ($po['type2']) {
				case 'xitong':
					$where = $where." AND type = 1";
					break;
				case 'fupai':
					$where = $where." AND type = 2";
					break;
				case 'dingdan':
					$where = $where." AND type = 3";
					break;
				default:
					# code...
					break;
			}
		}
// var_dump($where);exit();
		if(isset($po['start'])){
			$where = " AND createtime > ".$po['start'];
		}

		if(isset($po['end'])){
			$where = " AND createtime < ".$po['end'];
		}

		$where = $where." AND receive_id IN ({$uid})" ;
		$res = Db::table('opb_message')->where($where)->select();

		if($res){
			return $res;
		}else{
			return ["type"=>"error","tip"=>"错误获取数据，或者没有数据"];
		}
		
	}


	public function changeIsread($id,$new){
		$res = Db::table('opb_message')->where("mes_id = '".$id."'")->setField("isread",$new);
    	return $res;
	}

	public function changeIscollect($id,$new){
		$res = Db::table('opb_message')->where("mes_id = '".$id."'")->setField("iscollect",$new);
    	return $res;
		
	}

	public function saveData($po){
		$uid =  $this->where(" phone = {$po['phone']} ")->column("uid");
		
		if($uid){
			return "zcgd";//注册过的
		}
		
		$da['account']       = $this->issetData($po['account'],"-");
		$da['nickname']      = $this->issetData($po['nickname'],0);
		$da['pwd']           = md5(md5($this->issetData($po['password'],0)));
		$da['phone']         = $this->issetData($po['phone'],2); 
		$da['mobile']        = $this->issetData($po['phone'],2); 
		$da['business_id']   = $this->issetData($po['business_id'],0);

		$da['email']         = $this->issetData($po['email'],'-');
		$da['truename']      = $this->issetData($po['truename'],0);
		$da['birthday']      = $this->issetData($po['birthday'],0);
		$da['sex']           = $this->issetData($po['sex'],0);
		$da['address']       = $this->issetData($po['address'],'-');
		$da['city']          = $this->issetData($po['city'],0);
		$da['province']      = $this->issetData($po['province'],0);
		$da['aid']           = $this->issetData($po['aid'],0);
		$da['pay_wallet_id'] = $this->issetData($po['pay_wallet_id'],0);
		$da['iscom']         = $this->issetData($po['iscom'],2);

        $res = Db::table('opb_member')->insert($da);

        if($res){
        	$uid =  $this->where(" phone = {$da['phone']} ")->column("uid");
        	if($uid){
	            return  $uid;
	        }
        }else{
            return 0;
        }
        
	}


    public function issetData(&$a,$b){
        return isset($a)?$a:$b;
    }


  

}