<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use app\finance\model\Withdraw as WithdrawModel;
use app\finance\model\BusinessWithdraw;
use think\Request;

/**
 * @class 会员提现管理
 * @author zsq
 */
class Withdraw extends NoAuth{
    
    public function __construct()
    {
        parent::__construct();
        if(!empty($this->_uid)){
            $this->_user = $this->getCallerInfo();
        }
    }

	/**
	 * @function 获取会员提现申请
	 * @author zsq
	 * @see 用于后台获取提现申请
	 */
    public function drawList()
    {
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;
        
        $where = [
                'page' => valueRequest('page', 0),
                'pageSize' => $pageSize,
                'start_at' => valueRequest('start_at', 0),
                'end_at' => valueRequest('end_at', 0),
                'status' => input('status'),  
            	'keywords' => valueRequest('keywords', '', 'string')
            ];
            
        $model = new WithdrawModel();
        $result = $model->getAllList($where);        
        
        return $result;
    }

    /**
     * @function 获取商家提现列表
     * @author zsq
     * @see 用于获取商家提现申请
     */
    public function businessList()
    {
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;
        
        $where = [
                'page' => valueRequest('page', 0),
                'pageSize' => $pageSize,
                'start_at' => valueRequest('start_at', 0),
                'end_at' => valueRequest('end_at', 0),
                'status' => input('status'),  
                'keywords' => valueRequest('keywords', '', 'string')
            ];
            
        $model = new BusinessWithdraw();
        $result = $model->getAllList($where);        
        
        return $result;
    }

    /**
     * @function 后台会员提现审核
     * @author zsq
     */
    public function memberCheck()
    {
        $data = $this->request->post();
        $model = new WithdrawModel();
        
        $result = $model->edit($data);
        
        if($result){
            return ['success'=>true, 'status'=>$data['status'], 'msg'=>'审核完成'];
        }else{
            return ['success'=>false, 'msg'=>'审核失败'];
        }
    }   

    /**
     * @function 后台商家提现审核
     * @author zsq
     */
    public function businessCheck()
    {
        $data = $this->request->post();
        $model = new BusinessWithdraw();
        
        $result = $model->edit($data);
        
        if($result){
            return ['success'=>true, 'status'=>$data['status'], 'msg'=>'审核完成'];
        }else{
            return ['success'=>false, 'msg'=>'审核失败'];
        }
    }   

}