<?php
namespace app\finance\model;

use think\Model;

/**
 * @class 拍卖订单详情模型
 * @author ljx
 */
class AuctionOrderDetail extends Model
{

    protected $table = 'opf_auction_order_detail';

    public $_tableFields = array(
        'order_id' => 'int', // 拍卖订单id
        'business_id' => 'int', // 订单所属商户id
        'user_id' => 'int', // 买家id
        'goods_id' => 'int', // 商品id
        'detail_stuff_type' => 'int', // 拍卖类型:10竞价 11拍卖 12VIP 13专场 14拍卖会
        'detail_stuff_id' => 'int', // 拍卖id
        'detail_num' => 'int', // 拍卖商品数量
        'detail_broker_price' => 'int', // 【单位分】卖家需缴纳佣金
        'detail_deposit_price' => 'int', // 【单位分】买家已缴纳保证金
        'detail_youhui_price' => 'int', // 【单位分】优惠金额
        'detail_integral_price' => 'int', // 【单位分】结算时积分抵扣金额
        'detail_freight_price' => 'int', // 【单位分】物流费用
        'detail_integral' => 'int', // 结算时抵扣积分数
        'detail_goods_price' => 'int', // 【单位分】买时商品单价
        'detail_goods_attr_value' => 'varchar', // 商品：买时sku
        'detail_goods_attr_str' => 'varchar', // 商品：买时sku解析后的字符串
        'detail_goods_name' => 'varchar', // 商品: 买时商品名称
        'detail_goods_sn' => 'varchar' /*商品: 买时商品序列号**/
	);

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        if ($this->save($fields)) {
            return $this->indexid;
        } else {
            return false;
        }
    }
    
    /**
     * @function 编辑
     *
     * @author ljx
     */
    public function edit($wdata = array(), $requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        
        return $this->save($fields, $wdata);
    }
    
    /**
     * @function 删除
     * @author ljx
     */
    public function delete($wdata = array(), $operateData = array()){
        return Db::table($this->table)->where($wdata)->delete();
    }
}
