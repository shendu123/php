<?php
namespace Admin\Controller;

use Think\Controller;

class OvideoController extends CommonController {

    public function index() {
        $M = D('ovideo');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];


        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'ovideo_id DESC');
        // var_dump($this->list);
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }





    public function editcourse() {
        if (IS_POST) {
            $course = M('ovideo');
            $info = I('post.info');
            if($info['ovideo_id']==''){
                unset($info["ovideo_id"]);
                if($course->add($info)){
                    echojson(array('status' => 1, 'info' => '新增成功','url'=>U('Ovideo/index',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }else{
                if($course->where(array('ovideo_id'=>$info['ovideo_id']))->save($info)){
                    echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Ovideo/index',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }
            
            
        }else{
            $info = D('ovideo')->where(array('ovideo_id'=>I('get.cid')))->find();
            $this->edit = $edit;
            $this->info=$info;
            $this->display('editcourse');
        }
        
    }






    public function delcourse(){
        if (D("ovideo")->where("ovideo_id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

}