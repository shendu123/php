<?php
namespace app\finance\controller;

use think\Request;
use app\common\controller\NoAuth;

class Common extends NoAuth{
    /**
     * @function 获取站点配置
     * @author ljx
     */
    public function getWebConfig(){
        // case 从couchbase获取
        $config_cb = array();
        
        // case 从base获取
        if(empty($config_cb)){
            $config_base = curl_get_content(config("basic_api_url") . "Config/index", 0, "", $this->request->header('accesstoken'));
            $config_base = object_array($config_base);
        }
        
        if(!empty($config_cb)){
            return $config_cb;
        }else{
            return $config_base;
        }
    }
}