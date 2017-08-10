<?php
namespace Admin\Model;
use Think\Model;
class SystemLogModel extends Model {
    public function addLog($data) {
        $systemLog=M('system_log');
        $logdata['create_time']=time();
        $logdata['user_name']= $_SESSION['email'];
        $logdata['user_type']=0;//0后台，1前台
        $logdata['url']=$_SERVER['REQUEST_URI'];
        $logdata['action']=$data['action'];
        $logdata['description']=$data['description'];
        $logdata['ip']=$_SERVER["REMOTE_ADDR"];
        $logdata['status']=$data['status'];
        return $systemLog->add($logdata);
    }
}

?>
