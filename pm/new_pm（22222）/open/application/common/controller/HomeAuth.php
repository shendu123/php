<?php
namespace app\common\controller;

use think\controller\Rest;
use app\basic\model\AccessToken;
use think\Session;

/**
 * @class 前端业务公共控制器
 * @author ljx
 */
class HomeAuth extends Rest
{

    protected $_appid = 0;

    protected $_uid = 0;
    
    public $_user;

    public function __construct()
    {
        parent::__construct();
        $this->_checkAccessToken();
        $this->_user = $this->getCallerInfo();
    }

    private function _checkAccessToken()
    {
        $token = (new AccessToken())->getBy($this->request->header('accesstoken'));
        if (! empty($token)) {
            foreach ($token as $uid => $appid) {
                $this->_appid = $appid;
                $this->_uid = $uid;
            }
        }else{
			header ( 'Content-Type:application/json; charset=utf-8' );
			$data = array(
			    'status' => 401,
			    'code' => 'CHA000',
			    'msg' => 'invalid AccessToken'
			);
			echo json_encode ( $data );
			exit ();
        }
    }
    
    /**
     * @function 根据accesstoken 分析接口调用者身份信息
     * @author ljx
     */
    private function getCallerInfo(){
        $accesstoken = $this->request->header('accesstoken'); 
        
        if (! empty(Session::get($accesstoken))) {
            return Session::get($accesstoken);
        } else {
            $data = curl_get_content(config("basic_api_url") . "Util/getUserInfoB", 0, "", $this->request->header('accesstoken'));
            $data = object_array($data);
            Session::set($accesstoken, $data);
        
            return $data;
        }
    }
    
}
























