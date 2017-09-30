<?php
namespace app\basic\controller;

use app\common\controller\NoAuth;
use think\Request;

class Config extends NoAuth
{

    public function __construct()
    {
        parent::__construct();
        if (! empty($this->_uid)) {
            $this->_user = $this->getCallerInfo();
        }
    }

    /**
     * @function 列表
     * @author ljx
     */
    public function index()
    {
        $sign = valueRequest('sign', '', 'string');
        if (file_exists(__DIR__ . "/../extra/auto_gen_web_config.php")) {
            $config = include(__DIR__ . "/../extra/auto_gen_web_config.php");
        } else {
            // 生成的配置文件不存在
            $wdata = array();
            
            if (! empty($sign)) {
                $wdata['config_group'] = $sign;
            }
            $model = new \app\basic\model\Config();
            $config = $model->getList($wdata);
        }
        
        if(!empty($sign)){
            return $config[$sign];
        }else{
            return $config;
        }
    }

    /**
     * @function 购物流程，分销设置
     * @author zsq
     */     
    public function data()
    {
        $model = new \app\basic\model\Config();   
        $group = valueRequest('group', '', 'string');
        $result = $model->getGroup($group);
        return $result;
    }

    /**
     * @function 添加单条配置
     * @author ljx
     * @todo 数据变动后要写到配置文件
     */
    public function add()
    {
        if (request()->isPost()) {
            $catModel = new \app\goods\model\Brand();
            $requestData = Request::instance()->post();
            
            $model = new \app\basic\model\Config();
            $result = $model->add($requestData, $this->_user);
            if ($result === false) {
                $this->_error('操作失败', 500);
            } else {
                $this->updateConfigFile();
                return array(
                    'msg' => '操作成功',
                    'data' => true
                );
            }
        }
    }

    /**
     * @function 购物流程设置
     * @author ljx
     */
    public function shopping()
    {
        if (request()->isPost()) {
            $catModel = new \app\goods\model\Brand();
            $requestData = Request::instance()->post();
            $modify = input('modify');
            $model = new \app\basic\model\Config();

            if($modify==1){
                $result = $model->shopping($requestData, $this->_user, $modify);
            }else{
                $result = $model->shopping($requestData, $this->_user); 
            }
            if ($result === false) {
                $this->_error('操作失败', 500);
            } else {
                $this->updateConfigFile();
                return array(
                    'msg' => '操作成功',
                    'data' => true
                );
            }
        }
    }

    /**
     * @function 分销设置
     * @author ljx
     */
    public function distribution()
    {
        if (request()->isPost()) {
            $catModel = new \app\goods\model\Brand();
            $requestData = Request::instance()->post();
            $modify = input('modify');
            $model = new \app\basic\model\Config();
                
            if($modify==1){
                $result = $model->distribution($requestData, $this->_user, $modify);
            }else{
                $result = $model->distribution($requestData, $this->_user);     
            }   
            
            if ($result === false) {
                $this->_error('操作失败', 500);
            } else {
                $this->updateConfigFile();
                return array(
                    'msg' => '操作成功',
                    'data' => true
                );
            }
        }
    }

    /**
     * @function 更新配置文件
     * @author ljx
     * @todo extra 以及之下的权限为777
     */
    private function updateConfigFile()
    {
        $model = new \app\basic\model\Config();
        $config = $model->getList();
        
        $configs_string = "<?php 
        ";
        $configs_string .= "return " . var_export($config, true) . ';';
        
        $filePointer = fopen(__DIR__ . "/../extra/auto_gen_web_config.php", "w") or die("Unable to open file!");
        fwrite($filePointer, $configs_string);
        fclose($filePointer);
    }
}

