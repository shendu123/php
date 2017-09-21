<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;

class Brand extends Base
{

    /**
     * @function 品牌列表页
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Brand();
        
        $wdata = array(
            'cat_id' => valueRequest('cat_id', 0),
            'keyword' => valueRequest('keyword', '', 'string')
        );
        $result = $model->getList($wdata);
        
        return $result;
    }

    /**
     * @function 添加品牌
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $catModel = new \app\goods\model\Brand();
            $requestData = Request::instance()->post();
            
            if (! empty($requestData['brand_icon'])) {
                $requestData["brand_icon"] = $requestData['brand_iconArray'];
            }
            
            $model = new \app\goods\model\Brand();
            $result = $model->add($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败', 500);
            } else {
                return array(
                    'status' => 200,
                    'msg' => '操作成功'
                );
            }
        }
    }

    /**
     * @function 编辑品牌
     *
     * @author ljx
     *         TODO 品牌图片修改暂未实现
     */
    public function edit()
    {
        if (request()->isPost()) {
            $id = valueRequest('id', 0);
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                if (! empty($requestData['brand_icon'])) {
                    $requestData["brand_icon"] = $requestData['brand_iconArray'];
                }
                $operateData = array(); // 存放接口请求者信息 TODO 当前接口请求者信息需要从用户中心那边提供
                
                $model = new \app\goods\model\Brand();
                $result = $model->edit($requestData, $operateData);
                if ($result === false) {
                    $this->_error('操作失败', 500);
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
    }

    /**
     * @function 删除品牌
     *
     * @author ljx
     */
    public function delete()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Brand();
            $wdata = array(
                'ids' => $ids
            );
            $operateData = array();
            $result = $model->delete($wdata, $operateData);
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
	
	/*
	 * 添加/更换品牌logo  brand_icon
	 */
	public function changeLogo(){
		$data=request()->param();
		if(!isset($data['id'])||!is_numeric($data['id'])){
			$this->_error('参数错误',400);
		}
		if (!isset($data['brand_icon'])||empty($data['brand_icon'])) {
            $this->_error('参数错误',400);
		}
		$model = new \app\goods\model\Brand();
		if(!$model->edit($data)){
			$this->_error('更新数据库失败',500);
		}
		return ['msg'=>'操作成功'];
	}
}

