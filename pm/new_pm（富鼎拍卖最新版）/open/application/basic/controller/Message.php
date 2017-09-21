<?php
/**
 * @Author jzbis
 * @date 2017-5-26
 */
namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\Message as MMessage;
use think\controller\Rest;

class Message extends NoAuth {

	public function get(){
        $po  = $this->request->post();
        $uid = $this->_uid;

        $mes = new MMessage();
        $res = $mes->getMesByReid($uid,$po);

        return ["type"=>"success",'tip'=>"获取成功",'data'=>$res];

    }


    public function changeState(){
        $po = $this->request->get();

        $mes = new MMessage();
        $res = '';

        if($po['type']=='YD'){
            $res = $mes->changeIsread($po['mesid'],3);
        }

        if($po['type']=="SC"){
            $res = $mes->changeIscollect($po['mesid'],3);
        }

        if($po['type']=="XSC"){
            $res = $mes->changeIscollect($po['mesid'],2);
        }



        return ["type"=>"success",'tip'=>"修改成功",'data'=>$res];


    }

    public function create(){
        $po = $this->request->post();

        $mes = new MMessage();
        $res = $mes->saveData($po);

        if($res){
            return  ["type"=>"success",'tip'=>"保存成功",'data'=>$res];
        }else{
            return  ["type"=>"success",'tip'=>"保存失败",'data'=>$res];
        }
    }

    //是否有新消息
    public function IsNew() {
        return [
            'error'=>0,
            'isnew'=>1
        ];
    }

   














}