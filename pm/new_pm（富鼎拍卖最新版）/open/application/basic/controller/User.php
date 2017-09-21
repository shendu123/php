<?php
/**
 * @Author AJMstr
 * @date 2017-5-5
 */
namespace app\basic\controller;

use app\common\controller\Base;
use app\basic\model\Member;
use app\common\controller\NoAuth;
use app\basic\model\MemberRole;
use app\basic\model\Role;
use think\Db;
class User extends NoAuth {


    public function profile() {
        $profile = model('Member')->where('uid', $this->_uid)->column('uid,nickname,truename,mobile');

        return empty($profile) ? [] : array_pop($profile);
    }

    public function index() {        
        $keyword=request()->param('keyword');
        $where=[];
        if($keyword){
            $where['mobile|account']=['like',"%".$keyword."%"];
        }        
        $users = model('Member')->where($where)->field('uid,email,business_id,account,nickname,truename,login_time,mobile,avatar,sex')->paginate($this->request->param('s'))->toArray();
        foreach($users['data'] as $index => &$user) {
            $user['login_time']=date('Y-m-d H:i:s',$user['login_time']);
            $user['avatar'] = [['file_path' => $user['avatar'], 'url' => $user['avatar']]];
            $rid=(new MemberRole())->getRoleByUid($user['uid']);
            $user['role']=['name'=>(new Role())->getRoleNameById($rid),'id'=>$rid];
        }
        $users['cond'] = $this->request->request();

        return $users;
    }

    /**
     * [用户添加]
     */
    public function add(){
        $noAuth=new NoAuth();
        $user=$noAuth->getCallerInfo();
        if(request()->isPost()){
            $post=  request()->post();
            //member表数据
            $mData['account']=$post['account'];
            $mData['truename']=$post['truename'];
            $mData['mobile']=$post['mobile'];
            $mData['pwd']=md5(md5($post['pwd']));
            if(isset($post['avatar'][0]['url'])){
                $mData['avatar']=$post['avatar'][0]['url'];
            }
            //member_role表数据
            if(isset($post['role']['id'])){
                $mrData['role_id']=$post['role']['id'];
            }
            //member_rule表数据
            $mruleData['rule_oprid']=$this->_uid;
            $mruleData['rule_type']=90;//0普通会员 10企业会员 90营业人员 95商户总管理
            $mruleData['rule_intime']=time();            
            //wallet表数据
            $util=new \app\finance\library\Util();
            $waData['pay_wallet_id']=$util->getUID();            
            //启动事务
            Db::startTrans();
            try{
                $mData['business_id']=$mruleData['business_id']=$user['business']['business_id'];
                $mrData['uid']=$waData['uid']=$mruleData['member_id']=Db::name('Member')->insertGetId($mData);                 
                model('MemberRole')->save($mrData);
                model('MemberRule')->save($mruleData);
                Db::table('op_pay.opa_wallet')->insert($waData);               
                Db::commit();
                return ['msg'=> '添加成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('添加失败', 500);                  
            }
        }  
    }

    /**
     * [用户编辑]
     */
    public function edit(){        
        if(request()->isPost()){
            $post=  request()->post();
            $data['account']=$post['account'];
            $data['truename']=$post['truename'];
            $data['mobile']=$post['mobile'];
            if(isset($post['avatarArray'])){
                $data['avatar']=$post['avatarArray'];
            }
            if(isset($post['role']['id'])){
                $mrData['role_id']=$post['role']['id'];
            }
            if(isset($post['pwd'])){
                $data['pwd']=md5(md5($post['pwd']));
            }
            //print_r($post);exit;
            //启动事务
            Db::startTrans();
            try{
                model('Member')->where(['uid'=>$post['uid']])->update($data);
                if(model('MemberRole')->where(['uid'=>$post['uid']])->value('role_id')==false){
                    $mrData['uid']=$post['uid'];
                    model('MemberRole')->save($mrData);
                }else{
                    model('MemberRole')->where(['uid'=>$post['uid']])->update($mrData);
                }                
                Db::commit();
                return ['msg'=> '编辑成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('编辑失败', 500);                  
            }
            
        }  
    }

    /**
     * [用户删除]
     */
    public function delete(){
        if(request()->isDelete()){
            $id=request()->param('id');
            if(!model('Member')->where(['uid'=>['in',$id]])->delete()){
                $this->_error('删除失败'.model('Member')->getLastSql(), 500);
            }
            return ['msg'=> '删除成功'];
        }
    }
    /**
     * [用户状态设置]
     */
    public function changeStatus() {
        if(request()->isPost()){
            $id=request()->param('id');
            $data['rule_state']=request()->param('status');
            if(model('MemberRule')->where(['member_id'=>['in',$id]])->update($data)===false){
                $this->_error('设置失败'.model('Member')->getLastSql(), 500);
            }
            return ['msg'=> '设置成功'];
        }        
    }
    
    /**
     * [用户审核]
     */
    public function check(){        
        if(request()->isPost()){
            $param=  request()->param();
            $data['uid']=$param['uid'];
            if($param['status']==-1){
                $data['com_check_reason']=$param['checkmsg'];
                $data['com_check_status']=3;
            }else{
                $data['com_check_reason']='';
                $data['com_check_status']=2;
            }
            $data['com_oprid']=$param['uid'];
            $data['com_checktime']=date("Y-m-d H:i:s",time());            
            if(model('MemberCompany')->where(['uid'=>$param['uid']])->update($data)===false){
                $this->_error('操作失败', 500);  
            }
            return ['msg'=> '操作成功'];
        }else{
            $uid=  request()->get('uid');
            $info=Db::name('member_company')->where(['uid'=>$uid])->find();
            return $info;
        }  
    }
    
    /*
     * [修改密码]
     */
    public function changePwd(){
       if(request()->isPost()){
           $param = request()->param();
           $uid  = $this->_uid;

           if(!model('Member')->where(['pwd'=>md5(md5($param['oldPwd'])),'uid'=> $uid])->value('mobile')){
               $this->_error('原始密码错误',200);
           }
           if(!model('Member')->save(['pwd'=>md5(md5($param['newPwd']))],['uid'=> $uid])){
               $this->_error('修改密码失败',200);
           }
           return ['msg'=>'修改密码成功'];
       }
    }

    public function resetTouxiang(){
        $po = $this->request->get('picurl');
        $uid = $this->_uid;

        $mem = new Member();
        $res = $mem->changePicurl($uid,$po);
        if($res){
            return ['msg'=>"修改成功"];
        }else{
            $this->_error("修改错误",500);
        }


    }

    public function resetSex(){
        $po = $this->request->get('sex');
        $uid = $this->_uid;

        $mem = new Member();
        $res = $mem->changeSex($uid,$po);
        if($res){
            return ['msg'=>"修改成功"];
        }else{
            $this->_error("修改错误",500);
        }


    }



    public function resetName(){
        $po = $this->request->get('newname');
        $uid = $this->_uid;

        $mem = new Member();
        $res = $mem->changeName($uid,$po);
        if($res){
            return ['msg'=>"修改成功"];
        }else{
            $this->_error("修改错误",500);
        }


    }

    
    /*
     * 企业名称修改
     */
    public function companyNameModify(){        
        if(request()->isPost()){
            $post=  request()->param();//print_r($post);exit;
            $data['name']=$post['name'];
            $util=new Util();
            $business=$util->getUserInfoB()['business'];
            if(!isset($business['business_id'])){
                $this->_error('公司不存在', 500);
            }
            //启动事务
            Db::startTrans();
            try{             
                model('Business')->where(['business_id'=>$business['business_id']])->update($data);
                Db::commit();
                return ['msg'=> '修改成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('修改失败', 500);                  
            }
            
        }  
    }
    
    /*
     * 联系人手机号修改
     */
    public function mobileModify(){        
        if(request()->isPost()){
            $post=  request()->post();
            $data['phone']=$post['mobile'];
            if(model('Member')->where(['uid'=>$this->_uid])->update($data)===false){
                $this->_error('修改失败', 500); 
            }
            return ['msg'=>'修改成功'];            
        }  
    }    
 


    /*
     *消息推送
     */
    public function message(){
        $param = request()->param();
        if(request()->isPost()){            
            $param['createtime']=date("Y-m-d H:i:s");
            $param['detail']=htmlspecialchars_decode($param['detail']);
            if(!model('message')->save($param)){
                $this->_error('添加失败',500);
            }
            return ['msg'=>'添加成功'];
        }else{
            if(isset($param['type'])&&$param['type']=='delete'){
                if(!model('message')->where(['mes_id'=>['in',$param['id']]])->delete()){
                    $this->_error('删除失败',500);
                }
                return ['msg'=>'删除成功'];exit;
            }
            $where=[];
            if(isset($param['theme'])&&!empty($param['theme'])){
                $where['theme']=['like',"%".$param['theme']."%"];
            }
            $list=model('message')->where($where)->paginate($this->request->param('s'))->toArray();
            foreach($list['data'] as $k=>$v){
                $list['data'][$k]['detail']=  htmlspecialchars_decode($v['detail']); 
            }
            return $list;
        }
        
    }
    
    public function getUserInfo($uid=''){

        $mem = new Member();
        $res  = $mem->getUserInfo($uid?$uid:$this->_uid);
        if($res){
            // $this->_error("获取用户信息错误");
            return $res;
        }else{
            $this->_error("获取用户信息错误");
        }
    }

    public function access() {

    }
}