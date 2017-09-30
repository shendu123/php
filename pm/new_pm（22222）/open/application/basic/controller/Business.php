<?php

/**
 * 运营商
 * @Author zxl
 */
namespace app\basic\controller;
use app\common\controller\Base;
use app\basic\model\BusinessNew as BuNewModel;
use app\basic\model\BusinessService;
use think\Request;
use think\Db;
class Business extends base
{

    /*
     * 运营商列表
     */
    public function index(){ 
		$param=request()->param();
        $where=[];
        if(isset($param['keyword']) && !empty($param['keyword'])){
            $where['com_name|com_contact_name|com_contact_mobile']=['like','%'.$param['keyword'].'%'];
        }
		$where['sysid'] = $this->_sysid;
		$where['business_id']=$this->_user['business']['business_id'];
        $page['pageSize']= isset($param['page_size']) && intval($param['page_size']) < config('max_size') ? intval($param['page_size']) : config('max_size');
        $page['page']=isset($param['page']) ? intval($param['page']) : 1;
        return (new BuNewModel())->bcList($page, $where);
        
    }
    
    /*
     * 添加运营商
     */
    public function add(){
        if(request()->isPost()){
            $data=$this->request->post();
			$validateBc = validate('Business');
			//数据验证
			if (!$validateBc->check($data)) {
				$this->_error($validateBc->getError(), 400);
			}
			//var_dump($data);
            if(!(new BuNewModel())->add($data,$this->_user)){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
    }
    
    /*
     * 编辑运营商
     */
    public function edit(){
		$data=  request()->param();
		if (!isset($data['business_id'])||!is_numeric($data['business_id'])) {
			$this->_error('参数错误', 400);
		}
		if (!(new BuNewModel())->isHas($data['business_id'])) {
			$this->_error('运营商信息不存在', 400);
		}		
        if(request()->isPost()){    			
            $validateBc = validate('Business');
			//数据验证
			if (!$validateBc->check($data)) {
				$this->_error($validateBc->getError(), 400);
			}
            if(!(new BuNewModel())->edit($data,$this->_user)){
                $this->_error('编辑失败', 500);  
            }
            return ['msg'=> '编辑成功'];
        }else{
            return (new BuNewModel())->bcInfo(['business_id'=>$data['business_id']],'edit');
        }  
    }
    
    /*
     * 删除运营商
     */
    public function delete(){
        $id=request()->get('business_id');
        if (!isset($id) || empty($id)) {
            $this->_error('缺少运营商id',400); 
        }
		
		if(model('Business')->where(['pid' => $id])->value('business_id')){
			$this->_error('此运营商下有二级运营商，不能删除',500); 
		}
	
        if(model('Business')->where(['business_id'=>['in',$id]])->delete()===false){
            $this->_error('删除失败', 500); 
        }
		//清除缓存
		(new BuNewModel())->setCacheVersion();
        return ['msg'=> '删除成功'];
    }
	
	/*
	 * 查看运营商
	 */
    public function view(){
        $id=request()->get('business_id');
        if (!isset($id)||!is_numeric($id)) {
            $this->_error('缺少运营商id',400); 
        }
        return (new BuNewModel())->bcInfo(['business_id'=>$id]);
    }
	
	/*
	 * 运营商审核(前端调用查看企业详情的接口获取企业信息进行审核,这里只做post处理)
	 * 1)、审核不通过，填写原因,跳转到运营商列表
	 * 2)、审核通过，跳转到运营商列表或者到下一步添加二级运营商
	 */
	public function check(){
		if(request()->isPost()){
			$param=  request()->param();
			if (!isset($param['business_id']) || !isset($param['business_check_status'])) {
				$this->_error('参数错误',400); 
			}
			if($param['business_check_status'] == 2){//审核不通过
				if(!isset($param['business_check_reason'])){
					$this->_error('请填写审核失败原因',400); 
				}
				$data['business_check_reason'] = $param['business_check_reason'];
			}
			$data['business_check_status'] = $param['business_check_status'];
			if(model('Business')->save($data,['business_id'=>$param['business_id']]) === false){
                $this->_error('操作失败', 500);  
            }
			$sysid = Db::name('Business')->where('business_id='.$param['business_id'])->value('sysid');
			$result = ['business_id'=>$param['business_id'] , 'sysid'=>$sysid];
			$checkSuccess = ['data'=>$result , 'msg'=> '操作成功，审核通过' , 'status' => 200];
			$checkFailure = ['msg'=> '操作成功，审核失败' , 'status' => 200];
			//清除缓存
			(new BuNewModel())->setCacheVersion();
			return $param['business_check_status'] == 1 ?  $checkSuccess :  $checkFailure;		            
		}		
	}
	
	/*
	 * ajax更新排序/是否推荐/店铺状态/商品显示/店铺显示
	 * 1、business_is_recommend 店铺推荐 0不推荐 1推荐
	 * 2、status 店铺状态 1正常 2屏蔽
	 * 3、business_allow_goods_show 店铺商品是否在商城展示，1允许，2不允许
	 * 4、business_allow_show 店铺是否在商城展示，1允许，2不允许
	 */
	public function changeSortOrRec(){
		if(request()->isPost()){
			$data=request()->param();			
			if(!isset($data['business_id']) || !is_numeric($data['business_id'])){
				$this->_error('参数错误',400);
			}
			if(isset($data['business_sort'])&&!is_numeric($data['business_sort'])){
				$this->_error('排序参数非法',400);
			}			
			if(isset($data['field_status']) && !empty($data['field_status'])){
				list( $field_name , $field_value) = explode('|',$data['field_status']);
				$fields = ['business_is_recommend' , 'status' , 'business_allow_goods_show' , 'business_allow_show'];			
				if(!in_array( $field_name , $fields )){
					$this->_error($field_name.'参数名非法',400);
				}			
				$fieldsValArr = $field_name == 'business_is_recommend' ? [0,1] : [1,2];
				if(!in_array( $field_value , $fieldsValArr )){
					$this->_error($field_value . '参数值非法',400);
				}
				$data[$field_name] = $field_value;
				unset($data['field_status']);
			}			
			if(model('Business')->save($data , ['business_id'=>$data['business_id']]) === false){
				$this->_error('更新数据库失败',500);
			}
			//清除缓存
			(new BuNewModel())->setCacheVersion();
			return ['msg'=>'更新成功'];			
		}
	}

}










