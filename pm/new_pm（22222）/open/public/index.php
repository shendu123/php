<?php
// [ 应用入口文件 ]
header('Access-Control-Allow-Origin:*');  
header('Access-Control-Allow-Methods:OPTIONS, GET, POST');
header('Access-Control-Allow-Headers:x-requested-with,accesstoken');
header('Access-Control-Allow-Credentials:true');

if(method() == 'OPTIONS') {
    echo 'true';
} else {
    define('APP_PATH', __DIR__ . '/../application/');
    require __DIR__ . '/environment.php';
    require __DIR__ . '/../thinkphp/start.php';
}

function method() {
    if (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
        $method = strtoupper($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE']);
    } else {
        $method = $_SERVER['REQUEST_METHOD'];
    }
    return $method;
}