<?php
namespace app\bi\model;

use \think\Config;

class Base {
    public function __construct() {
        Config::load(APP_PATH.'bi/extra/couchbase.php', 'biCouchbases', 'bi');
    }
}