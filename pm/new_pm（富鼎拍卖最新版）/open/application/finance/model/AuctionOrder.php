<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 拍卖订单模型
 * @author ljx
 */
class AuctionOrder extends Model
{

    protected $table = 'opf_auction_order';

    public $_tableFields = array(
        'order_id' => 'int', // 拍卖订单id
        'order_code' => 'varchar', // 订单号(按规则统一生成唯一)
        'order_name' => 'varchar', // 订单名称
        'business_id' => 'int', // 订单所属商户id
        'user_id' => 'int', // 订单所属买家id
        'express_id' => 'int', // 快递公司id
        'address_id' => 'int', // 收货人地址id
        'order_amount_price' => 'int', // 【单位分】订单总额(未做任何扣除)
        'order_paytotal_price' => 'int', // 【单位分】用户支付总额 paytotal = (amount - youhui - integral_price) + freight;(amount - youhui - integral_price)必须为正
        'order_youhui_price' => 'int', // 【单位分】订单优惠总额
        'order_freight_price' => 'int', // 【单位分】运费总额
        'order_integral_price' => 'int', // 【单位分】结算时积分抵扣总额
        'order_deposit_price' => 'int', // 【单位分】买家已缴纳保证金总额
        'order_broker_price' => 'int', // 【单位分】卖家需缴纳佣金总额
        'order_integral' => 'int', // 结算时抵扣积分总数
        'order_selfintegral_price' => 'int', // 【单位分】【对总订单】结算时积分抵扣金额
        'order_selfintegral' => 'int', // 【对总订单】结算时抵扣积分数
        'order_selfyouhui_price' => 'int', // 【单位分】【对总订单】优惠金额
        'order_pay_type' => 'int', // 支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它
        'order_status' => 'int', // 订单流程状态:0待付款 1付款中 2已付款/处理中/待发货 3付款失败 10已发货 20已完成 30申请退货 35驳回退货 40退货处理中 45已退货 99作废
        'order_isxtrc' => 'int', // 佣金提取状态: 0未提取 1已提取
        'order_xtrctime' => 'int', // 佣金提取时间
        'order_isdelete' => 'int', // 订单删除状态: 0正常 1已删除
        'order_deltime' => 'int', // 订单删除时间
        'order_delid' => 'int', // 订单删除操作者
        'order_stuff_num' => 'int', // 物品总数
        'order_paytime' => 'int', // 订单支付时间
        'order_confirmid' => 'int', // 确认订单操作者id
        'order_confirm_time' => 'int', // 确认订单时间
        'order_express_info' => 'int', // 第三方物流信息，一般是物流单号
        'order_deliverid' => 'int', // 发货人员id
        'order_deliver_time' => 'int', // 发货时间
        'order_takeover_time' => 'int', // 确认收货时间
        'order_address_info' => 'int', // 序列化后的地址信息,防止用户修改,作为物流寄件地址
        'order_buier_remarks' => 'int', // 买家留言
        'order_seller_remarks' => 'int', // 卖家备注
        'order_third_ordercode' => 'int', // 第三方单号
        'order_third_payinfo' => 'int', // 【序列化保存】第三方支付返回信息
        'order_intime' => 'int', // 订单生成时间
        'order_uptime' => 'int' /*订单修改时间，只要数据有变动就更新时间**/
	);
    
    // 订单状态标签
    private $order_status_tags = array(
        '0' => '待付款',
        '1' => '付款中',
        '2' => '已付款/处理中/待发货',
        '3' => '付款失败',
        '10' => '已发货',
        '20' => '已完成',
        '30' => '申请退货',
        '35' => '驳回退货',
        '40' => '退货处理中',
        '45' => '已退货',
        '99' => '作废'
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        // case order 主表
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['order_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['order_uptime'] = $_SERVER['REQUEST_TIME'];
        $result_main = $this->save($fields);
        if ($result_main === false) {
            return false;
        }
        $order_id = $this->order_id;
        
        // case order 详情表
        $detailModel = new \app\finance\model\AuctionOrderDetail();
        $requestData['order_id'] = $order_id;
        $result_detail = $detailModel->add($requestData, $operateData);
        if ($result_detail === false) {
            return false;
        }
        
        return $order_id;
    }

    /**
     * @function 编辑
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['order_uptime'] = $_SERVER['REQUEST_TIME'];
        $wdata = array(
            'order_id' => $fields['order_id']
        );
        
        // case 主表
        $result_main = $this->save($fields, $wdata);
        if ($result_main === false) {
            return false;
        }
        
        // case 详情表
        $detailModel = new \app\finance\model\AuctionOrderDetail();
        $wdata_detail = array(
            'order_id' => $fields['order_id']
        );
        $result_detail = $detailModel->edit($wdata_detail, $requestData, $operateData);
        if ($result_detail === false) {
            return false;
        }
        
        return true;
    }

    /**
     * @function 用于编辑主表字段
     * @author ljx
     */
    public function editBy($wdata = array(), $requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['order_uptime'] = $_SERVER['REQUEST_TIME'];
        
        return $this->save($fields, $wdata);
    }
    
    /**
     * @function 删除订单
     * @author ljx
     * @see 适用于 取消订单业务 该数据对平台已无意义
     */
    public function delete($wdata = array(), $operateData = array()){
        // case 获取订单号
        $requestData_getBy = array(
            'order_code'
        );
        $orderInfo = $this->getBy($wdata, $requestData_getBy);
        
        // case opf_order
        $orderModel = new \app\finance\model\Order();
        $wdata_order = array(
            'order_code' => $orderInfo['order_code']
        );
        $result_order = $orderModel->delete($wdata_order, $operateData);
        if($result_order === false){
            return false;
        }
        
        // case service_order
        $result_service = Db::table($this->t)->where($wdata)->delete();
        if($result_service === false){
            return false;
        }
        
        // case service_order_detail
        $detailModel = new \app\finance\model\CrowdOrderDetail();
        $wdata_detail = array(
            'order_id' => $wdata['order_id']
        );
        $result_detail = $detailModel->delete($wdata_detail, $operateData);
        if($result_detail === false){
            return false;
        }
        
        // case 结束业务
        return true;
    }
    
    /**
     * @function 获取详情的少量字段
     * @author ljx
     * @todo 暂不支持详情
     */
    public function getBy($wdata = array(), $requestData = array()){
        $sql_fields = '';
        $fields = array();
        foreach($requestData as $key => $val){
            if(in_array($val, array_keys($this->_tableFields))){
                $fields[] = $val;
            }
        }
        $sql_fields = implode(',', $fields);
    
        return Db::table('opf_auction_order')->where($wdata)->field($sql_fields)->find();
    }

    /**
     * @function 列表
     * @author ljx
     *        
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        if(isset($wdata['business_id']) && !empty($wdata['business_id']) ){
            $whereCond['business_id'] = $wdata['business_id'];
        }
        if(isset($wdata['order_status']) && !empty($wdata['order_status'])){
            $tempArr = explode('|', $wdata['order_status']);
            $whereCond['order_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        $list = Db::table('opf_auction_order')->alias('auction')
            ->where($whereCond)
            ->field('auction.*')
            ->order('auction.order_id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opf_auction_order')->alias('auction')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list);
        }
        
        $result = array(
            'count' => $count,
            'data' => $list
        );
        
        return $result;
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        foreach ($data as $key => $val) {
            isset($data[$key]['order_intime']) ? $data[$key]['order_intime_tag'] = fd_checktime($data[$key]['order_intime']) : '';
            isset($data[$key]['order_outtime']) ? $data[$key]['order_outtime_tag'] = fd_checktime($data[$key]['order_outtime']) : '';
        }
        
        return $data;
    }

    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($requestData = array(), $operateData = array(), $exchange = true)
    {
        $wdata = array();
        if (isset($requestData['order_id']) && ! empty($requestData['order_id'])) {
            $wdata['o.order_id'] = $requestData['order_id'];
        }
        $row = Db::table('opf_auction_order')->alias('o')
            ->join('opf_auction_order_detail od', 'od.order_id = o.order_id', 'INNER')
            ->where($wdata)
            ->find();
        
        if (! empty($row) && $exchange === true) {
            // 优化数据结构
            $order_detail['detail_stuff_type'] = $row['detail_stuff_type'];
            $order_detail['detail_stuff_id'] = $row['detail_stuff_id'];
            $order_detail['detail_num'] = $row['detail_num'];
            $order_detail['detail_broker_price'] = $row['detail_broker_price'];
            $order_detail['detail_deposit_price'] = $row['detail_deposit_price'];
            $order_detail['detail_youhui_price'] = $row['detail_youhui_price'];
            $order_detail['detail_integral_price'] = $row['detail_integral_price'];
            $order_detail['detail_freight_price'] = $row['detail_freight_price'];
            $order_detail['detail_integral'] = $row['detail_integral'];
            $order_detail['detail_goods_price'] = $row['detail_goods_price'];
            $order_detail['detail_goods_attr_value'] = $row['detail_goods_attr_value'];
            $order_detail['detail_goods_attr_str'] = $row['detail_goods_attr_str'];
            $order_detail['detail_goods_name'] = $row['detail_goods_name'];
            $order_detail['detail_goods_thumb'] = $row['detail_goods_thumb'];
            $order_detail['detail_goods_sn'] = $row['detail_goods_sn'];
            $row = fd_delArrElesByKey('detail_', $row);
            $row['order_detail'][] = $order_detail;
            
            $row = $this->parseRowData($row);
        }
        
        return $row;
    }

    /**
     * @function 解析详情数据
     * @author ljx
     */
    private function parseRowData($row)
    {
        $row['order_status_tag'] = $this->order_status_tags[$row['order_status']];
        if (isset($row['order_address_info'])) {
            $row['order_address_info'] = unserialize($row['order_address_info']);
        }
        
        return $row;
    }
}
