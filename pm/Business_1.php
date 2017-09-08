<?php
namespace app\basic\controller;

use app\common\controller\Base;
use app\basic\model\Business as Bu;
use app\basic\model\BusinessService;
use think\Request;
use think\Db;
class Business extends base
{
    function __construct() {
        parent::__construct();
        $this->_username=$this->_user['user']['user_name'];
        $this->uid=$this->_user['user']['user_id'];
        $this->companyname=isset($this->_user['business']['name'])?$this->_user['business']['name']:'';
        $this->business_id=isset($this->_user['business']['business_id'])?$this->_user['business']['business_id']:'';
    }

    /*
     * 商户列表接口
     */
    function businessList(){
        $bu = new Bu();
        $page['pageSize']= request()->param('s');
        $page['page']=request()->param('p');
        $keyword= request()->param('keyword');
        if($keyword){
            $where['name']=['like',"%".$keyword."%"];
        }
        $ids=model('Business')->idTree(['pid'=>$this->business_id]);
        $where['business_id']=['in',$ids];
        $where['sysid']= request()->param('sysid');
        return $bu->getBusinessList($page, $where);
    }
    /*
     * 商户详情
     */
    function businessView(){
        $bu = new Bu();
        $where['b.business_id']=request()->param('business_id');
        return $bu->getBusinessView($where);
    }
    /*
     * 获取下属运营商列表
     */
    function sonBusinessList(){
        $bu = new Bu();
        $page['pageSize']= request()->param('s');
        $page['page']=request()->param('p');
        $where['pid']=request()->param('business_id');
        return $bu->getSonBusinessList($page,$where);
    }
    
    /*
     * 添加商户时选择上级商户接口
     */
    function getParentBusiness(){
        $bu = new Bu();
        $sysid=request()->param('sysid');
        switch($sysid){
                    case '2':
                        $ids = [1];
                        break;
                    case '3':
                        $ids = [1,2];//一级运营商的上级可以为总部平台、合伙人
                        break;
                    case '4':
                        $ids = [1,3];//二级运营商上级可以为总部平台、一级运营商
                        break;
                    case '5':
                        $ids = [1,2,3,4];
                        break;
                    default :
                        $ids = [1];
                        break;
                }
        return $bu->getOptionBList($ids);
    }
    /*
     * 添加运营商接口
     * level_top 2合伙人，level_1st 3一级运营商,level_2nd 4二级运营商
     */
    function add(){
        if(request()->isPost()){
            $post=  request()->param();                      
            if($post['type']){
                switch($post['type']){
                    case 'level_top':
                        $sysid = 2;
                        $code=str_pad(rand(1,100),3,0,STR_PAD_LEFT);
                        break;
                    case 'level_1st':
                        $sysid = 3;
                        $code=rand(101,999);
                        break;
                    case 'level_2nd':
                        $sysid = 4;
                        $pcode=isset($post['code'])&&!empty($post['code'])?$post['code']:'100';
                        $code=$pcode.str_pad(rand(01,99),2,0,STR_PAD_LEFT);
                        break;
                    default :
                        $sysid = 3;
                        $code=rand(101,999);
                        break;
                }
            }
            $this->checkCodeIsExist($code);
            //member表数据
            $mData['pwd']=md5(md5($post['pwd']));
            $mData['account']=$code;
            $mData['mobile']=$post['mobile'];
            //member_rule表数据
            $mruleData['rule_oprid']=$this->uid;
            $mruleData['rule_type']=95;//0普通会员 10企业会员 90营业人员 95商户总管理
            $mruleData['rule_intime']=time();
            //business_service表数据
            $bsData['service_inrate']=$post['service_inrate'];  
            $bsData['service_code']=$code;
            //business表数据
            $bData['sysid']=$sysid; 
            $bData['pid']=$post['pid']; 
            $bData['name']=$post['name'];  
            $bData['business_intime']=time();
            //print_r($post);exit;
            //启动事务
            Db::startTrans();
            try{                
                $bsData['business_id']=$mData['business_id']=$mruleData['business_id']= Db::name('Business')->insertGetId($bData);
                model('BusinessService')->save($bsData);
                $mruleData['member_id']=Db::name('Member')->insertGetId($mData);
                model('MemberRule')->save($mruleData);
                Db::commit();
                return ['msg'=> '添加成功','code'=>$code];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('添加失败', 500);                  
            }
        }
    }
    
    /*
     * 编辑运营商
     * 
     */
    function edit(){
        if(request()->isPost()){
            $post=  request()->param();                               
            $bData['name']=$post['name'];                         
            $bData['pid']=$post['pid']; 
            $bData['business_uptime']=time();
            $bsData['service_inrate']=$post['service_inrate']; 
            $business_id=$post['business_id'];  
            //print_r($post);exit;
            //启动事务
            Db::startTrans();
            try{
                Db::name('Business')->where(['business_id'=>$business_id])->update($bData);
                model('BusinessService')->where(['business_id'=>$business_id])->update($bsData);
                Db::commit();
                return ['msg'=> '编辑成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('编辑失败', 500);                  
            }
        }else{
            $id=  request()->param('id');
            $binfo=Db::name('Business')->where(['business_id'=>$id])->find();
            $bsinfo=Db::name('BusinessService')->where(['business_id'=>$id])->find();
            $info=  array_merge($binfo,$bsinfo);
            return $info;
        }
    }
    /*
     * 管理商户
     */
    function manage(){
        if(request()->isPost()){
            $post=  request()->param();                                         
            $mData['pwd']=md5(md5($post['pwd']));  
            $bData['status']=$post['status'];
            $business_id=$post['business_id'];
            $service_code=model('BusinessService')->where(['business_id'=>$business_id])->value('service_code');
            //print_r($post);exit;
            //启动事务
            Db::startTrans();
            try{
                Db::name('Member')->where(['business_id'=>$business_id,'account'=>$service_code])->update($mData);
                Db::name('Business')->where(['business_id'=>$business_id])->update($bData);
                Db::commit();
                return ['msg'=> '操作成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('操作失败', 500);                  
            }
        }
    }
    /*
     * 删除商户
     */
    function delete(){
        $business_id=  request()->param('business_id');
        $where['business_id']=['in',$business_id];
        try{
            Db::name('Business')->where($where)->delete();
            model('BusinessService')->where($where)->delete();
            Db::commit();
            return ['msg'=> '删除成功'];                 
        }catch(\Exception $e){
            Db::rollback();
            $this->_error('删除失败', 500);                  
        }
    }
    /*
     * 数据统计
     */
    function statistic(){
        //平台或合伙人下的一级运营商数据 $sysid=3
        //平台或一级运营商下二级运营商数据 $sysid=4
        $sysid=  request()->param('sysid',3);
        $secondSysid=  request()->param('secondSysid',4);
        $where['pid']=$business_id=$this->business_id;
        $where['sysid']=$sysid;
        $bu = new Bu();
        $res = $bu->getStatistic($where,$secondSysid);
        $res['username']=$this->_username;
        $res['companyname']=$this->companyname;//print_r($res);exit;
        return $res;                        
    }
    /*
     * 总后台数据统计
     */
    function adminStatistic(){
        $where['pid']=$this->business_id;
        //$where['sysid']=1;
        $bu = new Bu();
        $res = $bu->adminStatistic($where);
        return $res;
    }
    /*
     * 首次登录完善账号信息
     */
    function improveInfo(){
        if(request()->isPost()){
            $post=  request()->param(); //print_r($post);exit;
            $bData['name']=$post['name'];              
            $mData['mobile']=$post['mobile'];
            $mData['pwd']=md5(md5($post['pwd']));                        
            //启动事务
            Db::startTrans();
            try{
                Db::name('Business')->where(['business_id'=>$this->business_id])->update($bData);
                //Db::name('MemberCompany')->where(['uid'=>$this->uid])->update($bData);
                Db::name('Member')->where(['uid'=>$this->uid])->update($mData);
                Db::commit();
                return ['msg'=> '编辑成功'];                 
            }catch(\Exception $e){
                Db::rollback();
                $this->_error('编辑失败', 500);                  
            }
        }
    }
    /*
     * 商户信息接口
     */
    public function businessInfo(){
        $base = new Base();
        return $base->_user;
    }
    
    /*
     * 检验service_code的唯一性
     */
    function checkCodeIsExist($code){
        if(model('BusinessService')->where(['service_code'=>$code])->value('business_id')===true){
            $this->_error('会员编码已存在', 500);   
        }
    }
    
    /*
     * 百分数
     */
    public function percent(){
        for($i=1;$i<50;$i++){
            $percent[]=$i."%";
        }
        return $percent;
    }

    

}










