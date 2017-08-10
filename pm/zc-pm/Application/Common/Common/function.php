<?php

/**
  +----------------------------------------------------------
 * 原样输出print_r的内容
  +----------------------------------------------------------
 * @param string    $content   待print_r的内容
  +----------------------------------------------------------
 */

use Library\Aliyunsms\Aliyunsms;
function pre($content) {
    header("Content-type: text/html;charset=utf-8");
    echo "<pre>";
    print_r($content);
    echo "</pre>";
}
function checkKey(){
    $Xxtea = new \Org\Util\Xxtea();
    if ( !file_exists(APP_PATH . "Common/Conf/key.dat") ){
        show();
    }
    $xxtea_key = 'paimai.oncoo.net/cuit';
    $str = @file_get_contents(APP_PATH . "Common/Conf/key.dat");
    $str = $Xxtea->decrypt($str,$xxtea_key);
    $arr = explode(',',$str);
    $host = $_SERVER['HTTP_HOST'];
    if(in_array($host,$arr)){
        return true;
    }
    show();
}
function show(){
    @header('Content-Type: text/html; charset=utf-8');
    $str = 'PHA+5piC6YW3572R57uc5o+Q6YaS5oKo77yaPC9wPiAgICAgICAgPHA+PHN0cm9uZz7mraTln5/lkI3mnKrnu4885piC6YW3572R57ucPuaOiOadg++8jOaXoOazlei/kOihjOaYgumFt+aLjeWNluezu+e7n++8gTwvc3Ryb25nPjwvcD4gICAgICAgIDxoci8+ICAgICAgICA8cD7lrpjmlrnnvZHlnYDvvJo8YSBocmVmPSJodHRwOi8vd3d3Lm9uY29vLm5ldCI+d3d3Lm9uY29vLm5ldDwvYT48L2JyPuiBlOezu+eUteivne+8mjEzODAzODQ1MDc377ybMTU1MTU4NDg5MDI8L2JyPlFROjE3NzI3MDMzNzLvvJsxNjI4NDkyNTc5PC9wPiAgICAgICAgPHA+5piC6YW3572R57ucLeS4k+azqOS6juWcqOe6v+aLjeWNlue9keermeezu+e7n+eahOeglOWPkeWPiumUgOWUru+8gTwvcD4=';
    $str = base64_decode($str);
    die($str);
}
/**
 * 网站分页配置
 * @param  [type] $count [总数]
 * @param  [type] $size  [每页显示]
 * @return [type]        [description]
 */
function page($count,$size,$client='web'){
    $page = new \Think\Page($count, $size);
    $page->lastSuffix = false;
    $page->setConfig('prev','上一页');
    $page->setConfig('next','下一页');
    $page->setConfig('first','首页');
    $page->setConfig('last','尾页');
    $page->setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% <span>共%TOTAL_PAGE%页</span>');
    $pConf['show'] = $page->show();
    $pConf['first'] = $page->firstRow;
    $pConf['list'] = $page->listRows;
    return $pConf;
}
/**
 * 验证验证码
 * @param $code
 * @param string $id
 * @return bool
 */
function check_verify($code, $id = '',$reset = true){
    session_start();
    $verify = new \Think\Verify();
    $verify->reset = $reset;
    return $verify->check($code, $id,$reset);
    session_write_close();
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function set_config($name, $value='', $path=DATA_PATH) {
    static $_cache  = array();
    $filename       = $path . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
        } else {
            // 缓存数据
            $dir            =   dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir,0755,true);
            $_cache[$name]  =   $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    if (is_file($filename)) {
        $value          =   include $filename;
        $_cache[$name]  =   $value;
    } else {
        $value          =   false;
    }
    return $value;
}

/**
  +----------------------------------------------------------
 * 加密密码
  +----------------------------------------------------------
 * @param string    $data   待加密字符串
  +----------------------------------------------------------
 * @return string 返回加密后的字符串
 */
function encrypt($data) {
    return md5(C("AUTH_CODE") . md5($data));
}

/**
  +----------------------------------------------------------
 * 将一个字符串转换成数组，支持中文
  +----------------------------------------------------------
 * @param string    $string   待转换成数组的字符串
  +----------------------------------------------------------
 * @return string   转换后的数组
  +----------------------------------------------------------
 */
function strToArray($string) {
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string, 0, 1, "utf8");
        $string = mb_substr($string, 1, $strlen, "utf8");
        $strlen = mb_strlen($string);
    }
    return $array;
}

/**
  +----------------------------------------------------------
 * 生成随机字符串
  +----------------------------------------------------------
 * @param int       $length  要生成的随机字符串长度
 * @param string    $type    随机码类型：0，数字+大写字母；1，数字；2，小写字母；3，大写字母；4，特殊字符；-1，数字+大小写字母+特殊字符
  +----------------------------------------------------------
 * @return string
  +----------------------------------------------------------
 */
function randCode($length = 5, $type = 0) {
    $arr = array(1 => "0123456789", 2 => "abcdefghijklmnopqrstuvwxyz", 3 => "ABCDEFGHIJKLMNOPQRSTUVWXYZ", 4 => "~@#$%^&*(){}[]|");
    if ($type == 0) {
        array_pop($arr);
        $string = implode("", $arr);
    } else if ($type == "-1") {
        $string = implode("", $arr);
    } else {
        $string = $arr[$type];
    }
    $count = strlen($string) - 1;
    for ($i = 0; $i < $length; $i++) {
        $str[$i] = $string[rand(0, $count)];
        $code .= $str[$i];
    }
    return $code;
}

/**
  +-----------------------------------------------------------------------------------------
 * 删除目录及目录下所有文件或删除指定文件
  +-----------------------------------------------------------------------------------------
 * @param str $path   待删除目录路径
 * @param int $delDir 是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
  +-----------------------------------------------------------------------------------------
 * @return bool 返回删除状态
  +-----------------------------------------------------------------------------------------
 */
function delDirAndFile($path, $delDir = FALSE) {
    $handle = opendir($path);
    if ($handle) {
        while (false !== ( $item = readdir($handle) )) {
            if ($item != "." && $item != "..")
                is_dir("$path/$item") ? delDirAndFile("$path/$item", $delDir) : unlink("$path/$item");
        }
        closedir($handle);
        if ($delDir)
            return rmdir($path);
    }else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return FALSE;
        }
    }
}

/**
  +----------------------------------------------------------
 * 将一个字符串部分字符用*替代隐藏
  +----------------------------------------------------------
 * @param string    $string   待转换的字符串
 * @param int       $bengin   起始位置，从0开始计数，当$type=4时，表示左侧保留长度
 * @param int       $len      需要转换成*的字符个数，当$type=4时，表示右侧保留长度
 * @param int       $type     转换类型：0，从左向右隐藏；1，从右向左隐藏；2，从指定字符位置分割前由右向左隐藏；3，从指定字符位置分割后由左向右隐藏；4，保留首末指定字符串
 * @param string    $glue     分割符
  +----------------------------------------------------------
 * @return string   处理后的字符串
  +----------------------------------------------------------
 */
function hideStr($string, $bengin = 0, $len = 4, $type = 0, $glue = "@") {
    if (empty($string))
        return false;
    $array = array();
    if ($type == 0 || $type == 1 || $type == 4) {
        $strlen = $length = mb_strlen($string);
        while ($strlen) {
            $array[] = mb_substr($string, 0, 1, "utf8");
            $string = mb_substr($string, 1, $strlen, "utf8");
            $strlen = mb_strlen($string);
        }
    }
    switch ($type) {
        case 1:
            $array = array_reverse($array);
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", array_reverse($array));
            break;
        case 2:
            $array = explode($glue, $string);
            $array[0] = hideStr($array[0], $bengin, $len, 1);
            $string = implode($glue, $array);
            break;
        case 3:
            $array = explode($glue, $string);
            $array[1] = hideStr($array[1], $bengin, $len, 0);
            $string = implode($glue, $array);
            break;
        case 4:
            $left = $bengin;
            $right = $len;
            $tem = array();
            for ($i = 0; $i < ($length - $right); $i++) {
                if (isset($array[$i]))
                    $tem[] = $i >= $left ? "*" : $array[$i];
            }
            $array = array_chunk(array_reverse($array), $right);
            $array = array_reverse($array[0]);
            for ($i = 0; $i < $right; $i++) {
                $tem[] = $array[$i];
            }
            $string = implode("", $tem);
            break;
        default:
            for ($i = $bengin; $i < ($bengin + $len); $i++) {
                if (isset($array[$i]))
                    $array[$i] = "*";
            }
            $string = implode("", $array);
            break;
    }
    return $string;
}

/**
  +----------------------------------------------------------
 * 功能：字符串截取指定长度
 * leo.li hengqin2008@qq.com
  +----------------------------------------------------------
 * @param string    $string      待截取的字符串
 * @param int       $len         截取的长度
 * @param int       $start       从第几个字符开始截取
 * @param boolean   $suffix      是否在截取后的字符串后跟上省略号
  +----------------------------------------------------------
 * @return string               返回截取后的字符串
  +----------------------------------------------------------
 */
function cutStr($str, $len = 100, $start = 0, $suffix = 1) {
    $str = strip_tags(trim(strip_tags($str)));
    $str = str_replace(array("\n", "\t"), "", $str);
    $strlen = mb_strlen($str);
    while ($strlen) {
        $array[] = mb_substr($str, 0, 1, "utf8");
        $str = mb_substr($str, 1, $strlen, "utf8");
        $strlen = mb_strlen($str);
    }
    $end = $len + $start;
    $str = '';
    for ($i = $start; $i < $end; $i++) {
        $str.=$array[$i];
    }
    return count($array) > $len ? ($suffix == 1 ? $str . "&hellip;" : $str) : $str;
}

/**
  +----------------------------------------------------------
 * 功能：检测一个目录是否存在，不存在则创建它
  +----------------------------------------------------------
 * @param string    $path      待检测的目录
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function makeDir($path) {
    return is_dir($path) or (makeDir(dirname($path)) and @mkdir($path, 0777));
}

/**
  +----------------------------------------------------------
 * 功能：检测一个字符串是否是邮件地址格式
  +----------------------------------------------------------
 * @param string $value    待检测字符串
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function is_email($value) {
    return preg_match("/^[0-9a-zA-Z]+(?:[\_\.\-][a-z0-9\-]+)*@[a-zA-Z0-9]+(?:[-.][a-zA-Z0-9]+)*\.[a-zA-Z]+$/i", $value);
}

/**
  +----------------------------------------------------------
 * 功能：系统邮件发送函数
  +----------------------------------------------------------
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表namespace Org\Util\PHPMailer;
  +----------------------------------------------------------
 * @return boolean
  +----------------------------------------------------------
 */
function send_mail($to, $name, $subject = '', $body = '', $attachment = null, $config = '') {
    $config = is_array($config) ? $config : C('SYSTEM_EMAIL');
    //import('PHPMailer.phpmailer', VENDOR_PATH);         //从PHPMailer目录导class.phpmailer.php类文件
    $mail = new \Org\Util\PHPMailer\PHPMailer();                           //PHPMailer对象
    $mail->CharSet = 'UTF-8';                         //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                                   // 设定使用SMTP服务

//    $mail->IsHTML(true);
    $mail->SMTPDebug = 0;                             // 关闭SMTP调试功能 1 = errors and messages2 = messages only
    $mail->SMTPAuth = true;                           // 启用 SMTP 验证功能
    if ($config['smtp_port'] == 465)
        $mail->SMTPSecure = 'ssl';                    // 使用安全协议
    $mail->Host = $config['smtp_host'];                // SMTP 服务器
    $mail->Port = $config['smtp_port'];                // SMTP服务器的端口号
    $mail->Username = $config['smtp_user'];           // SMTP服务器用户名
    $mail->Password = $config['smtp_pass'];           // SMTP服务器密码
    $mail->SetFrom($config['from_email'], $config['from_name']);
    $replyEmail = $config['reply_email'] ? $config['reply_email'] : $config['reply_email'];
    $replyName = $config['reply_name'] ? $config['reply_name'] : $config['reply_name'];
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($to, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            if (is_array($file)) {
                is_file($file['path']) && $mail->AddAttachment($file['path'], $file['name']);
            } else {
                is_file($file) && $mail->AddAttachment($file);
            }
        }
    } else {
        is_file($attachment) && $mail->AddAttachment($attachment);
    }
    ob_clean();
    return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
  +----------------------------------------------------------
 * 功能：剔除危险的字符信息
  +----------------------------------------------------------
 * @param string $val
  +----------------------------------------------------------
 * @return string 返回处理后的字符串
  +----------------------------------------------------------
 */
function remove_xss($val) {
    // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
    // this prevents some character re-spacing such as <java\0script>
    // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
    $val = preg_replace('/([\x00-\x08,\x0b-\x0c,\x0e-\x19])/', '', $val);

    // straight replacements, the user should never need these since they're normal characters
    // this prevents like <IMG SRC=@avascript:alert('XSS')>
    $search = 'abcdefghijklmnopqrstuvwxyz';
    $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $search .= '1234567890!@#$%^&*()';
    $search .= '~`";:?+/={}[]-_|\'\\';
    for ($i = 0; $i < strlen($search); $i++) {
        // ;? matches the ;, which is optional
        // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
        // @ @ search for the hex values
        $val = preg_replace('/(&#[xX]0{0,8}' . dechex(ord($search[$i])) . ';?)/i', $search[$i], $val); // with a ;
        // @ @ 0{0,7} matches '0' zero to seven times
        $val = preg_replace('/(&#0{0,8}' . ord($search[$i]) . ';?)/', $search[$i], $val); // with a ;
    }

    // now the only remaining whitespace attacks are \t, \n, and \r
    $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
    $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
    $ra = array_merge($ra1, $ra2);

    $found = true; // keep replacing as long as the previous round replaced something
    while ($found == true) {
        $val_before = $val;
        for ($i = 0; $i < sizeof($ra); $i++) {
            $pattern = '/';
            for ($j = 0; $j < strlen($ra[$i]); $j++) {
                if ($j > 0) {
                    $pattern .= '(';
                    $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                    $pattern .= '|';
                    $pattern .= '|(&#0{0,8}([9|10|13]);)';
                    $pattern .= ')*';
                }
                $pattern .= $ra[$i][$j];
            }
            $pattern .= '/i';
            $replacement = substr($ra[$i], 0, 2) . '<x>' . substr($ra[$i], 2); // add in <> to nerf the tag
            $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
            if ($val_before == $val) {
                // no replacements were made, so exit the loop
                $found = false;
            }
        }
    }
    return $val;
}

/**
  +----------------------------------------------------------
 * 功能：计算文件大小
  +----------------------------------------------------------
 * @param int $bytes
  +----------------------------------------------------------
 * @return string 转换后的字符串
  +----------------------------------------------------------
 */
function byteFormat($bytes) {
    $sizetext = array(" B", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
    return round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . $sizetext[$i];
}

function checkCharset($string, $charset = "UTF-8") {
    if ($string == '')
        return;
    $check = preg_match('%^(?:
                                [\x09\x0A\x0D\x20-\x7E] # ASCII
                                | [\xC2-\xDF][\x80-\xBF] # non-overlong 2-byte
                                | \xE0[\xA0-\xBF][\x80-\xBF] # excluding overlongs
                                | [\xE1-\xEC\xEE\xEF][\x80-\xBF]{2} # straight 3-byte
                                | \xED[\x80-\x9F][\x80-\xBF] # excluding surrogates
                                | \xF0[\x90-\xBF][\x80-\xBF]{2} # planes 1-3
                                | [\xF1-\xF3][\x80-\xBF]{3} # planes 4-15
                                | \xF4[\x80-\x8F][\x80-\xBF]{2} # plane 16
                                )*$%xs', $string);

    return $charset == "UTF-8" ? ($check == 1 ? $string : iconv('gb2312', 'utf-8', $string)) : ($check == 0 ? $string : iconv('utf-8', 'gb2312', $string));
}

/**
 * 显示指定英文标示的广告位
 * @param string $tagname 广告位标示
 * @param string $htag html标签，如div,li,td等，
 */
function showAdvPosition($tagname,$htag="",$is_flash = true)
{
    if(!$tagname){
        return '';
    }
    $advertising_position = M('Advertising_position');
    $advertising = M('Advertising');
    $adv_postmap['tagname'] = array('eq',$tagname);
    $ap= $advertising_position->where($adv_postmap)->find();

    $now=time();
    $advmap['status'] = array('eq',1);
    $advmap['pid'] = array('eq',$ap['id']);
    $advmap['_string'] = "((adv_start_time <='".$now."' and adv_end_time >='".$now."') or (adv_start_time =0 and adv_end_time = 0 ) or (adv_start_time <='".$now."' and adv_end_time = 0 ) or (adv_start_time =0 and adv_end_time >='".$now."' ))";
    
    $adv_list = $advertising->where($advmap)->order('sort desc,id asc')->select();

    foreach($adv_list as $key => $adv){
        $adv_list[$key]['html']= getAdvHTML($adv,$ap);
    }

    $ap['adv_list'] = $adv_list;

    if ($is_flash && $ap ['is_flash'] == 1 && ! empty ( $ap ['flash_style'] )) {
        $adv_path =  '//static.fjsxpmh.com' ."/Public/Advertising/" . $ap ['flash_style'] . ".swf";
        $adv_pics = "";
        $adv_texts = "";
        $adv_links = "";
        
        foreach ( $ap ['adv_list'] as $adv ) {
            if (empty ( $adv_pics ))
                $jg = "";
            else
                $jg = "|";
            
            $adv_pics .= $jg .'//static.fjsxpmh.com'.trim(C('UPLOADS_PICPATH'), '.') . $adv ['code'];
            $adv_texts .= $jg . $adv ['desc'];
            $adv_links .= $jg . $adv ['url'];
            
        }
        
        unset ( $ap ['adv_list'] );
        $parseStr = $ap ['style'];

        $parseStr = str_replace('[adv_position.width]',$ap['width'], $parseStr);
        $parseStr = str_replace('[adv_position.height]',$ap['height'], $parseStr);
        $parseStr = str_replace('[adv_path]',$adv_path, $parseStr);
        $parseStr = str_replace('[adv_pics]',$adv_pics, $parseStr);
        $parseStr = str_replace('[adv_links]',$adv_links, $parseStr);
        $parseStr = str_replace('[adv_texts]',$adv_texts, $parseStr);
        if ($htag){
            $parseStr ='<'.$htag.'>'.$parseStr.'</'.$htag.'>';
        }

    } else {
        $ap_adv_list = $ap ['adv_list'];
        $parseStr='';
        if($ap_adv_list){
            if ($htag){
                foreach($ap_adv_list as $value){
                    $parseStr.='<'.$htag.'>'.$value['html'].'</'.$htag.'>';
                }
            }else{
                $parseStr.='<ul>';
                foreach($ap_adv_list as $value){
                    $parseStr.='<li>'.$value['html'].'</li>';
                }
                $parseStr.='</ul>';
            }
        }
    }
        
    return $parseStr;
    
}
function getAdvHTML($adv,$ap)
{   
    if($ap['width'] == 0)
        $ap['width']="";
    else
        $ap['width']=" width='".$ap['width']."'";
        
    if($ap['height'] == 0)
        $ap['height']="";
    else
        $ap['height']=" height='".$ap['height']."'";
        
    switch($adv['type']){
        case '1':
            if($adv['url']=='')
                $adv_str = "<img src='".C('UPLOADS_PICPATH').$adv['code']."'".$ap['width'].$ap['height']."/>";
            elseif(intval($adv['is_vote']) ==1)
                $adv_str = "<a href='".C('UPLOADS_PICPATH').$adv['url']."' target='_blank' title='".$adv['desc']."'><img src='".C('UPLOADS_PICPATH').$adv['code']."'".$ap['width'].$ap['height']."/></a>";
            else
                $adv_str = "<a href='".$adv['url']."' target='_blank' title='".$adv['desc']."'><img src='".C('UPLOADS_PICPATH').$adv['code']."'".$ap['width'].$ap['height']."/></a>";
            break;
        case '2':
            $adv_str = "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0'".$ap['width'].$ap['height'].">".
                       "<param name='movie' value='".C('UPLOADS_PICPATH').$adv['code']."' />".
                       "<param name='quality' value='high' />".
                       "<param name='menu' value='false' />".
                       "<embed src='".C('UPLOADS_PICPATH').$adv['code']."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'".$ap['width'].$ap['height']."></embed>".
                       "</object>";
            break;
        case '3':
            $adv_str = htmlspecialchars_decode($adv['code']);
            break;
    }
    return $adv_str;
}
//获取广告类型
function getAdvtype($type) {
    switch ($type) {
        case 2 :
            $showText = 'Flash广告';
            break;
        case 3 :
            $showText = '自定义代码广告';
            break;
        case 1 :
        default :
            $showText = '图片广告';

    }
    return $showText;

}
/**
  +----------------------------------------------------------
 * 获取图片尺寸
  +----------------------------------------------------------
 * @param string    $pN   为配置文件中图片的前缀pre_,max_,mid_,mini_
  +----------------------------------------------------------
 */
    function picSize($wk,$wh,$how='goods') {
        if($how=='goods'){
            $picFix = explode(',',C('GOODS_PIC_PREFIX'));
            $picWidth = explode(',',C('GOODS_PIC_WIDTH'));
            $picHeight = explode(',',C('GOODS_PIC_HEIGHT'));
        }elseif ($how=='user') {
            $picFix = explode(',',C('USER_PIC_PREFIX'));
            $picWidth = explode(',',C('USER_PIC_WIDTH'));
            $picHeight = explode(',',C('USER_PIC_HEIGHT'));
        }
        $picSize = array();
        $sK = 0;
        foreach ($picFix as $fK => $fV) {
            $picSize[$sK] = array(
                'width'=> $picWidth[$fK],
                'height'=> $picHeight[$fK]
            );
            $sK +=1;
        }
        if($wk<4){
            return($picSize[$wk][$wh]);
        }
        return($picSize);
    }
/**
  +----------------------------------------------------------
 * 获取数据库中图片加上前缀的地址
  +----------------------------------------------------------
 * @param string    $str   为数据库中图片的地址
 * @param string    $fix   为配置文件中图片的前缀pre_,max_,mid_,mini_的索引分别是0,1,2,3
  +----------------------------------------------------------
 */
    function picRep($str,$fix='',$how='goods'){
        if($how=='goods'){
            $picFix = explode(',',C('GOODS_PIC_PREFIX'));
            $preg = '/'.C('GOODS_PICPATH').'\/\d+?\//is';
        }elseif($how=='user'){
            $picFix = explode(',',C('USER_PIC_PREFIX'));
            $preg = '/'.C('USER_PICPATH').'\//is';
        }
        preg_match($preg, $str, $gdPicPath);
        $newpath = $gdPicPath[0];
        if ($fix) {
            $newpath.=$picFix[$fix];
        }
        $picFixPath=preg_replace($preg ,$newpath, $str);
        return($picFixPath);

    }
    // 图片url
    function getImgUrl($str){
        return C('WEB_ROOT'). str_replace('./', '', C('UPLOADS_PICPATH').$str);
    }


/**
 * 通过数据库图片地址字符串获取指定图片
 * @param  [type] $picStr [数据库中图片字符串]
 * @param  [type] $fix    [第几种图片]
 * @param  [type] $key    [第几个图片]
 * @return [type]         [description]
 */
    function getPicUrl($picStr,$fix,$key){
        if ($picStr) {
            $picArr = explode('|', $picStr);
        }
        return picRep($picArr[$key],$fix);
    }
    /**
     * 获取充值用途
     * @param  [type] $use [description]
     * @return [type]      [description]
     */
    function getUse($purpose){
        switch ($purpose) {
            case 'pledge':
                return '余额充值';
            case 'auction':
                return '拍品支付';
        }
    }
    /**
     * 获取分类对应的筛选条件不限fid
     * @param  [type] $cid  [分类cid]
     * @param  string $type [数据类型,默认字符串]
     * @return [type]       [根据数据类型返回对应筛选条件集合]
     */
    function getTopField($cid,$type='str'){
        $filtrate = M('Goods_filtrate');
        $cate = M('Goods_category');
        $cLinkF =M('Goods_category_filtrate');
        $interimCid = $cid; //临时存放cid
        $catPath = array($cid); //用来保存分类路径的cid
        $zoarium = array();
        // 获取对应顶级条件
        do {
             $interimCid = $cate->where('cid='.$interimCid)->getField('pid');
             if($interimCid !=0){
                $catPath[] = $interimCid ;
             }
        } while ( $interimCid !=0 );
        $catPath = array_reverse($catPath); //获取分类路径id数组
        foreach ($catPath as $lk => $lv) {
            $fidArr = $cLinkF->where('cid='.$lv)->getField('fid',true);
            $filtMap = $filtrate->where(array('fid'=>array('in',$fidArr)))->order('sort desc')->getField('fid',true);
            if($filtMap){
                $zoarium = array_merge($zoarium,$filtMap);
            }
        }
        // 根据所需类型返回
        if($type=='str'){
            return implode('_', $zoarium);
        }elseif ($type=='arr') {
            return $zoarium;
        }
        
    }
    /**
     * [sendSms 发私信]
     * @param  [type] $uid     [用户id]
     * @param  [str] $type     [类型]
     * @param  [type] $content [内容]
     * @return [type]          [description]
     */
    function sendSms($uid,$type,$content){
        $smsData=array(
            'uid'=>$uid,
            'type'=>$type,
            'content'=>$content,
            'time'=>time()
            );
        $smsData['business_id'] = $_SESSION['business_id'];
        M('mysms')->add($smsData);
    }
    /**
     * 生成订单
     * @param  [type] $rmk [订单前缀]
     * @return [type]      [返回订单号]
     */
    function createNo($rmk) {
        return $rmk. time().substr(microtime(), 2, 3) .rand(0, 99);
    }
// 发送微信模板消息
function remind_msg($template_id,$template){
        $color = "#980000";
        $json_token = http_request("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".C('Weixin.appid')."&secret=".C('Weixin.appsecret'));
        $access_token = json_decode($json_token,true);
        $template['topcolor'] = $color;
        // 模板surpass（被超越）bidsuccess（出价成功）
        $tpl = C('Weixin.template');
        switch ($template_id) {
            case 'surpass':
                $template['template_id'] = $tpl['surpass'];
                break;
            case 'bidsuccess':
                $template['template_id'] = $tpl['bidsuccess'];
                break;
            case 'bidstatus':
                $template['template_id'] = $tpl['bidstatus'];
                break;
            case 'success':
                $template['template_id'] = $tpl['success'];
                break;
            case 'orderstatus':
                $template['template_id'] = $tpl['orderstatus'];
                break;
            case 'walletchange':
                $template['template_id'] = $tpl['walletchange'];
                break;
            case 'addsuccess':
                $template['template_id'] = $tpl['addsuccess'];
                break;
        }
        if(!$template['template_id']){
            return false;
        }
        $template['data']['first']=array('value'=>$template['first'],'color'=>"#980000");
        unset($template['first']);
        foreach ($template['keyword'] as $tk => $tv) {
            $template['data']['keyword'.($tk+1)]['value'] = $tv;
            $template['data']['keyword'.($tk+1)]['color'] = "#1D367A";
        }
        $template['data']['remark']=array('value'=>$template['remark'],'color'=>"#666666");
        unset($template['remark']);
        unset($template['keyword']);
        $json_template=json_encode($template);
        $url="https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token['access_token'];
        $res=http_request($url,urldecode($json_template));
        return json_decode($res,true);

}

/**
 * 发送短信函数
 * @param  [str] $mobile  [手机号]
 * @param  [str] $content [内容]
 * @return [arr]          [返回值]
 */

function sendNote($mobile='',$content='',$type = ''){
    $ntc=C('SYSTEM_NOTE');
    // 控制24小时内发送短信条数在100条内【
    $sendcach = S(C('CACHE_FIX').'mobile'.$mobile);
    if($sendcach){
        if(time()<=$sendcach['time']+(24*3600)){
            if($sendcach['count']>100){
                return array('status'=>0,'info'=>'发送短信过于频繁，请24小时候在试');
                break;
            }
        }else{
            $sendcach['time'] = time();
            $sendcach['count'] = 0;
        }
    }else{
        $sendcach = array(
            'time'=>time(),
            'count'=>0
        );
    }
    // 控制24小时内发送短信条数在100条内】
    if (empty($ntc)) {
        //return array('status'=>0,'info'=>'未配置短信接口，无法发送短信');
        //break;
    }elseif ($mobile=='') {
        return array('status'=>0,'info'=>'手机号未填写');
        break;
    }elseif ($content=='') {
        return array('status'=>0,'info'=>'内容不能为空');
        break;
    }
    $http = 'http://api.wxduanxin.com/';
    $data = array(
        'ac'=>'send',
        'uid'=>$ntc['uid'],                    //用户账号
        'pwd'=>strtolower(md5($ntc['pwd'])),   //MD5位32密码
        'mobile'=>$mobile,              //号码
        'content'=>urlencode($content),            //内容
        'time'=>'',     //定时发送
        );

    $dataAA['product'] = '首玺拍卖网' ;
    $dataAA['code'] = $content ;
    $re= postSMSB($mobile,$dataAA,$type);       //POST方式提交

    if( trim($re) == '100' ){
        $sendcach['count'] +=1;
        S(C('CACHE_FIX').'mobile'.$mobile,$sendcach);
        return array('status'=>1,'info'=>'发送成功');
    }else{
        switch (trim($re)) {
            case '101':
                return array('status'=>0,'info'=>'验证失败');
                break;
            case '102':
                return array('status'=>0,'info'=>'短信不足');
                break;
            case '103':
                return array('status'=>0,'info'=>'操作失败');
                break;
            case '104':
                return array('status'=>0,'info'=>'非法字符');
                break;
            case '105':
                return array('status'=>0,'info'=>'内容过多');
                break;
            case '106':
                return array('status'=>0,'info'=>'号码过多');
                break;
            case '107':
                return array('status'=>0,'info'=>'频率过快');
                break;
            case '108':
                return array('status'=>0,'info'=>'号码内容空');
                break;
            case '109':
                return array('status'=>0,'info'=>'账号冻结');
                break;
            case '110':
                return array('status'=>0,'info'=>'禁止频繁单条发送');
                break;
            case '111':
                return array('status'=>0,'info'=>'系统暂定发送');
                break;
            case '112':
                return array('status'=>0,'info'=>'号码不正确');
                break;
            case '120':
                return array('status'=>0,'info'=>'系统升级');
                break;
            default:
                return array('status'=>0,'info'=>'短信接口配置错误');
                break;
        }
    }
}


function postSMSB($mobile,$code,$which){
    $ff =new Aliyunsms();
    $com  = '首玺拍卖';

    // if(!preg_match_all("/13[1235690]{1}\d{8}|15[1235689]\d{8}|188\d{8}/",$mobile)){
    //     return 112;
    // }
    // 
    
    // if(strlen($mobile)!=11){
    //     return 112;
    // }

    $gg = $ff->sendSms($mobile,$code,$which,$com);

    if($gg){
        return 100;
    }else{
        return 120;
    }
}

function postSMS($url,$data=''){
    $row = parse_url($url);
    $host = $row['host'];
    $port = $row['port'] ? $row['port']:80;
    $file = $row['path'];
    while (list($k,$v) = each($data))
    {
        $post .= rawurlencode($k)."=".rawurlencode($v)."&"; //转URL标准码
    }
    $post = substr( $post , 0 , -1 );
    $len = strlen($post);
    $fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
    if (!$fp) {
        return "$errstr ($errno)\n";
    } else {
        $receive = '';
        $out = "POST $file HTTP/1.0\r\n";
        $out .= "Host: $host\r\n";
        $out .= "Content-type: application/x-www-form-urlencoded\r\n";
        $out .= "Connection: Close\r\n";
        $out .= "Content-Length: $len\r\n\r\n";
        $out .= $post;
        fwrite($fp, $out);
        while (!feof($fp)) {
            $receive .= fgets($fp, 128);
        }
        fclose($fp);
        $receive = explode("\r\n\r\n",$receive);
        unset($receive[0]);
        return implode("",$receive);
    }
}

/**
 * 生成拍卖|申购状态条件
 * @param  [str] $typ [传入get值]
 * @return [array]      [返回条件和模板用的的值]
 */
function bidType($typ,$who){
    $nowTime=time();
    switch ($typ) {
        case 'biding':
            $bidtype = array('starttime'=>array('elt',$nowTime),'endtime'=>array('egt',$nowTime));
            switch ($who) {
                case 1:
                    $saytyp['ch']='已开拍专场';
                    break;
                case 2:
                    $saytyp['ch']='已开拍拍卖会';
                    break;
                case 3:
                    $saytyp['ch']='正在申购';
                    break;
                default:
                    $saytyp['ch']='正在拍卖';
                    break;
            }
            $saytyp['get']='biding';
            break;
        case 'bidend':            
            if(MODULE_NAME=='Home'){
                $bidtype['support_money']=array('gt',0);
            }
            $bidtype['endtime']=array('lt',$nowTime);
            switch ($who) {
                case 1:
                    $saytyp['ch']='已结束专场';
                    break;
                case 2:
                    $saytyp['ch']='已结束拍卖会';
                    break;
                case 3:
                    $saytyp['ch']='已结束申购';
                    break;
                default:
                    $saytyp['ch']='已结束拍卖';
                    break;
            }
            $saytyp['get']='bidend';
            break;
        case 'future':
            $bidtype = array('starttime'=>array('gt',$nowTime));
            switch ($who) {
                case 1:
                    $saytyp['ch']='未开拍专场';
                    break;
                case 2:
                    $saytyp['ch']='未开拍卖会';
                    break;
                case 3:
                    $saytyp['ch']='未开始申购';
                    break;
                default:
                    $saytyp['ch']='未开始拍卖';
                    break;
            }
            $saytyp['get']='future';
            break;
    }
    return array('bidType'=>$bidtype,'saytyp'=>$saytyp) ;
}


// 秒转换分秒
function conversionM_S($s){
    if($s>0){
        $minute =  (int)($s/60);
        $second = $s%60;
        if($minute!=0){$conversion =$minute.'分钟';}
        if($second!=0){$conversion .=$second.'秒';}
    }else{
        $conversion=0;
    }
    return $conversion;
}
// 支付成功解冻保证金
function payBidUnfreeze($orderNo,$paytype=0){
    // 解冻保证金---------------------------------------------------------------
    if($paytype==0){
        $msg = '(在线)支付拍品订单';
    }else{
        $msg = '(线下)支付拍品订单';
    }
    $order = M('Goods_order');
    $auction = M('Auction');
    $g_u =M('Goods_user');
    $oInfo = $order->where(array('order_no'=>$orderNo))->find();
    // 设置订单为已支付
    $order->where(array('order_no'=>$orderNo))->setField(array('status'=>1,'remark'=>'已支付我们会尽快安排发货'));
    $bidinfo = M('Auction')->where(array('pid'=>$oInfo['gid']))->find();
    $rsh = '';
    // 专场还是单品拍的条件
    if($bidinfo['sid']!=0){
        $special = M('special_auction')->where(array('sid'=>$bidinfo['sid']))->find();
        // 专场扣除模式且专场已结束
        if($special['special_pledge_type']==0&&$special['endtime']<=time()){
            // 专场拍品的pid集合
            $spidarr = $auction->where(array('sid'=>$bidinfo['sid']))->getField('pid',true);
            // 是否全部支付
            $paystaw = array(
                'uid'=>$oInfo['uid'],
                'gid'=>array('in',$spidarr),
                'status'=>0
            );
            // 全部支付的话进行退还
            $paysize = $order->where($paystaw)->count();
            if($paysize==0){
               $rsh.='解冻缴纳专场';
               $greezwhere = array('g-u'=>'s-u','uid'=>$oInfo['uid'],'gid'=>$bidinfo['sid'],'status'=>0);
               // 未全部支付跳出退还保证金 
            }else{
                return false;
            }
        }else{
           $rsh.='解冻缴纳拍品';
           $greezwhere = array('g-u'=>'p-u','uid'=>$oInfo['uid'],'gid'=>$oInfo['gid'],'status'=>0); 
        }
    }else{
        $rsh.='解冻缴纳拍品';
        $greezwhere = array('g-u'=>'p-u','uid'=>$oInfo['uid'],'gid'=>$oInfo['gid'],'status'=>0);
    }

    // 返还冻结保证金和信用额度
    $gfeez = $g_u->where($greezwhere)->find();
    if ($gfeez['status']==0) {
        // 解冻
        $m = M('member');
        $wr = array('uid'=>$gfeez['uid']);
        $freeze = $m->where($wr)->getField('wallet_pledge_freeze');
        //解冻保证金
        if($gfeez['pledge']>0){
           if($m->where($wr)->setDec('wallet_pledge_freeze',$gfeez['pledge'])){
                // 设置状态为已解冻
                $gudata = array('rtime'=>time(),'status'=>1);
                
                $pledge_data = array(
                    'order_no'=>$orderNo,
                    'uid'=>$gfeez['uid'],
                    'changetype'=>'paybid_unfreeze',
                    'time'=>time(),
                    'annotation'=>'按时'.$msg.'<a href="'.U('Home/Auction/details',array('pid'=>$bidinfo['pid'],'aptitude'=>1)).'">【'.$bidinfo['pname'].'】</a>',
                    'income'=>$gfeez['pledge']
                    );
                if(M('member_pledge_bill')->add($pledge_data)){
                    // 给用户发消息
                    sendSms($pledge_data['uid'],'保证金解冻',$pledge_data['annotation'].$rsh.'保证金'.$gfeez['pledge'].'元');
                } //写入用户账户记录
            } 
            $rs = $rsh.'保证金：<strong>'.$gfeez['pledge'].'</strong>;';
        }
        //解冻信用额度
        if($gfeez['limsum']>0){
            if($m->where($wr)->setDec('wallet_limsum_freeze',$gfeez['limsum'])){
                // 设置状态为已解冻
                $gudata = array('rtime'=>time(),'status'=>1);
                
                $limsum_data = array(
                    'order_no'=>$orderNo,
                    'uid'=>$gfeez['uid'],
                    'changetype'=>'paybid_unfreeze',
                    'time'=>time(),
                    'annotation'=>'按时'.$msg.'<a href="'.U('Home/Auction/details',array('pid'=>$bidinfo['pid'],'aptitude'=>1)).'">【'.$bidinfo['pname'].'】</a>',
                    'income'=>$gfeez['limsum']
                    );
                if(M('member_limsum_bill')->add($limsum_data)){
                    // 给用户发消息
                    sendSms($limsum_data['uid'],'信用额度解冻',$limsum_data['annotation'].$rsh.'信誉额度'.$gfeez['limsum'].'元');
                } //写入用户账户记录
            }
            $rs = $rsh.'信用额度：<strong>'.$gfeez['limsum'].'</strong>;';
        }
        if ($gudata) {
            $g_u->where($greezwhere)->save($gudata);
        }
        return $rs;
    }else{
        return '系统出错';
    }
    // 解冻保证金end------------------------------------------------------------
}
// 转换佣金
function perbroker($btype,$mn,$per){
    if($btype=='ratio'){
       return round($mn*($per/100),2); 
    }else{
        return $per;
    }
    
}
// 根据商品状态退还保证金
function return_pledge($gid,$sid=0,$uid=0,$endtype = 0){
    $gu='p-u';
    $info = M('Auction')->where(array('pid'=>$gid))->find();
    if($endtype==1){
        $etmsg='结束';
    }elseif($endtype==2){
        $etmsg='流拍';
    }elseif($endtype==3){
        $etmsg='无人出价流拍';
    }elseif($endtype==4){
        $etmsg='撤拍';
    }
    $remark = '拍品结束【<a  target="_blank" href="'.U('Home/Auction/details',array('pid'=>$gid,'aptitude'=>1)).'">'.$info['pname'].'</a>】'.$etmsg;
    $goods_user = M('Goods_user');
    // 如果属于专场拍卖拍品
    if($sid){
        // 如果拍品属于专场且为专场扣除模式的话，需要专场结束解冻没有竞价成功的
        $special = M('special_auction')->where(array('sid'=>$sid))->find();
        if($special&&$special['special_pledge_type']==0){
            // 专场拍品是否都已经结束
            $specount = M('auction')->where(array('sid'=>$sid))->count();
            $endcount = M('auction')->where(array('sid'=>$sid,'endtime'=>array('elt',time()),'endstatus'=>array('neq',0)))->count();
            // 获取专场成交者uid
            $succuid = M('auction')->where(array('sid'=>$sid,'endtime'=>array('elt',time()),'endstatus'=>array('neq',0)))->getField('uid',true);
            if($specount==$endcount){
                $fwhere = array('gid'=>$sid,'g-u'=>'s-u','status'=>0);
                $remark = '专场【<a  target="_blank" href="'.U('Home/Special/speul',array('sid'=>$sid)).'">'.$special['sname'].'</a>】结束,拍品【<a  target="_blank" href="'.U('Home/Auction/details',array('pid'=>$info['pid'])).'">'.$info['pname'].'</a>】'.$etmsg;
            }else{
                // 专场时间未结束退出退还保证金程序
                return;
            }
        }else{
           $succuid=array($uid);
            $fwhere = array('gid'=>$gid,'g-u'=>'p-u','status'=>0);
        }
    }else{
        $succuid=array($uid);
        $fwhere = array('gid'=>$gid,'g-u'=>'p-u','status'=>0);
    }

// ------------------------------------------------------------
    // 退还除成交者以外用户交纳的保证金
    // 本次拍品交纳的列表
    $member = M('member');
    $fezlist = $goods_user->where($fwhere)->select();
    foreach ($fezlist as $flk => $flv) {
        // 如果不是流拍和撤拍
        if(!in_array($endtype,array('2','3','4'))){
            // 当前用户为竞拍成功者则不进行扣除保证金流程
            if(in_array($flv['uid'], $succuid)){ 
                continue;
            }
        }
        // -------------------------------
        $wr = array('uid'=>$flv['uid']);
        $freeze = $member->where($wr)->getField('wallet_pledge_freeze');
        //解冻保证金
        $thisFrW=array('gid'=>$flv['gid'],'uid'=>$flv['uid']);
        if($flv['pledge']>0){
            if($member->where($wr)->setDec('wallet_pledge_freeze',$flv['pledge'])){
                // 设置状态为已解冻
                $gudata = array('rtime'=>time(),'status'=>1);
                // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                $pledge_data = array(
                    'order_no'=>createNo('guf'),
                    'uid'=>$flv['uid'],
                    'changetype'=>'bid_unfreeze',
                    'time'=>time(),
                    'annotation'=>$remark,
                    'income'=>$flv['pledge'],
                    );
                $pledge_status = M('member_pledge_bill')->add($pledge_data);
            } 
        }
        //解冻信用额度
        if($flv['limsum']>0){
            if($member->where($wr)->setDec('wallet_limsum_freeze',$flv['limsum'])){
                // 设置状态为已解冻
                $gudata = array('rtime'=>time(),'status'=>1);
                // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                $limsum_data = array(
                    'order_no'=>createNo('guf'),
                    'uid'=>$flv['uid'],
                    'changetype'=>'bid_unfreeze',
                    'time'=>time(),
                    'annotation'=>$remark,
                    'income'=>$flv['limsum'],
                    );
                $limsum_status = M('member_limsum_bill')->add($limsum_data);
                
            }
        }
        if($pledge_status||$limsum_status){
            // 设置为已解冻
            $goods_user->where($thisFrW)->save($gudata);
        // 发送提醒消息【
            // 微信模板消息
            $remark = '';
            if($pledge_data['income']){
                $remark .= '解冻保证金'.$pledge_data['income'].'元；';
            }
            if($limsum_data['income']){
                $remark .= '解冻信誉额度'.$limsum_data['income'].'元；';
            }
            // 站内信提醒内容
            $webmsg = array(
                'title'=>'保证金解冻',
                'content'=>$remark
                );
            // 微信模板消息
            $weimsg['tpl'] = 'bidstatus';
            $weimsg['msg']=array(
                "url"=>U('Home/Auction/details',array('pid'=>$info['pid']),'html',true), 
                "first"=>'您好，拍卖'.$etmsg.'，未拍到拍品'.$remark,
                "remark"=>'拍卖'.$etmsg.'，点击查看>>',
                "keyword"=>array($info['pname'],$info['nowprice'].'元【当前价】',$etmsg,date('y年m月d日 H:i',$info['endtime']).'【结束】',percent($info['pledge_type'],$info['onset'],$info['pledge']).'元'),
            );
            // 短信提醒内容
            if(mb_strlen($info['pname'],'utf-8')>15){
                $newname = mb_substr($info['pname'],0,15,'utf-8').'...';
            }else{
                $newname = $info['pname'];
            }
            // 短信提醒内容
            $notemsg = '拍品“'.$newname.'”'.$etmsg.'，保证金已解冻，您可以登陆网站查询详情';
            // 邮箱提醒内容
            $mailmsg['title'] = "【".$etmsg."提醒】";
            $mailmsg['msg'] = '您好：<br/><p>拍品“<a target="_blank" href="'.U('Home/Auction/details',array('pid'=>$info['pid'],'aptitude'=>1),'html',true).'">'.$info['pname'].'</a>”'.$etmsg.'！</p><p><a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆查看详情！</a></p>';
            // 发送消息函数
            sendRemind($member,M('member_weixin'),$info,array($flv['uid']),$webmsg,$weimsg,$notemsg,$mailmsg);
        // 发送提醒消息】
        }
        
    // -------------------------------
    }
}
// 解冻卖家每件拍卖冻结的保证金
//$from auction | auction_audit
function unfreeze_seller_pledge($sellerid, $pid, $act, $from = 'auction'){
    $member = M('member');
    $seller_pledge = M('seller_pledge');
    $gfeez = $seller_pledge->where(array('sellerid'=>$sellerid,'pid'=>$pid,'status'=>1, 'from' => $from))->find();
    // 不是一次扣除永久发布的话进行退还卖家保证金
    if($gfeez['type']!='disposable'){
        $bidinfo = M($from)->where(array('pid'=>$pid))->find();
        $changetype = 'add_unfreeze';
        switch ($act) {
            case 'del':
                $etmsg = '删除';
                break;
            case 'cancel':
                $etmsg = '撤拍';
                break;
            case 'break':
                $etmsg = '买家未按时支付';
                break;
            case 'success':
                $etmsg = '买家确认收到';
                $changetype = 'payadd_unfreeze';
                break;
            case 'abortive':
                $etmsg = '拍品流拍';
                break;
            case 'audit_reject':
                $etmsg = '拍卖审核拒绝';
                break;
        }
        if($info['from'] == 'auction') {
            $annotation = $etmsg.'<a href="'.U('Home/Auction/details',array('pid'=>$bidinfo['pid'],'aptitude'=>1)).'">【'.$bidinfo['pname'].'】</a>';
        } else {
            $annotation = $etmsg.'【'.$bidinfo['pname'].'】';
        }

        $mwhere = array('uid'=>$gfeez['sellerid']);
        $orderNo = createNo('auf');
        if($gfeez['pledge']>0){
           if($member->where($mwhere)->setDec('wallet_pledge_freeze',$gfeez['pledge'])){
                $pledge_data = array(
                    'order_no'=>$orderNo,
                    'uid'=>$gfeez['sellerid'],
                    'changetype'=>$changetype,
                    'time'=>time(),
                    'annotation'=>$annotation,
                    'income'=>$gfeez['pledge'],
                    );
                $pledge_status = M('member_pledge_bill')->add($pledge_data);
            } 
        }
        //解冻信用额度
        if($gfeez['limsum']>0){
            if($member->where($mwhere)->setDec('wallet_limsum_freeze',$gfeez['limsum'])){
                
                $limsum_data = array(
                    'order_no'=>$orderNo,
                    'uid'=>$gfeez['sellerid'],
                    'changetype'=>$changetype,
                    'time'=>time(),
                    'annotation'=>$annotation,
                    'income'=>$gfeez['limsum']
                    );
                $limsum_status = M('member_limsum_bill')->add($limsum_data);
            }
        }
        if($pledge_status||$limsum_status){
            $seller_pledge->where(array('id'=>$gfeez['id']))->setField('status',0);
            $wallet = $member->where(array('uid'=>$sellerid))->field('wallet_pledge,wallet_pledge_freeze,wallet_limsum,wallet_limsum_freeze')->find();
            if ($pledge_status) {
                $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
            // 退还卖家保证金提醒【
                // 微信提醒内容
                $wei_profit['tpl'] = 'walletchange';
                $wei_profit['msg']=array(
                    "url"=>U('Home/Member/pledge','','html',true), 
                    "first"=>"您好，".$etmsg.'“'.$bidinfo['pname'].'”，退还保证金！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('余额账户','解冻保证金','单号:'.$orderNo,'+'.$pledge_data['income'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_profit = array(
                    'title'=>'解冻保证金',
                    'content'=>$pledge_data['annotation'].'解冻保证金'.$pledge_data['income'].'元！'
                    );
                // 短信提醒内容
                if(mb_strlen($bidinfo['pname'],'utf-8')>10){
                    $newname = mb_substr($bidinfo['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidinfo['pname'];
                }
                $note_profit = $etmsg.'：拍品“'.$newname.'”。解冻保证金【'.$pledge_data['income'].'元】，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_profit['title'] = $etmsg.'“'.$newname.'”';
                $mail_profit['msg'] = '您好：<br/><p>'.$web_profit['content'].'，解冻保证金：'.$pledge_data['income'].'元。</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';

                sendRemind($member,M('Member_weixin'),array(),array($sellerid),$web_profit,$wei_profit,$note_profit,$mail_profit,'sel');
            // 退还卖家保证金提醒【
            }
            if ($limsum_status) {
                $usable = $wallet['wallet_limsum']-$wallet['wallet_limsum_freeze'];
            // 退还卖家信誉提醒【
                // 微信提醒内容
                $wei_profit['tpl'] = 'walletchange';
                $wei_profit['msg']=array(
                    "url"=>U('Home/Member/limsum','','html',true), 
                    "first"=>"您好，".$etmsg.'“'.$bidinfo['pname'].'”，退还信誉！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('余额账户','解冻信誉','单号:'.$orderNo,'+'.$limsum_data['income'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_profit = array(
                    'title'=>'解冻信誉',
                    'content'=>$limsum_data['annotation'].'解冻信誉'.$limsum_data['income'].'元！'
                    );
                // 短信提醒内容
                if(mb_strlen($bidinfo['pname'],'utf-8')>10){
                    $newname = mb_substr($bidinfo['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidinfo['pname'];
                }
                $note_profit = $etmsg.'：拍品“'.$newname.'”。解冻信誉【'.$limsum_data['income'].'元】，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_profit['title'] = $etmsg.'“'.$newname.'”';
                $mail_profit['msg'] = '您好：<br/><p>'.$web_profit['content'].'，解冻信誉：'.$limsum_data['income'].'元。</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';

                sendRemind($member,M('Member_weixin'),array(),array($sellerid),$web_profit,$wei_profit,$note_profit,$mail_profit,'sel');
            // 退还卖家信誉提醒【
            }
        }
        return $smsdata;
    }

}


// 拍卖状态
function endstatus_ch($endstatus){
    switch ($endstatus) {
        case '0':
            return '正在拍卖';
            break;
        case '1':
            return '成交';
            break;
        case '2':
            return '流拍';
            break;
        case '3':
            return '无人出价流拍';
            break;
        case '4':
            return '撤拍';
            break;
        default:
            return '删除';
            break;
    }
}


// 判断是手机登陆还是PC登陆
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
 }
 // $type=1(只访问电脑版)
 function defineView($type){
    if($type==1){
        $data['view']='Web';
        $data['mobile'] = 0;
    }if($type==2){
        $data['view']='Wap';
        $data['mobile'] = 1;
    }else{
        $data=array();
        if(ismobile()){
            $data['view']='Wap';
            $data['mobile'] = 1;
        }else{
            $data['view']='Web';
            $data['mobile'] = 0;
        }
    }
    return $data;
 }
// 读取广告位数据
function getAdvData($tagname){
    $advertising_position = M('Advertising_position');
    $advertising = M('Advertising');
    $adv_postmap['tagname'] = array('eq',$tagname);
    $ap= $advertising_position->where($adv_postmap)->find();
    $now=time();
    $advmap['status'] = array('eq',1);
    $advmap['pid'] = array('eq',$ap['id']);
    $advmap['_string'] = "((adv_start_time <='".$now."' and adv_end_time >='".$now."') or (adv_start_time =0 and adv_end_time = 0 ) or (adv_start_time <='".$now."' and adv_end_time = 0 ) or (adv_start_time =0 and adv_end_time >='".$now."' ))";
    $adv_list = $advertising->where($advmap)->order('sort desc,id asc')->select();
    return array('adv_list'=>$adv_list,'ap'=>$ap);
}
function get_by_curl($url,$post = false){
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if($post){
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    }
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
// 获取wap链接地址
function getwapurl($url){
    $tempu=parse_url($url);  
    $nurl=$tempu['host']; 
    if($nurl){
        $plc = str_replace('/', '', str_replace('http://', '', C('WEB_ROOT')));
        $tourl = str_replace($nurl,$plc, $url);
    }else{
        $tourl = '网址格式不对';
    }
    return $tourl;
}
// 根据用户头像多平台登陆获取用户头像地址
// $size 1 大 2中 3小
function getUserpic($uid,$size){
    $avatar = M('member')->where(array('uid'=>$uid))->getField('avatar');
    if($avatar=='headimgurl'){
        $headimgurl = M('member_weixin')->where(array('uid'=>$uid))->getField('headimgurl');
        if($headimgurl!=''){
            switch ($size) {
                case 1:$sz = 0;break;
                case 2:$sz = 132;break;
                case 3:$sz = 96;break;
                default:$sz = 64;break;
            }
            $imgurl = getWeipic($headimgurl,$sz);
        }else{
           $imgurl =  C('WEB_ROOT').'Public/Home/Img/default_2.gif';
        }
    }else{
        if($avatar!=''){
            $imgurl = __ROOT__.trim(C('UPLOADS_PICPATH'),'.').picRep($avatar,$size,'user');
        }else{
           $imgurl =  C('WEB_ROOT').'Public/Home/Img/default_2.gif';
        }
    }
    return $imgurl;
}
// 生成用户头像地址
// max_0,mid_130,mini_64
// 用户头像，最后一个数值代表正方形头像大小（有0、46、64、96、132数值可选，0代表640*640正方形头像）
// 用户没有头像时该项为空。若用户更换头像，原有头像URL将失效。

function getWeipic($url,$size){
    if($size==0){
        $rt = $url;
    }else{
        $ea = 'http://wx.qlogo.cn/mmopen/';
        $hdstr = str_replace($ea, '', $url);
        $nhdarr = explode('/', $hdstr);
        $eb = $nhdarr[0];
        $ec = $size;
        $rt = $ea.$eb.'/'.$ec;
    }
    return $rt;
}


// 数组排序
//     SORT_ASC - 默认，按升序排列。(A-Z)
//     SORT_DESC - 按降序排列。(Z-A)
// 随后可以指定排序的类型：
//     SORT_REGULAR - 默认。将每一项按常规顺序排列。
//     SORT_NUMERIC - 将每一项按数字顺序排列。
//     SORT_STRING - 将每一项按字母顺序排列
// $person = my_sort($person,'id',SORT_DESC,SORT_NUMERIC);pre($person);
function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){   
    if(is_array($arrays)){   
        foreach ($arrays as $array){   
            if(is_array($array)){   
                $key_arrays[] = $array[$sort_key];   
            }else{   
                return false;   
            }   
        }   
    }else{
        return false;   
    }  
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);   
    return $arrays;   
}  

// 格式化数字删除后多余0例：1.00=1
function wipezero($num){
    $num = strrev((float)sprintf("%.2f",$num));
    $num = strrev($num);
    return $num;
}

function echojson($code){
    header('Content-Type:application/json; charset=utf-8');
    echo json_encode($code);
}
// 快递查询接口
    function getExpressHtml($typeCom,$typeNu){
        $port = C('EXPRESS');
        if($port['id']!=''&&$port['key']!=''){
            $ebusinessid = $port['id'];
            $key = $port['key'];
            $requrl = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
        }else{
            $ebusinessid = '1237100';
            $key = '518a73d8-1f7f-441a-b644-33e77b49d846';
            $requrl = 'http://api.kdniao.cc:8081/Ebusiness/EbusinessOrderHandle.aspx';
        }
        $requestData= "{'OrderCode':'','ShipperCode':'".$typeCom."','LogisticCode':'".$typeNu."'}";
        $datas = array(
            'EBusinessID' => $ebusinessid,
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = createsig($requestData, $key);
        $result=sendPost($requrl, $datas);   
        $exdata = json_decode(strstr($result,'{'),true);

        if($exdata['Success']){
            $rthtml = '<ul class="result-tit clearfix"><li class="name">快递公司：'.M('express')->where(array('en'=>$exdata['ShipperCode']))->getField('ch').'</li>';
            $rthtml .='<li class="numb">快递单号：'.$typeNu.'</li></ul>';
            $rthtml .= '<div class="result-tbbox"><div class="result-top"><span class="col1">时间</span><span class="col2">地点和跟踪进度</span></div><table cellspacing="0" class="result-info2" id="queryResult2"><tbody>';
            $count = count($exdata['Traces']);
            foreach ($exdata['Traces'] as $tk => $tv) {
                $rthtml.='<tr><td class="row1">';
                $rthtml.=$tv['AcceptTime'];
                $rthtml.='</td><td class="status ';
                if($tk==0){
                    $rthtml.='status-first';
                }else{
                    if($tk==$count-1){
                        if($exdata['State']==3){
                            $rthtml.='status-check';
                        }else{
                            $rthtml.='status-wait';
                        }
                    }
                }
                $rthtml.='">&nbsp;</td>';
                $rthtml.='<td>'.$tv['AcceptStation'].'</td></tr>';
            }
            $rthtml .='</tbody></table></div>';
            $rt = array('status'=>1,'html'=>$rthtml);
        }else{
            $rt = array('status'=>0,'html'=>$exdata['Reason']);
        }
        return $rt;
    }
    /**
     *  post提交数据 
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据 
     * @return url响应返回的html
     */
    function sendPost($url, $datas) {
        $temps = array();   
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);      
        }   
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], 80);
        fwrite($fd, $httpheader);
        $gets = "";
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容   
     * @param appkey Appkey
     * @return DataSign签名
     */
    function createsig($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }
// 快递公司select
    function expressCompany(){
        $express = M('express');
        $letter = explode('|', 'A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|W|X|Y|Z');
        $com = $express->where(array('status'=>2))->order('sort desc')->select();
        if($com){
            $list['com'] = $com;
        }
        foreach ($letter as $lk => $lv) {
            $data = $express->where(array('letter'=>$lv,'status'=>0))->order('sort desc')->select();
            if($data){
                $list[$lv] = $data;
            }
        }
        return $list;
    }
    function object_array($array){
      if(is_object($array)){
        $array = (array)$array;
      }
      if(is_array($array)){
        foreach($array as $key=>$value){
          $array[$key] = object_array($value);
        }
      }
      return $array;
    }
// 账户变动类型获取
// 账户冻结  bid_freeze,admin_freeze,extract_freeze,add_freeze
// 账户解冻  bid_unfreeze,admin_unfreeze,extract,add_unfreeze,pay_pledge
// 账户增加  admin_deposit,pay_deposit,share_add,profit
// 账户减少  admin_deduct,pay_pledge,pay_deduct,extract
function changetype($type){
    switch ($type) {
        case 'bid_freeze':
            return '参拍冻结';
            break;
        case 'bid_unfreeze':
            return '未拍到解冻';
            break;
        case 'paybid_unfreeze':
            return '支付拍品订单解冻';
            break;
        case 'buy_break_nopay':
            return '订单过期扣除';
            break;
        case 'seller_break_nopay':
            return '订单过期收入';
            break;
        case 'admin_deposit':
            return '管理员充值';
            break;
        case 'admin_deduct':
            return '管理员扣除';
            break;
        case 'admin_freeze':
            return '管理员冻结';
            break;
        case 'admin_unfreeze':
            return '管理员解冻';
            break;
        case 'pay_deposit':
            return '在线充值';
            break;
        case 'pay_pledge':
            return '保证金抵货款';
            break;
        case 'pay_deduct':
            return '支付扣除余额';
            break;
        case 'extract':
            return '提现扣除';
            break;
        case 'extract_freeze':
            return '提现冻结';
            break;
        case 'share_add':
            return '分享奖励';
            break;
        case 'add_freeze':
            return '发布拍卖冻结';
            break;
        case 'add_unfreeze':
            return '未卖出解冻';
            break;
        case 'payadd_unfreeze':
            return '交易成功解冻';
            break;
        case 'seller_break_deliver':
            return '未按时发货扣除';
            break;
        case 'buy_break_deliver':
            return '未按时发货收入';
            break;
        case 'profit':
            return '交易收入';
            break;
        case 'all':
            return array(
                'bid_freeze'=>'参拍冻结','bid_unfreeze'=>'未拍到解冻','paybid_unfreeze'=>'支付拍品订单解冻',
                'buy_break_nopay'=>'订单过期扣除','seller_break_nopay'=>'订单过期收入',
                'admin_deposit'=>'管理员充值','admin_deduct'=>'管理员扣除','admin_freeze'=>'管理员冻结','admin_unfreeze'=>'管理员解冻','pay_deposit'=>'在线充值',
                'pay_pledge'=>'保证金抵货款','pay_deduct'=>'支付扣除余额','extract'=>'提现扣除','extract_freeze'=>'提现冻结',
                'share_add'=>'分享奖励',
                'add_freeze'=>'发布拍卖冻结','add_unfreeze'=>'未卖出解冻','payadd_unfreeze'=>'交易成功解冻',
                'seller_break_deliver'=>'未按时发货扣除','buy_break_deliver'=>'未按时发货收入',
                'profit'=>'交易收入'
                );
            break;
    }
}
// 账户扣除冻结的条件
function increase_freeze_where(){
    return array('changetype'=>array('in',array('pay_pledge','extract','buy_break_nopay','seller_break_deliver')));
}
// 账户解冻条件
function unfreeze_where(){
    return array('changetype'=>array('in',array('bid_unfreeze','paybid_unfreeze','admin_unfreeze','add_unfreeze','payadd_unfreeze')));
}
// 账户冻结条件
function freeze_where(){
    return array('changetype'=>array('in',array('bid_freeze','admin_freeze','extract_freeze','add_freeze')));
}
// 账户减少条件
function reduce_where(){
    return array('changetype'=>array('in',array('admin_deduct','pay_deduct')));
}
// 账户增加条件
function increase_where(){
    return array('changetype'=>array('in',array('admin_deposit','pay_deposit','share_add','profit','seller_break_nopay','buy_break_deliver')));
}
// 账户变动类型获取
function sharename($en){
    switch ($en) {
        case 'Timeline':
            return '微信朋友圈';
            break;
        case 'AppMessage':
            return '微信好友';
            break;
        case 'QQ':
            return 'QQ';
            break;
        case 'QZone':
            return 'QQ空间';
            break;
        case 'Weibo':
            return '微博';
            break;
    }
}
    
// 移动版域名
function wapdomain(){
    $tempu=parse_url(C('WEB_ROOT'));
    return $tempu['port']?$tempu['host'].':'.$tempu['port']:$tempu['host'];
}
// 电脑版域名
function webdomain(){
    $tempu=parse_url(C('WEB_ROOT'));
    return $tempu['port']?$tempu['host'].':'.$tempu['port']:$tempu['host'];
}
// 判断微信浏览器
function is_weixin(){
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }else{
        return false;
    }
}
//获取当前页面完整URL地址
function get_url() {
    $sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
}
function getJson($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}

// 通过分类cid生成扩展字段html
function getExtendsHtml($cid,$gid){
    $extend = M('Goods_extend');
    $cate = M('Goods_category');
    $cLinkE =M('goods_category_extend');

    $cate->where('cid='.$cid)->getField('pid');
    $interimCid = $cid; //临时存放cid
    $catPath = array($cid); //用来保存分类路径的cid
    do {
         $interimCid = $cate->where('cid='.$interimCid)->getField('pid');
         if($interimCid !=0){
            $catPath[] = $interimCid ;
         }
    } while ( $interimCid !=0 );
    $catPath = array_reverse($catPath); //获取分类路径id数组
    $eHtmlUl = '';
    $eHtmlDiv = '';
    $textarea = array();
    $goods_fields = M('goods_fields');
    $regWhere = array(
        array('cid'=>array('in',$catPath)),
        array('eid'=>0)
        );

    if($cLinkE->where($regWhere)->count()){
        $region = C('goods_region'); //判断是否关联地区
    }else{
        $region = 'no';
    }
    foreach ($catPath as $lk => $lv) {
        $eidArr = $cLinkE->where('cid='.$lv)->getField('eid',true);
        $eMap = $extend->where(array('eid'=>array('in',$eidArr),'status'=>1))->order('rank desc')->select();
        foreach ($eMap as $ek => $ev) {
            $rd='r'.rand(); //百度编辑器一个id只渲染一次，用随机数来区别。有没有几率碰到重复的？
            $textarea[] = $rd;
            $eHtmlUl .='<li class="ext" eid="'.$ev['eid'].'">'.$ev['name'].'</li>';
            //根据商品id是否存在，设置扩展字段默认值还是新值
            if($gid){
                $fieldVal=$goods_fields->where(array('eid'=>$ev['eid'],'gid'=>$gid))->getField('default');
            }else{
                $fieldVal=$ev['default'];
            }
            $eHtmlDiv .='<div class="hide ext" eid="'.$ev['eid'].'"><textarea id="'.$rd.'" name="extend['.$ev['eid'].']">'.stripslashes($fieldVal).'</textarea></div>';
        }
    }
    return array('eUrlHtml'=>$eHtmlUl,'eDivHtml'=>$eHtmlDiv,'textarea' =>$textarea,'region'=>$region);
}
/**
  +----------------------------------------------------------
 * 通过分类cid生成筛选条件html
  +----------------------------------------------------------
 * @param  [type] $cid     [分类id]
 * @param  [type] $filtStr [属性字符串]
 * @return [type]          [html]
   +----------------------------------------------------------
 */

function getFiltrateHtmlSeller($cid,$filtStr){
    $filtrate = M('Goods_filtrate');
    $cate = M('Goods_category');
    $cLinkF =M('Goods_category_filtrate');
    $filtArr = explode('_', $filtStr);
    $cate->where('cid='.$cid)->getField('pid');
    $interimCid = $cid; //临时存放cid
    $catPath = array($cid); //用来保存分类路径的cid
    do {
         $interimCid = $cate->where('cid='.$interimCid)->getField('pid');
         if($interimCid !=0){
            $catPath[] = $interimCid ;
         }
    } while ( $interimCid !=0 );

    $catPath = array_reverse($catPath); //获取分类路径id数组
    foreach ($catPath as $lk => $lv) {
        $fidArr = $cLinkF->where('cid='.$lv)->getField('fid',true);
        $filtMap = $filtrate->where(array('fid'=>array('in',$fidArr)))->order('sort desc')->select();
        $filtBoxClass = $lk == 0 ? 'sellfiltbox' : 'sellfiltbox child';  //除了顶级以外的样式
        if ($filtMap) {
            $filtHtml .= '<div class="'.$filtBoxClass.'">';
            foreach ($filtMap as $fk => $fv) {
                $filtHtml.='<ul class="clearfix">';
                $filtHtml.='<li><span>'.$fv['name'].':</span></li>';

                $filtHtml.='<li><a class="filtParent';
                if(empty($filtStr)||in_array($fv['fid'],$filtArr)){
                    $filtHtml.= ' current';
                }
                $filtHtml.= '" fid="'.$fv['fid'].'" href="javascript:void(0);">不限</a></li>';
                $childMap = $filtrate->where('pid='.$fv['fid'])->select();
                foreach ($childMap as $ck => $cv) {
                    $filtHtml.= '<li><a href="javascript:void(0);" fid="'.$cv['fid'].'" class="filtParent';
                    $display = 'none';
                    if(in_array($cv['fid'],$filtArr)){
                        $filtHtml.= ' current';
                        $display = 'block';
                    }
                    $filtHtml.='">'.$cv['name'].'</a></li>';
                    $childLi .= getChildHtmlSeller($cv['fid'],$display,$filtArr); //获取子类
                }
                $filtHtml.='</ul>';
                $filtHtml.=$childLi;
                $childLi = '';
                $display = 'none';
            }
            $filtHtml.='</div>';
    }
        }
    return $filtHtml;
}
    // 通过fid生成子级筛选条件html
function getChildHtmlSeller($fid,$display,$filtArr){
    if(countChild($fid)!=0){
        $childArr = M('Goods_filtrate')->where('pid='.$fid)->order('sort desc')->select();
        $childStr = '<div class="filtLi" style="display:'.$display.';" fid="'.$fid.'">';
        $childStr .='<ul class="clearfix filtChild">';
        foreach ($childArr as $ck => $cv) {
            $childStr .='<li><a class="filtParent';
            $displaySun = 'none';
            if(in_array($cv['fid'],$filtArr)){
                    $childStr.= ' current';
                    $displayCh = 'block';
                }else{
                    $displayCh = 'none';
                }
            $childStr.='" fid="'.$cv['fid'].'" href="javascript:void(0);">'.$cv['name'];
            if(countChild($cv['fid'])!=0){
                $childStr .= '('.countChild($cv['fid']).')';
            }
            $childStr .= '</a></li>';
            $childSun = getChildHtmlSeller($cv['fid'],$displayCh,$filtArr);  
        }
        $childStr .='</ul>';
        $childStr .=$childSun;
        $childStr .= '</div>';
        return $childStr;
    }
    return ;
}

// 获取卖家信用星星值
    function getstarval($evaluate,$where,$per){
        $eval_count = $evaluate->where($where)->count();
        $eval_conform = $evaluate->where($where)->sum('conform');
        $eval_service = $evaluate->where($where)->sum('service');
        $eval_express = $evaluate->where($where)->sum('express');
        $eval_all = $eval_conform+$eval_service+$eval_express;
        $eval_man = $eval_count*15;
        return round($eval_all/$eval_man*5);
    }
// 返回等级$buy=1买家等级
    function getlevel($score,$buy){
        if($buy==1){
            $level = C('buylevel');
        }else{
            $level = C('level');
        }
        $count = count($level);
        if($score!='max'){
            foreach ($level as $lk => $lv) {
                if($lk==0){
                    if($score<$lv['score_lt']){
                        $ico = $lv['ico'];
                        break;
                    }
                }elseif($lk==$count-1){
                    if($score>$lv['score_gt']){
                        $ico = $lv['ico'];
                        break;
                    }
                }else{
                    if($score>$lv['score_gt']&&$score<$lv['score_lt']){
                        $ico = $lv['ico'];
                        break;
                    }
                }
            }
        }else{
            $ico = $level[$count-1]['ico'];
        }
        return C('WEB_ROOT').$ico;
        
    }
// 获取用户账户信息
    function getwallet($uid){
        // 计算账户可用保证金和信誉额度
        $ufield=array('uid','wallet_pledge','wallet_pledge_freeze','wallet_limsum','wallet_limsum_freeze');
        $uLimit = M('member')->where('uid='.$uid)->field($ufield)->find();
        // 可用保证金
        $uLimit['pledge'] = $uLimit['wallet_pledge']-$uLimit['wallet_pledge_freeze'];
        $uLimit['pledge'] = $uLimit['pledge']>0?sprintf("%.2f", $uLimit['pledge']):0;
        // 可用信用额度
        $uLimit['limsum'] = $uLimit['wallet_limsum']-$uLimit['wallet_limsum_freeze'];
        $uLimit['limsum'] = $uLimit['limsum']>0?sprintf("%.2f", $uLimit['limsum']):0;
        // 可用共计
        $uLimit['count'] = $uLimit['pledge']+$uLimit['limsum'];
        return $uLimit;
    }

//获取卖家缴纳保证金方式
function sellpledgetype($type){
    switch ($type) {
        case 'disposable':
            return '一次性缴纳';
            break;
        case 'every':
            return '发布每件拍品缴纳';
            break;
        case 'proportion':
            return '按拍品起拍价比例';
            break;
        case 'all':
            return array('disposable'=>'一次性缴纳','every'=>'发布每件拍品缴纳','proportion'=>'按拍品起拍价比例');
            break;
    }
    
}

function http_request($url,$data=array()){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    // 我们在POST数据哦！
    curl_setopt($ch, CURLOPT_POST, 1);
    // 把post的变量加上
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}
// 处理浮动价格
function setStep($step_type,$step,$nowprice){
    if($step_type==0){
        $stparr = explode(',', $step);
        if($nowprice>=$stparr[2]){
            $rostep= (int)str_pad(1,strlen((int)$nowprice),0,STR_PAD_RIGHT)*((int)$stparr[0]/100);
            if($rostep>$stparr[3]){
               $rtstep = $stparr[3];
            }else{
               $rtstep = $rostep;
            }
        }else{
             $rtstep = $stparr[1];
        }
    }elseif($step_type==1){
      // 转换并不是整数
      $rtstep=floatval($step);
    }
    return wipezero($rtstep);
}
// 转换保证金
function percent($btype,$mn,$per){
    if($btype=='ratio'){
       return round($mn*($per/100),2); 
    }else{
        return $per;
    }
    
}
//功能：计算两个时间戳之间相差的日时分秒
//$begin_time 开始时间戳
//$end_time 结束时间戳
//$type 返回类型 str字符串 arr数组
function timediff($begin_time,$end_time,$type, $precise='sec'){
    if($begin_time < $end_time){
        $starttime = $begin_time;
        $endtime = $end_time;
    }else{
        $starttime = $end_time;
        $endtime = $begin_time;
    }
    //计算天数
    $timediff = $endtime-$starttime;
    $days = intval($timediff/86400);
    //计算小时数
    $remain = $timediff%86400;
    $hours = intval($remain/3600);
    //计算分钟数
    $remain = $remain%3600;
    $mins = intval($remain/60);
    //计算秒数
    $secs = $remain%60;
    if($type=='str'){
        $str = '';
        if ($days) {$str.=$days.'天';}
        if ($hours) {$str.=$hours.'小时';}
        if(in_array($precise, array('sec'))) {
            if ($mins) {$str.=$mins.'分';}
            $str.=$secs.'秒';
        }

        return $str;
    }else{
        return array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
    }
}


// 拍卖提醒用户
function sendRemind($member,$member_weixin,$info,$uidarr,$webmsg=array(),$weimsg,$notemsg,$mailmsg,$stype,$role){
    // 发送站内信【
    if($webmsg){
        foreach ($uidarr as $uk => $uv) {
            sendSms($uv,$webmsg['title'],$webmsg['content']);
        }
    }
    // 发送站内信】
    // 微信结束提醒【
    if(C('Weixin.appid')&&C('Weixin.appsecret')){
        // 设置微信提醒的用户uid集合
        $weiuid = $member->where(array('uid'=>array('in',$uidarr),'alerttype'=>array('LIKE', '%weixin%')))->getField('uid',true);
        // 设置微信提醒的用户openid集合
        $oidarr = $member_weixin->where(array('uid'=>array('in',$weiuid)))->field('uid,openid')->select();
        foreach ($oidarr as $opk => $opv) {
            $weimsg['msg']['touser'] = $opv['openid'];
            $rtsta = remind_msg($weimsg['tpl'],$weimsg['msg']);
            // 设置该用户已提醒
            if($rtsta['errcode']==0&&$stype!=''){
                M('scheduled')->where(array('pid'=>$info['pid'],'uid'=>$opv['uid'],'stype'=>$stype))->setField('time',time());
            }
        }
    }
    // 微信结束提醒】
    // 短信提醒【
    if(C('SYSTEM_NOTE')){
        // 设置微信提醒的用户uid集合
        $noteuid = $member->where(array('uid'=>array('in',$uidarr),'verify_mobile'=>1,'alerttype'=>array('LIKE', '%mebile%')))->field('uid,nickname,organization,mobile')->select();

        foreach ($noteuid as $nk => $nv) {
            if($role=='sel'){
                $uname = $noteuid['organization'];
            }else{
                $uname = $noteuid['nickname'];
            }
            $note = '尊敬的【'.$uname .'】，'.$notemsg;
            $notst = sendNote($noteuid['mebile'],$note);
            // 设置该用户已提醒
            if($notst['status']&&$stype!=''){
                M('scheduled')->where(array('pid'=>$info['pid'],'uid'=>$nv['uid'],'stype'=>$stype))->setField('time',time());
            }
        }
    }
    // 短信提醒】
    // 邮件提醒【
    if(C('SYSTEM_EMAIL')){
        // 设置微信提醒的用户uid集合
        $mailuid = $member->where(array('uid'=>array('in',$uidarr),'verify_email'=>1,'alerttype'=>array('LIKE', '%email%')))->field('uid,nickname,organization,email')->select();
        foreach ($mailuid as $mk => $mv) {
            if($role=='sel'){
                $uname = $noteuid['organization'];
            }else{
                $uname = $noteuid['nickname'];
            }
            $mail = '尊敬的【'.$uname.'】'.$mailmsg['msg'];
            $mailtst = send_mail($mv['email'], "", $mailmsg['title'], $mail, "", $_POST);
            // 设置该用户已提醒
            if($mailtst['status']&&$stype!=''){
                M('scheduled')->where(array('pid'=>$info['pid'],'uid'=>$mv['uid'],'stype'=>$stype))->setField('time',time());
            }
        }
    }
    // 邮件提醒】
}

// 订单状态提醒
function sendOrderRemind($order_no) {
    $order = M('Goods_order');
    $oinfo = $order->where(array('order_no'=>$order_no))->find();
    $info = M('Auction')->where(array('pid'=>$oinfo['gid']))->field('pid,pname,nowprice')->find();
    $organization = M('Member')->where(array('uid'=>$oinfo['sellerid']))->getField('organization');

    // 支付状态0：未支付 1：已支付 2：已发货3：买家已收货 4：订单过期已扣除保证金 5：已评价 6：申请退货 7：已同意退货 8：不同意退货 9：买家已发货 10：卖家确认收货 11：已评价买家
    switch ($oinfo['status']) {
        case '0':
            $ststr = '待支付';
            $first_buy = '已生成订单，请在'.date('Y-m-d H:i',$oinfo['deftime1']).'前支付订单！';
            $first_sel = '已生成订单，等待买家支付！';
            break;
        case '1':
            $ststr = '已支付';
            $first_buy = '您'.$ststr.'，等待卖家发货！';
            $first_sel = '买家'.$ststr.'，请尽快给买家发货！';
            break;
        case '2':
            $ststr = '已发货';
            $first_buy = '卖家'.$ststr.'，请保持电话畅通以便顺利收货！';
            $first_sel = '您'.$ststr.'，等待买家确认收货！';
            break;
        case '3':
            $ststr = '确认收货';
            $first_buy = '您'.$ststr.'，请对卖家做出评价，其他小伙伴需要您的建议哦！';
            $first_sel = '买家已'.$ststr.'，买家将对您的商品做出评价！';
            break;
        case '4':
            $ststr = '已评价';
            $first_buy = '您'.$ststr.'！等待买家对您做出评价！';
            $first_sel = '买家已对您做出评价，赶快给买家一个回评吧！';
            break;
        case '10':
            $ststr = '已互评';
            $first_buy = '卖家也对您做出了评价！双方'.$ststr;
            $first_sel = '您已评价买家，双方'.$ststr;
            break;
        default:
            # code...
            break;
    }

    $c_link = '商品：“<a target="_blank" href="'.U('Home/Auction/details',array('pid'=>$info['pid'],'aptitude'=>1)).'">'.$info['pname'].'</a>”。';
    $c_order = '订单号：“<a target="_blank" href="'.U('Home/Member/order_details',array('order_no'=>$oinfo['order_no'],'aptitude'=>1)).'">'.$oinfo['order_no'].'</a>”';

    $url = U('Home/Member/order_details',array('order_no'=>$oinfo['order_no']),'html',true);
    $keyword = array($organization,$oinfo['order_no'],$oinfo['price']+$oinfo['freight'].'元',$ststr);

    $mailmsg_buy = '您好：<br/><p>您拍到的'.$c_link.$first_buy.'</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站进行交易！</p>';
    $mailmsg_sel = '您好：<br/><p>您的'.$c_link.$first_sel.'</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站进行交易！</p>';
    // 给买家发送提醒【
        // 站内信内容
        $web_buy = array(
            'title'=>'订单状态通知',
            'content'=>$c_order.$first_buy.$c_link
            );
        // 微信模板消息
        $wei_buy['tpl'] = 'orderstatus';
        $wei_buy['msg']=array(
            "url"=>$url, 
            "first"=>$first_buy,
            "remark"=>'查看订单>>',
            "keyword"=>$keyword
        );
        // 短信提醒内容
        if(mb_strlen($info['pname'],'utf-8')>15){
            $newname = mb_substr($info['pname'],0,15,'utf-8').'...';
        }else{
            $newname = $info['pname'];
        }
        $note_buy = '您拍到的“'.$newname.'”；订单号：'.$oinfo['order_no'].'，'.$first_buy;
        // 邮箱提醒内容
        $mail_buy['title'] = "订单号：".$oinfo['order_no']."，【".$ststr."】";
        $mail_buy['msg'] = $mailmsg_buy;
        
        // 提醒函数
        sendRemind(M('Member'),M('Member_weixin'),$info,array($oinfo['uid']),$web_buy,$wei_buy,$note_buy,$mail_buy,'buy');
    // 给买家发送提醒】
    // 给卖家发送提醒【
        // 站内信内容
        $web_sel = array(
            'title'=>'订单状态通知',
            'content'=>$c_order.$first_sel.$c_link
            );
        // 微信模板消息
        $wei_sel['tpl'] = 'orderstatus';
        $wei_sel['msg']=array(
            "url"=>$url, 
            "first"=>$first_sel,
            "remark"=>'查看订单>>',
            "keyword"=>$keyword
        );
        // 短信提醒内容
        if(mb_strlen($info['pname'],'utf-8')>15){
            $newname = mb_substr($info['pname'],0,15,'utf-8').'...';
        }else{
            $newname = $info['pname'];
        }
        $note_sel = '您拍到的“'.$newname.'”；订单号：'.$oinfo['order_no'].'，'.$first_sel;
        // 邮箱提醒内容
        $mail_sel['title'] = "订单号：".$oinfo['order_no']."，【".$ststr."】";
        $mail_sel['msg'] = $mailmsg_sel;
        
        // 提醒函数
        sendRemind(M('Member'),M('Member_weixin'),$info,array($oinfo['sellerid']),$web_sel,$wei_sel,$note_sel,$mail_sel,'sel');
    // 给卖家发送提醒】
}

// 获取符合买家爱推送条件的用户uid，$sellerid卖家uid $type=1图文推送，0消息推送
function eligibility($sellerid,$type=0){
    // 关注我的用户
    $attuid = M('attention_seller')->where(array('sellerid'=>$sellerid))->getField('uid',true);
    // 和我有过交易的用户
    $buyuid = M('goods_order')->where(array('sellerid'=>$sellerid))->getField('uid',true);
    // $buyuid = array_flip(array_flip($buyuid));
    // 合并数组
    $sendid = array();
    if(is_array($attuid)&&is_array($buyuid)){
        $sendid = array_merge($attuid,$buyuid);
    }else{
        if(is_array($attuid)){
            $sendid = $attuid;
        }
        if(is_array($buyuid)){
            $sendid = $buyuid;
        }
    }
    $sendid = array_flip(array_flip($sendid));
    if(!empty($sendid)){
        if($type){
            // 获取微信登陆该站小于48小时的用户
            $sendwhere = array(
                'weitime'=>array('gt',time()),
                'uid'=>array('in',$sendid)
                );
            return M('member_weixin')->where($sendwhere)->getField('uid',true);
        }else{
            return $sendid;
        }
    }else{
        return array();
    }
}

// 拍卖上架通知
function auction_putaway($sellerid,$info){
    $member = M('Member');
// 给买家发送提醒【
    $uidarr = eligibility($sellerid,0);
    $link = '拍品“<a href="'.U('Home/Auction/details',array('pid'=>$info['pid'],'aptitude'=>1)).'">'.$info['pname'].'】</a>”上架';
    // 保证金
    $selpledge = M('seller_pledge')->where(array('sellerid'=>$sellerid,'pid'=>$info['pid']))->field('pledge,limsum')->find();
    if(!$selpledge){
        $selpledge = M('seller_pledge')->where(array('sellerid'=>$sellerid,'type'=>'proportion'))->field('pledge,limsum')->find();
    }
    $pledge = $selpledge['pledge']+$selpledge['limsum'];
    // 开拍结拍时间
    if($info['starttime']<time()){
        $starttime = '已开始';
    }else{
        $starttime = date('Y年m月d日 H:i',$info['starttime']);
    }
    // 阶梯价
    $stch = '';
    if($info['stepsize_type']==0){$stch = '阶梯';}
    $stepstr = $ststr.setStep($info['stepsize_type'],$info['stepsize'],$info['nowprice']).'元';
    // 卖家名称
    $organization = $member->where(array('uid'=>$sellerid))->getField('organization');
    // 站内信内容
    $web_buy = array(
        'title'=>'拍品上架提醒',
        'content'=>'卖家['.$organization.']的'.$link.'！'
        );
    // 微信模板消息

    $wei_buy['tpl'] = 'addsuccess';
    $wei_buy['msg']=array(
        "url"=>U('Home/Auction/details',array('pid'=>$info['pid']),'html',true), 
        "first"=>'您好，卖家['.$organization.']有拍品上架啦！',
        "remark"=>'结拍时间：'.date('Y年m月d日 H:i',$info['endtime']).' 查看拍品>>',
        "keyword"=>array($info['pname'],$info['onset'].'元',$stepstr,date('Y年m月d日 H:i',time()),$pledge.'元')
    );
    // 短信提醒内容
    if(mb_strlen($info['pname'],'utf-8')>15){
        $newname = mb_substr($info['pname'],0,15,'utf-8').'...';
    }else{
        $newname = $info['pname'];
    }
    $note_buy = '卖家['.$organization.']的拍品“'.$newname.'”已上架，起拍价'.$info['onset'].'元，请登录网站查看详情';
    // 邮箱提醒内容
    $mail_buy['title'] = '卖家['.$organization.']的拍品“'.$newname.'”已上架';
    $mail_buy['msg'] = '您好：<br/><p>'.$mail_buy['title'].'</p><p>起拍价：'.$info['onset'].'元；</p><p>阶梯价：'.$stch.'元；</p><p>开拍时间：'.$starttime.'</p><p>结拍时间：'.date('Y年m月d日 H:i',$info['endtime']).'</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站进行交易！</p>';

    // 提醒函数
    sendRemind($member,M('Member_weixin'),$info,$uidarr,$web_buy,$wei_buy,$note_buy,$mail_buy,'buy');
// 给买家发送提醒】
}

// 买家确认收货，卖家账户增加并提醒
function income_send_sell($order_no){
    $member = M('Member');
    $odata = M('goods_order')->where(array('order_no'=>$order_no))->find();
    // 解冻卖家保证金
    $rtmsg = unfreeze_seller_pledge($odata['sellerid'],$odata['gid'],'success');
    // 解冻卖家保证金】
    // 订单扣除佣金后转入卖家账户【
    $total = $odata['price']+$odata['freight'];
    $deserved = $total-$odata['broker'];
    // 卖家账户增加
    if(M('member')->where(array('uid'=>$odata['sellerid']))->setInc('wallet_pledge',$deserved)){
        $info = M('Auction')->where(array('pid'=>$odata['gid']))->find();
        $link = '拍品“<a href="'.U('Home/Auction/details',array('pid'=>$info['pid'],'aptitude'=>1)).'">'.$info['pname'].'】</a>”';
        $olink = '拍品订单：“<a target="_blank" href="'.U('Home/Member/order_details',array('order_no'=>$odata['order_no'],'aptitude'=>1)).'">'.$odata['order_no'].'</a>”';

        $wallet = M('Member')->where(array('uid'=>$odata['sellerid']))->field('wallet_pledge,wallet_pledge_freeze')->find();
        $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
        // 可用余额
        
        $pledge_data = array(
            'order_no'=>createNo('pro'),
            'uid'=>$odata['sellerid'],
            'changetype'=>'profit',
            'time'=>time(),
            'annotation'=>'买家确认收到'.$link.'；'.$olink.'，拍品成交价：'.$odata['price'].'元+运费：'.$odata['freight'].'元=订单总额：'.$total.'元，扣除网站'.C('Auction.broker_name').'：'.$odata['broker'].'元后收入'.$deserved.'元',
            'income'=>$deserved,
            );
        if(M('member_pledge_bill')->add($pledge_data)){
            // 提醒通知卖家账户增加【
                // 微信提醒内容
                $wei_profit['tpl'] = 'walletchange';
                $wei_profit['msg']=array(
                    "url"=>U('Home/Member/pledge','','html',true), 
                    "first"=>"您好，".'买家确认收货“'.$info['pname'].'”，货款已到账！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('余额账户','交易收入','订单:'.$odata['order_no'],'+'.$deserved.'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_profit = array(
                    'title'=>'交易收入',
                    'content'=>$pledge_data['annotation']
                    );
                // 短信提醒内容
                if(mb_strlen($info['pname'],'utf-8')>10){
                    $newname = mb_substr($info['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $info['pname'];
                }
                $note_profit = '买家确认收货，拍品“'.$newname.'”订单号'.$odata['order_no'].'。收入【'.$deserved.'元】，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_profit['title'] = '买家确认收货“'.$newname.'”';
                $mail_profit['msg'] = '您好：<br/><p>'.$web_profit['content'].'</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';

                sendRemind($member,M('Member_weixin'),array(),array($odata['sellerid']),$web_profit,$wei_profit,$note_profit,$mail_profit,'sel');
            // 提醒通知卖家账户增加【
            return array('status'=>0,'msg'=>'写入账户记录成功！');
        }else{
            return array('status'=>0,'msg'=>'写入账户记录失败！');
        }
    }else{
        return array('status'=>0,'msg'=>'账户收入增加失败！');
    }
}


// 商品保证金显示
function pledgeShow($pattern,$pledge_type,$onset,$pledge,$spledge,$mpledge){
    if ($pattern == 1) {
        if($spledge==0){
            $show = '专场免保证金';
        }else{
            $show = '专场'.wipezero($spledge).'<span class="unit">元</span>';
        }
    }elseif ($pattern == 3) {
        if($mpledge==0){
            $show = '拍卖会免保证金';
        }else{
            $show = '拍卖会'.wipezero($mpledge).'<span class="unit">元</span>';
        }
    }else{
        if($pledge_type=='ratio'){
            $pledge = round($onset*($pledge/100),2); 
        }
        if($pledge==0){
            $show = '免保证金';
        }else{
            $show = wipezero($pledge).'<span class="unit">元</span>';
        }
    }
    return $show;
}

// 用户提醒字段更新$member[实例用户表],$uid[用户uid],$assfield[提醒方式],$type=0[0添加，1删除]
function upalerttype($member,$uid,$assfield,$type=0){
    $alertstr = $member->where(array('uid'=>$uid))->getField('alerttype');
    if($alertstr != ''){
        $alertarr = explode(',', $alertstr);
    }else{
        $alertarr = array();
    }
    if($type){
        if(in_array($assfield, $alertarr)){
            $key = array_search($assfield, $alertarr); 
            unset($alertarr[$key]);
        }
    }else{
        if(!in_array($assfield, $alertarr)){
            $alertarr[] = $assfield;
        }
    }
    if(!empty($alertarr)){
        $member->where(array('uid'=>$uid))->setField('alerttype',implode(',', $alertarr));
    }
    
}
function order_dispose_default($uid,$sellerid){
    $auction = M('auction');
    $member = M('member');
    $special = M('special_auction');
    $goods_user = M('goods_user');
    $seller_pledge = M('seller_pledge');
    $goods_order = M('goods_order');
    // 默认支付过期条件
    $where1 = array('status'=>0,'deftime1st'=>0,'_string'=>"deftime1 > 0 and deftime1 < ".time());
    // 默认发货过期条件
    $where2 = array('status'=>1,'deftime2st'=>0,'_string'=>"deftime2 > 0 and deftime2 < ".time());
    // 默认收货过期条件
    $where3 = array('status'=>2,'deftime3st'=>0,'_string'=>"deftime3 > 0 and deftime3 < ".time());
    // 默认评价卖家过期条件
    $where4 = array('status'=>3,'deftime4st'=>0,'_string'=>"deftime4 > 0 and deftime4 < ".time());
    // 默认评价买家过期条件
    $where11 = array('status'=>4,'deftime10st'=>0,'_string'=>"deftime10 > 0 and deftime10 < ".time());
    // 如果通过uid进行操作
    if ($uid) {
        $where1['uid'] = $uid;
        $where2['uid'] = $uid;
        $where3['uid'] = $uid;
        $where4['uid'] = $uid;
        $where11['uid'] = $uid;
    }
    if ($sellerid) {
        $where1['sellerid'] = $uid;
        $where2['sellerid'] = $uid;
        $where3['sellerid'] = $uid;
        $where4['sellerid'] = $uid;
        $where11['sellerid'] = $uid;
    }
    // 过期阶段的条件组合】
    // 符合条件的订单集合【
    $order_arr = array();
    $time1arr = $goods_order->where($where1)->select();
    if ($time1arr) {
        $order_arr = $time1arr;
    }

    $time2arr = $goods_order->where($where2)->select();
    if ($time2arr) {
        if ($order_arr) {
            $order_arr = array_merge($order_arr,$time2arr);
        }else{
            $order_arr = $time2arr;
        }
    }
    
    $time3arr = $goods_order->where($where3)->select();
    if ($time3arr) {
        if ($order_arr) {
            $order_arr = array_merge($order_arr,$time3arr);
        }else{
            $order_arr = $time3arr;
        }
    }

    $time4arr = $goods_order->where($where4)->select();
    if ($time4arr) {
        if ($order_arr) {
            $order_arr = array_merge($order_arr,$time4arr);
        }else{
            $order_arr = $time4arr;
        }
    }
    $time11arr = $goods_order->where($where11)->select();
    if ($time11arr) {
        if ($order_arr) {
            $order_arr = array_merge($order_arr,$time11arr);
        }else{
            $order_arr = $time11arr;
        }
    }
    // 符合条件的订单集合】
    // 如果存在循环进行处理【
    if ($order_arr) {
        // 循环判断进行处理
        foreach ($order_arr as $ok => $ov) {
            switch ($ov['status']) {
                // 扣除买家保证金  扣除网站佣金后转入卖家账户   解冻卖家保证金  
                case '0':
                    pledgesentence($ov,'deftime1st');
                    break;
                // 扣除卖家保证金  扣除网站佣金后转入买家账户   解冻买家保证金
                case '1':
                    pledgesentence($ov,'deftime2st');
                    break;
                // 设置为默认收货   
                case '2':
                // 设置默认发货已处理，订单已发货，并设置买家默认评价时间
                    if($goods_order->where(array('order_no'=>$ov['order_no']))->setField(array('status'=>3,'time3'=>time(),'deftime3st'=>1,'deftime4'=>$deftime4))){
                        // 买家确认收货，卖家账户增加并提醒
                        income_send_sell($ov['order_no']);
                        // 确认收货订单状态提醒【
                        sendOrderRemind($ov['order_no']);
                        // 确认收货订单状态提醒【
                    }
                    break;
                // 默认给卖家好评
                case '3':
                    $where = array('order_no'=>$ov['order_no']);
                    if(!$evaluate->where('$where')->find()){
                        $data = array(
                            'order_no'=>$ov['order_no'],
                            'service_evaluate'=>'买家未作出评价，默认好评！',
                            'conform_evaluate'=>'买家未作出评价，默认好评！',
                            'conform'=>5,
                            'service'=>5,
                            'express'=>5,
                            'uid'=>$ov['uid'],
                            'pid'=>$ov['gid'],
                            'sellerid'=>$ov['sellerid'],
                            'time'=>time()
                            );
                        if(M('goods_evaluate')->add($data)){
                            // 卖家默认好评过期时间
                            if(C('Order.losetime10')==0||C('Order.losetime10')==''){
                                $deftime10 = 0;
                            }else{
                                $losetime10=C('Order.losetime10');
                                $deftime10 = time()+(60*60*24*$losetime10);
                            }
                            // 设置已评价和卖家默认评价时间
                            if($goods_order->where($where)->setField(array('status'=>'4','time4'=>time(),'deftime4st'=>1,'deftime10'=>$deftime10))){
                                // 用户未按时评价，系统默认评价【
                                    sendOrderRemind($ov['order_no']);
                                // 用户未按时评价，系统默认评价【
                            }
                            // 为用户等级加分数
                            $score = $data['conform']+$data['service']+$data['express'];
                            $member->where(array('uid'=>$data['sellerid']))->setInc('score',$score);
                        }
                    }
                    break;
                // 默认给买家好评
                case '4':
                    $data = I('post.info');
                    $where = array('order_no'=>$ov['order_no']);
                    $data = array(
                        'order_no'=>$ov['order_no'],
                        'evaluate'=>'卖家未及时作出评价，系统默认好评',
                        'pid'=>$ov['gid'],
                        'sellerid' => $ov['sellerid'],
                        'uid' => $ov['uid'],
                        'time' => time()
                        );
                    if(M('member_evaluate')->add($data)){
                        if ($goods_order->where($where)->setField(array('status'=>'10','time10'=>time(),'deftime10st'=>1))) {
                            // 买家未及时作出评价，系统默认好评【
                                sendOrderRemind($ov['order_no']);
                            // 买家未及时作出评价，系统默认好评【
                        }
                        $member->where(array('uid'=>$data['uid']))->setInc('scorebuy',$data['score']);
                    }
                    break;
            }
        }
    }
    // 如果存在循环进行处理】
    
}
// 违约方扣除冻结的保证金，减去网站佣金后转入对方账户，发送消息提醒
// 订单号，违约方
function pledgesentence($ov,$defst){
    $auction = M('auction');
    $member = M('member');
    $goods_user = M('goods_user');
    $rate = C('Order.liquidated')/100;
    // 获取买家保证金缴纳方式
    $pinfo = $auction->where(array('pid'=>$ov['gid']))->field('sid,mid,pname')->find();
    $p_l_w = array('uid'=>$ov['uid'],'gid'=>$ov['gid'],'g-u'=>'p-u','status'=>0);
    // 如果专场
    if ($pinfo['sid'] != 0) {
        $sinfo = M('special_auction')->where(array('sid'=>$pinfo['sid']))->field('special_pledge_type,endtime')->find();
        // 专场扣除模式且专场已结束只要有一个订单过期就会扣除保证金
        if($sinfo['special_pledge_type']==0 && $sinfo['endtime']>time()){
            $p_l_w = array('uid'=>$ov['uid'],'gid'=>$pinfo['sid'],'g-u'=>'s-u','status'=>0);
        }
    }
    if(mb_strlen($ov['pname'],'utf-8')>15){
        $newname = mb_substr($ov['pname'],0,15,'utf-8').'...';
    }else{
        $newname = $ov['pname'];
    }
    $anno2 = '】，扣除';
    $anno3 = '元。订单号：';
    $auction_link = '<a href="'.U('Auction/details',array('pid'=>$ov['gid']),'html',true).'">'.$pinfo['pname'].'</a>';
    $order_link = '<a href="'.U('Member/order_details',array('order_no'=>$ov['order_no']),'html',true).'">'.$ov['order_no'].'</a>';

    switch ($defst) {
        case 'deftime1st':
            $anno1 = '未在有效期支付，拍品【';
            // 读取缴纳的保证金
            $freeze = $goods_user->where($p_l_w)->find();
            // 违约方
            $brole = $ov['uid'];
            $arole = $ov['sellerid'];
            $bstr = 'buy';
            $astr = 'sel';
            $anno = '买家';
            $kc = 'buy_break_nopay';
            $sr = 'seller_break_nopay';
        // 买家未按时支付解冻卖家保证金
            unfreeze_seller_pledge($arole,$ov['gid'],'break');
            break;
        case 'deftime2st':
            $anno1 = '未在有效期发货，拍品【';
            $seller_pledge = M('seller_pledge');
            $freeze = $seller_pledge->where(array('sellerid'=>$ov['sellerid'],'pid'=>$ov['gid'],'status'=>1))->find();
            // 违约方
            $brole = $ov['sellerid'];
            $arole = $ov['uid'];
            $bstr = 'sel';
            $astr = 'buy';
            $anno = '卖家';
            $kc = 'seller_break_deliver';
            $sr = 'buy_break_deliver';
        // 买家保证金在支付时候已经解冻了无需操作
            break;
    }
    
    if ($freeze['pledge']>0) {
        $official_pledge = wipezero($freeze['pledge']*$rate);
        $transfer_pledge = $freeze['pledge']-$official_pledge;
        // 扣除违约方保证金
        if($member->where(array('uid'=>$brole))->setDec('wallet_pledge_freeze',$freeze['pledge'])){
            $member->where(array('uid'=>$brole))->setDec('wallet_pledge',$freeze['pledge']);
            // 设置状态为已解冻
            $gudata = array('rtime'=>time(),'status'=>1);
            $brole_pledge_data = array(
                'order_no'=>createNo('bnp'),
                'uid'=>$brole,
                'changetype'=>$kc,
                'time'=>time(),
                'annotation'=>'您'.$anno1.$auction_link.$anno2.'保证金'.$freeze['pledge'].$anno3.$order_link,
                'expend'=>$freeze['pledge'],
                );
            $brole_pledge_status = M('member_pledge_bill')->add($brole_pledge_data);
        }
        // 转给守约方保证金
        if($member->where(array('uid'=>$arole))->setInc('wallet_pledge_freeze',$transfer_pledge)){
            $member->where(array('uid'=>$arole))->setInc('wallet_pledge',$transfer_pledge);
            $arole_pledge_data = array(
                'order_no'=>createNo('anp'),
                'uid'=>$arole,
                'changetype'=>$sr,
                'time'=>time(),
                'annotation'=>$anno.$anno1.$auction_link.$anno2.'保证金'.$transfer_pledge.$anno3.$order_link,
                'income'=>$transfer_pledge,
                );
            $arole_pledge_status = M('member_pledge_bill')->add($arole_pledge_data);
        }
    }
    if ($freeze['limsum']>0) {
        $official_limsum = $freeze['limsum']*$rate;
        $transfer_limsum = $freeze['limsum']-$official_limsum;
        // 扣除违约方信誉额度
        if($member->where(array('uid'=>$brole))->setDec('wallet_limsum_freeze',$freeze['limsum'])){
            $member->where(array('uid'=>$brole))->setDec('wallet_limsum',$freeze['limsum']);
            $brole_limsum_data = array(
                'order_no'=>createNo('bnp'),
                'uid'=>$brole,
                'changetype'=>$kc,
                'time'=>time(),
                'annotation'=>'您'.$anno1.$auction_link.$anno2.'信誉额度'.$freeze['pledge'].$anno3.$order_link,
                'expend'=>$freeze['limsum'],
                );
            $brole_limsum_status = M('member_limsum_bill')->add($brole_limsum_data);
        }
        // 转给守约方信誉额度
        if($member->where(array('uid'=>$arole))->setInc('wallet_limsum_freeze',$transfer_limsum)){
            $member->where(array('uid'=>$arole))->setInc('wallet_limsum',$transfer_limsum);
            $arole_limsum_data = array(
                'order_no'=>createNo('snp'),
                'uid'=>$arole,
                'changetype'=>$sr,
                'time'=>time(),
                'annotation'=>$anno.$anno1.$auction_link.$anno2.'信誉额度'.$freeze['pledge'].$anno3.$order_link,
                'income'=>$transfer_limsum,
                );
            $arole_limsum_status = M('member_limsum_bill')->add($arole_limsum_data);
        }
    }
    //设置保证金已处理
    if ($brole_pledge_status||$brole_limsum_status) {
        switch ($defst) {
            case 'deftime1st':
                $gudata = array('rtime'=>time(),'status'=>1);
                $goods_user->where($p_l_w)->save($gudata);
                break;
            case 'deftime2st':
                $seller_pledge->where(array('id'=>$freeze['id']))->setField('status',0);
                break;
        }
        
    }
    // 设置该违约已处理
    M('goods_order')->where(array('order_no'=>$ov['order_no']))->setField($defst,1);
    // 写入网站订单违约收入表
    $break_data = array(
        'order_no'=>$ov['order_no'],
        'limsum'=>$official_limsum,
        'pledge'=>$official_pledge,
        'how'=>$bstr
        );
    M('order_break')->add($break_data);
// 给违约方发消息
    $brole_wallet = $member->where(array('uid'=>$brole))->field('wallet_pledge,wallet_pledge_freeze,wallet_limsum,wallet_limsum_freeze')->find();
    if ($brole_pledge_status) {
        $brole_usable = $brole_wallet['wallet_pledge']-$brole_wallet['wallet_pledge_freeze'];
        // 微信提醒内容
        $wei_profit['tpl'] = 'walletchange';
        $wei_profit['msg']=array(
            "url"=>U('Home/Member/pledge','','html',true), 
            "first"=>'您好，您'.$anno1.$newname.$anno2.'保证金'.$freeze['pledge'].$anno3.$ov['order_no'],
            "remark"=>'查看账户记录>>',
            "keyword"=>array('余额账户','扣除保证金','单号:'.$brole_pledge_data['order_no'],'-'.$brole_pledge_data['expend'].'元',$brole_usable.'元')
        );
        // 账户类型，操作类型、操作内容、变动额度、账户余额
        // 站内信提醒内容
        $web_profit = array(
            'title'=>'扣除保证金',
            'content'=>$brole_pledge_data['annotation']
            );
        $note_profit = '您好，您'.$anno1.$newname.$anno2.'保证金'.$freeze['pledge'].$anno3.$ov['order_no'];
        // 邮箱提醒内容
        $mail_profit['title'] = $anno1.$newname.'】扣除保证金';
        $mail_profit['msg'] = $brole_pledge_data['annotation'].'<p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';
        sendRemind($member,M('Member_weixin'),array(),array($brole),$web_profit,$wei_profit,$note_profit,$mail_profit,$bstr);
    }
    if ($brole_limsum_status) {
        $brole_usable = $brole_wallet['wallet_limsum']-$brole_wallet['wallet_limsum_freeze'];
        // 微信提醒内容
        $wei_profit['tpl'] = 'walletchange';
        $wei_profit['msg']=array(
            "url"=>U('Home/Member/limsum','','html',true), 
            "first"=>'您好，您'.$anno1.$newname.$anno2.'信誉额度'.$freeze['pledge'].$anno3.$ov['order_no'],
            "remark"=>'查看账户记录>>',
            "keyword"=>array('余额账户','扣除信誉额度','单号:'.$brole_limsum_data['order_no'],'-'.$brole_limsum_data['expend'].'元',$brole_usable.'元')
        );
        // 账户类型，操作类型、操作内容、变动额度、账户余额
        // 站内信提醒内容
        $web_profit = array(
            'title'=>'扣除信誉额度',
            'content'=>$brole_limsum_data['annotation']
            );
        $note_profit = '您好，您'.$anno1.$newname.$anno2.'信誉额度'.$freeze['pledge'].$anno3.$ov['order_no'];
        // 邮箱提醒内容
        $mail_profit['title'] = $anno1.$newname.'】扣除信誉额度';
        $mail_profit['msg'] = $brole_limsum_data['annotation'].'<p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';
        sendRemind($member,M('Member_weixin'),array(),array($brole),$web_profit,$wei_profit,$note_profit,$mail_profit,$bstr);
    }
    
// 给守约方发消息
    $arole_wallet = $member->where(array('uid'=>$arole))->field('wallet_pledge,wallet_pledge_freeze,wallet_limsum,wallet_limsum_freeze')->find();
    if ($arole_pledge_status) {
        $arole_usable = $arole_wallet['wallet_pledge']-$arole_wallet['wallet_pledge_freeze'];
        // 微信提醒内容
        $wei_profit['tpl'] = 'walletchange';
        $wei_profit['msg']=array(
            "url"=>U('Home/Member/pledge','','html',true), 
            "first"=>'您好，'.$anno.$anno1.$newname.$anno2.'保证金'.$arole_pledge_data['income'].$anno3.$ov['order_no'],
            "remark"=>'查看账户记录>>',
            "keyword"=>array('余额账户','收入保证金','单号:'.$arole_pledge_data['order_no'],'+'.$arole_pledge_data['income'].'元',$arole_usable.'元')
        );
        // 账户类型，操作类型、操作内容、变动额度、账户余额
        // 站内信提醒内容
        $web_profit = array(
            'title'=>'收入保证金',
            'content'=>$arole_pledge_data['annotation']
            );
        $note_profit = '您好，'.$anno.$anno1.$newname.$anno2.'保证金'.$arole_pledge_data['income'].$anno3.$ov['order_no'];
        // 邮箱提醒内容
        $mail_profit['title'] = $anno.$anno1.$newname.'】扣除保证金';
        $mail_profit['msg'] = $arole_pledge_data['annotation'].'<p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';
        sendRemind($member,M('Member_weixin'),array(),array($arole),$web_profit,$wei_profit,$note_profit,$mail_profit,$astr);
    }
    if ($arole_limsum_status) {
        $arole_usable = $arole_wallet['wallet_limsum']-$arole_wallet['wallet_limsum_freeze'];
        // 微信提醒内容
        $wei_profit['tpl'] = 'walletchange';
        $wei_profit['msg']=array(
            "url"=>U('Home/Member/limsum','','html',true), 
            "first"=>'您好，'.$anno.$anno1.$newname.$anno2.'信誉额度'.$arole_limsum_data['income'].$anno3.$ov['order_no'],
            "remark"=>'查看账户记录>>',
            "keyword"=>array('余额账户','收入信誉额度','单号:'.$arole_limsum_data['order_no'],'+'.$arole_limsum_data['income'].'元',$arole_usable.'元')
        );
        // 账户类型，操作类型、操作内容、变动额度、账户余额
        // 站内信提醒内容
        $web_profit = array(
            'title'=>'收入信誉额度',
            'content'=>$arole_limsum_data['annotation']
            );
        $note_profit = '您好，'.$anno.$anno1.$newname.$anno2.'信誉额度'.$arole_limsum_data['income'].$anno3.$ov['order_no'];
        // 邮箱提醒内容
        $mail_profit['title'] = $anno.$anno1.$newname.'】扣除信誉额度';
        $mail_profit['msg'] = $arole_limsum_data['annotation'].'<p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';
        sendRemind($member,M('Member_weixin'),array(),array($arole),$web_profit,$wei_profit,$note_profit,$mail_profit,$astr);
    }
}







?>

