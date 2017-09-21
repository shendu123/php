<?php

/**
 * @class 品牌授权模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class BrandRule extends Model
{

    protected $table = 'opg_brand_rule';

    public $_tableFields = array(
        'id' => 'int', // 申请id
        'business_id' => 'int', // 商户id
        'cat_id' => 'int', // 分类id
        'brand_id' => 'varchar', // 品牌id
        'rule_oprid' => 'int', // 操作者id
        'rule_intime' => 'int', // 新增时间
        'rule_uptime' => 'int' /* 更新时间*/
	);

    /**
     * @function 新增品牌品牌授权
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['rule_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['rule_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['rule_oprid'] = $operateData['user']['user_id'];
        if ($this->save($fields)) {
            return $this->id;
        } else {
            return false;
        }
    }

    /**
     * @function 品牌授权列表
     * @author ljx
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {

    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        return $data;
    }

    /**
     * @function 取消品牌 授权
     * @author ljx
     */
    public function delete($wdata = array(), $operateData = array())
    {

    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowByRule($wdata = array(), $operateData = array()){
        if(!empty($wdata['id'])){
            $whereCond['id'] = $wdata['id'];
        }
        if(!empty($wdata['cat_id'])){
            $whereCond['cat_id'] = $wdata['cat_id'];
        }
        if(!empty($wdata['business_id'])){
            $whereCond['business_id'] = $wdata['business_id'];
        }
        if(!empty($wdata['brand_id'])){
            $whereCond['brand_id'] = $wdata['brand_id'];
        }
        
        return Db::table('opg_brand_rule')->where($whereCond)->find();
    }
    
}

