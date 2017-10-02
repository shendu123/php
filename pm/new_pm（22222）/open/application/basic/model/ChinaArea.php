<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class ChinaArea extends Model {

	public function getListByParent($id){
		$res = Db::table('opb_china_area')->where('parent_id', $id)->select();
		if($res){
			return $res;
		}
	}

	public function getListByTid($id){
		$res = Db::table('opb_china_area')->where('tmall_parentid', $id)->select();
		if($res){
			return $res;
		}
	}

	public function getDetail($id){
	    $res = Db::table('opb_china_area')->where('id', $id)->find();
	    if($res){
	        return $res;
	    }
	}
  
	/**
	 * @function 获取地址名称
	 * @author ljx
	 */
	public function getBy($wdata = array()){
	    $whereCond = array();
	    if(isset($wdata['ids']) && !empty($wdata['ids'])){
	        $whereCond['id'] = array(
	            'in',
	            $wdata['ids']
	        );
	    }
	    if(isset($wdata['tmall_areaids']) && !empty($wdata['tmall_areaids'])){
	        $whereCond['tmall_areaid'] = array(
	            'in',
	            $wdata['tmall_areaids']
	        );
	    }
	    if(empty($whereCond)){
	        return null;
	    }
	    
	    return Db::table('opb_china_area')->where($whereCond)->field('id,tmall_areaid,region_name')->select();
	}

}