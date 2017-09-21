<?php
namespace app\message\model;

use think\Model;
use think\Db;

/**
 * @class app推送信息记录表
 * @author ljx
 */
class AppMsg extends Model
{

    protected $table = 'opm_app_msg';

    public $_tableFields = array(
        'msg_id' => 'int', // 消息id
        'msg_type' => 'int', // 消息类型: 0系统 1消费
        'msg_from_id' => 'int', // 消息发送者id: 0系统 msg_type=1时为商户id
        'msg_receive_id' => 'int', // 接收者id
        'msg_status' => 'int', // 消息状态: 0未读 1已读 2删除
        'msg_title' => 'varchar', // 消息标题
        'msg_content' => 'varchar', // 消息内容
        'msg_link' => 'varchar', // 消息链接
        'msg_intime' => 'int' /*发送时间*/
	);

    /**
     * @function 新增
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['msg_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->msg_id;
        } else {
            return false;
        }
    }
    
    /**
     * @function 新增多个
     * @author ljx
     */
    public function addAll($requestData = array(), $operateData = array())
    {
        if ($this->saveAll($requestData)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @function 列表
     * @author ljx
     * @param integer $exchange 是否转换数据
     */
    public function getList($wdata = array(), $exchange = true)
    {
        $whereCond = array();

        $list = Db::table('opm_app_msg')
            ->where($whereCond)
            ->order('msg_intime desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opm_app_msg')
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
     * @param array $data 待解析的数据
     */
    private function parseListData($data = array())
    {
        if (! is_array($data) || empty($data)) {
            return $data;
        }
        
        foreach ($data as $key => $val) {
            isset($data[$key]['msg_intime']) ? $data[$key]['msg_intime_tag'] = fd_checktime($data[$key]['msg_intime']) : '';
        }
        
        return $data;
    }

    /**
     * @function 删除
     * @author ljx
     * @param integer $wdata['id'] id MUST
     * @param array $operateData 操作者相关信息
     */
    public function delete($wdata = array(), $operateData = array())
    {
        $whereCond = array();
        $whereCond['msg_id'] = array(
            'in',
            $wdata['ids']
        );
        return Db::table('opm_app_msg')->where($whereCond)->delete();
    }
}
