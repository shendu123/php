<?php
/**
 * @Author jzbis
 * @date 2017-5-26
 */
namespace app\basic\controller;


use app\common\controller\NoAuth;
use app\basic\model\Message;
use app\basic\model\Member;
use app\basic\model\DeliveryAddress;
use app\basic\model\ChinaArea;
use app\basic\library\Util;


class Address extends NoAuth {

    //获取省
    public function getProvince(){
        $china = new ChinaArea();
        return $china->getListByParent(7459);
    }

    //获取市
    public function getCity(){
        $po = $this->request->get('proid');
        $china = new ChinaArea();
        return $china->getListByParent($po);
    }

    //获取区
    public function getCounty(){
        $po = $this->request->get('tid');
        $china = new ChinaArea();
        return $china->getListByTid($po);
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getDetail($id = 0){
        $po_id = $this->request->get('id');
        $id = $id ? $id : $po_id;
        
        $china = new ChinaArea();
        return $china->getDetail($id);
        
    }
    
    /**
     * @function 获取地区
     * @author ljx
     */
    public function getDistrict(){
        $po = $this->request->get('tid');
        $china = new ChinaArea();
        return $china->getListByParent($po);
    }

    public function add() {
        $po = $this->request->post();
        $util = new Util();
        $need = ["addr_type",
                "addr_address",
                "addr_mobile",
                "addr_postalcode",
                "addr_truename",
                "area",
                "city",
                "province",
                "addr_phone"];
        $util->checkPostIsempty($po,$need);

        $uid = $this->_uid;
        if(isset($po['addr_type'])){
            $addr = new DeliveryAddress();
            $res = $addr->saveData($po,$uid);

           if($res){
                return ["type"=>"success",'tip'=>"成功",'data'=>$res[0]];
            }
        }

        return ["type"=>"error",'tip'=>"保存失败","data"=>$res];
    }


    public function update(){
        $po = $this->request->post();
        if(isset($po['id'])){
            $addr = new DeliveryAddress();
            $res = $addr->updateById($po);

            if($res){
                return ["type"=>"success",'tip'=>"成功",'data'=>$res[0]];
            }
        }


        return ["type"=>"error",'tip'=>"更新失败",'data'=>$res[0]];
        
    }

    public function getById(){
        $uid = $this->_uid;
        $id = $this->request->post('id');
        if(!isset($id)){
            return ["type"=>"error",'tip'=>"获取地址失败"];
        }

        $add = new DeliveryAddress();
        $addr = $add->getDataById($id);


        if($addr){
            return ["type"=>"success",'tip'=>"获取地址成功",'data'=>$addr];
        }else{
            return ["type"=>"error",'tip'=>"获取地址失败 或者没有地址",'data'=>$addr];
        }
    }



	public function get(){
        $uid = $this->_uid;

        $addr = model('DeliveryAddress')->where(" owner_id =  {$uid} ")->column('id');
        // var_dump($uid);exit();

        if($addr){
            return ["type"=>"success",'tip'=>"获取地址成功",'data'=>$addr[0]];
        }else{
            return ["type"=>"error",'tip'=>"获取地址失败 或者没有地址",'data'=>$addr];
        }
    }

    public function getList(){
        $uid = $this->_uid;
        $add = new DeliveryAddress();
        $addr = $add->getDataListById($uid);


        // $addr = model('DeliveryAddress')->where(" owner_id =  {$uid} ")->select();
        //var_dump($uid);//exit();

        if($addr){
            return ["type"=>"success",'tip'=>"获取地址成功",'data'=>$addr];
        }else{
            return ["type"=>"error",'tip'=>"获取地址失败 或者没有地址",'data'=>$addr];
        }
    }

    public function setDefault(){
        $uid = $this->_uid;
        $po = $this->request->get();
        $res = model('DeliveryAddress')->where("owner_id =  {$uid} ")->setField("addr_isdefault",2);
        $res  = model('DeliveryAddress')->where("id = '".$po['id']."'")->setField("addr_isdefault",3);
        if($res){
            return ["type"=>"success",'tip'=>"修改地址为默认 成功",'data'=>$res];
        }else{
            return ["type"=>"error",'tip'=>"修改地址为默认 失败",'data'=>$res];
        }

    }

    public function isExist(){
        $addr = model('DeliveryAddress')->where('owner_id', $_POST['uid'])->column('id');

       	return empty($addr) ? false: true;
    }





    public function edit() {

    }

    public function del() {
        if(! model('DeliveryAddress')->where('id', $this->request->get('id'))->delete()) {
            $this->_error('删除失败，请稍后再试', 200);
        }

        return ['msg'=> '删除成功'];
    }










   






}