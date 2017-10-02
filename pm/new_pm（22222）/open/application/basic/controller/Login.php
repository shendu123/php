<?php
/**
 * @Author AJMstr
 * @date 2017-5-5
 */
namespace app\basic\controller;

use app\common\controller\Base;
use app\basic\model\App;
use app\basic\model\Member;
use think\Db;
class Login extends Base {

    public function refreshToken() {
        echo $this->request->get('refresh_token');
    }

    public function accessToken() {
        $this->_check();
        $token=$this->_genToken();
        if($token){
            (new Member())->where(['uid' =>  $this->_uid])->setField('login_time',time());
        }
        return $token;
    }

    private function _check() {
        $this->_checkApp();
        $this->_checkUser();
    }

    private function _checkApp() {
        $this->_appid = (int)$this->request->post('appid');

        if(! (new App())->isExists($this->_appid)) {
            $this->_error('invalid appid', 500);
        }
    }

    private function _checkUser() {
        $this->_uid = (new Member())->getUidBy($this->request->post('username'), md5($this->request->post('password')));

        if(! $this->_uid) {
            $this->_error('用户名与密码不匹配', 500);
        }
    }

    private function _genToken() {
        $token = $this->_genAccessToken();
        $token['refresh_token'] = $this->_genRefreshToken();
        unset($token['app_id'], $token['uid']);

        return $token;
    }
    
    public function loginOut(){
        $deleteToken=Db::table('opb_access_token')->where(['access_token'=>$this->request->header('accesstoken')])->delete();
        if(!$deleteToken){
            $res['msg']='未知错误';
            $res['code']=500;
        }else{
            $res['msg']='退出成功';
            $res['code']=200;
        }
        echo json_encode($res);exit;
    }
}