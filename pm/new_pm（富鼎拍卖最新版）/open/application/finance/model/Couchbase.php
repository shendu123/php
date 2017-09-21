<?php
namespace app\finance\model;

/**
 * @class finance模块所有需要用到couchbase的能力 在这里面实现
 * @author ljx
 */
class Couchbase
{

    private $cbObj;

    public function __construct()
    {
        $this->cbObj = new \Couchbase(config('couchbase'));
    }

    /**
     * @function 商品业务订单
     * @author ljx
     *        
     * @param array $requestData
     * @param array $operateData
     */
    public function addServiceOrder($requestData = array(), $operateData = array())
    {
        $order_code = $requestData['order_code'];
        $requestData = json_encode($requestData);
        
        return $this->cbObj->n1ql_query("INSERT INTO `finance_order` ( KEY, VALUE ) VALUES ('{$order_code}', {$requestData} )");
    }

    /**
     * @function 商品业务订单详情
     * @author ljx
     *        
     * @param array $requestData
     * @param array $operateData
     */
    public function getServiceOrderDetail($requestData = array(), $operateData = array())
    {
        $whereCond = array();
        
        if(isset($requestData['order_code'])){
            $whereCond['order_code'] = " order_code = '{$requestData['order_code']}' ";
        }
        if(isset($requestData['order_id']) && !empty($requestData['order_id'])){
            $whereCond['order_id'] = " order_id = '{$requestData['order_id']}' ";
        }
        if(isset($requestData['stuff_type']) && !empty($requestData['stuff_type'])){
            $whereCond['stuff_type'] = " stuff_type = '{$requestData['stuff_type']}' ";
        }
        
        $whereSql = implode('AND', $whereCond);
        
        $row = $this->cbObj->bucket('finance_order')
            ->where($whereSql)
            ->select();
        $row = object_array($row);
        $row = $row[0];
        
        return $row;
    }

    /**
     * @function 商品业务订单 更新字段
     * @author ljx
     *        
     * @param array $requestData
     * @param array $operateData
     */
    public function updateServiceOrderFields($wdata = array(), $fields = array(), $operateData = array())
    {
        $requestData_detail = array(
            'order_code' => $wdata['order_code']
        );
        $orderDetail = $this->getServiceOrderDetail($requestData_detail, $operateData);
        
        $sql_fields = "";
        // 字段检测
        if (isset($fields['order_status']) && isset($orderDetail['order_status'])) {
            $sql_fields .= " order_status = {$fields['order_status']} ";
        }
        if (isset($fields['order_third_ordercode']) && isset($orderDetail['order_third_ordercode'])) {
            $sql_fields .= ", order_third_ordercode = '{$fields['order_third_ordercode']}' ";
        }
        if (isset($fields['order_third_payinfo']) && isset($orderDetail['order_third_payinfo'])) {
            $sql_fields .= ", order_third_payinfo = '{$fields['order_third_payinfo']}' ";
        }
        if (isset($fields['order_pay_type']) && isset($orderDetail['order_pay_type'])) {
            $sql_fields .= ", order_pay_type = {$fields['order_pay_type']} ";
        }
        if (isset($fields['order_paytime']) && isset($orderDetail['order_paytime'])) {
            $sql_fields .= ", order_paytime = {$fields['order_paytime']} ";
        }
        
        $sql_update = "UPDATE `finance_order` SET";
        
        $sql_where = " WHERE order_code = '{$wdata['order_code']}' ";
        
        $sql_query = $sql_update . $sql_fields . $sql_where;
        
        return $this->cbObj->n1ql_query($sql_query);
    }

    /**
     * @function 商品业务订单刷新 与mysql数据同步
     * @author ljx
     */
    public function refreshOrderDetail($wdata = array(), $operateData = array())
    {
        // case 获取订单详情
        $orderModel = new \app\finance\model\Order();
        $wdata_order = array(
            'order_code' => $wdata['order_code']
        );
        $orderDetail = $orderModel->getRow($wdata_order, $operateData);
        $orderDetail = json_encode($orderDetail);
        
        $sql_query = "UPSERT INTO finance_order (KEY, VALUE) VALUES('{$wdata['order_code']}', {$orderDetail})";
        
        return $this->cbObj->n1ql_query($sql_query);
    }

    /**
     * @function 删除商品业务订单
     * @author ljx
     */
    public function deleteServiceOrder($wdata = array(), $operateData = array())
    {
        if(!isset($wdata['order_id']) || empty($wdata['order_id']) || !isset($wdata['stuff_type']) || empty($wdata['stuff_type'])){
            return false;
        }
        $n1ql = "DELETE FROM `finance_order` WHERE order_id = '{$wdata['order_id']}' AND stuff_type = '{$wdata['stuff_type']}'";
        return $this->cbObj->n1ql_query($n1ql);
    }

    /**
     * @function 列表
     * @author ljx
     *        
     * @param array $wdata 列表查询条件 $wdata条件组合都是以AND连接
     * @param integer $wdata['business_id'] 订单所属商户id
     * @param integer $wdata['user_id'] 订单所属用户id
     * @param string $wdata['start_from_time'] $wdata['start_to_time'] xx开始时间搜索区间 标准时间格式字符串 例如 2017-05-08 【不支持时分秒】
     * @param string $wdata['end_from_time'] $wdata['end_to_time'] xx结束时间搜索区间 例如 2017-05-08 【不支持时分秒】
     * @param string $wdata['order_status'] 订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废
     * @param ingeger $wdata['stuff_type'] 1拍卖 2申购 3自由买卖
     * @param integer $wdata['page'] 第几页
     * @param integer $wdata['pageSize'] 页宽
     *       
     * @param boolean $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        // TODO 稳定后 要指定字段 或者考虑接口专用
        $sql_select = "SELECT * ";
        $sql_from = " FROM finance_order ";
        $sql_where = " WHERE 1=1 ";
        // 搜索条件
        if (isset($wdata['business_id']) && ! empty($wdata['business_id']) && $wdata['business_id'] != 1) {
            $sql_where .= " AND business_id ={$wdata['business_id']} ";
        }
        if (isset($wdata['user_id']) && ! empty($wdata['user_id'])) {
            $sql_where .= " AND user_id ={$wdata['user_id']} ";
        }
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
        // 订单类型 1 2 3
        if (isset($wdata['stuff_type']) && ! empty($wdata['stuff_type'])) {
            $sql_where .= " AND stuff_type = '{$wdata['stuff_type']}' ";   
        }
        
        // 订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废
        if (isset($wdata['order_status']) && ! empty($wdata['order_status'])) {
            $sql_where .= " AND order_status {$wdata['order_status']} ";
        }
		
		$deliveryOrPay = (isset($wdata['isdelivery']) && ! empty($wdata['isdelivery'])) || (isset($wdata['ispay']) && ! empty($wdata['ispay']));
		if (!isset($wdata['order_status']) && $deliveryOrPay) {
			$order_status = $wdata['isdelivery'] || $wdata['ispay'];
            $sql_where .= " AND order_status = {$order_status} ";
        }
        
        // 订单支付时间搜索区间
        if (! empty($wdata['start_order_paytime']) || ! empty($wdata['end_order_paytime'])) {
            if (empty($wdata['start_order_paytime'])) {
                $wdata['start_order_paytime'] = strtotime($year_m . '-01 00:00:00');
            } else {
                $wdata['start_order_paytime'] = strtotime($wdata['start_order_paytime']);
            }
            if (empty($wdata['end_order_paytime'])) {
                $wdata['end_order_paytime'] = strtotime($year_m . date("t") . ' 23:59:59');
            } else {
                $wdata['end_order_paytime'] = strtotime($wdata['end_order_paytime']) + 86400 - 1;
            }
            
            $sql_where .= " AND order_paytime BETWEEN {$wdata['start_order_paytime']} AND {$wdata['end_order_paytime']}";
        }
        
        // 订单下单时间搜索区间
        if (! empty($wdata['start_order_intime']) || ! empty($wdata['end_order_intime'])) {
            if (empty($wdata['start_order_intime'])) {
                $wdata['start_order_intime'] = strtotime($year_m . '-01 00:00:00');
            } else {
                $wdata['start_order_intime'] = strtotime($wdata['start_order_intime']);
            }
            if (empty($wdata['end_order_intime'])) {
                $wdata['end_order_intime'] = strtotime($year_m . date("t") . ' 23:59:59');
            } else {
                $wdata['end_order_intime'] = strtotime($wdata['end_order_intime']) + 86400 - 1;
            }
            
            $sql_where .= " AND order_intime BETWEEN {$wdata['start_order_intime']} AND {$wdata['end_order_intime']}";
        }
        
        // 订单号模糊搜索
        if (isset($wdata['keyword']) && ! empty($wdata['keyword'])) {
            $sql_where .= " AND order_code LIKE '%{$wdata['keyword']}%' ";
            $sql_where .= " OR order_buyer.mobile LIKE '%{$wdata['keyword']}%' ";
            $sql_where .= " OR order_buyer.nickname LIKE '%{$wdata['keyword']}%' ";
            $sql_where .= " OR order_detail.detail_goods_price LIKE '%{$wdata['keyword']}%' ";
        }
        
        // 删除状态
        if (isset($wdata['order_isdelete']) && ! empty($wdata['order_isdelete'])) {
            $sql_where .= " AND order_isdelete {$wdata['order_isdelete']} ";
        }

        // 其他搜索条件
        if (isset($wdata['xxxxxxxx']) && ! empty($wdata['xxxxxxxx'])) {
            $sql_where .= " AND xxxxxxxx ='{$wdata['xxxxxxxx']}' ";
        }
        
        $sql_order = " ORDER BY order_payintime DESC, order_uptime DESC ";
        
        $sql_limit = " LIMIT " . $wdata['pageSize'] . " OFFSET " . ($wdata['page'] - 1) * $wdata['pageSize'];
        
        // 获取数据
        $sql_all = $sql_select . $sql_from . $sql_where . $sql_order . $sql_limit;
        //echo 'aaaaaaaaaaaa';
        $data = $this->cbObj->n1ql_query($sql_all);
        //echo '93209230923090923';
        $data = object_array($data);
        //echo '12333';
        $data = array_column($data['rows'], 'finance_order');
        //echo 'eeeee';
        // 获取总数
        $sql_count = "SELECT COUNT(*) AS d " . $sql_from . $sql_where;
        $sql_count_result = $this->cbObj->n1ql_query($sql_count);
        $sql_count_result = object_array($sql_count_result);

        $data = $this->parseListData($data, $operateData);
        
        return array(
            'total' => $sql_count_result['rows'][0]['d'],
            'data' => $data
        );
    }
    
    /**
     * @function 获取列表
     * @author ljx
     */
    public function getListBy($wdata = array(), $operateData = array(), $exchange = true){
        // TODO 稳定后 要指定字段 或者考虑接口专用
        $sql_select = "SELECT * ";
        $sql_from = " FROM finance_order ";
        $sql_where = " WHERE 1=1 ";
        
        // 搜索条件
        
        // 联合订单号严格搜索
        if (isset($wdata['order_sn']) && ! empty($wdata['order_sn'])) {
            $sql_where .= " AND order_sn = '{$wdata['order_sn']}' ";
        }elseif(isset($wdata['order_code']) && ! empty($wdata['order_code'])){
            $sql_where .= " AND order_code = '{$wdata['order_code']}' ";
        }
        
        // 获取数据
        $sql_all = $sql_select . $sql_from . $sql_where;
        
        $data = $this->cbObj->n1ql_query($sql_all);
        $data = object_array($data);
        $data = array_column($data['rows'], 'finance_order');
        
        return $data;
    }

    /**
     * @function 解析列表数据
     * @author ljx
     */
    private function parseListData($data = array(), $operateData = array())
    {
        if (empty($data)) {
            return;
        }
        
        foreach ($data as $key => $val) {
            //$data[$key]['order_address_info'] = unserialize($val['order_address_info']);
        }
        
        return $data;
    }
}





































