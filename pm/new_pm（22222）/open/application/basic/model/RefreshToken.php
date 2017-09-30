<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

class RefreshToken extends Base {

    public function isExists($appid, $uid) {
        return $this->where(['app_id' => $appid, 'uid' => $uid])->count() > 0;
    }
}