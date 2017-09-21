<?php
/**
 * @Author zxl
 */
namespace app\basic\model;
use think\Model;
use think\Db;

class BusinessCompany extends Model {
	//图片字段
	public $imgFields = ['com_license','com_legal_idcard_front','com_legal_idcard_back'];
	
	//运营商
	public $businessLevel =[1=>'直营',2=>'合伙人',3=>'一级运营商',4=>'二级运营商',6=>'店铺'];
	
	//列表
	public function bcList($page,$where){
		$dataList = Db::name('BusinessCompany')->where($where)->order('com_id desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
		$count= Db::name('BusinessCompany')->where($where)->count();
		foreach($dataList as $k => $v){
			$dataList[$k] = array_merge($v,$this->DataHandle($v));
		}
		$list=[
            'data'=>$dataList,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count
        ];
		return $list;
    }
	
	//详情
	public function bcInfo($where , $method = 'view'){
		$info = Db::name('BusinessCompany')->where($where)->order('com_id asc')->find();		
		$info=$this->DataHandle($info , $method);
		return $info;
    }
	
	//添加
	public function add($data){		
		$data = $this->FormHandle($data);
		$data['com_intime'] = time();
		return $this->save($data);
	}
	
	//编辑
	public function edit($data){		
		$data = $this->FormHandle($data);
		$data['com_uptime'] = time();
		unset($data['com_intime']);
		return $this->save($data,$data['com_id']);
	}
	
	//表单数据处理
	public function FormHandle($data){
		//图片处理:1、营业执照，2、法人身份证正面，3、法人身份证反面
		foreach($this->imgFields as $v){
			if(isset($data[$v.'Array']) && $data[$v.'Array']){
				$data[$v]=$data[$v.'Array'];
			}
			unset($data[$v.'Array']);
		}
		return $data;
	}
	
	//数据处理
	public function DataHandle($data , $method = 'view'){
		//图片
		$arrPic = [];
		foreach($this->imgFields as $img){
			foreach(explode(',', $data[$img]) as $key => $val){
				$arrPic[$key] = array(
					'file_path' => $val,
					'url' => $val
				);
			}
			$data[$img]=$arrPic;
		}			
		//时间
		$data['com_intime']=date('Y-m-d H:i',$data['com_intime']);
		$data['com_uptime']=date('Y-m-d H:i',$data['com_uptime']);
		if($method == 'view'){
			//地址
			$address = ['province'=>$data['com_province'],'city'=>$data['com_city'],'area'=>$data['com_area']];
			$data['address'] = (new DeliveryAddress())->parseDetailData($address);
			//企业运营商数量
			$data['business_count_info'] = '';
			foreach($this->businessLevel as $k=>$v){
				$count=Db::name('business')->where(['business_company_id'=>$data['com_id'] , 'sysid'=>$k])->count();
				if(!$count){
					continue;
				}
				$data['business_count_info'][]= ['bLevel'=>$v,'bcount'=>$count];			
			}
		}
		
		return $data;
	}
	
    //检测企业是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['com_id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }

}