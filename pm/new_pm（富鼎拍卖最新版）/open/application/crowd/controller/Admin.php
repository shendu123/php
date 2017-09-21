<?php
namespace app\crowd\controller;

use app\common\controller\Base;
use app\crowd\model\CrowdBack;
use think\Request;

class Admin extends Base
{

    /**
     * @function 获取crowd列表
     * @author ljx
     */
    public function index()
    {
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'goods_id' => valueRequest('goods_id', 0),
            'ids' => valueRequest('ids', '', 'string'),
            'business_id' => $this->_user['business']['business_id'],
            'operator_id' => valueRequest('operator_id', 0),
            'publish_id' => valueRequest('publish_id', 0),
            'check' => valueRequest('check', 'egt|0', 'string'),
            'onsale' => valueRequest('onsale', 'egt|0', 'string'),
            'keyword' => valueRequest('keyword', '', 'string'),
            'start_from_time' => valueRequest('start_from_time', '', 'string'),
            'start_to_time' => valueRequest('start_to_time', '', 'string'),
            'end_from_time' => valueRequest('end_from_time', '', 'string'),
            'end_to_time' => valueRequest('end_to_time', '', 'string'),
            'sysid'=>$this->_sysid,
			'type'=>valueRequest('type', '', 'string'),//crowding正在申购，future即将申购，crowdend已结束申购
        );
		
		if(!isset($condition['page_type'])||$condition['page_type']!='unlimited'){
			$wdata['page'] = valueRequest('page', 1);
            $wdata['pageSize'] = valueRequest('pageSize', 20);
		}
        
        ! empty($wdata['start_from_time']) ? $wdata['start_from_time'] = date('Y-m-d', strtotime($wdata['start_from_time'])) : '';
        ! empty($wdata['start_to_time']) ? $wdata['start_to_time'] = date('Y-m-d', strtotime($wdata['start_to_time'])) : '';
        ! empty($wdata['end_from_time']) ? $wdata['end_from_time'] = date('Y-m-d', strtotime($wdata['end_from_time'])) : '';
        ! empty($wdata['end_to_time']) ? $wdata['end_to_time'] = date('Y-m-d', strtotime($wdata['end_to_time'])) : '';
        
        $model = new CrowdBack();
        $result = $model->getList($wdata, $this->_user);
        
        return array(
            'status' => 200,
            'msg' => '成功',
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }

    /**
     * @function crowd 详情
     * @author ljx
     */
    public function detail($id = 0)
    {
        $id_r = valueRequest('id', 0);
        $id = $id_r ? $id_r : $id;
        
        if (! empty($id)) {
            $model = new CrowdBack();
            $wdata = array(
                'id' => $id,
                'accesstoken' => $this->request->header('accesstoken')
            );
            $rowData = $model->getRow($wdata, $this->_user);
            
            if (! empty($rowData)) {
                return array(
                    'status' => 200,
                    'data' => $rowData
                );
            } else {
                $this->_error('详情不存在,请稍后再试', 404);
            }
        } else {
            $this->_error('参数id不能为空', 400);
        }
    }

    /**
     * @function crowd 删除
     * @author ljx
     */
    public function delete()
    {
        $id = valueRequest('id', 0);
        if (! empty($id)) {
            $model = new CrowdBack();
            $wdata = array(
                'id' => $id
            );
            
            $result = $model->delete($wdata, $this->_user);
            if (! $result) {
                $this->_error('system error', 500);
            } else {
                return array(
                    'msg' => '操作成功'
                );
            }
        } else {
            $this->_error('参数id不能为空', 400);
        }
    }

    /**
     * @function crowd 添加申购
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            //数据验证
            $dataValidate = validate('Crowd');
			if (!$dataValidate->check($requestData)) {
				$this->_error($dataValidate->getError(), 400);
			}
            // 添加商品
            $requestData_curl = multiDecode($requestData);
            $result = curl_get_content(config("goods_api_url") . "goods/add", 1, $requestData_curl, $this->request->header('accesstoken'));
            $result = object_array($result);
            if (isset($result['error'])) {
                $this->_error($result['error'], 500);
            }
            
            if (! empty($requestData['crowd_apply_stuff'])) {
                $requestData["crowd_apply_stuff"] = $requestData['crowd_apply_stuffArray'];
            }
            
            ! empty($requestData['crowd_starttime']) ? $requestData['crowd_starttime'] = strtotime($requestData['crowd_starttime']) : '';
            ! empty($requestData['crowd_endtime']) ? $requestData['crowd_endtime'] = strtotime($requestData['crowd_endtime']) : '';
            
            if($requestData['crowd_starttime']>$requestData['crowd_endtime']){
                $this->_error('起始时间不能大于结束时间', 500);
            }
            $goods_id = $result['new_id'];
            if (! empty($goods_id)) {
                $model = new CrowdBack();
                $requestData['goods_id'] = $goods_id;
                $result = $model->add($requestData, $this->_user);
                if ($result === false) {
                    $this->_error('操作失败，请稍后再试', 500);
                } else {
                    return array(
                        'status' => 200,
                        'new_id' => $result,
                        'msg' => '操作成功'
                    );
                }
            } else {
                $this->_error('操作失败，请稍后再试', 500);
            }
        } else {
            ;
        }
    }
	
	/*
	 * 商品发布到申购
	 */
	
	public function addGoods(){
		if (request()->isPost()) {
			$data= request()->post();
			if(!$id=(new CrowdBack())->add($data, $this->_user)){
				$this->_error('操作失败，请稍后再试', 500);
			}else{
				return ['msg'=>'添加成功','id'=>$id];
			}
		}		
	}
	

    /**
     * @function crowd 编辑更新
     * @author ljx
     */
    public function edit()
    {
        if (request()->isPost()) {
            $id = valueRequest('id', 0);
            if (! empty($id)) {
            } else {
                $this->_error('参数id不能为空', 400);
            }
            
            // 从前端中删除数据
            $row = $this->detail($id);
            $row = $row['data'];
            $crowd_id = $id;            
            
            
            $requestData = Request::instance()->post();
            
            //数据验证
            $dataValidate = validate('Crowd');
			if (!$dataValidate->check($requestData)) {
				$this->_error($dataValidate->getError(), 400);
			}
            
            // 添加商品
            $requestData_curl = multiDecode($requestData);
            unset($requestData_curl['id']);
            
            $result = curl_get_content(config("goods_api_url") . "goods/edit", 1, $requestData_curl, $this->request->header('accesstoken'));
            $result = object_array($result);
            if (isset($result['error'])) {
                $this->_error($result['error'], 500);
            }
            
            if (! empty($requestData['crowd_apply_stuff'])) {
                $requestData["crowd_apply_stuff"] = $requestData['crowd_apply_stuffArray'];
            }
            
            ! empty($requestData['crowd_starttime']) ? $requestData['crowd_starttime'] = strtotime($requestData['crowd_starttime']) : '';
            ! empty($requestData['crowd_endtime']) ? $requestData['crowd_endtime'] = strtotime($requestData['crowd_endtime']) : '';
            if($requestData['crowd_starttime']>$requestData['crowd_endtime']){
                $this->_error('起始时间不能大于结束时间', 500);
            }
            // 重置审核字段
            $requestData['crowd_check'] = 0;
            $requestData['crowd_checkid'] = 0;
            $requestData['crowd_check_reason'] = '';
            
            $model = new CrowdBack();
            $result = $model->edit($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败，请稍后再试', 500);
            } 
            
            if($row['crowd_check']==1){
                 $srt = new \SphinxRt(config('sphinx'));
                 $srt_del = $srt->delete($crowd_id);
                 $cb = (new \Couchbase(config('couchbase')))->n1ql_query("DELETE FROM `crowd` WHERE crowd_id = {$crowd_id}");
            }
            return array(
                'status' => 200,
                'new_id' => $result,
                'msg' => '操作成功'
            );
        } else {
            ;
        }
    }

    /**
     * @function 审核crowd
     * @author ljx
     *        
     */
    public function check()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = valueRequest('id', 0);
            $value = valueRequest('value', 0); // crowd_check
            if (empty($id)) {
                $this->_error('id不能为空', 400);
            }
            $wdata['id'] = $id;
            switch ($value) {
                case 1: // 审核成功
                    break;
                case 2: // 审核失败 需要填写审核失败原因
                    $reason = valueRequest('reason', '', 'string');
                    if (empty($reason)) {
                        $this->_error('reason【审核失败原因】参数值不能为空', 400);
                    }
                    $wdata['crowd_check_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['crowd_check'] = $value;
            
            $model = new CrowdBack();
            $result = $model->check($wdata, $this->_user);
            if ($result === false) {
                $this->_error('system error', 500);
            }
            // 审核通过 加入前端缓存
            if($value == 1){
                $result_onCheckSuc = $this->onCheckSuc($id);
            }
            
            return array(
                'status' => 200,
                'msg' => '操作成功'
            );
        } else {
            ;
        }
    }
    
    /**
     * @function 审核通过的处理
     * @author ljx
     * 
     * @param integer $id
     */
    private function onCheckSuc($id){
        $row = $this->detail($id);
        $row = $row['data'];

        $rt = [
            'title' => $row['goods_info']['goods_name'],
            'code' => $row['crowd_code'],
            'keywords' => $row['goods_info']['goods_keywords'],
            'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'content' => $row['goods_info']['goods_desc'].$row['goods_info']['goods_content'],
            'crowd_name' => $row['crowd_name'],
            'cat_id' => $row['goods_info']['cat_id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'business_id' => $row['business_id'],
            'crowd_code' => $row['crowd_code'],
            'crowd_onsale' => $row['crowd_onsale'],
            'crowd_id' => $row['id'],
            'crowd_price' => priceFormat(false , $row['crowd_price']),   
            'crowd_consume' => $row['crowd_consume'],
            'crowd_premium' => 0,
            'crowd_inventory' => $row['crowd_inventory'],
            'crowd_total' => $row['crowd_total'],
            'crowd_sort' => $row['crowd_sort'],
            'goods_price' => priceFormat(false , $row['goods_info']['goods_price']),
            'crowd_starttime' => $row['crowd_starttime'],
            'crowd_endtime' => $row['crowd_endtime']
        ];
        $srt = new \SphinxRt(config('sphinx'));
        $srt_insert = $srt->insert($rt, $id);
        
        $cb_data = json_encode([
            'crowd_id' => $row['id'],
            'goods_id' => $row['goods_info']['id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'goods_desc' => $row['goods_info']['goods_desc'],
            'goods_content' => $row['goods_info']['goods_content'],
            'goods_pictures' => array_column($row['goods_info']['goods_pictures'], 'url'),
            'business_id' => $row['business_id'],
            'member_id' => $row['goods_info']['member_id'],
            'crowd_name' => $row['crowd_name'],
            'crowd_code' => $row['crowd_code'],
            'crowd_total' => $row['crowd_total'],
            'crowd_onsale' => $row['crowd_onsale'],
            'crowd_price' => priceFormat(false , $row['crowd_price']),   
            'crowd_consume' => $row['crowd_consume'],
            'crowd_premium' => 0,
            'crowd_inventory' => $row['crowd_inventory'],
            'crowd_broker_price' => priceFormat(false , $row['crowd_broker_price']),
            'crowd_seller_price' => priceFormat(false , $row['crowd_seller_price']),
            'crowd_starttime' => $row['crowd_starttime'],
            'crowd_endtime' => $row['crowd_endtime'],
            'crowd_freight_price' => priceFormat(false , $row['crowd_freight_price']),
            'goods_price' => priceFormat(false , $row['goods_info']['goods_price']),
        ]);
        $cb = (new \Couchbase(config('couchbase')))->n1ql_query("INSERT INTO `crowd` (KEY, VALUE) VALUES ('crowd_{$row['id']}', $cb_data)");
    }

    /**
     * @function 上下架crowd
     * @author ljx
     *        
     */
    public function onsale()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = request()->param('id',0);
            $value = valueRequest('value', 0); // crowd_onsale
            if (empty($id)) {
                $this->_error('id不能为空', 400);
            }
            $wdata['id'] = $id;
            switch ($value) {
                case 1:
                    break;
                case 2:
                    /**
                     * $reason = valueRequest('reason', '', 'string');
                     * if (empty($reason)) {
                     * $this->_error('reason【上架失败原因】参数值不能为空', 400);
                     * }
                     * $wdata['crowd_check_reason'] = $reason;
                     */
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['crowd_onsale'] = $value;
            
            $model = new CrowdBack();
            $result = $model->setOnsale($wdata, $this->_user);
            if (!$result['status']) {
                $this->_error($result['msg'], 500);
            } else {
                return array(
                    'msg' => '操作成功'
                );
            }
        } else {
            ;
        }
    }
    
    /**
     * @function 获取crowd列表 unlimited
     * @author ljx
     */
    public function getList()
    {
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'goods_id' => valueRequest('goods_id', 0),
            'ids' => valueRequest('ids', '', 'string'),
            'operator_id' => valueRequest('operator_id', 0),
            'publish_id' => valueRequest('publish_id', 0),
            'check' => valueRequest('check', 'egt|0', 'string'),
            'onsale' => valueRequest('onsale', 'egt|0', 'string'),
            'keyword' => valueRequest('keyword', '', 'string'),
            'start_from_time' => valueRequest('start_from_time', '', 'string'),
            'start_to_time' => valueRequest('start_to_time', '', 'string'),
            'end_from_time' => valueRequest('end_from_time', '', 'string'),
            'end_to_time' => valueRequest('end_to_time', '', 'string'),
			'type'=>valueRequest('type', '', 'string'),//crowding正在申购，future即将申购，crowdend已结束申购
        );
    
        ! empty($wdata['start_from_time']) ? $wdata['start_from_time'] = date('Y-m-d', strtotime($wdata['start_from_time'])) : '';
        ! empty($wdata['start_to_time']) ? $wdata['start_to_time'] = date('Y-m-d', strtotime($wdata['start_to_time'])) : '';
        ! empty($wdata['end_from_time']) ? $wdata['end_from_time'] = date('Y-m-d', strtotime($wdata['end_from_time'])) : '';
        ! empty($wdata['end_to_time']) ? $wdata['end_to_time'] = date('Y-m-d', strtotime($wdata['end_to_time'])) : '';
    
        $model = new CrowdBack();
        $result = $model->getList($wdata, $this->_user);
    
        return array(
            'status' => 200,
            'msg' => '成功',
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }
	
	/*
	 * ajax更新排序
	 */
	public function changeCrowdSort(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(!is_numeric($data['crowd_sort'])){
				$this->_error('排序非法',400);
			}
			$model = new CrowdBack();
			if(!$model -> edit($data , $this->_user)){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新排序成功'];			
		}
	}
}