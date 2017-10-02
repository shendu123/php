<?php

namespace app\goods\model;

use think\Db;

class SpecGoods
{
    public function manage($goodsid, $data){

        if ((int)$goodsid == 0 || empty($data)) {
            return false;
        }

        Db::name('spec_goods')->where('goods_id',$goodsid)->delete();

        return Db::name('spec_goods')->insertAll($data);
    }

    public function get_inventory($goods_id, $key) {
    	if ((int)$goods_id == 0 || empty($key)) {
    		return false;
    	}

    	return Db::name('spec_goods')->field('inventory')->where("goods_id = {$goods_id} and `key` = '{$key}'")->find();
    }

	public function inventory($goods_id, $key, $num) {
		if ($goods_id == 0 || empty($key) || $num == 0) {
			return false;
		}


		$commit = 1;
		Db::startTrans();
		try{

			Db::execute("update opg_spec_goods set consume=consume+{$num}, inventory=inventory-{$num} where goods_id = {$goods_id} and `key` = '{$key}'");

			Db::commit();

		} catch (\Exception $e) {
			Db::rollback();
			$commit = 0;
		}

		return $commit ? true : false;


	}
	
	public function goodsSpecList($goods_id){
		$list = Db::name('spec_goods')->where(['goods_id'=>$goods_id])->field('goods_id,key,key_name,price,total,inventory')->select();
		if(!$list){
			return false;
		}
		$list['spec_type'] = Db::name('goods')->where(['id'=>$goods_id])->value('spec_type');
		return $list;
	}

	public function getAllByGoodsid($goods_id) {
		if ($goods_id == 0) {
			return false;
		}

		return Db::name('spec_goods')->where("goods_id = {$goods_id}")->field('goods_id,key,key_name,price,total,inventory')->select();
	}

}
