<?php
namespace app\basic\model;

use think\Model;
use think\Db;
/**
 * @class 会员memberRule模型 用户规则表
 * @author ljx
 * @caution 规则这边的记录 若删除则直接删除
 */
class MemberRule extends Model
{

    protected $table = 'opb_member_rule';

    public $_tableFields = array(
        'sysid' => 'int', // 自增id不要去用
        'member_id' => 'int', // 会员id
        'business_id' => 'int', // 商户id
        'rule_oprid' => 'int', // 操作者id
        'rule_checkid' => 'int', // 审核人id
        'rule_check_status' => 'int', // 0审核通过 1审核失败 2待审核
        'rule_type' => 'int', // 0普通会员 90营业人员 95商户总管理
        'rule_from' => 'int', // 注册来源 0pc 1app 2微信 10其他
        'rule_state' => 'int', // 状态: 0启用 1禁用锁定
        'rule_check_reason' => 'varchar', // 审核备注
        'rule_checktime' => 'int', // 审核时间
        'rule_intime' => 'int', // 添加时间
        'rule_uptime' => 'int', /* 更新时间 */
	);
    
    public $rule_check_status = array(
        '0' => '审核通过',
        '1' => '审核失败',
        '2' => '待审核'
    );
    
    public $rule_type = array(
        '0' => '普通会员',
        '90' => '营业人员',
        '95' => '商户总管理'
    );
    
    public $rule_from = array(
        '0' => 'pc',
        '1' => 'app',
        '2' => '微信',
        '10' => '其他'
    );
    
    public $rule_state = array(
        '0' => '启用',
        '1' => '禁用'
    );
    
    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['business_id'] = $operateData['business']['business_id'];
        $fields['rule_oprid'] = $operateData['user']['user_id'];
        $fields['rule_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['rule_uptime'] = $_SERVER['REQUEST_TIME'];

        return $this->save($fields);
    }
    
    /**
     * @function 编辑
     * 
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array()){
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['rule_uptime'] = $_SERVER['REQUEST_TIME'];
        // 操作者在编辑的时候不记录在rule_oprid
        
        $wdata = array(
            'uid' => $requestData['uid'],
            'business_id' => $requestData['business_id'],
            'rule_type' => $requestData['rule_type']
        );
        
        return $this->save(parseRequestData($fields, $wdata));
    }
}


















