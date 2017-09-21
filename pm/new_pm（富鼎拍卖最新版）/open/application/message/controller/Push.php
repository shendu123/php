<?php
namespace app\message\controller;

use think\Request;
use app\common\controller\NoAuth;

/**
 * @class 推送 对接业务
 * @author ljx
 */
class Push extends NoAuth
{
    // 推送机器
    private $pusher;

    public function index()
    {
        require_once __DIR__ . '/../library/PushEvent.php';
        $pushObj = new \PushEvent();
        
        $return = $pushObj->push();
        
        return $return;
    }

    private function getPusher()
    {
        // 多种推送机器
        require_once __DIR__ . '/../library/PushEvent.php';
        $this->pusher = new \PushEvent();
    }

    /**
     * @function 单对单聊天
     * @author ljx
     * @param chat_sender_type chat_senderid chat_receiver_type chat_receiverid
     * @param chat_stuff_type chat_stuff_id chat_content
     */
    public function singleChatSend($params = array())
    {
        // case 参数接收和检验
        $postData = $this->checkSingleChatSend($params);
        
        // case 写入opm_single_chatlog
        $chatLogModel = new \app\message\model\SingleChatlog();
        $requestData_log = $postData;

        $requestData_log['chat_content'] = serialize($requestData_log['chat_content']);
        $result_log = $chatLogModel->add($requestData_log);
        
        // case 消息推送
        $this->getPusher();
        $result_push = $this->pusher->setUser($postData['chat_receiverid'])
            ->setContent($postData)
            ->push();
        if($result_push != 'ok'){
            $this->_error('消息发送失败~', 500);
        }else{
            return array(
                'data' => true
            );
        }
    }

    /**
     * @function 单对单聊天 参数接收和检验
     * @author ljx
     */
    private function checkSingleChatSend($params = array())
    {
        // case chat_sender_type 发送者类型 1user 2business 3system
        $chat_sender_type_param = valueRequest('chat_sender_type', 0);
        $chat_sender_type = isset($params['chat_sender_type']) ? $params['chat_sender_type'] : $chat_sender_type_param;
        $chat_sender_types = array(
            1,
            2,
            3
        );
        if (! in_array($chat_sender_type, $chat_sender_types)) {
            $this->_error('chat_sender_type 发送者类型 参数错误', 400);
        }
        
        // chat_senderid 发送者id
        $chat_senderid_param = valueRequest('chat_senderid', 0);
        $chat_senderid = isset($params['chat_senderid']) ? $params['chat_senderid'] : $chat_senderid_param;
        if ($chat_sender_type != 3 && empty($chat_senderid)) {
            $this->_error('chat_senderid 发送者id 参数错误', 400);
        }
        
        // case chat_receiver_type 接收者类型 1user 2business 3system
        $chat_receiver_type_param = valueRequest('chat_receiver_type', 0);
        $chat_receiver_type = isset($params['chat_receiver_type']) ? $params['chat_receiver_type'] : $chat_receiver_type_param;
        $chat_receiver_types = array(
            1,
            2,
            3
        );
        if (! in_array($chat_receiver_type, $chat_receiver_types)) {
            $this->_error('chat_receiver_type 接收者类型 参数错误', 400);
        }
        
        // chat_receiverid 接收者id
        $chat_receiverid_param = valueRequest('chat_receiverid', 0);
        $chat_receiverid = isset($params['chat_receiverid']) ? $params['chat_receiverid'] : $chat_receiverid_param;
        if (empty($chat_receiverid)) {
            $this->_error('chat_receiverid 接收者id 参数错误', 400);
        }
        
        // chat_stuff_type chat_stuff_id chat_content
        $chat_stuff_type_param = valueRequest('chat_stuff_type', 0);
        $chat_stuff_type = isset($params['chat_stuff_type']) ? $params['chat_stuff_type'] : $chat_stuff_type_param;
        $chat_stuff_id_param = valueRequest('chat_stuff_id', 0);
        $chat_stuff_id = isset($params['chat_stuff_id']) ? $params['chat_stuff_id'] : $chat_stuff_id_param;
        // chat_content 这是一个数组
        // $chat_content_request = Request::instance()->post('chat_content'); 巨坑
        $chat_content_request = $_REQUEST['chat_content'];
        $chat_content = isset($params['chat_content']) ? $params['chat_content'] : $chat_content_request;
        
        // case 消息支持的类型检查 TODO
        
        return array(
            'chat_sender_type' => $chat_sender_type,
            'chat_senderid' => $chat_senderid,
            'chat_receiver_type' => $chat_receiver_type,
            'chat_receiverid' => $chat_receiverid,
            'chat_stuff_type' => $chat_stuff_type,
            'chat_stuff_id' => $chat_stuff_id,
            'chat_content' => $chat_content
        );
    }

    /**
     * @function 消息推送 单推
     * @author ljx
     */
    public function push($params = array())
    {
        // case 参数接收和检验
        $postData = $this->checkPush($params);
        
        // case 写入opm_app_msg
        $appMsgModel = new \app\message\model\AppMsg();
        $requestData_log = $postData;
        $result_log = $appMsgModel->add($requestData_log);
        if($result_log === false){
            $this->_error('推送消息失败', 500);
        }

        // case 消息推送
        if(empty($postData['msg_receive_id'])){
            $receive_id = "";
        }else{
            $receive_id = $postData['msg_receive_id'];
        }
        $this->getPusher();
        $result_push = $this->pusher->setUser($receive_id)
            ->setContent($postData)
            ->push();
        if($result_push != 'ok'){
            $this->_error('消息发送失败~', 500);
        }else{
            return array(
                'data' => true
            );
        }
    }
    
    /**
     * @function 推送参数检查
     * @author ljx
     */
    private function checkPush($params = array()){
        // msg_type 消息类型: 0系统 1消费
        $msg_type_param = valueRequest('msg_type', 0);
        $msg_type = isset($params['msg_type']) ? $params['msg_type'] : $msg_type_param;
        $msg_types = array(
            0,
            1
        );
        if (! in_array($msg_type, $msg_types)) {
            $this->_error('msg_type 发送者类型 参数错误', 400);
        }
        
        // msg_from_id 消息发送者id: 0系统 msg_type=1时为商户id
        $msg_from_id_param = valueRequest('msg_from_id', 0);
        $msg_from_id = isset($params['msg_from_id']) ? $params['msg_from_id'] : $msg_from_id_param;
        if ($msg_type_param != 0 && empty($msg_from_id)) {
            $this->_error('msg_from_id 消息发送者id 参数错误', 400);
        }
        
        // msg_receive_id 接收者id
        $msg_receive_id_param = valueRequest('msg_receive_id', 0);
        $msg_receive_id = isset($params['msg_receive_id']) ? $params['msg_receive_id'] : $msg_receive_id_param;

        // msg_title 消息标题
        $msg_title_param = valueRequest('msg_title', '', 'string');
        $msg_title = isset($params['msg_title']) ? $params['msg_title'] : $msg_title_param;
        if(empty($msg_title)){
            $this->_error('msg_title 消息标题  参数错误', 400);
        }
        
        // msg_content 消息内容
        $msg_content_param = valueRequest('msg_content', '', 'string');
        $msg_content = isset($params['msg_content']) ? $params['msg_content'] : $msg_content_param;
        if(empty($msg_content)){
            $this->_error('msg_content 消息内容  参数错误', 400);
        }
        
        // msg_link 消息链接
        $msg_link_param = valueRequest('msg_link', '', 'string');
        $msg_link = isset($params['msg_link']) ? $params['msg_link'] : $msg_link_param;
        
        return array(
            'msg_type' => $msg_type,
            'msg_from_id' => $msg_from_id,
            'msg_receive_id' => $msg_receive_id,
            'msg_title' => $msg_title,
            'msg_content' => $msg_content,
            'msg_link' => $msg_link
        );
    }

    /**
     * @function 群聊
     * @author ljx
     */
    public function groupChat()
    {
    }
}
