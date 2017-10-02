<?php
namespace app\common\controller;

use app\basic\model\AccessToken;
use app\basic\model\Util;
use think\controller\Rest;
use think\Session;

class NoAuth extends Rest {
    protected $_appid = 0;
    protected $_sysid = 1;
    protected $_uid = 0;
    protected $_username = 0;
    public $request_time; //请求时间
    public $_user;

    public function __construct() {
        parent::__construct();
        $this->request_time = $_SERVER['REQUEST_TIME'];
        $this->request->request($this->request->param());
        $this->_checkAccessToken();
        $this->_sysid = $this->request->header('sysid', 1);
    }

    private function _checkAccessToken() {
        if($token = (new AccessToken())->getBy($this->request->header('accesstoken'))) {
            foreach ($token as $uid => $appid) {
                $this->_appid = $appid;
                $this->_uid = $uid;
            }
        }
    }

    protected function _checkLogin() {
        if(! $this->_uid) {
            $this->_error('Invalid AccessToken', 401);
        }
    }
    
    /**
     * @function 获取当前接口调用者的信息
     */
    public function getCallerInfo($user_id_param = 0)
    {
        $user_id_req = valueRequest('user_id', 0);
        $user_id = $user_id_param ? $user_id_param : $user_id_req;
        $accesstoken = $this->request->header('accesstoken');
        
        if(!empty($accesstoken)){
            if (! empty(Session::get($accesstoken))) {
                return Session::get($accesstoken);
            } else {
                $data = curl_get_content(config("basic_api_url") . "Util/getUserInfoB", 0, "", $accesstoken);
                $data = object_array($data);
                if(empty($data)){
                    $this->_error('无法获取到用户信息', 400);
                }
                Session::set($accesstoken, $data);
            
                return $data;
            }
        }elseif(!empty($user_id)){
            $data = curl_get_content(config("basic_api_url") . "Util/getUserInfoByUid?user_id={$user_id}");
            $data = object_array($data);
            
            return $data;
        }else{
            $this->_error('无法获取到用户信息', 400);
        }
    }
    
    /**
     * @function 获取用户钱包详情
     * @author ljx
     */
    public function getUserWallet(){
        $model = new \app\finance\controller\WalletHome();
        $wallet = $model->detail();
    
        return $wallet['data'];
    }
    
}