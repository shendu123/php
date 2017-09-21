<?php
/**
 * @Author jzbis
 * @date 2017-5-26
 */
namespace app\basic\controller;

use app\common\controller\Base;

class Wechat extends Base {

    public function setOpenid(){
        $uid = $this->_uid;
        $openid = $this->request->post("openid");

        $res = model('Member')->where(array('uid'=>$uid))->setInc('openid',$openid);
        if($res){
            return true;
        }else{
            return false;
        }
    }
















}