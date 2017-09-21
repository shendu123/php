<?php


namespace app\goods\model;

use think\Model;
use think\Db;
/*
 * 商品相册
 */
class Goodsgallery extends Model
{

    protected $table = 'opg_goods_gallery';

    public $_tableFields = array(
        'goods_id' => 'int', // 商品ID
        'gallery_pic_url' => 'text', //商品相册图片地址,存多张，用逗号隔开
	);
    /**
     * 新增商品相册
     */
    public function add($requestData = array(), $operateData = array())
    {
        return $this->save(parseRequestData($this->_tableFields, $requestData));
    }

    /**
     *  编辑商品相册
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $wdata = array(
            'goods_id' => $requestData['goods_id']
        );
		//如果不存在就添加
		if(!$this->where(['goods_id'=>$wdata['goods_id']])->find()){
			return $this->save(parseRequestData($this->_tableFields, $requestData)); 
		}
        //存在就修改
        return $this->save(parseRequestData($this->_tableFields, $requestData), $wdata);
    }

    /**
     *  删除商品相册
     */
    public function delete($requestData = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $requestData['goods_ids']
        );
        return Db::table('opg_goods_gallery')->where($whereCond)->delete();
    }
}
