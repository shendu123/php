<?php
namespace app\goods\controller;

use app\common\controller\Base;
use app\goods\model\SpecItem as SpecItem_model;

class SpecItem extends Base {

	public function index() {

		$get = $this->request->get();

		$spec_id = isset($get['spec_id']) ? intval($get['spec_id']) : 0;
		if ($spec_id == 0) {
			$this->_error('参数错误', 400);
		}
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new SpecItem_model())->list_data($spec_id, (int)$this->_user['business']['business_id'], $get['page'], $get['page_size']);
		
		return [
			'error' => 0,
			'result' => $data
		];

	}

	public function add() {
		$data['spec_id'] = (int)$this->request->post('spec_id');
		$data['item'] = $this->request->post('item');
		if ($data['spec_id'] == 0 || empty($data['item'])) {
			$this->_error('参数错误', 400);
		}
		$data['business_id'] = $this->_user['business']['business_id'];
		$data['oprid'] = $this->_uid;
		$data['intime'] = time();

		$rs = (new SpecItem_model())->add($data);

		return $rs ? ['error'=>0, 'spec_item_id'=>$rs] : $this->_error('商品规格项添加失败', 500);
	}

	public function edit() {
		$id = (int)$this->request->post('id');
		$data['item'] = $this->request->post('item');
		if ($id == 0 || empty($data['item'])) {
			$this->_error('参数错误', 400);
		}
		$data['oprid'] = $this->_uid;
		$data['uptime'] = time();

		$rs = (new SpecItem_model())->edit($id, $this->_user['business']['business_id'], $data);

		return $rs ? ['error'=>0, 'msg'=>'商品规格项修改成功'] : $this->_error('商品规格项修改失败', 500);
	}

	public function del() {
		$id = (int)$this->request->post('id');
		if ($id == 0) {
			$this->_error('参数错误', 400);
		}
		$data['oprid'] = $this->_uid;
		$data['uptime'] = time();
		$data['isdelete'] = 1;

		$rs = (new SpecItem_model())->edit($id, $this->_user['business']['business_id'], $data);

		return $rs ? ['error'=>0, 'msg'=>'商品规格项删除成功'] : $this->_error('商品规格项删除失败', 500);
	}
}