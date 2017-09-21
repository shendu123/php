<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 积分流水模型
 * @author ljx
 */
class IntegralFlow extends Model
{

    protected $table = 'opf_integral_flow';

    public $_tableFields = array(
        'flow_id' => 'int', // 积分流水id
        'flow_code' => 'varchar', // 积分流编号
        'user_id' => 'int', // 会员id
        'flow_type' => 'int', // 0:减少 1:增加
        'flow_num' => 'int', // 积分变动数目
        'flow_integral' => 'int', // 流水生成之前的钱包积分数
        'flow_remarks' => 'varchar', // 流水描述
        'flow_intime' => 'int' /*生成流水时间**/
	);

    /**
     * @function 新增
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
     * @function 列表
     * @author ljx
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        if(isset($wdata['user_id']) && !empty($wdata['user_id'])){
            $whereCond['user_id'] = $wdata['user_id'];
        }

        $list = Db::table('opf_integral_flow')->alias('flow')
            ->where($whereCond)
            ->field('flow.*')
            ->order('flow.flow_id desc')
            ->select();
        
        $count = Db::table('opf_integral_flow')->alias('flow')
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
        return Db::table('opf_integral_flow')->where($wdata)->find();
    }
}
