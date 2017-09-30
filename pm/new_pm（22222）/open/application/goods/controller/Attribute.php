<?php

namespace app\goods\controller;

use app\common\controller\Base;
use app\goods\model\Attribute as AttrModel;

class Attribute extends Base {
    /*
     * 属性列表
     */
    public function index() {
	$cid=  request()->param('cid');
        $where=[];
        if($cid){
            $where['cid']=$cid;
        }
        $page['pageSize']= request()->param('s');
        $page['page']=request()->param('p');
	return (new AttrModel())->attrList($page,$where);
    }
    /*
     * 添加属性
     */
    public function add() {
	if(request()->isPost()){
            $data=request()->param();
            $data['attr_intime']=time();
            if(model('Attribute')->save($data)===false){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    /*
     * 编辑属性
     */
    public function edit(){
	if(request()->isPost()){
            $data=request()->param();
            $data['attr_uptime']=time();
	    unset($data['cat_name']);
	    unset($data['attr_intime']);
            if(model('Attribute')->save($data,['id'=>$data['id']])===false){
                $this->_error('修改失败',500);
            }
            return ['msg'=>'修改成功'];
        }	
    }
    /*
     * 删除属性
     */
    public function delete(){
	if(model('Attribute')->where(['id'=>['in',request()->param('id')]])->delete()===false){
	    $this->_error('删除失败', 500); 
	}
	return ['msg'=>'删除成功'];
    }
    /*
     * 属性状态设置
     */
    public function changeStatus() {
        if(request()->isPost()){
            $id=request()->param('id');
            $data['attr_is_disable']=request()->param('status');
            if(model('attribute')->where(['id'=>['in',$id]])->update($data)===false){
                $this->_error('设置失败');
            }
            return ['msg'=> '设置成功'];
        }        
    }
}


































