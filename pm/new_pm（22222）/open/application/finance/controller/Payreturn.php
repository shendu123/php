<?php
namespace app\finance\controller;

use think\Request;
use think\Db;

use app\finance\model\AuthionOrder;
use app\finance\model\CrowdOrder;
use app\finance\model\DepositOrder;
use app\finance\model\FreetradingOrder;
use app\finance\model\RechargeOrder;
use app\finance\model\Couchbase;
use app\finance\model\Wallet;
use app\finance\model\FundFlow;

use app\finance\controller\Pay;

/**
 * @class 第三方支付结果通知
 * @author ljx
 */
class Payreturn
{
    // 交易数据
    private $tradeData;
    // 订单信息
    private $orderInfo;

    public function __construct()
    {
        $this->wxData = json_decode(json_encode(simplexml_load_string(file_get_contents("php://input"), 'SimpleXMLElement', LIBXML_NOCDATA)), true); 
    }

    /**
     * @function 微信支付结果回调
     * @author ljx
     */
    public function wechat()
    {
        // case 回应微信
        require_once APP_PATH . "/finance/library/wechat/lib/WxPay.Api.php";
        require_once APP_PATH . "/finance/library/wechat/lib/WxPay.Notify.php";
        // case 订单状态变更
        $isUnion = strpos($this->wxData['attach'], 'isunion') ? true : false;
        $outTradeNo = $this->wxData['out_trade_no'];
        $orderStatus = $this->checkOrderStatus($outTradeNo, $isUnion);    
        if($orderStatus>=2){
            return false;
        }
        $notifyObj = new \PayNotifyCallBack();
        $result = $notifyObj->Handle(false);
        if($result){
            if($isUnion){
                $this->paidUnion(1);
            }else{
                $this->paid(1);  
            }
        }
        return true;
    }
    
    /**
     * @function 获取订单信息
     * @author ljx
     */
    private function checkOrderStatus($orderSn, $isUnion = false){
        if(strstr($orderSn, 'RCHARGE')){
            $orderModel = new RechargeOrder();
        }else{
            $orderModel = new Couchbase();  
        }

        if($isUnion){
            $wdata = array(
                'order_sn' => $orderSn
            );
        }else{
            $wdata = array(
                'order_code' => $orderSn
            );
        }

        if(strstr($orderSn, 'RCHARGE')){
            $result = $orderModel->getBy($wdata);
        }else{
            $result = $orderModel->getListBy($wdata); 
        }
    
        if($isUnion || strstr($orderSn, 'RCHARGE')){
            $this->orderInfo = $result; 
        }else{
            $this->orderInfo = $result[0];    
        }
        if(strstr($orderSn, 'RCHARGE')){
            $this->orderInfo['stuff_type'] = 5;
        }    
        if(empty($this->orderInfo)){
            return array(
                'status' => 400,
                'msg' => '订单不存在~'
            );
        }
        /*
        $fp = fopen('2.txt', 'a+b');
        fwrite($fp, var_export($this->orderInfo, true));
        fclose($fp);
        */
        if($isUnion){
            return $this->orderInfo[0]['order_status']; 
        }else{
            return $this->orderInfo['order_status'];
        }
            
    }

    /**
     * @function 更改订单状态
     * @author zsq
     */
    public function paid($payType, $orderId='', $stuffType='', $orderCode='', $amount='', $userId='')
    {
        $oid = empty($orderId) ? $this->orderInfo['order_id'] : $orderId;
        $stuffType = empty($stuffType) ? $this->orderInfo['stuff_type'] : $stuffType;
        $orderCode = empty($orderCode) ? $this->orderInfo['order_code'] : $orderCode;
        $amount = empty($amount) ? $this->orderInfo['order_paytotal_price'] : $amount;
        $userId = empty($userId) ? $this->orderInfo['user_id'] : $userId;

        $time = time();
        $signKey = config('SIGN_KEY');
        $key = md5(md5($orderCode).$time.$signKey);
        switch($stuffType){
            // 拍卖业务订单 auction
            case 1:
                $model = new AuthionOrder();
                $where['order_id'] = $oid;
                $update['order_status'] = 2;
                $update['order_pay_type'] = $payType;
                $update['order_paytime'] = time();//$_SERVER['REQUEST_TIME'];
                $model->editBy($where, $update);
                break;
            // 申购业务订单 crowd
            case 2:
                $model = new CrowdOrder();
                $where['order_id'] = $oid;
                $update['order_status'] = 2;
                $update['order_pay_type'] = $payType;
                $update['order_paytime'] = time();
                $model->editBy($where, $update);
                $result = curl_get_content(config("crowd_api_url")."index/inventory?oid={$orderCode}&time={$time}&key={$key}");
                break;
            // 自由买卖业务订单 freetrading
            case 3:
                $model = new FreetradingOrder();
                $where['order_id'] = $oid;
                $update['order_status'] = 2;
                $update['order_pay_type'] = $payType;
                $update['order_paytime'] = time();
                $model->editBy($where, $update);
                $result = curl_get_content(config("item_api_url")."index/inventory?oid={$orderCode}&time={$time}&key={$key}");
                break;
            // 保证金订单 deposit
            case 4:
                $model = new DepositOrder();
                $where['order_id'] = $oid;
                $update['order_status'] = 2;
                $update['order_pay_type'] = $payType;
                $update['order_paytime'] = time();
                $model->editBy($where, $update);
                $where['user_id'] = $userId;
                $where['amount'] = $amount;  
                model('Wallet')->freezePrice($where);
                $this->addFlow($payType, $userId, $stuffType, $oid, $amount, $orderCode);
                breaks;
            // 余额充值订单 wallet/balance
            case 5:
                $model = new RechargeOrder();
                $where['order_id'] = $oid;
                $update['order_status'] = 2;
                $update['order_pay_type'] = $payType;
                $update['order_paytime'] = time();
                $model->editBy($where, $update);

                $where['user_id'] = $userId;
                $where['amount'] = $amount;  
                model('Wallet')->raise($where);
                $this->addFlow($payType, $userId, $stuffType, $oid, $amount, $orderCode);
                break;
            default:
                $this->_error("订单类型 stuff_type++{$this->tradeData['stuff_type']}++ 参数不正确", 400);
                break;
        }
        $cbModel = new Couchbase(); 
        $fields['order_status'] = 2;
        $fields['order_pay_type'] = $payType;
        $fields['order_paytime'] = time();
        $where['order_code'] = $orderCode;
        $cbModel->updateServiceOrderFields($where, $fields);
        return true;
    }

    /**
     * @function 记录流水
     * @author zsq
     */   
    public function addFlow($payType, $userId, $stuffType, $oid, $amount, $orderCode){
        $flow_remarks = '';
        switch ($stuffType) {
            case 1:
                $flow_remarks = '拍卖业务';
                break;
            case 2:
                $flow_remarks = '申购业务';
                break;
            case 3:
                $flow_remarks = '自由买卖业务';
                break;
            case 4:
                $flow_remarks = '缴纳保证金';
                break;
            case 5:
                $flow_remarks = '余额充值业务';
                break;
        }

        $userInfo = Db::table('op_basic.opb_member')->where('uid', $userId)->find();        
        // case fund flow
        $flow_type = 1;
        $requestData = array(
            'flow_code' => genOrdeCode('FUNDFLOW', $userId),
            'flow_fromid' => $userId,
            'flow_account' => $userInfo['account'],
            'flow_from_paytype' => $payType,
            'flow_toid' => - 1,
            'flow_to_paytype' => $payType,
            'flow_type' => 1, // 0余额变动记录 1交易记录
            'flow_order_type' => $stuffType,
            'flow_order_id' => isset($oid) ? $oid : 0, // 多订单与单订单兼容处理
            'flow_attach' => isset($oid) ? '' : $orderCode, // 多订单与单订单兼容处理 需要用order_sn来查看流水对应的相关订单
            'flow_available_price' => $amount,
            'flow_price' => $amount,
            'flow_remarks' => $flow_remarks . '支付金额' . fd_demoney($amount) . '元'
        );
        $result = model('FundFlow')->add($requestData);
        return $result;
    }        

    /**
     * @function 更改联合订单状态
     * @author zsq
     */
    public function paidUnion($payType, $freeOrderInfo=[])
    {
        $orderInfo = empty($freeOrderInfo) ? $this->orderInfo : $freeOrderInfo;
        
        foreach($orderInfo as $order){
            $model = new FreetradingOrder();
            $where['order_id'] = $order['order_id'];
            $update['order_status'] = 2;
            $update['order_pay_type'] = $payType;
            $update['order_paytime'] = time();
            $model->editBy($where, $update);
            $cbModel = new Couchbase(); 
            $fields['order_status'] = 2;
            $fields['order_pay_type'] = $payType;
            $fields['order_paytime'] = time();    
            $where['order_code'] = $order['order_code'];
            $cbModel->updateServiceOrderFields($where, $fields);
            
            $orderCode = $order['order_code'];
            $time = time();
            $signKey = config('SIGN_KEY');
            $key = md5(md5($orderCode).$time.$signKey);
            $result = curl_get_content(config("item_api_url")."index/inventory?oid={$orderCode}&time={$time}&key={$key}");
        }
        return true;
    }

    /**
     * @function 支付宝支付结果回调
     * @author ljx
     */
    public function zhifubao()
    {
    }

    /**
     * @function 汇潮支付结果回调
     * @author ljx
     */
    public function huichao()
    {
    }
}