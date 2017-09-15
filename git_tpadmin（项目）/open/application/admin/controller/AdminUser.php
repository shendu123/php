<?php

//------------------------
// 用户控制器
//-------------------------

namespace app\admin\controller;
use app\admin\Controller;
use think\Session;
use think\Exception;
use think\Loader;
use app\common\model\Member as MemberModel;
use think\Db;

class AdminUser extends Controller
{
    /**
     * 用户列表
     */
    public function index(){
        $params = $this->request->param();
        $where = '';
        if (isset($params['status']) && is_numeric($params['status'])) {
            $where['m.status'] = $params['status'];
        }
        if (isset($params['snType']) && !empty($params['snType']) && !empty($params['snText'])) {
            switch ($params['snType']) {
                case 'account':
                    $where['m.account'] = ['like', '%'. $params['snText']. '%'];
                    break;
                case 'realname':
                    $where['m.realname'] = ['like', '%'. $params['snText']. '%'];
                    break;
                case 'role_id':
                    $where['mr.role_id'] = $params['snText'];
                    break;
            }
        }
        $page = $this->request->get('page', 1);
        $pageSize = $this->request->get('pageSize', 20);
        $field = 'm.uid,m.account,m.truename,m.status,r.name';
        $join  = [['member_role mr', 'm.uid=mr.uid', 'left'], ['role r', 'mr.role_id=r.id', 'left']];
        $count = Db::name('member')->alias('m')->join($join)->where($where)->field($field)->count();
        $userList  = Db::name('member')->alias('m')->join($join)->where($where)->field($field)->group('m.uid')->page($page,$pageSize)->order('uid asc')->select();
        $result = [
            'data' => $userList,
            'page' => $page,
            'pageSize' => $pageSize,
            'count' => $count,
        ];
        return json($result, 200);
    }
    
    /**
     * 添加用户
     */
    public function add()
    {
        $params = $this->request->param();
        if (empty($params)) {
            return json(['message' => '请求参数错误'], 400);
        }
        $userModel = new MemberModel();
        $validateUser = validate('member');
        if (!$validateUser->check($params)) {
            return json(['message' => $validateUser->getError()], 400);
        }
        try {
            $password = $params['password'];
            $params['pwd'] = md5($password);
            unset($params['password']);
//            $params['create_time'] = time();
//            $params['last_login_ip'] = $this->request->ip();
            $userModel->allowField(true)->isUpdate(false)->save($params);
            return json(['tip' => '新增成功'], 200);
        } catch (\Exception $e) {
            return json(['message' => '新增失败'], 500);
        }
    }
    
    /**
     * 显示编辑资源表单页.
     */
    public function edit($id)
    {
        if (empty($id)) {
            return json(['message' => '请求参数错误'], 400);
        }
        $result = MemberModel::get($id);
        $list = [];
        $list['uid'] = $result['uid'];
        $list['account'] = $result['account'];
        $list['truename'] = $result['truename'];
        $list['status'] = $result['status'];
        return json($list, 200); 
    }

    /**
     * 保存更新的资源
     */
    public function update($id)
    {
        if (empty($id)) {
            return json(['message' => '请求参数错误'], 400);
        }
        $params = $this->request->param();
        $userModel = new MemberModel();//print_r($params);exit;
        if(!isset($params['password'])){
            unset($params['pwd']);
        }else{
            $params['pwd'] = md5($params['password']);
            unset($params['password']);
        }        
        //启动事务
        Db::startTrans();
        try {
            //$params['update_time'] = time();
            $userModel->allowField(true)->save($params, ['uid' => $id]);
            Db::commit();
            return json(['tip' => '更新成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['message' => '更新失败'], 500);
        }
    }

    /**
     * 删除
     */
    public function delete($id)
    {
        if (empty($id)) {
            return json(['message' => '请求参数错误'], 400);
        }
        try {
            MemberModel::destroy($id);
            return json(['tip' => '操作成功'], 200);
        } catch (Exception $e) {
            return json(['message' => '操作失败'], 500);
        }
    }
    
    /**
     * 修改状态
     */
    public function changeStatus(){
        $user_id = $this->request->param('id/d');
        $params['status'] = $this->request->param('status/d');//echo $params['status'];exit;
        $userModel = new MemberModel();
        //启动事务
        Db::startTrans();
        try {
            $userModel->allowField(true)->save($params, ['uid' => $user_id]);
            Db::commit();
            return json(['tip' => '更新成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['message' => '更新失败'], 500);
        }
    }

    /**
     * 禁用限制
     */
    protected function beforeForbid()
    {
        // 禁止禁用 Admin 模块,权限设置节点
        $this->filterId(1, '该用户不能被禁用', '=');
    }
}