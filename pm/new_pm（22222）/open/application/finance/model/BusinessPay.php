<?php
/**
 * @Author zxl
 */
namespace app\finance\model;

use think\Model;
use think\Db;

class BusinessPay extends Model {
	
	protected $table = 'opf_business_pay';
	
	//付款类型
	public $type=[1=>'保证金',2=>'平台使用费'];
	
	//付款方式
	public $pay_type=[1=>'银联',2=>'支付宝',3=>'微信',4=>'余额'];
	
	//付款状态
	public $pay_status=[0=>'未付款',1=>'已付款'];
	
	//列表
	public function bpList($where){
		$list = Db::table($this->table)->where($where)->order('id desc')->select();
		$fee['deposit_money']=$fee['plat_money']=0;
		foreach($list as $k => $v){
			$list[$k] = array_merge($v,$this->DataHandle($v));
			if($v['type'] == 1){
				$fee['deposit_money'] += $v['money'];
			}else{
				$fee['plat_money'] += $v['money'];
			}
			$list['fee'] = $fee;			
		}
		return $list;
    }

	//添加
	public function add($data,$user){
		$data['pay_time'] = strtotime($data['pay_time']);
		return $this->save($data);
		
	}
	
	//数据处理
	public function DataHandle($data){
		//时间处理
		$data['pay_time'] = date("Y-m-d H:i:s",$data['pay_time']);
		//状态数据
		$data['type'] = $this->type[$data['type']];
		$data['pay_type'] = $this->pay_type[$data['pay_type']];
		$data['pay_status'] = $this->pay_status[$data['pay_status']];
		return $data;
	}

	



}