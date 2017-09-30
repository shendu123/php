<?php
namespace app\finance\model;

use think\Model;
use think\Db;

/**
 * @class 余额提现订单模型
 * @author zsq
 */
class Withdraw extends Model
{
	protected $table = 'opf_withdraw';

	public $_tableFields = [
        'id' => 'int', //提现id
        'type' => 'int', // 提现方式:1:微信;2:支付宝;3:银行卡;
        'account' => 'varchar', // 提现账号
        'bankname' => 'varchar', // 提现方式为2时: 银行名字
        'open_bankname' => 'varchar', // 开户行名称
        'account_name' => 'varchar', // 账号名称
        'amount' => 'int', // 【单位分】提现金额
        'status' => 'int', // 状态
        'user_id' => 'int', // 用户id
        'mobile' => 'int', // 用户手机
        'nickname' => 'varchar', // 用户昵称
        'reason' => 'varchar', // 原因
        'operator_id' => 'int', //操作员id 
        'created_at' => 'int', // 创建时间 
        'updated_at' => 'int',  // 更新时间
	];

	/**
     * @function 添加提现
     * @author zsq
     */
	public function add($requestData=[])
	{
		$fields = parseRequestData($this->_tableFields, $requestData);
        $fields['created_at'] = time();
        $fields['updated_at'] = time();

        $result = $this->save($fields);
        return $result;
	}	

	/**
     * @function 提现列表
     * @author zsq
     * @param $where 查询条件
     */
	public function getList($where)
	{
		$condition['user_id'] = $where['user_id'];		 
		
		$list = Db::table('opf_withdraw')
            		->where($condition)
            		->field('id,status,amount,created_at')
            		->order('id desc')
            		->limit(($where['page'] - 1) * $where['pageSize'] . ',' . $where['pageSize'])
            		->select();
        foreach($list as $k => $v){
            $list[$k]['created_at'] = date('Y-m-d H:i', $v['created_at']);
        }
        $count = Db::table('opf_withdraw')
            		->where($condition)
            		->count();    		
       
        $result = [
            'count' => $count,
            'data' => $list
        ];
        return $result;   		
	}	

	/**
     * @function 后台会员提现列表
     * @author zsq
     * @param $where 查询条件
     */	
	public function getAllList($where)
	{
		$condition = [];
		if(!empty($where['status'])){
			$condition['status'] = $where['status'];  
		}
		if(!empty($where['start_at'] && !empty($where['end_at']))){
			$condition['created_at'] = ['between', [$where['start_at'], $where['end_at']]];
		}
		if(!empty($where['keywords'])){
			$condition['mobile|nickname'] = ['like', '%' . $where['keywords'] . '%'];
		}
		
		$list = Db::table('opf_withdraw')
		            ->where($condition)
		            ->field('id, created_at, nickname, amount, type, account, account_name, status')
		            ->order('id desc')
		            ->limit(($where['page'] - 1) * $where['pageSize'] . ',' . $where['pageSize'])
		            ->select();

		$count = Db::table('opf_withdraw')
            		->where($condition)
            		->count();             
        
        $pendingAmount = Db::table('opf_withdraw')
		            		->where(['status' => 0])
		            		->sum('amount');
		$passedAmount = Db::table('opf_withdraw')
							->where(['status' => 5])
		            		->sum('amount');            		
		$successAmount = Db::table('opf_withdraw')
							->where(['status' => 10])
		            		->sum('amount');
		$allAmount = Db::table('opf_withdraw')
		            		->sum('amount');           		
		
		return  $result = [
            		'total' => $count,
                    'current_page' => $where['page'],
                    'per_page' => $where['pageSize'],
            		'data' => [
                        'list' => $list,
                        'pending_amount' => $pendingAmount,
                        'passed_amount' => $passedAmount,
                        'success_amount' => $successAmount,
                        'all_amount' => $allAmount     
                    ]
        		];          		            		
	}

    /**
     * @function 后台会员提现审核
     * @author zsq
     * @param $where 查询条件
     */
    public function edit($update)
    {
        $fields = parseRequestData($this->_tableFields, $update);
        $fields['updated_at'] = $_SERVER['REQUEST_TIME'];
        
        $where = [
            'id' => $fields['id']
        ];

        return $this->save($fields, $where);
    }   
}	