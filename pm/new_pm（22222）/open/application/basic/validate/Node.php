<?php
/**
 * @desc 节点验证
 * @Author AJMstr
 * @date 2017-5-16
 */

namespace app\basic\validate;

use think\Validate;

class Node extends Validate {
    protected $rule = [
        "sysid|所属系统" => "require|isSystemExists:1",
        "title|节点名称" => "require|length:2,4",
        "pid|所属节点"   => "require|isPidExists:1",
        "is_menu|菜单地址" => "require|urlValue:1"
    ];

    protected function isSystemExists($value, $rule, $data) {
        return model('System')->whereExists('sysid', $value) ? true : "所属系统不存在";
    }

    protected function isPidExists($value, $rule, $data) {
        if($value == 0) {
            return true;
        }

        return model('Node')->where('id','=', $value)->where('sysid', $data['sysid'])->find() ? true : "所属系统不存在";
    }

    protected function urlValue($value, $rule, $data) {
        if($value == 0) {
            if(! preg_match('/\w+\/\w+\/\w+/', $data['url_value'])) {
                return '节点链接不匹配';
            }
        }

        return true;
    }
}