<?php
namespace app\basic\controller;

use think\Request;
use think\Db;
use app\common\controller\NoAuth;
use app\finance\controller\Common;
use app\basic\model\Wallet;

/**
 * @class passport 通行证
 * @author ljx
 */
class Passport extends NoAuth
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @function 普通会员注册
     * @author ljx
     */
    public function regMember()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            // 默认数据处理
            if (isset($requestData['nickname']) && empty($requestData['nickname']) || ! isset($requestData['nickname'])) {
                $requestData['nickname'] = substr_replace($requestData['mobile'], '*****', 3, 5);
            }
            $requestData['account'] = $requestData['mobile'];
            
            // 表单数据有效性拦截验证
            $result_checkFields = $this->checkFields_member($requestData);
            if ($result_checkFields !== true) {
                return $result_checkFields;
            }
            
            // 注册来源 0pc 1app 2微信 10其它 ;
            if (isset($requestData['rule_from'])) {
                $requestData['rule_from'] = $requestData['rule_from'];
            } else {
                $from = checkBrowser();
                $from_arr = array(
                    'pc' => 0,
                    'weixin' => 2,
                    'mobile' => 1
                );
                $requestData['rule_from'] = $from_arr[$from];
            }
            
            $model = new \app\basic\model\MemberBack();
            
            // 手机号码唯一性验证
            $data = array(
                'mobile' => $requestData['mobile'],
                'type' => 'add'
            );
            $checkMobileOnly_result = $model->checkMobileOnly($data);
            if ($checkMobileOnly_result == false) {
                $this->_error('手机号码已存在~', 400);
            }
            /**
             * 为了兼容，仿照$this->_user的结构 *
             */
            $operateData = array(
                'user' => array(
                    'user_id' => 0
                ),
                'business' => array(
                    'business_id' => $requestData['business_id']
                )
            );
            // case 会员
            $result = $model->add($requestData, $operateData);
            if ($result === false) {
                $this->_error('服务器繁忙,注册失败~', 500);
            }
            $user_id = $result;

            // case 钱包
            $data = array(
                'user_id' => $user_id
            );
            
            $walletId = model('Wallet')->add($data);

            // case 注册送积分   
            $commonObj = new Common();
            $config = $commonObj->getWebConfig();
            $integral = $config['shopping']['integral_reg']['config_value'];
            $flow_remarks = "注册赠送{$integral}积分";
            $wallet_integral = 0;
                                    
            $wdata_wallet = [
                'wallet_id' => $walletId
            ];
            $requestData_wallet = [
                'integral' => $integral
            ];
            $resultWallet = model('Wallet')->raiseIntegral($wdata_wallet, $requestData_wallet, []);

            $requestDataFlow = [
                'flow_code' => genOrdeCode('ITGR', $user_id),
                'user_id' => $user_id,
                'flow_type' => 1,
                'flow_type' => $wallet_integral,
                'flow_num' => $integral,
                'flow_remarks' => $flow_remarks
            ];
            $resultFlow = Db::table('op_finance.opf_integral_flow')->insert($requestDataFlow);

            // case 结束业务
            return array(
                'msg' => '操作成功',
                'data' => array(
                    'uid' => $result
                )
            );
        } else {
            $this->_error('非法请求~', 400);
        }
    }
    
    /**
     * @function 手机号是否注册过的 校验
     * @author ljx
     */
    public function isMobileExists(){
        $mobile = valueRequest('mobile', '', 'string');
        if(! checkMobile($mobile)){
            $this->_error('手机号码输入有误~', 400);
        }
        
        $type = valueRequest('type', '', 'string');
        if($type != 'add' && $type != 'edit'){
            $this->_error('参数type有误 只能输入add 或 edit ~', 400);
        }
        
        $user_id = valueRequest('user_id', 0);
        if($type == 'edit' && empty($user_id)){
            $this->_error('参数type为edit时 user_id不能为空', 400);
        }
        
        $data = array(
            'mobile' => $mobile,
            'type' => $type,
            'uid' => $user_id
        );
        
        $model = new \app\basic\model\MemberBack();
        $checkMobileOnly_result = $model->checkMobileOnly($data);
        if ($checkMobileOnly_result == false) {
            $this->_error('手机号码已存在~', 400);
        }else{
            return array(
                'data' => true
            );
        }
    }

    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields_member($requestData)
    {
        // case mobile
        if (empty($requestData['mobile'])) {
            $this->_error('手机号不能为空~', 400);
        }
        if (checkMobile($requestData['mobile']) === false) {
            $this->_error('手机号码不合法~', 400);
        }
        
        // case password
        if (strlen($requestData['pwd']) < 6 || strlen($requestData['pwd']) > 20) {
            $this->_error('密码允许设置的长度为6-20位~', 400);
        }
        
        // case 用户类型
        if ($requestData['rule_type'] != 0) {
            $this->_error('未选择注册用户类型~', 400);
        }
        
        // case 成为某个运营商的会员
        if (empty($requestData['business_id'])) {
            $this->_error('商户未选择~', 400);
        }
        
        // case ... TODO
        
        return true;
    }

    /**
     * @function 企业会员注册
     *
     * @author ljx
     */
    public function regCompany()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            // 默认数据处理
            if (isset($requestData['nickname']) && empty($requestData['nickname']) || ! isset($requestData['nickname'])) {
                $requestData['nickname'] = substr_replace($requestData['mobile'], '*****', 3, 5);
            }
            // 表单数据有效性拦截验证
            $result_checkFields = $this->checkFields_company($requestData);
            if ($result_checkFields !== true) {
                return $result_checkFields;
            }
            
            // 注册来源 0pc 1app 2微信 10其它 ;
            if (isset($requestData['rule_from'])) {
                $requestData['rule_from'] = $requestData['rule_from'];
            } else {
                $from = checkBrowser();
                $from_arr = array(
                    'pc' => 0,
                    'weixin' => 2,
                    'mobile' => 1
                );
                $requestData['rule_from'] = $from_arr[$from];
            }
            // rule_type 0普通会员 10企业会员 90营业人员 95商户总管理
            $requestData['rule_type'] = 10;
            
            $modelMember = new \app\basic\model\MemberBack();
            
            // 手机号码唯一性验证
            $data = array(
                'mobile' => $requestData['mobile'],
                'type' => 'add'
            );
            $checkMobileOnly_result = $modelMember->checkMobileOnly($data);
            if (isset($checkMobileOnly_result['status']) && $checkMobileOnly_result['status'] != 200) {
                return $checkMobileOnly_result;
            } elseif ($checkMobileOnly_result == false) {
                $this->_error('手机号码已存在~', 400);
            }
            
            $modelCompany = new \app\basic\model\CompanyBack();
            /**
             * 为了兼容，仿照$this->_user的结构 *
             */
            $operateData = array(
                'user' => array(
                    'user_id' => 0
                ),
                'business' => array(
                    'business_id' => $requestData['business_id']
                )
            );
            // case 会员
            $result_add = $modelCompany->add($requestData, $operateData);
            if ($result_add === false) {
                $this->_error('操作失败~', 500);
            }
            
            // case 钱包
            $data = array(
                'user_id' => $result_add['uid']
            );
            $result_wallet = curl_get_content(config("finance_api_url") . "Wallet/add", 1, $data);
            $result_wallet = object_array($result_wallet);
            if ($result_wallet['status'] != 200) {
                ;
            }
            
            // case 结束业务
            return array(
                'msg' => '操作成功',
                'data' => $result_add
            );
        } else {
            ;
        }
    }

    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields_company($requestData)
    {
        // case mobile
        if (empty($requestData['mobile'])) {
            $this->_error('手机号不能为空~', 400);
        }
        if (checkMobile($requestData['mobile']) === false) {
            $this->_error('手机号码不合法~', 400);
        }
        
        // case password
        if (strlen($requestData['pwd']) < 6 || strlen($requestData['pwd']) > 20) {
            $this->_error('密码允许设置的长度为6-20位~', 400);
        }
        
        // case 用户类型
        if ($requestData['rule_type'] != 10) {
            $this->_error('未选择注册用户类型~', 400);
        }
        
        // case com_contact_mobile
        if (isset($requestData['com_contact_mobile']) && checkMobile($requestData['com_contact_mobile']) === false) {
            $this->_error('联系人手机号码不合法~', 400);
        }
        
        // case com_legal_mobile
        if (isset($requestData['com_legal_mobile']) && checkMobile($requestData['com_legal_mobile']) === false) {
            $this->_error('法人手机号码不合法~', 400);
        }
        
        // case ... TODO
        
        return true;
    }

    public function login()
    {
    }

    public function logout()
    {
    }

    /**
     * @function 忘记密码
     * @author ljx
     */
    public function forgetPwd()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            if(empty($requestData['mobile'])){
                $this->_error('手机号码不能为空~', 400);
            }
            $model = new \app\basic\model\MemberBack();
            $user = $model->isExist($requestData['mobile'], true);
            //$user['pwd'] =    


            if ($requestData['password_first'] != $requestData['password_second']) {
                $this->_error('两次密码输入不一致密码输入有误~', 400);
            }
            $requestData['pwd'] = $requestData['password_first'];

            if($user['pwd'] == md5(md5($requestData['pwd']))) {
                $this->_error('输入的密码不能跟原密码一样~', 400);
            }

            if (strlen($requestData['pwd']) < 6 || strlen($requestData['pwd']) > 20) {
                $this->_error('密码允许设置的长度为6-20位~', 400);
            }
            
            // case 验证码验证
            $result_auth = curl_get_content(config("message_api_url") . "Sms/auth", 1, $requestData);
            $result_auth = object_array($result_auth);
            if(isset($result_auth['error'])){
                $this->_error($result_auth['error'], 400);
            }

            // case 修改
            
            $result = $model->changePwd($requestData);
            if($result === false){
                $this->_error('密码修改失败~', 500);
            }
            
            // case 结束业务
            return array(
                'msg' => '密码修改成功~'
            );
        } else {
            
        }
    }
}






















