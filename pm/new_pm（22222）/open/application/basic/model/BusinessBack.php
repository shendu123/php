<?php

/**
 * @class Business商户模型
 * @author ljx
 */
namespace app\basic\model;

use think\Model;
use think\Db;
use app\basic\model\MemberRule;

class BusinessBack extends Model
{

    protected $table = 'opb_business';

    public $_tableFields = array(
        'business_id' => 'int', // 加盟商ID
        'name' => 'int', // 加盟商名称
        'pid' => 'int', // 上级商户id 0表示顶级商户,用于平台/合伙人; -1表示没有父级商户,用于企业用户
        'sysid' => 'int', // system.sysid
        'business_intime' => 'int', // 创建时间
        'business_uptime' => 'int' /* 修改时间**/
    );

    /**
     * @function 添加
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['business_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['business_intime'] = $_SERVER['REQUEST_TIME'];
        
        if ($this->save($fields)) {
            return $this->business_id;
        } else {
            return false;
        }
    }

    /**
     * @function 编辑
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['business_uptime'] = $_SERVER['REQUEST_TIME'];
        
        $wdata = array(
            'business_id' => $fields['business_id']
        );
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }
}



