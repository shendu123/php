<?php
namespace app\finance\controller;
use app\common\controller\NoAuth;

/**
 * @class 申购订单管理
 * @author ljx
 */
class Crowd extends NoAuth{
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
        
        $order_status = valueRequest('order_status', 'egt|0', 'string');
        $tempArr = explode('|', $order_status);
        $operator = opr_check_convert($tempArr[0]);
        $order_status = $operator . ' ' . $tempArr[1];
        
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'business_id' => $this->_user['business']['business_id'],
            'order_status' => $order_status,
            'stuff_type' => 2,
            'keyword' => valueRequest('keyword', '', 'string'),
			'isdelivery' => valueRequest('isdelivery' , ''),
			'ispay' => valueRequest('ispay' , ''),
        );

        $model = new \app\finance\model\Couchbase();
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
















