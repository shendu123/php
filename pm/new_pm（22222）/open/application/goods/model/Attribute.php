<?php
namespace app\goods\model;
use think\Model;
use think\Db;
class Attribute extends Model {
    
    public function attrList($pageSize,$where){      
        $list = $this->alias('attr')
		->join('GoodsCategory','attr.cat_id=GoodsCategory.id','LEFT')
		->where($where)
		->field('attr.*,GoodsCategory.cat_name')
		->order('attr.id asc')
		->paginate($pageSize)
		->toArray();
        foreach($list['data'] as $k=>$v){
            $list['data'][$k]['attr_intime']=date('Y-m-d H:i',$v['attr_intime']);
            $list['data'][$k]['attr_uptime']=date('Y-m-d H:i',$v['attr_uptime']);
        }
        return $list;
    }
    
    
}

