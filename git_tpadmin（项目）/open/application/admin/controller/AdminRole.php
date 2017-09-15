<?php
//------------------------
// 角色控制器
//-------------------------

namespace app\admin\controller;
use app\admin\Controller;
use think\Exception;
use think\Db;
use think\Loader;
use app\common\model\Role as RoleModel;
use think\Request;
use think\Cache;

class AdminRole extends Controller
{
    
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index(Request $request)
    {
        $params = $request->param();
        $where = '';
        if (isset($params['status']) && is_numeric($params['status'])) {
            $where['r.status'] = $params['status'];
        }
        if (isset($params['snText'])) {
            $where['r.name'] = ['like', '%'. $params['snText'] .'%'];
        }
        $page = $request->get('page', 1);
        $pageSize = $request->get('pageSize', 10);
        //总数
        $field = 'm.uid as uid,m.account,m.truename,r.id,r.name,r.remark,r.status,r.create_time,r.update_time';
        $join  = [['member_role mr', 'mr.role_id=r.id', 'left'], ['member m','m.uid=mr.uid', 'left']];
        $count = Db::name('role')->alias('r')->join($join)->where('r.isdelete = 0')->where($where)->field($field)->count();
        $roleList=Db::name('role')->alias('r')->join($join)->where('r.isdelete = 0')->where($where)->field($field)->page($page,$pageSize)->order('r.id asc')->select();
        foreach($roleList as $k=>$v){
            $roleUserList[0]='';
            $roleUserList[$v['id']]['id']=$v['id'];
            $roleUserList[$v['id']]['name']=$v['name'];
            $roleUserList[$v['id']]['remark']=$v['remark'];
            $roleUserList[$v['id']]['status']=$v['status'];
            $roleUserList[$v['id']]['create_time']=$v['create_time'];
            $roleUserList[$v['id']]['update_time']=$v['update_time'];
            if($v['uid']){
                $roleUserList[$v['id']]['userlist'][$v['uid']]['account']=$v['account'];
                $roleUserList[$v['id']]['userlist'][$v['uid']]['truename']=$v['truename'];
            }
        }
        $result = [
            'data' => $roleUserList,
            'page' => $page,
            'pageSize' => $pageSize,
            'count' => $count,
        ];//print_r($result);exit;
        return json($result, 200);
    }

    /**
     * 添加
     */
    public function add(Request $request)
    {
        $params = $request->param();
        if (empty($params)) {
            return json(['message' => '请求参数错误'], 400);
        }
        $roleModel = new RoleModel();
        $validateRole = validate('Role');
        if (!$validateRole->check($params)) {
            return json(['message' => $validateRole->getError()], 400);
        }
        //启动事务
        Db::startTrans();
        try {
            $params['create_time'] = time();
            $params['update_time'] = time();
            $roleModel->allowField(true)->isUpdate(false)->save($params);
            Db::commit();
            return json(['tip' => '新增成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
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
        $result = RoleModel::get($id);
        if ($result) {
            unset($result['create_time']);
            unset($result['update_time']);
        }
        return json($result, 200); 
    }

    /**
     * 保存更新的资源
     */
    public function update(Request $request, $id)
    {
        if (empty($id)) {
            return json(['message' => '请求参数错误'], 400);
        }
        $params = $request->param();
        $roleModel = new RoleModel();
        if ($roleModel->isHas($id, $params['name'])) {
            return json(['message' => '该角色名称已存在'], 400);
        }
        //启动事务
        Db::startTrans();
        try {
            $params['update_time'] = time();
            $roleModel->allowField(true)->save($params, ['id' => $id]);
            Db::commit();
            return json(['tip' => '更新成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['message' => '更新失败'], 500);
        }
    }

    /**
     * 删除
     * @param Request $request
     * @return \think\response\Json
     */
    public function delete($id)
    {
        if (empty($id)) {
            return json(['message' => '请求参数错误'], 400);
        }
        try {
            RoleModel::destroy($id);
            return json(['tip' => '操作成功'], 200);
        } catch (Exception $e) {
            return json(['message' => '操作失败'], 500);
        }
    }


    /**
     * 用户列表
     */
    public function user()
    {
        $role_id = $this->request->param('id/d');
        if (!$role_id) {
                return json(['message' => '缺少必要参数'], 400);
        }
        if ($this->request->isPost()) {
            // 提交
            $db_member_role = Db::name("MemberRole");
            //删除之前的角色绑定
            $db_member_role->where("role_id", $role_id)->delete();
            //写入新的角色绑定
            $data = $this->request->post();//print_r($data);exit;
            if (isset($data['user_id']) && !empty($data['user_id']) && is_array($data['user_id'])) {
                $insert_all = [];
                foreach ($data['user_id'] as $v) {
                    $insert_all[] = [
                        "role_id" => $role_id,
                        "uid" => intval($v),
                    ];
                }
                $db_member_role->insertAll($insert_all);
            }
            return json(['tip' => '分配角色成功'], 200);
        } else {
            // 编辑页读取系统的用户列表
           // $list_user = Db::name("AdminUser")->field('id,account,realname')->where('status=1 AND id > 1')->select();
            // 已授权权限
            $list_member_role = Db::name("MemberRole")->where("role_id", $role_id)->select();
            $checks = filter_value($list_member_role, "uid");
            $result=[
             //   'list'=>$list_user,直接从用户列表接口获取
                   'data'=>  $checks//当前角色下的用户id
                
            ];
            return json($result,200);
        }
    }
    
    /**
     * 修改状态
     */
    public function changeStatus(){
        $role_id = $this->request->param('id/d');
        $params['status'] = $this->request->param('status/d');
        $roleModel = new RoleModel();
        //启动事务
        Db::startTrans();
        try {
            $roleModel->allowField(true)->save($params, ['id' => $role_id]);
            Db::commit();
            return json(['tip' => '更新成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['message' => '更新失败'], 500);
        }
    }

    /**
     * 授权
     * @return mixed
     */
    public function access()
    {
        $role_id = $this->request->param('id/d');
        if (!$role_id) {
            return json(['message' => '缺少必要参数'], 400);
        }        
        if ($this->request->isPost()) {
            if (true !== $error = Loader::model('RoleNode', 'logic')->insertAccess($role_id, $this->request->post())) {
                return ajax_return_adv_error($error);
            }
             //Cache::rm('member_auth_' . Cache::get(Config::get('rbac.user_auth_key')));
            return json(['tip'=>'权限分配成功'], 200);
        } else {
            $accesses = Db::name("RoleNode")->where("role_id", $role_id)->select();
            //$accesses_node = filter_value($accesses, "node_id");
            $result=[];
            foreach($accesses as $v){
                $result['access_id'][]=$v['node_id'];
                $result['access_value'][]=$v['node_id']."_".$v['level']."_".$v['pid'];
            }
            //print_r($result);exit;
            return json($result,200);
        }
    }
}
