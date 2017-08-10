<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends CommonController {
    /**
     * 帮助页面
     * @return [type] [description]
     */
    public function help(){
        $ism = $this->ism;
        // 帮助导航列表
        $cate = M('category');
        $news = M('news');
        $helpmap = $cate->where('pid = 1')->order('sort desc')->getField('cid,name',true);
        $hi = 0;
        foreach ($helpmap as $hk => $hv) {
            $newlist[$hi]['cid']=$hk;
            $newlist[$hi]['cname']=$hv;
            $newlist[$hi]['list']=$news->where('cid ='.$hk)->getField('id,title',true);
            $hi += 1;
        }
        $this->newlist=$newlist;
        // 文章
        $newid = I('get.id');
        $where = empty($newid) ? array('id'=>key($newlist[0]['list'])):array('id'=>$newid);
        $list = $news->where($where)->find();
        $list['content']=stripslashes($list['content']);
        $list['cname']= $cate->where('cid ='.$list['cid'])->getField('name');
        $this->list=$list;  
        if($ism&&$newid!=''){
            $this->display('help_details');
        }else{
           $this->display(); 
        }
        
    }
    /**
     * 公告/咨询列表
     * @return [type] [description]
     */
    public function notice(){
        $cid=I('get.cid');
        $news = M('news');
        $cate = M("Category");
        $caname = $cate->where(array('cid'=>2))->getField('name');
        $cbname = $cate->where(array('cid'=>3))->getField('name');

        $count = $news->where('cid = '.$cid)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show']; //分页分配
        $where = array('status'=>1,'cid'=>$cid); //文章发布状态公告分类
        $noticemap = $news->where($where)->limit($pConf['first'].','.$pConf['list'])->field('id,title,keywords,description,update_time,picture,published')->order('published desc')->select();
        $this->cname=($cid==2)?$caname:$cbname;
        $this->cid=$cid;
        $this->list=$noticemap;
        $this->caname = $caname;
        $this->cbname = $cbname;
        $this->display();
    }
    public function notice_details(){
        $cid=I('get.cid');
        $news = M('news');
        $cate = M("Category");
        $where = array('id'=>I('get.id'));
        $data = $news->where($where)->find();
        $data['content']=stripslashes($data['content']);
        $cname = $cate->where(array('cid'=>$data['cid']))->getField('name');
        $this->cname=$cname;
        $this->cid=$data['cid'];
        $this->data=$data;
        $this->caname = $cate->where(array('cid'=>2))->getField('name');
        $this->cbname = $cate->where(array('cid'=>3))->getField('name');
        $this->display();
    }
}