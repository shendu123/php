<?php

/**
 * @class 推荐区域模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Goodsrecommend extends Model
{

    protected $table = 'opg_goods_recommend';

    public $_tableFields = array(
        'id' => 'int', // 推荐表自增id
        'rec_oprid' => 'int', // 推荐操作者id
        'business_id' => 'int', // 商户id
        'rec_stuff_type' => 'int', // 业务类型 0纯粹商品 【11-20auction业务用】11:竞价 12拍卖 13vip 14专场 15拍卖会 【21-30crowd业务用】21申购
        'rec_stuff_id' => 'int', // 业务id stuff_type:0:goods.id; stuff_type:11-20:auction.id; stuff_type:21-30:crowd.id
        'rec_pos_id' => 'int', // 推荐区域 关联recommend_position.id
        'rec_opr_remarks' => 'varchar', // 推荐操作备注
        'rec_sort' => 'int', // 推荐排序值 值越大排越前
        'rec_status' => 'int', // 推荐状态 0上架 1下架
        'rec_statustime' => 'int', // 状态变更时间
        'rec_starttime' => 'int', // 推荐开始时间
        'rec_endtime' => 'int', // 推荐结束时间
        'rec_intime' => 'int', // 创建时间
        'rec_uptime' => 'int' /*更新时间**/
	);
    // 应用名称
    public $rec_stuff_type = array(
        0 => '商品',
        11 => '竞价',
        12 => '拍卖',
        13 => 'vip',
        14 => '专场',
        15 => '拍卖会',
        21 => '申购',
    );
    
    // 状态
    public $rec_status = array(
        0 => '已上架',
        1 => '已下架'
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        isset($requestData['business_id']) ? $business_id = $requestData['business_id'] : $business_id = $operateData['business']['business_id'];
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['rec_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['rec_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['rec_oprid'] = $operateData['user']['user_id'];
        $fields['business_id'] = $business_id;
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
        $fields['rec_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['rec_oprid'] = $operateData['user']['user_id'];
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
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        if (! empty($wdata['keyword'])) {
            $whereCond['rec_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        
        // 上下架状态
        if (! empty($wdata['onsale'])) {
            $tempArr = explode('|', $wdata['onsale']);
            $whereCond['rec_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        $list = Db::table('opg_goods_recommend')->where($whereCond)
            ->order('id desc')
            ->select();
        $count = $this->where($whereCond)->count();
        
        if ($exchange === true) {
            $operateData_parse = $operateData;
            $operateData_parse['accesstoken'] = $wdata['accesstoken'];
            $list = $this->parseListData($list, $operateData_parse);
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
    private function parseListData($data = array(), $operateData = array())
    {
        // data - business
        $business_arr = array_unique(array_column($data, 'business_id'));
        $business_ids_string = implode(',', $business_arr);
        $postData = array(
            'inid' => $business_ids_string
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $operateData['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array)$businessData;
        
        // data - member
        $member_arr_oprid = array_column($data, 'rec_oprid');
        $member_arr = array_merge((array) $member_arr_oprid);
        $member_arr = array_filter(array_unique($member_arr));
        
        $member_ids_string = implode(',', $member_arr);
        $postData = array(
            'inid' => $member_ids_string
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $operateData['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array)$memberData;
        
        // data - business service; etc: crowd or goods or auction
        // split crowd auction and so on
        $serviceDataList = array();
        foreach($data as $key => $val){
            if($val['rec_stuff_type'] >= 10 && $val['rec_stuff_type'] <= 20){
                $serviceDataList['auction'][] = $val;
            }else if($val['rec_stuff_type'] >= 21 && $val['rec_stuff_type'] <= 30){
                $serviceDataList['crowd'][] = $val;
            }else if($val['rec_stuff_type'] >= 31 && $val['rec_stuff_type'] <= 40){
                $serviceDataList['item'][] = $val;
            }
        }
        
        $serviceData_crowd = $serviceData_auction = array();
        if(isset($serviceDataList['crowd']) && !empty($serviceDataList['crowd'])){
            $service_arr_crowd = array_column($serviceDataList['crowd'], 'rec_stuff_id');
            $service_arr_crowd = array_filter(array_unique($service_arr_crowd));
            $service_ids_string = implode(',', $service_arr_crowd);
        
            $serviceData_crowd = curl_get_content(config("crowd_api_url") . "Admin/getList?ids=" . $service_ids_string, 0, "", $operateData['accesstoken']);
            $serviceData_crowd = object_array($serviceData_crowd);
            $serviceData_crowd = $serviceData_crowd['data'];
        }
        
        if(isset($serviceDataList['auction']) && !empty($serviceDataList['auction'])){
            $service_arr_auction = array_column($serviceDataList['auction'], 'rec_stuff_id');
            $service_arr_auction = array_filter(array_unique($service_arr_auction));
            $service_ids_string = implode(',', $service_arr_auction);
        
            $serviceData_auction = curl_get_content(config("auction_api_url") . "Admin/getList?ids=" . $service_ids_string, 0, "", $operateData['accesstoken']);
            $serviceData_auction = object_array($serviceData_auction);
            $serviceData_auction = $serviceData_auction['data'];
        }
		
		 if(isset($serviceDataList['item']) && !empty($serviceDataList['item'])){
            $service_arr_item = array_column($serviceDataList['item'], 'rec_stuff_id');
            $service_arr_item = array_filter(array_unique($service_arr_item));
            $service_ids_string = implode(',', $service_arr_item);
        
            $serviceData_item = curl_get_content(config("item_api_url") . "Admin/index?page_type='unlimited'&ids=" . $service_ids_string, 0, "", $operateData['accesstoken']);
            $serviceData_item = object_array($serviceData_item);
            $serviceData_item = $serviceData_item['data'];
        }
        
        $positionCon = new \app\goods\controller\Recposition();
        
        foreach ($data as $key => $val) {
            isset($data[$key]['rec_intime']) ? $data[$key]['rec_intime_tag'] = date('Y-m-d H:i', $val['rec_intime']) : '';
            isset($data[$key]['rec_uptime']) ? $data[$key]['rec_uptime_tag'] = date('Y-m-d H:i', $val['rec_uptime']) : '';
            isset($data[$key]['rec_starttime']) ? $data[$key]['rec_starttime_tag'] = date('Y-m-d H:i', $val['rec_starttime']) : '';
            isset($data[$key]['rec_endtime']) ? $data[$key]['rec_endtime_tag'] = date('Y-m-d H:i', $val['rec_endtime']) : '';
            isset($data[$key]['rec_statustime']) ? $data[$key]['rec_statustime_tag'] = date('Y-m-d H:i', $val['rec_statustime']) : '';
            
            isset($data[$key]['rec_app_type']) ? $data[$key]['rec_app_type_tag'] = $this->rec_app_type[$val['rec_app_type']] : '';
            isset($data[$key]['rec_status']) ? $data[$key]['rec_status_tag'] = $this->rec_status[$val['rec_status']] : '';
            
            // 业务_申购
            if(($val['rec_stuff_type'] >= 21 && $val['rec_stuff_type'] <= 30) && !empty($serviceData_crowd)){
                foreach($serviceData_crowd as $key_in => $val_in){
                    if($val['rec_stuff_id'] == $val_in['id']){
                        $data[$key]['service'] = $val_in;
                    }
                }
            }
            // 业务_拍卖
            if(($val['rec_stuff_type'] >= 10 && $val['rec_stuff_type'] <= 20) && !empty($serviceData_auction)){
                foreach($serviceData_auction as $key_in => $val_in){
                    if($val['rec_stuff_id'] == $val_in['id']){
                        $data[$key]['service'] = $val_in;
                    }
                }
            }
			
			// 业务_自由买卖
            if(($val['rec_stuff_type'] >= 31 && $val['rec_stuff_type'] <= 40) && !empty($serviceData_item)){
                foreach($serviceData_item as $key_in => $val_in){
                    if($val['rec_stuff_id'] == $val_in['id']){
                        $data[$key]['service'] = $val_in;
                    }
                }
            }
            
            // 商户
            foreach ($businessData as $key_in => $val_in) {
                if ($val['business_id'] == $val_in['business_id']) {
                    $data[$key]['owner']['business'] = $val_in;
                    break;
                }
            }
            // 用户
            foreach ($memberData as $key_in => $val_in) {
                // 操作人
                if ($val['rec_oprid'] == $val_in['uid']) {
                    $data[$key]['operator'] = $val_in;
                }
            }
            // data - recommend position
            $params = array(
                'ids' => $val['rec_pos_id']
            );
            $recPosInfo = $positionCon->getList($params);
            $data[$key]['rec_pos_info'] = $recPosInfo['data'];
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
        return Db::table('opg_goods_recommend')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opg_goods_recommend')->where('id',$wdata['id'])->find();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowByName($wdata = array(), $operateData = array()){
        return Db::table('opg_goods_recommend')->where('rec_name',$wdata['pos_name'])->find();
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
            'rec_status' => $wdata['value'],
            'rec_oprid' => $operateData['user']['user_id'],
            'rec_statustime' => $_SERVER['REQUEST_TIME']
        );
        return Db::table('opg_goods_recommend')->where($whereCond)->update($fields);
    }
}
