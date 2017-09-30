<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;


class Business extends Model
{

    protected $table = 'opb_business';

    public $_tableFields = array(
        'business_id' => 'int', // 加盟商ID
        'name' => 'int', // 加盟商名称
        'pid' => 'int', // 上级商户id 0表示顶级商户,用于平台/合伙人; -1表示没有父级商户,用于企业用户
        'sysid' => 'int', // system.sysid
        'business_intime' => 'int', // 创建时间
        'business_uptime' => 'int' /* 修改时间**/
    );

    public function getListByInid($id)
    {
        $res = Db::table('opb_business')->where('business_id IN (' . $id . ')')->select();
        return $res;
    }
    /*
     * 获取商信息
     */
    public function getBusinessInfoById($where){
        $info=$this->alias('b')->join('opb_system','b.sysid=opb_system.sysid','left')->where($where)->field('b.name,b.sysid,opb_system.title')->find();
        return $info;
    }

    /**
     * @function 列表
     * @author ljx
     *
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();
        
        if(isset($wdata['sysids']) && !empty($wdata['sysids'])){
            $whereCond['sysid'] = array(
                'IN',
                $wdata['sysids']
            );
        }
    
        $list = Db::table('opb_business')
        ->where($whereCond)
        ->field('*')
        ->select();
    
        $result = array(
            'data' => $list
        );
    
        return $result;
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array()){
        $whereCond = array();
        
        if(isset($wdata['business_ids']) && !empty($wdata['business_ids'])){
            $whereCond['business_id'] = array(
                'IN',
                $wdata['business_ids']
            );
        }

        $detailList = Db::table('opb_business')
        ->where($whereCond)
        ->field('*')
        ->select();
        
        $result = array(
            'data' => $detailList
        );
        
        return $result;
    }
    
    /*
     * 添加运营商时选择商户列表    $sysid 2:合伙人；3：一级运营商，4：二级运营商
     */
    public function getOptionBList($id){
        $where['sysid']=['in',$id];
        $res = Db::table('opb_business')->where($where)->select();
        foreach($res as $k => $v){
            $res[$k]['code']=Db::table('opb_business_service')->where(['business_id'=>$v['business_id']])->value('service_code');
        }
        return $res;
    }
    
    /*
     * 商户列表
     */
    public function getBusinessList($page=[],$where=''){
        $blist=Db::table('opb_business')->where($where)->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();//print_r($blist);exit;
        $count=Db::table('opb_business')->where($where)->count();
        $list=[];
        foreach($blist as $k => $v){                        
            $blist[$k]=array_merge($v, $this->monthData($v['business_id']));
            $blist[$k]['userCount']=Db::table('opb_business')->where(['pid'=>$v['business_id']])->count();
            $bsInfo= model('BusinessService')->getBSInfoById(['Business_id'=>$v['business_id']]);
            $blist[$k]['service_inrate']=$bsInfo['service_inrate'];
            $blist[$k]['service_code']=$bsInfo['service_code'];
            $bInfo=$this->getBusinessInfoById(['Business_id'=>$v['pid']]);
            $blist[$k]['parent_name']=$bInfo['name'];
            $blist[$k]['title']=$bInfo['title'];
            $blist[$k]['business_intime']=date("Y-m-d H:i",$v['business_intime']);
        }
        $list=[
            'data'=>$blist,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count,
        ];
        return $list;        
    }
    /*
     * 商户详情
     */
    public function getBusinessView($where){        
         $info=$this->alias('b')
                 ->join('opb_business_service','b.business_id=opb_business_service.business_id','left')
                 ->where($where)
                 ->field('b.name,b.sysid,opb_business_service.*')
                 ->find();
         $ids=$this->idTree(['pid'=>$info['business_id']],$recursion=false);//print_r($ids);exit;
         if($ids){
            $data=$this->queryOrderByMonth('',implode(',',$ids));
            $info['total_money']=$data['total_money'];
            $info['total_commision']=$data['total_commision'];
         }         
         return $info;
    }
    /*
     * 获取下属运营商列表
     */
    public function getSonBusinessList($page=[],$where){        
         $blist=$this->alias('b')
                 ->join('opb_business_service','b.business_id=opb_business_service.business_id','left')
                 ->where($where)
                 ->field('b.name,b.sysid,opb_business_service.*')
                 ->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])
                 ->select();
         foreach($blist as $k=>$v){
            $data=$this->queryOrderByMonth('',$v['business_id']);
            $blist[$k]['total_money']=$data['total_money'];
            $blist[$k]['total_commision']=$data['total_commision'];
         }
         $count=$this->where($where)->count();
         $list=[
            'data'=>$blist,
            'current_page' => $page['page'],
            'per_page' => $page['pageSize'],
            'total' => $count,
        ];
        return $list; 
    }
    
    /*
     * 数据统计[申购订单]
     */
    public function getStatistic($where='',$secondSysid=''){
        $blist=Db::table('opb_business')->where($where)->field('business_id')->select();
        $list['userCount']='';
        $bid=[];
        foreach($blist as $k => $v){
            $bid[]=$v['business_id'];
        }
        if($bid){
            $list['sonCount']=count($bid);
            $list['userCount']=Db::table('opb_business')->where(['pid'=>['in',$bid],'sysid'=>5])->count();//下属用户数
            $list=  array_merge($list,$this->monthData($bid));
            if($secondSysid==5){
                $bid[]=$where['pid'];//如果一级运营商登录，统计下属用户信息，则显示一级运营产与二级运营商一起的用户总和;
            }            
            $where2['pid']=['in',$bid];
            $where2['sysid']=$secondSysid;//二级运营商
            $list['second']=$this->getStatistic($where2);
        }
        return $list;        
    }
    /*
     * 总后台运营数据
     */
    public function adminStatistic($where){ 
        $ids=$this->idTree($where);//print_r($ids);exit;
        $ids[]=$where['pid'];
        $list['partnerCount']=$this->getStatisticCount(['business_id'=>['in',$ids],'sysid'=>2]);
        $list['yijiCount']=$this->getStatisticCount(['business_id'=>['in',$ids],'sysid'=>3]);
        $list['erjiCount']=$this->getStatisticCount(['business_id'=>['in',$ids],'sysid'=>4]);
        $list['userCount']=$this->getStatisticCount(['business_id'=>['in',$ids],'sysid'=>5])+$list['partnerCount']+$list['yijiCount']+$list['erjiCount'];
        $list=  array_merge($list,$this->monthData($ids));
        return $list;
        
    }
    /*
     * 统计运营商总数
     */
    public function getStatisticCount($where){
        $count=Db::table('opb_business')->where($where)->count();
        return $count;
    }

    /*
     * 递归查找id
     * $recursion：true递归，false不递归
     */
    public function idTree($where,$recursion=true){
        $blist=Db::table('opb_business')->where($where)->field('business_id,pid')->select();
        static $ids=[];
        foreach($blist as $k => $v){
            if($v['pid']==$where['pid']){
                $ids[]=$v['business_id'];
                $where2['pid']=$v['business_id'];
                if(isset($where['sysid'])){
                    $where2['sysid']=$where['sysid'];
                }
                if($recursion){
                    $this->idTree($where2);
                }                
            }
        } 
        return $ids;
    }
    /*
     * 月份数据
     */
    public function monthData($ids){
        $date1=date("Y-m",  strtotime("-1 month"));
        $date2=date("Y-m",  strtotime("-2 month"));
        $date3=date("Y-m",  strtotime("-3 month"));
        $currentDate=date("Y-m",time());
        if(is_array($ids)){
            $ids=implode(',',$ids);
        }
        $list['time1']=$this->queryOrderByMonth($date1, $ids);
        $list['time2']=$this->queryOrderByMonth($date2, $ids);
        $list['time3']=$this->queryOrderByMonth($date3, $ids);
        $list['all']=$this->queryOrderByMonth('', $ids);
        return $list;
    }
    /*
     * 根据月份查询订单数与成交额
     */
    public function queryOrderByMonth($date='',$id){
        $where="1=1";
        $where.=" and ispay=1";
        if($date){
            $where.=" and date_format(createtime,'%Y-%m')='".$date."'";            
        }
        $where.=" and businessid in (".$id.")";
        $sql="SELECT date_format(createtime,'%Y-%m') AS YM,price,freight,businessid,broker FROM op_pay.opa_order_crowd WHERE ".$where;//echo $sql;exit;
        $orderList=Db::query($sql);//print_r($orderList);exit;
        $list['YM']=$date;
        $list['total_money']=0;
        $list['total_commision']=0;
        $list['orderCount']=0;        
        foreach($orderList as $k => $v){
            $service_inrate=model('BusinessService')->where(['business_id'=>$v['businessid']])->value('service_inrate');
            $list['total_money']+=$v['price']+$v['freight']+$v['broker'];
            $list['total_commision']+=(($v['price']+$v['freight']+$v['broker'])*$service_inrate/100);
            $list['orderCount']=count($orderList);
        }
        return $list;
    }
}

















































