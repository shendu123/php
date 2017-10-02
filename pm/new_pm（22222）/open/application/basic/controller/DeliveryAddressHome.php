<?php
namespace app\basic\controller;

use think\Request;
use app\common\controller\NoAuth;

/**
 * @class 收货地址
 * @author ljx
 */
class DeliveryAddressHome extends NoAuth
{

    /**
     * @function 列表
     * @author ljx
     */
    public function getList()
    {
        $this->_checkLogin();
        $this->_user = $this->getCallerInfo();
        $model = new \app\basic\model\DeliveryAddress();
        
        if ($this->_user['rule']['rule_type'] == 10) {
            $owner_id = $this->_user['com']['com_id'];
            $addr_type = 10;
        } else {
            $owner_id = $this->_user['user']['user_id'];
            $addr_type = 0;
        }
        
        $wdata = array(
            'owner_id' => $owner_id,
            'addr_type' => $addr_type
        );
        $result = $model->getList($wdata);
        
        return $result;
    }

    /**
     * @function 详情
     * @author ljx
     */
    public function detail($id_param = 0)
    {
        $id_request = valueRequest('id', 0);
        $id = $id_request ? $id_request : $id_param;
        if (! empty($id)) {
            $model = new \app\basic\model\DeliveryAddress();
            $wdata = array(
                'id' => $id
            );
            $result = $model->getRow($wdata);
            if (! empty($result)) {
                return array(
                    'data' => $result
                );
            } else {
                $this->_error('未查询到该记录~', 400);
            }
        } else {
            $this->_error('id不能为空~', 400);
        }
    }

    /**
     * @function 获取默认收货地址
     * @author ljx
     */
    public function getDefault()
    {
        $this->_checkLogin();
        $this->_user = $this->getCallerInfo();
        if ($this->_user['rule']['rule_type'] == 10) {
            $owner_id = $this->_user['com']['com_id'];
            $addr_type = 10;
        } else {
            $owner_id = $this->_user['user']['user_id'];
            $addr_type = 0;
        }
        
        $model = new \app\basic\model\DeliveryAddress();
        $wdata = array(
            'owner_id' => $owner_id,
            'addr_type' => $addr_type
        );
        $result = $model->getDefault($wdata, $this->_user);
        if (empty($result)) {
            $this->_error('未查询到该记录~', 400);
        }
        
        return array(
            'data' => $result
        );
    }

    /**
     * @function 添加
     * @author ljx
     */
    public function add()
    {
        $this->_checkLogin();
        if (request()->isPost()) {
            $this->_user = $this->getCallerInfo();
            $requestData = Request::instance()->post();
            if ($this->_user['rule']['rule_type'] == 10) {
                // 如果是企业则记录 com_id
                $requestData['addr_type'] = 10;
                $requestData['owner_id'] = $this->_user['com']['com_id'];
            } elseif ($this->_user['rule']['rule_type'] == 0) {
                // 普通买家记录user_id
                $requestData['addr_type'] = 0;
                $requestData['owner_id'] = $this->_user['user']['user_id'];
            } else {
                // 业务扩展预留
                $this->_error('暂不支持该用户添加收货地址~', 400);
            }
            
            // case 表单数据有效性拦截验证
            $result_checkFields = $this->checkFields_add($requestData);
            if ($result_checkFields !== true) {
                return $result_checkFields;
            }
            
            // case 执行业务
            $model = new \app\basic\model\DeliveryAddress();
            $result = $model->add($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败~', 500);
            }
            
            // case 若当前被设置为默认地址,则其余的要设置为非默认
            if (isset($requestData['addr_isdefault']) && $requestData['addr_isdefault'] == 1) {
                $wdata = array(
                    'id' => $result,
                    'owner_id' => $requestData['owner_id']
                );
                $model->unsetDefault($wdata, $this->_user);
            }
            
            // case 结束业务
            return array(
                'msg' => '操作成功',
                'data' => array(
                    'id' => $result
                )
            );
        } else {
            $this->_error('非法请求~', 400);
        }
    }

    /**
     * @function 表单字段检查
     * @author ljx
     */
    private function checkFields_add($requestData)
    {
        // case mobile
        if (empty($requestData['addr_mobile'])) {
            $this->_error('手机号码不能为空~', 400);
        }
        if (checkMobile($requestData['addr_mobile']) === false) {
            $this->_error('手机号码不合法~', 400);
        }
        
        // case addr info
        if (empty($requestData['province'])) {
            $this->_error('省份未选择~', 400);
        }
        if (empty($requestData['city'])) {
            $this->_error('城市未选择~', 400);
        }
        if (empty($requestData['area'])) {
            $this->_error('地区未选择~', 400);
        }
        if (empty($requestData['addr_address'])) {
            $this->_error('详细收货地址未填写~', 400);
        }
        
        // case name
        if (empty($requestData['addr_truename'])) {
            $this->_error('收件人未填写~', 400);
        }
        
        return true;
    }

    /**
     * @function 编辑
     * @author ljx
     */
    public function edit()
    {
        $this->_checkLogin();
        if (request()->isPost()) {
            $this->_user = $this->getCallerInfo();
            $id = valueRequest('id', 0);
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                
                // case 表单数据有效性拦截验证
                $result_checkFields = $this->checkFields_edit($requestData);
                if ($result_checkFields !== true) {
                    return $result_checkFields;
                }
                
                // case 执行业务
                $model = new \app\basic\model\DeliveryAddress();
                $result = $model->edit($requestData, $this->_user);
                if ($result === false) {
                    $this->_error('操作失败~', 500);
                }
                
                // case 若当前被设置为默认地址,则其余的要设置为非默认
                if (isset($requestData['addr_isdefault']) && $requestData['addr_isdefault'] == 1) {
                    if ($this->_user['rule']['rule_type'] == 10) {
                        $owner_id = $this->_user['com']['com_id'];
                    } else {
                        $owner_id = $this->_user['user']['user_id'];
                    }
                    $wdata = array(
                        'id' => $id,
                        'owner_id' => $owner_id
                    );
                    $model->unsetDefault($wdata, $this->_user);
                }
                
                // case 结束业务
                return array(
                    'msg' => '操作成功'
                );
            } else {
                $this->_error('参数id不能为空~', 400);
            }
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
        if (isset($requestData['addr_mobile']) && empty($requestData['addr_mobile'])) {
            $this->_error('手机号码不能为空~', 400);
        }
        if (isset($requestData['addr_mobile']) && checkMobile($requestData['addr_mobile']) === false) {
            $this->_error('手机号码不合法~', 400);
        }
        
        // case addr info
        if (isset($requestData['province']) && empty($requestData['province'])) {
            $this->_error('省份未选择~', 400);
        }
        if (isset($requestData['city']) && empty($requestData['city'])) {
            $this->_error('城市未选择~', 400);
        }
        if (isset($requestData['area']) && empty($requestData['area'])) {
            $this->_error('地区未选择~', 400);
        }
        if (isset($requestData['addr_address']) && empty($requestData['addr_address'])) {
            $this->_error('详细收货地址未填写~', 400);
        }
        
        // case name
        if (isset($requestData['addr_truename']) && empty($requestData['addr_truename'])) {
            $this->_error('收件人未填写~', 400);
        }
        
        return true;
    }

    /**
     * @function 删除 支持单删 和 多删
     *
     * @author ljx
     */
    public function delete()
    {
        $this->_checkLogin();
        $ids = valueRequest('ids', '', 'string');
        
        if (request()->isPost()) {
            $this->_user = $this->getCallerInfo();
            if (! empty($ids)) {
                if ($this->_user['rule']['rule_type'] == 10) {
                    $owner_id = $this->_user['com']['com_id'];
                } else {
                    $owner_id = $this->_user['user']['user_id'];
                }
                
                $model = new \app\basic\model\DeliveryAddress();
                $wdata = array(
                    'ids' => $ids,
                    'owner_id' => $owner_id
                );
                
                $result = $model->delete($wdata, $this->_user);
                if ($result === false) {
                    $this->_error('操作失败~', 500);
                }
                
                return array(
                    'msg' => '操作成功'
                );
            } else {
                $this->_error('参数ids不能为空~', 400);
            }
        } else {
            $this->_error('非法请求~', 400);
        }
    }
}
