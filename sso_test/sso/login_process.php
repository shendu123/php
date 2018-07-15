<?php
    include 'sso.php';

    class login_process extends SSO
    {
        public function __construct(){
            parent::__construct();
            $this->login();
        }
        public function login(){
            if($_POST['username'] && $_POST['password']){
                setcookie('username',$_POST['username']);
                $return_url = $_POST['return_url'];
                $token = $this->createAccessToken()['token'];
                header("location:".$return_url."?access_token=$token");
            }
        }
    }
    new login_process();
?>

