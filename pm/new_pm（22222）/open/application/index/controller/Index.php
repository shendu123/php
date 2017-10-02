<?php
namespace app\index\controller;

use app\common\controller\Base;

use think\Loader;

class Index extends Base {
    public function index() {
        $this->response(['Hello World'])->send();
    }

    public function test() {
        $this->response(['accesstoken' => \Token::generate()])->send();
    }
}