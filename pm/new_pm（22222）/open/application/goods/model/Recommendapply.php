<?php

/**
 * @class 推荐申请模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Recommendapply extends Model
{

    protected $table = 'opg_recommend_apply';

    public $_tableFields = array(
        'id' => 'int', // 申请自增id
        'apply_stuff_type' => 'int', // 业务类型 0纯粹商品 【10-20auction业务用】10:竞价 11拍卖 12vip 13专场 14拍卖会 【21-30crowd业务用】21申购
        'business_id' => 'int', // 商户id
        'apply_oprid' => 'int', // 推荐申请发起人id
        'apply_status' => 'int', // 申请状态 0待审核 1审核通过 2审核失败
        'apply_checkid' => 'int', // 推荐审核人id
        'apply_check_reason' => 'varchar', // 申请推荐审核原因
        'apply_stuff_id' => 'int', // 申请推荐业务id stuff_type:0:goods.id; stuff_type:10-20:auction.id; stuff_type:21-30:crowd.id
        'apply_pos_ids' => 'varchar', // 申请推荐区域 关联recommend_position.id
        'apply_remarks' => 'varchar', // 申请备注
        'apply_checktime' => 'int', // 审核时间
        'apply_starttime' => 'int', // 申请推荐开始时间
        'apply_endtime' => 'int', // 申请推荐结束时间
        'apply_intime' => 'int', // 创建时间
        'apply_uptime' => 'int' /*更新时间**/
	);
    // 应用名称
    public $apply_stuff_type = array(
        0 => '商品',
        10 => '竞价',
        11 => '拍卖',
        12 => 'vip',
        13 => '专场',
        14 => '拍卖会',
        21 => '申购',
    );
    
    // 申请状态
    public $apply_status = array(
        0 => '待审核',
        1 => '审核通过',
        2 => '审核失败'
    );

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['apply_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['apply_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['apply_oprid'] = $operateData['user']['user_id'];
        $fields['business_id'] = $operateData['business']['business_id'];
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
        $fields['apply_uptime'] = $_SERVER['REQUEST_TIME'];
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
            $whereCond['apply_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }

        // 审核状态
        if (! empty($wdata['check'])) {
            $tempArr = explode('|', $wdata['check']);
            $whereCond['apply_status'] = array(
                "{$tempArr[0]}",
                "{$tempArr[1]}"
            );
        }
        
        $list = Db::table('opg_recommend_apply')->where($whereCond)
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
        $member_arr_oprid = array_column($data, 'apply_oprid');
        $member_arr_checkid = array_column($data, 'apply_checkid');
        $member_arr = array_merge((array) $member_arr_oprid, (array) $member_arr_checkid);
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
            if($val['apply_stuff_type'] >= 10 && $val['apply_stuff_type'] <= 20){
                $serviceDataList['auction'][] = $val;
            }else if($val['apply_stuff_type'] >= 21 && $val['apply_stuff_type'] <= 30){
                $serviceDataList['crowd'][] = $val;
            }else if($val['apply_stuff_type'] >= 31 && $val['apply_stuff_type'] <= 40){
                $serviceDataList['item'][] = $val;
            }			
        }
        
        $serviceData_crowd = $serviceData_auction = $service_arr_item= array();
		//申购
        if(isset($serviceDataList['crowd']) && !empty($serviceDataList['crowd'])){
            $serviceData_crowd = $this->getCurlData($serviceDataList['crowd'],config("crowd_api_url"),$operateData);
        }
        //拍卖
        if(isset($serviceDataList['auction']) && !empty($serviceDataList['auction'])){
            $serviceData_auction = $this->getCurlData($serviceDataList['auction'],config("auction_api_url"),$operateData);
        }
		//自由买卖
		if(isset($serviceDataList['item']) && !empty($serviceDataList['item'])){
			$serviceData_item = $this->getCurlData($serviceDataList['item'],config("item_api_url"),$operateData);
        }

        $positionCon = new \app\goods\controller\Recposition();
        
        foreach ($data as $key => $val) {
            isset($data[$key]['apply_checktime']) ? $data[$key]['apply_checktime_tag'] = fd_checktime($data[$key]['apply_checktime']) : '';
            isset($data[$key]['apply_intime']) ? $data[$key]['apply_intime_tag'] = fd_checktime($data[$key]['apply_intime']) : '';
            isset($data[$key]['apply_uptime']) ? $data[$key]['apply_uptime_tag'] = fd_checktime($data[$key]['apply_uptime']) : '';
            isset($data[$key]['apply_starttime']) ? $data[$key]['apply_starttime_tag'] = fd_checktime($data[$key]['apply_starttime']) : '';
            isset($data[$key]['apply_endtime']) ? $data[$key]['apply_endtime_tag'] = fd_checktime($data[$key]['apply_endtime']) : '';
            isset($data[$key]['apply_app_type']) ? $data[$key]['apply_app_type_tag'] = $this->apply_app_type[$val['apply_app_type']] : '';
            isset($data[$key]['apply_status']) ? $data[$key]['apply_status_tag'] = $this->apply_status[$val['apply_status']] : '';
            
            // 业务_申购
            if(($val['apply_stuff_type'] >= 21 && $val['apply_stuff_type'] <= 30) && !empty($serviceData_crowd)){
                foreach($serviceData_crowd as $key_in => $val_in){
                    if($val['apply_stuff_id'] == $val_in['id']){
                        $data[$key]['service'] = $val_in;
                    }
                }
            }
            // 业务_拍卖
            if(($val['apply_stuff_type'] >= 10 && $val['apply_stuff_type'] <= 20) && !empty($serviceData_auction)){
                foreach($serviceData_auction as $key_in => $val_in){
                    if($val['apply_stuff_id'] == $val_in['id']){
                        $data[$key]['service'] = $val_in;
                    }
                }
            }
			
			// 业务_自由买卖
            if(($val['apply_stuff_type'] >= 31 && $val['apply_stuff_type'] <= 40) && !empty($serviceData_item)){
                foreach($serviceData_item as $key_in => $val_in){
                    if($val['apply_stuff_id'] == $val_in['id']){
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
                // 申请人
                if ($val['apply_oprid'] == $val_in['uid']) {
                    $data[$key]['operator'] = $val_in;
                }
            
                // 审核人
                if ($val['apply_checkid'] == $val_in['uid']) {
                    $data[$key]['checker'] = $val_in;
                }
            }
            // data - recommend position
            $params = array(
                'ids' => $val['apply_pos_ids']
            );
            $recPosInfo = $positionCon->getList($params);
            $data[$key]['rec_pos_info'] = $recPosInfo['data'];
        }

        return $data;
    }
	
	public function getCurlData($data,$api,$operateData){
		$service_arr_crowd = array_column($data, 'apply_stuff_id');
		$service_ids_string = implode(',', $service_arr_crowd);
		$serviceData_crowd = curl_get_content($api . "Admin/index?page_type='unlimited'&ids=" . $service_ids_string, 0, "", $operateData['accesstoken']);
		$serviceData_crowd = object_array($serviceData_crowd);
		return $serviceData_crowd['data'];
		
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
        return Db::table('opg_recommend_apply')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opg_recommend_apply')->where('id',$wdata['id'])->find();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRowByName($wdata = array(), $operateData = array()){
        return Db::table('opg_recommend_apply')->where('apply_name',$wdata['pos_name'])->find();
    }

    /**
     * @function 审核
     * @author ljx
     *        
     * @param integer $wdata['id'] crowd Id
     * @param integer $wdata['crowd_check'] crowd crowd_check值 1审核成功 2审核失败
     * @param string @wdata['reason'] crowd crowd_check_reason 审核失败原因 当value值为2时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        $wdata['apply_checkid'] = $operateData['user']['user_id'];
        $wdata['apply_checktime'] = $_SERVER['REQUEST_TIME'];
        
        return Db::table('opg_recommend_apply')->where('id', $wdata['id'])->update($wdata);
    }
}
