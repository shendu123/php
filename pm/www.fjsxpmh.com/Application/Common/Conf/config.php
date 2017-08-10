<?php

/*
 * 通用配置文件
 * Author：leo.1772703372@qq.com）
 * Date:2013-02-01
 */
$config1 = array(
    /* 数据库设置 */
    'DB_TYPE' => 'mysql', // 数据库类型
    'SHOW_PAGE_TRACE' => FALSE,
    'TOKEN_ON' => true, // 是否开启令牌验证
    'TOKEN_NAME' => '__oncoo__', // 令牌验证的表单隐藏字段名称
    'TOKEN_TYPE' => 'md5', //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET' => FALSE, //令牌验证出错后是否重置令牌 默认为true
    'URL_CASE_INSENSITIVE' =>false,
    /* 开发人员相关信息 */
    'AUTHOR_INFO' => array(
        'author' => 'oncoo.net',
        'author_email' => '286771902@qq.com',
    ),
    'DEFAULT_C_LAYER'       =>  'Controller', // 默认的控制器层名称
    'MODULE_ALLOW_LIST'     =>  array('Home','Admin'), // 配置你原来的分组列表
    'DEFAULT_MODULE'        =>  'Home', // 配置你原来的默认分组
    'MODULE_DENY_LIST'   => array('Common'),
    'TAGLIB_BUILD_IN' =>'Cx,Cuit', 
    'URL_MODEL'=> '2', //URL模式
    'UPLOADS_PICPATH'=>'./Uploads/',//图片上传根路径
    
    'VAR_SESSION_ID' =>  'session_id', //sessionID的提交变量
    // 验证码过期时间
    'SEND_LOSE_TIME'=>24,
    // 拍品前缀
    'BID_PRE'=>'a',
    // 专场前缀
    'SID_PRE'=>'s',
    // 拍卖会前缀
    'MID_PRE'=>'m',
    /*
     * 以下是关于商品图片的配置
     */
    'GOODS_PICPATH'=>'Goods',//商品图片上传路径（相对于根路径下）
    
    //pre_(最初用于裁剪的，也用于备份)max_,mid_,mini_(网站使用大中小图)
    'GOODS_PIC_PREFIX' =>'pre_,max_,mid_,mini_',
    'GOODS_PIC_WIDTH' =>'750,640,305,120',//商品图片宽度和图片前缀对应
    'GOODS_PIC_HEIGHT' =>'562,480,230,91',//商品图片高对和图片前缀对应

    //pre_(最初用于裁剪的，也用于备份)max_,mid_,mini_(网站使用大中小图)
    'USER_PICPATH'=>'User',//商品图片上传路径（相对于根路径下）
    'USER_PIC_PREFIX' =>'max_,mid_,mini_',
    'USER_PIC_WIDTH' =>'215,100,50',//商品图片宽度和图片前缀对应
    'USER_PIC_HEIGHT' =>'215,100,50',//商品图片高对和图片前缀对应
    /*
     * 以下是关于微信图文图片上传配置
     */
    'WEI_PICPATH'=>'Weixin',//文章图标上传路径（相对于根路径下）
    'WEI_TOP_WIDTH'=>'360',//文章图标宽度
    'WEI_TOP_HEIGHT'=>'200',//文章图标高度
    'WEI_LIST_WIDTH'=>'200',//文章图标宽度
    'WEI_LIST_HEIGHT'=>'200',//文章图标高度



    'DATA_CACHE_TYPE' => 'Memcache',//默认是file方式进行缓存的，修改为memcache
    'MEMCACHE_HOST' => '127.0.0.1',//memcache服务器地址和端口，这里为本机。
    'MEMCACHE_PORT' => '11211',
    // 'DATA_CACHE_PREFIX'     =>  'on_',     // 缓存前缀
    // 'DATA_CACHE_TIME' => '20',  //过期的秒数。
    // 'DATA_CACHE_SUBDIR'=>true,
    // 'DATA_PATH_LEVEL'=>2,
    // 命名空间自动加载
    'AUTOLOAD_NAMESPACE'    =>  array(
        'Lib'   =>  APP_PATH.'Lib'
    ),
    'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR',
    'TMPL_ACTION_ERROR'     => './Public/error.html', // 默认错误跳转对应的模板文件
    'TMPL_ACTION_SUCCESS'   => './Public/error.html', // 默认成功跳转对应的模板文件
    
   
);
$config2 = APP_PATH . "Common/Conf/systemConfig.php";
$config2 = file_exists($config2) ? include "$config2" : array();

$payment = APP_PATH . "Common/Conf/payment.php";
$payment = file_exists($payment) ? include "$payment" : array();

$setExtend = APP_PATH . "Common/Conf/setExtend.php";
$setExtend = file_exists($setExtend) ? include "$setExtend" : array();

$SetAuction = APP_PATH . "Common/Conf/SetAuction.php";
$SetAuction = file_exists($SetAuction) ? include "$SetAuction" : array();

$SetWeixin = APP_PATH . "Common/Conf/SetWeixin.php";
$SetWeixin = file_exists($SetWeixin) ? include "$SetWeixin" : array();

$SetOrder = APP_PATH . "Common/Conf/SetOrder.php";
$SetOrder = file_exists($SetOrder) ? include "$SetOrder" : array();

$SetMember = APP_PATH . "Common/Conf/SetMember.php";
$SetMember = file_exists($SetMember) ? include "$SetMember" : array();

$SetSellerLevel = APP_PATH . "Common/Conf/SetSellerLevel.php";
$SetSellerLevel = file_exists($SetSellerLevel) ? include "$SetSellerLevel" : array();

$SetBuyLevel = APP_PATH . "Common/Conf/SetBuyLevel.php";
$SetBuyLevel = file_exists($SetBuyLevel) ? include "$SetBuyLevel" : array();


return array_merge($config1, $config2, $payment,$setExtend,$SetAuction,$SetOrder,$SetMember,$SetBuyLevel,$SetSellerLevel,$SetWeixin);
?>