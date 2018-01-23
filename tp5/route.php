<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


//Route::controller($rule, $route)是先调用get、post...路由方法，再调用rule方法，然后调用setRule方法进行路由设置
//同样的规则（rule），不同的路由(route)，返回不一样的类型，但结果都是一样，示例如下：

//（1）返回类型为模块
//\think\Route::controller('controller', 'index/Blog');
//控制器注册 http://www.autologin.zxl/controller/info会对应http://www.autologin.zxl/index/Blog/getinfo
//Array ( [type] => module [module] => Array ( [0] => index [1] => Blog [2] => getinfo ) [convert] => )

//（2）返回类型为重定向
//\think\Route::controller('controller', '/index/Blog');
//访问http://www.autologin.zxl/controller/info 会重定向跳转到 http://www.autologin.zxl/index/Blog/getinfo页面
//Array ( [type] => redirect [url] => /index/Blog/getinfo [status] => 301 )

//（3）返回类型为方法
//\think\Route::controller('controller', 'app\\index\\controller\\Blog');
//Array ( [type] => method [method] => Array ( [0] => \index\Blog [1] => getinfo ) )

//（4）返回类型为控制器
//\think\Route::controller('controller', '@index/Blog');
//Array ( [type] => controller [controller] => index/Blog/getinfo )

////（5）返回类型为闭包(匿名函数)
//\think\Route::get('controller/:name', function($name){ return 'Hello,'.$name;});
//Array ( [type] => function [function] => Closure Object ( [parameter] => Array ( [$name] => ) ) ) 




//\think\Route::get('blog', 'index/Blog/getinfo');
//http://www.autologin.zxl/blog会对应http://www.autologin.zxl/index/Blog/getinfo



//return [
//    '__pattern__' => [
//        'name' => '\w+',
//    ],
//    '[hello]'     => [
//        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//        ':name' => ['index/hello', ['method' => 'post']],
//    ],
//
//];
