<?php
namespace Admin\Controller;

use Think\Controller;

class CrowdController extends CommonController {
    /**
     * 申购列表
     */
    public function index() {
        $M = D('crowd');
        $ws = I('get.typ')?bidType(I('get.typ'), 3):bidType('biding', 3);
        if(!is_null($_SESSION['business_id'])){
            $ws['bidType']['business_id'] = array('in', $_SESSION['business_id']);
        }

        $count = $M->where($ws['bidType'])->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws['bidType'], 'crowd_id DESC');
        $this->saytyp = $ws['saytyp'];
        $this->display();
    }

    /**
     * 添加申购
     */
    public function add(){
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            $info['business_id'] = intval($_SESSION['business_id']);//增加企业id

            if($info['endtime']<time()){
                echojson(array('status' => 0, 'info' => '结束时间应该大于当前时间'));
                exit;
            }
            if($info['endtime']<$info['starttime']){
                echojson(array('status' => 0, 'info' => '结束时间应大于开始时间'));
                exit;
            }
            
            // 发布者id
            $info['aid'] = $_SESSION['my_info']['aid'];
            unset($info['crowd_id']);
            if(D('crowd')->add($info)){
                S("crowd_list_biding_key", time());
                S("crowd_list_future_key", time());
                echojson(array('status' => 1, 'info' => '添加成功','url'=>U('Crowd/index')));
            }else{
                echojson(array('status' => 0, 'info' => '添加失败，请重试'));
            }
        }else{
            $this->display();  
        }
    }

    /**
     * 编辑申购
     */
    public function edit() {
        if (IS_POST) {
            $info = I('post.info');
            $info['starttime']=strtotime($info['starttime']);
            $info['endtime']=strtotime($info['endtime']);
            if(M('crowd')->save($info)){
                if ($info['starttime']<=time() && $info['endtime']>=time()) {
                    $typ = 'biding';
                }elseif ($info['endtime']<time()) {
                    $typ = 'bidend';
                }elseif ($info['starttime']>time()) {
                    $typ = 'future';
                }
                S("crowd_list_biding_key", time());
                S("crowd_list_future_key", time());

                echojson(array('status' => 1, 'info' => '更新成功','url'=>U('Crowd/index',array('typ'=>$typ))));
            }else{
                echojson(array('status' => 0, 'info' => '更新失败，请重试'));
            }
        }else{
            $info = D('crowd')->where(array('crowd_id'=>I('get.cid')))->find();
            // 未开始申购可以编辑
            if ($info['starttime']>time()) {
                $edit = 0;
            }else{
                $edit = 1;
            }
            $this->edit = $edit;
            $this->info=$info;
            $this->display('add');
        }
        
    }
    public function del(){
        if (D("Crowd")->where("crowd_id=" . (int) $_GET['cid'])->delete()) {
            M('crowd_items')->where("crowd_id=" . (int) $_GET['cid'])->delete();
            S("crowd_list_biding_key", time());
            S("crowd_list_future_key", time());
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }

    public function goods() {
        $M = D('crowd_items');
        $ws['crowd_id'] = I('get.cid');
        $this->crowd = D('Crowd')->where("crowd_id=" . (int) $ws['crowd_id'])->field('name,main_img')->find();
        $count = $M->where($ws)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show'];

        $this->list = $M->lists($pConf['first'], $pConf['list'], $ws, 'ciid DESC');

        $this->display();
    }

    public function add_goods() {
        if(IS_POST) {
            $info = I('post.info');
            
            $_referer = empty($info['referer']) ? ('Goods/index') : $info['referer'];
            unset($info['referer']);
            if($ciid = D('crowd_items')->getId($info['gid'], $info['crowd_id'])) {
                $info['ciid'] = $ciid;
                if(D('crowd_items')->save($info)) {
                    S('crowd_items_'.$info['crowd_id'], null);
                    echojson(array('status' => 1, 'info' => '更新成功','url'=> $_referer));
                }else{
                    echojson(array('status' => 0, 'info' => '更新失败，请重试'));
                }
            } else {
                $info['limit_stock']=isset($info['limit_buy'])&&!empty($info['limit_buy'])?$info['limit_buy']:0;
                if(D('crowd_items')->add($info)){
                     S('crowd_items_'.$info['crowd_id'], null);
                     echojson(array('status' => 1, 'info' => '添加成功','url'=> $_referer));
                }else{
                    echojson(array('status' => 0, 'info' => '添加失败，请重试'));
                }                
            }
        } else {
            $info['gid'] = I('get.gid');
            $goods= M('Goods');
            $gdata=$goods->where('id ='.$info['gid'])->field('title,price,description')->find();
            $info['title'] = $gdata['title'];
            $info['price'] = $gdata['price'];
            $this->info = $info;

            $biding = bidType('biding', 3);
            $future = bidType('future', 3);
            $future['bidType']['business_id'] = $biding['bidType']['business_id'] = array('in', $_SESSION['business_id']);

            $bidingList = D('crowd')->where($biding['bidType'])->order('crowd_id desc')->select();
            $futureList = D('crowd')->where($future['bidType'])->order('crowd_id desc')->select();
            $this->bidingList=$bidingList;
            $this->futureList=$futureList;
            $this->referer = $_SERVER['HTTP_REFERER'];
            $this->display();
        }
    }

    public function edit_goods() {
        if(IS_POST) {
            $info = I('post.info');
            $_referer = empty($info['referer']) ? ('Crowd/index') : $info['referer'];
            unset($info['referer']);
            if(D('crowd_items')->save($info)) {
                $crowd_id = M('crowd_items')->where("ciid='{$info['ciid']}'")->getfield('crowd_id');
                S('crowd_items_'.$crowd_id, null);
                echojson(array('status' => 1, 'info' => '编辑成功','url'=> $_referer));
            }else{
                echojson(array('status' => 0, 'info' => '编辑失败，请重试'));
            }
        } else {
            $this->info = D('CrowdItems')->details(I('get.ciid'));

            $this->referer = $_SERVER['HTTP_REFERER'];

            $this->display('add_goods');
        }
    }

    public function del_goods() {
        $crowd_id = M('crowd_items')->where('ciid='.(int) $_GET['ciid'])->getfield('crowd_id');
        if (D("CrowdItems")->where("ciid=" . (int) $_GET['ciid'])->delete()) {
            S('crowd_items_'.$crowd_id, null);
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
}