<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;
use think\Db;

class Brandapply extends Base
{

    /**
     * @function 品牌申请 列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Brandapply();
        
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
			'sysid' => $this->_sysid,
			'business_id' => $this->_user['business']['business_id'],
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'keyword' => valueRequest('keyword', '', 'string')
        );
        
        $result = $model->getList($wdata, $this->_user);
        
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
     * @function 商户品牌申请 列表
     *
     * @author ljx
     */
    public function getList()
    {
        $model = new \app\goods\model\Brandapply();
        
        $wdata = array(
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 20),
            'business_id' => $this->_user['business']['business_id'],
			'sysid' => $this->_sysid,
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'keyword' => valueRequest('keyword', '', 'string')
        );
        
        $result = $model->getList($wdata, $this->_user);
        
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
     * @function 品牌申请 添加
     *
     * @author ljx
     */
    public function add()
    {
        if (request()->isPost()) {
            $model = new \app\goods\model\Brandapply();
            $requestData = Request::instance()->post();
            
            if (! empty($requestData['apply_stuff'])) {
                $requestData["apply_stuff"] = $requestData['apply_stuffArray'];
            }
            
            // 表单数据有效性拦截验证
            if (empty($requestData['apply_brand_name'])) {
                $this->_error('品牌名称不能为空', 400);
            }
            if (empty($requestData['cat_id'])) {
                $this->_error('请选择分类', 400);
            }
            
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
     * @function 品牌申请 删除
     *
     * @author ljx
     */
    public function delete()
    {
        $id_single = valueRequest('id', 0);
        $id_multi = valueRequest('ids', '', 'string');
        
        $ids = $id_single ? $id_single : $id_multi;
        
        if (! empty($ids)) {
            $model = new \app\goods\model\Brandapply();
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
     * @function 品牌申请 审核
     * @author ljx
     *        
     */
    public function check()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = valueRequest('id', 0);
            $value = valueRequest('value', 0); // apply_status
            if (empty($id)) {
                $this->_error('id不能为空', 400);
            }
            $wdata['id'] = $id;
            switch ($value) {
                case 1: // 审核成功
                    break;
                case 2: // 审核失败 需要填写审核失败原因
                    $reason = valueRequest('reason', '', 'string');
                    if (empty($reason)) {
                        $this->_error('reason【审核失败原因】参数值不能为空', 400);
                    }
                    $wdata['apply_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['apply_status'] = $value;
            $model = new \app\goods\model\Brandapply();
            
            Db::startTrans();
            
            // case 审核
            $result_check = $model->check($wdata, $this->_user);
            if ($result_check === false) {
                Db::rollback();
                $this->_error('system error', 500);
            }
            // case 审核通过
            $result_onCheckSuc = $this->onCheckSuc($id);
            if($result_onCheckSuc['status'] != 200){
                Db::rollback();
                return $result_onCheckSuc;
            }
            
            // case 审核失败
            // do nothing
            
            Db::commit();
            return array(
                'status' => 200,
                'msg' => '操作成功'
            );
        } else {
            ;
        }
    }

    /**
     * @function 详情
     * @author ljx
     *        
     * @param integer $id
     */
    public function getDetail($id = 0)
    {
        $id_r = valueRequest('id', 0);
        $id = $id ? $id : $id_r;
        
        if (! empty($id)) {
            $model = new \app\goods\model\Brandapply();
            $wdata = array(
                'id' => $id
            );
            $row = $model->getRow($wdata, $this->_user);
            if (empty($row)) {
                return array(
                    'status' => 500,
                    'msg' => '详情不存在'
                );
            } else {
                return array(
                    'status' => 200,
                    'data' => $row
                );
            }
        } else {
            $this->_error('参数id不能为空', 400);
        }
    }

    /**
     * @function 审核成功的处理
     * @author ljx
     *        
     * @param integer $id
     */
    private function onCheckSuc($id)
    {
        $row = $this->getDetail($id);
        $row_apply = $row['data'];
        
        // case brand
        $brand_id = '';
        $brandModel = new \app\goods\model\Brand();
        $wdata = array(
            'brand_name' => $row_apply['apply_brand_name']
        );
        $row_brand = $brandModel->getRowByName($wdata, $this->_user);
        if (empty($row_brand)) {
            $requestData = array(
                'cat_id' => $row_apply['cat_id'],
                'brand_name' => $row_apply['apply_brand_name']
            );
            $result_add_brand = $brandModel->add($requestData, $this->_user);
            if (empty($result_add_brand)) {
                return array(
                    'status' => 500,
                    'msg' => '自动创建品牌失败'
                );
            } else {
                $brand_id = $result_add_brand;
            }
        } else {
            $brand_id = $row_brand['id'];
        }
        
        // case brand_rule
        $brandRuleModel = new \app\goods\model\BrandRule();
        $requestData = array(
            'brand_id' => $brand_id,
            'business_id' => $row_apply['business_id'],
            'cat_id' => $row_apply['cat_id']
        );
        $row_brandrule = $brandRuleModel->getRowByRule($requestData, $this->_user);
        if (! empty($row_brandrule)) {
            return array(
                'status' => 200,
                'msg' => '该品牌已经授权'
            );
        } else {
            $requestData = array(
                'brand_id' => $brand_id,
                'business_id' => $row_apply['business_id'],
                'cat_id' => $row_apply['cat_id']
            );
            $result_add_rule = $brandRuleModel->add($requestData, $this->_user);
            if (empty($result_add_rule)) {
                return array(
                    'status' => 500,
                    'msg' => '授权失败'
                );
            } else {
                return array(
                    'status' => 200,
                    'msg' => '授权成功'
                );
            }
        }
    }
}
