<?php
    class SSO
    {
        public function __construct()
        {
            $this->redis = new Redis();
            $this->redis->connect('127.0.0.1', 6379);
        }

        function createAccessToken(){
            $token['token'] = md5('123456');
            $token['expire'] = time()+30;
            //把$token存入redis数据库
            $this->redis->set(session_id()."_token", json_encode($token));
            return $token;
        }
        function validateAccessToken($accessToken){
            $token = $this->redis->get(session_id().'_token');
            $token = json_decode($token,true);
            if($accessToken !=  $token['token']){
                return ['err_msg'=>'token无效'];
            }
            if(time() -  $token['expire'] > 0){
                return ['err_msg'=>'token已过期'];
            }
            return true;
        }

        function  refreshToken(){

        }

    }
?>
