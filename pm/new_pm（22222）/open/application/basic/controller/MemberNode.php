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
		if(substr_count($urlArray[1],'/') > 3){ //如果'/'出现3次以上说明后面有参数,就要进行过滤
			$urlArray[1] = rtrim($urlArray[1], strrchr($urlArray[1] , '/'));
		}		
        $urlValue = trim($urlArray[1], '/');
        if(strpos($urlValue, 'auction/Admin') !== false){
            $urlValue = 'auction/Admin/index';
        }

        $roleIds = model('MemberRole')->getRoleBy($this->_uid);
    	$nodeList = model('Node')->getChildNode($roleIds, $urlValue, $this->_sysid);
        $allList = model('Node')->getChildAllNode($urlValue, $this->_sysid);
        return ['user'=>$nodeList, 'all'=>$allList];
    }
}
