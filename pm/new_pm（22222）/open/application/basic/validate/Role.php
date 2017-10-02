<?php
/**
 * @desc 角色验证
 * @Author AJMstr
 * @date 2017-5-24
 */

namespace app\basic\validate;

use think\Validate;

class Role extends Validate {
    protected $rule = [
        "name|角色名称"  => "require|length:2,20",
        "pid|所属角色"   => "require|isPidExists:1"
    ];
	
	protected $message = [
		'name.length' => '角色名称长度只能为2-20个字符'
	];

    protected function isPidExists($value, $rule, $data) {
        if($value == 0) {
            return true;
        }

        return model('Role')->where('id','=', $value)->find() ? true : "所属角色不存在";
    }
}