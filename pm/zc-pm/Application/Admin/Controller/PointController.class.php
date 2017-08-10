<?php
namespace Admin\Controller;

use Think\Controller;

class PointController extends CommonController {

    public function index() {
        $M = D('point_course');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];


        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'id DESC');
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }

    public function order() {
        $M = D('point_order');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $list = $M->lists($pConf['first'], $pConf['list'], $ws, 'id DESC');
// var_dump($list);exit();
        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'id DESC');
        $this->two = $list['two'];
        // $this->saytyp = $ws['saytyp'];
        $this->display();
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

        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'id DESC');
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }
    
    public function indexschool() {
        $M = D('point_school');
        // $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        $ws = " 1 = 1 ";

        // if(!is_null($_SESSION['business_id'])){
        //     $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        // }

        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'id DESC');
        // $this->saytyp = $ws['saytyp'];
        $this->display();
    }


    public function editcourse() {
        if (IS_POST) {
            $info = I('post.info');
            // $info['picurl'] = I('post.pic');
            $course = M('point_course');
            // $info['picurl'] = implode('|', I('post.pic'));
            $info['starttime']=strtotime($info['starttime']);
            //dump($info);exit;
            if($info['id']==''){
                unset($info["id"]);
                if($course->add($info)!==false){
                    echojson(array('status' => 1, 'info' => '新增成功','url'=>U('Point/index',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }else{
                if($course->where(array('id'=>$info['id']))->save($info)!==false){
                    echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Point/index',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }
            
            
        }else{
            $info = D('point_course')->where(array('id'=>I('get.cid')))->find();
            $teacherList = D('online_teacher')->field('ol_teacher_id,name')->where(array('delete'=>0))->select();
            // if ($info['picurl']) {
            //     $info['picurl'] = explode('|', $info['picurl']);
            // }
            $this->edit = $edit;
            $this->info=$info;
            $this->teacherList=$teacherList;
            $this->display('editcourse');
        }
        
    }


    public function editgift() {
        if (IS_POST) {
            $course = M('point_gift');
            $info = I('post.info');
            $info['picurl3'] = implode('|', I('post.pic'));
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
            if ($info['picurl3']) {
                $info['picurl3'] = explode('|', $info['picurl3']);
            }
            $this->edit = $edit;
            $this->info=$info;
            $this->display('editgift');
        }
        
    }
    
    public function editschool() {
        if (IS_POST) {
            $course = M('point_school');
            $info = I('post.info');//print_r($info);exit;
            if($info['picurl']){
                $info['video_pic_url']=$info['picurl'];
            }            
            if($info['is_limit_buy']==1){
                $info['limit_stock']=isset($info['limit_buy'])&&!empty($info['limit_buy'])?$info['limit_buy']:0;
            }else{
                $info['limit_stock']=$info['limit_buy']=0;
            }
            
            unset($info['picurl']);
            if($info['id']==''){
                unset($info["id"]);
                // $_SESSION['infoooij'] = $info;
                if($course->add($info)!==false){
                    echojson(array('status' => 1, 'info' => '新增成功','url'=>U('Point/indexschool',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }else{
                if($course->where(array('id'=>$info['id']))->save($info)!==false){
                    echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Point/indexschool',array('typ'=>$typ))));
                }else{
                    echojson(array('status' => 0, 'info' => $course->getDbError()));
                    // echojson(array('status' => 0, 'info' => $info));
                }
            }
            
            
        }else{
            $info = D('point_school')->where(array('id'=>I('get.cid')))->find();
            $teacherList = D('online_teacher')->field('ol_teacher_id,name')->where(array('delete'=>0))->select();
            $this->edit = $edit;
            $this->info=$info;
            $this->teacherList=$teacherList;
            $this->display('editschool');
        }
        
    }

    public function test(){
        var_dump($_SESSION['infoooij']);exit();
    }


    public function delgift(){
        if (D("point_gift")->where("id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
     public function delschool(){
        if (D("point_school")->where("id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

    public function delcourse(){
        if (D("point_course")->where("id=" . (int) $_GET['cid'])->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }


    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $goodsId = I('post.goodsId'); //商品ID
        if($goodsId){
            $goods = M('Goods');
            $gd_pic = $goods->where(array('id'=>$goodsId))->find();
            //组合要写入数据
            $newPic = str_replace('||','|',trim(str_replace($imgUrl, '', $gd_pic['pictures']),'|'));
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => $newPic
                );

            if($goods->save($data)){
                $ecJson = array(
                    'status' => 1,
                    'msg' => '删除成功!'
                    );
                @unlink($imgDelUrl);
                //循环删除缩略图
                $picFix = explode(',',C('GOODS_PIC_PREFIX'));
                foreach ($picFix as $pfK => $pfV) {
                    @unlink( C('UPLOADS_PICPATH').picRep($imgUrl,$pfK));
                }
                //输出结果
                echojson($ecJson);
            }else{
                $ecJson = array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    );
                echojson($ecJson);
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从服务器删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '删除失败，请检查文件权限!'
                ));
            }
            
        }
    }

}