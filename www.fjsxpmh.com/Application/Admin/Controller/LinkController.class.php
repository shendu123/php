<?php
namespace Admin\Controller;
use Think\Controller;
class LinkController extends CommonController {
//=========================友情链接操作=============================
    // 友情链接列表
    public function index() {
        if(I('get.ico')!=''){
            $where = array('rec'=>I('get.ico'));
        }
        $link = M('Link');
        $count = $link->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];
        $this->list = $link->order('sort desc')->where($where)->select();
        $this->ico=I('get.ico');
        $this->display();
    }
    //添加友情链接
    public function add(){
        if (IS_POST) {
            $this->checkToken();
            $data = I('post.info');
            if(M('Link')->add($data)){
                echojson(array('status' => 1, 'info' => '添加成功', 'url' => U('Link/index')));
            }else{
                echojson(array('status' => 0, 'info' => '添加失败！请重试'));
            }
        } else {
            $this->display();
        }
    }
    // 编辑友情链接
    public function edit() {
        $M = M('Link');
        if (IS_POST) {
            $this->checkToken();
            $data = I('post.info');
            if(M('Link')->save($data)){
                echojson(array('status' => 1, 'info' => '已更新', 'url' => U('Link/index')));
            }else{
                echojson(array('status' => 0, 'info' => '更新失败，请重试'));
            }
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }
            $this->assign("info", $info);
            $this->display('add');
        }
    }
    //删除友情链接
    public function del() {
        if (M("Link")->where("id=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            //echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    //友情链接异步排序
    public function sort() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('Link');
            $where=array('id'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }
        } else {
            echojson(array('status'=>'0','msg'=>'什么情况'));
        }
    }
    //异步删除商品图片
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $linkId = I('post.linkId');
        $M = M('Link');
        $data = array(
            'id' => $linkId,
            'ico' =>''
        );
        if($linkId){
            if($M->save($data)){
                if(@unlink($imgDelUrl)){
                    echojson(array(
                    'status' => 1,
                    'msg' => '已从数据库删除成功!'
                    ));
                }else{
                    echojson(array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    ));
                }
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从磁盘删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '磁盘文件删除失败，请检查文件是否存在或磁盘权限!'
                ));
            }
            
        }
    }
}