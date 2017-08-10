<?php
namespace Admin\Controller;

use Think\Controller;

class OnlineController extends CommonController {


    public function index() {

        $M = D('online_teacher');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];





        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'ol_teacher_id DESC');
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }

    public function editcourse() {
        if (IS_POST) {

            $course = M('online_teacher');
            $info = I('post.info');
            if($info['ol_teacher_id']==''){

                // $bb = D('Member')->where(array('account' => I('post.member_name'),'ol_teacher_id'=>0 ))->select();
                $bb = D('Member')->where(array('account' => I('post.member_name')))->select();
                // var_dump(count($bb));
                if($bb==null||count($bb)!=1){
                    echojson(array('status' => 0, 'info' => '错误的账户，或者账户已注册教师'));
                    exit();
                }


                unset($info["ol_teacher_id"]);
                if($course->add($info)){

                    $mem['ol_teacher_id'] = $course['ol_teacher_id'];
                    $bb = D('Member')->where(array('account' => I('post.member_name') ))->save($mem);
                    
                    echojson(array('status' => 1, 'info' => '新增成功','url'=>U('Online/index',array('typ'=>$typ))));
                }else{
                    // var_dump($course);exit();
                    if($course->getDbError==null){
                        echojson(array('status' => 0, 'info' => $course->getDbError()));
                    }else{
                        echojson(array('status' => 0, 'info' => '新增 错误'));
                    }

                }
            }else{

                $bb = D('Member')->where(array('account' => I('post.member_name') ))->select();
                // var_dump(count($bb));
                if($bb==null){
                    echojson(array('status' => 0, 'info' => '不存在的账户'));
                    exit();
                }

                $mem['ol_teacher_id'] = $info['ol_teacher_id'];
                $memb['ol_teacher_id'] = 0;

                $bb = D('Member')->where(array('account' => I('post.member_name') ))->save($mem);
                $bb = D('Member')->where(array('ol_teacher_id' => I('post.ol_teacher_id') ))->save($memb);
                // var_dump($info);exit();
                // 
                // $jj = $course->where(array('ol_teacher_id'=>$info['ol_teacher_id']))->save($info);
                // var_dump($jj);exit();
                if($course->where(array('ol_teacher_id'=>$info['ol_teacher_id']))->save($info)){
                    echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Online/index',array('typ'=>$typ))));
                }else{
                    // var_dump($course->getDbError==null);exit();
                    if($course->getDbError!=null){
                        echojson(array('status' => 0, 'info' => $course->getDbError()));
                    }else{
                        echojson(array('status' => 0, 'info' => '没有跟新'));
                    }
                    
                }
            }
            
            
        }else{
            $mem = null;
            if(I('get.cid')!=''){
                $mem =  D('Member')->where(array('ol_teacher_id' => I('get.cid') ))->select();
            }


            if($mem!=null&&count($mem)==1){
                $this->member_name= $mem[0]['account'];
            }else{
                $this->member_name= '';
            }

            

            $info = D('online_teacher')->where(array('ol_teacher_id'=>I('get.cid')))->find();
            $this->edit = $edit;
            $this->info=$info;
            $this->display('editcourse');
        }
        
    }



    public function delcourse(){
        if (D("online_teacher")->where("ol_teacher_id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }






















    public function indexgift() {
        $M = D('point_gift');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'ol_teacher_id DESC');
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }



    public function editgift() {
        if (IS_POST) {
            $course = M('point_gift');
            $info = I('post.info');
            if($info['id']==''){
                unset($info["id"]);
                // $_SESSION['infoooij'] = $info;
                if($course->add($info)){
                    echojson(array('status' => 1, 'info' => '新增成功','url'=>U('Point/indexgift',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }else{
                if($course->where(array('id'=>$info['id']))->save($info)){
                    echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Point/indexgift',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }
            
            
        }else{
            $info = D('point_gift')->where(array('id'=>I('get.cid')))->find();
            $this->edit = $edit;
            $this->info=$info;
            $this->display('editgift');
        }
        
    }



    public function delgift(){
        if (D("point_gift")->where("id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }


}