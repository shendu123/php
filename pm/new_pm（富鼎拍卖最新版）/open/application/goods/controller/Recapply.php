<?php
namespace app\goods\controller;

use app\common\controller\Base;
use think\Request;
use think\Db;

/**
 * @class 商品推荐申请管理
 * @author ljx
 */
class Recapply extends Base
{

    /**
     * @function 列表
     *
     * @author ljx
     */
    public function index()
    {
        $model = new \app\goods\model\Recommendapply();
        
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'check' => valueRequest('check', 'eq|0', 'string'),
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
            
            // 检查是否重复推荐
            $result_checkApply = $this->checkApply($requestData);
            if($result_checkApply !== true){
                return $result_checkApply;
            }
            
            $requestData['apply_pos_ids'] = explode(',', $requestData['apply_pos_ids']);
            sort($requestData['apply_pos_ids']);
            $requestData['apply_pos_ids'] = implode(',', $requestData['apply_pos_ids']);
            
            ! empty($requestData['apply_starttime']) ? $requestData['apply_starttime'] = strtotime($requestData['apply_starttime']) : '';
            ! empty($requestData['apply_endtime']) ? $requestData['apply_endtime'] = strtotime($requestData['apply_endtime']) : '';
            
            if($requestData['apply_starttime']>$requestData['apply_endtime']){
                $this->_error('起始时间不能大于结束时间', 500);
            }
            $model = new \app\goods\model\Recommendapply();
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
     * @function 是否可以申请推荐
     * @author ljx
     */
    private function checkApply($requestData)
    {
        // TODO 考虑推荐区域增加的情况 
        
        // TODO 稳定后再整
        $sql_query = "SELECT * FROM opg_recommend_apply 
            WHERE 1=1 
            AND apply_stuff_type = '{$requestData['apply_stuff_type']}'
            AND apply_stuff_id = '{$requestData['apply_stuff_id']}'
            AND apply_status != 2
            AND apply_endtime > '{$_SERVER['REQUEST_TIME']}' 
        ";
        $data = Db::query($sql_query);
        
        if(empty($data)){
            return true;
        }else{
            $data = $data[0];
            
            if($data['apply_status'] == 0){
                $returnData = array(
                    'status' => 404,
                    'error' => '该商品已经发起申请推荐，等待审核'
                );
            }else if($data['apply_status'] == 1 && $data['apply_endtime'] > $_SERVER['REQUEST_TIME']){
                $returnData = array(
                    'status' => 404,
                    'error' => '该商品已发起过推荐,且推荐时间暂未结束'
                );
            }
            
            return $returnData;
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
                
                $model = new \app\goods\model\Recommendapply();
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
            $model = new \app\goods\model\Recommendapply();
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
     * @function 审核
     * @author ljx
     *
     */
    public function check()
    {
        if (request()->isPost()) {
            $wdata = array();
            $id = valueRequest('id', 0);
            $value = valueRequest('value', 0);
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
                    $wdata['apply_check_reason'] = $reason;
                    break;
                default:
                    $this->_error('value参数值不正确', 400);
                    break;
            }
            $wdata['apply_status'] = $value;
            $model = new \app\goods\model\Recommendapply();
            
            //Db::startTrans();
            
            $result = $model->check($wdata, $this->_user);
            if ($result === false) {
                //Db::rollback();
                $this->_error('system error', 500);
            }
            // 审核通过 加入商品推荐表
            if($value == 1){
                $result_onCheckSuc = $this->onCheckSuc($id);
                if($result['status'] != 200){
                    //Db::rollback();
                    return $result_onCheckSuc;
                }
            }

            //Db::commit();
            return array(
                'status' => 200,
                'msg' => '操作成功'
            );
        } else {
            ;
        }
    }
    
    /**
     * @function 审核通过后执行的事情
     * @author ljx
     */
    private function onCheckSuc($id){
        // case 审核通过 加入商品推荐表
        $row = $this->detail($id);
        $row = $row['data'];
        
        $rec_pos_arr = explode(',', $row['apply_pos_ids']);
        $rec_pos_arr = array_unique(array_filter($rec_pos_arr));

        $goodsRecModel = new \app\goods\model\Goodsrecommend();
        // TODO 一次写入
        foreach($rec_pos_arr as $key => $val){
            $requestData = array(
                'business_id' => $row['business_id'],
                'rec_stuff_type' => $row['apply_stuff_type'],
                'rec_stuff_id' => $row['apply_stuff_id'],
                'rec_pos_id' => $val,
                'rec_oprid' => $this->_user['user']['user_id'],
                'rec_intime' => $_SERVER['REQUEST_TIME'],
                'rec_uptime' => $_SERVER['REQUEST_TIME'],
                'rec_starttime' => $row['apply_starttime'],
                'rec_endtime' => $row['apply_endtime'],
            );
            $result = Db::name('goods_recommend')->insert($requestData);
            if ($result === false) {
                return array(
                    'status' => 404,
                    'msg' => '加入推荐失败'
                );
            }
        }

        return array(
            'status' => 200,
            'msg' => '操作成功',
            'new_id' => $result
        );
    }
    
    /**
     * @function 详情
     *
     * @author ljx
     */
    public function detail()
    {
        $id = valueRequest('id', 0);
        if (! empty($id)) {
            $model = new \app\goods\model\Recommendapply();
    
            $wdata = array(
                'id' => $id
            );
    
            $result = $model->getRow($wdata);
            if (! empty($result)) {
                return array(
                    'status' => 200,
                    'msg' => '操作成功',
                    'data' => $result
                );
            } else {
                $this->_error('商品不存在或已删除~', 500);
            }
        } else {
            $this->_error('商品不存在或已删除~', 500);
        }
    }
}
