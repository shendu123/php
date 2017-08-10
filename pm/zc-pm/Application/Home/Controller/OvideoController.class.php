<?php
namespace Home\Controller;
use Think\Controller;

//
class OvideoController extends CommonController {

    public function index(){

    	// $this->video =  D('member')->where(array('uid' => $uid ))->select();
    	$this->video = $data = D('ovideo')->where(array('delete' =>0 ))->limit(0,30)->order('updatetime DESC')->select();
    	$this->first = $data[0]; 
        $this->display();
    }

   
   















   
}