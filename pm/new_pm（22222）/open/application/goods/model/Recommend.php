<?php
namespace app\goods\model;

use think\Model;
use think\Db;

class Recommend extends model {

	public function getRecommend($pid) {
		if ($pid == 0) {
			return false;
		}

		$now = time();
		$data = Db::name('goods_recommend')->field('rec_stuff_type,rec_stuff_id')->where("rec_pos_id = {$pid} and rec_status = 0 and rec_starttime < $now and rec_endtime > $now")->select();

		return $data;
	}

}