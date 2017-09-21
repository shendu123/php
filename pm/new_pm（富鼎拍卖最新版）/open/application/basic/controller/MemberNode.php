<?php

namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\MemberRole;
use app\basic\model\Node;
use app\basic\model\RoleNode;

class MemberNode extends NoAuth {			
    /**
     * @function 管理员节点权限值
     * @author zsq
     */
    public function index()
    {
        $url = input('url');
        $urlArray = explode('#', $url);
        $urlValue = trim($urlArray[1], '/');
        $roleIds = model('MemberRole')->getRoleBy($this->_uid);
    	$nodeList = model('Node')->getChildNode($roleIds, $urlValue, $this->_sysid);
        $allList = model('Node')->getChildAllNode($urlValue, $this->_sysid);
        return ['user'=>$nodeList, 'all'=>$allList];
    }
}
