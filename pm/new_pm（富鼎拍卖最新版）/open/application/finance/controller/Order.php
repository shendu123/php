<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use think\Request;
use think\Db;

class Order extends OrderHome
{

    public function __construct()
    {
        parent::__construct();
    }

    /*
     * 订单确认
     */
    public function confirm()
    {
        $stuffType = valueRequest('stuff_type', 0);
        $orderId = valueRequest('order_id', 0);
        switch ($stuffType) {
            // 拍卖
            case 1:
                $model = new \app\finance\model\AuctionOrder();
                $wdata = array(
                    'order_id' => $orderId
                );
                $update['order_status'] = 20;
                $row = $model->save($update, $wdata);
                break;
            // 申购
            case 2:
                $model = new \app\finance\model\CrowdOrder();
                $wdata = array(
                    'order_id' => $orderId
                );
                $update['order_status'] = 20;
                $row = $model->save($update, $wdata);
                break;
            // 自由买卖
            case 3:
                $model = new \app\finance\model\FreetradingOrder();
                $wdata = array(
                    'order_id' => $orderId
                );
                $update['order_status'] = 20;
                $row = $model->save($update, $wdata);
                break;
            // 保证金
            case 4:
                $model = new \app\finance\model\DepositOrder();
                $wdata = array(
                    'order_id' => $orderId
                );
                $row = $model->save($update, $wdata);
                break;
            // 余额充值
            case 5:
                $model = new \app\finance\model\RechargeOrder();
                $wdata = array(
                    'order_id' => $orderId
                );
                $update['order_status'] = 20;
                $row = $model->save($update, $wdata);
                break;
            default:
                $this->_error('stuff_type 业务类型参数不正确~', 400);
        }
        return [
            'msg' => '操作成功',
            'data' => true
        ];
    }
	
	/*
	 * 快递公司
	 */
	public function getExpress(){
		return Db::name('express')->select();
	}

    /*
     * 订单发货【拍卖、申购、自由买卖】
     * @author zxl
     */
    public function orderDelivery()
    {
        $param = request()->post();
        if (! isset($param['order_id']) || empty($param['order_id'])) {
            $this->_error('参数错误', 400);
        }
        $table = [
            'auction',
            'crowd',
            'freetrading'
        ];
        if (! isset($param['type']) || ! in_array(strtolower($param['type']), $table)) {
            $this->_error('订单表不存在', 400);
        }
        if (! isset($param['express_id']) || empty($param['express_id'])) {
            $this->_error('请选择快递公司', 400);
        }
        if (! isset($param['order_express_info']) || empty($param['order_express_info'])) {
            $this->_error('请填写快递单号', 400);
        }
        $class = "app\\finance\\model\\" . ucfirst(strtolower($param['type'])) . "Order";
        $model = new $class();
        $data['order_deliverid'] = $this->_user['user']['user_id'];
        $data['order_deliver_time'] = time();
        $data['express_id'] = $param['express_id'];
        $data['order_express_info'] = $param['order_express_info'];
        $data['order_status'] = 10; // 10已发货
        if ($model->save($data, [
            'order_id' => $param['order_id']
        ]) === false) {
            $this->_error('操作失败', 500);
        }
        return [
            'msg' => '操作成功',
            'status' => 200
        ];
    }

    /**
     * @function 会员列表交易记录
     * @author ljx
     */
    public function getTradeList()
    {
        if (empty($this->_user)) {
            $this->_user = $this->getCallerInfo();
        }
        
        $user_id = valueRequest('user_id', 0);
        if (empty($user_id)) {
            $this->_error("参数user_id不能为空~", 400);
        }
        
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
            'business_id' => $this->_user['business']['business_id'],
            'user_id' => $user_id
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
     * @function 会员列表交易记录详情
     * @author ljx
     */
    public function getDetail()
    {
        $order_id = valueRequest('order_id', 0);
        $stuff_type = valueRequest('stuff_type', 0);
        
        if (empty($order_id)) {
            $this->_error('order_id 不能为空~');
        }
        if (empty($stuff_type)) {
            $this->_error('stuff_type 不能为空~');
        }
        $stuff_types = array(
            1,
            2,
            3
        );
        if (! in_array($stuff_type, $stuff_types)) {
            $this->_error('stuff_type 参数有误~');
        }
        
        $cbOrderModel = new \app\finance\model\Couchbase();
        $wdata = array(
            'order_id' => $order_id,
            'stuff_type' => $stuff_type
        );
        $data = $cbOrderModel->getServiceOrderDetail($wdata);
        
        return $data;
    }

}