<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;

class Goodsrec extends Base
{

    /**
     * @function 列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Goodsrecommend();
        
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'onsale' => valueRequest('onsale', 'egt|0', 'string'),
            'keyword' => valueRequest('keyword', '', 'string')
        );
        $result = $model->getList($wdata, $this->_user);
        
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
            
            $model = new \app\goods\model\Goodsrecommend();
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
                
                ! empty($requestData['rec_starttime']) ? $requestData['rec_starttime'] = strtotime($requestData['rec_starttime']) : '';
                ! empty($requestData['rec_endtime']) ? $requestData['rec_endtime'] = strtotime($requestData['rec_endtime']) : '';
                
                $model = new \app\goods\model\Goodsrecommend();
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
            $model = new \app\goods\model\Goodsrecommend();
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
     * @function 批量上架
     * @author ljx
     */
    public function onsaleAll(){
        $id_multi = valueRequest('ids', '', 'string');
        $value = valueRequest('value', 0);
        $ids = $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Goodsrecommend();
            $wdata = array(
                'ids' => $ids,
                'value' => $value
            );

            $result = $model->ableAll($wdata, $this->_user);
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
}
