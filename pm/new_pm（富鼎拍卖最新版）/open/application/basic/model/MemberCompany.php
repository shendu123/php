<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class MemberCompany extends Model {

	public function saveData($po){
		

		$da['uid']          = $this->issetData($po['uid'],0);
		$da['com_contact_name']         = $this->issetData($po['name'],0);
		$da['com_contact_idcard']       = $this->issetData($po['idcard'],0);
		$da['com_name']     = $this->issetData($po['com_name'],0);
		$da['com_province']     = $this->issetData($po['province'],0);
		$da['com_city']         = $this->issetData($po['city'],0);
		$da['com_area']         = $this->issetData($po['area'],0);
		$da['com_contact_mobile']        = $this->issetData($po['phone'],0);
		$da['com_ucredit']      = $this->issetData($po['ucredit'],0);
		$da['com_license']  = $this->issetData($po['license_url'],'-');
		$da['business_id']   = $this->issetData($po['businessid'],0);
		$da['com_detail_addr']  = $this->issetData($po['detail_addr'],2);
		$da['com_legal_name']   = $this->issetData($po['legal_name'],"-");
		$da['com_legal_idcard'] = $this->issetData($po['legal_idcard'],"-");
		$da['com_legal_mobile']  = $this->issetData($po['lagal_phone'],"-");

        $res = Db::table('opb_member_company')->insert($da);

        if($res){
            return  array($po['uid']);
        }else{
            return 0;
        }
        
	}


    public function issetData(&$a,$b){
        return isset($a)?$a:$b;
    }


    public function getUidBy($username, $password) {
        return $this->where(['email|account|mobile' => $username, 'pwd' => $password])->value('uid');
    }

    public function Info($where){
        return $this->where($wehre)->find();
    }

    public function getName($uid){
    	return $this->where(" uid = {$uid} ")->getField("account");
    }

}