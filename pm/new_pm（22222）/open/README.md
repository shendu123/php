php环境
>需安装couchbase 2.3.x扩展

首玺平台的服务层，通过接口的形式提供服务

##获取令牌

####URL
>basic/Login/accessToken

#####Mehod
>POST

#####参数<-

<font color="red">注</font>：要求 password = md5(password)

~~~
{
  appid:xxxx
  username:xxxx
  password:xxxxx
}
~~~

#####响应

~~~
{
  "access_token":"afb4233bbab475ebb4c8678492e8b3d4ebe79441",
  "expires":"2017-05-05 12:48:07",
  "refresh_token":"a4e8c4ca29847b635b034f72c9f2b42f5432a9ee"
}
~~~

## 刷新令牌
当 access_token 失效后，通过 refresh_token 重新获取 access_token
####URL
>basic/Token/refreshToken

#####Mehod
>POST

#####参数

~~~
{
  refresh_token: xxxx
}
~~~

#####响应

~~~
{
  access_token: xxxx  (7200,2小时）
  expires_in:xxxx
}
~~~

## 鉴权使用说明
如下所示，每个请求都将携带上前面第一步获取的令牌，资源服务器根据对access_token进行资源权限校验
##### Header

access_token:xxxxxxxxxxxxxxxxxx

##  获取菜单树
获取主菜单树，比如管理后台右侧的菜单树
####URL
>basic/Node/menu

#####Mehod
>GET

#####参数

~~~
{
  sysid: 1
}
~~~

#####响应

~~~
[
  {
    "id": 1,
    "pid": 0,
    "sysid": 1,
    "title": "系统功能",
    "icon": "",
    "url_value": "",
    "leaf": false,
    "child": [
      {
        "id": 2,
        "pid": 1,
        "sysid": 1,
        "title": "系统设置",
        "icon": "",
        "url_value": "basic/System/index",
        "leaf": true
      },
      {
        "id": 3,
        "pid": 1,
        "sysid": 1,
        "title": "节点管理",
        "icon": "",
        "url_value": "basic/Node/index",
        "leaf": true
      }
    ]
  },
  ……
]
~~~

## 获取页面操作项

####URL
>basic/Node/operation

#####Mehod
>GET

#####参数

~~~
{
  node_id: 1
}
~~~

#####响应

~~~
{
  
}
~~~
