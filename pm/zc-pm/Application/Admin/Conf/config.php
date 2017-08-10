<?php
//$config_arr1 = include_once APP_PATH . 'Common/Conf/config.php';
$DB_PREFIX = C('DB_PREFIX');
return array(
    'admin_big_menu' => array(
        'Index' => '首页',
        'Member' => '注册/用户管理',
        'Goods' => '商品管理',
        'Crowd' => '申购管理',
        'Auction' => '拍卖管理',
        'Order' => '订单管理',
        'Link' => '友情链接',
        'News' => '文章管理',
        'Advertising' => '广告管理',
        'Payment' => '支付管理',
//        'Webinfo'=>'系统设置',
//        'SysData' => '数据管理',
        'Access' => '权限管理',
        'Weixin' => '微信平台',
        'Point' => '积分商城',
        'Ovideo' => '视讯',
        'Online' => '在线'
    ),
    'admin_sub_menu' => array(
        'Common' => array(
            'Index/take' => '提现申请',
            'Index/statistics' => '资金统计',
            'Goods/add' => '发布商品',
            'News/add' => '新闻发布',
            'Index/myInfo' => '修改密码',
            'Index/cache' => '缓存清理',
            'Index/link' => '会员推广',
            'Index/system_log'=>'系统日志'
        ),
        'Webinfo' => array(
            'index' => '配置信息',
            'steWebConfig'=>'站点配置',
            'setEmailConfig' => '邮箱配置',
            'setNoteConfig' => '短信配置',
            'setSafeConfig' => '安全配置',
            'express'=> '快递配置及管理',
            'setUserAgreement' => '用户协议',
            'setSellerLevel' => '卖家等级管理',
            'setBuyLevel' => '买家等级管理',
            'navigation' => '前台导航、链接管理'
        ),
        'Member' => array(
            'add' =>'添加用户',
            'index' => '用户列表',
            'walletbill' => '账户记录',
            // 'sendsms'=>'发送站内信',
            'webmail'=>'站内信管理',
            'feedback' => '推广反馈',
            'set_member' => '注册方式'
        ),
        'Goods' => array(
            'add' => '发布商品',
            'index' => '商品列表',
            'category' => '频道、分类管理',
            'filtrate' => '筛选条件管理',
            'cate_filt'=> '频道、分类与条件关联',
            'fields_list'=> '扩展字段、默认值',
            'cate_extend'=> '频道、分类与扩展字段关联'
        ),
        'Crowd' => array(
            'index' => '申购列表',
            'add' => '添加申购'
        ),
        'Point' => array(
            'index' => '积分视频',
            'editcourse' => '添加视频',
            'indexschool' => '积分学堂',
            'editschool' => '添加积分学堂',
            'indexgift' => '积分礼品',
            'editgift' => '添加礼品',
            'order' => '积分订单'
        ),
        'Online' => array(
            // 'sentmes' => '发布消息',
            'index' => '老师列表',
            'editcourse' => '添加老师',
            // 'indexgift' => '会话列表',
            // 'editgift' => '编辑会话'
        ),
        'Ovideo' => array(
            'index' => '视讯列表',
            'editcourse' => '添加视讯'
        ),
        'Auction' => array(
            'index?typ=biding' => '拍品列表',
            'audit' => '待审核列表',
            'add_special' => '添加专场',
            'special?typ=biding' => '专场列表',
            'add_meeting' => '添加拍卖会',
            'meeting' => '拍卖会列表',
            'set_auction' => '拍卖配置',
            'seller_pledge' => '卖家保证金'
        ),
        'Order' => array(
            'index' => '拍卖订单',
            'crowd' => '申购订单',
            // 'index?typ=goods' => '一口价订单',
            'set_order' => '订单配置',
            
        ),
        'Link' => array(
            'index' => '友情链接列表',
            'add' => '添加友情链接'
        ),
        'News' => array(
            'add' => '发布文章',
            'index' => '文章列表',
            'category' => '文章分类管理',
        ),
        'Advertising' => array(
            'index' => '广告列表',
            'add_advertising' => '添加广告',
            'position' => '广告位列表',
            'add_position' => '添加广告位'
        ),
        'Payment' => array(
            'index' => '支付订单',
            'pay_gallery' => '支付接口'
        ),
        'SysData' => array(
            'index' => '数据库备份',
            'restore' => '数据库导入',
            'zipList' => '数据库压缩包',
            'repair' => '数据库优化修复'
        ),
        'Access' => array(
            'index' => '后台用户',
            'nodeList' => '节点管理',
            'roleList' => '角色管理',
            'addAdmin' => '添加管理员',
            'addNode' => '添加节点',
            'addRole' => '添加角色',
        ),
        'Weixin' => array(
            'index' => '图文消息列表',
            'addurl' => '添加图文消息',
            'weimenu' => '微信自定义菜单',
            'weiconfig' => '微信接口和分享配置',
            'sharerecord' => '用户分享记录',
            'autoreply'=> '自动回复',

        ),
    ),
    
    'PAGE_SIZE' =>20,//分页数量
    
    /*
     * 以下是关于广告图片配置
     */
    'ADV_PICPATH'=>'Advertising',//商品图片上传路径（相对于根路径下）
    'ADV_MAX_WIDTH'=>'1400',//广告图片最大宽度
    'ADV_MAX_HEIGHT'=>'700',//广告图片最大高度
    /*
     * 以下是关于editor文章图片上传配置
     */
    'ARTICLE_PICPATH'=>'Article',//文章内图片上传路径（相对于根路径下）
    'ART_MAX_WIDTH'=>'1000',//广告图片最大宽度
    /*
     * 以下是关于分类图标图片上传配置
     */
    'CATE_PICPATH'=>'Category',//分类图标上传路径（相对于根路径下）
    'CATE_ICO_WIDTH'=>'100',//分类图标宽度
    'CATE_ICO_HEIGHT'=>'100',//分类图标高度

    /*
     * 以下是关于友情链接图标图片上传配置
     */
    'LINK_PICPATH'=>'Link',//友情链接图标上传路径（相对于根路径下）
    'LINK_ICO_WIDTH'=>'128',//友情链接图标宽度
    'LINK_ICO_HEIGHT'=>'48',//友情链接图标高度

    /*
     * 以下是关于文章标题图片上传配置
     */
    'NEWS_PICPATH'=>'News',//文章图标上传路径（相对于根路径下）
    'NEWS_ICO_WIDTH'=>'180',//文章图标宽度
    'NEWS_ICO_HEIGHT'=>'100',//文章图标高度

    /*
     * 以下是关于专场图片上传配置
     */
    'SPECIAL_PICPATH'=>'Special',//专场图片上传路径（相对于根路径下）
    'SPECIAL_ICO_WIDTH'=>'520',//专场列表图片宽度
    'SPECIAL_ICO_HEIGHT'=>'220',//专场列表图片高度
    'SPECIAL_BANNER_WIDTH'=>'2000',//专场banner图片宽度
    'SPECIAL_BANNER_HEIGHT'=>'300',//专场banner图片高度
    'CROWD_BANNER_WIDTH'=>'790',//专场banner图片宽度
    'CROWD_BANNER_HEIGHT'=>'260',//专场banner图片高度
    /*
     * 以下是关于拍卖会图片上传配置
     */
    'MEETING_PICPATH'=>'Meeting',//拍卖会图片上传路径（相对于根路径下）
    'MEETING_ICO_WIDTH'=>'700',//拍卖会列表图片宽度
    'MEETING_ICO_HEIGHT'=>'296',//拍卖会列表图片高度
    'MEETING_BANNER_WIDTH'=>'2000',//拍卖会banner图片宽度
    'MEETING_BANNER_HEIGHT'=>'300',//拍卖会banner图片高度

    /*
     * 以下是RBAC认证配置信息
     */
    'USER_AUTH_ON' => true,
    'USER_AUTH_TYPE' => 2, // 默认认证类型 1 登录认证 2 实时认证
    'USER_AUTH_KEY' => 'authId', // 用户认证SESSION标记
//    'ADMIN_AUTH_KEY' => '1772703372@qq.com',
    'USER_AUTH_MODEL' => 'Admin', // 默认验证数据表模型
    'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式encrypt
    'USER_AUTH_GATEWAY' => '/admin/Public/index', // 默认认证网关
    'NOT_AUTH_MODULE' => 'Public,Upload', // 默认无需认证模块
    'REQUIRE_AUTH_MODULE' => '', // 默认需要认证模块
    'NOT_AUTH_ACTION' => 'search,getcate,getFilt,getUser,getExtends,checkNewsTitle,goodPicOrder,del_pic,cutview,cutoper,delIco,order_filtrate,getChild,order_fields,onOff_fields,region_fields,region,sort,order_advertising,forbid,order_navigation,search_special,del_specpic,search_meeting,del_meetpic,search_sms', // 默认无需认证操作
    'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
    'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
    'GUEST_AUTH_ID' => 0, // 游客的用户ID
    'RBAC_ROLE_TABLE' => $DB_PREFIX . 'role',
    'RBAC_USER_TABLE' => $DB_PREFIX . 'role_user',
    'RBAC_ACCESS_TABLE' => $DB_PREFIX . 'access',
    'RBAC_NODE_TABLE' => $DB_PREFIX . 'node',

    'LOCK_ID'=>array(
        'link'=>'1,2,3',
        'article'=>'1,2,3',
        'goods'=>'1,2,3',
        'art_sun'=>'1,2,3'
        ),
    /*
     * 系统备份数据库时每个sql分卷大小，单位字节
     */
    'sqlFileSize' => 5242880, //该值不可太大，否则会导致内存溢出备份、恢复失败，合理大小在512K~10M间，建议5M一卷
        //10M=1024*1024*10=10485760
        //5M=5*1024*1024=5242880
    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => '//static.fjsxpmh.com/Public',
        '__IMG__'    => '//static.fjsxpmh.com/Public/Admin/Img',
        '__CSS__'    => '//static.fjsxpmh.com/Public/Admin/Css',
        '__JS__'     => '//static.fjsxpmh.com/Public/Admin/Js',
        '--PUBLIC--'=> '//www.fjsxpmh.com/Public',
        '__WEBSOCKET__'=> '//static.fjsxpmh.com/Public/WebSocketMain'
    ),
);

//return array_merge($config_arr1, $config_arr2);
?>