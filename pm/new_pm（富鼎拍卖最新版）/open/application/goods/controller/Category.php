<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;

class Category extends Base
{

    /**
     * @function 分类列表页
     *
     * @author ljx
     */
    public function index() {
		$condition['sysid'] = $this->_sysid;
		$condition['user'] = $this->_user;
        return \Tree::format(
            (new \app\goods\model\Category())->getList($condition),
            $this->request->get('toHtml', 1),
            ['parentKey' => 'cat_pid', 'nameKey' => 'cat_name']
        );
    }
	
	//给外部调用
	public function catList(){
		$param = request()->param();
		$where = [];
		if( isset($param['cat_id']) && !empty($param['cat_id']) ){
			$where['id'] = $param['cat_id'];
		}
		$list = model('category')->where($where)->select();
		return [
			'data' => $list,
			'count' => count($list)
		];
	}

    /**
     * @function 添加分类
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            if (! empty($requestData['cat_icon'])) {
                $requestData["cat_icon"] = $requestData['cat_iconArray'];
            }
            $validateAdv = validate('Category');
			if (!$validateAdv->check($requestData)) {
				$this->_error($validateAdv->getError(), 400);
			}
			$this->_user['sysid'] = $this->_sysid;
            $model = new \app\goods\model\Category();
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
     * @function 编辑分类
     *
     * @author ljx
     *         TODO 分类图片修改暂未实现
     */
    public function edit()
    {
        if (request()->isPost()) {
            $id = valueRequest('id', 0);
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                if (! empty($requestData['cat_iconArray'])) {
                    $requestData["cat_icon"] = $requestData['cat_iconArray'];
                }
				$validateAdv = validate('Category');
				if (!$validateAdv->check($requestData)) {
					$this->_error($validateAdv->getError(), 400);
				}				
                $model = new \app\goods\model\Category();
				$this->_user['sysid'] = $this->_sysid;
                $result = $model->edit($requestData, $this->_user);
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
     * @function 删除分类
     * @author ljx
     */
    public function delete()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Category();
            $wdata = array(
                'ids' => $ids
            );
			if($model->where(['cat_pid' => $ids])->find()){
				$this->_error('此分类下有子分类，不能删除，请先删除子类',500);
			}
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
     * @function 启用禁用 可批量
     * @author ljx
     */
    public function ableAll()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        $value = valueRequest('value', 0);
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Category();
            $wdata = array(
                'ids' => $ids,
                'value' => $value
            );

            $result = $model->ableAll($wdata, $this->_user);
            if ($result === false) {
                return array(
                    'status' => 500,
                    '操作失败~'
                );
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
     * @function 根据分类id获取下级分类
     * @author ljx
     */
    public function getOffspring($id = 0){
        $id_r = valueRequest('id', 0);
        $id = $id_r ? $id_r : $id;
        
        
    }
	
	/*
	 * ajax更新排序/是否显示
	 */
	public function changeSortOrShow(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(isset($data['cat_sort'])&&!is_numeric($data['cat_sort'])){
				$this->_error('排序参数非法',400);
			}
			if(isset($data['is_show'])&&!in_array($data['is_show'],[0,1])){
				$this->_error('is_show参数非法',400);
			}
			$model = new \app\goods\model\Category();
			$this->_user['sysid'] = $this->_sysid;
			if(!$model -> edit($data , $this->_user)){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新成功'];			
		}
	}
	
	/*
	 * 添加/更换分类logo  cat_icon
	 */
	public function changeLogo(){
		$data=request()->param();
		if(!isset($data['id'])||!is_numeric($data['id'])){
			$this->_error('参数错误',400);
		}
		if (!isset($data['cat_icon'])||empty($data['cat_icon'])) {
            $this->_error('参数错误',400);
		}
		$model = new \app\goods\model\Category();
		if(!$model->edit($data)){
			$this->_error('更新数据库失败',500);
		}
		return ['msg'=>'操作成功'];
	}
}
