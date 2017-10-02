<?php
/**
 * @Author AJMstr
 * @date 2017-5-25
 */

namespace app\basic\model;

use think\Model;

class Base extends Model {
    public function __construct() {
        $this->connection = \think\Config::load(APP_PATH.'basic/database.php', '__basicsDatabases__');
        parent::__construct();
    }
}