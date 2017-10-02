<?php
return [
    'basic_api_url' => "http://api.wode-mall.com/basic/", // basic api
    'item_api_url' => "http://api.wode-mall.com/item/", // item api
    'crowd_api_url' => "http://api.wode-mall.com/crowd/", // crowd api
    'auction_api_url' => "http://api.wode-mall.com/auction/", // auction api
    'wxpay' => [
        'appid' => 'wx44b6629768a304ca',
        'wxappid' => 'wx44b6629768a304ca',
        'mchid' => '1433584302',
        'key' => '8saKJV978AS9jlKD2Js99sffjHFFY8FD',
        'appsecrect' => '4709ae21c816eb6e4208f1fbd7614081',
        'sslcert_path' => '../cert/apiclient_cert.pem',
        'sslkey_path' => '../cert/apiclient_key.pem',
        // 支付回调通知地址
        'notify_url' => 'http://ap.wode-mall.com:81/finance/Payreturn/wechat'
    ],
    // finance 模块签名
    'SIGN_KEY' => "s5sDghk8)ZL"
];