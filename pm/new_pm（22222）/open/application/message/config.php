<?php
/**
 * @function 统一配置文件
 * @author ljx
 */
return array(
    /*url begin*/
    'basic_api_url' => "http://api.wode-mall.com/basic/", //base api
    /*url end*/
    'sms' => array(
        // https://ak-console.aliyun.com/#/accesskey
        'ali' => array(
            'AccessKeyId' => 'LTAIzKWUKX8MEebb',
            'AccessKeySecret' => 'ok1yLA2QWkIwLCX1jmckVqGCYH0xUV',
            // 签名列表
            'sign' => array(
                'default' => '阿里云短信测试专用', // 默认签名 首玺拍卖  林纳克斯
            ),
            // 短信模板
            'template' => array(
                'zhuce' => 'SMS_94295461', // SMS_79530010 SMS_47210042
                'xiugai' => 'SMS_94295460',
                'denglu' => 'SMS_47210044',
                'duihuan' => 'SMS_66780267',
            )
        ),
        'jiguang' => array(
            
        ),
        'and-so-on' => array(
            
        )
    ),
    // other third-part service config, classify by service...
);
