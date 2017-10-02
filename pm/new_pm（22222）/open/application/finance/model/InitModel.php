<?php
namespace app\finance\model;

use think\Model;
use app\finance\library\Util;

class InitModel extends Model {

    public $util;

    public function initialize() {
        header("Content-Type: text/html; charset=UTF-8");
        ini_set('date.timezone','Asia/Shanghai');


        $this->util = new Util();
    }
    


}