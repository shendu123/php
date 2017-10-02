<?php
namespace app\common\controller;

use app\basic\model\AccessToken;
use app\basic\model\MemberRole;
use app\basic\model\RefreshToken;
use app\basic\model\Node;
use think\Config;
use think\controller\Rest;
use think\Session;

class Base extends Rest
{

    protected $_appid = 0;

    protected $_sysid = 1;

    protected $_uid = 0;

    protected $_MCA;

    protected $_MC;

    protected $_username = 0;

    protected $_WHITE_REQUEST;

    public $_user;

    public function __construct()
    {
        parent::__construct();
        $this->request->request($this->request->param());
		$this->_sysid = $this->request->header('sysid', 1);
        $this->_checkAccessToken();        
        if(!empty($this->request->header('accesstoken'))){
            $this->_user = $this->getCallerInfo();
        }        
    }

    private function _checkAccessToken()
    {
        $this->_MC = $this->request->module() . '/' . $this->request->controller() . '/*';
        $this->_MCA = $this->request->module() . '/' . $this->request->controller() . '/' . $this->request->action();
        $this->_WHITE_REQUEST = Config::get('app.white_request');
        
        if ($token = (new AccessToken())->getBy($this->request->header('accesstoken'))) {
            foreach ($token as $uid => $appid) {
                $this->_appid = $appid;
                $this->_uid = $uid;
            }
            
            $this->_checkAcl();
        } else {
            if (! in_array($this->_MC, $this->_WHITE_REQUEST) and ! in_array($this->_MCA, $this->_WHITE_REQUEST)) {
                $this->_error('invalid AccessToken', '401');
            }
        }
    }

    protected function _getUsername()
    {
        if (! $this->_username) {
            $mem = new Util();
            $this->_username = $mem->getName($this->_uid);
        }
        
        return $this->_username[0];
    }

    private function _checkAcl()
    {
        if (! in_array($this->_MC, $this->_WHITE_REQUEST) and ! in_array($this->_MCA, $this->_WHITE_REQUEST)) {
            $pass = (new Node())->checkAclBy((new MemberRole())->getRoleBy($this->_uid), $this->_sysid, $this->_MCA);
            
            if (! $pass) {
                $this->_error('Forbidden-checkAcl', '403');
            }
        }
    }

    protected function _genAccessToken()
    {
        $Model = new AccessToken();
        $Model->isExists($this->_appid, $this->_uid) && $Model->isUpdate(true);
        $token = [
            'app_id' => $this->_appid,
            'uid' => $this->_uid,
            'access_token' => \Token::generate(),
            'expires' => date('Y-m-d H:i:s', time() + 3600 * 2)
        ];
        
        if ($Model->save($token)) {
            $token['expires'] = 3600 * 2;
            return $token;
        } else {
            $this->_error('generate AccessToken failed', '501');
        }
    }

    protected function _genRefreshToken()
    {
        $Model = new RefreshToken();
        $Model->isExists($this->_appid, $this->_uid) && $Model->isUpdate(true);
        $token = [
            'app_id' => $this->_appid,
            'uid' => $this->_uid,
            'refresh_token' => \Token::generate(),
            'expires' => date('Y-m-d H:i:s', time() + 3600 * 48)
        ];
        
        if ($Model->save($token)) {
            $token['expires'] = 3600 * 48;
            return $token['refresh_token'];
        } else {
            $this->_error('generate refreshToken failed', '501');
        }
    }

    /**
     * @function 获取当前接口调用者的信息
     * @author ljx
     */
    private function getCallerInfo()
    {
        if (! empty(Session::get($this->request->header('accesstoken')))) {
            
            return Session::get($this->request->header('accesstoken'));
        } else {
            // $data = curl_get_content(config("basic_api_url") . "Util/getUserInfoB", 0, "", $this->request->header('accesstoken'));
            $data = curl_get_content(config("basic_api_url") ."Util/getUserInfoB", 0, "", $this->request->header('accesstoken'));
            $data = object_array($data);
            Session::set($this->request->header('accesstoken'), $data);
            
            return $data;
        }
    }
}