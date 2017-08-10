<?php
namespace Home\Model;

use Think\Model;

class CrowdModel extends Model {
    public function detail($crowd_id) {
        $detail = S('crowd_detail_'.$crowd_id);
        if (empty($detail)) {
            $detail = $this->where(array('crowd_id' => $crowd_id))->field('name,banner_img,starttime,endtime,target_money,description,support_count,support_money')->find();

            $detail['percent'] = $detail['target_money'] > 0 ? round(100 * $detail['support_money'] / $detail['target_money']) :100;
            // 判断状态
            if($detail['starttime'] > time()) {// -----未开始
                $detail['status'] = 'future';
            } else if($detail['endtime'] > time() && $detail['starttime'] <= time()){ // 进行中
                $detail['status']='biding';
            } else if($sinfo['endtime'] <= time()){// 结束
                $detail['status']='bidend';
            }

            S('crowd_detail_'.$crowd_id,$detail,['expire'=>600]);

        }

        return $detail;
    }
}