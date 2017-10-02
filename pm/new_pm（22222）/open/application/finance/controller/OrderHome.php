<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use think\Request;
use app\finance\model\DepositOrder;
use think\Db;
use app\finance\controller\Payreturn;
use app\finance\model\Wallet;
use app\finance\model\Couchbase;
use app\finance\model\Order;

// TODO couchbase 整型 与 mysql取出时的字符串类型
class OrderHome extends NoAuth
{
    
    // 存放交易数据
    private $tradeData = array();

    private $stuff_types = array(
        '1', // 拍卖
        '2', // 申购
        '3', // 自由买卖
        '4', // 保证金
        '5'  /*余额充值*/
    );

    private $stuff_types_goods = array(
        '1', // 拍卖
        '2', // 申购
        '3'/*自由买卖*/
    );

    public function __construct()
    {
        parent::__construct();
        $user_id = valueRequest('user_id', 0);
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
     * @function 用户中心首页
     * @author zsq
     */
    public function userHome()
    {
        $result = model('Wallet')
                            ->where('user_id', $this->_uid)
                            ->field('wallet_available_price, wallet_freeze_price,wallet_integral')    
                            ->find();

        $order1 = model('Couchbase')->getUserListBy(['order_status'=>0],$this->_uid);
        $order2 = model('Couchbase')->getUserListBy(['order_status'=>2],$this->_uid);
        $order3 = model('Couchbase')->getUserListBy(['order_status'=>10],$this->_uid);
        $order =  model('Couchbase')->getUserListBy([], $this->_uid);

        $result['unpay'] = count($order1);
        $result['unsend'] = count($order2);        
        $result['unrecieve'] = count($order3); 
        $result['all'] = count($order);      

        return $result;
    }

    /**
     * @function 全部订单
     * @author ljx
     */
    public function allList()
    {
        $page = valueRequest('page', 1);
        $pageSize = valueRequest('pageSize', 10);
        $pageSize = $pageSize > 300 ? 10 : $pageSize;
        
        // 订单类型 stuff_type 1拍卖 2申购 3自由
        $stuff_type = valueRequest('stuff_type', 0);
        
        // 订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废
        $order_status = valueRequest('order_status', 'egt|0', 'string');
        $tempArr = explode('|', $order_status);
        $operator = opr_check_convert($tempArr[0]);
        $order_status = $operator . ' ' . $tempArr[1];
            
        // 拍卖审核状态
        if (! empty($wdata['check_status'])) {
            $tempArr = explode('|', $wdata['check_status']);
            $whereCond['a.auction_check_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        // 支付时间时间搜索
        $start_order_paytime = valueRequest('start_order_paytime', '', 'string');
        $end_order_paytime = valueRequest('end_order_paytime', '', 'string');
        ! empty($start_order_paytime) ? $start_order_paytime = date('Y-m-d', strtotime($start_order_paytime)) : '';
        ! empty($end_order_paytime) ? $end_order_paytime = date('Y-m-d', strtotime($end_order_paytime)) : '';
        if ($start_order_paytime > $end_order_paytime) {
            $this->_error('支付时间搜索 开始时间不能大于结束时间~', 400);
        }
        
        // 下单时间搜索
        $start_order_intime = valueRequest('start_order_intime', '', 'string');
        $end_order_intime = valueRequest('end_order_intime', '', 'string');
        ! empty($start_order_intime) ? $start_order_intime = date('Y-m-d', strtotime($start_order_intime)) : '';
        ! empty($end_order_intime) ? $end_order_intime = date('Y-m-d', strtotime($end_order_intime)) : '';
        if ($start_order_intime > $end_order_intime) {
            $this->_error('下单时间搜索 开始时间不能大于结束时间~', 400);
        }
        
        // 订单号模糊搜索 keyword for order_code
        $keyword = valueRequest('keyword', '', 'string');
        
        $wdata = array(
            'page' => $page,
            'pageSize' => $pageSize,
            'stuff_type' => $stuff_type,
            'start_order_paytime' => $start_order_paytime,
            'end_order_paytime' => $end_order_paytime,
            'start_order_intime' => $start_order_intime,
            'end_order_intime' => $end_order_intime,
            'keyword' => $keyword,
            'order_status' => $order_status,
            'order_isdelete' => '= 0',
            'user_id' => $this->_user['user']['user_id']
        );
        
        $cbOrderModel = new \app\finance\model\Couchbase();
        $data = $cbOrderModel->getList($wdata);
        
        return array( 
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $data['total'],
            'totalPage' => ceil($data['total'] / $wdata['pageSize']),
            'data' => $data['data']
        );
    }

    /**
     * @function 订单详情
     * @author ljx
     */
    public function detail($stuff_type_param = 0, $order_id_param = 0)
    {
        $stuff_type_request = valueRequest('stuff_type', 0);
        $order_id_request = valueRequest('order_id', 0);
        
        $stuff_type = $stuff_type_param ? $stuff_type_param : $stuff_type_request;
        $order_id = $order_id_param ? $order_id_param : $order_id_request;
        switch ($stuff_type) {
            // 拍卖
            case 1:
                $model = new \app\finance\model\AuctionOrder();
                $wdata = array(
                    'order_id' => $order_id
                );
                $row = $model->getRow($wdata);
                break;
            // 申购
            case 2:
                $model = new \app\finance\model\CrowdOrder();
                $wdata = array(
                    'order_id' => $order_id
                );
                $row = $model->getRow($wdata);
                break;
            // 自由买卖
            case 3:
                $model = new \app\finance\model\FreetradingOrder();
                $wdata = array(
                    'order_id' => $order_id
                );
                $row = $model->getRow($wdata);
                break;    
            // 保证金
            case 4:
                $model = new \app\finance\model\DepositOrder();
                $wdata = array(
                    'order_id' => $order_id
                );
                $row = $model->getRow($wdata);
                break;
            // 余额充值
            case 5:
                $model = new \app\finance\model\RechargeOrder();
                $wdata = array(
                    'order_id' => $order_id
                );
                $row = $model->getRow($wdata);
                break;
            default:
                $this->_error('stuff_type 业务类型参数不正确~', 400);
        }
        
        // TODO case opf_order
        $orderModel = new \app\finance\model\Order();
        $wdata_order = array(
            'order_id' => $order_id,
            'stuff_type' => $stuff_type
        );
        $orderInfo = $orderModel->getRow($wdata_order);
        
        // case 结束业务
        if (empty($row)) {
            $this->_error('订单不存在~', 400);
        } else {
            // TODO
            $row['order_sn'] = $orderInfo['order_sn'];
            return $row;
        }
    }

    /**
     * @function 订单是否已支付查询
     * @author ljx
     */
    public function isPaid($stuff_type_param = 0, $order_id_param = 0)
    {
        $stuff_type_request = valueRequest('stuff_type', 0);
        $order_id_request = valueRequest('order_id', 0);
        
        $stuff_type = $stuff_type_param ? $stuff_type_param : $stuff_type_request;
        $order_id = $order_id_param ? $order_id_param : $order_id_request;
        $order_sn = input('order_sn');

        if(empty($order_sn)){
            $row = $this->detail($stuff_type, $order_id);
        }else{
            $where['order_sn'] = $order_sn;
            $data = model('Couchbase')->getListBy($where);
            $row = $this->detail($data[0]['stuff_type'],  $data[0]['order_id']);   
        }

        // 订单流程状态:0待付款 1付款中 2已付款
        if ($row['order_status'] != 2) {
            require_once APP_PATH . "/finance/library/Wechat.php";  
            $wechat = new \Wechat();
            $payReturn = new Payreturn();

            $isPaid = false;
            switch($row['order_pay_type']){
                //微信微信支付
                case 1:
                    $result = $wechat->query($row['order_code']);
                    if(isset($result['trade_state']) && $result['trade_state'] == 'SUCCESS'){
                        $payReturn->paid(1, $row['order_id'], $stuff_type, $row['order_code']);           
                        $isPaid = true;
                    }
                    if($stuff_type == 3){
                        if($order_sn){
                            $result = $wechat->query($row['order_sn']);
                        }else{
                            $result = $wechat->query($row['order_code']);  
                        }
                        if(isset($result['trade_state']) && $result['trade_state'] == 'SUCCESS'){
                            if($order_sn){    
                                $payReturn->paidUnion(1, $data);
                            }else{
                                $payReturn->paid(1, $row['order_id'], $stuff_type, $row['order_code']);  
                            }
                            $isPaid = true; 
                        }
                    }    
                    break;
                case 2:
                    break;
                case 4:
                    break; 
            }
            return array(
                'data' => array(
                    'is_paid' => $isPaid
                )
            );
        } else {
            return array(
                'data' => array(
                    'is_paid' => true
                )
            );
        }
    }

    /**
     * @function 删除订单
     * @author ljx
     */
    public function delete($stuff_type_param = 0, $order_id_param = 0)
    {
        $stuff_type_request = valueRequest('stuff_type', 0);
        $order_id_request = valueRequest('order_id', 0);
        
        $stuff_type = $stuff_type_param ? $stuff_type_param : $stuff_type_request;
        $order_id = $order_id_param ? $order_id_param : $order_id_request;
        
        Db::startTrans();
        
        // case 操作mysql
        $orderDbModel = $this->getOrderModel($stuff_type);
        $requestData = array(
            'order_isdelete' => 1,
            'order_delid' => $this->_user['user']['user_id'],
            'order_deltime' => $_SERVER['REQUEST_TIME']
        );
        $wdata = array(
            'order_id' => $order_id
        );
        $result = $orderDbModel->editBy($wdata, $requestData, $this->_user);
        if ($result === false) {
            Db::rollback();
            $this->_error('操作失败~', 500);
        }
        
        // case 操作couchbase
        if (in_array($stuff_type, $this->stuff_types_goods)) {
            $orderCbModel = new \app\finance\model\Couchbase();
            $wdata_cb = array(
                'stuff_type' => $stuff_type,
                'order_id' => $order_id
            );
            $result_cb = $orderCbModel->deleteServiceOrder($wdata_cb, $this->_user);
        }
        
        // case 结束业务
        Db::commit();
        return array(
            'msg' => '操作成功',
            'data' => true
        );
    }

    /**
     * @function 获取订单模型
     * @author ljx
     */
    private function getOrderModel($stuff_type)
    {
        switch ($stuff_type) {
            // 拍卖
            case 1:
                $model = new \app\finance\model\AuctionOrder();
                break;
            // 申购
            case 2:
                $model = new \app\finance\model\CrowdOrder();
                break;
            // 自由买卖
            case 3:
                $model = new \app\finance\model\FreetradingOrder();
                break;
            // 保证金
            case 4:
                $model = new \app\finance\model\DepositOrder();
                break;
            // 余额充值
            case 5:
                $model = new \app\finance\model\RechargeOrder();
                break;
            default:
                $this->_error('stuff_type 业务类型参数不正确~', 400);
        }
        
        return $model;
    }

    /**
     * @function 取消订单
     * @author ljx
     */
    public function cancel($stuff_type_param = 0, $order_id_param = 0)
    {
        $stuff_type_request = valueRequest('stuff_type', 0);
        $order_id_request = valueRequest('order_id', 0);
        
        $stuff_type = $stuff_type_param ? $stuff_type_param : $stuff_type_request;
        $order_id = $order_id_param ? $order_id_param : $order_id_request;
        
        Db::startTrans();
        
        // case 操作mysq
        $orderDbModel = $this->getOrderModel($stuff_type);
        $wdata = array(
            'order_id' => $order_id
        );
        $result = $orderDbModel->delete($wdata, $this->_user);
        if ($result === false) {
            Db::rollback();
            $this->_error('操作失败~', 500);
        }
        
        // case 操作couchbase
        if (in_array($stuff_type, $this->stuff_types_goods)) {
            $orderCbModel = new \app\finance\model\Couchbase();
            $wdata_cb = array(
                'stuff_type' => $stuff_type,
                'order_id' => $order_id
            );
            $result_cb = $orderCbModel->deleteServiceOrder($wdata_cb, $this->_user);
        }
        
        // case 结束业务
        Db::commit();
        return array(
            'msg' => '操作成功',
            'data' => true
        );
    }

    /**
     * @function 确认收货
     * @author ljx
     */
    public function takeover()
    {
        $orderCode = input('order_code');
        $stuffType = input('stuff_type');
        $orderDbModel = $this->getOrderModel($stuffType); 

        $where = [
            'order_code' => $orderCode
        ];
        $update = [
            'order_status' => 20
        ];

        $orderDbModel->editBy($where,$update);
        
        if (in_array($stuffType, $this->stuff_types_goods)) {
            $orderCbModel = new \app\finance\model\Couchbase();
            $where = [
                'order_code' => $orderCode
            ];
            $update = [
                'order_status' => 20
            ];
            $result_cb = $orderCbModel->updateServiceOrderFields($where, $update);
        }

        return array(
            'msg' => '操作成功',
            'data' => true
        );
    }

    /**
     * @function 申请退货
     * @author ljx
     */
    public function refund()
    {
    }

    /**
     * @function 统一下单
     * @author ljx
     */
    public function add()
    {
        // case 获取提交的数据
        $this->tradeData = Request::instance()->post();
        $this->_user['user']['wallet'] = $this->getUserWallet();
        
        if (! isset($this->tradeData['stuff_type'])) {
            $this->_error("订单类型 stuff_type++{$this->tradeData['stuff_type']}++ 参数不正确", 400);
        }
        
        /*
         * AJMtr 2017-8-30 TODO: 请确认是否所有类型的订单，都需要item数据
         * if (! isset($this->tradeData['item'])) {
         * $this->_error('订单详情列表 item 参数不正确', 400);
         * }
         */
        
        // case 重复下单验证
        $this->checkDblAdd();
        
        // 开启事物
        Db::startTrans();
        
        // case 分业务处理 auction crowd freetrading
        switch ($this->tradeData['stuff_type']) {
            // 拍卖业务订单 auction
            case 1:
                $result = $this->auctionService();
                $this->addMainOrder($result);
                break;
            // 申购业务订单 crowd
            case 2:
                $result = $this->crowdService();
                $this->addMainOrder($result);
                break;
            // 自由买卖业务订单 freetrading
            case 3:
                $result = $this->freetradingService();
                break;
            // 保证金订单 deposit
            case 4:
                $result = $this->depositService();
                $this->addMainOrder($result);
                break;
            // 余额充值订单 wallet/balance
            case 5:
                $result = $this->walletService();
                $this->addMainOrder($result);
                break;
            default:
                $this->_error("订单类型 stuff_type++{$this->tradeData['stuff_type']}++ 参数不正确", 400);
                break;
        }
        
        // case 结束业务
        Db::commit();
        return $result;
    }

    /**
     * @function 自由买卖下单
     * @author ljx
     */
    private function freetradingService()
    {
        // case post数据item解析 改造交易数据的结构
        // 改造后的交易数据分为两大块 交易统计信息 和 交易数据按商户分组列表
        $this->tradeData = $this->parseFreetradingData();
        
        // case 业务验证
        $this->checkFreetradingService();
        
        // case 改造交易数据 备好订单入库数据
        $this->preAddFreetradingOrder();
        
        // case 订单操作 按商户写订单
        $order_id = 0;
        $serviceOrderModel = new \app\finance\model\FreetradingOrder();
        $serviceOrderDetailModel = new \app\finance\model\FreetradingOrderDetail();
        $opfOrderModel = new \app\finance\model\Order();
        $couchbaseModel = new \app\finance\model\Couchbase();
        
        // 保存买时卖家信息
        $business_ids = implode(',', array_unique(array_filter(array_keys($this->tradeData['trade_list']))));
        $sellerInfos = curl_get_content(config("basic_api_url") . "/Business_Home/getDetail?business_ids=" . $business_ids, 0, '', '', 1);
        $sellerInfos = object_array($sellerInfos);
        $sellerInfos = $sellerInfos['data'];
        $sellerList = array();
        foreach($sellerInfos as $key => $val){
            $sellerList[$val['business_id']] = array(
                'business_id' => $val['business_id'],
                'business_name' => $val['name'],
                'business_logo' => $val['business_logo']
            );
        }
        unset($sellerInfos);
        
        foreach ($this->tradeData['trade_list'] as $key => $val) {
            // $key 对应商户id
            $business_id = $key;
            // case service order
            $result_service = $serviceOrderModel->insert($val['order_info']['order'], $this->_user);
            if ($result_service === false) {
                Db::rollback();
                $this->_error('生成自由买卖主订单失败~', 500);
            }
            $order_id = $result_service;
            
            // case service order detail
            $temp = array(
                'order_id' => $order_id
            );
            
            foreach ($val['order_info']['order_detail'] as $key_in => $val_in) {
                $val['order_info']['order_detail'][$key_in] = array_merge($val['order_info']['order_detail'][$key_in], $temp);
                // 巨坑TP5
            }
            $result_detail = $serviceOrderDetailModel->addAll($val['order_info']['order_detail'], $this->_user);
            if ($result_detail === false) {
                Db::rollback();
                $this->_error('生成自由买卖详情订单失败~', 500);
            }
            
            // case opf_order
            $order_sn = $val['order_info']['opf_order']['order_sn'];
            $result_opforder = $opfOrderModel->insert(array_merge($val['order_info']['opf_order'], $temp));
            if ($result_opforder === false) {
                Db::rollback();
                $this->_error('生成主订单失败~', 500);
            }
            
            // case couchbase
            foreach ($val['order_info']['order_couchbase']['order_detail'] as $key_cb => $val_cb) {
                $temp['stuff_type'] = 3;
                $val['order_info']['order_couchbase']['order_detail'][$key_cb] = array_merge($val['order_info']['order_couchbase']['order_detail'][$key_cb], $temp);
            }
            $val['order_info']['order_couchbase']['order_id'] = $order_id;
            // 保存卖家信息
            $val['order_info']['order_couchbase']['order_seller'] = $sellerList[$business_id];
            $result_couchbase = $couchbaseModel->addServiceOrder($val['order_info']['order_couchbase'], $this->_user);
            // TODO 这边的判断
        }
        
        // case 结束业务
        return array(
            'data' => array(
                'order_sn' => $order_sn,
                'order_union' => 'isunion'
            )
        );
    }

    /**
     * @function 改造交易数据 备好订单入库数据
     * @author ljx
     */
    private function preAddFreetradingOrder()
    {
        // 生成联合订单号
        $order_sn = genOrdeCode('UNION', $this->_user['user']['user_id']);
        // 按商户划分订单
        foreach ($this->tradeData['trade_list'] as $key => $val) {
            // $key 商户id
            $business_id = $key;
            $goods_price_total = 0;
            $order_youhui_price = 0;
            $order_integral_price = 0;
            $order_integral = 0;
            $order_details = array();
            $order_freight_price = 0;
            $goods_num_total = 0;
            
            foreach ($val as $key_in => $val_in) {
                // $val_in 单条商品信息
                $goods_price_total += $val_in['trade_item_detail']['detail_num'] * $val_in['trade_item_detail']['detail_goods_price'];
                $order_youhui_price += $val_in['trade_item_detail']['detail_youhui_price'];
                $order_integral_price += $val_in['trade_item_detail']['detail_integral_price'];
                $order_integral += $val_in['trade_item_detail']['detail_integral'];
                $order_freight_price += $val_in['trade_item_detail']['detail_freight_price'];
                $goods_num_total += $val_in['trade_item_detail']['detail_num'];
                
                // case order_detail
                $order_details[] = array(
                    'business_id' => $business_id,
                    'user_id' => $this->_user['user']['user_id'],
                    'goods_id' => $val_in['goods_info']['item']['goods_id'],
                    'detail_stuff_id' => $val_in['goods_info']['item']['item_id'],
                    'detail_num' => $val_in['trade_item_detail']['detail_num'],
                    // 'detail_broker_price' => 0,
                    // 'detail_deposit_price' => 0,
                    'detail_youhui_price' => $val_in['trade_item_detail']['detail_youhui_price'],
                    'detail_integral_price' => $val_in['trade_item_detail']['detail_integral_price'],
                    'detail_freight_price' => $val_in['trade_item_detail']['detail_freight_price'],
                    'detail_integral' => $val_in['trade_item_detail']['detail_integral'],
                    'detail_goods_price' => $val_in['trade_item_detail']['detail_goods_price'],
                    'detail_goods_attr_value' => $val_in['trade_item_detail']['detail_goods_attr_value'],
                    'detail_goods_name' => $val_in['goods_info']['item']['item_name'],
                    'detail_goods_thumb' => $val_in['goods_info']['item']['goods_thumb'],
                    'detail_goods_sn' => isset($val_in['goods_info']['spec_goods']) && isset($val_in['goods_info']['spec_goods']['sn']) ? $val_in['goods_info']['spec_goods']['sn'] : '',
                    'detail_goods_attr_str' => isset($val_in['goods_info']['spec_goods']) && isset($val_in['goods_info']['spec_goods']['key_name']) ? $val_in['goods_info']['spec_goods']['key_name'] : ''
                );
            }
            
            // order_amount_price
            $order_amount_price = $goods_price_total + $order_freight_price;
            $order_paytotal_price = $order_amount_price - $order_youhui_price - $order_integral_price;
            $address_id = $this->tradeData['trade_stats']['address_id'];
            $address_info = $this->getAddressInfo($address_id);
            
            // TODO 单商户结算金额校验 检查展示给买家的金额与后台校验的金额是否一致
            // case order
            $order_code = genOrdeCode('FTRADING', $this->_user['user']['user_id']);
            $order_name = '自由买卖订单';
            $order = array(
                'order_code' => $order_code,
                'order_name' => $order_name,
                'business_id' => $business_id,
                'user_id' => $this->_user['user']['user_id'],
                'express_id' => $this->tradeData['trade_stats']['express_id'], // TODO 这边应当按商户的哦
                'address_id' => $this->tradeData['trade_stats']['address_id'], // 收货地址可以是公共的
                'order_amount_price' => $order_amount_price,
                'order_paytotal_price' => $order_paytotal_price,
                'order_youhui_price' => $order_youhui_price,
                'order_freight_price' => $order_freight_price,
                'order_integral_price' => $order_integral_price,
                // 'order_deposit_price' => 0,
                // 'order_broker_price' => 0,
                'order_integral' => $order_integral,
                // 'order_selfintegral_price' => 0,
                // 'order_selfintegral' => 0,
                // 'order_selfyouhui_price' => 0,
                'order_stuff_num' => $goods_num_total,
                'order_address_info' => serialize($address_info),
                'order_buier_remarks' => $this->tradeData['trade_stats']['order_buier_remarks']
            );
            
            // case opf_order
            $opf_order = array(
                'order_sn' => $order_sn,
                'order_code' => $order_code,
                'order_name' => $order_name,
                'stuff_type' => 3
            );
            
            // case couchbase
            $order_couchbase = $order;
            $order_couchbase['order_sn'] = $order_sn;
            $order_couchbase['order_pay_type'] = 0;
            $order_couchbase['order_status'] = 0;
            $order_couchbase['order_isxtrc'] = 0;
            $order_couchbase['order_xtrctime'] = 0;
            $order_couchbase['order_isdelete'] = 0;
            $order_couchbase['order_deltime'] = 0;
            $order_couchbase['order_delid'] = 0;
            $order_couchbase['order_paytime'] = 0;
            $order_couchbase['order_confirmid'] = 0;
            $order_couchbase['order_confirm_time'] = 0;
            $order_couchbase['order_express_info'] = '';
            $order_couchbase['order_deliverid'] = 0;
            $order_couchbase['order_deliver_time'] = 0;
            $order_couchbase['order_takeover_time'] = 0;
            $order_couchbase['order_seller_remarks'] = '';
            $order_couchbase['order_third_ordercode'] = '';
            $order_couchbase['order_third_payinfo'] = '';
            $order_couchbase['order_intime'] = $_SERVER['REQUEST_TIME'];
            $order_couchbase['order_uptime'] = $_SERVER['REQUEST_TIME'];
            $order_couchbase['order_detail'] = $order_details;
            $order_couchbase['stuff_type'] = $this->tradeData['trade_stats']['stuff_type'];

            // 保存买时买家信息
            $order_couchbase['order_buyer'] = $this->_user['user'];
            if (isset($order_couchbase['order_buyer']['wallet'])) {
                unset($order_couchbase['order_buyer']['wallet']);
            }
            // TODO detail_goods_desc
            
            $this->tradeData['trade_list'][$key]['order_info'] = array(
                'opf_order' => $opf_order,
                'order' => $order,
                'order_detail' => $order_details,
                'order_couchbase' => $order_couchbase
            );
        }
    }

    /**
     * @function 自由买卖业务验证
     * @author ljx
     */
    private function checkFreetradingService()
    {
        // TODO 每个商家的运费是不一样的 当多商家时 order_freight_price 是每个商家的运费之和
        $order_stuff_num = $order_youhui_price = $order_selfyouhui_price = $order_integral_price = $order_integral = 0;
        $order_selfintegral = $order_selfintegral_price = 0;
        $order_amount_price = $order_paytotal_price = 0;
        $goods_price_total = 0;
        $order_freight_price = 0;
        
        foreach ($this->tradeData['trade_list'] as $key => $val) {
            $goods_price = 0;
            // $key 为商家id $val为该商家的单品信息
            foreach ($val as $key_in => $val_in) {
                $goods_price = isset($val_in['goods_info']['spec_goods']['price']) ? $val_in['goods_info']['spec_goods']['price'] : $val_in['goods_info']['item']['item_price'];
                $order_stuff_num += $val_in['trade_item_detail']['detail_num'];
                $order_youhui_price += $val_in['trade_item_detail']['detail_youhui_price'];
                $order_integral_price += $val_in['trade_item_detail']['detail_integral_price'];
                $order_integral += $val_in['trade_item_detail']['detail_integral'];
                $goods_price_total += $goods_price * $val_in['trade_item_detail']['detail_num'];
                $order_freight_price += $val_in['trade_item_detail']['detail_freight_price'];
                
                // 检查库存
                if ($val_in['trade_item_detail'] < $val_in['goods_info']['item']['item_inventory']) {
                    Db::rollback();
                    $this->_error("亲,{$val_in['goods_info']['item']['item_name']} 的商品库存已不足,无法购买,请重新选择商品下单哦~", 500);
                }
            }
        }
        
        // 验证 order_stuff_num
        if ($order_stuff_num != $this->tradeData['trade_stats']['order_stuff_num']) {
            Db::rollback();
            $this->_error('物品总数不正确~', 400);
        }
        
        // 验证 order_youhui_price
        if ($order_youhui_price != $this->tradeData['trade_stats']['order_youhui_price']) {
            Db::rollback();
            $this->_error('总优惠金额不正确~', 400);
        }
        
        // 验证 order_integral_price
        if ($order_integral_price != $this->tradeData['trade_stats']['order_integral_price']) {
            Db::rollback();
            $this->_error('积分抵扣总金额不正确~', 400);
        }
        
        // 验证 order_integral
        if ($order_integral != $this->tradeData['trade_stats']['order_integral']) {
            Db::rollback();
            $this->_error('积分总数不正确~', 400);
        }
        
        // 验证运费 order_freight_price
        if ($order_freight_price != $this->tradeData['trade_stats']['order_freight_price']) {
            Db::rollback();
            $this->_error('运费总金额不正确~', 400);
        }
        
        // 验证 order_amount_price
        $order_amount_price = $goods_price_total + $this->tradeData['trade_stats']['order_freight_price'];
        if ($this->tradeData['trade_stats']['order_amount_price'] != $order_amount_price) {
            Db::rollback();
            $this->_error('订单总金额不正确~', 400);
        }
        
        // 验证 order_paytotal_price
        $order_paytotal_price = $order_amount_price - $order_youhui_price - $order_integral_price;
        if ($this->tradeData['trade_stats']['order_paytotal_price'] != $order_paytotal_price) {
            Db::rollback();
            $this->_error('用户支付总金额不正确~', 400);
        }
    }

    /**
     * @function 自由买卖交易数据解析
     * @author ljx
     * @see 见readmeForPay
     */
    private function parseFreetradingData()
    {
        $order_array = array();
        $order_array['trade_stats'] = $this->tradeData;
        $order_array['trade_list'] = array();
        unset($order_array['trade_stats']['item']);
        
        // case 一次获取多个业务详情
        $item_sku_maps = array();
        foreach ($this->tradeData['item'] as $key => $val) {
            $item_sku_maps[] = array(
                'item_id' => $val['detail_stuff_id'],
                'spec_key' => $val['detail_goods_attr_value']
            );
        }
        
        $temp = array(
            's' => json_encode($item_sku_maps)
        );
        $serviceDatas = curl_get_content(config("item_api_url") . "/index/sku_data", 1, $temp, $this->request->header('accesstoken'), 1);
        if ($serviceDatas['error'] != 0) {
            Db::rollback();
            $this->_error('该商品不存在~', 500);
        }
        $serviceDatas = $serviceDatas['result'];
        
        // case 业务数据绑定 以及按商户拆分
        foreach ($this->tradeData['item'] as $key => $val) {
            // 内层匹配业务数据
            foreach ($serviceDatas as $key_in => $val_in) {
                if (! empty($val_in['spec_goods']) && $val['detail_stuff_id'] == $key_in) {
                    // 该商品有sku时 取到匹配到的sku
                    $this->tradeData['item'][$key]['business_id'] = $val_in['item']['business_id'];
                    $this->tradeData['item'][$key]['goods_info'] = array(
                        'item' => $val_in['item'],
                        'spec_goods' => $val_in['spec_goods'][$val['detail_goods_attr_value']]
                    );
                } elseif (empty($val_in['spec_goods']) && $val['detail_stuff_id'] == $key_in) {
                    // 该商品没有sku时 就算了
                    $this->tradeData['item'][$key]['business_id'] = $val_in['item']['business_id'];
                    $this->tradeData['item'][$key]['goods_info'] = array(
                        'item' => $val_in['item'],
                        'spec_goods' => array()
                    );
                }
                // 其他情况都是不符合的哦 不要去判断
            }
            // 按商户拆分解析后的交易数据
            $order_array['trade_list'][$this->tradeData['item'][$key]['business_id']][] = array(
                'trade_item_detail' => $val,
                'goods_info' => $this->tradeData['item'][$key]['goods_info']
            );
        }
        
        return $order_array;
    }

    /**
     * @function 重复下单验证
     * @author ljx
     * @see TODO
     */
    private function checkDblAdd()
    {
        // TODO 申购重复下单需要考虑解决
        // TODO 自由买卖重复下单需要考虑解决
        // TODO 余额充值重复下单需要考虑解决
        
        // TODO 保证金重复下单可解决
        // TODO 拍卖重复下单可解决
    }

    /**
     * @function 申购下单
     * @author ljx
     */
    private function crowdService()
    {
        // case 获取提交的数据
        $this->tradeData;
        
        // case 获取业务数据
        // $serviceData = curl_get_content(config("crowd_api_url") . "Crowd_Home/detail?id=" . $this->tradeData['item'][0]['detail_stuff_id'], 0, "", $this->request->header('accesstoken'));
        // $serviceData = object_array($serviceData);
        
        $serviceData = curl_get_content(config("crowd_api_url") . "/index/detail?crowd_id=" . $this->tradeData['item'][0]['detail_stuff_id']);
        $serviceData = object_array($serviceData);
        
        // case 交易数据 与 当前业务数据验证
        $this->checkCrowdService($serviceData);
        $serviceData = $serviceData['result'];
        
        // case 生成订单 根据落槌价与保证金的关系 决定订单的处理
        $requestData = array();
        $requestData = $this->tradeData;
        
        $requestData['order_code'] = genOrdeCode('CROWD', $this->_user['user']['user_id']);
        $requestData['order_name'] = '申购订单';
        $requestData['business_id'] = $serviceData['business_id'];
        $requestData['goods_id'] = $serviceData['goods_id'];
        $requestData['user_id'] = $this->_user['user']['user_id'];
        $requestData['order_broker_price'] = $serviceData['crowd_broker_price'];
        $requestData['order_address_info'] = serialize($this->getAddressInfo());
        // case 补充order detail 需要的数据
        $item = $requestData['item'][0];
        // $requestData = array_merge($requestData, $requestData['item'][0]);
        unset($requestData['item']);
        $item['detail_stuff_id'] = $serviceData['crowd_id'];
        $item['detail_broker_price'] = $serviceData['crowd_broker_price'];
        $item['detail_deposit_price'] = $serviceData['crowd_seller_price'];
        $item['detail_goods_name'] = $serviceData['crowd_name'];
        $item['detail_goods_sn'] = isset($serviceData['crowd_code']) && ! empty($serviceData['crowd_code']) ? $serviceData['crowd_code'] : '';
        $item['detail_goods_thumb'] = $serviceData['goods_thumb'];
        $item['detail_goods_desc'] = $serviceData['goods_desc'];
        
        // $item['detail_goods_attr_value'] = $serviceData['goods_info']['goods_attr_value'];
        // $item['detail_goods_attr_str'] = $serviceData['goods_info']['goods_attr_str'];
        
        $requestData['order_isxtrc'] = 0;
        $requestData['order_xtrctime'] = 0;
        $requestData['order_isdelete'] = 0;
        $requestData['order_deltime'] = 0;
        $requestData['order_delid'] = 0;
        $requestData_cb = $requestData;
        
        $requestData = array_merge($requestData, $item);
        $model = new \app\finance\model\CrowdOrder();
        $result_add = $model->add($requestData, $this->_user);
        if ($result_add === false) {
            Db::rollback();
            $this->_error('生成申购订单失败', 500);
        }

        $item['order_id'] = $result_add;
        $item['stuff_type'] = 2;
        $requestData_cb['order_detail'][] = $item;
        
        // case 融合订单
        $cbModel = new \app\finance\model\Couchbase();
        $requestData_cb['order_id'] = $result_add;
        $requestData_cb['order_pay_type'] = 0;
        $requestData_cb['order_third_ordercode'] = '';
        $requestData_cb['order_third_payinfo'] = '';
        $requestData_cb['order_paytime'] = 0;
        $requestData_cb['order_status'] = 0;
        
        $requestData_cb['order_deliverid'] = 0;
        $requestData_cb['order_deliver_time'] = 0;
        $requestData_cb['order_express_info'] = '';

        $requestData_cb['order_intime'] = $_SERVER['REQUEST_TIME'];
        $requestData_cb['order_uptime'] = $_SERVER['REQUEST_TIME'];
        // 保存买时买家信息
        $requestData_cb['order_buyer'] = $this->_user['user'];
        if (isset($requestData_cb['order_buyer']['wallet'])) {
            unset($requestData_cb['order_buyer']['wallet']);
        }
        // 保存买时卖家信息
        $sellerInfo = curl_get_content(config("basic_api_url") . "/Business_Home/getDetail?business_ids=" . $serviceData['business_id'], 0, "", "", 1);
        $sellerInfo = object_array($sellerInfo);
        $sellerInfo = $sellerInfo['data'][$serviceData['business_id']];
        $requestData_cb['order_seller'] = array(
            'business_id' => $sellerInfo['business_id'],
            'business_name' => $sellerInfo['name'],
            'business_logo' => $sellerInfo['business_logo'],
        );
        
        $result_cb = $cbModel->addServiceOrder($requestData_cb, $this->_user);
        if ($result_cb === false) {
            Db::rollback();
            $this->_error('融合申购订单失败', 500);
        }
        
        // case 结束业务
        return array(
            'data' => array(
                'order_id' => $result_add,
                'order_sn' => $requestData['order_code'],
                'order_code' => $requestData['order_code'],
                'order_name' => $requestData['order_name']
            )
        );
    }

    /**
     * @function 获取收货地址
     * @author ljx
     */
    private function getAddressInfo($address_id_param = 0)
    {
        if (empty($address_id_param)) {
            $address_id = $this->tradeData['address_id'];
        } else {
            $address_id = $address_id_param;
        }
        $addressInfo = curl_get_content(config("basic_api_url") . "Delivery_Address_Home/detail?id=" . $address_id, 0, "", $this->request->header('accesstoken'));
        $addressInfo = object_array($addressInfo);
        
        return $addressInfo['data'];
    }

    /**
     * @function crowd下单检查
     * @author ljx
     */
    private function checkCrowdService($serviceData)
    {
        if (true !== ($validate = $this->validate($this->tradeData, 'Crowd'))) {
            $this->_error($validate, 400);
        }
        if ($serviceData['error'] != 0) {
            $this->_error('该申购不存在', 400);
        }
        $serviceData = $serviceData['result'];
        
        // case 参加申购时间合法性检查
        // if ($_SERVER['REQUEST_TIME'] < $serviceData['crowd_starttime'] || $_SERVER['REQUEST_TIME'] > $serviceData['crowd_endtime']) {
        // if ($_SERVER['REQUEST_TIME'] < $serviceData['crowd_starttime']) {
        // $error_msg = "申购时间还没开始~";
        // } else {
        // $error_msg = "申购已经结束了~";
        // }
        // $this->_error($error_msg, 400);
        // }
        
        // case 库存验证
        
        $item = $this->tradeData['item'][0]; // auction 只有一个item
                                             
        // case detail post data验证 验证拍卖类型:10竞价 11拍卖 12VIP 13专场 14拍卖会
        $auction_types = array(
            10,
            11,
            12,
            13,
            14
        );
        
        if (! isset($item['detail_stuff_id']) || empty($item['detail_stuff_id'])) {
            $this->_error('detail_stuff_id 申购id参数不正确~', 400);
        }
        if (! isset($item['detail_num']) || empty($item['detail_num'])) {
            $this->_error('detail_num 申购商品数量参数不正确~', 400);
        }
        if (! isset($item['detail_goods_price']) || ! is_numeric($item['detail_goods_price']) || intval($item['detail_goods_price']) < 0) {
            $this->_error('detail_goods_price 商品单价不正确~', 400);
        }
        if (isset($item['detail_youhui_price']) && (! is_numeric($item['detail_youhui_price']) || intval($item['detail_youhui_price']) < 0)) {
            $this->_error('detail_youhui_price 优惠金额不正确~', 400);
        }
        if (isset($item['detail_integral_price']) && (! is_numeric($item['detail_integral_price']) || intval($item['detail_integral_price']) < 0)) {
            $this->_error('detail_integral_price 积分抵扣金额不正确~', 400);
        }
        if (isset($item['detail_integral']) && intval($item['detail_integral']) != $item['detail_integral']) {
            $this->_error('detail_integral 积分不正确~', 400);
        }
        
        // case 拍卖、申购、自由买卖订单公共结算验证
        $this->checkService();
    }

    /**
     * @function auction下单
     * @author ljx
     */
    private function auctionService()
    {
        // case 获取提交的数据
        $this->tradeData;
        
        // case 获取业务数据
        // $serviceData = curl_get_content(config("auction_api_url") . "Auction_Home/detail?id=" . $this->tradeData['item'][0]['detail_stuff_id'], 0, "", $this->request->header('accesstoken'));
        // $serviceData = object_array($serviceData);
        
        $serviceData = curl_get_content(config("auction_api_url") . "/index/detail?aid=" . $this->tradeData['item'][0]['detail_stuff_id']);
        $serviceData = object_array($serviceData);
        
        // case 交易数据 与 当前业务数据验证
        $this->checkAuctionService($serviceData);
        $serviceData = $serviceData['result'];

        // case 该用户对应该拍卖所交保证金订单的检查 【这部可以考虑去掉】
        $depositModel = new \app\finance\model\DepositOrder();
        $wdata = array(
            'business_id' => $serviceData['business_id'],
            'user_id' => $this->_user['user']['user_id'],
            'order_stuff_type' => 0, // 竞价买卖保证金
            'order_stuff_id' => $serviceData['auction_id']
        );
        $depositOrderInfo = $depositModel->getRow($wdata);
        if ($depositOrderInfo['order_status'] != 2) {
            $this->_error('保证金订单处于 ' . $depositOrderInfo['order_status_tag'] . ' 状态', 400);
        }
        
        // case 生成订单 根据落槌价与保证金的关系 决定订单的处理
        $requestData = array();
        $requestData = $this->tradeData;
        $requestData['order_code'] = genOrdeCode('AUCTION', $this->_user['user']['user_id']);
        $requestData['order_name'] = '拍卖订单';
        $requestData['business_id'] = $serviceData['business_id'];
        $requestData['user_id'] = $this->_user['user']['user_id'];
        $requestData['order_deposit_price'] = $depositOrderInfo['order_paytotal_price'];
        $requestData['order_broker_price'] = $serviceData['auction_broker_price'];
        
        /**
         * case 拍卖业务处理
         * 若保证金 大于 落槌价 则 保证金部分转移 多余的保证金转余额 订单自动完成
         * 若保证金 等于 落槌价 则 保证金全部转移 订单自动完成
         * 若保证金 小于 落槌价 则 保证金全部转移 订单走支付流程
         */
        $order_paytotal_price = $this->tradeData['order_paytotal_price']; // 落槌价
        $deposit_price = $depositOrderInfo['order_paytotal_price'];
        $diff_price = $deposit_price - $order_paytotal_price;
        if ($diff_price == 0) {
            // 若保证金 等于 落槌价 则 保证金转移 订单自动完成
            $requestData['order_status'] = 2; // 已支付
            $requestData['order_pay_type'] = 99; // 支付方式为其它
            $requestData['order_paytime'] = $_SERVER['REQUEST_TIME']; // 支付时间
            $requestData['order_address_info'] = $depositOrderInfo['order_address_info']; // 收货地址信息
        } elseif ($diff_price > 0) {
            // 若保证金 大于 落槌价 则 保证金转移 多余的保证金转余额 订单自动完成
            $requestData['order_status'] = 2;
            $requestData['order_pay_type'] = 99;
            $requestData['order_paytime'] = $_SERVER['REQUEST_TIME'];
            $requestData['order_address_info'] = $depositOrderInfo['order_address_info'];
        } else {
            // 若保证金 小于 落槌价 则 保证金全部转移 订单走支付流程
            $requestData['order_status'] = 0; // 待支付
            $requestData['order_address_info'] = $depositOrderInfo['order_address_info'];
        }
        
        // 处理保证金流水 三种情况都把 保证金的订单状态标记为转移
        $requestData_deposit = array(
            'order_id' => $depositOrderInfo['order_id'],
            'order_status' => 5 /* 转移成功*/
        );
        
        $result_deposit = $depositModel->edit($requestData_deposit, $this->_user);
        if ($result_deposit === false) {
            Db::rollback();
            $this->_error('更改保证金订单状态失败~', 500);
        }
        
        // case $diff_price >= 0 的处理
        if ($diff_price >= 0) {
            $wallet_available_price = $this->_user['user']['wallet']['wallet_available_price'];
            
            // 保证金解冻
            if ($this->_user['user']['wallet']['wallet_freeze_price'] < $deposit_price) {
                $this->_error('钱包冻结金额出现错误~', 500);
            }
            $walletModel = new \app\finance\model\Wallet();
            $requestData_wallet = array(
                'wallet_id' => $this->_user['user']['wallet']['wallet_id'],
                'deposit_price' => $deposit_price,
                'deposit_free_price' => $order_paytotal_price
            );
            $result_wallet = $walletModel->release($requestData_wallet, $this->_user);
            if ($result_wallet === false) {
                Db::rollback();
                $this->_error('释放钱包中的冻结金额失败~', 500);
            }
            
            if ($diff_price > 0) {
                // 多余的保证金释放到余额中 记录到资金流水
                $requestData_fund = array(
                    'flow_code' => genOrdeCode('FUNDFLOW', $this->_user['user']['user_id']),
                    'flow_fromid' => $this->_user['user']['user_id'],
                    'flow_from_paytype' => 99,
                    'flow_toid' => - 1,
                    'flow_type' => 0, // 0余额变动记录 1交易记录
                    'flow_to_paytype' => - 1,
                    'flow_price' => $diff_price,
                    'flow_available_price' => $wallet_available_price, // 变动前的钱包余额
                    'flow_remarks' => '保证金转移到余额' . fd_demoney($diff_price) . '元'
                );
                $flowModel = new \app\finance\model\FundFlow();
                $result_flow = $flowModel->add($requestData_fund, $this->_user);
                if ($result_flow === false) {
                    Db::rollback();
                    $this->_error('保证金转移流水记录失败~', 500);
                }
            }
        }
        
        // case 补充order detail 需要的数据
        $item = $requestData['item'][0];
        unset($requestData['item']);
        $requestData['goods_id'] = $serviceData['goods_id'];
        $requestData['business_id'] = $serviceData['business_id'];
        $requestData['goods_id'] = $serviceData['goods_id'];
        $requestData['user_id'] = $this->_user['user']['user_id'];
        $item['detail_stuff_type'] = $serviceData['auction_mode'];
        $item['detail_stuff_id'] = $serviceData['auction_id'];
        $item['detail_broker_price'] = $serviceData['auction_broker_price'];
        $item['detail_deposit_price'] = $depositOrderInfo['order_paytotal_price'];
        $item['detail_goods_name'] = $serviceData['auction_name'];
        $item['detail_goods_sn'] = isset($serviceData['auction_code']) && ! empty($serviceData['auction_code']) ? $serviceData['auction_code'] : '';
        $item['detail_goods_thumb'] = $serviceData['goods_thumb'];
        $item['detail_goods_desc'] = $serviceData['goods_desc'];
       

        $requestData['order_isxtrc'] = 0;
        $requestData['order_xtrctime'] = 0;
        $requestData['order_isdelete'] = 0;
        $requestData['order_deltime'] = 0;
        $requestData['order_delid'] = 0;
        $requestData_cb = $requestData;
        
        $requestData = array_merge($requestData, $item);
        $model = new \app\finance\model\AuctionOrder();
        $result_add = $model->add($requestData, $this->_user);
        if ($result_add === false) {
            Db::rollback();
            $this->_error('生成拍卖订单失败', 500);
        }

        $item['order_id'] = $result_add;

        $item['stuff_type'] = 1;    
        $requestData_cb['order_detail'][] = $item;

        // case 订单融合
        $model = new \app\finance\model\CrowdOrder();
        $cbModel = new \app\finance\model\Couchbase();
        $requestData_cb['order_id'] = $result_add;
        $requestData_cb['order_pay_type'] = 0;
        $requestData_cb['order_third_ordercode'] = '';
        $requestData_cb['order_third_payinfo'] = '';
        
        $requestData_cb['order_deliverid'] = 0;
        $requestData_cb['order_deliver_time'] = 0;
        $requestData_cb['order_express_info'] = '';

        $requestData_cb['order_paytime'] = 0;
        $requestData_cb['order_intime'] = $_SERVER['REQUEST_TIME'];
        $requestData_cb['order_uptime'] = $_SERVER['REQUEST_TIME'];
        // 保存买时买家信息
        $requestData_cb['order_buyer'] = $this->_user['user'];
        if (isset($requestData_cb['order_buyer']['wallet'])) {
            unset($requestData_cb['order_buyer']['wallet']);
        }
        // 保存买时卖家信息
        $sellerInfo = curl_get_content(config("basic_api_url") . "/Business_Home/getDetail?business_ids=" . $serviceData['business_id']);
        $sellerInfo = object_array($sellerInfo);
        $sellerInfo = $sellerInfo['data'][0];
        $requestData_cb['order_seller'] = array(
            'business_id' => $sellerInfo['business_id'],
            'business_name' => $sellerInfo['name'],
            'business_logo' => $sellerInfo['business_logo'],
        );
        
        $result_cb = $cbModel->addServiceOrder($requestData_cb, $this->_user);
        if ($result_cb === false) {
            Db::rollback();
            $this->_error('融合拍卖订单失败', 500);
        }
        
        // case 结束业务
        return array(
            'data' => array(
                'order_id' => $result_add,
                'order_sn' => $requestData['order_code'],
                'order_code' => $requestData['order_code'],
                'order_name' => $requestData['order_name']
            )
        );
    }

    /**
     * @function 生成主订单
     * @author ljx
     */
    private function addMainOrder($result)
    {
        $model = new \app\finance\model\Order();
        
        $requestData_order = array(
            'order_sn' => $result['data']['order_sn'],
            'order_code' => $result['data']['order_code'],
            'order_name' => $result['data']['order_name'],
            'stuff_type' => $this->tradeData['stuff_type'],
            'order_id' => $result['data']['order_id']
        );
        $result_add = $model->add($requestData_order);
        if ($result_add === false) {
            Db::rollback();
            $this->_error('生成主订单失败', 500);
        }
    }

    /**
     * @function auction下单检查
     * @author ljx
     */
    private function checkAuctionService($serviceData)
    {
        if (true !== ($validate = $this->validate($this->tradeData, 'Auction'))) {
            $this->_error($validate, 400);
        }
        if ($serviceData['error'] != 0) {
            $this->_error('该拍卖不存在', 400);
        }
        
        $item = $this->tradeData['item'][0]; // auction 只有一个item
                                             
        // case detail post data验证 验证拍卖类型:10竞价 11拍卖 12VIP 13专场 14拍卖会
        $auction_types = array(
            10,
            11,
            12,
            13,
            14
        );
        if (! isset($item['detail_stuff_type']) || empty($item['detail_stuff_type']) || ! in_array($item['detail_stuff_type'], $auction_types)) {
            $this->_error('detail_stuff_type 拍卖类型参数不正确~', 400);
        }
        if (! isset($item['detail_stuff_id']) || empty($item['detail_stuff_id'])) {
            $this->_error('detail_stuff_id 拍卖id参数不正确~', 400);
        }
        if (! isset($item['detail_num']) || empty($item['detail_num'])) {
            $this->_error('detail_num 拍卖商品数量参数不正确~', 400);
        }
        if (! isset($item['detail_goods_price']) || ! is_numeric($item['detail_goods_price']) || intval($item['detail_goods_price']) < 0) {
            $this->_error('detail_goods_price 商品单价不正确~', 400);
        }
        if (isset($item['detail_youhui_price']) && (! is_numeric($item['detail_youhui_price']) || intval($item['detail_youhui_price']) < 0)) {
            $this->_error('detail_youhui_price 优惠金额不正确~', 400);
        }
        if (isset($item['detail_integral_price']) && (! is_numeric($item['detail_integral_price']) || intval($item['detail_integral_price']) < 0)) {
            $this->_error('detail_integral_price 积分抵扣金额不正确~', 400);
        }
        if (isset($item['detail_integral']) && intval($item['detail_integral']) != $item['detail_integral']) {
            $this->_error('detail_integral 积分不正确~', 400);
        }
        
        // case 拍卖、申购、自由买卖订单公共结算验证
        $this->checkService();
    }

    /**
     * @function 拍卖、申购、自由买卖订单公共结算验证
     * @author ljx
     */
    private function checkService()
    {
        // 分 单品优惠 和 订单优惠
        $total_detail_num = 0;
        $total_detail_goods_price = 0;
        $total_detail_youhui_price = 0;
        $total_detail_integral_price = 0;
        $total_detail_integral = 0;
        
        foreach ($this->tradeData['item'] as $key => $val) {
            if ($val['detail_num']) {
            }
            $total_detail_num += $val['detail_num'];
            $total_detail_goods_price += $val['detail_goods_price'] * $total_detail_num;
            $total_detail_youhui_price += $val['detail_youhui_price'];
            $total_detail_integral_price += $val['detail_integral_price'];
            $total_detail_integral += $val['detail_integral'];
        }
        // case 验证商品总个数
        if ($this->tradeData['order_stuff_num'] != $total_detail_num) {
            $this->_error('订单商品总个数有误', 400);
        }
        // case 验证抵扣积分总数
        if ($this->tradeData['order_integral'] != $total_detail_integral + $this->tradeData['order_selfintegral']) {
            $this->_error('订单抵扣积分总数有误', 400);
        }
        // case 验证抵扣积分总金额
        if ($this->tradeData['order_integral_price'] != $total_detail_integral_price + $this->tradeData['order_selfintegral_price']) {
            $this->_error('订单抵扣积分总金额有误', 400);
        }
        // case 验证优惠总金额
        if ($this->tradeData['order_youhui_price'] != $total_detail_youhui_price + $this->tradeData['order_selfyouhui_price']) {
            $this->_error('订单优惠总金额有误', 400);
        }
        // case 验证总金额
        if ($this->tradeData['order_amount_price'] != $total_detail_goods_price + $this->tradeData['order_freight_price']) {
            $this->_error('订单总金额有误', 400);
        }
        // case 验证支付总额 支付总额 = 订单总额 减去 优惠总额 减去抵扣金额
        $order_paytotal_price = $this->tradeData['order_paytotal_price'];
        $order_amount_price = $this->tradeData['order_amount_price'];
        $order_youhui_price = $this->tradeData['order_youhui_price'];
        $order_integral_price = $this->tradeData['order_integral_price'];
        $order_freight_price = $this->tradeData['order_freight_price'];
        if ($order_paytotal_price != $order_amount_price - $order_youhui_price - $order_integral_price) {
            $this->_error('订单支付金额有误~', 400);
        }
    }

    /**
     * @function 缴纳保证金下单
     * @author ljx
     */
    private function depositService()
    {
        // case 获取业务数据
        $serviceData = curl_get_content(config("auction_api_url") . "Auction_Home/detail?id=" . $this->tradeData['order_stuff_id'], 0, "", $this->request->header('accesstoken'));
        $serviceData = object_array($serviceData);
        
        // case 交易数据 与 当前业务数据验证
        $this->checkDeposit($serviceData);
        $serviceData = $serviceData['data'];
        
        // 获取收货地址
        $addressInfo = curl_get_content(config("basic_api_url") . "Delivery_Address_Home/detail?id=" . $this->tradeData['address_id'], 0, "", $this->request->header('accesstoken'));
        $addressInfo = object_array($addressInfo);
        if (isset($addressInfo['error'])) {
            $this->_error('该收货地址不存在~', 400);
        } else {
            $addressInfo = $addressInfo['data'];
            if ($addressInfo['owner_id'] != $this->_user['user']['user_id']) {
                $this->_error('该收货地址不是您的~', 400);
            }
        }
        
        // case 生成订单
        $requestData = array();
        $requestData = $this->tradeData;

        $requestData['order_code'] = genOrdeCode('AUDEPOSIT', $this->_user['user']['user_id']);
        $requestData['order_name'] = '拍卖保证金订单';
        $requestData['business_id'] = $serviceData['business_id'];
        $requestData['user_id'] = $this->_user['user']['user_id'];
        $requestData['order_address_info'] = serialize($addressInfo);
        $model = new \app\finance\model\DepositOrder();
        $result_add = $model->add($requestData, $this->_user);
        if ($result_add === false) {
            Db::rollback();
            $this->_error('生成保证金订单失败', 500);
        }

        //订单融合
        $cbModel = new \app\finance\model\Couchbase();
        $requestData_cb['order_id'] = $result_add;
        $requestData_cb['order_pay_type'] = 0;
        $requestData_cb['order_third_ordercode'] = '';
        $requestData_cb['order_third_payinfo'] = '';
        $requestData_cb['order_paytime'] = 0;
        $requestData_cb['stuff_type'] = 4;
        $requestData_cb['order_status'] = 0;
        $requestData_cb['order_code'] = $requestData['order_code'];
        $requestData_cb['order_paytotal_price'] = $requestData['order_paytotal_price'];
        $requestData_cb['user_id'] = $requestData['user_id'];
        $requestData_cb['order_intime'] = $_SERVER['REQUEST_TIME'];
        $requestData_cb['order_uptime'] = $_SERVER['REQUEST_TIME'];
        // 保存买时买家信息
        $requestData_cb['order_buyer'] = $this->_user['user'];
        if (isset($requestData_cb['order_buyer']['wallet'])) {
            unset($requestData_cb['order_buyer']['wallet']);
        }
            
        $sellerInfo = curl_get_content(config("basic_api_url") . "/Business_Home/getDetail?business_ids=" . $serviceData['business_id']);
        $sellerInfo = object_array($sellerInfo);
        $sellerInfo = $sellerInfo['data'][$serviceData['business_id']];
        $requestData_cb['order_seller'] = array(
            'business_id' => $sellerInfo['business_id'],
            'business_name' => $sellerInfo['name'],
            'business_logo' => $sellerInfo['business_logo'],
        );
        
        $result_cb = $cbModel->addServiceOrder($requestData_cb, $this->_user);
        if ($result_cb === false) {
            Db::rollback();
            $this->_error('融合拍卖订单失败', 500);
        }
        
        // case 结束业务
        return array(
            'data' => array(
                'order_id' => $result_add,
                'order_sn' => $requestData['order_code'],
                'order_code' => $requestData['order_code'],
                'order_name' => $requestData['order_name']
            )
        );
    }

    /**
     * @function 交易数据检查
     * @author ljx
     */
    private function checkDeposit($serviceData)
    {
        if (true !== ($validate = $this->validate($this->tradeData, 'Deposit'))) {
            $this->_error($validate, 400);
        }
        if (isset($serviceData['error'])) {
            $this->_error('该拍卖不存在~', 400);
        }
        $serviceData = $serviceData['data'];
        if ($this->tradeData['order_paytotal_price'] != $serviceData['auction_buier_price']) {
            $this->_error('支付金额与拍卖设置的买家保证金不相等', 400);
        }
        // case 是否已经交过
        $model = new \app\finance\model\DepositOrder();
        $wdata = array(
            'business_id' => $serviceData['business_id'],
            'user_id' => $this->_user['user']['user_id'],
            'order_stuff_id' => $serviceData['id']
        );
        $row = $model->getRow($wdata);
        if (! empty($row)) {
            $this->_error('保证金订单已经生成过了~', 400);
        }
    }

    /**
     * @function 余额充值下单
     * @author ljx
     */
    private function walletService()
    {
        // case 获取提交的数据
        $this->tradeData;
        
        // case 数据验证
        $this->checkWalletService();
        
        // case 生成订单
        $requestData = $this->tradeData;
        $requestData['order_code'] = genOrdeCode('RCHARGE', $this->_user['user']['user_id']);
        $requestData['order_name'] = '余额充值订单';
        $requestData['user_id'] = $this->_user['user']['user_id'];
        $requestData['mobile'] = $this->_user['user']['mobile'];
        $requestData['nickname'] = $this->_user['user']['nickname'];
          
        $model = new \app\finance\model\RechargeOrder();
        $result_add = $model->add($requestData);
        if ($result_add === false) {
            $this->_error('生成充值订单失败~', 500);
        }
        
        // case 结束业务
        return array(
            'data' => array(
                'order_id' => $result_add,
                'order_sn' => $requestData['order_code'],
                'order_code' => $requestData['order_code'],
                'order_name' => $requestData['order_name']
            )
        );
    }

    /**
     * @function 余额充值下单验证
     * @author ljx
     */
    private function checkWalletService()
    {
        if (true !== ($validate = $this->validate($this->tradeData, 'Recharge'))) {
            $this->_error($validate, 400);
        }
    }

    /**
     * @function 支付结果更新到订单
     * @author ljx
     * @param $payResult['pay_status'] 支付结果
     * @param $payResult['data'] 支付结果附加数据
     * @param $tradeData 交易数据
     */
    public function update($payResult = array(), $tradeData = array())
    {
        $this->tradeData = $tradeData;
        
        // 公共更新数据集
        $order_id = $this->tradeData['order_id'];
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
        
        $order_third_ordercode = $payResult['data']['order_third_ordercode'];
        $order_third_payinfo = $payResult['data']['order_third_payinfo'];
        
        switch ($this->tradeData['stuff_type']) {
            // 拍卖业务订单
            case 1:
                $model = new \app\finance\model\AuctionOrder();
                $requestData = array(
                    'order_id' => $order_id,
                    'order_pay_type' => $order_pay_type,
                    'order_status' => $order_status,
                    'order_paytime' => $order_paytime,
                    'order_third_ordercode' => $order_third_ordercode,
                    'order_third_payinfo' => serialize($order_third_payinfo)
                );
                $result = $model->edit($requestData);
                break;
            // 申购业务订单
            case 2:
                $model = new \app\finance\model\CrowdOrder();
                $requestData = array(
                    'order_id' => $order_id,
                    'order_pay_type' => $order_pay_type,
                    'order_status' => $order_status,
                    'order_paytime' => $order_paytime,
                    'order_third_ordercode' => $order_third_ordercode,
                    'order_third_payinfo' => serialize($order_third_payinfo)
                );
                $result = $model->edit($requestData);
                break;
            // 自由买卖业务订单
            case 3:
                break;
            // 保证金订单
            case 4:
                $model = new \app\finance\model\DepositOrder();
                $requestData = array(
                    'order_id' => $order_id,
                    'order_pay_type' => $order_pay_type,
                    'order_status' => $order_status,
                    'order_paytime' => $order_paytime,
                    'order_third_ordercode' => $order_third_ordercode,
                    'order_third_payinfo' => serialize($order_third_payinfo)
                );
                $result = $model->edit($requestData);
                break;
            // 余额充值订单
            case 5:
                $model = new \app\finance\model\RechargeOrder();
                $requestData = array(
                    'order_id' => $order_id,
                    'order_pay_type' => $order_pay_type,
                    'order_status' => $order_status,
                    'order_paytime' => $order_paytime,
                    'order_third_ordercode' => $order_third_ordercode,
                    'order_third_payinfo' => serialize($order_third_payinfo)
                );
                $result = $model->edit($requestData);
                break;
            default:
                Db::rollback();
                $this->_error('订单类型 stuff_type 参数不正确', 400);
                break;
        }
        
        // case 结束业务
        if ($result === false) {
            Db::rollback();
            $this->_error('更新订单失败~', 500);
        } else {
            return true;
        }
    }
}
