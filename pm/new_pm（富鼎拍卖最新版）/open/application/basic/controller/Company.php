<?php
namespace app\basic\controller;

use app\common\controller\Base;
use think\Request;
use app\basic\model\MemberBack;

class Company extends base
{

    /**
     * @function 会员企业列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\basic\model\CompanyBack();
        
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'check' => valueRequest('check', 'egt|1', 'string'),
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'ids' => valueRequest('ids', '', 'string'),
            'business_id' => valueRequest('business_id', 0),
            'keyword' => valueRequest('keyword', '', 'string')
        );
        $result = $model->getList($wdata, $this->_user);
        
        return array(
            'status' => 200,
            'msg' => '成功',
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }

    /**
     * @function 详情
     *
     * @author ljx
     */
    public function getDetail()
    {
        $id = valueRequest('com_id', 0);
        if (! empty($id)) {
            $model = new \app\basic\model\CompanyBack();
            
            $wdata = array(
                'accesstoken' => $this->request->header('accesstoken'), // 不需要传
                'com_id' => $id
            );
            
            $result = $model->getRow($wdata, $this->_user);
            if (! empty($result)) {
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'data' => $result
                );
            } else {
                $this->_error('会员不存在或已删除~', 500);
            }
        } else {
            $this->_error('会员不存在或已删除~', 500);
        }
    }

    /**
     * @function 添加企业会员
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            if (isset($requestData['com_licenseArray'])) {
                $requestData["com_license"] = $requestData['com_licenseArray'];
            }
            
            // 表单数据有效性拦截验证
            $result_checkFields = $this->checkFields($requestData);
            if ($result_checkFields !== true) {
                return $result_checkFields;
            }
            $requestData['pwd'] = $requestData['password_first'];
            
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
                return array(
                    'status' => '404',
                    'msg' => '手机号码已存在~'
                );
            }
            
            $modelCompany = new \app\basic\model\CompanyBack();
            $result_add = $modelCompany->add($requestData, $this->_user);
            if ($result_add === false) {
                return array(
                    'status' => 500,
                    'msg' => '操作失败'
                );
            }
            
            return array(
                'status' => 200,
                'msg' => '操作成功',
                'mew_id' => $result_add
            );
        } else {
            ;
        }
    }

    /**
     * @function 编辑
     *
     * @author ljx
     */
    public function edit()
    {
        if (request()->isPost()) {
            $id = valueRequest('com_id', 0);
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                
                if (isset($requestData['com_licenseArray'])) {
                    $requestData["com_license"] = $requestData['com_licenseArray'];
                }
                
                // 表单数据有效性拦截验证
                $result_checkFields = $this->checkFields_edit($requestData);
                if ($result_checkFields !== true) {
                    return $result_checkFields;
                }
                $model = new \app\basic\model\CompanyBack();
                $result = $model->edit($requestData, $this->_user);
                if ($result === false) {
                    $this->_error('保存失败，请稍后再试', 500);
                } else {
                    return array(
                        'status' => 200,
                        'msg' => '操作成功'
                    );
                }
            } else {
                $this->_error('com_id不能为空' . $id, 400);
            }
        } else {
            ;
        }
    }
    
    /**
     * @function 获取企业会员详情信息
     * @author ljx
     */
    public function getMemberDetail($uid_param = 0){
        $uid_request = valueRequest('uid', 0);
        $uid = $uid_param ? $uid_param : $uid_request;
        
        if(! empty($uid)){
            
            $memberModel = new MemberBack();
            $row = $memberModel->getRow($uid);
            unset($row['pwd']);
            return array(
                'status' => 200,
                'data' => $row
            );
        }else{
            return array(
                'status' => 404,
                'msg' => 'uid不能为空~'
            );
        }
    }
    
    /**
     * @function 修改密码
     * @author ljx
     */
    public function changepwd(){
        $uid = valueRequest('uid', 0);
        
        if(!empty($uid)){
            $memberObj = new Member();
            $requestData = Request::instance()->post();
            $result = $memberObj->changepwd($requestData);
            if($result === false){
                return array(
                    'status' => 500,
                    'msg' => '操作失败~'
                );
            }else{
                return array(
                    'status' => 200,
                    'msg' => '操作成功~'
                );
            }
        }else{
            return array(
                'status' => 404,
                'msg' => 'uid不能为空'
            );
        }
    }
    
    /**
     * @function 审核
     * @author ljx
     *
     */
    public function check()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = valueRequest('com_id', 0);
            $value = valueRequest('value', 0);
            if (empty($id)) {
                $this->_error('com_id不能为空', 400);
            }
            $wdata['com_id'] = $id;
            switch ($value) {
                case 1: // 审核成功
                    break;
                case 3: // 审核失败 需要填写审核失败原因
                    $reason = valueRequest('reason', '', 'string');
                    if (empty($reason)) {
                        $this->_error('reason【审核失败原因】参数值不能为空', 400);
                    }
                    $wdata['com_check_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['com_check_status'] = $value;
            $wdata['business_id'] = valueRequest('business_id', 0);
            $wdata['uid'] = valueRequest('uid', 0);
    
            $model = new \app\basic\model\CompanyBack();
            $result = $model->check($wdata, $this->_user);
            if ($result === false) {
                $this->_error('system error', 500);
            }
    
            return array(
                'status' => 200,
                'msg' => '操作成功'
            );
        } else {
            ;
        }
    }

    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields($requestData)
    {
        // case mobile
        if (empty($requestData['mobile'])) {
            return array(
                'status' => 404,
                'msg' => '手机号不能为空~'
            );
        }
        if (checkMobile($requestData['mobile']) === false) {
            return array(
                'status' => 404,
                'msg' => '手机号码不合法~'
            );
        }
        
        // case com_contact_mobile
        if (isset($requestData['com_contact_mobile']) && checkMobile($requestData['com_contact_mobile']) === false) {
            return array(
                'status' => 404,
                'msg' => '联系人手机号码不合法~'
            );
        }
        
        // case com_legal_mobile
        if (empty($requestData['com_legal_mobile'])) {
            return array(
                'status' => 404,
                'msg' => '法人手机号不能为空~'
            );
        }
        if (checkMobile($requestData['com_legal_mobile']) === false) {
            return array(
                'status' => 404,
                'msg' => '法人手机号码不合法~'
            );
        }
        
        // case password
        if ((isset($requestData['password_first']) && isset($requestData['password_second']))) {
            if ($requestData['password_first'] != $requestData['password_second'] || empty($requestData['password_first'])) {
                return array(
                    'status' => 404,
                    'msg' => '密码输入有误~'
                );
            }
        }
        
        // case ... TODO
        
        return true;
    }
    
    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields_edit($requestData)
    {
        // case com_contact_mobile
        if (isset($requestData['com_contact_mobile']) && checkMobile($requestData['com_contact_mobile']) === false) {
            return array(
                'status' => 404,
                'msg' => '联系人手机号码不合法~'
            );
        }
        
        // case com_legal_mobile
        if (empty($requestData['com_legal_mobile'])) {
            return array(
                'status' => 404,
                'msg' => '法人手机号不能为空~'
            );
        }
        if (checkMobile($requestData['com_legal_mobile']) === false) {
            return array(
                'status' => 404,
                'msg' => '法人手机号码不合法~'
            );
        }
    
        return true;
    }
}




























