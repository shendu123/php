<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

class MemberRole extends Base {

    public function getRoleBy($uid) {
        return $this->where('uid', $uid)->column('role_id');
    }
    
    public function getRoleByUid($uid) {
        return $this->where('uid', $uid)->value('role_id');
    }
}