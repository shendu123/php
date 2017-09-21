<?php

/**
 * @class 系统配置模型
 * @author ljx
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class Config extends Model
{

    protected $table = 'opb_config';

    public $_tableFields = array(
        'config_id' => 'int', // 配置id
        'config_oprid' => 'int', // 操作者id
        'config_status' => 'int', // 配置状态 0启用 1禁用
        'config_syslevel' => 'int', // 配置系统级别 0系统配置 1子系统配置 2商户配置
        'config_group' => 'varchar', // 配置分组
        'config_name' => 'varchar', // 配置名称
        'config_value' => 'varchar', // 配置值
        'config_remarks' => 'varchar', // 配置备注
        'config_intime' => 'int', // 创建时间
        'config_uptime' => 'int' /*更新时间**/
	);

    /**
     * @function 新增
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['config_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['config_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['config_oprid'] = $operateData['user']['user_id'];
        
        if ($this->save($fields)) {
            return $this->config_id;
        } else {
            return false;
        }
    }
        
    /**
     * @function 
     * @author zsq
     */
    public function shopping($requestData = array(), $operateData = array(), $modify=0){
        $fields_arr = array();
        
        $groups = array(
            'integral_reg' => array(
                'group' => 'shopping',
                'remarks' => '注册赠送积分'
            ),
            'integral_money' => array(
                'group' => 'shopping',
                'remarks' => '积分换算比例 1元=xx积分'
            ),
            'auction_unpay' => array(
                'group' => 'shopping',
                'remarks' => '拍中后多少天不支付处罚'
            ),
            'order_unpay' => array(
                'group' => 'shopping',
                'remarks' => '待付款订单不支付多少天后关闭'
            ),
            'order_close' => array(
                'group' => 'shopping',
                'remarks' => '收货后多少天订单完成'
            ),
            'upload_limit' => array(
                'group' => 'shopping',
                'remarks' => '附件上传大小'
            ),
            'withdraw_lowlimit' => array(
                'group' => 'shopping',
                'remarks' => '提现金额 需超过多少才能提现金额'
            ),
            'withdraw_mini' => array(
                'group' => 'shopping',
                'remarks' => '最少提现额度'
            )
        );
        foreach($requestData as $key => $val){
            $update = array(
                'config_status' => 0,
                'config_syslevel' => 0,
                'config_group' => $groups[$key]['group'],
                'config_name' => $key,
                'config_value' => $val,
                'config_remarks' => $groups[$key]['remarks'],
                'config_intime' => $_SERVER['REQUEST_TIME'],
                'config_uptime' => $_SERVER['REQUEST_TIME'],
                'config_oprid' => $operateData['user']['user_id']
            );
            $fields_arr[] = $update;

            if($modify==1){
                $result = $this->save($update, ['config_name'=>$key]);
            }
        }

        if($modify==1){
           return $result; 
        }        

        if ($this->saveAll($fields_arr)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * @function 分销设置
     * @author ljx
     */
    public function distribution($requestData = array(), $operateData = array(), $modify=0){
        $fields_arr = array();
        
        $groups = array(
            'partner_seller_bonus' => array(
                'group' => 'bonus',
                'remarks' => '合伙人推荐卖家获得佣金比例'
            ),
            'opr_seller_bonus' => array(
                'group' => 'bonus',
                'remarks' => '运营商推荐卖家获佣金比例'
            ),
            'opr_buyer_bonus' => array(
                'group' => 'bonus',
                'remarks' => '运营商推荐会员获佣金比例'
            )
        );
        foreach($requestData as $key => $val){
            $update = array(
                'config_status' => 0,
                'config_syslevel' => 0,
                'config_group' => $groups[$key]['group'],
                'config_name' => $key,
                'config_value' => $val,
                'config_remarks' => $groups[$key]['remarks'],
                'config_intime' => $_SERVER['REQUEST_TIME'],
                'config_uptime' => $_SERVER['REQUEST_TIME'],
                'config_oprid' => $operateData['user']['user_id']
            );           

            $fields_arr[] = $update;
            if($modify==1){
                $result = $this->save($update, ['config_name'=>$key]);
            }
        }

        if($modify==1){
           return $result; 
        }  
        
        if ($this->saveAll($fields_arr)) {
            return true;
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
        $fields['config_uptime'] = $_SERVER['config_uptime'];
        $fields['config_oprid'] = $operateData['user']['user_id'];
        $wdata = array(
            'id' => $fields['id']
        );
        
        $this->add();
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @function 编辑多条
     * @author ljx
     */
    public function editAll($requestData = array(), $operateData = array()){
        // TODO 用 case when 来做
    }

    /**
     * @function 列表
     * @author ljx
     */
    public function getList($wdata = array())
    {
        $whereCond = array();
        if(isset($wdata['config_group']) && !empty($wdata['config_group'])){
            $whereCond['config_group'] = $wdata['config_group'];
        }
        
        $list = Db::table('opb_config')
        ->where($whereCond)
        ->field('*')
        ->select();
        
        $list = $this->parseListData($list);

        return $list;
    }

     /**
     * @function 获取组
     * @author zsq
     */
    public function getGroup($group)
    {
        $condition['config_group'] = $group;
        
        $list = Db::table('opb_config')
                    ->where($condition)
                    ->field('config_name, config_value')
                    ->select();
        $result = array_column($list, 'config_value', 'config_name');
        return $result;
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        $returnData = array();
        foreach($data as $key => $val){
            $returnData[$val['config_group']][$val['config_name']] = $val;
        }
        
        return $returnData;
    }
}
























