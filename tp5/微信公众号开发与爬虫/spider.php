<?php
include('./snoopy.php');
include('./simple_html_dom.php');
$act='';
define('SCRIPT_ROOT',dirname(__FILE__).'/');
if (isset($_REQUEST['act'])) {
   $act = trim($_REQUEST['act']);
}

switch($act)
{
  case 'login':     
      // $loginParams为curl模拟登录时post的参数
      $loginParams['mer_uname'] = 'shendu';
      $loginParams['mer_pwd'] = 'zhang?';    
      // $cookieFile 为加载验证码时保存的cookie文件名 
      $cookieFile = SCRIPT_ROOT.'cookie.tmp';
      // $targetUrl curl 提交的目标地址
      $targetUrl = 'http://www.zwzpy.com/index.php?ac=auth_login';  
      // 参数重置
      $content = curlLogin($targetUrl, $cookieFile, $loginParams);
      echo $content;
      break;
      case 'authcode':
      // Content-Type 验证码的图片类型
      header('Content-Type:image/png charset=gb2312');
      showAuthcode('http://tpadmin.yuan1994.com/captcha.html?t=1517316625621');
      
      exit;
     break;
}


function curlLogin($url, $cookieFile, $loginParams)
{   
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_COOKIEJAR,$cookieFile );
    
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
    curl_setopt($ch, CURLOPT_HEADER, 0);//设定是否显示头信 息
    curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面 内容
    curl_setopt($ch,CURLOPT_POST, 1);
    //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $loginParams); //提交查询信息
    $con=curl_exec($ch);//返回结果
    //print_r($con);exit;
    curl_close($ch); //关闭
    $curl2=curl_init();
    curl_setopt($curl2, CURLOPT_COOKIEFILE, $cookieFile); 
     curl_setopt($curl2, CURLOPT_HEADER, false); 
     curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true); 
     curl_setopt($curl2, CURLOPT_TIMEOUT, 20); 
     curl_setopt($curl2, CURLOPT_AUTOREFERER, true); 
     curl_setopt($curl2, CURLOPT_URL, 'http://www.zwzpy.com/index.php?ac=member&u_name=shendu');//登陆后要从哪个页面获取信息
     $content=curl_exec($curl2);//返回结果
     header("Content-type: text/html; charset=utf-8");
     $html = new simple_html_dom($content);//获取html文件

     foreach($html->find('.hy_index_uers_info') as $e){
	 $ids[]= $e->innertext ;
     }
     
     echo "<pre>";print_r($ids);exit;
     curl_close($curl2);
}

/**
 * 加载目标网站图片验证码
 * string $authcode_url 目标网站验证码地址
 */
function showAuthcode( $authcode_url )
{
    $con = file_get_contents($authcode_url);
    echo $con;
    $cookieFile = SCRIPT_ROOT.'cookie.tmp';
    $ch = curl_init($authcode_url);
    curl_setopt($ch,CURLOPT_COOKIEJAR, $cookieFile); // 把返回来的cookie信息保存在文件中
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $content =curl_exec($ch);
    
    //var_dump($cookieFile);
    curl_close($ch);
}
?>
<iframe src="?act=authcode" style='width: 200px; height:100px ' frameborder=0 ></iframe>
<form>
<input type="hidden" name="act" value="login">
<input type="text" name="code" />
<input type="submit" name="submit" >
</form>