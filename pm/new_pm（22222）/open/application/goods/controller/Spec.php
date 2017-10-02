<?php
namespace app\goods\controller;

use app\common\controller\Base;
use app\goods\model\Spec as Spec_model;

class Spec extends Base {

	public function index() {

		$get = $this->request->get();

		$condition['wd'] = isset($get['wd']) ? trim($get['wd']) : '';
		$condition['cat_id'] = isset($get['cat_id']) ? trim($get['cat_id']) : '';
		$get['page'] = isset($get['page']) ? intval($get['page']) : 1;
		$get['page_size'] = isset($get['page_size']) && intval($get['page_size']) < config('max_size') ? intval($get['page_size']) : config('max_size');

		$data = (new Spec_model())->list_data($condition, $get['page'], $get['page_size']);
		
		return [
			'error' => 0,
			'result' => $data
		];

	}

	public function add() {
		$data['cat_id'] = (int)$this->request->post('cat_id');
		$data['name'] = $this->request->post('name');
		$data['sort'] = (int)$this->request->post('sort');
		if ($data['cat_id'] == 0 || empty($data['name'])) {
			$this->_error('参数错误', 400);
		}
		$data['oprid'] = $this->_uid;
		$data['intime'] = time();

		$rs = (new Spec_model())->add($data);

		return $rs ? ['status'=>200, 'msg'=>'操作成功'] : $this->_error('商品规格添加失败', 500);
	}

	public function edit() {
		$id = (int)$this->request->post('id');
		$data['cat_id'] = (int)$this->request->post('cat_id');
		$data['name'] = $this->request->post('name');
		$data['sort'] = (int)$this->request->post('sort');
		if ($id == 0 || $data['cat_id'] == 0 || empty($data['name'])) {
			$this->_error('参数错误', 400);
		}
		$data['oprid'] = $this->_uid;
		$data['uptime'] = time();

		$rs = (new Spec_model())->edit($id, $data);

		return $rs ? ['status'=>200, 'msg'=>'商品规格修改成功'] : $this->_error('商品规格修改失败', 500);
	}

	public function del() {
		$id = (int)$this->request->post('id');
		if ($id == 0) {
			$this->_error('参数错误', 400);
		}
		$data['oprid'] = $this->_uid;
		$data['uptime'] = time();
		$data['isdelete'] = 1;

		$rs = (new Spec_model())->edit($id, $data);

		return $rs ? ['error'=>0, 'msg'=>'商品规格删除成功'] : $this->_error('商品规格删除失败', 500);
	}
}