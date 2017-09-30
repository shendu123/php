<?php
/*
 * 自由拍卖
 */
namespace app\item\controller;
use app\common\controller\Base;
use app\item\model\ItemBack;
use think\Request;
class Admin extends Base
{
	/*
	 * 自由拍卖列表
	 */
	public function index(){
		$condition =  request()->param();
		$condition['accesstoken'] = $this->request->header('accesstoken');
		$condition['business_id'] = $this->_user['business']['business_id'];
		$condition['sysid'] = $this->_sysid;
		if(!isset($condition['page_type'])||$condition['page_type']!='unlimited'){
			$page['pageSize'] = request()->param('page_size',10);
			$page['page'] = request()->param('page',1);
			if($page['pageSize'] > config('max_size')){
				$this->_error('每页最多只能展示“'.config('max_size').'”条',500);
			}
		}
        return (new ItemBack())->itemList($page, $condition);
	}
	/*
	 * 添加自由拍卖
	 */
	public function add(){
        if (request()->isPost()) {
            $data =  request()->param();
			//数据验证
			$validateAdv = validate('Item');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}
            // 添加商品
            $goods = curl_get_content(config("goods_api_url") . "goods/add", 1, multiDecode($data), $this->request->header('accesstoken'));
            $goods = object_array($goods);
            if (isset($goods['error'])) {
                $this->_error($goods['error'], 500);
            }
            if (! empty($goods['new_id'])) {
                $data['goods_id'] = $goods['new_id'];
                if (!$result=(new ItemBack())->add($data, $this->_user)) {
                    $this->_error('操作失败', 500);
                }
				return ['new_id' => $result,'msg' => '操作成功','status' => 200];
            } else {
                $this->_error('操作失败', 500);
            }
        }
    }
	/*
	 * 商品发布到自由买卖，后面再做修改
	 */
	
	public function addGoods(){
		if (request()->isPost()) {
			$data= Request::instance()->post();
			if(!$id=(new ItemBack())->add($data, $this->_user)){
				$this->_error('操作失败，请稍后再试', 500);
			}else{
				return ['msg'=>'添加成功','id'=>$id];
			}
		}		
	}
	/*
	 * 编辑自由拍卖
	 */
	public function edit(){
		 if (request()->isPost()) {
            $data=  request()->param();
			if (!isset($data['id'])||!is_numeric($data['id'])) {
				$this->_error('参数错误', 400);
			}
			//数据验证
			$validateAdv = validate('Item');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}
            // 从前端中删除数据
            $row = $this->detail($data['id']);
            $row = $row['data'];
            $item_id = $data['id'];                       
            // 编辑商品            
            $goods = curl_get_content(config("goods_api_url") . "goods/edit", 1,  multiDecode($data), $this->request->header('accesstoken'));
            $goods = object_array($goods);
            if (isset($goods['error'])) {
                $this->_error($goods['error'], 500);
            }
            // 重置审核字段
            $data['item_check'] = 0;
            $data['item_checkid'] = 0;
            $data['item_check_reason'] = '';
            if (!$result=(new ItemBack())->edit($data, $this->_user)) {
                $this->_error('操作失败，请稍后再试', 500);
            } 
            //清除缓存
            if($row['item_check']==1){
                 $srt = new \SphinxRt(config('sphinx'));
                 $srt_del = $srt->delete($item_id);
                 $cb = (new \Couchbase(config('couchbase')))->n1ql_query("DELETE FROM `item` WHERE item_id = {$item_id}");
            }
			return ['new_id' => $result,'msg' => '操作成功','status' => 200,];
        }
	}

    /**
     *  审核
     *        
     */
    public function check()
    {
        if (request()->isPost()) {
			$data=  request()->param();
            if (!isset($data['id'])||!is_numeric($data['id'])) {
				$this->_error('参数错误', 400);
			}
			if(!isset($data['item_check'])||!in_array($data['item_check'],[1,2])){
				$this->_error('item_check参数错误', 400);
			}
			if(($data['item_check']==2) && empty(valueRequest('item_check_reason', '', 'string'))){
				$this->_error('审核失败原因不能为空', 400);
			}
            if ($result=(new ItemBack())->check($data, $this->_user) === false) {
                $this->_error('数据库操作失败', 500);
            }
            // 审核通过 加入前端缓存
            if($data['item_check'] == 1){
                $this->onCheckSuc($data['id']);
            }
            
            return array('status' => 200, 'msg' => '操作成功');
        }
    }
    
    /**
     * 审核通过的处理
     */
    private function onCheckSuc($id){
        $row = $this->detail($id);
        $row = $row['data'];

        $rt = [
            'title' => $row['goods_info']['goods_name'],
            'code' => $row['item_code'],
            'keywords' => $row['goods_info']['goods_keywords'],            
            'content' => $row['goods_info']['goods_desc'].$row['goods_info']['goods_content'],
            'item_name' => $row['item_name'],
            'cat_id' => $row['goods_info']['cat_id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'business_id' => $row['business_id'],
			'item_business_cat_id'=>$row['item_business_cat_id'],
            'item_code' => $row['item_code'],
            'item_onsale' => $row['item_onsale'],
            'item_id' => $row['id'],
            'item_price' => priceFormat(false , $row['item_price']),            
            'item_inventory' => $row['item_inventory'],
			'item_consume' => $row['item_consume'],
            'item_total' => $row['item_total'],
            'item_sort' => $row['item_sort'],
			'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'goods_price' => priceFormat(false, $row['goods_info']['goods_price']),
        ];
        $srt = new \SphinxRt(config('sphinx'));
        $srt_insert = $srt->insert($rt, $id);
        
        $cb_data = json_encode([
            'item_id' => $row['id'],
            'goods_id' => $row['goods_info']['id'],
            'brand_id' => $row['goods_info']['brand_id'],
            'goods_thumb' => $row['goods_info']['goods_thumb'][0]['url'],
            'goods_desc' => $row['goods_info']['goods_desc'],
            'goods_content' => $row['goods_info']['goods_content'],
            'goods_pictures' => array_column($row['goods_info']['goods_pictures'], 'url'),
            'business_id' => $row['business_id'],
            'item_name' => $row['item_name'],
			'item_code' => $row['item_code'],
            'item_total' => $row['item_total'],
            'item_onsale' => $row['item_onsale'],
            'item_price' => priceFormat(false , $row['item_price']),
            'item_consume' => $row['item_consume'],
            'item_inventory' => $row['item_inventory'],
            'item_freight_price' => priceFormat(false , $row['item_freight_price']),
            'goods_price' => priceFormat(false, $row['goods_info']['goods_price']),
        ]);
        $cb = (new \Couchbase(config('couchbase')))->n1ql_query("INSERT INTO `item` (KEY, VALUE) VALUES ('item_{$row['id']}', $cb_data)");
    }

    /**
     * 上下架item
     *        
     */
    public function onsale()
    {
        if (request()->isPost()) {
			$data=  request()->param();
			if (!isset($data['id']) || empty($data['id'])) {
				$this->_error('参数错误', 400);
			}
			if(!isset($data['item_onsale'])||!in_array($data['item_onsale'],[1,2])){
				$this->_error('item_onsale参数错误', 400);
			}
//			if(($data['item_onsale']==2) && empty(valueRequest('item_onsale_reason', '', 'string'))){
//				$this->_error('下架原因不能为空', 400);
//			}            
            $result = (new ItemBack())->setOnsale($data, $this->_user);
            if (!$result['status']) {
                $this->_error($result['msg'], 500);
            } else {
                $srt = new \SphinxRt(config('sphinx'));
                $srt_update = $srt->update(['item_onsale'=>$data['item_onsale']],$data['id']);
                $cb = (new \Couchbase(config('couchbase')))->n1ql_query("UPDATE `item` SET item_onsale = {$data['item_onsale']} WHERE item_id in ({$data['id']})");

                return array('msg' => '操作成功');
            }
        }
    }
    
	
	/*
	 * ajax更新排序/是否推荐
	 */
	public function changeSortOrRec(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(isset($data['item_sort'])&&!is_numeric($data['item_sort'])){
				$this->_error('排序参数非法',400);
			}
			if(isset($data['item_is_recommend'])&&!in_array($data['item_is_recommend'],[0,1])){
				$this->_error('item_is_recommend参数非法',400);
			}
			if(!(new ItemBack())->edit($data, $this->_user)){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新成功'];			
		}
	}
	
	/**
     * 详情
     */
    public function detail()
    {
		$data=request()->param();
		if(!isset($data['id'])||!is_numeric($data['id'])){
			$this->_error('参数错误',400);
		}
		$data['accesstoken']=$this->request->header('accesstoken');
		if(!$info=(new ItemBack())->getRow($data , $this->_user)){
			$this->_error('数据不存在',400);
		}
        return ['status'=>200,'data'=>$info];
    }

    /**
     * 删除
     */
    public function delete()
    {
		$data=request()->param();
		if(!isset($data['id'])||!is_numeric($data['id'])){
			$this->_error('参数错误',400);
		}
		if(!(new ItemBack())->delete($data , $this->_user)){
			 $this->_error('删除数据失败', 500);
		}
		return ['msg'=>'操作成功'];
    }

}	


