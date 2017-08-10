<?php
namespace Admin\Model;

use Think\Model;

class OvideoModel extends Model {

    public function lists($firstRow = 0, $listRows = 20, $where,$od) {
        $list = M("ovideo")->limit($firstRow.','.$listRows)->order($od)->where($where)->select();

        return $list;
    }
}
