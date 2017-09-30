<?php
namespace app\finance\controller;

use think\Request;
use think\Db;
use app\common\controller\NoAuth;

/**
 * @class 支付模块
 * @author ljx
 */
class Pay extends NoAuth
{
    // 存放前端提交的数据
    private $tradeData;
    // 存放订单数据
    private $orderInfo;
    // 是否IOS
    private $isIos;

    private $order_pay_type = array(
        0, // 余额支付
        1, // 微信支付
        2, // 支付宝支付
        3, // 银行卡支付
        4, // 汇潮支付
        99  /*其他*/
    );

    public function __construct() {
        parent::__construct();
        $this->_checkLogin();
        $this->_user = $this->getCallerInfo();
    }
    
    /**
     * @function 多商户同时支付
     * @author ljx
     * @param string order_sn
     * @param string order_union isunion
     */
    public function payAll(){
        // case 获取提交的数据
        $this->tradeData = Request::instance()->post();
        if(isset($this->tradeData['isios'])){
            $this->isIos = $this->tradeData['isios'];
            unset($this->tradeData['isios']);
        }
        $this->_user['user']['wallet'] = $this->getUserWallet();
        $wallet_available_price = $this->_user['user']['wallet']['wallet_available_price'];

        // case post data 检查
        $this->checkPayAllPostData();
        
        // case 获取联合订单详情
        $cbOrderModel = new \app\finance\model\Couchbase();
        $wdata = array(
            'order_sn' => $this->tradeData['order_sn']
        );
        $this->orderInfo = $cbOrderModel->getListBy($wdata, $this->_user);
        
        // case 支付前检查合法性
        $this->checkPayAll();
        
        // 开启事物
        Db::startTrans();
        
        $order_pay_type = $this->tradeData['order_pay_type'];
        // case 走支付流程
        switch ($order_pay_type) {
            // 余额支付
            case 0:
                $result_pay = $this->doBalancePay();
                break;
                // 微信支付
            case 1:
                $result_pay = $this->doWeChatPay();
                break;
                // 支付宝支付
            case 2:
                $result_pay = $this->doAliPay();
                break;
                // 银行卡支付
            case 3:
                $result_pay = $this->doBankPay();
                break;
                // 汇潮支付
            case 4:
                $result_pay = $this->doHuiChaoPay();
                break;
            default:
                $this->_error('暂不支持该支付方式~', 400);
        }

        // case 支付结果更新到订单
        // 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它
        $order_pay_type = $this->tradeData['order_pay_type'];
        // 0待付款 1付款中 2已付款/处理中/待发货 3付款失败
        if ($order_pay_type == 0) {
            // 如果是余额支付 则订单支付完成
            $order_status = 2;
            $order_paytime = $_SERVER['REQUEST_TIME'];
        } elseif ($order_pay_type == 1) {
            // 第三方支付 微信支付
            $order_status = 0;
            $order_paytime = 0;
        } else {
            // 第三方支付 其他暂未测试
            $order_status = 0;
            $order_paytime = 0;
        }
        $order_third_ordercode = $result_pay['data']['order_third_ordercode'];
        $order_third_payinfo = $result_pay['data']['order_third_payinfo'];
        $orderObj = new \app\finance\model\FreetradingOrder();
        foreach($this->orderInfo as $key => $val){
            // case service order
            $wdata_service_order = array(
                'order_id' => $val['order_id']
            );
            $requestData_service_order = array(
                'order_pay_type' => $order_pay_type,
                'order_status' => $order_status,
                'order_paytime' => $order_paytime,
                'order_third_ordercode' => $order_third_ordercode,
                'order_third_payinfo' => serialize($order_third_payinfo)
            );
            $result_service = $orderObj->editBy($wdata_service_order, $requestData_service_order, $this->_user);
            if($result_service === false){
                Db::rollback();
                $this->_error('更新自由买卖订单失败', 500);
            }

            // case couchbase
            $wdata_cb = array(
                'order_code' => $val['order_code']
            );
            $result_cb = $cbOrderModel->updateServiceOrderFields($wdata_cb, $requestData_service_order);
            // TODO 检查返回值
        }
        
        // case 记录支付流水 积分流水
        if ($order_pay_type == 0) {
            // 余额支付成功时 此时订单已经结束
            $this->recordFlow($wallet_available_price);
        }

        // case 结束业务
        Db::commit();
        $time = time();
        $signKey = config('SIGN_KEY');
        $orderCode = $val['order_code'];   
        $key = md5(md5($orderCode).$time.$signKey);
        $result = curl_get_content(config("item_api_url")."index/inventory?oid={$orderCode}&time={$time}&key={$key}");
        return $result_pay;
    }
    
    /**
     * @function 支付前检查合法性
     * @author ljx
     */
    private function checkPayAll(){
        $order_paytotal_price = 0;
        foreach($this->orderInfo as $key => $val){
            // case 所有者 与 可支付控制
            if ($val['user_id'] != $this->_user['user']['user_id']) {
                $this->_error('暂不支持支付非所有者订单', 400);
            }
            
            // case 订单相关
            if ($val['order_status'] >= 2) {
                if ($val['order_status'] == 2) {
                    $this->_error('该订单已经完成了~', 400);
                }
            }
            
            $order_paytotal_price += $val['order_paytotal_price'];
        }
        
        // 应付金额检查
        if ($this->tradeData['order_paytotal_price'] != $order_paytotal_price) {
            $this->_error('支付金额与应付金额不相等~', 400);
        }
    }
    
    /**
     * @function payall post data 检查
     * @author ljx
     */
    private function checkPayAllPostData(){
        if(!isset($this->tradeData['order_sn']) || empty($this->tradeData['order_sn'])){
            $this->_error('多商家同时支付时,联合订单号不能为空~', 400);
        }
        if(!isset($this->tradeData['order_union']) || empty($this->tradeData['order_union']) || $this->tradeData['order_union'] != 'isunion'){
            $this->_error('多商家同时支付时,联合标识参数出错', 400);
        }
        if(!isset($this->tradeData['order_paytotal_price']) || !fd_isposnum($this->tradeData['order_paytotal_price'])){
            $this->_error('支付金额参数不正确~', 400);
        }
    }

    /**
     * @function 统一支付
     * @author ljx
     * @see 对订单进行支付
     *
     * @see 拍卖业务特殊对待 涉及到保证金 处理方式为：
     * @see 客户端调用订单详情，此时的支付金额为 order_paytotal_price = order_paytotal_price - order_deposit_price
     * @see 后端对支付金额进行校验
     * @todo 考虑后端算好支付金额
     */
    public function pay()
    {
        // case 获取提交的数据
        $this->tradeData = Request::instance()->post();
        
        if(isset($this->tradeData['isios'])){
            $this->isIos = $this->tradeData['isios'];
            unset($this->tradeData['isios']);
        }
        $this->_user['user']['wallet'] = $this->getUserWallet();
        $wallet_available_price = $this->_user['user']['wallet']['wallet_available_price'];
        
        // case post data 检查
        $this->checkPayPostData();
        
        // case 获取订单信息
        $orderObj = new \app\finance\controller\OrderHome();
        $this->orderInfo = $orderObj->detail($this->tradeData['stuff_type'], $this->tradeData['order_id']);
        
        // case 支付前检查合法性
        $this->checkPay();

        // 开启事物
        Db::startTrans();
        
        $order_pay_type = $this->tradeData['order_pay_type'];
        // case 走支付流程
        switch ($order_pay_type) {
            // 余额支付
            case 0:
                $result = $this->doBalancePay();
                break;
            // 微信支付
            case 1:
                $result = $this->doWeChatPay();
                break;
            // 支付宝支付
            case 2:
                $result = $this->doAliPay();
                break;
            // 银行卡支付
            case 3:
                $result = $this->doBankPay();
                break;
            // 汇潮支付
            case 4:
                $result = $this->doHuiChaoPay();
                break;
            default:
                $this->_error('暂不支持该支付方式~', 400);
        }
        // case 支付结果更新到订单
        $result_update_order = $orderObj->update($result, $this->tradeData);
        if($result_update_order !== true){
            // TODO 里面也有 外面也有 惨了
            Db::rollback();
        }
        
        // case 记录支付流水 积分流水
        if ($order_pay_type == 0) {
            // 拍卖业务订单涉及到保证金 特殊处理
            $this->recordFlow($wallet_available_price, 0);
            if($this->tradeData['stuff_type'] == 1){
                $walletModel = new \app\finance\model\Wallet();
                $wdata_wallet = array(
                    'wallet_id' => $this->_user['user']['wallet']['wallet_id']
                );
                $requestData_wallet = array(
                    'amount' => $this->orderInfo['order_deposit_price']
                );
                $result_wallet = $walletModel->minusDeposit($wdata_wallet, $requestData_wallet, $this->_user);
                if($result_wallet === false){
                    Db::rollback();
                    $this->_error('扣除钱包冻结保证金失败~', 500);
                }
            }

            // case 商品业务订单需要更新到couchbase
            $stuff_types = array(
                1,//auction
                2,//crowd
                3/*freetrading*/
            );
            if(in_array($this->tradeData['stuff_type'], $stuff_types)){
                $wdata_couchbase = array(
                    'order_code' => $this->orderInfo['order_code']
                );
                $fields_couchbase = $result['data'];
                $fields_couchbase['order_status'] = 2; // 已支付
                $fields_couchbase['order_pay_type'] = $this->tradeData['order_pay_type'];
                $fields_couchbase['order_paytime'] = $_SERVER['REQUEST_TIME'];
                $cbModel = new \app\finance\model\Couchbase();
                $result_couchbase = $cbModel->updateServiceOrderFields($wdata_couchbase, $fields_couchbase, $this->_user);
                if($result_couchbase === false){
                    Db::rollback();
                    $this->_error('更新融合业务订单失败~', 500);
                }
                
            }
        }

        // case 结束业务
        Db::commit();
        $inventoryStuffTypes = [2,3];
        if(in_array($this->tradeData['stuff_type'], $inventoryStuffTypes)){
            $time = time();
            $signKey = config('SIGN_KEY');
            $orderCode = $this->orderInfo['order_code'];   
            $key = md5(md5($orderCode).$time.$signKey);
            $res = curl_get_content(config("crowd_api_url")."index/inventory?oid={$orderCode}&time={$time}&key={$key}");
        }
        return $result;
        
        // 返回的数据格式如下
        // $result = array(
        // // 支付结果
        // 'pay_status' => true,
        // // 附加数据
        // 'data' => array(
        // 'order_third_ordercode' => '',
        // 'order_third_payinfo' => ''
        // )
        // );
    }

    /**
     * @function post data 检查
     * @author ljx
     */
    private function checkPayPostData()
    {
        if (true !== ($validate = $this->validate($this->tradeData, 'Pay'))) {
            $this->_error($validate, 400);
        }
    }

    /**
     * @function 流水记录
     * @author ljx
     */
    private function recordFlow($wallet_available_price=0, $paytype=0)
    {
        $flow_remarks = '';
        switch ($this->tradeData['stuff_type']) {
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
                $flow_remarks = '保证金业务';
                break;
            case 5:
                $flow_remarks = '余额充值业务';
                break;
        }
        
        // case fund flow
        $flow_type = $this->tradeData['stuff_type'] == 4 ? 2 : 0; // $flow_type 0:减少 1:增加 2:冻结
        $requestData = array(
            'flow_code' => genOrdeCode('FUNDFLOW', $this->_user['user']['user_id']),
            'flow_fromid' => $this->_user['user']['user_id'],
            'flow_account' => $this->_user['user']['account'],
            'flow_from_paytype' => $this->tradeData['order_pay_type'],
            'flow_toid' => - 1,
            'flow_to_paytype' => $paytype,
            'flow_type' => $this->tradeData['order_pay_type'] == 0 ? 0 : 1, // 0余额变动记录 1交易记录
            'flow_order_type' => $this->tradeData['stuff_type'],
            'flow_order_id' => isset($this->orderInfo['order_id']) ? $this->orderInfo['order_id'] : 0, // 多订单与单订单兼容处理
            'flow_attach' => isset($this->orderInfo['order_id']) ? '' : $this->orderInfo[0]['order_sn'], // 多订单与单订单兼容处理 需要用order_sn来查看流水对应的相关订单
            'flow_available_price' => $wallet_available_price,
            'flow_price' => $this->tradeData['order_paytotal_price'],
            'flow_remarks' => $flow_remarks . '支付金额' . fd_demoney($this->tradeData['order_paytotal_price']) . '元'
        );

        $fundModel = new \app\finance\model\FundFlow();
        $result_fund = $fundModel->add($requestData);
        // 不做中断业务操作
        
        // case integral flow TODO
        
        // case 结束业务
        return true;
    }

    /**
     * @function 余额支付
     * @author ljx
     */
    private function doBalancePay()
    {
        // case 检查钱包
        $availableMoney = $this->_user['user']['wallet']['wallet_available_price'];
        $order_paytotal_price = $this->tradeData['order_paytotal_price'];
        $diffMoney = $availableMoney - $order_paytotal_price;
        if ($diffMoney < 0) {
            Db::rollback();
            $this->_error('可用余额不足~', 400);
        }
        
        // 扣除余额
        $time = time();
        $signKey = config('SIGN_KEY');
        //$payReturn = new Payreturn();
        $walletModel = new \app\finance\model\Wallet();
        
        if ($this->tradeData['stuff_type'] == 4) {
            // 保证金要冻结余额
            $requestData = array(
                'wallet_id' => $this->_user['user']['wallet']['wallet_id'],
                'amount' => $this->tradeData['order_paytotal_price']
            );
            $result_wallet = $walletModel->freeze($requestData);
        } else {
            $requestData = array(
                'wallet_id' => $this->_user['user']['wallet']['wallet_id'],
                'amount' => $this->tradeData['order_paytotal_price']
            );
            $result_wallet = $walletModel->reduce($requestData);
        }
        if ($result_wallet === false) {
            Db::rollback();
            $this->_error('余额支付失败~', 500);
        }
        
        return array(
            // 支付结果
            'pay_status' => true,
            // 附加数据
            'data' => array(
                'order_third_ordercode' => '',
                'order_third_payinfo' => ''
            )
        );
    }

    /**
     * @function 支付验证
     * @author ljx
     */
    private function checkPay()
    {
        // case 所有者 与 可支付控制
        if ($this->orderInfo['user_id'] != $this->_user['user']['user_id']) {
            $this->_error('暂不支持支付非所有者订单', 400);
        }
        
        // case 订单相关
        if ($this->orderInfo['order_status'] >= 2) {
            if ($this->orderInfo['order_status'] == 2) {
                $this->_error('该订单已经完成了~', 400);
            }
        }
        
        // case 应付金额检查 拍卖订单特殊处理
        if($this->tradeData['stuff_type'] == 1){
            // 1 拍卖订单
            if ($this->tradeData['order_paytotal_price']  != $this->orderInfo['order_paytotal_price'] - $this->orderInfo['order_deposit_price']) {
                $this->_error('支付金额与应付金额不相等~', 400);
            }
        }else{
            // 其他类型的订单支付金额检验
            if ($this->tradeData['order_paytotal_price'] != $this->orderInfo['order_paytotal_price']) {
                $this->_error('支付金额与应付金额不相等~', 400);
            }
        }
        
        // case 余额充值时做限制
        if ($this->tradeData['stuff_type'] == 5 && $this->tradeData['order_pay_type'] == 0) {
            $this->_error('余额充值不能选择余额支付', 400);
        }
    }

    /**
     * @function 处理微信支付
     * @author ljx
     * @see 微信支付的统一下单分两大分支 刷卡下单 和 其它
     */
    private function doWeChatPay()
    {
        require_once APP_PATH . "/finance/library/Wechat.php";
        $doObj = new \Wechat();
        $wxConfig = config('wxpay');
        $this->tradeData['notify_url'] = $wxConfig['notify_url'];
        
        // case 交易数据对接
        $tradeData_WeChat = $this->abutWeChat();

        // case 微信统一下单
        $result = $doObj->createOrder($tradeData_WeChat);
        //var_dump($result);
        if (isset($result['result_code']) && $result['result_code'] != 'SUCCESS' && isset($result['return_code']) && $result['return_code'] != 'SUCCESS') {
            $returnData = array(
                // 支付结果
                'pay_status' => false,
                // 附加数据
                'data' => array(
                    'order_third_ordercode' => '',
                    'order_third_payinfo' => $result
                )
            );
        } else {
            $result['mweb_url'] .= '&redirect_url=http://www.fjsxpmh.com/index/openUrl?open=com.fupaihang%3a%2f%2f';
            $returnData = array(
                // 支付结果
                'pay_status' => true,
                // 附加数据
                'data' => array(
                    'order_third_ordercode' => $result['prepay_id'],
                    'order_third_payinfo' => $result
                )
            );
        }
        
        return $returnData;
    }

    /**
     * @function 微信交易数据对接
     * @author ljx
     * @todo 这边应当做到与业务无关
     */
    private function abutWeChat()
    {
        if (! isset($this->tradeData['trade_type']) || empty($this->tradeData['trade_type'])) {
            $this->_error('微信支付 trade_type 支付方式参数有误', 400);
        }

        if(isset($this->tradeData['order_sn'])){
            $out_trade_no = $this->tradeData['order_sn'];
            $body = "自由买卖订单";
            $order_paytotal_price = $this->tradeData['order_paytotal_price'];
            $attach = "{$out_trade_no}_isunion";
        }else{
            $out_trade_no = $this->orderInfo['order_code'];
            $body = $this->orderInfo['order_name'];
            $order_paytotal_price = $this->orderInfo['order_paytotal_price'];
            $attach = "{$this->tradeData['order_id']}_{$this->tradeData['stuff_type']}";
        }
        //var_dump($order_paytotal_price);
        $tradeData_WeChat = array();
        $tradeData_WeChat['out_trade_no'] = $out_trade_no;
        $tradeData_WeChat['body'] = $body;
        $tradeData_WeChat['total_fee'] = $order_paytotal_price;
        $tradeData_WeChat['trade_type'] = $this->tradeData['trade_type'];
        $tradeData_WeChat['notify_url'] = $this->tradeData['notify_url'];
        // 这边有问题 TODO
        if ($this->tradeData['trade_type'] == 'NATIVE') {
            // 原生扫码支付的时候 要传
            // trade_type=NATIVE，此参数必传。此id为二维码中包含的商品ID，商户自行定义。
            $tradeData_WeChat['product_id'] = $this->orderInfo['order_code'];
        }
        if ($this->tradeData['trade_type'] == 'MWEB') {
            if($this->isIos==1){
                $scene_info = '{"h5_info": {"type":"IOS","app_name": "富拍行","bundle_id": "com.fupaihang.FuPaiHang"}}';
            }else{
                $scene_info = '{"h5_info": {"type":"Android","app_name": "富拍行","package_name": "com.fupaihang"}}';
            }            
            $tradeData_WeChat['scene_info'] = $scene_info;
        }
        
        $tradeData_WeChat['attach'] = $attach;
        
        return $tradeData_WeChat;
    }
}
