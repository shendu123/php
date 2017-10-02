<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use app\basic\model\Business;


class Role extends Model {

    public function getAllBy($sysid, $businessId=0) {   
        if($businessId>1){
    		$sysid = model('Business')->where('business_id', $businessId)->value('sysid');
    		$result = $this->where('sysid', $sysid)->column('id,pid,name,status,sysid,remark');
    		return $result;
    	}else{
    		return $this->column('id,pid,name,status,sysid,remark');
    	}
                    
    }
    
    public function getRoleNameById($id){
        return $this->where(['id'=>['in',$id]])->value('name');
    }
}