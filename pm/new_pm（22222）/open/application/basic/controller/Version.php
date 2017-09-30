<?php

namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\Version as VersionModel;

class Version extends NoAuth {
	//获取版本
	public function index()
	{
		return model('Version')->where('id', 1)->find();
	}
}