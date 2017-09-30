<?php
/*
 * 广告
 */
namespace app\adv\controller;
use app\adv\model\AdvPosition as ApModel;
use app\adv\model\Adv as AdvModel;
use app\common\controller\Base;
class Adv extends Base {
    
   function __construct() {
       parent::__construct();
   }
    
    /*
     * 广告列表
     */
    public function index(){ 
        $param=  request()->param();//print_r($param);exit;
        $where=[];
        if( isset($param['cid']) && !empty($param['cid'])){
            $where['pid'] = $param['cid'];
        }
		if( isset($param['is_show']) && !empty($param['is_show'])){
            $where['is_show'] = $param['is_show'] == -1 ? 0 : $param['is_show'];
        }
		if( isset($param['adv_name']) && !empty($param['adv_name'])){
            $where['adv_name']=['like','%'.$param['adv_name'].'%'];
        }
        $page['pageSize']= request()->param('page_size',10);
        $page['page']=request()->param('page',1);
		if($page['pageSize'] > config('pageSize')){
			$this->_error('每页最多只能展示“'.config('pageSize').'”条',500);
		}
        return (new AdvModel())->advList($page, $where);
        
    }
    
    /*
     * 添加广告
     */
    public function add(){
        if(request()->isPost()){
            $data=$this->request->post();
			$validateAdv = validate('Adv');
			//数据验证
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}	
            if(!(new AdvModel())->add($data)){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑广告
     */
    public function edit(){
		$data=  request()->param();
		if (!isset($data['id'])||!is_numeric($data['id'])) {
			$this->_error('参数错误', 400);
		}
		if (!(new AdvModel())->isHas($data['id'])) {
			$this->_error('广告信息不存在', 400);
		}		
        if(request()->isPost()){    
            $validateAdv = validate('Adv');
			//数据验证
			if (!$validateAdv->check($data)) {
				$this->_error($validateAdv->getError(), 400);
			}
			if(!(new AdvModel())->edit($data)){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
        }else{
            return (new AdvModel())->advInfo(['id' => $data['id']]);
        }  
    }
    
    /*
     * 删除广告
     */
    public function delete(){
        $id=request()->get('id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少广告id',400); 
        }
        if(model('Adv')->where(['id'=>['in',$id]])->delete()===false){
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
			if(model('Adv')->where(['id'=>$data['id']])->update($data)===false){
				$this->_error('更新数据库失败',500);
			}
			return ['msg'=>'更新成功'];			
		}
	}
}
?>