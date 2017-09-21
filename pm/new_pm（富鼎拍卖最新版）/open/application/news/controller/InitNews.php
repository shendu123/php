<?php
namespace app\news\controller;

use app\common\controller\NoAuth;


class InitNews extends NoAuth {

    protected $util;

    public function __construct() {
        parent::__construct();
        $this->initialize();
    }

    public function initialize() {
        header("Content-Type: text/html; charset=UTF-8");
        ini_set('date.timezone','Asia/Shanghai');

        if ($this->_uid == 0) {
            $this->_error('没有登入', '403');
        }

    }
}