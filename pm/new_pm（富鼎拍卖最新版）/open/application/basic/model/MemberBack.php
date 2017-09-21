<?php

/**
 * @class 会员member模型
 * @author ljx
 */
namespace app\basic\model;

use think\Model;
use think\Db;
use app\basic\model\MemberRule;

class MemberBack extends Model
{

    protected $table = 'opb_member';

    public $_tableFields = array(
        'uid' => 'int', // UID
        'mobile' => 'varchar', // 邮箱地址
        'account' => 'varchar', // 登录账号
        'email' => 'varchar', // 用户昵称
        'business_id' => 'int', // 商户ID
        'status' => 'int', // 状态
        'truename' => 'varchar', // 真实姓名
        'nickname' => 'varchar', // 用户昵称
        'phone' => 'varchar', // 电话
        'pwd' => 'varchar', // 密码MD5*2
        'avatar' => 'varchar', // 用户头像url
        'login_ip' => 'varchar', // 登录ip
        'login_time' => 'int', // 登录时间
        //'aid' => 'int', // 推广人id,member.uid
        'pay_wallet_id' => 'varchar', // 用户钱包id
        'checkid' => 'int', // 审核人id
        'ischeck' => 'int', // 2初始状态 3 审核不通过 1审核通过
        'iscom' => 'int', // 2个人用户 1公司用户
        'sex' => 'int', // 0女1男 2保密
        'birthday' => 'int', // 用户生日【转detail】
        'reg_ip' => 'varchar', // 注册IP地址【转detail】
        'reg_date' => 'int', // 注册时间【转detail】
        'province' => 'int', // 省份【转detail】
        'city' => 'int', // 城市【转detail】
        'area' => 'int', // 区、县【转detail】
        'address' => 'varchar', // 地址【转detail】
        'postalcode' => 'int', /* 邮政编码【转detail】 */
	);

    public $sex = array(
        0 => '女',
        1 => '男',
        2 => '保密'
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
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        
        if (! empty($wdata['ids'])) {
            $whereCond['m.id'] = array(
                'in',
                $wdata['ids']
            );
        }
        if (! empty($wdata['business_id'])&&$wdata['sysid']!=1) {
            $whereCond['m.business_id'] = $wdata['business_id'];
        }
        if (! empty($wdata['keyword'])) {
            $whereCond['m.mobile|m.truename|m.nickname'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        if (! empty($wdata['check'])) {
            $tempArr = explode('|', $wdata['check']);
            $whereCond['rule.rule_check_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        $dataObj = Db::table('opb_member')->alias('m');
        $dataList = $dataObj->join('opb_member_rule rule', 'rule.member_id = m.uid AND rule.rule_type = 0', 'INNER')
            ->where($whereCond)
            ->field('m.*,rule.*')
            ->order('m.uid desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opb_member')->alias('m')
            ->join('opb_member_rule rule', 'rule.member_id = m.uid AND rule.rule_type = 0', 'INNER')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $operateData['accesstoken'] = $wdata['accesstoken'];
            $dataList = $this->parseListData($dataList, $operateData);
        }  
        foreach($dataList as $k=>$v){
            $waInfo=$this->getWallet($v['uid']);
            $dataList[$k]['wallet_keyong']=0;
            $dataList[$k]['wallet_out']=0;
            $dataList[$k]['wallet_freeze'] = 0;
            $dataList[$k]['point'] = 0; 
            if($waInfo){
                $dataList[$k]['wallet_keyong']=$waInfo['wallet_money']-$waInfo['wallet_deposit']-$waInfo['wallet_freeze'];
                $dataList[$k]['wallet_out']=$waInfo['wallet_out'];
                $dataList[$k]['wallet_freeze'] = $waInfo['wallet_freeze'];
                $dataList[$k]['point'] = $waInfo['point']; 
            }            
        }
        $result = array(
            'total' => $count,
            'data' => $dataList
        );
        
        return $result;
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($uid_param = 0){
        $uid_request = valueRequest('uid', 0);
        $uid = $uid_param ? $uid_param : $uid_request;
        
        $row = Db::table('opb_member')
            ->where("uid = '{$uid}' ")
            ->field('uid,mobile,account,business_id,truename,nickname,phone,avatar,sex,birthday,province,city,area,address,postalcode')
            ->find();
            
        return $row;
    }
    
    //获取钱包
    public function getWallet($uid){
        return Db::table('op_pay.opa_wallet')->where("uid = '{$uid}' ")->find();
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
        $member_arr_oprid = array_column($data, 'rule_oprid');
        $member_arr_checkid = array_column($data, 'rule_checkid');
        $member_arr = array_merge((array) $member_arr_oprid, (array) $member_arr_checkid);
        $member_arr = array_filter(array_unique($member_arr));
        $member_ids_string = implode(',', $member_arr);
        $memberData = $memberModel->getUserInfoByInid($member_ids_string);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;
        
        $ruleModel = new MemberRule();
        
        foreach ($data as $key => $val) {
            $data[$key]['avatar'] = array(
                array(
                    'file_path' => $val['avatar'],
                    'url' => $val['avatar']
                )
            );
            
            // 时间解析
            isset($data[$key]['login_time']) && !empty($data[$key]['login_time']) ? $data[$key]['login_time_tag'] = date('Y-m-d H:i', $val['login_time']) : $data[$key]['login_time_tag'] = '';
            isset($data[$key]['reg_date']) && !empty($data[$key]['reg_date']) ? $data[$key]['reg_date_tag'] = date('Y-m-d H:i', $val['reg_date']) : $data[$key]['reg_date_tag'] = '';
            isset($data[$key]['birthday']) && !empty($data[$key]['birthday']) ? $data[$key]['birthday_tag'] = date('Y-m-d', $val['birthday']) : $data[$key]['birthday_tag'] = '';
            
            // 状态解析
            isset($data[$key]['rule_state']) ? $data[$key]['rule_state_tag'] = $ruleModel->rule_state[$data[$key]['rule_state']] : $data[$key]['rule_state_tag'] = '';
            isset($data[$key]['rule_from']) ? $data[$key]['rule_from_tag'] = $ruleModel->rule_from[$data[$key]['rule_from']] : $data[$key]['rule_from_tag'] = '';
            isset($data[$key]['rule_type']) ? $data[$key]['rule_type_tag'] = $ruleModel->rule_type[$data[$key]['rule_type']] : $data[$key]['rule_type_tag'] = '';
            isset($data[$key]['rule_check_status']) ? $data[$key]['rule_check_status_tag'] = $ruleModel->rule_check_status[$data[$key]['rule_check_status']] : $data[$key]['rule_check_status_tag'] = '';
            
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
                if (isset($val_in['uid'])&&$val['rule_oprid'] == $val_in['uid']) {
                    $data[$key]['operator'] = $val_in;
                }
                // 审核人
                if (isset($val_in['uid'])&&$val['rule_checkid'] == $val_in['uid']) {
                    $data[$key]['checker'] = $val_in;
                }
            }
        }

        return $data;
    }

    /**
     * @function 添加
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        /**
         * @caution 注意 维持member唯一 多条rule TODO very important
         * 必须维持 member + business_id + rule_type 唯一
         * 考虑将该功能做成独立添加会员买家 拆分添加各种不能身份 例如 卖家 运营商 会员企业 人资等等
         */
        $fields = parseRequestData($this->_tableFields, $requestData);
        
        if(isset($requestData['business_id']) && !empty($requestData['business_id'])){
            // 选择运营商传入
            $fields['business_id'] = $requestData['business_id'];
        }else{
            // 运营商后台主动添加
            $fields['business_id'] = $operateData['business']['business_id'];
        }
        
        //$fields['aid'] = $operateData['user']['user_id'];
        $fields['reg_ip'] = getIPaddress();
        $fields['reg_date'] = $_SERVER['REQUEST_TIME'];
        $fields['pwd'] = md5(md5($fields['pwd']));
        
        // 开启事物
        Db::startTrans();
        
        // case member主表
        $this->save($fields);
        $uid = $this->uid;
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
        
        // 提交事务
        Db::commit();
        
        return $uid;
    }

    /**
     * @function 编辑
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function edit($requestData = array(), $operateData = array())
    {
        // 主表
        $fields = parseRequestData($this->_tableFields, $requestData);
        if (! empty($fields['pwd'])) {
            $fields['pwd'] = md5(md5($fields['pwd']));
        }
        
        // 开启事物
        Db::startTrans();
        
        // case 主表
        $wdata = array(
            'uid' => $fields['uid']
        );
        
        $result = $this->save($fields, $wdata);
        if ($result === false) {
            Db::rollback();
            return false;
        }
        
        // case member_rule 规则表
        $ruleModel = new MemberRule();
        $requestData['member_id'] = $fields['uid'];
        $result_rule = $ruleModel->edit($requestData, $operateData);
        if ($result_rule === false) {
            Db::rollback();
            return false;
        }
        
        // case member_detail 详情表 TODO
        
        // 提交事务
        Db::commit();
        
        return true;
    }
    
    /**
     * @function 修改密码
     * @author ljx
     */
    public function changePwd($requestData = array(), $operateData = array()){
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['pwd'] = md5(md5($fields['pwd']));
        if(empty($requestData['uid'])){
            $wdata = array(
                'mobile' => $requestData['mobile']
            ); 
        }else{
            $wdata = array(
                'uid' => $requestData['uid']
            );
        }
        
        return $result = $this->save($fields, $wdata);
    }
    
    /**
     * @function 审核
     * @author ljx
     *
     * @param integer $wdata['uid']
     * @param integer $wdata['rule_check_status'] 0审核通过 1审核失败 2待审核
     * @param string @wdata['rule_check_reason'] rule_check_reason 审核失败原因 当value值为1时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        if($wdata['rule_check_status'] == 1){
            $fields['rule_check_reason'] = $wdata['rule_check_reason'];
        }
        
        $fields['rule_checkid'] = $operateData['user']['user_id'];
        $fields['rule_check_status'] = $wdata['rule_check_status'];
        $fields['rule_checktime'] = $_SERVER['REQUEST_TIME'];
        
        $whereCond['member_id'] = $wdata['uid'];
        $whereCond['business_id'] = $wdata['business_id'];
        $whereCond['rule_type'] = 0; // 定死为 0 表示对会员买家进行审核
        
        return Db::table('opb_member_rule')->where($whereCond)->update($fields);
    }
    
    /**
     * @function 启用禁用
     * @author ljx
     *
     * @param string $wdata['ids'] ids MUST 1,2,3
     * @param integer $wdata['value'] cat_disable值 0启用，1禁用
     */
    public function ableAll($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['member_id'] = array(
            'in',
            $wdata['ids']
        );
        $whereCond['business_id'] = $operateData['business']['business_id'];
        $whereCond['rule_type'] = 0;//会员买家
        $fields = array(
            'rule_state' => $wdata['value'],
            'rule_oprid' => $operateData['user']['user_id'],
            'rule_uptime' => $_SERVER['REQUEST_TIME']
        );
        
        return Db::table('opb_member_rule')->where($whereCond)->update($fields);
    }

    /**
     * @function 手机号码唯一判断
     * @author ljx
     * @param string $type: add edit
     */
    public function checkMobileOnly($data = array())
    {
        if (empty($data['mobile'])) {
            return array(
                'status' => 404,
                'msg' => '手机号码不能为空~'
            );
        }
        if ($data['type'] == 'add') {
            $whereCond['mobile'] = $data['mobile'];
            $count = Db::table('opb_member')->where($whereCond)->count();
        } elseif ($data['type'] == 'edit') {
            
            if (empty($data['uid'])) {
                return array(
                    'status' => 404,
                    'msg' => 'uid不能为空~'
                );
            }
            
            $whereCond['mobile'] = $data['mobile'];
            $whereCond['uid'] = array(
                "neq",
                $data['uid']
            );
            $count = Db::table('opb_member')->where($whereCond)->count();
        }
        
        return $count == 0 ? true : false;
    }
    
    /**
     * @function 昵称唯一性判断
     * @author ljx
     * @param string $type: add edit
     */
    public function checkNicknameOnly($data = array())
    {
        if (empty($data['nickname'])) {
            return array(
                'status' => 404,
                'msg' => '会员昵称不能为空~'
            );
        }
        if ($data['type'] == 'add') {
            $whereCond['nickname'] = $data['nickname'];
            $count = Db::table('opb_member')->where($whereCond)->count();
        } elseif ($data['type'] == 'edit') {
    
            if (empty($data['uid'])) {
                return array(
                    'status' => 404,
                    'msg' => 'uid不能为空~'
                );
            }
    
            $whereCond['nickname'] = $data['nickname'];
            $whereCond['uid'] = array(
                "neq",
                $data['uid']
            );
            $count = Db::table('opb_member')->where($whereCond)->count();
        }
    
        return $count == 0 ? true : false;
    }

    /**
     * @function 身份唯一判断
     * @author ljx
     *         @readme 添加身份是从主表出发 故不考虑放从表rule
     */
    public function checkRuleOnly()
    {
    }
    
    /**
     * @functon 手机号码是否存在
     * @author ljx
     */
    public function isExist($mobile = "", $isData=false){
        $row = Db::table('opb_member')->where("mobile = '{$mobile}' ")->find();
        if($isData){
            return $row;
        }
        if(!empty($row)){
            return true;
        }else{
            return false;
        }
    }
}













