<?php
namespace app\finance\controller;

use think\Request;
use think\Db;
use app\common\controller\NoAuth;
use app\finance\model\Couchbase;

class Tradelog extends NoAuth
{

    public function __construct()
    {
        parent::__construct();
        $accesstoken = $this->request->header('accesstoken');
        $request_tag = valueRequest('request_tag', '', 'string'); //inner
        
        $this->_checkLogin();
        if (! empty($this->_uid)) {
            $this->_user = $this->getCallerInfo();
        } elseif (!empty($user_id) && empty($accesstoken) && $request_tag == 'inner') {
            $time = valueRequest('time', 0);
            $sign_req = valueRequest('sign_req', '', 'string');
            $sign_check = md5(config('SIGN_KEY') . md5($user_id . $time));
            if($sign_req != $sign_check){
                $this->_error('sign error', 400);
            }
            // 自动下单的时候无法获取token 需要通过uid来获取用户信息
            $this->_user = $this->getCallerInfo($user_id);
        }
    }

    /**  
     * 交易记录
     * @author zsq
     */ 
    public function log()
    {
        $pageSize = valueRequest('pageSize', 20);
        $pageSize = $pageSize > 30 ? 20 : $pageSize;     
        $where = [
                    'page' => valueRequest('page', 0),
                    'pageSize' => $pageSize,
                    'user_id' => $this->_user['user']['user_id'],
                    'stuff_type' => ['1', '2', '3'], 
                    'order_status' => input('order_status')
                ];     
        $cbModel = new Couchbase();
        $result = $cbModel->getList($where);
        
        $result['current_page'] = $where['page'];
        $result['per_page'] = $where['pageSize'];
        return $result;
    }
}