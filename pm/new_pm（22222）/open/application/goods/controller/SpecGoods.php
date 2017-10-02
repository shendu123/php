<?php
namespace app\goods\controller;

use app\common\controller\Base;
use app\goods\model\Spec;
use app\goods\model\SpecItem;
use app\goods\model\SpecGoods as SpecGoods_model;

class SpecGoods extends Base {

	public function manage() {

		$post = $this->request->post();
		$goodsid = isset($post['goodsid']) ? intval($post['goodsid']) : 0;
		$item = isset($post['item']) ? $post['item'] : [];
		if ($goodsid == 0 || (!is_array($item) || empty($item))) {
			$this->_error('参数错误', 400);
		}

		$data = [];
		foreach($item as $key => $value) {
			if (!isset($value['key_name']) || !isset($value['price']) || !isset($value['inventory'])) {
				$this->_error('参数错误', 400);
			}

			$data[] = [
				'goods_id' =>$goodsid,
				'key' => $key,
				'key_name' => $value['key_name'],
				'price' => $value['price'],
				'inventory' => $value['inventory'],
				'total' => $value['inventory'],
			];
		}


		$rs = (new SpecGoods_model())->manage($goodsid, $data);

		return $rs ? ['error'=>0, 'msg'=>'商品规格保存成功'] : $this->_error('商品规格保存失败' , 500);

	}
	
	/*
	 * 商品拥有的规格列表
	 * author zxl
	 */
	public function goodsSpecList(){
		$goods_id = $this->request->get('goods_id');
		if (!isset($goods_id) || empty($goods_id)) {
            $this->_error('商品id不能为空',400); 
        }
		return ['error'=>0 , 'data'=>(new SpecGoods_model())->goodsSpecList($goods_id)];
	}

	public function get_spec_goods() {
		$get = $this->request->get();
		$goodsid = isset($get['goodsid']) ? intval($get['goodsid']) : '';
		$spec_type = isset($get['spec_type']) ? intval($get['spec_type']) : '';

		if ($goodsid == 0 || $spec_type == 0) {
			$this->_error('参数错误');
		}

		$spec = (new Spec())->getAllByCatid($spec_type);
		
		$tmp = [];
		if (!empty($spec)) {
			$spec_ids = [];
			foreach ($spec as $key => $value) {
				$spec_ids[] = $value['id'];
			}

			$spec_item = (new SpecItem())->getAllBySpecid($spec_ids, 3);
			// $spec_item = (new SpecItem())->getAllBySpecid($spec_ids, (int)$this->_user['business']['business_id']);

			if (!empty($spec_item)) {
				foreach ($spec_item as $key => $value) {
					$tmp['spec_item'][$value['spec_id']][$value['id']] = $value;
					$tmp['spec_item_tmp'][$value['id']] = $value['spec_id'];
				}
				$spec_goods = (new SpecGoods_model())->getAllByGoodsid($goodsid);
				$tmp['tmp_ids'] = [];
				if (!empty($spec_goods)) {
					foreach ($spec_goods as $key => $value) {
						$tmp['spec_goods'][$value['key']] = $value;
						$spec_ids = explode('_', $value['key']);
						foreach ($spec_ids as $k => $val) {
							if (!in_array($val, $tmp['tmp_ids'])) {
								$tmp['tmp_ids'][] = $val;
								!isset($tmp['spec_item_tmp'][$val]) ?: $tmp['spec_key'][$tmp['spec_item_tmp'][$val]][] = $val;
							}
						}
					}
					if (empty($tmp['spec_key'])) {
						return ['error'=>0,'result'=>['spec'=>$spec,'spec_item'=>$tmp['spec_item'],'spec_goods'=>[],'spec_goods2'=>[], 'child'=>[]]];
					}
					else {
						$spec_goods2 = combineDika($tmp['spec_key']);
						return ['error'=>0,'result'=>['spec'=>$spec,'spec_item'=>$tmp['spec_item'],'spec_goods'=>$tmp['spec_goods'],'spec_goods2'=>$tmp['tmp_ids'], 'child'=>$tmp['spec_key']]];
					}
				}
				else {
					return ['error'=>0,'result'=>['spec'=>$spec,'spec_item'=>$tmp['spec_item'],'spec_goods'=>[],'spec_goods2'=>[], 'child'=>[]]];
				}
			}
			else {
				return ['error'=>0,'result'=>['spec'=>$spec,'spec_item'=>[],'spec_goods'=>[],'spec_goods2'=>[], 'child'=>[]]];
			}

		}

		return ['error'=>0,'result'=>['spec'=>[],'spec_item'=>[],'spec_goods'=>[],'spec_goods2'=>[], 'child'=>[]]];
		
	}

}