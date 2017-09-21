<?php

/**
 * @class 商品详情模型
 * @author ljx
 * @uses 该模型依赖于商品主表模型
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Goodsdetail extends Model
{

    protected $table = 'opg_goods_detail';

    public $_tableFields = array(
        'goods_id' => 'int', // 商品ID
        'goods_filtrate' => 'varchar', // 筛选条件id集合
        'goods_keywords' => 'varchar', // 商品关键字
        'goods_desc' => 'varchar', // 商品描述
        'goods_province' => 'int', // 操作者id
        'goods_city' => 'int', // 商品名称
        'goods_area' => 'int', // 商品标题
        'goods_pictures' => 'varchar', // 1实物 0虚拟【预留】
        'goods_content' => 'varchar' /* 商品修改时间**/
	);
    // 详情表只提供三个方法,不提供查询//
    /**
     * @function 新增商品详情
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        return $this->save(parseRequestData($this->_tableFields, $requestData));
    }

    /**
     * @function 编辑商品详情
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $wdata = array(
            'goods_id' => $requestData['goods_id']
        );
        
        return $this->save(parseRequestData($this->_tableFields, $requestData), $wdata);
    }

    /**
     * @function 删除商品详情
     *
     * @author ljx
     */
    public function delete($requestData = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $requestData['goods_ids']
        );
        return Db::table('opg_goods_detail')->where($whereCond)->delete();
    }
}
