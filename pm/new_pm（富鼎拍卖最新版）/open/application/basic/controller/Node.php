<?php
/**
 * @Author AJMstr
 * @date 2017-5-5
 */
namespace app\basic\controller;

use app\common\controller\Base;

class Node extends Base {

    public function menu() {
        $roleIDs = model('MemberRole')->getRoleBy($this->_uid);

        return \Tree::format(
            model('Node')->getNodesBy(
                $roleIDs,
                $this->_sysid
            ),false, ['nameKey' => 'title']
        );
    }

    public function route() {
        $roleIDs = model('MemberRole')->getRoleBy($this->_uid);

        return $this->_formatRoute(model('Node')->getRoueBy(
            $roleIDs,
            $this->_sysid
        ));
    }

    private function _formatRoute($route) {
        $r = [];
        foreach ($route as $key => $item) {
            $r[strstr($key, '/', true)]['items'][] = [
                'sref' => str_replace('/', '-', $item['url_value']),
                'options' => [
                    'page'  => ['title' => $item['title']],
                    'files' => empty($item['files']) ? '' : explode(',', $item['files']),
                    'query' => $item['query']
                ]
            ];
        }
        return $r;
    }

    public function index() {
        return \Tree::format(
            model('Node')->getAllBy(
                $this->request->get('sysid',1)
            ),false, ['nameKey' => 'title']
        );
    }

    public function operation() {
        $this->_uid;
        $this->request->get('node_id');
    }

    public function add() {
        $this->_checkNode();
        if(! model('Node')->save($this->request->post())) {
            $this->_error('保存失败，请稍后再试', 500);
        }

        return ['msg'=> '添加成功'];
    }

    private function _checkNode() {
        if(true !== ($validate = $this->validate($this->request->post(), 'Node'))) {
            $this->_error($validate, 400);
        }
    }

    public function edit() {
        $post=request()->post();//dump($post);exit;
        unset($post['leaf']);unset($post['$$hashKey']);unset($post['child']);unset($post['pname']);
        if(model('Node')->where(['id'=>$post['id']])->update($post)===false){
            $this->_error('编辑失败', 500);  
        }
        return ['msg'=> '编辑成功'];
    }

    public function delete() {
        if(! model('Node')->where('id', $this->request->get('id'))->delete()) {
            $this->_error('删除失败，请稍后再试', 500);
        }

        return ['msg'=> '删除成功'];
    }
    
    public function allNodes() {
        $sidStr='1,2,3,4,5';
        $list= \Tree::format(
            model('Node')->getNodes(
                $sidStr
            ),false, ['nameKey' => 'title']
        );        
        foreach($list as $k=>$v){
            $nlist['nodes'][$v['sysid']]['stitle']=$v['stitle'];
            $nlist['nodes'][$v['sysid']]['sysid']=$v['sysid'];
            $nlist['nodes'][$v['sysid']][]=$v;            
        }//print_r($nlist);exit;
        return $nlist;
    }

    public function enable() {

    }

    public function disable() {

    }

    public function save() {

    }
}