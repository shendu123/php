<?php
namespace app\message\model;

use think\Model;
use think\Db;

/**
 * @class 单对单聊天记录表模型
 * @author ljx
 */
class SingleChatlog extends Model
{

    protected $table = 'opm_single_chatlog';

    public $_tableFields = array(
        'chat_id' => 'int', // 聊天记录id
        'chat_sender_type' => 'int', // 发送者类型 1user 2business 3system
        'chat_senderid' => 'int', // 发送者人id 对应user_id 若为商户取rule_type = 95 对应的user_id
        'chat_receiver_type' => 'int', // 接收者类型 1user 2business 3system
        'chat_receiverid' => 'int', // 接收者id 对应user_id 若为商户取rule_type = 95 对应的user_id
        'chat_stuff_type' => 'int', // 业务类型 0闲聊 1拍卖 2申购 3自由买卖
        'chat_stuff_id' => 'int', // 业务类型id
        'chat_content' => 'varchar', // 【长度限制】单条聊天内容
        'chat_isread' => 'int', // 是否已读 0未读 1已读
        'chat_intime' => 'int' /*短信发送时间*/
	);

    /**
     * @function 新增
     * @author ljx
     */
    public function add($requestData = array(), $operateData = array())
    {
        $fields = parseRequestData($this->_tableFields, $requestData);
        $fields['chat_intime'] = $_SERVER['REQUEST_TIME'];
        if ($this->save($fields)) {
            return $this->chat_id;
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

        $list = Db::table('opm_single_chatlog')
            ->where($whereCond)
            ->order('chat_intime desc')
            ->limit(($wdata['page'] - 1) * $wdata['pageSize'] . ',' . $wdata['pageSize'])
            ->select();
        
        $count = Db::table('opm_single_chatlog')
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
            isset($data[$key]['chat_intime']) ? $data[$key]['chat_intime_tag'] = fd_checktime($data[$key]['chat_intime']) : '';
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
        $whereCond['chat_id'] = array(
            'in',
            $wdata['ids']
        );
        return Db::table('opm_single_chatlog')->where($whereCond)->delete();
    }
}
