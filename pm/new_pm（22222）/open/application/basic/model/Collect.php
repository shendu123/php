<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class Collect extends Model {


	public function saveData($po,$uid){

        $isCollect = $this->isCollect($po['goodsid'], $uid, $po['from'], 1);
        if($isCollect=="kongde"){
            $da['goodsid'] = $this->issetData($po['goodsid'],0);
            $da['name']    = $this->issetData($po['name'],0);
            $da['price']   = $this->issetData($po['price'],0);
            $da['picurl']  = $this->issetData($po['picurl'],0);
            $da['from']  = $this->issetData($po['from'],'PM');
            $da['uid']  = $this->issetData($uid,0);

            $res = Db::table('opb_member_collect')->insertGetId($da);
        }else{
            if($isCollect['isdelete']==2){
                $res = Db::table('opb_member_collect')->where("goodsid = '" . $po['goodsid'] . "'")->setField("isdelete", 3);
            }else{
                $res = Db::table('opb_member_collect')->where("goodsid = '" . $po['goodsid'] . "'")->setField("isdelete", 2);
            }
        }

		

        if($res){
            return  $isCollect == "kongde" ? $res : $isCollect['id'];
        }else{
            return 0;
        }
        
	}

    public function isCollect($goodsid, $uid, $from, $return_id = 0){
        $from = addslashes($from);
        $res = Db::query("SELECT  id,isdelete FROM `opb_member_collect` WHERE  goodsid = '{$goodsid}' and uid = '{$uid}' and `from` = '{$from}' ");

        if($res){
            if(empty($res[0]['isdelete'])){
                return "kongde";
            }else{
                if ($return_id) {
                    return ['isdelete'=>$res[0]['isdelete'], 'id'=>$res[0]['id']];
                }
                else {
                    return $res[0]['isdelete'];
                }
            }
        }else{
            return "kongde";
        }
    }


    public function issetData(&$a, $b)
    {
        return isset($a) ? $a : $b;
    }

    
	public function deleteById($id){
		$res = Db::table('opb_member_collect')->where("id = '" . $id . "'")->setField("isdelete", 3);
        return $res;

	}

    public function getCollectById($id) {
        return Db::table('opb_member_collect')->where('id = '.$id.' AND isdelete = 2 ')->find();
    }


	public function getCollectByUid($uid,$page){
            $list = Db::table('opb_member_collect')->where('uid IN ('.$uid.') AND isdelete = 2 ')->limit(($page['page']-1)*$page['pageSize'],$page['pageSize'])->select();
            $count= Db::table('opb_member_collect')->where('uid IN ('.$uid.') AND isdelete = 2 ')->count();
            $pageCount=ceil($count/$page['pageSize']);
            if($list){
                $return['type']='success';
                $return['tip']='获取成功';
                $return['page']=['page_count'=>$pageCount,'total'=>$count];
                $return['data']=$list;         
            }else{
                $return['type']='error';
                $return['tip']='获取失败';
            }
            echo json_encode($return,JSON_UNESCAPED_UNICODE);exit;
	}

	public function getCollectTotalByUid($uid){
		$res = Db::query("SELECT  COUNT(`id`) as tt FROM `opb_member_collect` WHERE isdelete = 2  AND uid IN ({$uid}) ");

        if($res){
            if(empty($res[0]['tt'])){
                return 0;
            }else{
                return $res[0]['tt'];
            }
        }else{
            return 0;
        }
	}

  

}