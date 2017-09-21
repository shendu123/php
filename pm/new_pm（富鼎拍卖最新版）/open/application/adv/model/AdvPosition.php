<?php
namespace app\adv\model;
use think\Model;
class AdvPosition extends Model {
	
	protected $pos_type = [0=>'pc' , 1=>'app' , 2=>'微信'];
	public function ApList($pageSize,$where){
        $list = $this->where($where)->order('id asc')->paginate($pageSize)->toArray();
        foreach($list['data'] as $k=>$v){
            $list['data'][$k]['createtime']=date('Y-m-d H:i',$v['createtime']);
			$list['data'][$k]['pos_type_tag']=$this->pos_type[$v['pos_type']];
        }
        return $list;
    }
    //检测广告位是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }
    
}

