<?php
namespace app\auction\model;

use think\Model;
use think\Db;

class AuctionBack extends model
{

    protected $table = 'opa_auction';

    private $_tableFields = array(
        'id' => 'int', // 拍卖id
        'goods_id' => 'int', // 商品id
        'member_id' => 'int', // 商品所属用户id
        'business_id' => 'int', // 商户id
        'auction_oprid' => 'int', // 操作者id
        'auction_publishid' => 'int', // 发布人
        'auction_checkid' => 'int', // 审核人
        'auction_code' => 'varchar', // 拍品编号
        'auction_name' => 'varchar', // 拍卖名称
        'auction_bidcount' => 'int', // 出价次数
        'auction_attend_count' => 'int', // 想拍人数
        'auction_mode' => 'int', // 拍卖模式 新系统10竞价 11拍卖 12VIP 13专场 14拍卖会
        'auction_type' => 'int', // 拍卖类型0竞拍1竞价
        'auction_succtype' => 'int', // 成交模式0普通模式1即时成交
        'auction_check_status' => 'int', // 拍卖审核状态：0待审核 1审核通过 2审核失败
        'auction_flow_status' => 'int', // 拍卖状态流：0, 10正常 11已成交 12流拍 13撤拍
        'auction_reason' => 'varchar', // 审核失败原因
        'auction_adjust_status' => 'int', // 拍卖订单调整：0新增，1降价
        'auction_sort' => 'int', // 拍卖会排序
        'auction_succ_price' => 'decimal', // 即时成交价格
        'auction_freight_price' => 'decimal', // 运费
        'auction_onset_price' => 'decimal', // 起拍价
        'auction_reserve_price' => 'decimal', // 保留价
        'auction_now_price' => 'decimal', // 当前价
        'auction_broker_type' => 'int', // 佣金收取方式:新系统0定额
        'auction_broker_price' => 'decimal', // 佣金
        'auction_seller_price' => 'decimal', // 卖家保证金
        'auction_buier_price' => 'decimal', // 买家保证金
        'auction_stepsize_type' => 'int', // 价格浮动方式 0阶梯递增至高位
        'auction_stepsize_price' => 'decimal', // 价格浮动金额幅度
        'auction_attenderid' => 'int', // 当前出价人id
        'auction_apply_stuff' => 'varchar', // 卖家申请材料,以||分隔
        'auction_pledge_type' => 'int', // 【预留】旧pledge_type 保证金冻结方式
        'auction_starttime' => 'int', // 拍卖开始时间
        'auction_endtime' => 'int', // 拍卖结束时间
        'auction_intime' => 'int', // 插入时间
        'auction_uptime' => 'int' /* 更新时间*/
    );
    
    // 拍卖审核状态标签 0待审核 1审核通过 2审核失败
    private $auction_check_status = array(
        0 => '待审核',
        1 => '审核通过',
        2 => '审核失败'
    );
    
    // 拍卖状态流标签 0 10正常 11已成交 12流拍 13撤拍
    private $auction_flow_status = array(
        0 => '',
        10 => '正常',
        11 => '已成交',
        12 => '流拍',
        13 => '撤拍'
    );
    
    // 拍卖审核状态标签 0普通模式 1即时成交
    private $auction_succtype = array(
        0 => '普通模式',
        1 => '即时成交'
    );

    /**
     * @function 拍卖列表
     * @author ljx
     *        
     * @param array $wdata 列表查询条件 $wdata条件组合都是以AND连接
     * @param integer $wdata['id'] 拍卖id
     * @param integer $wdata['goods_id'] 商品id
     * @param integer $wdata['business_id'] 商户id
     * @param integer $wdata['member_id'] 商品所属用户id
     * @param integer $wdata['operator_id'] 操作者id
     * @param integer $wdata['publish_id'] 发布者id
     *        --暂不支持--@param integer $wdata['succtype'] 成交模式 0普通模式1即时成交
     * @param string $wdata['mode'] 拍卖模式 赋值格式为 '运算符,状态值' 例如： 'eq|1' 或 'neq|1' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['check_status'] 拍卖审核状态 赋值格式为 '运算符,状态值' 例如： 'eq|0' 或 'neq|0' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['flow_status'] 拍卖状态流 赋值格式为 '运算符,状态值' 例如： 'eq|10' 或 'neq|10' 支持 运算符gt、egt、lt、elt、in、not in
     * @param string $wdata['keyword'] 搜索关键字 匹配 auction_code 或 auction_name
     * @param string $wdata['start_from_time'] $wdata['start_to_time'] 拍卖开始时间搜索区间 标准时间格式字符串 例如 2017-05-08 【不支持时分秒】
     * @param string $wdata['end_from_time'] $wdata['end_to_time'] 拍卖结束时间搜索区间 例如 2017-05-08 【不支持时分秒】
     * @param integer $wdata['page'] 第几页
     * @param integer $wdata['pageSize'] 页宽
     *       
     * @param boolean $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        
        // 商品id
        if (! empty($wdata['goods_id'])) {
            $whereCond['a.goods_id'] = $wdata['goods_id'];
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
            $whereCond['a.id'] = array(
                'in',
                $wdata['ids']
            );
        }
        // 商户id
        if (! empty($wdata['business_id']) && $wdata['sysid'] != 1) {
            $whereCond['a.business_id'] = $wdata['business_id'];
        }
        // 商品所属用户id
        if (! empty($wdata['member_id'])) {
            $whereCond['a.member_id'] = $wdata['member_id'];
        }
        // 操作者id
        if (! empty($wdata['operator_id'])) {
            $whereCond['a.auction_oprid'] = $wdata['operator_id'];
        }
        // 发布者id
        if (! empty($wdata['publish_id'])) {
            $whereCond['a.auction_publishid'] = $wdata['publish_id'];
        }
        // 成交模式
        if (isset($wdata['succtype'])) {
            // $whereCond['a.auction_succtype'] = $wdata['succtype'];
        }
        // 拍卖模式
        if (! empty($wdata['mode'])) {
            $tempArr = explode('|', $wdata['mode']);
            $whereCond['a.auction_mode'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        // 拍卖状态流
        if (! empty($wdata['flow_status'])) {
            $tempArr = explode('|', $wdata['flow_status']);
            $whereCond['a.auction_flow_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        // 拍卖审核状态
        if (! empty($wdata['check_status'])) {
            $tempArr = explode('|', $wdata['check_status']);
            $whereCond['a.auction_check_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        // 搜索关键字
        if (! empty($wdata['keyword'])) {
            $whereCond['a.auction_code|a.auction_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        
        $year_m = date('Y-m', time());
        
        // 拍卖开始时间搜索区间
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
                ;
            }
            
            if ($wdata['start_from_time'] > $wdata['start_to_time']) {
                $wdata['start_from_time'] = 0;
            }
            
            $whereCond['a.auction_starttime'] = array(
                'between',
                "{$wdata['start_from_time']},{$wdata['start_to_time']}"
            );
        }
        
        // 拍卖结束时间搜索区间
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
            
            $whereCond['a.auction_endtime'] = array(
                'between',
                "{$wdata['end_from_time']},{$wdata['end_to_time']}"
            );
        }
        
        $dataObj = Db::table('opa_auction')->alias('a');
        $dataList = $dataObj->where($whereCond)
            ->field('a.*')
            ->order('a.id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opa_auction')->alias('a')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $dataList = $this->parseListData($dataList, $wdata);
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
    private function parseListData($data = array(), $wdata = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }        
        foreach ($data as $key => $val) {
			//价格处理（把分转化为元）
			$data[$key]=array_merge($val,$this->priceHandle($val,true));
            // 卖家审核资料图片完善资源路径
            if (! empty($val['auction_apply_stuff'])) {
                $data[$key]['auction_apply_stuff'] = array(
                    array(
                        'file_path' => $val['auction_apply_stuff'],
                        'url' => $val['auction_apply_stuff']
                    )
                );
            }			
            // 拍卖状态流标签
            isset($data[$key]['auction_flow_status']) ? $data[$key]['auction_flow_status_tag'] = $this->auction_flow_status[$val['auction_flow_status']] : '';
            // 拍卖审核状态标签
            isset($data[$key]['auction_check_status']) ? $data[$key]['auction_check_status_tag'] = $this->auction_check_status[$val['auction_check_status']] : '';
            // 成交模式标签
            isset($data[$key]['auction_succtype']) ? $data[$key]['auction_succtype_tag'] = $this->auction_succtype[$val['auction_succtype']] : '';
            
            // 时间解析
            isset($data[$key]['auction_starttime']) ? $data[$key]['auction_starttime_tag'] = timeFmt($data[$key]['auction_starttime']) : '';
            isset($data[$key]['auction_endtime']) ? $data[$key]['auction_endtime_tag'] = timeFmt($data[$key]['auction_endtime']) : '';
            isset($data[$key]['auction_intime']) ? $data[$key]['auction_intime_tag'] = timeFmt($data[$key]['auction_intime']) : '';
            isset($data[$key]['auction_uptime']) ? $data[$key]['auction_uptime_tag'] = timeFmt($data[$key]['auction_uptime']) : '';
        }
        
        // auction - goods
        $goods_arr = array_column($data, 'goods_id');
        $goods_ids_string = implode(',', $goods_arr);
        $goodsData = curl_get_content(config("goods_api_url") . "goods/index?ids=" . $goods_ids_string, 0, "", $wdata['accesstoken']);
        $goodsData = object_array($goodsData);
        $goodsData = $goodsData['data'];
        
        // auction - business
        $business_arr = array_unique(array_column($data, 'business_id'));
        $business_ids_string = implode(',', $business_arr);
        $postData = array(
            'inid' => $business_ids_string
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array) $businessData;
        
        // auction - member
        $member_arr_ownerid = array_column($data, 'member_id');
        $member_arr_oprid = array_column($data, 'auction_oprid');
        $member_arr_publishid = array_column($data, 'auction_publishid');
        $member_arr_attenderid = array_column($data, 'auction_attenderid');
        $member_arr_checkid = array_column($data, 'auction_checkid');
        $member_arr = array_merge((array) $member_arr_ownerid, (array) $member_arr_oprid, (array) $member_arr_publishid, (array) $member_arr_attenderid, (array) $member_arr_checkid);
        $member_arr = array_filter(array_unique($member_arr));
        
        $member_ids_string = implode(',', $member_arr);
        $postData = array(
            'inid' => $member_ids_string
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;
        
        // 数据关联
        foreach ($data as $key_out => $val_out) {
            // 商品
            foreach ($goodsData as $key_in => $val_in) {
                if ($val_out['goods_id'] == $val_in['id']) {
                    $data[$key_out]['goods_info'] = $val_in;
                    break;
                }
            }
            // 商户
            foreach ($businessData as $key_in => $val_in) {
                if (isset($val_in['business_id']) && $val_out['business_id'] == $val_in['business_id']) {
                    $data[$key_out]['owner']['business'] = $val_in;
                    break;
                }
            }
            // 用户
            foreach ($memberData as $key_in => $val_in) {
                // 所属人
                if (isset($val_in['uid']) && $val_out['member_id'] == $val_in['uid']) {
                    $data[$key_out]['owner']['member'] = $val_in;
                }
                // 操作者
                if (isset($val_in['uid']) && $val_out['auction_oprid'] == $val_in['uid']) {
                    $data[$key_out]['operator'] = $val_in;
                }
                
                // 审核人
                if (isset($val_in['uid']) && $val_out['auction_checkid'] == $val_in['uid']) {
                    $data[$key_out]['checker'] = $val_in;
                }
                
                // 发布人
                if (isset($val_in['uid']) && $val_out['auction_publishid'] == $val_in['uid']) {
                    $data[$key_out]['publisher'] = $val_in;
                }
                
                // 当前出价人
                if (isset($val_in['uid']) && $val_out['auction_attenderid'] == $val_in['uid']) {
                    $data[$key_out]['attender'] = $val_in;
                }
            }
        }
        
        return $data;
    }
    
    /**
     * @function 列表数据解析
     * @author ljx
     *
     * @param array $data 待解析的数据
     */
    private function parseDetailData($data = array(), $wdata = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
    
        foreach ($data as $key => $val) {
			//价格处理（把分转化为元）
			$data[$key]=array_merge($val,$this->priceHandle($val,true));
            // 卖家审核资料图片完善资源路径
            if (! empty($val['auction_apply_stuff'])) {
                $data[$key]['auction_apply_stuff'] = array(
                    array(
                        'file_path' => $val['auction_apply_stuff'],
                        'url' => $val['auction_apply_stuff']
                    )
                );
            }			
            // 拍卖状态流标签
            isset($data[$key]['auction_flow_status']) ? $data[$key]['auction_flow_status_tag'] = $this->auction_flow_status[$val['auction_flow_status']] : '';
            // 拍卖审核状态标签
            isset($data[$key]['auction_check_status']) ? $data[$key]['auction_check_status_tag'] = $this->auction_check_status[$val['auction_check_status']] : '';
            // 成交模式标签
            isset($data[$key]['auction_succtype']) ? $data[$key]['auction_succtype_tag'] = $this->auction_succtype[$val['auction_succtype']] : '';
    
            // 时间解析
            isset($data[$key]['auction_starttime']) ? $data[$key]['auction_starttime_tag'] = timeFmt($data[$key]['auction_starttime']) : '';
            isset($data[$key]['auction_endtime']) ? $data[$key]['auction_endtime_tag'] = timeFmt($data[$key]['auction_endtime']) : '';
            isset($data[$key]['auction_intime']) ? $data[$key]['auction_intime_tag'] = timeFmt($data[$key]['auction_intime']) : '';
            isset($data[$key]['auction_uptime']) ? $data[$key]['auction_uptime_tag'] = timeFmt($data[$key]['auction_uptime']) : '';
        }
    
        // auction - goods
        $goods_arr = array_column($data, 'goods_id');
        $goods_ids_string = implode(',', $goods_arr);
        $goodsData = curl_get_content(config("goods_api_url") . "goods/detail?id=" . $goods_ids_string, 0, "", $wdata['accesstoken']);
        $goodsData = object_array($goodsData);
        $goodsData = $goodsData['data'];
    
        // auction - business
        $business_arr = array_unique(array_column($data, 'business_id'));
        $business_ids_string = implode(',', $business_arr);
        $postData = array(
            'inid' => $business_ids_string
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array) $businessData;
    
        // auction - member
        $member_arr_ownerid = array_column($data, 'member_id');
        $member_arr_oprid = array_column($data, 'auction_oprid');
        $member_arr_publishid = array_column($data, 'auction_publishid');
        $member_arr_attenderid = array_column($data, 'auction_attenderid');
        $member_arr_checkid = array_column($data, 'auction_checkid');
        $member_arr = array_merge((array) $member_arr_ownerid, (array) $member_arr_oprid, (array) $member_arr_publishid, (array) $member_arr_attenderid, (array) $member_arr_checkid);
        $member_arr = array_filter(array_unique($member_arr));
    
        $member_ids_string = implode(',', $member_arr);
        $postData = array(
            'inid' => $member_ids_string
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array) $memberData;
    
        // 数据关联
        foreach ($data as $key_out => $val_out) {
            // 商品
            $data[$key_out]['goods_info'] = $goodsData;
            // 商户
            foreach ($businessData as $key_in => $val_in) {
                if ( isset($val_in['business_id']) &&  $val_out['business_id'] == $val_in['business_id']) {
                    $data[$key_out]['owner']['business'] = $val_in;
                    break;
                }
            }
            // 用户
            foreach ($memberData as $key_in => $val_in) {
                // 所属人
                if (isset($val_in['uid']) && $val_out['member_id'] == $val_in['uid']) {
                    $data[$key_out]['owner']['member'] = $val_in;
                }
                // 操作者
                if (isset($val_in['uid']) && $val_out['auction_oprid'] == $val_in['uid']) {
                    $data[$key_out]['operator'] = $val_in;
                }
    
                // 审核人
                if (isset($val_in['uid']) && $val_out['auction_checkid'] == $val_in['uid']) {
                    $data[$key_out]['checker'] = $val_in;
                }
    
                // 发布人
                if (isset($val_in['uid']) && $val_out['auction_publishid'] == $val_in['uid']) {
                    $data[$key_out]['publisher'] = $val_in;
                }
    
                // 当前出价人
                if (isset($val_in['uid']) && $val_out['auction_attenderid'] == $val_in['uid']) {
                    $data[$key_out]['attender'] = $val_in;
                }
            }
        }
    
        return $data;
    }

    /**
     * @function auction审核
     * @author ljx
     *        
     * @param integer $wdata['id'] auction Id
     * @param integer $wdata['value'] auction auctoin_flow_status值 1审核成功 2审核失败
     * @param string @wdata['reason'] auction auction_reason 审核失败原因 当value值为2时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        $wdata['auction_checkid'] = $operateData['user']['user_id'];
        if ($wdata['auction_check_status'] == 1) {
            // TODO 审核通过不一定马上发布
            $wdata['auction_publishid'] = $operateData['user']['user_id'];
            $wdata['auction_flow_status'] = 10;
        }
        
        return Db::table('opa_auction')->where('id', $wdata['id'])->update($wdata);
    }

    /**
     * @function auction详情
     * @author ljx
     *         不从getList获取 TODO 需要优化
     */
    public function getRow($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        
        // 拍卖id
        $whereCond['a.id'] = $wdata['id'];
        
        $dataObj = Db::table('opa_auction')->alias('a');
        $dataList = $dataObj->where($whereCond)
            ->field('a.*')
            ->select();
        
        if (! empty($dataList)) {
            
            if ($exchange === true) {
                $dataList = $this->parseDetailData($dataList, $wdata);
            }
            
            return $dataList[0];
        } else {
            return;
        }
    }

    /**
     * @function 删除auction
     * @author ljx
     *        
     * @param integer $wdata['id'] auction id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        return Db::table('opa_auction')->where('id', $wdata['id'])->delete();
    }

    /**
     * @function 添加auction
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['auction_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['auction_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['auction_oprid'] = $operateData['user']['user_id']; // 操作者
        $fields['member_id'] = $operateData['user']['user_id']; // 所有者
        $fields['business_id'] = $operateData['business']['business_id']; // 操作者
        $fields=array_merge($fields,$this->priceHandle($fields));	
        $this->save($fields);
        if ($this->id) {
            return $this->id;
        } else {
            return false;
        }
    }

    /**
     * @function 编辑auction
     * @author ljx
     *        
     * @param array $requestData 表单信息
     * @param array $operateData 操作者相关信息
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['auction_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['auction_oprid'] = $operateData['user']['user_id'];
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
	
	/*
	 * 价格处理
	 */
	public function priceHandle($tableFields,$show=false){
		$fields=[
			'auction_succ_price',
			'auction_freight_price',
			'auction_onset_price',
			'auction_reserve_price',
			'auction_now_price',
			'auction_broker_price',
			'auction_seller_price',
			'auction_buier_price',
			'auction_stepsize_price'
			
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
	
	/**
     * @function auction上架下架
     * @author ljx
     *        
     * @param integer $wdata['id'] auction Id
     * @param integer $wdata['value'] auction auction_onsale值 1上架 2下架
     * @param string @wdata['reason'] auction auction_onsale_reason 下架原因
     */
    public function setOnsale($wdata = array(), $operateData = array())
    {		
		$clist=Db::table('opa_auction')->where(['id'=>['in',$wdata['id']]])->field('auction_check_status,auction_starttime,auction_endtime')->select();
		foreach($clist as $k=>$cinfo){
			//审核通过并且即将开始或正在拍卖的商品才能强制上/下架
			$whereIf=($cinfo['auction_check_status']==1)&&(($cinfo['auction_starttime']>time())||($cinfo['auction_starttime']<=time()&&$cinfo['auction_endtime']>=time()));
			if(!$whereIf){
				return  ['status'=>0,'msg'=>'条件不符，不能强制上下架'];
			}
		}
		//批量上下架
		if(Db::table('opa_auction')->where(['id'=>['in',$wdata['id']]])->update(['auction_onsale'=>$wdata['auction_onsale']])){
			 return ['status'=>1];
		 }else{
			 return ['status'=>0,'msg'=>'更新数据库失败'];
		 }		        
    }
}
