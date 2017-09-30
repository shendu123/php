<?php
namespace app\finance\controller;
use app\common\controller\NoAuth;

/**
 * @class 会员充值订单管理
 * @author ljx
 */
class Recharge extends NoAuth{
    public function __construct(){
        parent::__construct();
        if(!empty($this->_uid)){
            $this->_user = $this->getCallerInfo();
        }
    }
    /**
     * @function 列表
     * @author ljx
     */
    public function getList(){
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;
        $order_status = valueRequest('order_status', '', 'int');
        $startDate = input('start_date');
        $endDate = input('end_date');         
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传      
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'order_status' => $order_status,
            'start_at' => strtotime($startDate),
            'end_at' => strtotime($endDate),
            'stuff_type' => 5,
            'keyword' => valueRequest('keyword', '', 'string'),
			'order_pay_type' => valueRequest('order_pay_type', 0, 'int'),
        );
        $model = new \app\finance\model\RechargeOrder();
        $result = $model->getList($wdata);
        
        return array(
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'business_id' => $this->_user['business']['business_id'],
            'total' => $result['total'],
            'totalPage' => ceil($result['total'] / $wdata['pageSize']),
            'data' => $result['data']
        );
    }
    
    /**
     * @function 订单详情
     * @author ljx
     */
    public function getDetail(){
        $order_id = valueRequest('order_id', 0);
        if(empty($order_id)){
            $this->_error('order_id 参数不能为空', 400);
        }
        
        $model = new \app\finance\model\Couchbase();
        $requestData = array(
            'order_id' => $order_id,
            'stuff_type' => 2
        );
        $row = $model->getServiceOrderDetail($requestData);
        
        return $row;
    }
}
















