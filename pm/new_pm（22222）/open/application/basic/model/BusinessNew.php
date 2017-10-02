<?php
/**
 * @Author zxl
 */
namespace app\basic\model;

use think\Model;
use think\Db;
use think\Cache;

class BusinessNew extends Model {
	
	protected $table = 'opb_business';
	
	//运营商店铺等级
	public $business_level=[1=>'直营',2=>'合伙人',3=>'一级运营商',4=>'二级运营商',5=>'客户'];
	
	//店铺状态
	public $business_status=[1=>'开启',2=>'关闭'];
	
	//运营商审核状态
	public $business_check_status=[0=>'待审核',1=>'审核通过',2=>'审核未通过'];
	
	//商品显示
	public $business_goods_show=[1=>'显示',2=>'不显示'];
	
	//店铺显示
	public $business_show=[1=>'显示',2=>'不显示'];
	
	//店铺推荐
	public $business_is_recommend=[0=>'不推荐',1=>'推荐'];
	
	//缓存版本(实现分页缓存)
	private $cache_version = 'cache_version'; 
	
	//列表
	public function bcList($page,$where){
		$cache_id = 'list_page'.$page['page'].'_limit'.$page['pageSize'].'_sysid'.$where['sysid'].'_businessid'.$where['business_id'].'v_'.$this->getCacheVersion(); 
		if($list = Cache::get($cache_id)){
			return $list;
		}
		if($where['sysid']!=1){//非总部平台
			$where['pid']=$where['business_id'];
		}
		unset($where['business_id']);
		unset($where['sysid']);
		$dataList = Db::name('Business')->where($where)->order('business_id desc')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
		$count= Db::name('Business')->where($where)->count();
		foreach($dataList as $k => $v){
			$dataList[$k] = array_merge($v,$this->DataHandle($v));
		}
		$list=[
            'data'=>$dataList,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count
        ];
		Cache::set($cache_id, $list);
		return $list;
    }
	
	//详情
	public function bcInfo($where , $method = 'view'){
		$info = Db::name('Business')->where($where)->find();
		if($method == 'edit'){
			$info['business_starttime'] = date("Y-m-d H:i",$info['business_starttime']);
			$info['business_endtime'] = date("Y-m-d H:i",$info['business_endtime']);
			return $info;
		}		
		$data['basic'] = array_merge($info,$this->DataHandle($info));
		$data['business_company'] = curl_get_content(config('basic_api_url')."business_company/view?com_id={$info['business_company_id']}",$post=0, $postData='', request()->header('accesstoken'));
		$data['business_pay'] = curl_get_content(config('finance_api_url').'business_pay/payList?business_id='.$info['business_id'], $post=0, $postData='', request()->header('accesstoken'));
		return $data;
    }
	
	//添加
	public function add($data,$user){	
		$data=$this->FormHandle($data,$user,'add');
		//开启事务
		Db::startTrans();		
		try{		
			$data['member_rule']['business_id'] = $data['member']['business_id'] = Db::name('Business')->insertGetId($data['business']);
			$data['member_rule']['member_id'] = $data['member_role']['uid'] = Db::name('Member')->insertGetId($data['member']);
			model('MemberRule')->save($data['member_rule']);
			model('MemberRole')->save($data['member_role']);
			Db::commit();
			$this->setCacheVersion();
			return true; 
		}catch(\Exception $e){
			//echo $e->getMessage();
			Db::rollback();
			return false;
		}
	}
	
	//编辑
	public function edit($data,$user){
		$data=$this->FormHandle($data,$user,'edit');
		$memberWhere['business_id']=$data['business']['business_id'];
		$memberWhere['account']=$data['business']['business_account'];
		$data['member_role']['uid'] = model('Member')->where($memberWhere)->value('uid');
		//开启事务
		Db::startTrans();		
		try{			
			model('Business')->save($data['business'],$data['business']['business_id']);
			model('Member')->save($data['member'],$memberWhere);
			if(!model('MemberRole')->where($data['member_role'])->find()){//没有权限时就授权
				model('MemberRole')->save($data['member_role']);
			}
			Db::commit();
			//Cache::rm('list');
			$this->setCacheVersion();
			return true; 
		}catch(\Exception $e){
			Db::rollback();
			return false;
		}
	}
	
	//表单数据处理
	public function FormHandle($data,$user,$method = 'add'){
		//member表数据
		if(isset($data['login_pwd']) && $data['login_pwd']){
			$mData['pwd'] = md5(md5($data['login_pwd']));	
		}
		$mData['account'] = $data['business_account'];
		$mData['mobile'] = $data['business_account'];
		//member_rule表数据
		$mruleData['rule_oprid']=$user['user']['user_id'];
		$mruleData['rule_type']=95;//0普通会员 10企业会员 90营业人员 95商户总管理		
		//运营商表数据 $data
		$data['business_starttime'] = strtotime($data['business_starttime']);
		$data['business_endtime'] = strtotime($data['business_endtime']);
		unset($data['login_pwd']);
		if($method == 'add'){
			if( isset($data['pid']) && $data['sysid']!=4){//给一级运营商添加二级运营商
				$data['sysid'] = 4;
				unset($data['business_id']);
			}			
			$mruleData['rule_intime'] = time();			
			$data['business_intime'] = time();
			unset($data['business_uptime']);
		}else{			
			$data['business_uptime'] = time();
			unset($data['business_intime']);
		}
		//member_role表,添加运营商时就授予权限
		$mroleData['role_id'] = model('role')->where(['sysid'=>$data['sysid'],'pid'=>0])->value('id');
		return ['member'=>$mData,'member_role'=>$mroleData,'member_rule'=>$mruleData,'business'=>$data];
	}
	
	//查询显示数据处理
	public function DataHandle($data){
			$data['business_level'] = $this->business_level[$data['sysid']];
			$data['status_tag'] = $this->business_status[$data['status']];
			$data['business_allow_goods_show_tag'] = $this->business_goods_show[$data['business_allow_goods_show']];
			$data['business_allow_show_tag'] = $this->business_show[$data['business_allow_show']];
			$data['business_is_recommend_tag'] = $this->business_is_recommend[$data['business_is_recommend']==1?1:0];
			$data['business_check_status'] = $this->business_check_status[$data['business_check_status']?$data['business_check_status']:0];
			$data['business_intime'] = date("Y-m-d H:i",$data['business_intime']);
			$data['business_uptime'] = date("Y-m-d H:i",$data['business_uptime']);
			$data['business_starttime'] = date("Y-m-d H:i",$data['business_starttime']);
			$data['business_endtime'] = date("Y-m-d H:i",$data['business_endtime']);
			//店铺关注数
			$data['business_attention_count'] = Db::name('MemberBusinessAttention')->where(['business_id'=>$data['business_id']])->count();
			//推荐会员数(前台选择此运营商注册的会员)
			$data['recommend_member_count'] = Db::name('Member')->where(['business_id'=>$data['business_id']])->count();
			//订单统计（订单数、订单总金额）
			$order = curl_get_content(config('finance_api_url').'business_pay/orderStatistic?business_id='.$data['business_id'], $post=0, $postData='', request()->header('accesstoken'));
			$data['order'] = $order;		
			return $data;
	}
	
    //检测运营商是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['business_id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }
	
	public function getCacheVersion(){ 
        $cache_version_num = Cache::get($this->cache_version); 
        if( FALSE === $cache_version_num){ 
            $cache_version_num = 1; 
            Cache::set($this->cache_version, $cache_version_num, 86400); 
        } 
        return $cache_version_num; 
    } 
     
    public function setCacheVersion(){ 
        $cache_version_num = Cache::get($this->cache_version); 
        $cache_version_num++; 
        Cache::set($this->cache_version, $cache_version_num, 86400); 
    } 

}