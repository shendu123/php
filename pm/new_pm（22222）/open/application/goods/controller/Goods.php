<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;

class Goods extends base
{

    /**
     * @function 商品列表接口
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Goods();
        
        /**
         * TODO 这边根据业务需求 限定条件 接口调用者信息
         * 1. 合伙人 business_id的限制
         * 2. 一级运营商 business_id的限制 可能得需求 可查看自己 可查看下级
         * 3. 二级运营商 business_id的限制
         * 4. 平台运营人资模块内部人员查看的控制 【这一块没做】
         */
        $operateData = $this->_user;
        
        /**
         * TODO 这边还应当提供 传多个商户id的能力
         * business_ids => 1,2,3
         */
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'ids' => valueRequest('ids', '', 'string'),
            'business_id' => $operateData['business']['business_id'],
			'sysid' => $this->_sysid,
            'member_id' => valueRequest('member_id', 0),
            'goods_is_delete' => valueRequest('is_delete', 0),
            // 'cat_ids' => '4,5,7',
            'keyword' => valueRequest('keyword', '', 'string')
        );
        $result = $model->getList($wdata);
        
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
     * @function 商品详情接口
     *
     * @author ljx
     */
    public function detail()
    {
        $id = valueRequest('id', 0);
        if (! empty($id)) {
            $model = new \app\goods\model\Goods();
            
            $wdata = array(
                'id' => $id
            );
            
            $result = $model->getRow($wdata);
            if (! empty($result)) {
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'data' => $result
                );
            } else {
                $this->_error('商品不存在或已删除~', 500);
            }
        } else {
            $this->_error('商品不存在或已删除~', 500);
        }
    }

    /**
     * @function 商品添加接口
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            if (! empty($requestData['goods_thumb'])) {
                $requestData["goods_thumb"] = $requestData['goods_thumbArray'];
            }
            
            if (! empty($requestData['goods_pictures'])) {
                $requestData["goods_pictures"] = $requestData['goods_picturesArray'];
            }
			
			if (! empty($requestData['gallery_pic_urlArray'])) {
                $requestData["gallery_pic_url"] = $requestData['gallery_pic_urlArray'];
            }
            
            // 表单数据有效性拦截验证
            if (empty($requestData['goods_name'])) {
                $this->_error('商品名称不能为空', 500);
            }
            
            $requestData['goods_content'] = htmlspecialchars_decode($requestData['goods_content']);
            $model = new \app\goods\model\Goods();
            $result = $model->add($requestData, $this->_user);
						
            if ($result === false) {
                $this->_error('保存失败，请稍后再试', 500);
            } else {				
				//如果是自由买卖，则要添加商品规格
				if(isset($requestData['item']) && !empty($requestData['item'])){
					$specData['goodsid'] = $result;
					$specData['item'] = $requestData['item'];
					$specGoods = curl_get_content(config("goods_api_url") . "SpecGoods/manage", 1,  multiDecode($specData), $this->request->header('accesstoken'));
					if($specGoods->error){
						$this->_error($specGoods->error, 500);
					}
				}
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'new_id' => $result
                );
            }
        } else {
            ;
        }
    }

    /**
     * @function 商品编辑接口
     *
     * @author ljx
     */
    public function edit()
    {
        if (request()->isPost()) {

            $id_id = valueRequest('id', 0);
            $id_goods_id = valueRequest('goods_id', 0);
            $id = $id_goods_id ? $id_goods_id : $id_id;
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                $requestData['id'] = $id;
                
                if (! empty($requestData['goods_thumbArray'])) {
                    $requestData["goods_thumb"] = $requestData['goods_thumbArray'];
                }
                
//                if (! empty($requestData['goods_pictures'])) {
//                    $pictures = array_column($requestData['goods_pictures'], 'url');
//                    $requestData["goods_pictures"] = implode(',', $pictures);
//                }
				if (! empty($requestData['goods_picturesArray'])) {
					$requestData["goods_pictures"] = $requestData['goods_picturesArray'];
				}				
				
				if (! empty($requestData['gallery_pic_urlArray'])) {
					$requestData["gallery_pic_url"] = $requestData['gallery_pic_urlArray'];
				}				
                
                // 表单数据有效性拦截验证
                if (isset($requestData['goods_name']) && empty($requestData['goods_name'])) {
                    $this->_error('商品名称不能为空', 500);
                }
                
                $model = new \app\goods\model\Goods();
				if(isset($requestData['goods_content']) && !empty($requestData['goods_content'])){
					$requestData['goods_content'] = htmlspecialchars_decode($requestData['goods_content']);
				}                
                $result = $model->edit($requestData, $this->_user);
                if ($result === false) {
                    $this->_error('保存失败，请稍后再试', 500);
                } else {					
					//如果是自由买卖，则要添加商品规格
					if(isset($requestData['item']) && !empty($requestData['item'])){
						$specData['goodsid'] = $id;
						$specData['item'] = $requestData['item'];
						$specGoods = curl_get_content(config("goods_api_url") . "SpecGoods/manage", 1,  multiDecode($specData), $this->request->header('accesstoken'));
						if($specGoods->error){
							$this->_error($specGoods->error, 500);
						}
					}
                    return array(
                        'status' => 200,
                        'msg' => '操作成功'
                    );
                }
            } else {
                $this->_error('商品id不能为空' . $id, 400);
            }
        } else {
            ;
        }
    }

    /**
     * @function 真删商品
     * @author ljx
     *         TODO 暂不实现
     */
    public function trueDel()
    {
    }

    /**
     * @function 删除商品
     * @author ljx
     *         TODO 这边应当是假删
     *         TODO 考虑是否拆除批量功能
     */
    public function delete()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Goods();
            $wdata = array(
                'ids' => $ids
            );
            $result = $model->delete($wdata, $this->_user);
            if (! $result) {
                $this->_error('system error', 500);
            } else {
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
     * @function 获取分类及其后代分类下的商品
     * @author ljx
     */
    public function getOffspring(){

    }
    
    /**
     * @function 授权审核
     * @author ljx
     * TODO 确认需求为 通过人工审核 不在技术上限制
     */
    public function checkAuth(){
        // 一级运营商不限制所销售商品的分类 但只能销售指定代理品牌的商品
    }
	
	/*
	 * 发布到申购
	 */
	public function pubToCrowd(){
		if(request()->isPost()) {
			$data=Request::instance()->post();			
			//数据验证
			$crowdAdd = validate('CrowdAdd');
			if(!$crowdAdd->check($data)){
				$this->_error($crowdAdd->getError(),400);
			}
			$data['crowd_starttime'] = strtotime($data['crowd_starttime']);
			$data['crowd_endtime'] = strtotime($data['crowd_endtime']);
			$result = curl_get_content(config("crowd_api_url") . "admin/addGoods", 1, $data, $this->request->header('accesstoken'));
			$result = object_array($result);
			if(!empty($result['id'])){
				return ['msg'=>'发布成功','crowd_id'=>$result['id']];
			}
			$this->_error('发布失败',500);
		}		
	}
	/*
	 * 发布到拍卖
	 */
	public function pubToAuction(){
		if(request()->isPost()) {
			$data=Request::instance()->post();
			//数据验证
			$auctionAdd = validate('AuctionAdd');
			if(!$auctionAdd->check($data)){
				$this->_error($auctionAdd->getError(),400);
			}
			$data['auction_starttime'] = strtotime($data['auction_starttime']);
			$data['auction_endtime'] = strtotime($data['auction_endtime']);
			$result = curl_get_content(config("auction_api_url") . "admin/addGoods", 1, $data, $this->request->header('accesstoken'));
			$result = object_array($result);
			if(!empty($result['id'])){
				return ['msg'=>'发布成功','auction_id'=>$result['id']];
			}
			$this->_error('发布失败',500);
		}
	}
	/*
	 * 发布到自由买卖
	 */
	public function pubToItem(){
		if(request()->isPost()) {
			$data=Request::instance()->post();
			$itemAdd = validate('ItemAdd');
			if(!$itemAdd->check($data)){
				$this->_error($itemAdd->getError(),400);
			}
			$result = curl_get_content(config("item_api_url") . "admin/addGoods", 1, $data, $this->request->header('accesstoken'));
			$result = object_array($result);
			if(!empty($result['id'])){
				//添加商品规格
				if(isset($data['item']) && !empty($data['item'])){
					$specData['goodsid'] = $data['goods_id'];
					$specData['item'] = $data['item'];
					$specGoods = curl_get_content(config("goods_api_url") . "SpecGoods/manage", 1,  multiDecode($specData), $this->request->header('accesstoken'));
					if($specGoods->error){
						$this->_error($specGoods->error, 500);
					}
				}
				return ['msg'=>'发布成功','item_id'=>$result['id']];
			}
			$this->_error('发布失败',500);
		}
	}	
}




























