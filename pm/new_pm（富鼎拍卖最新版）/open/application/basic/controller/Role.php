<?php
/**
 * @Author AJMstr
 * @date 2017-5-5
 */
namespace app\basic\controller;

use app\common\controller\Base;

class Role extends Base {

    public function index() {
        $businessId = input('business_id');
        return ['data' => \Tree::format(
            model('Role')->getAllBy(
                $this->_sysid,
                $businessId
            ),
            $this->request->get('toHtml', 1)
        )];
    }
    
    public function authorize(){
        $sidStr='1,2,3,4,5';
        if(request()->isPost()){
            $param=request()->get();//dump($param);exit;
            $roleId=$param['roleId'];
            $nodeId=$param['nodeId'];            
            foreach(explode(',',$nodeId) as $k=>$v){
                $data[$k]['node_id']=$v;
                $data[$k]['role_id']=$roleId;
            }
            model('RoleNode')->where('role_id', $roleId)->delete();
            if(!model('RoleNode')->saveAll($data)){
                $this->_error('授权失败', 500);
            }
            return ['msg'=> '授权成功'];
        }else{
            $roleIDs = request()->get('id');
            $access=model('Node')->getNodesBy(
                    $roleIDs,
                    $sidStr,
                    $where=[]
            );
            //dump($access);exit;
            $ids=[];
            foreach($access as $k=>$v){
                $ids[]=$v['id'];
                if($v['pid']){
                   $ids[]=$v['pid']; 
                }
            }
            return array_unique($ids);             
        }               
    }

    public function add() {
        $this->_checkRole();
		$data = $this->request->post();
		unset($data['pname']);
        if(! model('Role')->save($data)) {
            $this->_error('保存失败，请稍后再试', 500);
        }

        return ['msg'=> '添加成功'];
    }

    private function _checkRole() {
        if(true !== ($validate = $this->validate($this->request->post(), 'Role'))) {
            $this->_error($validate, 400);
        }
    }

    public function edit() {
        if(! model('Role')->allowField(['name','remark'])->save($this->request->post(), ['id' => $this->request->post('id')])) {
            $this->_error('编辑失败，请稍后再试', 500);
        }

        return ['msg'=> '编辑成功'];
    }

    public function delete() {
        $where['id']=['in',$this->request->get('id')];
		if(model('Role')->where(['pid' => $where['id']])->find()){
			$this->_error('此角色含有子角色，不能删除，请先删除子角色', 500);
		}
        if(! model('Role')->where($where)->delete()) {
            $this->_error('删除失败，请稍后再试', 500);
        }

        return ['msg'=> '删除成功'];
    }

    /**
     * [角色状态设置]
     */
    public function changeStatus() {
        if(request()->isPost()){
            $id=request()->param('id');
            $data['status']=request()->param('status');
            if(model('Role')->where(['id'=>['in',$id]])->update($data)===false){
                $this->_error('设置失败'.model('Role')->getLastSql(), 500);
            }
            return ['msg'=> '设置成功'];
        }        
    }
}