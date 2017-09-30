<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 资金流水模型
 * @author ljx
 */
class FundFlow extends Model
{

    protected $table = 'opf_fund_flow';

    public $_tableFields = array(
        'flow_id' => 'int', // 资金流水id
        'flow_code' => 'varchar', // 资金流编号
        'flow_fromid' => 'int', // 流水发起端: 0系统 其它为会员id
        'flow_from_paytype' => 'int', // 支付类型: 0余额 1微信 2支付宝 3银行卡 4汇潮 99其它
        'flow_toid' => 'int', // 流水结束端: 流水结束端:-1未定义 0系统 其它为会员id
        'flow_to_paytype' => 'int', // 支付类型: -1未定义 0余额 1微信 2支付宝 3银行卡 4汇潮 99其它
        'flow_type' => 'int', // 0余额变动记录 1交易记录
        'flow_order_type' => 'int', // 订单类型: 1拍卖下单 2申购下单 3自由买卖下单 4缴纳保证金  5余额充值 6余额提现
        'flow_order_id' => 'int', // 订单id
        'flow_attach' => 'varchar', // 订单相关信息 一流水对多订单时 需要联合订单号 该字段常寸order_sn
        'flow_price' => 'int', // 【单位分】流水金额 正数为增加 负数为减少
        'flow_available_price' => 'int', // 【单位分】流水生成之前的钱包可用余额
        'flow_remarks' => 'varchar', // 流水描述
        'flow_intime' => 'int' /*生成流水时间**/
	);

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['flow_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->flow_id;
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
            'flow_id' => $fields['flow_id']
        );
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * @function 编辑
     *
     * @author ljx
     */
    public function editBy($wdata = array(), $requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 列表
     * @author ljx
     *        
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        if(isset($operateData['user']['user_id']) && !empty($operateData['user']['user_id'])){
            $whereCond['flow_fromid'] = $operateData['user']['user_id'];
        }
        
        // 0余额变动记录 1交易记录
        if (!empty($wdata['flow_type'])) {
            $whereCond['flow.flow_type'] = $wdata['flow_type'];
        }
        
        // 0余额变动记录 1交易记录
        if (!empty($wdata['flow_order_type'])) {
            $whereCond['flow.flow_order_type'] = $wdata['flow_order_type'];
        }
        //支付类型
        if(!empty($wdata['pay_type'])){
            $whereCond['flow.flow_from_paytype'] = $wdata['pay_type'];
        }
        //来源
        if(!empty($wdata['from'])){
            $whereCond['flow.flow_fromid'] = $wdata['from'];
        }
        //状态
        if(!empty($wdata['status'])){
            $whereCond['flow.flow_status'] = $wdata['status'];
        }   
        //收缩
        if(!empty($wdata['keywords'])){
            $whereCond['flow_code|flow_order_id|flow_attach'] = ['like', '%' . $wdata['keywords'] . '%'];
        }
        //查询时间范围
        if(!empty($wdata['start_at']) && !empty($wdata['end_at'])){
            $whereCond['flow_intime'] = ['>=', $wdata['start_at']];
            $whereCond['flow_intime'] = ['<=', $wdata['end_at']];
        }

        $list = Db::table('opf_fund_flow')->alias('flow')
            ->where($whereCond)
            ->field('flow.*')
            ->order('flow.flow_id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        /*     
        foreach($list as $k=>$v){
            $list[$k]['account'] = Db::table('op_basic.opb_member')->where(['uid'=>$v['']])->value('account'); 
        }
        */
        
        $count = Db::table('opf_fund_flow')->alias('flow')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list);
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
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        foreach ($data as $key => $val) {
            isset($data[$key]['flow_intime']) ? $data[$key]['flow_intime_tag'] = fd_checktime($data[$key]['flow_intime']) : '';
        }
        
        return $data;
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opf_fund_flow')->where($wdata)->find();
    }
}
