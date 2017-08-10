<?php
namespace Admin\Model;

use Think\Model;

class CrowdItemsModel extends Model {

    public function lists($firstRow = 0, $listRows = 20, $where,$od) {
        $list = $this->join('LEFT JOIN __GOODS__ ON __CROWD_ITEMS__.gid=__GOODS__.id')
            ->limit($firstRow.','.$listRows)
            ->order($od)
            ->where($where)
            ->field('on_crowd_items.*, on_goods.title, on_goods.pictures')
            ->select();

        foreach($list as &$item) {
            $item['pictures'] = explode('|', $item['pictures'])[0];
        }

        return $list;
    }

    public function details($ciid) {
        return $this->join('LEFT JOIN __GOODS__ ON __CROWD_ITEMS__.gid=__GOODS__.id')
            ->where(array('ciid' => $ciid))
            ->field('on_crowd_items.*, on_goods.title, on_goods.pictures')
            ->find();
    }

    public function getId($gid, $crowd_id) {
        $item = $this->where(array('gid'=> $gid, 'crowd_id' => $crowd_id))->field('ciid')->find();

        return isset($item['ciid']) ? $item['ciid'] : 0;
    }
}

?>
