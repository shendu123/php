<?php
namespace app\news\model;
use think\Model;
class NewsCategory extends Model {
    public function catList($pageSize,$where){
        $list = $this->where($where)->order('id asc')->paginate($pageSize)->toArray();
        foreach($list['data'] as $k=>$v){
            $list['data'][$k]['create_time']=$v['create_time'] ? date('Y-m-d H:i',$v['create_time']) : '--';
            $list['data'][$k]['update_time']=$v['update_time'] ? date('Y-m-d H:i',$v['update_time']) : '--';
        }
        $list['data']=$this->catTree($list['data'], $pid=0);
        return $list;
    }
    /*
     * 分类树
     */
    public function catTree($list, $pid = 0, $level = 0, $html = '|--')
    {
        static $tree = array();
        foreach ($list as $v) {
            if ($v['pid'] == $pid) {
                $v['html'] = str_repeat($html, $level);
                $tree[] = $v;
                $this->catTree($list, $v['id'], $level + 1);
            }
        }
        return $tree;
    }
    //检测分类是否存在
    public function isHas($id = 0)
    {
        $result = $this->where(['id' => $id])->find();
        if(empty($result)){
            return false;
        }
        return true;
    }
    
}

