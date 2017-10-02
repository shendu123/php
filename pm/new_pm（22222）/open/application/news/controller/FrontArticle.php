<?php
/*
 * 资讯文章
 */
namespace app\news\controller;
use app\news\model\NewsCategory as CatModel;
use app\news\model\NewsArticle as ArtModel;
use think\Controller;
class FrontArticle extends \think\controller\Rest {
    
    /*
     * 首页
     */
    public function index(){
        $article = new ArtModel();
        $where['is_recommend']=1;
        $where['status']=1;
		$where['na.is_show'] = 1;
		$where['NewsCategory.is_show'] = 1;
        //$list=$article->indexArticleList();
        $page['pageSize']= request()->param('page_size',10);
        $page['page']=request()->param('page',1);
        return $article->articleList($page, $where);
        
    }    
    
    /*
     * 文章列表
     */
    public function alist(){        
        $cid=  request()->param('cid');
        if(!$cid){
           $this->_error('缺少栏目id');
        }
        $article = new ArtModel();
        $where['cid']=$cid;
        $where['status']=1;
		$where['na.is_show'] = 1;
		$where['NewsCategory.is_show'] = 1;
        $get = $this->request->get();
        $page['pageSize']= isset($get['page_size']) && intval($get['page_size']) < config('pageSize') ? intval($get['page_size']) : config('pageSize');
        $page['page']=isset($get['page']) ? intval($get['page']) : 1;
        $articlelist=$article->articleList($page, $where);
        return $articlelist;
        
    }        
    
    /*
     * 文章详情
     */
    public function detail(){
        $id=  request()->param('id');
        if(!$id){
           $this->_error('缺少文章id');
        }
        $article = new ArtModel();
        $where['id']=$id;
        $where['status']=1;
        return $article->articleDetail($where);
    }
}
?>