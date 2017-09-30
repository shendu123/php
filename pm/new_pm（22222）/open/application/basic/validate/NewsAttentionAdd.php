<?php

namespace app\basic\validate;

use think\Validate;

class NewsAttentionAdd extends Validate {
	protected $rule = [
		"newsid|文章id" => "require|integer",
		"title|文章标题" => "require",
		"author|文章作者" => "require",
	];


}