<?php
namespace app\finance\controller;

use think\Request;
use think\Db;
use app\common\controller\NoAuth;
use app\finance\model\Withdraw;

class WalletHome extends NoAuth
{

    public function __construct()
    {
        parent::__construct();
        $accesstoken = $this->request->header('accesstoken');
        $request_tag = valueRequest('request_tag', '', 'string'); //inner
        
        $this->_checkLogin();
        if (! empty($this->_uid)) {
            $this->_user = $this->getCallerInfo();
        } elseif (!empty($user_id) && empty($accesstoken) && $request_tag == 'inner') {
            $time = valueRequest('time', 0);
            $sign_req = valueRequest('sign_req', '', 'string');
            $sign_check = md5(config('SIGN_KEY') . md5($user_id . $time));
            if($sign_req != $sign_check){
                $this->_error('sign error', 400);
            }
            // 自动下单的时候无法获取token 需要通过uid来获取用户信息
            $this->_user = $this->getCallerInfo($user_id);
        } 
    }

    /**
     * @function 钱包详情
     * @author ljx
     */
    public function detail()
    {
        // case 数据调取
        $model = new \app\finance\model\Wallet();
        $wdata = array(
            'user_id' => $this->_user['user']['user_id']
        );
        $rowData = $model->getRow($wdata);
        
        if (! empty($rowData)) {
            return array(
                'data' => $rowData
            );
        } else {
            $data['user_id'] = $this->_user['user']['user_id'];
            $model->add($data);
            $rowData = $model->getRow($wdata);
            return array(
                'data' => $rowData
            );
            //$this->_error('钱包不见了~', 500);
        }
    }

    /**
     * @function 余额明细
     * @author ljx
     */
    public function log()
    {
        $flow_type = valueRequest('flow_type', 0);
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 10),
            'flow_fromid' => $this->_user['user']['user_id'],
            'flow_type' => $flow_type
        );
        $model = new \app\finance\model\FundFlow();
        $result = $model->getList($wdata, $this->_user);
        
        return array(
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }
    
    /**
     * @function 冻结明细
     * @author ljx
     */
    public function freezeLog()
    {
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 10),
            'flow_order_type' => 4
        );
        $model = new \app\finance\model\FundFlow();
        $result = $model->getList($wdata, $this->_user);
    
        return array(
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }

    /**
     * @function 余额提现
     * @author zsq
     */
    public function withdraw()
    {
        if (request()->isPost()) {
            $request = Request::instance()->post();
            $data = $request;
            
            $data['status'] = 0;
            $data['nickname'] = $this->_user['user']['nickname'];
            $data['user_id'] = $this->_user['user']['user_id'];
            $model = new Withdraw();
            $result = $model->add($data);

            if($result==true){
                return ['status'=>true, 'msg' => '申请提现成功！'];
            }else{
                return ['status'=>false, 'msg' => '申请提现失败！'];
            }
        } else {
            $this->_error("非法请求~", 400);
        }
    }   

    /**
     * @function 提现记录列表
     * @author ljx
     */
    public function withdrawList()
    {
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;
        $where = [
                'page' => valueRequest('page', 0),
                'pageSize' => $pageSize,
                'user_id' => $this->_user['user']['user_id']
            ];
            
        $model = new Withdraw();
        $result = $model->getList($where);
        return $result;
    }

    /**
     * @function 新增钱包
     * @author ljx
     * @see 不对外提供
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            // case 表单数据有效性拦截验证
            if (empty($requestData['user_id'])) {
                $this->_error("user_id不能为空~", 400);
            }
            
            // case wallet_checktoken
            //$requestData['wallet_checktoken'] = $this->genToken();
            
            // case 新增钱包
            $model = new \app\finance\model\Wallet();
            $result_add = $model->add($requestData);
            if ($result_add === false) {
                $this->_error("系统繁忙,生成钱包失败~", 500);
            }
            
            // case 结束业务
            return array(
                'wallet_id' => $result_add,
                'msg' => '生成钱包成功~'
            );
        } else {
            $this->_error("非法请求~", 400);
        }
    }
    
    /**
     * @function 增加积分
     * @author ljx
     * @param integer $purchase_price_param 单位分
     * @param boolean $needStartTrans 是否需要开启事物 默认开启
     * @see 如果当前模块使用 若上层业务有开启事务，则由上层业务来决定整个事物
     * @see 如果别的模块访问 则保证当前业务的完整性 此时不会影响别的模块的业务
     */
    public function raiseIntegral($type_param = 0, $purchase_price_param = 0, $needStartTrans = true){
        // TODO check access key, use finance SIGN_KEY
        
        $types = array(
            'register', //注册送积分
            'purchase' /*购买商品*/
        );
        
        // case 参数解析验证
        $type_request = valueRequest('type', '', 'string');
        $purchase_price_request = valueRequest('purchase_price', 0);
        
        $type = $type_param ? $type_param : $type_request;
        $purchase_price = $purchase_price_param ? $purchase_price_param : $purchase_price_request;
        
        // 注册时送积分特殊处理
        $wallet_id_param = valueRequest('wallet_id', 0);
        $user_id_param = valueRequest('user_id', 0);
        
        if(!in_array($type, $types)){
            $this->_error('增加积分类型参数type错误~', 400);
        }
        
        if($type == 'purchase' && empty($purchase_price)){
            $this->_error('当前消费金额参数purchase_price错误~', 400);
        }
        
        // case 获取站点配置
        $commonObj = new \app\finance\controller\Common();
        $config = $commonObj->getWebConfig();
        
        // case 获取积分规则并换算
        $integral = 0;
        $flow_remarks = '';
        switch($type){
            case 'register':
                $integral = $config['integral']['integral_reg']['config_value'];
                $flow_remarks = "注册赠送{$integral}积分";
                break;
            case 'purchase':
                $ratio = $config['integral']['integral_money']['config_value'];
                $ratio_maps = explode(',', $ratio);
                $integral = ceil(fd_demoney($purchase_price)*$ratio_maps[1]);
                $flow_remarks = "购买商品成功,赠送{$integral}积分";
                break;
            default:
                $this->_error('暂不支持增加该类型的积分~', 500);
        }
        
        if($needStartTrans === true){
            // 开启事物
            Db::startTrans();  
        }
        
        if(empty($wallet_id_param)){
            $this->_user['user']['wallet'] = $this->getUserWallet();
            $wallet_integral = $this->_user['user']['wallet']['wallet_integral'];
            $wallet_id = $this->_user['user']['wallet']['wallet_id'];
            $user_id = $this->_user['user']['user_id'];
        }else{
            $wallet_id = $wallet_id_param;
            $wallet_integral = 0;
            $user_id = $user_id_param;
        }
        if(empty($wallet_id)){
            $this->_error('钱包不见了~', 500);
        }
        
        // case 增加积分
        $walletModel = new \app\finance\model\Wallet();
        $wdata_wallet = array(
            'wallet_id' => $wallet_id
        );
        $requestData_wallet = array(
            'integral' => $integral
        );
        if(!empty($wallet_id_param)){
            $operateData_wallet = array();
        }else{
            $operateData_wallet = $this->_user;
        }
        $result_wallet = $walletModel->raiseIntegral($wdata_wallet, $requestData_wallet, $operateData_wallet);
        if($result_wallet === false){
            if($needStartTrans === true){
                Db::rollback();                
            }
            $this->_error('增加几分操作失败~', 500);
        }
        
        // case 记录积分流水
        $requestData_flow = array(
            'flow_code' => genOrdeCode('ITGR', $user_id),
            'user_id' => $user_id,
            'flow_type' => 1,
            'flow_type' => $wallet_integral,
            'flow_num' => $integral,
            'flow_remarks' => $flow_remarks
        );
        $flowModel = new \app\finance\model\IntegralFlow();
        $result_flow = $flowModel->add($requestData_flow);
        if($result_flow === false){
            if($needStartTrans === true){
                Db::rollback();
            }
            $this->_error('增加几分,记录流水,操作失败~', 500);
        }
        
        // case 结束业务
        if($needStartTrans === true){
            Db::commit();
        }
        return true;
    }

}


































