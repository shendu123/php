<?php
namespace app\basic\controller;

use think\Request;
use app\common\controller\NoAuth;

/**
 * @class 商户
 * @author ljx
 */
class BusinessHome extends NoAuth
{
    public function getList(){
        $wdata = array(
            'sysid' => '1,2,3,4'
        );
        $model = new \app\basic\model\Business();
        $data = $model->getList($wdata);
    
        return $data;
    }
    
    public function getDetail(){
        $business_ids = valueRequest('business_ids', '', 'string');
        if(empty($business_ids)){
            $this->_error('商户id不能为空~', 400);
        }
        
        $wdata = array(
            'business_ids' => $business_ids
        );
        
        $model = new \app\basic\model\Business();
        $details = $model->getRow($wdata);
        
        $returnData = array();
        if(!empty($details)){
            foreach($details['data'] as $key => $val){
                $returnData[$val['business_id']] = $val;
            }
        }

        return array(
            'data' => $returnData
        );
    }
}