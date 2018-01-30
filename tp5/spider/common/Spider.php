<?php
namespace  app\spider\common;
/*
  数据抓取
 */
use app\spider\common\Snoopy;
class Spider
{

    public $charset = 'utf-8'; //字符类型
    public $cookieFile; //存放cookie的文件

    public function __construct($cookieName = '')
    {
        if ($cookieName) {
            $this->cookieFile = APPLICATION_PATH . "/cookiefile/{$cookieName}.txt";
        }
    }

    //获取内容
    public function getContent($url, $charset = '')
    {
        $Snoopy=new Snoopy();
        $Snoopy->fetch($url);
        return $Snoopy->results;
        if (get_extension_funcs("curl")) {
            $content = $this->getContentByCurl($url);
        } else {
            $Snoopy=new Snoopy();
            $Snoopy->fetch($url);
            return $Snoopy->results;
        }
        if ($charset && $charset != $this->charset) {
            $content = iconv($charset, $this->charset, $content);
        }
        return $content;
    }

    //通过file_get_contents获取内容
    public function getContentByFile($url, $charset = '')
    {
        $content = file_get_contents($url);
        return $content;
    }

    //通过CURL获取内容
    public function getContentByCurl($url)
    {
        $ch = curl_init();
        // 2. 设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile); //读取  
        // 3. 执行并获取HTML文档内容
        $output = curl_exec($ch);
        if ($output === FALSE) {
            echo "cURL Error: " . curl_error($ch);
        }

        //输出采集信息
        $info = curl_getinfo($ch);
        //echo '获取' . $info['url'] . '耗时' . $info['total_time'] . '秒';
        // 4. 释放curl句柄
        curl_close($ch);
        return $output;
    }

    //发送数据
    public function postData($url, $data, $method = 'post')
    {

        $ch = curl_init();
        //头部
        $headers['CLIENT-IP'] = '202.103.229.40';
        $headers['X-FORWARDED-FOR'] = '202.103.229.40';
        //$headers['Host'] = 'baidu.com';
        foreach ($headers as $n => $v) {
            $headerArr[] = $n . ':' . $v;
        }
        //属性
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headerArr);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.baidu.com/");
        curl_setopt($ch, CURLOPT_ENCODING, "gzip");
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookieFile);
        //输出头部信息
        //curl_setopt($ch, CURLOPT_HEADER, 1);
        // 我们在POST数据哦！
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // 获取转向后的内容 
        // 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        //输出采集信息
//        $info = curl_getinfo($ch);
//        echo '获取' . $info['url'] . '耗时' . $info['total_time'] . '秒';
        curl_close($ch);
        return $output;
    }

    //显示验证码
    function showAuthcode($authcode_url)
    {
        $ch = curl_init($authcode_url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookieFile); // 把返回来的cookie信息保存在文件中
        curl_exec($ch);
        curl_close($ch);
    }

//根据代码开始和结束区间获取代码
    public static function getStrByStartEnd($content, $startHtml, $endHtml)
    {
        if (!$startHtml && !$endHtml) {
            return '';
        }

        if ($startHtml) {
            if (!strstr($content, $startHtml)) {
                return '';
            }

            $startHtml = htmlspecialchars_decode($startHtml);
            $newArr=explode($startHtml, $content);
            $content = end($newArr);
        }

        //获取HTML范围结束
        if ($endHtml) {
            if (!strstr($content, $endHtml)) {
                return '';
            }
            $endHtml = htmlspecialchars_decode($endHtml);
            $content=explode($endHtml, $content);
            $content = $content[0];
        }

        return trim($content);
    }

    //根据代码开始和结束区间获取代码URL
    public function getUrlByStartEnd($content, $startHtml, $endHtml)
    {
        $content=self::getStrByStartEnd($content, $startHtml, $endHtml);
        $Snoopy=new Snoopy();
        return $Snoopy->_striplinks($content);
        return trim($content);
    }
}
