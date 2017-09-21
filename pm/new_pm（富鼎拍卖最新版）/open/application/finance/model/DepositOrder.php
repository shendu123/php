<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 保证金订单模型
 * @author ljx
 */
class DepositOrder extends Model
{

    protected $table = 'opf_deposit_order';

    public $_tableFields = array(
        'order_id' => 'int', // 保证金id
        'order_code' => 'varchar', // 订单号(按规则统一生成唯一)
        'order_name' => 'varchar', // 订单名称
        'business_id' => 'int', // 订单所属商户id
        'user_id' => 'int', // 订单所属买家id
        'address_id' => 'int', // 收货人地址id
        'order_stuff_type' => 'int', // 业务类型:0竞价保证金
        'order_stuff_id' => 'int', // 业务id: 0对应auction.id
        'order_paytotal_price' => 'int', // 【单位分】用户支付总额
        'order_pay_type' => 'int', // 支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它
        'order_status' => 'int', // 订单流程状态:0待付款 1付款中 2已付款 3付款失败 5转移成功 6释放成功 7扣除成功 11退款中 12已退款
        'order_isdelete' => 'int', // 订单删除状态: 0正常 1已删除
        'order_deltime' => 'int', // 订单删除时间
        'order_delid' => 'int', // 订单删除操作者
        'order_paytime' => 'int', // 订单支付时间
        'order_confirmid' => 'int', // 确认订单操作者id
        'order_confirm_time' => 'int', // 确认订单时间
        'order_third_ordercode' => 'int', // 第三方单号
        'order_third_payinfo' => 'int', // 【序列化保存】第三方支付返回信息
        'order_address_info' => 'varchar', // 序列化后的地址信息,防止用户修改,作为物流寄件地址
        'order_intime' => 'int', // 订单生成时间
        'order_uptime' => 'int' /*订单修改时间，只要数据有变动就更新时间**/
	);
    
    // 订单状态标签
    private $order_status_tags = array(
        '0' => '待付款',
        '1' => '付款中',
        '2' => '已付款',
        '3' => '付款失败',
        '5' => '转移成功',
        '6' => '释放成功 ',
        '7' => '扣除成功 ',
        '11' => '退款中',
        '12' => '已退款'
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['order_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['order_uptime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->order_id;
        } else {
            return false;
        }
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
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 用于编辑少量字段
     *
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
        $result_service = Db::table('opf_deposit_order')->where($wdata)->delete();
        if($result_service === false){
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
    
        return Db::table('opf_deposit_order')->where($wdata)->field($sql_fields)->find();
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
        if(isset($wdata['business_id']) && !empty($wdata['business_id'])){
            $whereCond['business_id'] = $wdata['business_id'];
        }
        if(isset($wdata['order_status']) && !empty($wdata['order_status'])){
            $tempArr = explode('|', $wdata['order_status']);
            $whereCond['order_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }

        $list = Db::table('opf_deposit_order')->alias('deposit')
            ->where($whereCond)
            ->field('deposit.*')
            ->order('deposit.order_id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opf_deposit_order')->alias('deposit')
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
    public function getRow($wdata = array(), $operateData = array(), $exchange = true){
        $row = Db::table('opf_deposit_order')->where($wdata)->find();
    
        if(!empty($row) && $exchange === true){
            $row = $this->parseRowData($row);
        }
    
        return $row;
    }
    
    /**
     * @function 解析详情数据
     * @author ljx
     */
    private function parseRowData($row){
        $row['order_status_tag'] = $this->order_status_tags[$row['order_status']];
        
        if(isset($row['order_address_info'])){
            $row['order_address_info'] = unserialize($row['order_address_info']);
        }
        
        return $row;
    }
}
