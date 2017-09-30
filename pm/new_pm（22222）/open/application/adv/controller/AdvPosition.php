<?php
/*
 * 广告位
 */
namespace app\adv\controller;
use app\adv\model\AdvPosition as ApModel;
use app\common\controller\Base;
use think\Request;
class AdvPosition extends Base {
    
    /*
     * 广告位列表
     */
    public function index(){
        $name=  request()->param('name');
        $where=[];
        if($name){
            $where['name']=['like',"%".$name."%"];
        }        
        $pageSize=$this->request->param('page_size',10);
		if($pageSize > config('pageSize')){
			$this->_error('每页最多只能展示“'.config('pageSize').'”条',500);
		}
        return (new ApModel())->ApList($pageSize, $where);;
        
    }
    
    /*
     * 添加广告位
     */
    public function add(){
        if(request()->isPost()){
            $data=request()->param();
			$validateAdv = validate('AdvPosition');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}	 
            $data['createtime']=time();
			unset($data['pos_type_tag']);
            if(model('AdvPosition')->save($data)===false){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑广告位
     */
    public function edit(){
		$data=  request()->param();
		if (!isset($data['id'])||!is_numeric($data['id'])) {
			$this->_error('参数错误', 400);
		}
		if (!(new ApModel())->isHas($data['id'])) {
			$this->_error('广告位信息不存在', 400);
		}		
        if(request()->isPost()){            
            $validateAdv = validate('AdvPosition');
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}
			unset($data['createtime']);unset($data['pos_type_tag']);
            if(model('AdvPosition')->where(['id'=>$data['id']])->update($data)===false){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
        }else{
            $info=model('AdvPosition')->where(['id'=>$data['id']])->find();
            return $info;
        }  
    }
    
    /*
     * 删除广告位
     */
    public function delete(){
        $id=request()->get('id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少广告位id',400); 
        }
        if(model('AdvPosition')->where(['id'=>['in',$id]])->delete()===false){
            $this->_error('删除失败', 500); 
        }
        return ['msg'=> '删除成功'];
    }
}
?>