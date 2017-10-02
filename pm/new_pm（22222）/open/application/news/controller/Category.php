<?php
/*
 * 资讯栏目
 */
namespace app\news\controller;
use app\news\model\NewsCategory as CatModel;
use app\common\controller\Base;
class Category extends Base {
    
    /*
     * 栏目列表
     */
    public function index(){
        $name=  request()->param('name');
        $where=[];
        if($name){
            $where['name']=['like',"%".$name."%"];
        }        
        $pageSize=$this->request->param('s');
		if($pageSize > config('pageSize')){
			$this->_error('每页最多只能展示“'.config('pageSize').'”条',500);
		}
        return (new CatModel())->catList($pageSize, $where);
        
    }
    
    /*
     * 添加栏目
     */
    public function add(){
        if(request()->isPost()){
            $data=request()->param();
			$validateAdv = validate('NewsCategory');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}	
            $data['create_time']=time();
            if(model('NewsCategory')->save($data)===false){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑栏目
     */
    public function edit(){
        if(request()->isPost()){
			$data=  request()->param();
			if (!isset($data['id'])||!is_numeric($data['id'])) {
				$this->_error('参数错误', 400);
			}
			if (!(new CatModel())->isHas($data['id'])) {
				$this->_error('栏目信息不存在', 400);
			}
			$validateAdv = validate('NewsCategory');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}   
            $data['update_time']=time();
            unset($data['html']);
            unset($data['create_time']);
            if(model('NewsCategory')->where(['id'=>$data['id']])->update($data)===false){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
        }  
    }
    
    /*
     * 删除栏目
     */
    public function delete(){
        $id=request()->get('id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少栏目id'); 
        }
		if(model('NewsCategory')->where(['pid' => $id])->value('id')){
			$this->_error('此分类下有二级分类，不能删除',500); 
		}
        if(model('NewsCategory')->where(['id'=>['in',$id]])->delete()===false){
            $this->_error('删除失败', 500); 
        }
        return ['msg'=> '删除成功'];
    }
	
	/*
	 * ajax更新排序/是否显示
	 */
	public function changeSortOrShow(){
		if(request()->isPost()){
			$data=request()->param();
			if(!isset($data['id'])||!is_numeric($data['id'])){
				$this->_error('参数错误',400);
			}
			if(isset($data['sort'])&&!is_numeric($data['sort'])){
				$this->_error('排序参数非法',400);
			}
			if(isset($data['is_show'])&&!in_array($data['is_show'],[0,1])){
				$this->_error('is_show参数非法',400);
			}
			if(model('NewsCategory')->where(['id'=>$data['id']])->update($data)===false){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新成功'];			
		}
	}
}
?>