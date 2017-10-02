<?php
namespace app\auction\model;

use think\Db;

class Manage {

	public function add($data) {
		if (empty($data)) {
			return false;
		}

		$auction_id = Db::name('auction')->insertGetId($data);

		return $auction_id > 0 ? $auction_id : false;

	}
}
