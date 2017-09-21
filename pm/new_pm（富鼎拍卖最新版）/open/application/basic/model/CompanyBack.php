<?php

/**
 * @class 企业会员member_company模型
 * @author ljx
 */
namespace app\basic\model;

use think\Model;
use think\Db;
use app\basic\model\MemberRule;
use app\basic\controller\Address;

class CompanyBack extends Model
{

    protected $table = 'opb_member_company';

    public $_tableFields = array(
        'com_id' => 'int', // 企业id
        'uid' => 'int', // 用户id
        'com_business_id' => 'int', // 自身business_id
        'com_oprid' => 'int', // 操作者id
        'com_ucredit' => 'varchar', // 统一信用代码
        'com_contact_idcard' => 'varchar', // 联系人身份证号码
        'com_contact_mobile' => 'varchar', // 联系人手机
        'com_contact_name' => 'varchar', // 联系人姓名
        'com_name' => 'varchar', // 公司名称
        'com_province' => 'int', // 省
        'com_city' => 'int', // 市
        'com_area' => 'int', // 区
        'com_detail_addr' => 'varchar', // 详细地址
        'com_legal_name' => 'varchar', // 法人姓名
        'com_license' => 'varchar', // 营业执照
        'com_legal_idcard' => 'varchar', // 法人身份证
        'com_legal_mobile' => 'varchar', // 法人手机号
        'com_checkid' => 'int', // 审核uid
        'com_check_status' => 'int', // 1审核通过 2初始状态 3 审核不通过
        'com_check_reason' => 'int', // 审核原因
        'com_checktime' => 'int', // 审核时间
        'com_uptime' => 'int', // 修改时间
        'com_intime' => 'int', /* 创建时间 */
	);

    public $com_check_status = array(
        '1' => '审核通过',
        '2' => '待审核',
        '3' => '审核不通过'
    );

    /**
     * @function 列表
     * @author ljx
     *        
     * @param array $wdata 列表查询条件
     * @param integer $wdata['ids'] 多个会员id 用逗号隔开
     * @param integer $wdata['business_id']
     * @param $integer wdata['keyword'] 匹配mobile 或 truename
     * @param string $exchange 是否转换数据
     * 
     * TODO 返回的数据 拥有者冗余 
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        
        if (! empty($wdata['ids'])) {
            $whereCond['com.com_id'] = array(
                'in',
                $wdata['ids']
            );
        }
        if (! empty($wdata['business_id'])) {
            $whereCond['com.business_id'] = $wdata['business_id'];
        }
        if (! empty($wdata['keyword'])) {
            $whereCond['com.com_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        if (! empty($wdata['check'])) {
            $tempArr = explode('|', $wdata['check']);
            $whereCond['com.com_check_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        $dataList = Db::table('opb_member_company')->alias('com')
            ->join('opb_member mem', 'mem.uid = com.uid', 'INNER')
            ->join('opb_member_rule rule', 'rule.member_id = com.uid AND rule.rule_type=10', 'INNER')
            ->where($whereCond)
            ->field('com.*,rule.rule_check_status,rule.rule_checkid,rule.rule_checktime,rule.rule_check_reason,rule_state')
            ->order('com.com_id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opb_member_company')->alias('com')
            ->join('opb_member mem', 'mem.uid = com.uid', 'INNER')
            ->join('opb_member_rule rule', 'rule.member_id = com.uid  AND rule.rule_type=10', 'INNER')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $operateData['accesstoken'] = $wdata['accesstoken'];
            $dataList = $this->parseListData($dataList, $operateData);
        }
        
        $result = array(
            'total' => $count,
            'data' => $dataList
        );
        
        return $result;
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array(), $operateData = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        $businessModel = new Business();
        $memberModel = new Member();
        
        // data - business
        $business_arr = array_unique(array_column($data, 'business_id'));
        $business_ids_string = implode(',', $business_arr);
        $businessData = $businessModel->getListByInid($business_ids_string);
        $businessData = object_array($businessData);
        $businessData = (array) $businessData;
        
        // data - member
        $member_arr_oprid = array_column($data, 'com_oprid');
        $member_arr_uid = array_column($data, 'uid');
        $member_arr_checkid = array_column($data, 'com_checkid');
        $member_arr_rule_checkid = array_column($data, 'rule_checkid');
        $member_arr = array_merge((array) $member_arr_oprid, (array) $member_arr_uid, (array) $member_arr_checkid, (array) $member_arr_rule_checkid);
        $member_arr = array_filter(array_unique($member_arr));
        $member_ids_string = implode(',', $member_arr);
        $memberData = $memberModel->getUserInfoByInid($member_ids_string);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;
        
        $addrObj = new Address();
        
        $ruleModel = new MemberRule();
        
        foreach ($data as $key => $val) {
            $data[$key]['com_license'] = array(
                array(
                    'file_path' => $val['com_license'],
                    'url' => $val['com_license']
                )
            );
            
            // 地址解析
            if (isset($data[$key]['com_province']) && ! empty($data[$key]['com_province'])) {
                $addrInfo = $addrObj->getDetail($data[$key]['com_province']);
                $data[$key]['com_province_tag'] = $addrInfo['region_name'];
            }
            if (isset($data[$key]['com_city']) && ! empty($data[$key]['com_city'])) {
                $addrInfo = $addrObj->getDetail($data[$key]['com_city']);
                $data[$key]['com_city_tag'] = $addrInfo['region_name'];
            }
            if (isset($data[$key]['com_area']) && ! empty($data[$key]['com_area'])) {
                $addrInfo = $addrObj->getDetail($data[$key]['com_area']);
                $data[$key]['com_area_tag'] = $addrInfo['region_name'];
            }
            
            // 用户规则解析
            if(isset($data[$key]['rule_check_status'])){
                $data[$key]['rule_check_status_tag'] = $ruleModel->rule_check_status[$data[$key]['rule_check_status']];
            }
            if(isset($data[$key]['rule_state'])){
                $data[$key]['rule_state_tag'] = $ruleModel->rule_state[$data[$key]['rule_state']];
            }
            isset($data[$key]['rule_check_time']) && ! empty($data[$key]['rule_check_time']) ? $data[$key]['rule_check_time_tag'] = date('Y-m-d H:i', $val['rule_check_time']) : $data[$key]['com_checktime_tag'] = '';
            
            // 时间解析
            isset($data[$key]['com_checktime']) && ! empty($data[$key]['com_checktime']) ? $data[$key]['com_checktime_tag'] = date('Y-m-d H:i', $val['com_checktime']) : $data[$key]['com_checktime_tag'] = '';
            isset($data[$key]['com_uptime']) ? $data[$key]['com_uptime_tag'] = date('Y-m-d H:i', $val['com_uptime']) : '';
            isset($data[$key]['com_intime']) ? $data[$key]['com_intime_tag'] = date('Y-m-d H:i', $val['com_intime']) : '';
            
            // 状态解析
            isset($data[$key]['com_check_status']) ? $data[$key]['com_check_status_tag'] = $this->com_check_status[$data[$key]['com_check_status']] : $data[$key]['com_check_status_tag'] = '';
            
            // 商户
            foreach ($businessData as $key_in => $val_in) {
                if ($val['business_id'] == $val_in['business_id']) {
                    $data[$key]['owner']['business'] = $val_in;
                    break;
                }
            }
            // 用户
            foreach ($memberData as $key_in => $val_in) {
                // 操作人
                if ($val['com_oprid'] == $val_in['uid']) {
                    $data[$key]['operator'] = $val_in;
                }
                // 审核人
                if ($val['com_checkid'] == $val_in['uid']) {
                    $data[$key]['checker'] = $val_in;
                }
                // 账号审核人
                if ($val['rule_checkid'] == $val_in['uid']) {
                    $data[$key]['rule_checker'] = $val_in;
                }
                // 主账号
                if ($val['uid'] == $val_in['uid']) {
                    $data[$key]['owner']['user'] = $val_in;
                }
            }
        }
        
        return $data;
    }

    /**
     * @function 获取企业详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array(), $exchange = true)
    {
        $wdata['ids'] = $wdata['com_id'];
        $wdata['page'] = 1;
        $wdata['pageSize'] = 1;
        $row = $this->getList($wdata, $operateData);
        
        if(isset($row['data'][0]) && !empty($row['data'][0])){
            return $row['data'][0];
        }else{
            return ;
        }
    }
    /**
     * @function 添加
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        // 开启事物
        Db::startTrans();
        
        // case 收集member数据
        $modelMember = new MemberBack();
        $fields_member = parseRequestData($modelMember->_tableFields, $requestData);
        if (isset($requestData['business_id']) && ! empty($requestData['business_id'])) {
            // 选择运营商传入
            $fields_member['business_id'] = $requestData['business_id'];
        } else {
            // 运营商后台主动添加
            $fields_member['business_id'] = $operateData['business']['business_id'];
        }
        $fields_member['aid'] = $operateData['user']['user_id'];
        $fields_member['reg_ip'] = getIPaddress();
        $fields_member['reg_date'] = $_SERVER['REQUEST_TIME'];
        $fields_member['pwd'] = md5(md5($fields_member['pwd']));
        
        // case member主表
        $modelMember->save($fields_member);
        $uid = $modelMember->uid;
        if (empty($uid)) {
            Db::rollback();
            return false;
        }
        
        // case member_rule 规则表
        $ruleModel = new MemberRule();
        $requestData['member_id'] = $uid;
        $result_rule = $ruleModel->add($requestData, $operateData);
        if (empty($result_rule)) {
            Db::rollback();
            return false;
        }
        
        // case member_detail TODO
        
        // case business
        $modelBusiness = new BusinessBack();
        isset($requestData['com_name']) ? $requestData_business['name'] = $requestData['com_name'] : '';
        $requestData_business['pid'] = - 1; // 会员企业没有层级
        $requestData_business['sysid'] = 5; // 会员商户
        $result_business = $modelBusiness->add($requestData_business, $operateData);
        if (empty($result_business)) {
            Db::rollback();
            return false;
        }
        $busienss_id = $result_business;
        
        // case member_company
        $fields_company = parseRequestData($this->_tableFields, $requestData);
        if (isset($requestData['business_id']) && ! empty($requestData['business_id'])) {
            // 选择运营商传入
            $fields_company['business_id'] = $requestData['business_id'];
        } else {
            // 运营商后台主动添加
            $fields_company['business_id'] = $operateData['business']['business_id'];
        }
        $fields_company['uid'] = $uid;
        $fields_company['com_business_id'] = $busienss_id;
        $fields_company['com_oprid'] = $operateData['user']['user_id'];
        $fields_company['com_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields_company['com_intime'] = $_SERVER['REQUEST_TIME'];
        $this->save($fields_company);
        $com_id = $this->com_id;
        if (empty($com_id)) {
            Db::rollback();
            return false;
        }
        
        // 提交事务
        Db::commit();
        
        return array(
            'uid' => $uid,
            'com_id' => $com_id
        );
    }
    
    /**
     * @function 编辑
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array()){
        // 开启事物
        Db::startTrans();
        
        // case member_company
        $fields_company = parseRequestData($this->_tableFields, $requestData);
        $wdata_company = array(
            'com_id' => $requestData['com_id']
        );
        $result_company = $this->save($fields_company, $wdata_company);
        if($result_company === false){
            Db::rollback();
            return false;
        }
        
        // case business
        $businessModel = new BusinessBack();
        $requestData_business = array(
            'business_id' => $requestData['com_business_id'],
            'name' => $requestData['com_name']
        );
        $result_business = $businessModel->edit($requestData_business, $operateData);
        if($result_business === false){
            Db::rollback();
            return false;
        }
        
        // 提交事务
        Db::commit();
        
        return true;
    }
    
    /**
     * @function 审核
     * @author ljx
     *
     * @param integer $wdata['uid']
     * @param integer $wdata['com_check_status'] 1审核通过 2初始状态 3 审核不通过
     * @param string @wdata['com_check_reason'] com_check_reason 审核失败原因 当value值为3时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        // 开启事物
        Db::startTrans();
        
        // case member_company
        if($wdata['com_check_status'] == 3){
            $fields_company['com_check_reason'] = $wdata['com_check_reason'];
        }
        $fields_company['com_checkid'] = $operateData['user']['user_id'];
        $fields_company['com_check_status'] = $wdata['com_check_status'];
        $fields_company['com_checktime'] = $_SERVER['REQUEST_TIME'];
        $whereCond_company['com_id'] = $wdata['com_id'];
        $result_company = Db::table('opb_member_company')->where($whereCond_company)->update($fields_company);
        if($result_company === false){
            Db::rollback();
            return false;
        }

        // case member_rule 0审核通过 1审核失败 2待审核
        if($wdata['com_check_status'] == 3){
            $fields_mem_rule['rule_check_status'] = 1;
            $fields_mem_rule['rule_check_reason'] = $wdata['com_check_reason'];
        }else if($wdata['com_check_status'] == 1){
            $fields_mem_rule['rule_check_status'] = 0;
        }
        $fields_mem_rule['rule_checkid'] = $operateData['user']['user_id'];
        $fields_mem_rule['rule_checktime'] = $_SERVER['REQUEST_TIME'];
        
        $whereCond_mem_rule['member_id'] = $wdata['uid'];
        $whereCond_mem_rule['business_id'] = $wdata['business_id'];
        $whereCond_mem_rule['rule_type'] = 10; // 定死为 10 表示对企业会员进行审核
        
        $result_mem_rule = Db::table('opb_member_rule')->where($whereCond_mem_rule)->update($fields_mem_rule);
        if($result_mem_rule === false){
            Db::rollback();
            return false;
        }

        // 提交事务
        Db::commit();
        
        return true;
    }
    
}

















