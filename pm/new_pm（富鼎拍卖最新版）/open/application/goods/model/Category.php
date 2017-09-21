<?php

/**
 * @class 商品分类模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Category extends Model
{

    protected $table = 'opg_goods_category';

    public $_tableFields = array(
        'id' => 'int', // 分类ID
        'cat_pid' => 'int', // 上级ID
        'cat_name' => 'varchar', // 分类名称
        'cat_oprid' => 'int', // 操作者id
        'cat_icon' => 'varchar', // 分类图标
        'cat_recomend' => 'int', // 0不推荐，1推荐
        'cat_sort' => 'int', // 排序值
        'cat_remarks' => 'varchar', // 备注
        'cat_disable' => 'int', // 0启用，1禁用
        'cat_distime' => 'int', // 禁用/启用时间
        'cat_intime' => 'int', // 创建时间
        'cat_uptime' => 'int', /*更新时间**/
		'is_show' => 'int'
	);

    /**
     * @function 新增分类
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['cat_distime'] = $_SERVER['REQUEST_TIME']; // 启用/禁用时间
        $fields['cat_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['cat_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['cat_oprid'] = $operateData['user']['user_id'];
		$fields['business_id'] = $operateData['sysid'] == 1 ? 0 : $operateData['business']['business_id']; 		
        if ($this->save($fields)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 编辑分类
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['cat_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['cat_oprid'] = $operateData['user']['user_id'];
		$fields['business_id'] = $operateData['sysid'] == 1 ? 0 : $operateData['business']['business_id']; 	
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
     * @function 分类列表
     * @author ljx
     *
     * @param integer $exchange 是否转换数据
     */
    public function getList($condition , $exchange = true) {
		$where = [];
		if($condition['sysid'] !=1 ){
			$where['business_id'] = $condition['user']['business']['business_id'];
		}
        $list = Db::name("goods_category")->where($where)->select();

        if ($exchange === true) {
            $list = $this->parseListData($list);
        }

		foreach($list as $k=>$v){
			$list[$k]['goods_count'] = Db::table('opg_goods')->where(['cat_id'=>$v['id']])->count();
		}
        return $list;
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
            $data[$key]['cat_icon'] = array(
                array(
                    'file_path' => $val['cat_icon'],
                    'url' => $val['cat_icon']
                )
            );
            $data[$key]['cat_recomend_tag'] = $val['cat_recomend'] ? '是' : '否';
            $data[$key]['cat_disable_tag'] = $val['cat_disable'] ? '禁用' : '启用';
            $data[$key]['cat_distime_tag'] = date('Y-m-d H:i', $val['cat_distime']);
            $data[$key]['cat_intime_tag'] = date('Y-m-d H:i', $val['cat_intime']);
            $data[$key]['cat_uptime_tag'] = date('Y-m-d H:i', $val['cat_uptime']);
        }
        
        return $data;
    }

    /**
     * @function 删除商品分类
     * @author ljx
     *        
     * @param string $wdata['ids'] ids MUST 1,2,3
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $wdata['ids']
        );
        return Db::table('opg_goods_category')->where($whereCond)->delete();
    }

    /**
     * @function 启用禁用
     * @author ljx
     *        
     * @param string $wdata['ids'] ids MUST 1,2,3
     * @param integer $wdata['value'] cat_disable值 0启用，1禁用
     */
    public function ableAll($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $wdata['ids']
        );
        $fields = array(
            'cat_disable' => $wdata['value'],
            'cat_oprid' => $operateData['user']['user_id'],
            'cat_distime' => $_SERVER['REQUEST_TIME']
        );
        return Db::table('opg_goods_category')->where($whereCond)->update($fields);
    }
}
