<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 模拟tab产生空格
 * @param int $step
 * @param string $string
 * @param int $size
 * @return string
 */
function tab($step = 1, $string = ' ', $size = 4)
{
    return str_repeat($string, $size * $step);
}
// 支付类型
function pay_type($type)
{
    switch ($type) {
        case 'YE':
            $res = '余额支付';
            break;
        case 'W':
            $res = '微信'; // 微信手机，微信pc扫码，微信app(第三方)支付，微信js支付（微信自己里面的支付）
            break;
        case 'WWAP':
            $res = '微信wap';
            break;
        case 'WPC':
            $res = '微信pc扫码';
            break;
        case 'WAAP':
            $res = '微信app';
            break;
        case 'WJS':
            $res = '微信内部';
            break;
        case 'Z':
            $res = '支付宝';
            break;
        case 'ZWAP':
            $res = '支付宝wap';
            break;
        case 'ZPC':
        case 'ZAAP':
        case 'ZNB':
            $res = '支付宝内部';
            break;
        case 'P':
            $res = 'pc支付';
            break;
        case 'S':
            $res = '手机支付';
            break;
        case 'A':
            $res = 'App支付';
            break;
        case 'H':
            $res = '汇潮';
            break;
        default:
            $res = '未知';
            break;
    }
    return $res;
}
// 流水来源
function fundflowFrom($from)
{
    switch ($from) {
        case 'PM':
            $res = '拍卖';
            break;
        case 'VIP':
            $res = 'VIP拍卖';
            break;
        case 'ZM':
            $res = '自由买卖';
            break;
        case 'SG':
            $res = '申购';
            break;
        case 'YC':
            $res = '余额充值';
            break;
        case 'YD':
            $res = '余额冻结';
            break;
        case 'CZ':
            $res = '充值';
            break;
        case 'JJ':
            $res = '竞价';
            break;
        default:
            $res = '充值';
            break;
    }
    return $res;
}

// 支付状态
function pay_status($status)
{
    switch ($status) {
        case '1':
            $res = '成功';
            break;
        case '2':
            $res = '未支付';
            break;
        case '3':
            $res = '失败';
            break;
        case '31':
            $res = '余额不足';
            break;
        default:
            $res = '未支付';
            break;
    }
    return $res;
}

// 发货状态
function delivery_status($status)
{
    switch ($status) {
        case '1':
            $res = '已发货';
            break;
        case '2':
            $res = '待发货';
            break;
        case '3':
            $res = '已收货';
            break;
        default:
            $res = '待发货';
            break;
    }
    return $res;
}
/*
 *  价格处理
 * @param $showPrice查询显示的价格，转换为元
 * @param $insertPrice入库的价格，转换为分
 */
function priceFormat($showPrice='',$insertPrice='')
{
	if($showPrice){
		if (is_array($showPrice)) {
			foreach ($showPrice as $k => $v) {
				$showPrice[$k] /= 100;
			}
		} else {
			$showPrice /= 100;
		}
		return $showPrice;		
	}
	if($insertPrice){		
		return $insertPrice *= 100;
	}

}

/*
 * 文档字符过滤
 */
function filter_content($content){
	return str_replace(array('&nbsp;','&amp;','&quot;','&lt;','&gt;','&#039;','&ldquo;','&rdquo;','&mdash;'), array(' ','&','"','<','>',"'",'“','”','—'), $content);
}


/**
 * @function 根据数据表模型字段解析form提交的数据
 * @author ljx
 *        
 * @param array $tableFields 表格字段列表
 * @param array $data 前端提交的数据
 */
function parseRequestData($tableFields = array(), $data = array())
{
    $parseResult = array();
    foreach ($tableFields as $field => $type) {
        if (isset($data[$field])) {
            $parseResult[$field] = $data[$field];
        }
    }
    
    return $parseResult;
}

/**
 * @function 用户输入的数值检验给定默认值
 * @author ljx
 *        
 * @param string $name 参数名称
 * @param mixed $default 默认值
 * @param string $type 参数数据类型
 */
function valueRequest($name, $default, $type = 'int')
{
    $return_val = \think\Request::instance()->request($name);
    
    if (! empty($type)) {
        $return_val = valueCheck($return_val, $type, $default);
    }
    
    return $return_val;
}

/**
 * @function 数值验证
 * @author ljx
 *        
 * @param string $name 参数名称
 * @param mixed $default 默认值
 * @param string $type 参数数据类型
 */
function valueCheck($value, $type, $default = NULL)
{
    switch ($type) {
        case 'int':
            $data = ! empty($default) ? $default : 0;
            $value = trim("{$value}");
            $return = is_numeric($value) ? $value : 0;
            if (empty($return) && ! empty($default)) {
                $return = $data;
            }
            break;
        case 'string':
            $data = ! empty($default) ? $default : '';
            $value = trim("{$value}");
            $value = str_replace("\\", '', $value);
            $value = str_replace("/", '', $value);
            $value = str_replace("'", '', $value);
            $value = str_replace("’", '', $value);
            $return = ! empty($value) ? $value : $data;
            break;
        case 'date':
            $data = isset($default) ? $default : time();
            $value = strtotime($value);
            $return = $value ? $value : $data;
            break;
        case 'float':
            $return = is_float($value) ? $value : 0;
            break;
        case 'double':
            $return = is_double($value) ? $value : 0;
            break;
        default:
            $return = 0;
            break;
    }
    return $return;
}

/**
 * @function std class 转数组
 * @author ljx
 *        
 *         @remarks source from internet
 */
function object_array($array)
{
    if (is_object($array)) {
        $array = (array) $array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}

/**
 * @function 时间转换
 * @author ljx
 */
function timeFmt($timestamp, $format = "Y-m-d H:i:s", $default = "")
{
    $str = "";
    $timestamp > 0 ? $str = date($format, $timestamp) : $str = $default;
    
    return $str;
}

/**
 * @function 批量htmlspecials_decode
 * @author ljx
 */
function multiDecode($data = '')
{
    if (is_array($data)) {
        foreach ($data as $key => $val) {
            $data[$key] = multiDecode($val);
        }
    } else {
        return htmlspecialchars_decode($data);
    }
    
    return $data;
}

/**
 * @function 获取客户端ip地址
 * @author ljx
 */
function getIPaddress()
{
    $IPaddress = '';
    
    if (isset($_SERVER)) {
        
        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            
            $IPaddress = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else 
            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                
                $IPaddress = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                
                $IPaddress = $_SERVER["REMOTE_ADDR"];
            }
    } else {
        
        if (getenv("HTTP_X_FORWARDED_FOR")) {
            
            $IPaddress = getenv("HTTP_X_FORWARDED_FOR");
        } else 
            if (getenv("HTTP_CLIENT_IP")) {
                
                $IPaddress = getenv("HTTP_CLIENT_IP");
            } else {
                
                $IPaddress = getenv("REMOTE_ADDR");
            }
    }
    
    return $IPaddress;
}

/**
 * @function 验证手机号码
 * @author ljx
 */
function checkMobile($mobile)
{
    $mobile_rule = "/^1[34578]{1}\d{9}$/";
    $mobile_rule2 = '#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,1,3,6,7,8]{1}\d{8}$|^18[\d]{9}$#';
    if (! is_numeric($mobile)) {
        return FALSE;
    }
    return preg_match($mobile_rule2, $mobile) ? TRUE : FALSE;
}

/**
 * @function 判断浏览器访问的内核
 * @author ljx
 */
function checkBrowser()
{
    // 方法1
    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $user_agent = isset($user_agent) ? $user_agent : '';
    $mobile_agents = Array(
        "240x320",
        "acer",
        "acoon",
        "acs-",
        "abacho",
        "ahong",
        "airness",
        "alcatel",
        "amoi",
        "android",
        "anywhereyougo.com",
        "applewebkit/525",
        "applewebkit/532",
        "asus",
        "audio",
        "au-mic",
        "avantogo",
        "becker",
        "benq",
        "bilbo",
        "bird",
        "blackberry",
        "blazer",
        "bleu",
        "cdm-",
        "compal",
        "coolpad",
        "danger",
        "dbtel",
        "dopod",
        "elaine",
        "eric",
        "etouch",
        "fly ",
        "fly_",
        "fly-",
        "go.web",
        "goodaccess",
        "gradiente",
        "grundig",
        "haier",
        "hedy",
        "hitachi",
        "htc",
        "huawei",
        "hutchison",
        "inno",
        "ipad",
        "ipaq",
        "ipod",
        "jbrowser",
        "kddi",
        "kgt",
        "kwc",
        "lenovo",
        "lg ",
        "lg2",
        "lg3",
        "lg4",
        "lg5",
        "lg7",
        "lg8",
        "lg9",
        "lg-",
        "lge-",
        "lge9",
        "longcos",
        "maemo",
        "mercator",
        "meridian",
        "micromax",
        "midp",
        "mini",
        "mitsu",
        "mmm",
        "mmp",
        "mobi",
        "mot-",
        "moto",
        "nec-",
        "netfront",
        "newgen",
        "nexian",
        "nf-browser",
        "nintendo",
        "nitro",
        "nokia",
        "nook",
        "novarra",
        "obigo",
        "palm",
        "panasonic",
        "pantech",
        "philips",
        "phone",
        "pg-",
        "playstation",
        "pocket",
        "pt-",
        "qc-",
        "qtek",
        "rover",
        "sagem",
        "sama",
        "samu",
        "sanyo",
        "samsung",
        "sch-",
        "scooter",
        "sec-",
        "sendo",
        "sgh-",
        "sharp",
        "siemens",
        "sie-",
        "softbank",
        "sony",
        "spice",
        "sprint",
        "spv",
        "symbian",
        "tablet",
        "talkabout",
        "tcl-",
        "teleca",
        "telit",
        "tianyu",
        "tim-",
        "toshiba",
        "tsm",
        "up.browser",
        "utec",
        "utstar",
        "verykool",
        "virgin",
        "vk-",
        "voda",
        "voxtel",
        "vx",
        "wap",
        "wellco",
        "wig browser",
        "wii",
        "windows ce",
        "wireless",
        "xda",
        "xde",
        "zte"
    );
    $browser_type = 'pc';
    $is_mobile = FALSE;
    foreach ($mobile_agents as $device) {
        if (stristr($user_agent, $device) !== FALSE) {
            $is_mobile = TRUE;
            break;
        }
    }
    /* 获取浏览器内核 */
    // $browser_kernel = preg_match ( '|\(.*?\)|', $user_agent, $matches_kernel ) > 0 ? $matches[0] : '';
    /* 获取版本号-内核 */
    // $browser_version = preg_match ( '/.*?(MicroMessenger\/([0-9.]+))\s*/', $user_agent, $matches_version );
    if ($is_mobile == TRUE) {
        if (strpos($user_agent, "MicroMessenger") !== FALSE) { /* 微信浏览器 */
            $browser_type = 'weixin';
        } else {
            $browser_type = 'mobile';
        }
    }
    
    return $browser_type;
}

/**
 * @function 检查并给默认值
 * @author ljx
 */
function fd_checktime($time = 0, $format = "Y-m-d H:i")
{
    $str = '';
    ! empty($time) ? $str = date($format, $time) : $str = '';
    return $str;
}

/**
 * @function 金额 小数 转换 int
 * @author ljx
 */
function fd_enmoney($money)
{
    if (is_numeric($money)) {
        $int_money = ($money * 100);
        $int_money = (float) ($int_money);
    }
    return $int_money;
}

/**
 * @function int 转换 金额小数
 * @author ljx
 */
function fd_demoney($money)
{
    if (is_numeric($money)) {
        $int_money = $money / 100;
        $int_money = sprintf("%.2f", $int_money);
    }
    return $int_money;
}

/**
 * @function 通用生成订单号
 * @author ljx
 * @param string $service 业务名称
 * @param intiger $uid 用户id
 * @see $service 最好不要超过9个字符 生成的订单号控制在32个字符内
 */
function genOrdeCode($service, $uid)
{
    $service = strtoupper($service);
    $code = $service . sprintf("%06d", ($uid + 19) % 100000) . date('ymdHis') . rand(10000, 99999);
    return $code;
}

/**
 * @function 拆分大数组
 * @author ljx
 * @param array $array_input 数组
 * @param intiger $length 切割长度
 */
function fd_divide_array($array_input, $length = 50)
{
    $length_count = count($array_input);
    if ($length_count <= $length) {
        return array(
            $array_input
        );
    }
    
    $returnData = array();
    
    $circle = ceil($length_count / $length);
    for ($i = 1; $i <= $circle; $i ++) {
        $start = ($i - 1) * $length;
        $returnData[] = array_slice($array_input, $start, $length);
    }
    
    return $returnData;
}

/**
 * @function 运算符检查并转换
 * @author ljx
 */
function opr_check_convert($operator = '')
{
    $operators = array(
        'gt',
        'lt',
        'eq',
        'egt',
        'elt',
        'neq'
    );
    $operators_map = array(
        'gt' => '>',
        'lt' => '<',
        'eq' => '=',
        'egt' => '>=',
        'elt' => '<=',
        'neq' => '!='
    );
    
    if (! in_array($operator, $operators)) {
        return;
    } else {
        return $operators_map[$operator];
    }
}

/**
 * @function 删除指定key的元素 目前满足 ^{$keyString}.* 这个规则才能用
 * @author ljx
 */
function fd_delArrElesByKey($keyString = '', $arr = array())
{
    if (empty($keyString) || empty($arr)) {
        return false;
    }
    
    $regExp = "/^{$keyString}.*/";
    foreach ($arr as $key => $val) {
        $matchResult = preg_match($regExp, $key);
        if ($matchResult) {
            unset($arr[$key]);
        }
    }
    
    return $arr;
}

/**
 * @function 数组按某个元素的key进行分组
 * @author ljx
 */
function fd_array_group($data, $key_in_element)
{
    $returnData = array();
    foreach ($data as $key => $val) {
        $returnData[$val[$key_in_element]][] = $val;
    }
    
    return $returnData;
}

/**
 * @function 检查正整数
 * @author ljx
 */
function fd_isposnum($number = 0){
    return abs(ceil($number)) != $number ? false : true;
}

