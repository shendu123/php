<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;

class App extends Model {

    public function isExists($appid) {
        return $this->where('app_id', '=', $appid)->count() > 0;
    }
}