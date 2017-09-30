<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
include_once 'library/Alisms/core/Autoloader/Autoloader.php';
include_once 'library/Alisms/core/Regions/EndpointConfig.php';
include_once 'library/Alisms/core/DefaultAcsClient.php';

//$AKID ='LTAIXfnvFYfyedvW';//阿里云后台 api 接口 打开“我的Access Key”页面，页面地址：https://ak-console.aliyun.com/#/accesskey/
//$ASecret ='ffg42c69MXuL9MA3055631YewjkASb';//需要阿里后台获取

//config sdk auto load path.
Autoloader::addAutoloadPath("sms");
//Autoloader::addAutoloadPath("aliyun-php-sdk-ecs");
//Autoloader::addAutoloadPath("aliyun-php-sdk-batchcompute");
//Autoloader::addAutoloadPath("aliyun-php-sdk-sts");
//Autoloader::addAutoloadPath("aliyun-php-sdk-push");
//Autoloader::addAutoloadPath("aliyun-php-sdk-ram");
//Autoloader::addAutoloadPath("aliyun-php-sdk-ubsms");
//Autoloader::addAutoloadPath("aliyun-php-sdk-ubsms-inner");
//Autoloader::addAutoloadPath("aliyun-php-sdk-green");

//config http proxy	
define('ENABLE_HTTP_PROXY', FALSE);
define('HTTP_PROXY_IP', '127.0.0.1');
define('HTTP_PROXY_PORT', '8888');