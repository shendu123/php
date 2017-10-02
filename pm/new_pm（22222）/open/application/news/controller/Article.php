<?php
/*
 * 资讯文章
 */
namespace app\news\controller;
use app\news\model\NewsCategory as CatModel;
use app\news\model\NewsArticle as ArtModel;
use app\common\controller\Base;
class Article extends Base {
        
    /*
     * 文章列表
     */
    public function index(){
        $article = new ArtModel();
        $cid=  request()->param('cid');
        $status=  request()->param('status');
        $title=  request()->param('title');
        $where=[];
        if($cid){
            $where['cid']=$cid;
        }
        if($status){
            $where['status']=$status;
        }
        if($title){
            $where['title']=['like','%'.$title.'%'];
        }
		if($this->_sysid != 1){//非总部平台
			$where['business_id'] = $this->_user['business']['business_id'];
		}
        $page['pageSize']= request()->param('s',10);
        $page['page']=request()->param('p',1);
		if($page['pageSize'] > config('pageSize')){
			$this->_error('每页最多只能展示“'.config('pageSize').'”条',500);
		}
        return $article->articleList($page, $where);
        
    }
    
    /*
     * 添加文章
     */
    public function add(){
        if(request()->isPost()){
            $data=request()->param();
			$validateAdv = validate('NewsArticle');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}	
            if(!(new ArtModel())->add($data , $this->_user)){
                $this->_error('添加失败', 500);  
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑文章
     */
    public function edit(){
		$data=  request()->param();
		if (!isset($data['id'])||!is_numeric($data['id'])) {
			$this->_error('参数错误', 400);
		}
		if (!(new ArtModel())->isHas($data['id'])) {
			$this->_error('文章信息不存在', 400);
		}
        if(request()->isPost()){
			$validateAdv = validate('NewsArticle');
			//数据验证
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}
            if(!(new ArtModel())->edit($data , $this->_user)){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
            
        }else{
            return (new ArtModel())->articleDetail(['id'=>$data['id']]);
        }  
    }
    
    /*
     * 删除文章
     */
    public function delete(){
        $data['status']=  request()->get('status');
        $id=  request()->get('id');
        if(!$id||!$data['status']){
            $this->_error('缺少参数');
        }
        $model=model('NewsArticle')->where(['id'=>['in',$id]]);
        if($data['status']==2){
            if($model->delete()===false){
                $this->_error('操作失败', 500); 
            } 
        }else{
            if($model->update($data)===false){
                $this->_error('操作失败', 500); 
            }
        }        
        return ['msg'=> '操作成功'];
    }
	
	/*
	 * 是否推荐/是否显示
	 */
	public function changeRecOrShow(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(isset($data['is_recommend'])&&!in_array($data['is_recommend'],[0,1])){
				$this->_error('is_recommend参数非法',400);
			}
			if(isset($data['is_show'])&&!in_array($data['is_show'],[0,1])){
				$this->_error('is_show参数非法',400);
			}
			if(model('NewsArticle')->where(['id'=>$data['id']])->update($data)===false){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新成功'];			
		}
	}
    
}
?>