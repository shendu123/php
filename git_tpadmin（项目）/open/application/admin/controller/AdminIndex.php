<?php

//------------------------
// 用户控制器
//-------------------------

namespace app\admin\controller;
use app\admin\Controller;
use think\Session;
use think\Exception;
use think\Loader;
use app\common\model\Node as NodeModel;
use app\common\model\AdminUser as UserModel;
use think\Db;

class AdminIndex extends Controller
{
    /**
     * 用户列表
     */
    public function index(){
        
    }
    //权限认证
    public function auth() {
        $authList=parent::auth();
        return json(['data'=>$authList],200);
    }
    //后台左边菜单
    public function menu(){
        $where['status']=1;
        $where['type']=1;
        $where['isdelete']=0;
        $where['level']=['gt',1];
        $model=new NodeModel();
        $list=Db::name('Node')->field('id,pid,name,title,level,status')->where($where)->select();
        foreach($list as $k=>$v){
            $list[$k]['control']=strtolower(substr($v['name'],5));
        }
        $data=$model->tree($list,$pid=1);
        return json(['data'=>$data],200);
    }
        //权限控制器
    public function auth2() {
        $authList=parent::auth();//print_r($authList);exit;
        if($authList&&$authList!=1){
            foreach($authList['Admin'] as $k=>$v){
                $arr[]=$k;
                $arrChildControl=$this->checkChildAuth($v);
            }
            $arr=array_merge($arr,$arrChildControl);
            //print_r($arr);exit;
            return json(['data'=>$arr],200);
        }
        
    }
    //子控制器权限递规函数
    public function checkChildAuth($v){
        static $arrChildControl=[];
        foreach($v as $k2=>$v2){
            if($k2){
                $where['name']=$k2;
                $where['type']=1;
                $where['status']=1;
                $name=Db::name('Node')->where($where)->value('name');
                if($name){
                    $arrChildControl[]=$name;
                    $this->checkChildAuth($v2);
                }
            }
        }  
        return $arrChildControl;
    }
    
    
}