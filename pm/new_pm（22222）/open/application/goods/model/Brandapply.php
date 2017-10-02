<?php

/**
 * @class 品牌授权申请模型
 * @author ljx
 */
namespace app\goods\model;

use think\Model;
use think\Db;

class Brandapply extends Model
{

    protected $table = 'opg_brand_apply';

    public $_tableFields = array(
        'id' => 'int', // 申请id
        'business_id' => 'int', // 商户id
        'cat_id' => 'int', // 分类id
        'apply_brand_name' => 'varchar', // 申请授权品牌名称
        'apply_checkid' => 'int', // 审核人员id
        'apply_status' => 'int', // 审核状态 0待审核 1审核通过 2审核失败
        'apply_reason' => 'varchar', // 审核失败原因
        'apply_content' => 'varchar', // 申请附加内容
        'apply_stuff' => 'varchar', // 申请资质证明 以||隔开
        'apply_checktime' => 'int', // 审核时间
        'apply_intime' => 'int', // 审核失败时间
        'apply_uptime' => 'int' /* 更新时间*/
	);

    private $apply_status = array(
        0 => '待审核',
        1 => '审核通过',
        2 => '审核失败'
    );

    /**
     * @function 新增品牌申请
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['apply_intime'] = $_SERVER['REQUEST_TIME'];
        $fields['apply_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['business_id'] = $operateData['business']['business_id'];
        if ($this->save($fields)) {
            return true;
        } else {
            return false;
        }
    }
	
	/**
     * @function 新增品牌申请
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['apply_uptime'] = $_SERVER['REQUEST_TIME'];
        $fields['business_id'] = $operateData['business']['business_id'];
        if ($this->save($fields,$fields['id'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 品牌申请列表
     * @author ljx
     *        
     * @param integer $wdata['keyword'] 搜索关键字 匹配品牌名
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $operateData = array(), $exchange = true)
    {
        $whereCond = array();
        if (! empty($wdata['keyword'])) {
            $whereCond['a.apply_brand_name'] = array(
                'like',
                "%{$wdata['keyword']}%"
            );
        }
        if ($wdata['sysid'] != 1) {//非总部平台
            $whereCond['a.business_id'] = $wdata['business_id'];
        }
        
        $dataObj = Db::table('opg_brand_apply')->alias('a');
        $list = $dataObj->join('opg_goods_category cat', 'cat.id = a.cat_id', 'LEFT')
            ->where($whereCond)
            ->field('a.*,cat.cat_name')
            ->order('a.id desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opg_brand_apply')->alias('a')
            ->join('opg_brand_apply cat', 'cat.id = a.cat_id', 'INNER')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list);
        }
        
        // brandApply - business
        $business_arr = array_unique(array_column($list, 'business_id'));
        $business_ids_string = implode(',', $business_arr);
        $postData = array(
            'inid' => $business_ids_string
        );
        $businessData = curl_get_content(config("basic_api_url") . "Util/postBusinessInfo", 1, $postData, $wdata['accesstoken']);
        $businessData = object_array($businessData);
        $businessData = (array)$businessData;

        // brandApply - member
        $member_arr_checkid = array_column($list, 'apply_checkid');
        $member_arr = array_merge((array) $member_arr_checkid);
        $member_arr = array_filter(array_unique($member_arr));
        $member_ids_string = implode(',', $member_arr);
        $postData = array(
            'inid' => $member_ids_string
        );
        $memberData = curl_get_content(config("basic_api_url") . "Util/getUserInfoByInid", 1, $postData, $wdata['accesstoken']);
        $memberData = object_array($memberData);
        $memberData = (array)$memberData;
        
        // 数据关联
        foreach ($list as $key_out => $val_out) {
            // 商户
            foreach ($businessData as $key_in => $val_in) {
                if ($val_out['business_id'] == $val_in['business_id']) {
                    $list[$key_out]['owner']['business'] = $val_in;
                    break;
                }
            }

            // 用户
            foreach ($memberData as $key_in => $val_in) {
                // 审核人
                if (isset($val_in['uid']) && $val_out['apply_checkid'] == $val_in['uid']) {
                    $list[$key_out]['checker'] = $val_in;
                }
            }
        }

        $result = array(
            'total' => $count,
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
            $data[$key]['apply_intime_tag'] = date('Y-m-d H:i', $val['apply_intime']);
            $data[$key]['apply_uptime_tag'] = date('Y-m-d H:i', $val['apply_uptime']);
            $data[$key]['apply_checktime_tag'] = $val['apply_checktime'] ? date('Y-m-d H:i', $val['apply_checktime']) : '';
            
            // 审核状态标签
            isset($data[$key]['apply_status']) ? $data[$key]['apply_status_tag'] = $this->apply_status[$val['apply_status']] : '';
        }
        
        return $data;
    }

    /**
     * @function 删除 品牌申请
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
        return Db::table('opg_brand_apply')->where($whereCond)->delete();
    }

    /**
     * @function 审核 品牌申请
     * @author ljx
     *        
     * @param integer $wdata['id'] brand_apply Id
     * @param integer $wdata['value'] brand_apply apply_status值 1审核通过 2审核失败
     * @param string @wdata['reason'] brand_apply apply_reason 审核失败原因 当value值为2时必传
     */
    public function check($wdata = array(), $operateData = array())
    {
        $wdata['apply_checktime'] = $_SERVER['REQUEST_TIME'];
        $wdata['apply_checkid'] = $operateData['user']['user_id'];
        
        return Db::table('opg_brand_apply')->where('id', $wdata['id'])->update($wdata);
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opg_brand_apply')->where('id',$wdata['id'])->find();
    }
    
}





















