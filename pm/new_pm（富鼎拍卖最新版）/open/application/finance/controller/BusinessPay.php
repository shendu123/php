<?php
/*
 * 运营商付款（保证金与平台使用费）
 */
namespace app\finance\controller;
use app\common\controller\NoAuth;
use app\finance\model\BusinessPay as BpModel;
use think\Request;
use think\Db;
class BusinessPay extends NoAuth
{
	public function __construct(){
        parent::__construct();
        if(!empty($this->_uid)){
            $this->_user = $this->getCallerInfo();
        }
    }
	/*
	 * 添加付款
	 */
	public function add(){
		if(request()->isPost()){
            $data=$this->request->post();
			$validateBp = validate('BusinessPay');
			//数据验证
			if (!$validateBp->check($data)) {
				$this->_error($validateBp->getError(), 400);
			}
            if(!(new BpModel())->add($data,$this->_user)){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }
	}
   
	/*
	 * 运营商付款列表
	 */
	public function payList(){
		$param = request()->param();
		if(!isset($param['business_id']) || !is_numeric($param['business_id'])){
			$this->_error('参数错误',400);
		}
		$where['business_id'] = $param['business_id'];
		return (new BpModel())->bpList($where);
	}
	
	/*
	 * 订单统计,先放这
	 */
	public function orderStatistic(){
		$where = 'business_id='.request()->get('business_id');
		$field = 'order_amount_price';
		$table = ['opf_auction_order' , 'opf_crowd_order' , 'opf_freetrading_order'];
		$sql = "";
		foreach($table as $v){
			$sql .= " select {$field} from  ".$v." where {$where} union all";
		}
		$sql = substr($sql , 0 , -9);
		$list=Db::query($sql);
		$orderInfo['order_total_price'] = 0;
		foreach($list as $k=>$v){
			$orderInfo['order_total_price']+=$v['order_amount_price'];
		}
		$orderInfo['order_count'] = count($list);
		return $orderInfo;
	} 
	
}










