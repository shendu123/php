<?php

/**
 * @class 商品品牌模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Brand extends Model
{

    protected $table = 'opg_goods_brand';

    public $_tableFields = array(
        'id' => 'int', // 商品品牌ID
        'brand_name' => 'varchar', // 名称
        'cat_id' => 'int', // 所属分类
        'brand_upid' => 'int', // 上级品牌id
        'brand_oprid' => 'int', // 操作者id
        'brand_icon' => 'varchar', // 品牌图标
        'brand_remarks' => 'varchar', // 备注
        'brand_intime' => 'int', // 创建时间
        'brand_uptime' => 'int' /*更新时间**/
	);

    /**
     * @function 新增品牌
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['brand_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['brand_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['brand_oprid'] = $operateData['user']['user_id'];
        if ($this->save($fields)) {
            return $this->id;
        } else {
            return false;
        }
    }

    /**
     * @function 编辑品牌
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['brand_uptime'] = $_SERVER['REQUEST_TIME'];
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
     * @function 品牌列表
     * @author ljx
     *        
     * @param integer $wdata['keyword'] 搜索关键字 匹配品牌名
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        
        if (! empty($wdata['cat_id'])) {
            $whereCond['b.cat_id'] = $wdata['cat_id'];
        }
        
        if (! empty($wdata['keyword'])) {
            $whereCond['b.brand_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }

        $list = Db::table('opg_goods_brand')->alias('b')
            ->join('opg_goods_category cat', 'cat.id = b.cat_id', 'LEFT')
            ->where($whereCond)
            ->field('b.*,cat.cat_name')
            ->order('b.id desc')
            ->select();
        
        $count = Db::table('opg_goods_brand')->alias('b')
            ->join('opg_goods_category cat', 'cat.id = b.cat_id', 'LEFT')
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
            /**
             * $data[$key]['brand_icon'] = array(
             * array(
             * 'file_path' => $val['brand_icon'],
             * 'url' => $val['brand_icon']
             * )
             * );
             */
            $data[$key]['brand_intime_tag'] = date('Y-m-d H:i', $val['brand_intime']);
            $data[$key]['brand_uptime_tag'] = date('Y-m-d H:i', $val['brand_uptime']);
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
        return Db::table('opg_goods_brand')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opg_goods_brand')->where('id',$wdata['id'])->find();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowByName($wdata = array(), $operateData = array()){
        return Db::table('opg_goods_brand')->where('brand_name',$wdata['brand_name'])->find();
    }
}
