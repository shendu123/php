<?php
namespace app\crowd\model;

use think\Model;
use think\Db;
use app\crowd\library\Util;

class CrowdBack extends model
{

    protected $table = 'opc_crowd';

    private $_tableFields = array(
        'id' => 'int', // 申购id
        'goods_id' => 'int', // 商品id
        'business_id' => 'int', // 商户id
        'crowd_oprid' => 'int', // 操作者id
        'crowd_publishid' => 'int', // 发布人
        'crowd_checkid' => 'int', // 审核人
        'crowd_code' => 'varchar', // 申购编号【统一生成编号】
        'crowd_name' => 'varchar', // 申购名称或标题
        'crowd_total' => 'int', // 申购总量
        'crowd_consume' => 'int', // 已申购数量
        'crowd_check' => 'int', // 申购审核：0待审核 1审核通过 2审核失败
        'crowd_check_reason' => 'varchar', // 审核失败原因
        'crowd_onsale' => 'int', // 申购上架 0未上架 1已上架 2已下架
        'crowd_onsale_reason' => 'varchar', // 申购下架原因
        'crowd_price' => 'decimal', // 申购价格 注意与商品本身价格的区别
        'crowd_broker_price' => 'decimal', // 佣金 平台与商家线下协商
        'crowd_seller_price' => 'decimal', // 卖家保证金
        'crowd_starttime' => 'int', // 申购开始时间
        'crowd_endtime' => 'int', // 申购结束时间
        'crowd_intime' => 'int', // 插入时间
        'crowd_uptime' => 'int', /* 更新时间*/
		'crowd_sort' => 'int', /* 申购排序*/
		'crowd_inventory' => 'int'/*申购库存*/		
    );
    
    // 申购审核状态标签 0待审核 1审核通过 2审核失败
    private $crowd_check = array(
        0 => '待审核',
        1 => '审核通过',
        2 => '审核失败'
    );
    
    // 申购上下架状态标签0未上架 1已上架 2已下架
    private $crowd_onsale = array(
        0 => '未上架',
        1 => '已上架',
        2 => '已下架'
    );

    /**
     * @function 申购列表
     * @author ljx
     *        
     * @param array $wdata 列表查询条件 $wdata条件组合都是以AND连接
     * @param integer $wdata['id'] 申购id
     * @param integer $wdata['goods_id'] 商品id
     * @param integer $wdata['business_id'] 商户id
     * @param integer $wdata['operator_id'] 操作者id
     * @param integer $wdata['publish_id'] 发布者id
     * @param string $wdata['check'] 申购审核 赋值格式为 '运算符,状态值' 例如： 'eq|1' 或 'neq|1' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['onsale'] 申购上下架 赋值格式为 '运算符,状态值' 例如： 'eq|1' 或 'neq|1' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['keyword'] 搜索关键字 匹配 crowd_code 或 crowd_name
     * @param string $wdata['start_from_time'] $wdata['start_to_time'] 申购开始时间搜索区间 标准时间格式字符串 例如 2017-05-08 【不支持时分秒】
     * @param string $wdata['end_from_time'] $wdata['end_to_time'] 申购结束时间搜索区间 标准时间格式字符串 例如 2017-05-08 【不支持时分秒】
     * @param integer $wdata['page'] 第几页
     * @param integer $wdata['pageSize'] 页宽
     *       
     * @param boolean $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
		
		switch($wdata['type']){
			case 'crowding'://正在申购
				$whereCond['c.crowd_starttime']=['elt',time()];
				$whereCond['c.crowd_endime']=['egt',time()];
				break;
			case 'future'://即将申购
				$whereCond['c.crowd_starttime']=['gt',time()];
				break;
			case 'crowdend'://已结束申购
				$whereCond['c.crowd_endime']=['lt',time()];
				break;
			default :
				break;
				
		}
        
        // 商品id
        if (! empty($wdata['goods_id'])) {
            $whereCond['c.goods_id'] = $wdata['goods_id'];
        }
        // TODO 根据商品名称搜索 需要跨库
        if (! empty($wdata['goods_name'])) {
        /**
         * $whereCond['g.goods_name|g.goods_title'] = array(
         * 'like',
         * "%{$wdata['goods_name']}%"
         * );
         */
        }
        
        // 多个ids
        if (! empty($wdata['ids'])) {
            $whereCond['c.id'] = array(
                'in',
                $wdata['ids']
            );
        }
        
        // 商户id
        if (! empty($wdata['business_id']) && $wdata['sysid'] != 1) {
            $whereCond['c.business_id'] = $wdata['business_id'];
        }
        // 操作者id
        if (! empty($wdata['operator_id'])) {
            $whereCond['c.crowd_oprid'] = $wdata['operator_id'];
        }
        // 发布者id
        if (! empty($wdata['publish_id'])) {
            $whereCond['c.crowd_publishid'] = $wdata['publish_id'];
        }
        // 申购审核状态
        if (! empty($wdata['check'])) {
            $tempArr = explode('|', $wdata['check']);
            $whereCond['c.crowd_check'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        // 申购上下架状态
        if (! empty($wdata['onsale'])) {
            $tempArr = explode('|', $wdata['onsale']);
            $whereCond['c.crowd_onsale'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        // 搜索关键字
        if (! empty($wdata['keyword'])) {
            $whereCond['c.crowd_code|c.crowd_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        
        $year_m = date('Y-m', time());
        
        // 申购开始时间搜索区间
        if (! empty($wdata['start_from_time']) || ! empty($wdata['start_to_time'])) {
            if (empty($wdata['start_from_time'])) {
                $wdata['start_from_time'] = strtotime($year_m . '-01 00:00:00');
            } else {
                $wdata['start_from_time'] = strtotime($wdata['start_from_time']);
            }
            if (empty($wdata['start_to_time'])) {
                $wdata['start_to_time'] = strtotime($year_m . date("t") . ' 23:59:59');
            } else {
                $wdata['start_to_time'] = strtotime($wdata['start_to_time']) + 86400 - 1;
            }
            
            if ($wdata['start_from_time'] > $wdata['start_to_time']) {
                $wdata['start_from_time'] = 0;
            }
            
            $whereCond['c.crowd_starttime'] = array(
                'between',
                "{$wdata['start_from_time']},{$wdata['start_to_time']}"
            );
        }
        
        // 申购结束时间搜索区间
        if (! empty($wdata['end_from_time']) || ! empty($wdata['end_to_time'])) {
            if (empty($wdata['end_from_time'])) {
                $wdata['end_from_time'] = strtotime($year_m . '-01 00:00:00');
            } else {
                $wdata['end_from_time'] = strtotime($wdata['end_from_time']);
            }
            if (empty($wdata['end_to_time'])) {
                $wdata['end_to_time'] = strtotime($year_m . date("t") . ' 23:59:59');
            } else {
                $wdata['end_to_time'] = strtotime($wdata['end_to_time']) + 86400 - 1;
            }
            
            if ($wdata['end_from_time'] > $wdata['end_to_time']) {
                $wdata['end_from_time'] = 0;
            }
            
            $whereCond['c.crowd_endtime'] = array(
                'between',
                "{$wdata['end_from_time']},{$wdata['end_to_time']}"
            );
        }
        
        $dataObj = Db::table('opc_crowd')->alias('c');
        $dataList = $dataObj->where($whereCond)
            ->field('c.*')
            ->order('c.id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opc_crowd')->alias('c')
            ->where($whereCond)
            ->count();       
        
        if (! empty($dataList)) {
            
            if ($exchange === true) {
                $dataList = $this->parseListData($dataList);
            }
            
            // crowd - goods
            $goods_arr = array_column($dataList, 'goods_id');
            $goods_ids_string = implode(',', $goods_arr);
            $goodsData = curl_get_content(config("goods_api_url") . "goods/index?ids=" . $goods_ids_string, 0, "", $wdata['accesstoken']);
            $goodsData = object_array($goodsData);
            $goodsData = $goodsData['data'];
            
            // crowd - business
            $business_arr = array_unique(array_column($dataList, 'business_id'));
            $business_ids_string = implode(',', $business_arr);
            $postData = array(
                'inid' => $business_ids_string
            );
            $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
            $businessData = object_array($businessData);
            $businessData = (array) $businessData;
            
            // crowd - member
            $member_arr_oprid = array_column($dataList, 'crowd_oprid');
            $member_arr_publishid = array_column($dataList, 'crowd_publishid');
            $member_arr_checkid = array_column($dataList, 'crowd_checkid');
            $member_arr = array_merge((array) $member_arr_oprid, (array) $member_arr_publishid, (array) $member_arr_checkid);
            $member_arr = array_filter(array_unique($member_arr));
            
            $member_ids_string = implode(',', $member_arr);
            $postData = array(
                'inid' => $member_ids_string
            );
            $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
            $memberData = object_array($memberData);
            $memberData = (array) $memberData;
            
            // 数据关联
            foreach ($dataList as $key_out => $val_out) {
                // 商品
                foreach ($goodsData as $key_in => $val_in) {
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
                    if (isset($val_in['uid']) && $val_out['crowd_oprid'] == $val_in['uid']) {
                        $dataList[$key_out]['operator'] = $val_in;
                    }
                    
                    // 审核人
                    if (isset($val_in['uid']) && $val_out['crowd_checkid'] == $val_in['uid']) {
                        $dataList[$key_out]['checker'] = $val_in;
                    }
                    
                    // 发布人
                    if (isset($val_in['uid']) && $val_out['crowd_publishid'] == $val_in['uid']) {
                        $dataList[$key_out]['publisher'] = $val_in;
                    }
                }
            }
        }
        
        $result = array(
            'total' => $count,
            'data' => $dataList
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
             * 该字段预留
             * // 卖家审核资料图片完善资源路径
             * if (! empty($val['crowd_apply_stuff'])) {
             * $data[$key]['crowd_apply_stuff'] = explode("||", $val["crowd_apply_stuff"]);
             * foreach ($data[$key]['crowd_apply_stuff'] as $key_in => $val_in) {
             * $data[$key]['crowd_apply_stuff'][$key_in] = config('static_url') . $val_in;
             * }
             * }
             */
			//价格处理（把分转化为元）
			$data[$key]=array_merge($val,$this->priceHandle($val,true));
            // 时间解析
            isset($data[$key]['crowd_starttime']) ? $data[$key]['crowd_starttime_tag'] = date('Y-m-d H:i', $val['crowd_starttime']) : '';
            isset($data[$key]['crowd_endtime']) ? $data[$key]['crowd_endtime_tag'] = date('Y-m-d H:i', $val['crowd_endtime']) : '';
            isset($data[$key]['crowd_intime']) ? $data[$key]['crowd_intime_tag'] = date('Y-m-d H:i', $val['crowd_intime']) : '';
            isset($data[$key]['crowd_uptime']) ? $data[$key]['crowd_uptime_tag'] = date('Y-m-d H:i', $val['crowd_uptime']) : '';
            
            // 申购审核状态标签
            isset($data[$key]['crowd_check']) ? $data[$key]['crowd_check_tag'] = $this->crowd_check[$val['crowd_check']] : '';
            
            // 申购上下架状态标签
            isset($data[$key]['crowd_onsale']) ? $data[$key]['crowd_onsale_tag'] = $this->crowd_onsale[$val['crowd_onsale']] : '';
			$data[$key]['crowd_name'] = filter_content($data[$key]['crowd_name']);
			
        }
        
        return $data;
    }

    /**
     * @function crowd审核
     * @author ljx
     *        
     * @param integer $wdata['id'] crowd Id
     * @param integer $wdata['crowd_check'] crowd crowd_check值 1审核成功 2审核失败
     * @param string @wdata['reason'] crowd crowd_check_reason 审核失败原因 当value值为2时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        $wdata['crowd_checkid'] = $operateData['user']['user_id'];
        if ($wdata['crowd_check'] == 1) {
            // TODO 审核通过不一定马上发布
            $wdata['crowd_publishid'] = $operateData['user']['user_id'];
            $wdata['crowd_onsale'] = 1;
        }
        
        return Db::table('opc_crowd')->where('id', $wdata['id'])->update($wdata);
    }

    /**
     * @function crowd上架下架
     * @author ljx
     *        
     * @param integer $wdata['id'] crowd Id
     * @param integer $wdata['value'] crowd crowd_onsale值 1上架 2下架
     * @param string @wdata['reason'] crowd crowd_onsale_reason 下架原因
     */
    public function setOnsale($wdata = array(), $operateData = array())
    {		
		$clist=Db::table('opc_crowd')->where(['id'=>['in',$wdata['id']]])->field('crowd_check,crowd_starttime,crowd_endtime')->select();
		foreach($clist as $k=>$cinfo){
			//审核通过并且即将开始或正在申购的商品才能强制上/下架
			$whereIf=($cinfo['crowd_check']==1)&&(($cinfo['crowd_starttime']>time())||($cinfo['crowd_starttime']<=time()&&$cinfo['crowd_endtime']>=time()));
			if(!$whereIf){
				return  ['status'=>0,'msg'=>'条件不符，不能强制上下架'];
			}
		}
		//批量上下架
		if(Db::table('opc_crowd')->where(['id'=>['in',$wdata['id']]])->update(['crowd_onsale'=>$wdata['crowd_onsale']])){
			 return ['status'=>1];
		 }else{
			 return ['status'=>0,'msg'=>'更新数据库失败'];
		 }		        
    }

    /**
     * @function crowd详情
     * @author ljx
     *         不从getList获取 TODO 需要优化
     */
    public function getRow($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        
        // 拍卖id
        $whereCond['a.id'] = $wdata['id'];
        
        $dataObj = Db::table('opc_crowd')->alias('a');
        $row = $dataObj->where($whereCond)
            ->field('a.*')
            ->select();
        
        if (! empty($row)) {
            $row = $row[0];
            if ($exchange === true) {
                $row = $this->parseDetailData($row, $wdata);
            }
            return $row;
        } else {
            return;
        }
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseDetailData($data = array(), $wdata = array())
    {
        // 卖家审核资料图片完善资源路径
        if (! empty($data['crowd_apply_stuff'])) {
            $data['crowd_apply_stuff'] = array(
                array(
                    'file_path' => $val['crowd_apply_stuff'],
                    'url' => $val['crowd_apply_stuff']
                )
            );
        }
		//价格处理（把分转化为元）
		$data=array_merge($data,$this->priceHandle($data,true));
        // 时间解析
        isset($data['crowd_starttime']) ? $data['crowd_starttime_tag'] = date('Y-m-d H:i', $data['crowd_starttime']) : '';
        isset($data['crowd_endtime']) ? $data['crowd_endtime_tag'] = date('Y-m-d H:i', $data['crowd_endtime']) : '';
        isset($data['crowd_intime']) ? $data['crowd_intime_tag'] = date('Y-m-d H:i', $data['crowd_intime']) : '';
        isset($data['crowd_uptime']) ? $data['crowd_uptime_tag'] = date('Y-m-d H:i', $data['crowd_uptime']) : '';
        
        // 申购审核状态标签
        isset($data['crowd_check']) ? $data['crowd_check_tag'] = $this->crowd_check[$data['crowd_check']] : '';
        
        // 申购上下架状态标签
        isset($data['crowd_onsale']) ? $data['crowd_onsale_tag'] = $this->crowd_onsale[$data['crowd_onsale']] : '';
        
		$data['crowd_name'] = filter_content($data['crowd_name']);
        // crowd - goods
        $goods_id = $data['goods_id'];
        $goodsData = curl_get_content(config("goods_api_url") . "goods/detail?id=" . $goods_id, 0, "", $wdata['accesstoken']);
        $goodsData = object_array($goodsData);
        $goodsData = $goodsData['data'];
        
        // crowd - business
        $business_id = $data['business_id'];
        $postData = array(
            'inid' => $business_id
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array) $businessData;
        
        // crowd - member
        $member_arr = array(
            $data['crowd_oprid'],
            $data['crowd_publishid'],
            $data['crowd_checkid']
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
            if (isset($val_in['uid']) && $data['crowd_oprid'] == $val_in['uid']) {
                $data['operator'] = $val_in;
            }
            
            // 审核人
            if (isset($val_in['uid']) && $data['crowd_checkid'] == $val_in['uid']) {
                $data['checker'] = $val_in;
            }
            
            // 发布人
            if (isset($val_in['uid']) && $data['crowd_publishid'] == $val_in['uid']) {
                $data['publisher'] = $val_in;
            }
        }
        
        return $data;
    }

    /**
     * @function 删除crowd
     * @author ljx
     *        
     * @param integer $wdata['id'] crowd id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        return Db::table('opc_crowd')->where('id', $wdata['id'])->delete();
    }

    /**
     * @function 编辑crowd
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['crowd_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['crowd_oprid'] = $operateData['user']['user_id'];
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
     * @function 添加crowd
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['crowd_inventory'] = $fields['crowd_total'];
        $fields['crowd_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['crowd_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['crowd_oprid'] = $operateData['user']['user_id']; // 操作者
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
			'crowd_price',
			'crowd_broker_price',
			'crowd_seller_price',
			'crowd_freight_price',			
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
