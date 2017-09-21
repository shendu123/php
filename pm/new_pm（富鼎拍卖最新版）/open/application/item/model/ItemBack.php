<?php
namespace app\item\model;

use think\Model;
use think\Db;
use app\item\library\Util;

class ItemBack extends model
{

    protected $table = 'opi_item';

    private $_tableFields = array(
        'id' => 'int', // 自由买卖id
        'goods_id' => 'int', // 商品id
        'business_id' => 'int', // 商户id
        'item_oprid' => 'int', // 操作者id
        'item_publishid' => 'int', // 发布人
        'item_checkid' => 'int', // 审核人
        'item_code' => 'varchar', // 自由买卖编号【统一生成编号】
        'item_name' => 'varchar', // 自由买卖名称或标题
        'item_total' => 'int', // 自由买卖总量
        'item_consume' => 'int', // 已自由买卖数量
        'item_check' => 'int', // 自由买卖审核：0待审核 1审核通过 2审核失败
        'item_check_reason' => 'varchar', // 审核失败原因
        'item_onsale' => 'int', // 自由买卖上架 0未上架 1已上架 2已下架
        'item_onsale_reason' => 'varchar', // 自由买卖下架原因
        'item_price' => 'decimal', // 自由买卖价格 注意与商品本身价格的区别
        'item_intime' => 'int', // 插入时间
        'item_uptime' => 'int', /* 更新时间*/
		'item_business_cat_id'=>'int',/*商户分类id，0表示平台*/
		'item_sort' => 'int', /* 自由买卖排序*/
		'item_inventory' => 'int',/*自由买卖库存*/
		'item_is_recommend' => 'int'/*自由买卖推荐*/
    );
    
    // 自由买卖审核状态标签 0待审核 1审核通过 2审核失败
    private $item_check = array(
        0 => '待审核',
        1 => '审核通过',
        2 => '审核失败'
    );
    
    // 自由买卖上下架状态标签0未上架 1已上架 2已下架
    private $item_onsale = array(
        0 => '未上架',
        1 => '已上架',
        2 => '已下架'
    );

    /**
     * @function 自由买卖列表     
     * @param array $wdata 列表查询条件 $wdata条件组合都是以AND连接
     * @param integer $wdata['id'] 自由买卖id
     * @param integer $wdata['goods_id'] 商品id
     * @param integer $wdata['business_id'] 商户id
     * @param integer $wdata['operator_id'] 操作者id
     * @param integer $wdata['publish_id'] 发布者id
     * @param string $wdata['check'] 自由买卖审核 赋值格式为 '运算符,状态值' 例如： 'eq|1' 或 'neq|1' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['onsale'] 自由买卖上下架 赋值格式为 '运算符,状态值' 例如： 'eq|1' 或 'neq|1' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['keyword'] 搜索关键字 匹配 item_code 或 item_name
     * @param integer $wdata['page'] 第几页
     * @param integer $wdata['pageSize'] 页宽      
     * @param boolean $exchange 是否转换数据
     */
	
	public function itemList($page,$condition,$exchange=true){
		$where=[];
		if(isset($condition['keyword']) && $condition['keyword']){
			$where['item_name|item_code']=['like',"%".$condition['keyword']."%"];
		}
		//分类id
		if(isset($condition['cat_id']) && $condition['cat_id']){
			$where['g.cat_id']=$condition['cat_id'];
		}
		// 多个ids
        if (! empty($condition['ids'])) {
            $where['it.id'] = array(
                'in',
                $condition['ids']
            );
        }
		// 商户id
        if (! empty($condition['business_id']) && $condition['sysid'] != 1) {
            $where['it.business_id'] = $condition['business_id'];
        }
		// 审核状态
        if (! empty($condition['check'])) {
            $tempArr = explode('|', $condition['check']);
            $where['it.item_check'] = [$tempArr[0],$tempArr[1]];
        }
        // 上下架状态
        if (! empty($condition['onsale'])) {
            $tempArr = explode('|', $condition['onsale']);
			$where['it.item_onsale'] = [$tempArr[0],$tempArr[1]];
        }
		$dataObj = Db::table('opi_item')->alias('it');
        $dataList = $dataObj->where($where)
            ->field('it.*')
            ->order('it.id desc')
            ->limit(($page['page'] - 1) * $page['pageSize'] . ',' . $page['pageSize'])
            ->select();
        
        $count = Db::table('opi_item')->alias('it')
            ->where($where)
            ->count();
        
        if ($exchange === true) {
            $dataList = $this->parseListData($dataList);
        }
		// item - goods
		$goodsData = $this->getCurlData(config("goods_api_url") . "goods/index?ids=" . implode(',', array_column($dataList, 'goods_id')), 0, "", $condition['accesstoken']);
		// item - business
		$business_ids_string = implode(',', array_unique(array_column($dataList, 'business_id')));
		$postData = array(
			'inid' => $business_ids_string
		);
		$businessData = $this->getCurlData(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $condition['accesstoken']);
		// item - member
		$member_arr_oprid = array_column($dataList, 'item_oprid');
		$member_arr_publishid = array_column($dataList, 'item_publishid');
		$member_arr_checkid = array_column($dataList, 'item_checkid');
		$member_arr = array_merge((array) $member_arr_oprid, (array) $member_arr_publishid, (array) $member_arr_checkid);
		$member_arr = array_filter(array_unique($member_arr));
		$postData = ['inid' => implode(',', $member_arr)];
		$memberData = $this->getCurlData(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $condition['accesstoken']);
		// 数据关联
		foreach ($dataList as $key_out => $val_out) {
			// 商品
			foreach ($goodsData['data'] as $key_in => $val_in) {
				if ($val_out['goods_id'] == $val_in['id']) {
					$dataList[$key_out]['goods_info'] = $val_in;
					break;
				}
			}
			// 商户
			foreach ($businessData as $key_in => $val_in) {
				if ($val_out['business_id'] == $val_in['business_id']) {
					$dataList[$key_out]['owner']['business'] = $val_in;
					break;
				}
			}
			// 用户
			foreach ($memberData as $key_in => $val_in) {
				// 操作者
				if (isset($val_in['uid']) && $val_out['item_oprid'] == $val_in['uid']) {
					$dataList[$key_out]['operator'] = $val_in;
				}

				// 审核人
				if (isset($val_in['uid']) && $val_out['item_checkid'] == $val_in['uid']) {
					$dataList[$key_out]['checker'] = $val_in;
				}

				// 发布人
				if (isset($val_in['uid']) && $val_out['item_publishid'] == $val_in['uid']) {
					$dataList[$key_out]['publisher'] = $val_in;
				}
			}
		}
        $result = array(
            'total' => $count,
            'data' => $dataList,
			'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
        );	
		return $result;
	}
	
	private function getCurlData($url,$post=0,$postData='',$accesstoken) {
		$data = curl_get_content($url, $post, $postData, $accesstoken);
		return object_array($data);
	}


    /**
     * @function 列表数据解析
     */
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }        
        foreach ($data as $key => $val) {
			//价格处理（把分转化为元）
			$data[$key]=array_merge($val,$this->priceHandle($val,true));
            isset($data[$key]['item_intime']) ? $data[$key]['item_intime_tag'] = date('Y-m-d H:i', $val['item_intime']) : '';
            isset($data[$key]['item_uptime']) ? $data[$key]['item_uptime_tag'] = date('Y-m-d H:i', $val['item_uptime']) : '';           
            // 自由买卖审核状态标签
            isset($data[$key]['item_check']) ? $data[$key]['item_check_tag'] = $this->item_check[$val['item_check']] : '';            
            // 自由买卖上下架状态标签
            isset($data[$key]['item_onsale']) ? $data[$key]['item_onsale_tag'] = $this->item_onsale[$val['item_onsale']] : '';
			
        }
        
        return $data;
    }

    /**
     * @function item审核      
     * @param integer $wdata['id'] item Id
     * @param integer $wdata['item_check'] item item_check值 1审核成功 2审核失败
     * @param string @wdata['reason'] item item_check_reason 审核失败原因 当value值为2时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        $wdata['item_checkid'] = $operateData['user']['user_id'];
        if ($wdata['item_check'] == 1) {
            $wdata['item_publishid'] = $operateData['user']['user_id'];
            $wdata['item_onsale'] = 1;
        }
        
        return Db::table('opi_item')->where('id', $wdata['id'])->update($wdata);
    }

    /**
     * @function item上架下架   
     * @param integer $wdata['id'] item Id
     * @param integer $wdata['value'] item item_onsale值 1上架 2下架
     * @param string @wdata['reason'] item item_onsale_reason 下架原因
     */
    public function setOnsale($wdata = array(), $operateData = array())
    {		
		$clist=Db::table('opi_item')->where(['id'=>['in',$wdata['id']]])->field('item_check')->select();
		foreach($clist as $k=>$cinfo){
			//审核通过上/下架
			$whereIf=$cinfo['item_check']==1;
			if(!$whereIf){
				return  ['status'=>0,'msg'=>'条件不符，不能强制上下架'];
			}
		}
		//批量上下架
		if(Db::table('opi_item')->where(['id'=>['in',$wdata['id']]])->update(['item_onsale'=>$wdata['item_onsale']])){
			 return ['status'=>1];
		 }else{
			 return ['status'=>0,'msg'=>'更新数据库失败'];
		 }		        
    }

    /**
     * @function item详情
     */
    public function getRow($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();        
        // 拍卖id
        $whereCond['a.id'] = $wdata['id'];        
        $dataObj = Db::table('opi_item')->alias('a');
        $row = $dataObj->where($whereCond)
            ->field('a.*')
            ->select();
		if(empty($row)){
			return false;
		}
		if($exchange === true) {
			$row = $this->parseDetailData($row[0], $wdata);
		}
		return $row;
    }

    /**
     * @function 列表数据解析
     */
    private function parseDetailData($data = array(), $wdata = array())
    {
        isset($data['item_intime']) ? $data['item_intime_tag'] = date('Y-m-d H:i', $data['item_intime']) : '';
        isset($data['item_uptime']) ? $data['item_uptime_tag'] = date('Y-m-d H:i', $data['item_uptime']) : '';
        
        // 自由买卖审核状态标签
        isset($data['item_check']) ? $data['item_check_tag'] = $this->item_check[$data['item_check']] : '';
        
        // 自由买卖上下架状态标签
        isset($data['item_onsale']) ? $data['item_onsale_tag'] = $this->item_onsale[$data['item_onsale']] : '';
        //价格处理（把分转化为元）
		$data=array_merge($data,$this->priceHandle($data,true));
        // item - goods
        $goods_id = $data['goods_id'];
        $goodsData = curl_get_content(config("goods_api_url") . "goods/detail?id=" . $goods_id, 0, "", $wdata['accesstoken']);
        $goodsData = object_array($goodsData);
        $goodsData = $goodsData['data'];
        
        // item - business
        $business_id = $data['business_id'];
        $postData = array(
            'inid' => $business_id
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array) $businessData;
        
        // item - member
        $member_arr = array(
            $data['item_oprid'],
            $data['item_publishid'],
            $data['item_checkid']
        );
        $member_arr = array_filter(array_unique($member_arr));
        
        $member_ids_string = implode(',', $member_arr);
        $postData = array(
            'inid' => $member_ids_string
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;
        
        // 商品
        $data['goods_info'] = $goodsData;
        
        // 商户
        $data['owner']['business'] = !empty($businessData) ? $businessData[0] : array();
        // 用户
        foreach ($memberData as $key_in => $val_in) {
            // 操作者
            if (isset($val_in['uid']) && $data['item_oprid'] == $val_in['uid']) {
                $data['operator'] = $val_in;
            }
            
            // 审核人
            if (isset($val_in['uid']) && $data['item_checkid'] == $val_in['uid']) {
                $data['checker'] = $val_in;
            }
            
            // 发布人
            if (isset($val_in['uid']) && $data['item_publishid'] == $val_in['uid']) {
                $data['publisher'] = $val_in;
            }
        }
        
        return $data;
    }

    /**
     * @function 删除item
     */
    public function delete($wdata = array(), $operateData = array())
    {
        return Db::table('opi_item')->where('id', $wdata['id'])->delete();
    }

    /**
     * @function 编辑item
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['item_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['item_oprid'] = $operateData['user']['user_id'];
		$fields=array_merge($fields,$this->priceHandle($fields));
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
     * 添加item
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['item_inventory'] = $fields['item_total'];
        $fields['item_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['item_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['item_oprid'] = $operateData['user']['user_id']; // 操作者
        $fields['business_id'] = $operateData['business']['business_id']; // 操作者
        $fields=array_merge($fields,$this->priceHandle($fields));
        $this->save($fields);
        if ($this->id) {
            return $this->id;
        } else {
            return false;
        }
    }
	
	/*
	 * 价格处理
	 * @param $show false入库，true展示
	 */
	public function priceHandle($tableFields,$show=false){
		$fields=[
			'item_price',
			'item_freight_price',			
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
