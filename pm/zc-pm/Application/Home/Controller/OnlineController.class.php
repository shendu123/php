<?php
namespace Home\Controller;
use Think\Controller;

//
class OnlineController extends CommonController {


	// public function _initialize() {
 //        // var_dump($_SESSION);exit();
 //    }

    public function index(){
		$uid = $_SESSION['uid'];
        // var_dump($_SESSION['uid']);
        // var_dump(isset($uid));

        // exit();
		if(isset($uid)){
			$data = D('member')->where(array('uid' => $uid ))->select();
// var_dump($data);exit();
			if(isset($data[0]['ol_teacher_id'])&&$data[0]['ol_teacher_id']!=0){
				$teacher = D('online_teacher')->where( array('ol_teacher_id' =>$data[0]['ol_teacher_id'] ))->select();
				// var_dump($teacher);exit();
				$this->rank = '50';

				$_SESSION['ol_teacher_id']= $data[0]['ol_teacher_id'];
				$_SESSION['teacher_name']= $teacher[0]['name'];
				$this->ol_teacher_id = $_SESSION['ol_teacher_id'];
			}else{
				$this->ol_teacher_id = 0;
			}
			$this->member_id = $_SESSION['uid'];
			$this->member_name = $data[0]['account'];
			
		}else{
			$this->member_name = 0;
			$this->member_id =0;
		}

		$this->teacher = D('online_teacher')->where(array('delete' => 0 ))->select();

		
		

		// var_dump($this->chatindex);
		// exit();
        $this->display();
    }

    public function fayan(){
    	$chat = D('online_chat');
    	if(IS_POST){
    		$mes = I('post.body');

    		//保存到对应的 数据里面
    		$data['ol_teacher_id']= $_SESSION['ol_teacher_id'];
    		$data['message']= $mes;
    		// $data['question']= $answer;
    		$data['teache_name']= $_SESSION['teacher_name'];
    		// $data['member_name']= $answer;
    		// $data['member_id']= $answer;
    		// $data['last_id']= $answer;
    		$id = I('post.id');
    		if(isset($id)&&$id!=''){
				$chat->where(array('id' => I('post.id') ))->save($data);
    		}else{
    			$chat->add($data);
    		}
    		
    		//发送消息 mxw--
    	}else{
    		$mes = '';
    		$id =  I('get.id');
    		
	    	if(isset($id)&&$id!=''){
	    		$data = $chat->where(array('id' => $id ))->select();
	    		$this->mes = $data[0]['message'];
	    		$this->id = $data[0]['id'];
	    	}

	    	// var_dump($this->mes);exit();
			
    	}



    	$this->display();
    }


    //回复页面
    public function huifu(){
		$chat = D('online_chat');
    	if(IS_POST){
    		$answer = I('post.answer');
    		//保存到对应的 数据里面
    		// $data['ol_teacher_id']= $answer;
    		$data['message']= $answer;
    		// $data['question']= $answer;
    		$data['teache_name']=  $_SESSION['teacher_name'];
    		$data['ol_teacher_id']= $_SESSION['ol_teacher_id'];
    		// $data['member_name']= $answer;
    		$data['replytime']= date('Y-m-d H:i:s');
    		// $data['last_id']= $answer;
    		$chat->where(array('id' => I('post.id') ))->save($data);
    		//发送消息 mxw--
    	}else{
	    	$del =  I('get.deletehuifu');
	    	if(isset($del)&&$del!=''){
	    		//删除 数据库的对应id chat
	    		$data['delete']= '4';
	    		$chat->where(array('id' => $del ))->save($data);
	    	}
	        
	    }

        // $data = $chat->where($ws)->order('createtime DESC')->select();
        $data = $chat->where(' `delete` = 0 AND `member_id` > 0  ')->limit(0,30)->order('createtime DESC')->select();
        // var_dump($data);exit();
	    $this->chat = $data;
	    $this->display();
    }


    //回复问题
    public function huifub(){
		
		$id = I('get.id');
    	//取出 id 对应的 chat
    	$chat = D('online_chat')->where(array('id' => $id ))->select();
    	if(isset($chat[0])){
			$chat = $chat[0];
	    	
    	}else{

    	}
    	$this->chat = $chat;

    	

        $this->display();
    }


    //管理发言
    public function guanli(){
    	$chat = D('online_chat');
    	if(IS_POST){

    	}else{
	    	$del =  I('get.delete');
	    	if(isset($del)&&$del!=''){
	    		//删除 数据库的对应id chat
	    		$data['delete']= '3';
	    		$chat->where(array('id' => $del ))->save($data);
	    	}
	        
	    }



    	$data = $chat->where(array('delete' =>0 ,'member_id'=>0 ))->limit(0,30)->order('createtime DESC')->select();
        // var_dump($data);exit();
	    $this->chat = $data;

        $this->display();
    }


    //查看 30条 消息
    public function debug(){
        $chat = D('online_chat');
        $data = $chat->where(array('member_id'=>0 ))->limit(0,30)->order('createtime DESC')->select();
        var_dump($data);exit();
    }

    //恢复 错误删除的 
    public function huifuff(){
        $chat = D('online_chat');
        $id = I("get.iid");
        $data['delete']= '0';
        $chat->where(array('id' => $id ))->save($data);
    }





    public function tiwen(){

    	$chat = D('online_chat');
    	if(IS_POST){

    		//保存到对应的 数据里面
    		// $data['ol_teacher_id']= $answer;
    		// $data['message']= $mes;
    		$data['question']= I('post.question');
    		// $data['teache_name']= $answer;
    		$data['member_name']= I('post.member_name');
    		$data['member_id']= $_SESSION['uid'];
    		// $data['last_id']= $answer;

    		$chat->add($data);

    		
    		//发送消息 mxw--
    	}else{
    		$mes = '';
    		$id =  I('get.id');
    		
	    	if(isset($id)&&$id!=''){
	    		$data = $chat->where(array('id' => $id ))->select();
	    		$this->mes = $data[0]['message'];
	    		$this->id = $data[0]['id'];
	    	}

	    	// var_dump($this->mes);exit();
			
    	}

    	$data = $chat->where(' `delete` = 0 AND `member_id` > 0  ')->limit(0,30)->order('createtime DESC')->select();
        // var_dump($data);exit();
	    $this->chat = $data;



    	$this->display();
    	
    }


    // public function teacher(){

    // 	$this->teacher = D('online_teacher')->where(array('delete' => 0 ))->select();
    // 	$this->display();
    // }
    // 
    public function livegunhq(){
    	$this->display();
    }

    public function chat(){
    	$datac = D('online_chat')->where(' `delete` = 0 AND `ol_teacher_id` != 0')->order('createtime DESC')->limit(0,30)->select();
    
        // var_dump($datac);exit();
        foreach ($datac as $k => $v) {
            $data =   D('online_teacher')->where( array('ol_teacher_id' => $v['ol_teacher_id'] ))->select();
            $datac[$k]['picurl'] = $data[0]['picurl'];
            $this->chatindex = $datac;
        }
        // var_dump($data);exit();
    	// var_dump($this->chatindex);exit();
    	$this->display();
    }
   
   















   
}