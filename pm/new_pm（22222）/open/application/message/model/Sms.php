<?php

/**
 * @class 短信发送记录表模型
 * @author ljx
 */
namespace app\message\model;

use think\Model;
use think\Db;

/**
 * @class 短信模型
 * @author ljx
 * @TODO 改为单例
 */
class Sms extends Model
{

    protected $table = 'opm_sms';

    public $_tableFields = array(
        'sms_id' => 'int', // 短信发送记录表
        'sms_channel' => 'int', // 短信渠道: 0阿里
        'sms_type' => 'int', // 短信类型: 0系统 1消费 2验证码
        'sms_receive_id' => 'int', // 接收者id
        'sms_mobile' => 'varchar', // 接收时的手机号码
        'sms_status' => 'int', // 发送状态: 0成功 1发送失败 10已验证
        'sms_title' => 'varchar', // 短信标题
        'sms_content' => 'varchar', // 短信内容
        'sms_failed_reason' => 'varchar', // 发送失败原因
        'sms_outtime' => 'int', // 失效时间
        'sms_intime' => 'int' /*短信发送时间**/
	);

    /**
     * @function 新增
     *
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['sms_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->sms_id;
        } else {
            return false;
        }
    }
    
    /**
     * @function 编辑
     *
     * @author ljx
     */
    public function edit($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $wdata = array(
            'sms_id' => $fields['sms_id']
        );
        
        if ($this->save($fields, $wdata)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 列表
     * @author ljx
     *        
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();

        $list = Db::table('opm_sms')->alias('sms')
            ->where($whereCond)
            ->field('sms.*')
            ->order('sms.sms_id desc')
            ->select();
        
        $count = Db::table('opm_sms')->alias('sms')
            ->where($whereCond)
            ->count();
        
        if ($exchange === true) {
            $list = $this->parseListData($list);
        }
        
        $result = array(
            'count' => $count,
            'data' => $list
        );
        
        return $result;
    }

    /**
     * @function 列表数据解析
     * @author ljx
     *        
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        foreach ($data as $key => $val) {
            isset($data[$key]['sms_intime']) ? $data[$key]['sms_intime_tag'] = fd_checktime($data[$key]['sms_intime']) : '';
            isset($data[$key]['sms_outtime']) ? $data[$key]['sms_outtime_tag'] = fd_checktime($data[$key]['sms_outtime']) : '';
        }
        
        return $data;
    }

    /**
     * @function 删除
     * @author ljx
     *        
     * @param integer $wdata['id'] id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['sms_id'] = array(
            'in',
            $wdata['ids']
        );
        return Db::table('opm_sms')->where($whereCond)->delete();
    }
    
    /**
     * @function 获取详情
     * @author ljx
     */
    public function getRow($wdata = array(), $operateData = array()){
        return Db::table('opm_sms')->where('sms_id',$wdata['id'])->find();
    }
    
    /**
     * @function 获取最新记录
     * @author ljx
     */
    public function getLatest($wdata = array(), $operateData = array()){
        $whereCond = array(
            'sms_mobile' => $wdata['sms_mobile']
        );
        $list = Db::table('opm_sms')->where($whereCond)->field("*")->order('sms_id DESC')->limit(1)->select();
        
        if(!empty($list)){
            return $list[0];
        }else{
            return null;
        }
    }
}


















