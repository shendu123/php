<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;


class BusinessService extends Model
{
    public function getBSInfoById($where){
        return $this->where($where)->find();
    }
}

















































