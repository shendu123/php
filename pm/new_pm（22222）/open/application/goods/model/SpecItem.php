<?php

namespace app\goods\model;

use think\Db;

class SpecItem
{
    public function list_data($spec_id, $business_id, $page, $page_size) {
        $start = ($page-1)*$page_size;

        $count = Db::name('spec_item')->where("spec_id = {$spec_id} and business_id = {$business_id} and isdelete = 0")->count();

        $list = Db::name('spec_item')->where("spec_id = {$spec_id} and business_id = {$business_id} and isdelete = 0")->limit($start, $page_size)->select();

        return ['count'=>$count, 'data'=>$list];
    }

    public function add($data) {
        if (empty($data)) {
            return false;
        }

        $spec_id = Db::name('spec_item')->insertGetId($data);

        return $spec_id > 0 ? $spec_id : false;

    }

    public function edit($id, $business_id, $data) {
        if ($id == 0 || $business_id == 0 || empty($data)) {
            return false;
        }

        return Db::name('spec_item')->where("id = {$id} and business_id = {$business_id}")->update($data);
    }

    public function getAllBySpecid($spec_ids, $business_id) {
        if (empty($spec_ids) || $business_id == 0) {
            return false;
        }

        $spec_id_str = join(',', $spec_ids);

        return Db::name('spec_item')->where("spec_id in ($spec_id_str) and business_id = {$business_id} and isdelete = 0")->select();
    }

}
