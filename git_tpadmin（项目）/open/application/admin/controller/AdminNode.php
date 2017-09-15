<?php

//------------------------
// 节点控制器
//-------------------------

namespace app\admin\controller;
use app\admin\Controller;
use think\Db;
use think\Loader;
use app\common\model\Node as NodeModel;
use think\Request;

class AdminNode extends Controller
{

    /**
     * 首页
     */
    public function index()
    {
        $nodeModel=new NodeModel();
        $tree =$nodeModel->getNodeListTree();//echo "<pre>";print_r($tree[0]['ChildNodes']);exit;
        return json(['data'=>$tree[0]['ChildNodes']],200);
    }
    /**
     * 添加
     */
    public function add(Request $request)
    {
        $params = $request->param();
        if ($params['pid']===false) {
                return json(['message' => '缺少父节点'], 400);
        }
        $node = Db::name("Node")->where("id", $params['pid'])->field("id,level")->find();
        $params['level'] = intval($node['level']) + 1;
        $nodeModel = new NodeModel();
        $validateNode = validate('Node');
        if (!$validateNode->check($params)) {
            return json(['message' => $validateNode->getError()], 400);
        }
        //启动事务
        Db::startTrans();
        try {
            $nodeModel->allowField(true)->isUpdate(false)->save($params);
            Db::commit();
            return json(['tip' => '新增成功'], 200);
        } catch (\Exception $e) {
            Db::rollback();
            return json(['message' => '新增失败'], 500);
        }
    }
    
     /**
     * 添加子节点
     */
    public function addChild(Request $request)
    {
        $params = $request->param();
        if ($params['npid']===false) {
                return json(['message' => '缺少父节点'], 400);
        }
        $node = Db::name("Node")->where("id", $params['npid'])->field("id,level")->find();
        $params['level'] = intval($node['level']) + 1;
        $nodeModel = new NodeModel();
        $validateNode = validate('Node');
        $params['pid']=$params['npid'];
        unset($params['npid']);        
        if (!$validateNode->check($params)) {
            return json(['message' => $validateNode->getError()], 400);
        }
        //启动事务
        Db::startTrans();
        try {
            $nodeModel->allowField(true)->isUpdate(false)->save($params);
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
        $result = NodeModel::get($id);
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
        $nodeModel = new NodeModel();
        //启动事务
        $node = Db::name("Node")->where("id", $params['pid'])->field("id,level")->find();
        $params['level'] = intval($node['level']) + 1;
        Db::startTrans();
        try {
            $nodeModel->allowField(true)->save($params, ['id' => $id]);
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
            NodeModel::destroy($id);
            return json(['tip' => '操作成功'], 200);
        } catch (Exception $e) {
            return json(['message' => '操作失败'], 500);
        }
    }


    /**
     * 首页
     */
    /*public function index()
    {
        $list = Db::name('Node')->order('sort asc')->where('isdelete=0')->select();
        //分组信息
        $list_group = Loader::model('AdminGroup')->getList();
        $group = reset_by_key($list_group, "id");
        $node = [];
        foreach ($list as $vo) {
            $name = '<span class="c-warning">[ ' . ($vo['level'] == 1 ? '模块' : ($vo['type'] ? '控制器' : '方法')) . ' ]</span> '
                . $vo['title'] . " (" . $vo['name'] . ") "
                . (isset($group[$vo['group_id']]) ? '<span style="color:red"> [ ' . $group[$vo['group_id']]['name'] . ' ]</span>' : '')
                . ' <a></a><span class="c-secondary">[ 层级：' . $vo['level'] . ' ]</span> '
                . show_status($vo['status'], $vo['id'])
                . ' <a class="label label-primary radius J_add" data-id="' . $vo['id'] . '" href="javascript:;" title="添加子节点">添加</a>';
            $node[] = [
                'id'   => $vo['id'],
                'pId'  => $vo['pid'],
                'sort' => $vo['sort'],
                'name' => $name,
            ];
        }
        $this->view->assign('node', json_encode($node));
        $this->view->assign('count', count($list));

        return $this->view->fetch();
    }*/
}
