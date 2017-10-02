<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

class AccessToken extends Base {

    public function isExists($appid, $uid) {
        return $this->where(['app_id' => $appid, 'uid' => $uid])->count() > 0;
    }

    public function getBy($accessToken) {
        return $this->where('access_token', $accessToken)->column('app_id', 'uid');
    }
}