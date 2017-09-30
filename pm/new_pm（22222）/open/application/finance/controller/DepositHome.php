<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use think\Request;
use think\Db;

class DepositHome extends NoAuth
{

    private $tradeData;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @function 退回保证金
     * @author ljx
     * @param integer $order_stuff_type 业务类型:0竞价保证金
     * @param integer $order_stuff_id 业务id: 0对应auction.id
     * @param integer $user_id 会员id 获得该业务的会员id
     * @param integer $time 时间戳
     * @param string $token 签名
     * @see 涉及到 订单 流水 钱包
     */
    public function retreat()
    {
        // case 获取提交的数据
        $this->tradeData = Request::instance()->post();
        
        // case 参数验证
        $this->checkRetreatPostData();
        
        // case 退回保证金 TODO 这边order可以泛义
        $sql_order = "
                SELECT order_id,business_id,user_id,order_stuff_type,order_stuff_id,order_paytotal_price,
                    order_pay_type,order_status,order_paytime 
                FROM opf_deposit_order 
                WHERE user_id != {$this->tradeData['user_id']} 
                	AND order_status = 2
                	AND order_stuff_type = {$this->tradeData['order_stuff_type']}
                	AND order_stuff_id = {$this->tradeData['order_stuff_id']}
        ;";
        $order_list_total = Db::query($sql_order);
        if (empty($order_list_total)) {
            $this->_error('未查询到需要退回的保证金记录', 400);
        }
        
        // 一次处理一百个
        $order_list_array = fd_divide_array($order_list_total, 100);
        
        // 开启事物
        Db::startTrans();

        foreach ($order_list_array as $key_out => $val_out) {
            $order_list = $val_out;
            $order_paytotal_price_list = array_column($order_list, 'order_paytotal_price', 'user_id');
            $user_ids = array_column($order_list, 'user_id');
            $user_ids = implode(',', $user_ids);
            
            // 获取改动前的钱包可用余额 后面写流水要用
            $walletModel = new \app\finance\model\Wallet();
            $wdata_wallet = array(
                'user_ids' => $user_ids
            );
            $wallet_list = $walletModel->getList($wdata_wallet);
            $wallet_list = array_column($wallet_list['data'], 'wallet_available_price', 'user_id');
            
            // 构建退回保证金到余额的sql语句
            $sql_update = "
            UPDATE opf_wallet
            SET ";
            $sql_available = "
                wallet_available_price = wallet_available_price +
                    CASE user_id";
            $sql_freeze = "
                wallet_freeze_price = wallet_freeze_price -
                    CASE user_id";
            foreach ($order_paytotal_price_list as $key_uid => $val_price) {
                $sql_available .= "
                WHEN {$key_uid} THEN {$val_price}";
                $sql_freeze .= "
                WHEN {$key_uid} THEN {$val_price}";
            }
            $sql_end = "
                    END";
            $sql_where = "
            WHERE user_id IN ({$user_ids})";
            // TODO token genToken
            
            $sql_update = $sql_update . $sql_available . $sql_end . ',' . $sql_freeze . $sql_end . $sql_where;
            $result_wallet = Db::query($sql_update);
            if ($result_wallet === false) {
                Db::rollback();
                $this->_error('释放保证金到可用余额失败', 500);
            }
            
            // case 保证金订单状态转移
            $order_ids = array_column($order_list, 'order_id');
            $order_ids = implode(',', $order_ids);
            $depositModel = new \app\finance\model\DepositOrder();
            $wdata_deposit = array(
                'order_id' => array(
                    'in',
                    $order_ids
                )
            );
            $fields_deposit = array(
                'order_status' => 5 /*释放成功*/
            );
            $result_deposit = $depositModel->editBy($wdata_deposit, $fields_deposit, $this->_user);
            if ($result_deposit === false) {
                Db::rollback();
                $this->_error('保证金订单 释放保证金失败', 500);
            }
            
            // case 写余额流水
            $insert_sql_flow = "
            INSERT INTO opf_fund_flow
                (`flow_code`,`flow_fromid`,`flow_from_paytype`,`flow_toid`,`flow_to_paytype`,`flow_type`,`flow_price`,`flow_order_type`,`flow_order_id`,`flow_available_price`,`flow_remarks`,`flow_intime`)
            VALUES ";
            $insert_sql_flow_sub = "";
            $order_list_len = count($order_list);
            $i = 1; // $key 有可能会变化
            foreach ($order_list as $key => $val) {
                $orderCode = genOrdeCode('FUNDFLOW', $val['user_id']);
                $wallet_available_price = $wallet_list[$val['user_id']];
                $flow_remarks = '保证金释放到余额' . fd_demoney($val['order_paytotal_price']) . '元';
                $insert_sql_flow_sub .= "
                ('{$orderCode}',{$val['user_id']},99,-1,-1,0,{$val['order_paytotal_price']},4,{$val['order_id']},{$wallet_available_price},'{$flow_remarks}',{$_SERVER['REQUEST_TIME']})";
                if ($order_list_len != $i) {
                    $insert_sql_flow_sub .= ",";
                }
                $i ++;
            }
            $insert_sql_flow .= $insert_sql_flow_sub;
            $result_flow = Db::query($insert_sql_flow);
            if ($result_flow === false) {
                Db::rollback();
                $this->_error('余额流水记录失败', 500);
            }
        }
        
        // case 结束业务
        Db::commit();
        return array(
            'data' => array(
                'result' => true
            )
        );
    }

    /**
     * @function 退回保证金提交数据检查
     * @author ljx
     */
    private function checkRetreatPostData()
    {
        $order_stuff_types = array(
            0 /*竞价保证金*/
        );
        if (! isset($this->tradeData['order_stuff_type']) || ! in_array($this->tradeData['order_stuff_type'], $order_stuff_types)) {
            $this->_error('业务类型 order_stuff_type 参数错误', 400);
        }
        
        if (! isset($this->tradeData['order_stuff_id']) || empty($this->tradeData['order_stuff_id'])) {
            $this->_error('业务id order_stuff_id 参数错误', 400);
        }
        
        if (! isset($this->tradeData['user_id'])) {
            $this->_error('会员id user_id 参数错误', 400);
        }
        
        if (! isset($this->tradeData['time'])) {
            $this->_error('时间 time 参数错误', 400);
        }
        
        if (! isset($this->tradeData['token']) || empty($this->tradeData['token'])) {
            $this->_error('签名 token 参数错误', 400);
        }
        
        $sign_key = config('SIGN_KEY');
        $token_inner = md5(md5($this->tradeData['order_stuff_id']) . $this->tradeData['time'] . $sign_key);
        if ($this->tradeData['token'] != $token_inner) {
            $this->_error('签名验证出错', 400);
        }
    }
    
    /**
     * @function 用户是否已下单
     * @author ljx
     * @param integer order_stuff_type 业务类型 0竞价保证金
     * @param integer order_stuff_id order_stuff_type = 0对应拍卖id
     */
    public function isAddOrder($order_stuff_type_param = 0, $order_stuff_id_param = 0){
    	$this->_checkLogin();
        $this->_user = $this->getCallerInfo();
        if(empty($this->_user)){
            $this->_error('该会员不存在', 400);
        }
        
        $order_stuff_type_req = valueRequest('order_stuff_type', 0);
        $order_stuff_id_req = valueRequest('order_stuff_id', 0);
        
        $order_stuff_type = !empty($order_stuff_type_param) ? $order_stuff_type_param : $order_stuff_type_req;
        $order_stuff_id = !empty($order_stuff_id_param) ? $order_stuff_id_param : $order_stuff_id_req;

        if(empty($order_stuff_id)){
            $this->_error('order_stuff_id 业务id不能为空~', 400);
        }

        $model = new \app\finance\model\DepositOrder();
        $wdata = array(
            'order_stuff_type' => $order_stuff_type,
            'order_stuff_id' => $order_stuff_id,
            'user_id' => $this->_user['user']['user_id']
        );
        $detail = $model->getRow($wdata);
        if(empty($detail)){
            return array(
                'data' => false
            );
        }   

        if($detail['order_pay_type']>0 && $detail['order_status'] <= 3 && $detail['order_status'] != 2){
            require_once APP_PATH . "/finance/library/Wechat.php";    
            $wechat = new \Wechat();
            switch($detail['order_pay_type']){
                case 1:    
                    $result = $wechat->query($detail['order_code']);
                    if(isset($result['trade_state']) && $result['trade_state'] == 'SUCCESS'){
                        $where['order_status'] = 2;
                        $where['order_id'] = $detail['order_id'];
                        $model->edit($where);
                        $detail['order_status'] = 2;            
                    }
                    break;
                case 2:    
                    //$result = $payQuery->alipay();
                    break;
                case 4:    
                    //$result = $payQuery->huichao();
                    break;              
            }   
        }

        return array(   
            'data' => true,
            'order_info' => array(
                'is_pay' => $detail['order_status'] == 2 ? true : false,
                'order_code' => $detail['order_code'],
                'stuff_type' => 4, // 保证金订单
                'order_id' => $detail['order_id']
            )
        );
        
    }
}






















