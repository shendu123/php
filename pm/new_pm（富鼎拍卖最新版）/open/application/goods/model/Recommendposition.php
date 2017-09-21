<?php

/**
 * @class 推荐区域模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Recommendposition extends Model
{

    protected $table = 'opg_recommend_position';

    public $_tableFields = array(
        'id' => 'int', // 推荐区域自增id
        'pos_oprid' => 'int', // 操作者id
        'pos_name' => 'varchar', // 推荐区域名称
        'pos_code' => 'varchar', // 推荐区域码 唯一
        'pos_status' => 'int', // 是否启用 0启用 1不启用
        'pos_app_type' => 'int', // 0app 1pc 2微信
        'pos_remarks' => 'varchar', // 备注
        'pos_intime' => 'int', // 创建时间
        'pos_uptime' => 'int' /*更新时间**/
	);
    // 应用名称
    public $pos_app_type = array(
        0 => 'app',
        1 => 'pc',
        2 => '微信',
    );
    // 状态
    public $pos_status = array(
        0 => '启用',
        1 => '不启用'
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['pos_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['pos_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['pos_oprid'] = $operateData['user']['user_id'];
        if ($this->save($fields)) {
            return $this->id;
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
        $fields['pos_uptime'] = $_SERVER['REQUEST_TIME'];
        $wdata = array(
            'id' => $fields['id']
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
     *        
     * @param integer $wdata['keyword'] 搜索关键字 匹配区域名
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        if (! empty($wdata['keyword'])) {
            $whereCond['pos_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        if (! empty($wdata['ids'])) {
            $whereCond['id'] = array(
                'in',
                $wdata['ids']
            );
        }
        
        $list = Db::table('opg_recommend_position')->where($whereCond)
            ->order('id desc')
            ->select();
        $count = $this->where($whereCond)->count();
        
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
            $data[$key]['pos_intime_tag'] = date('Y-m-d H:i', $val['pos_intime']);
            $data[$key]['pos_uptime_tag'] = date('Y-m-d H:i', $val['pos_uptime']);
            
            isset($data[$key]['pos_app_type']) ? $data[$key]['pos_app_type_tag'] = $this->pos_app_type[$val['pos_app_type']] : '';
            isset($data[$key]['pos_status']) ? $data[$key]['pos_status_tag'] = $this->pos_status[$val['pos_status']] : '';
        }
        
        return $data;
    }

    /**
     * @function 删除
     * @author ljx
     *        
     * @param integer $wdata['id'] id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $wdata['ids']
        );
        return Db::table('opg_recommend_position')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opg_recommend_position')->where('id',$wdata['id'])->find();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowByName($wdata = array(), $operateData = array()){
        return Db::table('opg_recommend_position')->where('pos_name',$wdata['pos_name'])->find();
    }
}
