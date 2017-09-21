<?php
namespace app\basic\controller;

use app\common\controller\Base;
use think\Request;
use think\Db;
class Member extends base
{

    /**
     * @function 会员列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\basic\model\MemberBack();
        
        $operateData = $this->_user;
        
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'check' => valueRequest('check', 'egt|0', 'string'),
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'ids' => valueRequest('ids', '', 'string'),
            'business_id' => $this->_user['business']['business_id'],
            'keyword' => valueRequest('keyword', '', 'string'),
            'sysid'=>$this->_sysid
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
    public function detail()
    {
        $id = valueRequest('id', 0);
        if (! empty($id)) {
            $model = new \app\basic\model\MemberBack();
            
            $wdata = array(
                'id' => $id
            );
            
            $result = $model->getRow($wdata);
            if (! empty($result)) {
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'data' => $result
                );
            } else {
                $this->_error('用户不存在或已删除~', 500);
            }
        } else {
            $this->_error('用户不存在或已删除~', 500);
        }
    }

    /**
     * @function 添加买家会员
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            if (isset($requestData['avatar'])) {
                $requestData["avatar"] = $requestData['avatarArray'];
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
            // rule_type 0普通会员 90营业人员 95商户总管理
            $requestData['rule_type'] = 0;
            
            $model = new \app\basic\model\MemberBack();
            
            // 手机号码唯一性验证
            $data = array(
                'mobile' => $requestData['mobile'],
                'type' => 'add'
            );
            $checkMobileOnly_result = $model->checkMobileOnly($data);
            if(isset($checkMobileOnly_result['status']) && $checkMobileOnly_result['status'] != 200){
                return $checkMobileOnly_result;
            }elseif($checkMobileOnly_result == false){
                return array(
                    'status' => '404',
                    'msg' => '手机号码已存在~'
                );
            }
            
            $result = $model->add($requestData, $this->_user);
            if ($result === false) {
                $this->_error('保存失败，请稍后再试', 500);
            } else {
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'new_id' => $result
                );
            }
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
            $id = valueRequest('uid', 0);
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                
                if (isset($requestData['avatarArray'])) {
                    $requestData["avatar"] = $requestData['avatarArray'];
                }
                
                // 表单数据有效性拦截验证
                $result_checkFields = $this->checkFields_edit($requestData);
                if ($result_checkFields !== true) {
                    return $result_checkFields;
                } else 
                    if (isset($requestData['password_first']) && ! empty($requestData['password_first'])) {
                        $requestData['pwd'] = $requestData['password_first'];
                    }
                
                $model = new \app\basic\model\MemberBack();
                
                // 手机号码唯一性验证
                $data = array(
                    'mobile' => $requestData['mobile'],
                    'uid' => $requestData['uid'],
                    'type' => 'edit'
                );
                $checkMobileOnly_result = $model->checkMobileOnly($data);
                if(isset($checkMobileOnly_result['status']) && $checkMobileOnly_result['status'] != 200){
                    return $checkMobileOnly_result;
                }elseif($checkMobileOnly_result == false){
                    return array(
                        'status' => '404',
                        'msg' => '手机号码已存在~'
                    );
                }
                
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
                $this->_error('id不能为空' . $id, 400);
            }
        } else {
            ;
        }
    }

    /**
     * @function 删除
     * @author ljx
     *         @readme 不可删主表记录 只可删除rule记录
     */
    public function delete()
    {
    }
    
    /**
     * @function 修改密码
     * @author ljx
     */
    public function changepwd($requestData = array()){
        if(empty($requestData)){
            $requestData = Request::instance()->post();
        }
        
        if ($requestData['password_first'] != $requestData['password_second']) {
            return array(
                'status' => 404,
                'msg' => '密码输入有误~'
            );
        }
        $requestData['pwd'] = $requestData['password_first'];
        
        $model = new \app\basic\model\MemberBack();
        $result = $model->changePwd($requestData, $this->_user);
        if($result === false){
            return array(
                'status' => 500,
                'msg' => '密码修改失败~'
            );
        }else{
            return array(
                'status' => 200,
                'msg' => '密码修改成功~'
            );
        }
    }
    
    /**
     * @function 启用禁用 可批量
     * @author ljx
     */
    public function ableAll()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        $value = valueRequest('value', 0);
    
        $ids = $id_single ? $id_single : $id_multi;
        if (! empty($ids)) {
            $model = new \app\basic\model\MemberBack();
            $wdata = array(
                'ids' => $ids,
                'value' => $value
            );
    
            $result = $model->ableAll($wdata, $this->_user);
            if ($result === false) {
                return array(
                    'status' => 500,
                    'msg' => '操作失败~'
                );
            } else {
                return array(
                    'status' => 200,
                    'msg' => '操作成功'
                );
            }
        } else {
            $this->_error('参数id不能为空', 400);
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
            $id = valueRequest('id', 0);
            $value = valueRequest('value', 0);
            if (empty($id)) {
                $this->_error('uid不能为空', 400);
            }
            $wdata['uid'] = $id;
            switch ($value) {
                case 0: // 审核成功
                    break;
                case 1: // 审核失败 需要填写审核失败原因
                    $reason = valueRequest('reason', '', 'string');
                    if (empty($reason)) {
                        $this->_error('reason【审核失败原因】参数值不能为空', 400);
                    }
                    $wdata['rule_check_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['rule_check_status'] = $value;
            $wdata['business_id'] = valueRequest('business_id', 0);
    
            $model = new \app\basic\model\MemberBack();
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
     * @function 收货地址
     * @author zxl
     */
    public function address(){
        $uid=request()->param('uid');
        $aModel=new \app\basic\model\DeliveryAddress(); 
        $addressList=$aModel->getDataListById($uid);
        return $addressList;
    }

    /**
     * @function钱包交易记录
     * @author zxl
     */
    public function walletRecord(){
        $waModel=new \app\finance\model\WalletAction();
        $where['uid']=request()->param('uid');
        $page['pageSize']= request()->param('s');
        $page['page']=request()->param('p');
        $list=$waModel->getListByUid($page,$where);
        return $list;
    }
    /**
     * @function调节金额
     * @author zxl
     */
    public function adjustMoney(){
        $waModel=new \app\finance\model\WalletAction();
        $data=request()->param();
        if(!is_numeric($data['money'])||!is_numeric($data['point'])){
            $this->_error('格式错误', 500);
        }
        $data['money']=$data['opMoney']>0?$data['money']:'-'.$data['money'];
        $data['point']=$data['opPoint']>0?$data['point']:'-'.$data['point'];
        $data['wallet_freeze'] = $data['opWallet_freeze']>0?$data['wallet_freeze']:'-'.$data['wallet_freeze'];
        $data['createtime']=date('Y-m-d H:i:s',time());

        unset($data['opMoney']);unset($data['opPoint']);unset($data['opWallet_freeze']);
        $util = new \app\finance\library\Util();
        $data['pay_wa_time_id'] = $util->getUID();
        if(!Db::table('op_pay.opa_wallet_action')->insert($data)){
            $this->_error('添加失败', 500);
        }
        return ['msg'=>'操作成功'];
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
        
        // case password
        if ((isset($requestData['password_first']) && isset($requestData['password_second']))) {
            if ($requestData['password_first'] !== $requestData['password_second']) {
                return array(
                    'status' => 404,
                    'msg' => '密码输入有误~'
                );
            }
        }
        
        // case ... TODO
        
        return true;
    }
}




























