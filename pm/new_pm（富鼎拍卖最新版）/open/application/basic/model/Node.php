<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class Node extends Base {

    public function checkAclBy($roleIDs, $sysid, $urlValue) {
        $acl = $this->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->where('Node.sysid', $sysid)
            ->where('RoleNode.role_id', 'in', $roleIDs)
            ->where('url_value', $urlValue)
            ->where('status', 1)
            ->limit(1)
            ->column('id');//echo $this->getLastSql();exit;

        return isset($acl[0]) ? true : false;
    }

    public function getNodesBy($roleIDs, $sysid,$where=['is_menu'=>1]) {
        return $this->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->where('Node.sysid', 'in', $sysid)
            ->where('RoleNode.role_id', 'in', $roleIDs)
            ->where($where)
            ->where('status', 1)
            ->column('id,pid,sysid,title,icon,url_value');
    }

    public function getNodeById($nodeId, $sysid) {
        return $this->alias('Node')
            ->where('sysid', $sysid)
            ->where('id', $nodeId)
            ->column('id,pid,sysid,title,icon,url_value');
    }

    public function getChildNode($roleIds, $urlValue, $sysid){
        $nodeId = $this->alias('Node')
                        ->where('url_value', $urlValue)            
                        ->value('id');               
        return Db::table('opb_node')->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->where('RoleNode.role_id', 'in', $roleIds)
            ->where('Node.sysid', $sysid)
            ->where('Node.pid', $nodeId)
            ->where('status', 1)
            ->field('id,pid,sysid,title,icon,url_value')
            ->select();
    }

    public function getChildAllNode($urlValue, $sysid){
        $nodeId = $this->alias('Node')
                        ->where('url_value', $urlValue)            
                        ->value('id');
        return Db::table('opb_node')->alias('Node')
            ->where('Node.sysid', $sysid)
            ->where('Node.pid', $nodeId)
            ->where('status', 1)
            ->field('id,pid,sysid,title,icon,url_value')
            ->select();                
    }


    public function getRoueBy($roleIDs, $sysid) {
        $route = $this->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->where('Node.sysid', 'in', $sysid)
            ->where('RoleNode.role_id', 'in', $roleIDs)
            ->where('is_menu', 'in', [1,2])
            ->where('status', 1)
            ->where('url_value', "<>", '')
            ->column('url_value,title,files,query');

        return $route;
    }

    public function getAllBy($sysid) {
        return $this->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->where('Node.sysid', 'in', $sysid)
            ->where('status', 1)
            ->column('id,pid,sysid,title,icon,url_value,is_menu');
    }
    
    public function getNodes($sysid) {
        return $this->alias('Node')
            ->join('RoleNode','Node.id=RoleNode.node_id', 'LEFT')
            ->join('System','Node.sysid=System.sysid', 'LEFT')
            ->where('Node.sysid', 'in', $sysid)
            ->where('status', 1)
            ->column('id,pid,System.sysid,Node.title title,System.title stitle');
    }
}