<?php
namespace Home\Widget;
use Think\Controller;
class OncooWidget extends Controller {    
    public function notice($cid,$size){        
        $new = M("News");
        $where = array('status'=>1,'cid'=>$cid);
        $this->list = $new->where($where)->field('id,cid,title,update_time,published')->order('published desc')->limit($size)->select();
        $this->display('Article:notice_box'); 
    }
    // 底部文章列表
    public function helpList($catepid,$column,$row){
        $cate = M("Category")->where(array('pid'=>$catepid))->limit($column)->order('sort desc')->select();
        $news = M('News');
        foreach ($cate as $ck => $cv) {
            $hlist[$ck]['cname'] = $cv['name'];
            $hlist[$ck]['nlist'] = $news->where(array('cid'=>$cv['cid'],'status'=>'1'))->field(array('id','title'))->order('published desc')->limit($row)->select();
        }
        $this->hlist=$hlist;
        $this->display('Common:helpList');
    }
    //省市区
    public function region($province,$city,$area,$layer) {
        if($province==0){
            $rid = array(0,0,0);
        }else{
            $rid = array($province,$city,$area);
        }
        if(!empty($layer)){
            $layer  =$layer>3 || $layer<1 ? 3 : $layer;
        }else{
            $layer=3;
        }
        $name =array('province','city','area');
        $option = array('省、直辖市','选择城市','选择区、县');
        $tier = 1;
        $region = M('region');
        $rMap = $region->field(array('region_id','region_name'))->where(array('parent_id'=>1))->select();
        // 地区层
        $this->tier=$tier;
        $this->name=$name;

        $this->layer=$layer;
        $this->option=$option;
        $this->rid=$rid;
        $this->rMap=$rMap;
        $who = defineView();
        $this->display(T('Home@'.$who['view'].'/Common/region'));
    }
    // 拍品分类筛选
    public function catelist($cid,$how='auction'){
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name'));
        $cate = M('Goods_category');
        // 上级分类【
        $pid = $cate->where(array('cid'=>$cid))->getField('pid');
        $precate = $cate->where(array('cid'=>$pid))->find();
        $this->precate=$precate;
        // 上级分类【
        $catli = $cate->where(array('pid'=>$cid))->select();
        if(empty($catli)){
            $pid=$cate->where(array('cid'=>$cid))->getField('pid');
            $catli = $cate->where(array('pid'=>$pid))->select();
        }
        $this->catli=$catli;
        $this->how=$how;
        $this->chalist= $cat->getPath($cid);
        if($how=='auction'){
            $this->display('Auction:catelist');
        }elseif($how=='second'){
            $this->display('Second:catelist');
        }
    }

}