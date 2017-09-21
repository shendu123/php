<?php

/**
 * @class 商品模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;
use app\goods\model\Goodsdetail;

class Goods extends Model
{

    protected $table = 'opg_goods';

    public $_tableFields = array(
        'id' => 'int', // 商品ID
        'cat_id' => 'int', // 商品分类id
        'business_id' => 'int', // 商户id
        'member_id' => 'int', // 商品所属用户id
        'goods_oprid' => 'int', // 操作者id
        'goods_name' => 'varchar', // 商品名称
        'goods_title' => 'varchar', // 商品标题
        'goods_is_real' => 'int', // 1实物 0虚拟【预留】
        'goods_price' => 'int', // 商品价格
        'brand_id' => 'int', // 品牌id 新goods_brand.id【预留】
        'unit_id' => 'int', // 单位id 新goods_unit.id【预留】
        'goods_unit' => 'int', // 商品单位名称
        'goods_thumb' => 'int', // 封面图
        'goods_status' => 'int', // 状态0正常
        'goods_is_delete' => 'int', // 1删除0正常
        'goods_deltime' => 'int', // 删除时间
        'goods_intime' => 'int', // 商品创建时间
        'goods_uptime' => 'int' /* 商品修改时间**/
	);

    /**
     * @function 商品列表
     * @author ljx
     *        
     * @param array $wdata 列表查询条件
     * @param integer $wdata['ids'] 多个商品id 用逗号隔开
     * @param string $wdata['cat_ids'] 1,5,11 多个分类组合时，以逗号隔开
     * @param integer $wdata['business_id']
     * @param $integer wdata['member_id']
     * @param $integer wdata['keyword'] 匹配goods_name 或 goods_title
     * @param $integer wdata['goods_is_delete'] 商品是否已删除
     * @param string $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        
        if (isset($wdata['goods_is_delete'])) {
            $whereCond['g.goods_is_delete'] = $wdata['goods_is_delete'];
        } else {
            $whereCond['g.goods_is_delete'] = 0;
        }
        if (! empty($wdata['ids'])) {
            $whereCond['g.id'] = array(
                'in',
                $wdata['ids']
            );
        }
        if ($wdata['sysid'] != 1) {//非总部平台
            $whereCond['g.business_id'] = $wdata['business_id'];
        }
        if (! empty($wdata['member_id'])) {
            $whereCond['g.member_id'] = $wdata['member_id'];
        }
        if (! empty($wdata['cat_ids'])) {
            $whereCond['g.cat_id'] = array(
                'in',
                $wdata['cat_ids']
            );
        }
        if (! empty($wdata['keyword'])) {
            $whereCond['g.goods_name|g.goods_title'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        
        $dataObj = Db::table('opg_goods')->alias('g');
        $dataList = $dataObj->join('opg_goods_category cat', 'cat.id = g.cat_id', 'LEFT')
            ->join('opg_goods_brand brand', 'brand.id = g.brand_id', 'LEFT')
            ->where($whereCond)
            ->field('g.*,cat.cat_name,brand.brand_name')
            ->order('g.id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opg_goods')->alias('g')
            ->join('opg_goods_category cat', 'cat.id = g.cat_id', 'LEFT')
            ->join('opg_goods_brand brand', 'brand.id = g.brand_id', 'LEFT')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $dataList = $this->parseListData($dataList);
        }
        
        $result = array(
            'total' => $count,
            'data' => $dataList
        );
        
        return $result;
    }

    /**
     * @function 获取商品详情
     * @author ljx
     *        
     * @param integer $wdata['id']
     * @param boolean $exchange
     */
    public function getRow($wdata = array(), $exchange = true)
    {
        $whereCond['g.id'] = $wdata['id'];
        
        $dataObj = Db::table('opg_goods')->alias('g');
        $rowData = $dataObj->join('opg_goods_detail gd', 'gd.goods_id = g.id', 'INNER')
            ->join('opg_goods_category cat', 'cat.id = g.cat_id', 'LEFT')
            ->join('opg_goods_brand brand', 'brand.id=g.brand_id', 'LEFT')
			->join('opg_goods_gallery ga', 'ga.goods_id = g.id', 'LEFT')	
            ->where($whereCond)
            ->field('g.*,ga.gallery_pic_url,cat.cat_name,brand.brand_name,gd.goods_id,gd.goods_filtrate,gd.goods_keywords,gd.goods_desc,gd.goods_province,gd.goods_city,gd.goods_area,gd.goods_pictures,gd.goods_content')
            ->limit('0,1')
            ->select();
        
        if (! empty($rowData)) {
            $rowData = $rowData[0];
            if ($exchange === true) {
                $rowData = $this->parseDetailData($rowData);
            }
            //$rowData['goods_content'] = htmlspecialchars_decode($rowData["goods_content"]);
            // TODO 轮播图转换
            
            return $rowData;
        } else {
            return;
        }
    }

    /**
     * @function 详情数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseDetailData($row)
    {
        if (empty($row)) {
            return $row;
        }
		//价格处理（把分转化为元）
		$row=array_merge($row,$this->priceHandle($row,true));
        $row['goods_thumb'] = array(
            array(
                'file_path' => $row['goods_thumb'],
                'url' => $row['goods_thumb']
            )
        );

        $goods_pictures = explode(',', $row['goods_pictures']);
        $temp = array();
        foreach($goods_pictures as $key => $val){
            $temp[$key] = array(
                'file_path' => $val,
                'url' => $val
            );
        }
		
		$gallery_pic_url = explode(',', $row['gallery_pic_url']);
        $gallery_pic = array();
        foreach($gallery_pic_url as $key => $val){
            $gallery_pic[$key] = array(
                'file_path' => $val,
                'url' => $val
            );
        }
        
        $row['goods_pictures'] = $temp;
		$row['gallery_pic_url'] = $gallery_pic;
        $row['goods_intime_tag'] = $row['goods_intime'] > 0 ? date('Y-m-d H:i', $row['goods_intime']) : '';
        $row['goods_uptime_tag'] = $row['goods_uptime'] > 0 ? date('Y-m-d H:i', $row['goods_uptime']) : '';
        
        return $row;
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
            $data[$key]['goods_thumb'] = array(
                array(
                    'file_path' => $val['goods_thumb'],
                    'url' => $val['goods_thumb']
                )
            );
            
            // 时间解析
            isset($data[$key]['goods_intime']) ? $data[$key]['goods_intime_tag'] = date('Y-m-d H:i', $val['goods_intime']) : '';
            isset($data[$key]['goods_uptime']) ? $data[$key]['goods_uptime_tag'] = date('Y-m-d H:i', $val['goods_uptime']) : '';
			
			//价格处理（把分转化为元）
			$data[$key]=array_merge($val,$this->priceHandle($val,true));
        }
        
        return $data;
    }

    /**
     * @function 添加商品
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     * @return integer-goods_id boolean-false
     */
    public function add($requestData = array(), $operateData = array())
    {
        // 商品主表
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['goods_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['goods_uptime'] = $_SERVER['REQUEST_TIME'];
        
        $fields['business_id'] = $operateData['business']['business_id']; // 所属商户
        $fields['member_id'] = $operateData['user']['user_id']; // 所属会员
        $fields['goods_oprid'] = $operateData['user']['user_id']; // 操作者
		$fields=array_merge($fields,$this->priceHandle($fields));
                                                                  
        // 开启事物
        Db::startTrans();
        
        // case 写商品主表
        $this->save($fields);
        $goods_id = $this->id;
        if (empty($goods_id)) {
            Db::rollback();
            return false;
        }
		$requestData['goods_id'] = $goods_id;
        
        // case 写商品详情表
        $detailModel = new Goodsdetail();
        $result_detail = $detailModel->add($requestData, $operateData);
        if (empty($result_detail)) {
            Db::rollback();
            return false;
        }
		
		// case 写商品相册
        $galleryModel = new Goodsgallery();
        $result_gallery = $galleryModel->add($requestData, $operateData);
        if (empty($result_gallery)) {
            Db::rollback();
            return false;
        }
		
        // case 写sku etc.
        
        // 提交事务
        Db::commit();
        
        return $goods_id;
    }

    /**
     * @function 编辑商品
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     * @return integer-goods_id boolean-false
     */
    public function edit($requestData = array(), $operateData = array())
    {
        // 商品主表
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['goods_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['goods_oprid'] = $operateData['user']['user_id']; // 操作者
		$fields=array_merge($fields,$this->priceHandle($fields));
        // TODO $operateData未加入
        
        // 开启事物
        Db::startTrans();
        
        // case 商品主表
        $wdata = array(
            'id' => $fields['id']
        );
        $result = $this->save($fields, $wdata);
        if ($result === false) {
            Db::rollback();
            return false;
        }
        $requestData['goods_id'] = $fields['id'];		
        // case 写商品详情表
        $detailModel = new Goodsdetail();       
        $result_detail = $detailModel->edit($requestData, $operateData);
        if ($result_detail === false) {
            Db::rollback();
            return false;
        }
		
		// case 写商品相册
        $galleryModel = new Goodsgallery();
        $result_gallery = $galleryModel->edit($requestData, $operateData);
        if ($result_gallery === false) {
            Db::rollback();
            return false;
        }
        
        // case 写sku etc.
        
        // 提交事务
        Db::commit();
        
        return true;
    }

    /**
     * @function 删除商品
     * @author ljx
     *        
     * @param integer $wdata['id'] id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        // 开启事物
        Db::startTrans();
        
        // case 商品主表
        $whereCond = array();
        $whereCond['id'] = array(
            'in',
            $wdata['ids']
        );
        
        $result = Db::table('opg_goods')->where($whereCond)->delete();
        if ($result === false) {
            Db::rollback();
            return false;
        }
        $requestData['goods_ids'] = $wdata['ids'];
        unset($wdata['ids']);		
  
        // case 商品详情表
        $detailModel = new Goodsdetail();
        $result_detail = $detailModel->delete($requestData, $operateData);
        if ($result_detail === false) {
            Db::rollback();
            return false;
        }
		
		// case 商品相册
        $galleryModel = new Goodsgallery();
        $result_gallery = $galleryModel->delete($requestData, $operateData);
        if ($result_gallery  === false) {
            Db::rollback();
            return false;
        }

        // case sku etc.
        
        // 提交事务
        Db::commit();
        
        return true;
    }
	
	/*
	 * 价格处理
	 * @param $show false入库，true展示
	 */
	public function priceHandle($tableFields,$show=false){
		$fields=[
			'goods_price',		
		];
		$data=[];
		foreach($fields as $k=>$v){
			if(!isset($tableFields[$v])){
				continue;
			}
			if(empty($tableFields[$v])){
				$data[$v]=0;
			}else{				
				$data[$v]=$show ? priceFormat( $tableFields[$v] , false):priceFormat( false , $tableFields[$v] );
			}
							
		}
		return $data;
	}
}
