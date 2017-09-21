<?php
namespace app\message\controller;
class Push{
    public function index(){
        require_once __DIR__ . '/../library/PushEvent.php';
        
        $string = 'Man Always Remember Love Because Of Romance Only';
        $uid = 123;
        $push = new \PushEvent();
        $result = $push->setUser($uid)->setContent($string)->push();
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        echo "<pre>"; var_dump(999,$result); die;//======================================//
    }
}
