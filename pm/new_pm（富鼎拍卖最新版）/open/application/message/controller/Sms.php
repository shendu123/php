<?php
namespace app\message\controller;

use app\common\controller\NoAuth;
use app\basic\model\MemberBack;

class Sms extends NoAuth
{
    // 短信提供商
    private $providers = array(
        'ali',
        'jiguang' /*暂不支持*/
    );
    // 当前短信提供商
    private $provider;
    // 验证码有效期
    private $expireTime = 60 * 5;

    public function __construct($provider = "")
    {
        parent::__construct();
        in_array($provider, $this->providers) ? $this->provider = $provider : $this->provider = "ali";
    }

    /**
     * @action 发送短信
     * @author ljx
     *        
     * @param string $mobile/$requestData['mobile'] 接收手机号码
     * @param string $type/$requestData['type'] 短信类型
     *       
     */
    public function send($requestData = array())
    {
        // case 提交数据检查
        $result_post = $this->checkSendPost($requestData);
        if (isset($result_post['status']) && $result_post['status'] != 200) {
            return $result_post;
        } else {
            $tradeData = $result_post;
        }
        
        // case 检查是否允许发送短信 1.时间限制 2.ip限制【先不做】 3业务限制
        $result_firewall = $this->fireWall($tradeData);
        if (isset($result_firewall['status']) && $result_firewall['status'] != 200) {
            return $result_firewall;
        }
        
        // case common data
        $code = $this->randomkeys(4);
        $tradeData['code'] = $code;
        
        // case 记录
        $result_logSend = $this->logSend($tradeData);
        if (isset($result_logSend['status']) && $result_logSend['status'] != 200) {
            return $result_logSend;
        }else{
            $sms_id = $result_logSend;
        }
        
        // case 发送短信
        $config = config('sms');
        switch ($this->provider) {
            case 'ali':
                $phoneNumbers = $tradeData['mobile'];
                $templateParam = array(
                    'number' => $tradeData['code'],
                    'code' => $tradeData['code'],
                    'product' => '首玺拍卖'
                );
                require_once __DIR__ . '/../library/Alisms.php';
                $smsObj = new \Alisms();
                $result = $smsObj->sendSms($config['ali']['sign']['default'], $config['ali']['template']['zhuce'], $phoneNumbers, $templateParam);
                if ($result['Code'] !== "OK") {
                    $this->_error('短信发送失败~', 500);
                }
                break;
            case 'jiguang':
                // 验证码由极光提供
                ;
                break;
        }
        if (isset($returnData['status']) && $returnData['status'] != 200) {
            return $returnData;
        }
        
        // case 成功
        return array(
            'msg' => '短信发送成功~',
            'data' => array(
                'sms_id' => $sms_id
            )
        );
    }

    /**
     * @function 短信发送记录
     * @author ljx
     */
    private function logSend($tradeData = array())
    {
        $smsModel = new \app\message\model\Sms();
        $sms_channels = array(
            'ali' => 0,
            'jiguang' => 1
        );
        // 短信类型: 0系统 1消费 2验证码
        $sms_types = array(
            'zhuce' => 2,
            'xiugai' => 2,
            'denglu' => 2,
            'duihuan' => 1
        );
        $requestData = array(
            'sms_channel' => $sms_channels[$this->provider],
            'sms_type' => $sms_types[$tradeData['type']],
            // 'sms_receive_id' => 0,
            'sms_mobile' => $tradeData['mobile'],
            'sms_title' => $tradeData['type'],
            'sms_content' => $tradeData['code'], // TODO 模板内容 + 参数
            'sms_outtime' => $_SERVER['REQUEST_TIME'] + $this->expireTime
        );
        
        $result_log = $smsModel->add($requestData);
        if ($result_log === false) {
            $this->_error('短信发送失败~', 500);
        }
        
        return $result_log;
    }

    /**
     * @function 提交数据检查
     * @author ljx
     */
    private function checkSendPost($requestData = array())
    {
        // case post check
        $types = array(
            'zhuce',
            'xiugai',
            'denglu',
            'duihuan'
        );
        
        $mobile_request = valueRequest('mobile', '', 'string');
        $mobile = $mobile_request ? $mobile_request : $requestData['mobile'];
        if (checkMobile($mobile) !== true) {
            $this->_error('手机号码输入有误~', 400);
        }
        $type_request = valueRequest('type', '', 'string');
        $type = $type_request ? $type_request : $requestData['type'];
        if (! in_array($type, $types)) {
            $this->_error('暂不支持发送该类型的短信~', 400);
        }
        
        return array(
            'mobile' => $mobile,
            'type' => $type
        );
    }

    /**
     * @funciton 验证短信验证码
     * @author ljx
     * @param string $mobile 接收手机号码
     * @param string $code 短信验证码
     * @param int $sms_id 短信key
     */
    public function auth()
    {
        // TODO 不同的短信服务商 的短信验证码验证方式不相同
        
        $tradeData = array();
        
        // case check post
        $tradeData['mobile'] = valueRequest('mobile', '', 'string');
        if (checkMobile($tradeData['mobile']) !== true) {
            $this->_error('手机号码输入有误~', 400);
        }
        $tradeData['code'] = valueRequest('code', '', 'string');
        if (empty($tradeData['code'])) {
            $this->_error('短信验证码不能为空~', 400);
        }
        $tradeData['sms_id'] = valueRequest('sms_id', 0);
        if (empty($tradeData['sms_id'])) {
            $this->_error('短信的sms_id不能为空~', 400);
        }

        $isExist = curl_get_content(config("basic_api_url") . "Util/isExist?mobile=" . $tradeData['mobile']);
        $isExist = object_array($isExist);
        if ($isExist['data'] === true) {
            $this->_error('手机号码用户已经存在', 400);
        }

        // case auth 
        $smsModel = new \app\message\model\Sms();
        $wdata = array(
            'id' => $tradeData['sms_id']
        );
        $row = $smsModel->getRow($wdata);
        if(empty($row)){
            $this->_error('验证失败~', 400);
        }

        if($row['sms_mobile'] != $tradeData['mobile']){
            $this->_error('手机号码不匹配~', 400);
        }
        if($row['sms_content'] != $tradeData['code']){
            $this->_error('验证码不匹配~', 400);
        }
        if($row['sms_outtime'] < $this->request_time){
            $this->_error('验证码已过期~', 400);
        }
        if($row['sms_status'] == 10){
            $this->_error('该验证码已经使用过了~', 400);
        }
        
        // case 更新
        $requestData = array(
            'sms_id' => $tradeData['sms_id'],
            'sms_status' => 10
        );
        $result_update = $smsModel->edit($requestData);
        if($result_update !== true){
            $this->_error('验证失败~', 500);
        }
        
        // case 返回
        return array(
            'msg' => '验证成功'
        );
    }

    /**
     * @function 短信发送限制
     * @author ljx
     */
    private function fireWall($tradeData)
    {
        // case 检查发送时间
        $smsModel = new \app\message\model\Sms();
        $wdata = array(
            'sms_mobile' => $tradeData['mobile']
        );
        $row = $smsModel->getLatest($wdata);
        
        if ($row['sms_intime'] + $this->expireTime > $this->request_time) {
            $this->_error('短信发送太频繁了~', 400);
        }
                                
        // case 除了注册，其他情况要求手机号码在系统中存在
        if ($tradeData['type'] != 'zhuce') {
            $isExist = curl_get_content(config("basic_api_url") . "Util/isExist?mobile=" . $tradeData['mobile']);
            $isExist = object_array($isExist);
            if ($isExist['data'] === false) {
                $this->_error('不存在该手机号的用户~', 400);
            }
        }
        
        // case TODO 检查发送源地址是否发送频繁 
        
    }

    /**
     * [randomkeys 生成随机数]
     * @param [type] $length [随机数长度]
     * @return [type] $key [随机数]
     */
    private function randomkeys($length)
    {
        $pattern = '1235678908698966866999009899992098222';
        $key = '';
        for ($i = 0; $i < $length; $i ++) {
            $key .= $pattern{mt_rand(0, 35)};
        }
        return $key;
    }
}