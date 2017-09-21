<?php
namespace app\auction\controller;

use app\common\controller\Base;
use app\auction\model\AuctionBack;
use app\bi\model\Auction as bi_Auction;
use think\Request;

class Admin extends Base
{

    /**
     * @function 获取auction列表
     * @author ljx
     */
    public function index()
    {
        $type = valueRequest('type', 'jingjia', 'string');
        // 11拍卖 12VIP 13专场 14拍卖会
        switch ($type) {
            case 'jingjia':
                $mode = 'eq|10';
                break;
            case 'paimai':
                $mode = 'eq|11';
                break;
            case 'vip':
            case 'VIP':
            case 'Vip':
                $mode = 'eq|12';
                break;
            case 'zhuanchang':
                $mode = 'eq|13';
                break;
            case 'paimaihui':
                $mode = 'eq|14';
                break;
            default:
                $mode = 'eq|10';
        }
        
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传            
            'goods_id' => valueRequest('goods_id', 0),
            'ids' => valueRequest('ids', '', 'string'),
            'business_id' => $this->_user['business']['business_id'],
            'member_id' => valueRequest('member_id', 0),
            'operator_id' => valueRequest('operator_id', 0),
            'publish_id' => valueRequest('publish_id', 0),
            'flow_status' => valueRequest('flow_status', 'egt|0', 'string'),
            'check_status' => valueRequest('check', 'egt|0', 'string'),
            'keyword' => valueRequest('keyword', '', 'string'),
            'start_from_time' => valueRequest('start_from_time', '', 'string'),
            'start_to_time' => valueRequest('start_to_time', '', 'string'),
            'end_from_time' => valueRequest('end_from_time', '', 'string'),
            'end_to_time' => valueRequest('end_to_time', '', 'string'),
            'mode' => $mode,
            'sysid' => $this->_sysid
        );
        if(!isset($condition['page_type'])||$condition['page_type']!='unlimited'){
			$wdata['page'] = valueRequest('page', 1);
            $wdata['pageSize'] = valueRequest('pageSize', 20);
		}
        ! empty($wdata['start_from_time']) ? $wdata['start_from_time'] = date('Y-m-d', strtotime($wdata['start_from_time'])) : '';
        ! empty($wdata['start_to_time']) ? $wdata['start_to_time'] = date('Y-m-d', strtotime($wdata['start_to_time'])) : '';
        ! empty($wdata['end_from_time']) ? $wdata['end_from_time'] = date('Y-m-d', strtotime($wdata['end_from_time'])) : '';
        ! empty($wdata['end_to_time']) ? $wdata['end_to_time'] = date('Y-m-d', strtotime($wdata['end_to_time'])) : '';
        
        $auctionModel = new AuctionBack();
        $result = $auctionModel->getList($wdata, $this->_user);
        
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
     * @function auction 新增更新
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            //数据验证
            $dataValidate = validate('Auction');
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
            
            if (! empty($requestData['auction_apply_stuff'])) {
                $requestData["auction_apply_stuff"] = $requestData['auction_apply_stuffArray'];
            }
            
            ! empty($requestData['auction_starttime']) ? $requestData['auction_starttime'] = strtotime($requestData['auction_starttime']) : '';
            ! empty($requestData['auction_endtime']) ? $requestData['auction_endtime'] = strtotime($requestData['auction_endtime']) : '';
            
            if ($requestData['auction_starttime'] > $requestData['auction_endtime']) {
                $this->_error('起始时间不能大于结束时间', 500);
            }
            $goods_id = $result['new_id'];
            if (! empty($goods_id)) {
                $model = new AuctionBack();
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
	 * 商品发布到拍卖，后面再做修改
	 */
	
	public function addGoods(){
		if (request()->isPost()) {
			$data= Request::instance()->post();
			if(!$id=(new AuctionBack())->add($data, $this->_user)){
				$this->_error('操作失败，请稍后再试', 500);
			}else{
				return ['msg'=>'添加成功','id'=>$id];
			}
		}		
	}

    /**
     * @function auction 编辑更新
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
            
            $row = $this->detail($id);
            $row = $row['data'];
            $auction_id = $id;
            
            $requestData = Request::instance()->post(); // print_r($requestData);exit;
			
			//数据验证
            $dataValidate = validate('Auction');
			if (!$dataValidate->check($requestData)) {
				$this->_error($dataValidate->getError(), 400);
			}
                                                        
            
            // 重置审核字段
            $requestData['auction_check_status'] = 0;
            $requestData['auction_checkid'] = 0;
            $requestData['auction_reason'] = '';
            
            // 添加商品
            $requestData_curl = multiDecode($requestData);
            unset($requestData_curl['id']);
            
            $result = curl_get_content(config("goods_api_url") . "goods/edit", 1, $requestData_curl, $this->request->header('accesstoken'));
            $result = object_array($result);
            if (isset($result['error'])) {
                $this->_error($result['error'], 500);
            }
            
            if (isset($requestData['auction_apply_stuffArray']) && !empty($requestData['auction_apply_stuffArray'])) {
                $requestData["auction_apply_stuff"] = $requestData['auction_apply_stuffArray'];
            }
            
            ! empty($requestData['auction_starttime']) ? $requestData['auction_starttime'] = strtotime($requestData['auction_starttime']) : '';
            ! empty($requestData['auction_endtime']) ? $requestData['auction_endtime'] = strtotime($requestData['auction_endtime']) : '';
            
            if ($requestData['auction_starttime'] > $requestData['auction_endtime']) {
                $this->_error('起始时间不能大于结束时间', 500);
            }
            $model = new AuctionBack();
            $result = $model->edit($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败，请稍后再试', 500);
            }
            
            // 删除前端中的数据
            if ($row['auction_check_status'] == 1) {
                $srt = new \SphinxRt(config('sphinx'));
                $srt_del = $srt->delete($auction_id);
                $cb = (new \Couchbase(config('couchbase')))->n1ql_query("DELETE FROM `auction` WHERE auction_id = {$auction_id}");
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
     * @function auction 删除
     * @author ljx
     */
    public function delete()
    {
        $id = valueRequest('id', 0);
        if (! empty($id)) {
            $auctionModel = new AuctionBack();
            $wdata = array(
                'id' => $id
            );
            
            $result = $auctionModel->delete($wdata, $this->_user);
            if (! $result) {
                $this->_error('system error', 500);
            } else {

                $srt = new \SphinxRt(config('sphinx'));
                $srt_del = $srt->delete($auction_id);

                $cb = (new \Couchbase(config('couchbase')))->n1ql_query("DELETE FROM `auction` WHERE auction_id = {$auction_id}");
                return array(
                    'status' => 200,
                    'msg' => '操作成功'
                );
            }
        } else {
            $this->_error('参数id不能为空', 400);
        }
    }

    /**
     * @function auction 详情
     * @author ljx
     */
    public function detail($id_param = 0)
    {
        $id_request = valueRequest('id', 0);
        $id = $id_request ? $id_request : $id_param;
        if (! empty($id)) {
            $model = new AuctionBack();
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
     * @function 审核auction
     * @author ljx
     *        
     */
    public function check()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = valueRequest('id', 0);
            $value = valueRequest('value', 0); // auction_flow_status
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
                    $wdata['auction_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['auction_check_status'] = $value;
            
            $auctionModel = new AuctionBack();
            $result = $auctionModel->check($wdata, $this->_user);
            if ($result === false) {
                $this->_error('system error', 500);
            }
            
            // 审核通过 加入前端缓存
            if ($value == 1) {
                $result_onCheckSuc = $this->onCheckSuc($id);
                (new bi_Auction())->insert($id);
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
    private function onCheckSuc($id)
    {
        $row = $this->detail($id);
        $row = $row['data'];
       
        $rt = [
            'title' => $row['auction_name'],
            'code' => $row['auction_code'],
            'keywords' => $row['goods_info']['goods_keywords'],
            'content' => $row['goods_info']['goods_desc'].$row['goods_info']['goods_content'],
            'auction_name' => $row['auction_name'],
            'cat_id' => $row['goods_info']['cat_id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'member_id' => $row['member_id'],
            'business_id' => $row['business_id'],
            'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'auction_id' => $row['id'],
            'auction_type' => $row['auction_type'],
            'auction_mode' => $row['auction_mode'],
            'auction_flow_status' => $row['auction_flow_status'],
            'auction_onset_price' => priceFormat(false , $row['auction_onset_price']), 
            'auction_starttime' => $row['auction_starttime'],
            'auction_endtime' => $row['auction_endtime'],
            'auction_now_price' => priceFormat(false , $row['auction_now_price']),
            'auction_bidcount' => $row['auction_bidcount'],
            'auction_pledge_type' => $row['auction_pledge_type'],
            'auction_buier_price' => priceFormat(false , $row['auction_buier_price']),   
        ];
        $srt = new \SphinxRt(config('sphinx'));
        $srt_insert = $srt->insert($rt, $rt['auction_id']);
        
        $cb_data = json_encode([
            'auction_id' => $rt['auction_id'],
            'goods_id' => $row['goods_info']['id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'goods_desc' => isset($row['goods_desc'])?$row['goods_desc']:'',
            'goods_content' => isset($row['goods_content'])?$row['goods_content']:'',
            'goods_pictures' => array_column($row['goods_info']['goods_pictures'], 'url'),
            'business_id' => $row['business_id'],
            'member_id' => $row['member_id'],
            'bid_last_uid' => $row['auction_attenderid'],
            'cat_id' => $rt['cat_id'],
            'auction_name' => $rt['title'],
            'auction_code' => $row['auction_code'],
            'auction_type' => $rt['auction_type'],
            'auction_mode' => $rt['auction_mode'],
            'auction_bidcount' => $row['auction_bidcount'],
            'auction_succtype' => $row['auction_succtype'],
            'auction_flow_status' => $rt['auction_flow_status'],
            'auction_adjust_status' => $row['auction_adjust_status'],
            'auction_succ_price' => priceFormat(false , $row['auction_succ_price']),
            'auction_freight_price' => priceFormat(false , $row['auction_freight_price']), 
            'auction_broker_price' => priceFormat(false , $row['auction_broker_price']),  
            'auction_broker_type' => $row['auction_broker_type'],
            'auction_onset_price' => priceFormat(false , $row['auction_onset_price']),
            'auction_now_price' => priceFormat(false , $row['auction_now_price']), 
            'auction_stepsize_type' => $row['auction_stepsize_type'],
            'auction_stepsize_price' => priceFormat(false , $row['auction_stepsize_price']), 
            'auction_reserve_price' => priceFormat(false , $row['auction_reserve_price']), 
            'auction_starttime' => $rt['auction_starttime'],
            'auction_endtime' => $rt['auction_endtime'],
            'auction_stepsize_type' => $row['auction_stepsize_type'],
            'auction_pledge_type' => $row['auction_pledge_type'],
            'auction_buier_price' => priceFormat(false , $row['auction_buier_price'])
        ]);
        $cb = (new \Couchbase(config('couchbase')))->n1ql_query("INSERT INTO `auction` (KEY, VALUE) VALUES ('auction_{$rt['auction_id']}', $cb_data)");
    }

    /**
     * @function 获取auction列表 unlimited
     * @author ljx
     */
    public function getList()
    {
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'goods_id' => valueRequest('goods_id', 0),
            'ids' => valueRequest('ids', '', 'string'),
            'member_id' => valueRequest('member_id', 0),
            'operator_id' => valueRequest('operator_id', 0),
            'publish_id' => valueRequest('publish_id', 0),
            'flow_status' => valueRequest('flow_status', 'egt|0', 'string'),
            'check_status' => valueRequest('check', 'egt|0', 'string'),
            'keyword' => valueRequest('keyword', '', 'string'),
            'start_from_time' => valueRequest('start_from_time', '', 'string'),
            'start_to_time' => valueRequest('start_to_time', '', 'string'),
            'end_from_time' => valueRequest('end_from_time', '', 'string'),
            'end_to_time' => valueRequest('end_to_time', '', 'string')
        );
        
        ! empty($wdata['start_from_time']) ? $wdata['start_from_time'] = date('Y-m-d', strtotime($wdata['start_from_time'])) : '';
        ! empty($wdata['start_to_time']) ? $wdata['start_to_time'] = date('Y-m-d', strtotime($wdata['start_to_time'])) : '';
        ! empty($wdata['end_from_time']) ? $wdata['end_from_time'] = date('Y-m-d', strtotime($wdata['end_from_time'])) : '';
        ! empty($wdata['end_to_time']) ? $wdata['end_to_time'] = date('Y-m-d', strtotime($wdata['end_to_time'])) : '';
        
        $auctionModel = new AuctionBack();
        $result = $auctionModel->getList($wdata, $this->_user);
        
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
	 * 拍卖上下架
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
                     * $wdata['auction_onsale_reason'] = $reason;
                     */
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['auction_onsale'] = $value;
            
            $model = new AuctionBack();
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
	
	/*
	 * ajax更新排序
	 */
	public function changeAuctionSort(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(!is_numeric($data['auction_sort'])){
				$this->_error('排序非法',400);
			}
			$model = new AuctionBack();
			if(!$model -> edit($data , $this->_user)){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新排序成功'];			
		}
	}
}