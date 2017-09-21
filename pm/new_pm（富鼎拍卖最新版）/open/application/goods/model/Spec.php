<?php

namespace app\goods\model;

use think\Db;

class Spec
{
    public function list_data($condition, $page, $page_size) {
		$where = [];
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

    /**
     * 获取商品规格信息
     */
    public function spec_good($good_id)
    {
        $rs = $si = $sg = [];
        $sg = Db::name('spec_goods')->where("goods_id = {$good_id}")->select();
        if ($sg) {
            $spec_ids = [];
            foreach ($sg as $key => $value) {
                $keys = explode('_', $value['key']);
                $spec_ids += $keys;
            }
            $spec_ids = array_unique($spec_ids);
            $spec_ids_str = join(',', $spec_ids);

            $spec = Db::name('spec')->where("id in ({$spec_ids_str})")->order('id desc')->select();
            $spec_item = Db::name('spec_item')->where("spec_id in ({$spec_ids_str})")->order('id desc')->select();
            foreach ($spec as $k => $val) {
                $si[$val['id']]['spec'] = $val;
            }

            foreach ($spec_item as $key => $value) {
                $si[$value['spec_id']]['item'][] = $value;
            }

            unset($spec,$spec_item,$spec_ids,$spec_ids_str);
        }

        return ['spec_good'=>$sg, 'spec_item'=> $si];

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
