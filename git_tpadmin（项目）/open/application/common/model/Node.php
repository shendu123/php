<?php


//------------------------
// 节点模型
//-------------------------

namespace app\common\model;

use think\Model;

class Node extends Model
{
    public function getNodeListTree(){
        $node = $this->where("status=1 AND isdelete=0")->field("id,pid,group_id,name,title,level,type")->select();//print_r($node);exit;
        foreach ($node as $v) {
            $node_tree[] = [
                "id"          => $v['id'],
                "pid"         => $v['pid'],
                'type'        => $v['type'],
                "title"        => $v['title'] ,//. " (" . $v['name'] . ") " . (isset($group[$v['group_id']]) ? '<span style="color:red">[ ' . $group[$v['group_id']]['name'] . ' ]</span>' : ''),
                "value"       => $v['id'] . "_" . $v['level'] . "_" . $v['pid'],
                'hasChildren' => $v['type'] ? true : false,
            ];
        }

        //生成树
        return list_to_tree($node_tree, "id", "pid", "ChildNodes");
    }
    
    
    public function tree($list,$pid=0,$level=0,$html='--'){  
        static $tree = array();  
        foreach($list as $v){  
            if($v['pid'] == $pid){  
                $v['html'] = str_repeat($html,$level);  
                $tree[] = $v;  
                $this->tree($list,$v['id'],$level+1);  
            }  
        }  
        return $tree;  
    }  

}