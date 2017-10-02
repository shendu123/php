<?php
namespace app\finance\controller;

use app\common\controller\NoAuth;
use app\finance\model\FundFlow;
use think\Request;

class Flow extends NoAuth
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @function 积分流水列表
     * @author ljx
     */
    public function IntegralList()
    {
    	$this->_checkLogin();
        $this->_user = $this->getCallerInfo();
        $wdata = array(
            'accesstoken' => $this->request->header('accesstoken'), // 不需要传
            'page' => valueRequest('page', 1),
            'pageSize' => valueRequest('pageSize', 10),
            'user_id' => $this->_user['user']['user_id']
        );
        $model = new \app\finance\model\IntegralFlow();
        $result = $model->getList($wdata, $this->_user);
        
        return array(
            'current_page' => $wdata['page'],
            'per_page' => $wdata['pageSize'],
            'total' => $result['total'],
            'data' => $result['data']
        );
    }

    /**
     * @function 积分流水详情
     * @author ljx
     */
    public function IntegralDetail()
    {
    }

    /**
     * @function 资金流水
     * @author zsq
     */
    public function fund(){
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;
        $where = [
                'page' => valueRequest('page', 0),
                'pageSize' => $pageSize,
                'start_at' => valueRequest('start_at', 0),
                'end_at' => valueRequest('end_at', 0),
                'status' => input('status'),
                'from' => input('from'),
                'pay_type' => input('pay_type'),          
                'keywords' => valueRequest('keywords', '', 'string')
            ];

        $list = model('FundFlow')->getList($where);
        return $list;
    }

}