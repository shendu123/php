<?php
namespace Home\Model;

use Think\Model;

class CrowdItemsModel extends Model {
    public function items($crowd_id, $count = 30) {
        $items = S('crowd_items_'.$crowd_id);
        if (empty($items)) {
            // $items =  $this->join('LEFT JOIN __GOODS__ ON __CROWD_ITEMS__.gid=__GOODS__.id')
            $items =  $this->join('LEFT JOIN __GOODS__ ON __CROWD_ITEMS__.gid=__GOODS__.id')
                ->limit($count)
                ->where(array('crowd_id' => $crowd_id))
                ->field('on_crowd_items.*, on_goods.title, on_goods.description, on_goods.pictures')
                ->select();
            foreach($items  as &$item) {
                $item['pictures'] = explode('|', $item['pictures']);
            }
            S('crowd_items_'.$crowd_id,$items,['expire'=>600]);
        }

        return $items;
    }

    public function details($ciid) {
        $detail = $this->join('LEFT JOIN __GOODS__ ON __CROWD_ITEMS__.gid=__GOODS__.id')
            ->where(array('ciid' => $ciid))
            ->field('on_crowd_items.*, on_goods.title, on_goods.pictures')
            ->find();
        return $detail;
    }
}