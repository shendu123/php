<?php
/**
 * @Author AJMstr
 * @date 2017-5-5
 */
namespace app\basic\controller;

use app\common\controller\Base;

class System extends Base {
    
    /*
     * 站点配置
     */
    public function webConfig(){
        return $this->saveSysConfig('webInfo');
    }
	
	/*
	 * 购物流程设置
	 */
	public function shoppingConfig(){
		return $this->saveSysConfig('shopping');
	} 
			
	/*
	 * 分销设置
	 */
	public function distributionConfig(){
		return $this->saveSysConfig('distribution');
	} 
    /*
     * 系统配置保存
     */
    private function saveSysConfig($name){
        $filename=APP_PATH.'/sysConfig.php';
        $config=  file_exists($filename)?require $filename:[];
        if($post=request()->post()){
            $config=  array_merge($config,[$name=>$post]);
            if(!file_put_contents($filename, "<?php\treturn " . var_export($config, true) . ";")){
                $this->_error('保存失败',500); 
            }
            return ['msg'=>'保存成功'];
        }else{
            return isset($config[$name])?$config[$name]:[];
        }
    } 

    public function all() {
        return array_values(model('System')->column('sysid,name,title'));
    }
}