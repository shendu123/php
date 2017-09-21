<?php
namespace app\basic\controller;

use app\common\controller\NoAuth;
use think\Request;
use think\Session;
use app\basic\model\AccessToken;

/**
 * @class 会员
 * @author ljx
 */
class MemberHome extends NoAuth
{
    public function __construct(){
        parent::__construct();
        if(!empty($this->request->header('accesstoken'))){
            $this->_user = $this->getCallerInfo();
        }
    }

    /**
     * @function 获取会员详情
     * @author ljx
     */
    public function detail($id_param = 0)
    {
        $id_request = valueRequest('user_id', 0);
        $id = $id_request ? $id_request : $id_param;
        $id = $id ? $id : $this->_user['user']['user_id'];
        if (! empty($id)) {
            $model = new \app\basic\model\MemberBack();
            
            $result = $model->getRow($id);
            if (! empty($result)) {
                return array(
                    'data' => $result
                );
            } else {
                $this->_error('未查询到该记录~', 400);
            }
        } else {
            $this->_error('user_id不能为空~', 400);
        }
    }

    /**
     * @function 编辑资料 基本资料和密码头像等
     * @author ljx
     */
    public function edit()
    {
        if (request()->isPost()) {
            // case 内层模型调用兼容
            $requestData = Request::instance()->post();
            $requestData['uid'] = $this->_user['user']['user_id']; // 修改member时用
            $requestData['business_id'] = $this->_user['business']['business_id']; // 修改member_rule.rule_type时用
            $requestData['rule_type'] = $this->_user['rule']['rule_type']; // 修改member_rule.rule_type时用
                                                                           
            // case 表单数据有效性拦截验证
            $result_checkFields = $this->checkFields_edit($requestData);
            $model = new \app\basic\model\MemberBack();
            if ($result_checkFields !== true) {
                return $result_checkFields;
            } elseif (isset($requestData['old_password']) && ! empty($requestData['old_password'])) {
                $userInfo = $model->where('uid', $requestData['uid'])->find();    
                if(md5(md5($requestData['old_password'])) != $userInfo['pwd']){
                    $this->_error('原始密码不正确', 400);
                }
                $requestData['pwd'] = $requestData['new_password'];
            }
            
            // case 数据类型转换
            isset($requestData['birthday']) ? $requestData['birthday'] = strtotime($requestData['birthday']) : '';
            
          
            
            // case 如果手机号码有改动 就进行手机号码唯一性验证
            if (isset($requestData['mobile']) && $this->_user['user']['mobile'] != $requestData['mobile']) {
                $data = array(
                    'mobile' => $requestData['mobile'],
                    'uid' => $requestData['uid'],
                    'type' => 'edit'
                );
                $checkMobileOnly_result = $model->checkMobileOnly($data);
                if (isset($checkMobileOnly_result['status']) && $checkMobileOnly_result['status'] != 200) {
                    $this->_error($checkNicknameOnly_result['msg'], 400);
                } elseif ($checkMobileOnly_result == false) {
                    $this->_error('手机号码已存在~', 400);
                }
            }
            // case 如果昵称有改动 就进行昵称唯一性验证
            if (isset($requestData['nickname']) && $this->_user['user']['nickname'] != $requestData['nickname']) {
                $data = array(
                    'nickname' => $requestData['nickname'],
                    'uid' => $requestData['uid'],
                    'type' => 'edit'
                );
                $checkNicknameOnly_result = $model->checkNicknameOnly($data);
                if (isset($checkNicknameOnly_result['status']) && $checkNicknameOnly_result['status'] != 200) {
                    $this->_error($checkNicknameOnly_result['msg'], 400);
                } elseif ($checkNicknameOnly_result == false) {
                    $this->_error('此昵称已重复,请修改~', 400);
                }
            }
            
            // case 执行业务
            $result = $model->edit($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败~', 500);
            }
            
            // case 清空session
            Session::delete($this->request->header('accesstoken'));
            
            // case 结束业务
            return array(
                'msg' => '操作成功'
            );
        } else {
            $this->_error('非法请求~', 400);
        }
    }

    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields_edit($requestData)
    {
        // case mobile
        if (isset($requestData['mobile']) && empty($requestData['mobile'])) {
            $this->_error('手机号码不能为空~', 400);
        }
        if (isset($requestData['mobile']) && checkMobile($requestData['mobile']) === false) {
            $this->_error('手机号码不合法~', 400);
        }
        
        // case password
        if (isset($requestData['password_first']) && isset($requestData['password_second'])) {
            if ($requestData['password_first'] !== $requestData['password_second']) {
                $this->_error('两次输入的密码不相同~', 400);
            }
        }
        
        // case ... TODO
        
        return true;
    }
}
