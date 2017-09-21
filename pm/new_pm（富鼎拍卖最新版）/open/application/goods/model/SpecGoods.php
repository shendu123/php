<?php

namespace app\goods\model;

use think\Db;

class SpecGoods
{
    public function manage($goodsid, $data){

        if ((int)$goodsid == 0 || empty($data)) {
            return false;
        }

        Db::name('spec_goods')->where('goods_id',$goodsid)->delete();

        return Db::name('spec_goods')->insertAll($data);
    }

}
