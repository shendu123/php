<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;

class Recposition extends Base
{

    /**
     * @function 列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Recommendposition();
        
        $wdata = array(
            'keyword' => valueRequest('keyword', '', 'string')
        );
        $result = $model->getList($wdata);
        
        return $result;
    }

    /**
     * @function 添加
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $requestData = Request::instance()->post();
            
            $model = new \app\goods\model\Recommendposition();
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
     * @function 编辑
     *
     * @author ljx
     */
    public function edit()
    {
        if (request()->isPost()) {
            $id = valueRequest('id', 0);
            
            if (! empty($id)) {
                $requestData = Request::instance()->post();
                
                $model = new \app\goods\model\Recommendposition();
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
     * @function 删除
     *
     * @author ljx
     */
    public function delete()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Recommendposition();
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
     * @function 对外用列表接口
     *
     * @author ljx
     */
    public function getList($params = array())
    {
        $model = new \app\goods\model\Recommendposition();
        $wdata = array();
        
        isset($params['keyword']) ? $wdata['keyword'] = $params['keyword'] : $wdata['ids'] = valueRequest('keyword', '', 'string');
        isset($params['ids']) ? $wdata['ids'] = $params['ids'] : $wdata['ids'] = valueRequest('ids', '', 'string');

        $result = $model->getList($wdata);
    
        return $result;
    }
}














