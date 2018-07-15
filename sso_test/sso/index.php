<?php
    include 'sso.php';
    if($_GET['ac'] == 'auth'){
        $token = $_GET['access_token'];
        $soo = new SSO();
        $validateAccessToken = $soo->validateAccessToken($token);
        if(!isset($validateAccessToken['msg'])){
            $username = 222;//假设值，可以从数据库里查用户信息.getUserInfoByToken
            exit(json_encode(['code'=>1, 'user'=>$username]));
        }else{
            exit(json_encode(['code'=>-1, 'msg'=>$validateAccessToken['msg']]));
        }
    }

    if(empty($_COOKIE['username'])){
        header("location:http://sso.zxl/login.php?return_url={$_GET['return_url']}");
    }else{
        $sso = new SSO();
        $token = $sso->redis->get(session_id().'_token');
        $token = json_decode($token,true)['token'];
        header("location:{$_GET['return_url']}?access_token={$token}");
    }
?>