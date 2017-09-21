<?php
/*
 * 商户企业
 */
namespace app\basic\controller;
use app\basic\model\BusinessCompany as bcModel;
use app\common\controller\Base;
class BusinessCompany extends Base {
    
   function __construct() {
       parent::__construct();
   }
    
    /*
     * 企业列表
     */
    public function index(){ 
		$param=request()->param();
        $where=[];
        if(isset($param['keyword']) && !empty($param['keyword'])){
            $where['com_name|com_contact_name|com_contact_mobile']=['like','%'.$param['keyword'].'%'];
        }		
        $page['pageSize']= isset($param['page_size']) && intval($param['page_size']) < config('max_size') ? intval($param['page_size']) : config('max_size');
        $page['page']=isset($param['page']) ? intval($param['page']) : 1;
        return (new bcModel())->bcList($page, $where);
        
    }
    
    /*
     * 添加企业
     */
    public function add(){
        if(request()->isPost()){
            $data=$this->request->post();
			$validateBc = validate('BusinessCompany');
			//数据验证
			if (!$validateBc->check($data)) {
				$this->_error($validateBc->getError(), 400);
			}
            if(!(new bcModel())->add($data)){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑企业
     */
    public function edit(){
		$data=  request()->param();
		if (!isset($data['com_id'])||!is_numeric($data['com_id'])) {
			$this->_error('参数错误', 400);
		}
		if (!(new bcModel())->isHas($data['com_id'])) {
			$this->_error('企业信息不存在', 400);
		}		
        if(request()->isPost()){    			
            $validateBc = validate('BusinessCompany');
			//数据验证
			if (!$validateBc->check($data)) {
				$this->_error($validateBc->getError(), 400);
			}
            if(!(new bcModel())->edit($data)){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
        }else{
            return (new bcModel())->bcInfo(['com_id'=>$data['com_id']] , 'edit');
        }  
    }
    
    /*
     * 删除企业
     */
    public function delete(){
        $id=request()->get('com_id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少企业id',400); 
        }
        if(model('BusinessCompany')->where(['com_id'=>['in',$id]])->delete()===false){
            $this->_error('删除失败', 500); 
        }
        return ['msg'=> '删除成功'];
    }
	
	/*
	 * 查看企业
	 */
    public function view(){
        $id=request()->get('com_id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少企业id',400); 
        }
        return (new bcModel())->bcInfo(['com_id'=>$id] , 'view');
    }	
	

}
?>