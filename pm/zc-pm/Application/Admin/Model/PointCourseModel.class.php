<?php
namespace Admin\Model;

use Think\Model;

class PointCourseModel extends Model {

    public function lists($firstRow = 0, $listRows = 20, $where,$od) {
        $list = $this->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
        }
        return $list;
    }
}

?>
