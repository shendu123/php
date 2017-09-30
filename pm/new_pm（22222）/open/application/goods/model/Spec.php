<?php

namespace app\goods\model;

use think\Db;

class Spec
{
    public function list_data($condition, $page, $page_size) {
		$where = [];
        $where['isdelete'] = 0;
		if($condition['wd']){
			$where['name'] = ['like',"%".addslashes($condition['wd'])."%"];
		}
		if($condition['cat_id']){
			$where['cat_id'] = $condition['cat_id'];
		}
        $start = ($page-1)*$page_size;

        $count = Db::name('spec')->where($where)->count();

        $list = Db::name('spec')->where($where)->limit($start, $page_size)->select();

        return ['count'=>$count, 'data'=>$list];
    }

    public function add($data) {
        if (empty($data)) {
            return false;
        }

        $spec_id = Db::name('spec')->insertGetId($data);

        return $spec_id > 0 ? $spec_id : false;

    }

    public function edit($id, $data) {
        if ($id == 0 || empty($data)) {
            return false;
        }

        return Db::name('spec')->where("id = {$id}")->update($data);
    }

    public function getAllByCatid($cat_id) {
        if ($cat_id == 0) {
            return false;
        }

        return Db::name('spec')->where("cat_id = {$cat_id} and isdelete = 0")->select();
    }

    /**
     * 获取商品规格信息
     */
    public function spec_good($good_id)
    {
        // 获取商品信息
        $sg_where['goods_id'] = $good_id;
        $sg = DB::name('spec_goods')->where($sg_where)->select();
        // 获取规格参数
        $si = array();
        if ($sg) {
            $spec_id_list = array();
            foreach ($sg as $key => $value) {
                $keys = explode('_', $value['key']);
                // 去除空项
                $keys = array_filter($keys);
                $spec_id_list = array_merge($spec_id_list,$keys);
            }
            // 去重
            $spec_id_list = array_unique($spec_id_list);
            
            // 规格项
            $spec_where['id'] = array('in',$spec_id_list);
            $spec = DB::name('spec')->where($spec_where)->order('id desc')->select();
            if ($spec){
            	foreach ($spec as $k => $val) {
            		$si[$val['id']]['spec'] = $val;
            	}
            }
            
            // 规则项值
            $sim_where['spec_id'] = array('in',$spec_id_list);
            $spec_item = DB::name('spec_item')->where($sim_where)->order('id desc')->select();
           
			if ($spec_item){
	            foreach ($spec_item as $key => $value) {
	                $si[$value['spec_id']]['item'][] = $value;
	            }
           	}

            unset($spec,$spec_item,$spec_id_list);
        }
		// 返回结果
        $result = array('spec_good'=>$sg, 'spec_item'=> $si);
        return $result;

    }

    /**
     * 获取商品规格重要信息
     */
    public function spec_good_important_data($good_id, $spec_key) {
        if (intval($good_id) == 0) {
            return false;
        }

        $where = '';

        if (empty($spec_key)) {
            $where = "goods_id = {$good_id}";
        }
        else {
            $spec_key_str = join("', '", $spec_key);
            $where = "goods_id = {$good_id} and `key` in ('{$spec_key_str}')";
        }

        return Db::name('spec_goods')->field('goods_id,`key`,inventory,price')->where($where)->select();
    }

    /**
     * 获取商品规格sku信息
     */
    public function sku_data($good_id, $spec_key) {
        if (intval($good_id) == 0) {
            return false;
        }

        $where = '';

        if (empty($spec_key)) {
            $where = "goods_id = {$good_id}";
        }
        else {
            $spec_key_str = join("', '", $spec_key);
            $where = "goods_id = {$good_id} and `key` in ('{$spec_key_str}')";
        }

        return Db::name('spec_goods')->where($where)->select();
    }
}
