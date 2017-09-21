<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 余额充值订单模型
 * @author ljx
 */
class RechargeOrder extends Model
{

    protected $table = 'opf_recharge_order';

    public $_tableFields = array(
        'order_id' => 'int', // 保证金id
        'order_code' => 'varchar', // 订单号(按规则统一生成唯一)
        'order_name' => 'varchar', // 订单名称
        'user_id' => 'int', // 订单所属买家id
        'order_amount_price' => 'int', // 【单位分】订单总额(未做任何扣除)
        'order_paytotal_price' => 'int', // 【单位分】用户支付总额
        'order_youhui_price' => 'int', // 【单位分】订单优惠总额
        'order_integral' => 'int', // 结算时抵扣积分总数
        'order_integral_price' => 'int', // 【单位分】结算时积分抵扣总额
        'order_selfintegral_price' => 'int', // 【单位分】【对总订单】结算时积分抵扣金额
        'order_selfintegral' => 'int', // 【对总订单】结算时抵扣积分数
        'order_selfyouhui_price' => 'int', // 【单位分】【对总订单】优惠金额
        'order_pay_type' => 'int', // 支付方式: 0余额支付 1微信支付 2支付宝 3银行卡 4汇潮 99其它
        'order_status' => 'int', // 订单流程状态:0待付款 1付款中 2已付款 3付款失败 11退款中 11已退款
        'order_isdelete' => 'int', // 订单删除状态: 0正常 1已删除
        'order_deltime' => 'int', // 订单删除时间
        'order_delid' => 'int', // 订单删除操作者
        'order_paytime' => 'int', // 订单支付时间
        'order_buier_remarks' => 'varchar', // 买家留言
        'order_remarks' => 'varchar', // 订单备注
        'order_third_ordercode' => 'varchar', // 第三方单号
        'order_third_payinfo' => 'varchar', // 【序列化保存】第三方支付返回信息
        'order_intime' => 'int', // 订单生成时间
        'order_uptime' => 'int' /*订单修改时间，只要数据有变动就更新时间**/
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
        $result_service = Db::table('opf_recharge_order')->where($wdata)->delete();
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
    
        return Db::table('opf_recharge_order')->where($wdata)->field($sql_fields)->find();
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
        if(isset($wdata['order_status']) && !empty($wdata['order_status'])){
            $tempArr = explode('|', $wdata['order_status']);
            $whereCond['order_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        if(!empty($wdata['start_at'] && !empty($wdata['end_at']))){
            $whereCond['order_intime'] = ['between', [$wdata['start_at'],$wdata['end_at']]];
        }
        if(!empty($wdata['keyword'])){
            $whereCond['mobile|nickname'] = ['like', '%' . $wdata['keyword'] . '%'];
        }

        $list = Db::table('opf_recharge_order')->alias('recharge')
            ->where($whereCond)
            ->field('recharge.*')
            ->order('recharge.order_id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opf_recharge_order')->alias('recharge')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list, $wdata);
        }
        
        $result = array(
            'total' => $count,
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
    private function parseListData($data = array(), $wdata = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }

        $interactionTool = new \app\finance\model\Interaction();
        $wdata_intTool = array(
            'accesstoken' => $wdata['accesstoken'],
			'keyword' => $wdata['keyword']
        );
        //$userList = $interactionTool->getUserInfos($data, 'user_id', $wdata_intTool);
        
        foreach ($data as $key => $val) {
//			if(!isset($userList[$val['user_id']])){
//				continue;
//			}
//            $data[$key]['buyer_info'] = $userList[$val['user_id']];
			
            isset($data[$key]['order_intime']) ? $data[$key]['order_intime_tag'] = fd_checktime($data[$key]['order_intime']) : '';
            isset($data[$key]['order_outtime']) ? $data[$key]['order_outtime_tag'] = fd_checktime($data[$key]['order_outtime']) : '';
        }
        
        return $data;
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opf_recharge_order')->where($wdata)->find();
    }
}
