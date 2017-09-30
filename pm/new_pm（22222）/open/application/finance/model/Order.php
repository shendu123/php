<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 订单系统模型
 * @author ljx
 */
class Order extends Model
{

    protected $table = 'opf_order';

    public $_tableFields = array(
        'id' => 'int', // 订单系统id
        'order_code' => 'varchar', // 订单号(按规则统一生成唯一)
        'order_sn' => 'varchar', // 订单号(按规则统一生成唯一)
        'order_name' => 'varchar', // 订单名称
        'stuff_type' => 'int', // 业务类型 1:auction 2:crowd 3:freetrading 4:deposit 5:余额充值
        'order_id' => 'int' /*业务订单id**/
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
            return $this->id;
        } else {
            return false;
        }
    }
    
    /**
     * @function 可多次新增
     * @author ljx
     */
    public function insert($requestData = array(), $operateData = array()){
        $fields = parseRequestData($this->_tableFields, $requestData);
    
        $result = Db::name('order')->insert($fields);
        $id = Db::name('order')->getLastInsID();
        if($result === false){
            return false;
        }else{
            return $id;
        }
    }
    
    /**
     * @function 列表
     * @author ljx
     *        
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        // TODO very important
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opf_order')->where($wdata)->find();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowBy($wdata = array(), $operateData = array()){
        $whereCond = array();
        if(isset($wdata['order_code']) && !empty($wdata['order_code'])){
            // 取单条
            $whereCond = array(
                'order_code' => $wdata['order_code']
            );
            
            return Db::table('opf_order')->where($whereCond)->find();
        }elseif(isset($wdata['order_sn']) && !empty($wdata['order_sn'])){
            // 取联合
            $whereCond = array(
                'order_sn' => $wdata['order_sn']
            );
            
            return Db::table('opf_order')->where($whereCond)->select();
        }
    }
    
    /**
     * @function 删除
     * @author ljx
     */
    public function delete($wdata = array(), $operateData = array()){
        return Db::table('opf_order')->where($wdata)->delete();
    }
}
