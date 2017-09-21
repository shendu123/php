<?php
namespace app\goods\controller;

use app\common\controller\Base;
use app\goods\model\SpecGoods as SpecGoods_model;

class SpecGoods extends Base {

	public function manage() {

		$post = $this->request->post();
		$goodsid = intval($post['goodsid']);
		$item = $post['item'];
		if ($goodsid == 0 || !is_array($item)) {
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

}