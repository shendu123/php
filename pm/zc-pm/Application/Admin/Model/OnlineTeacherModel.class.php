<?php
namespace Admin\Model;

use Think\Model;

class OnlineTeacherModel extends Model {

    public function lists($firstRow = 0, $listRows = 20, $where,$od) {
        $list = M("online_teacher")->limit($firstRow.','.$listRows)->order($od)->where($where)->select();

        return $list;
    }
}
