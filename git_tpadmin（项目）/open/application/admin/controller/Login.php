<?php
namespace app\admin\controller;

use think\Request;
use app\common\model\User;
use app\common\controller\Base;
//use Odan\Jwt\JsonWebToken;
use think\captcha\Captcha;
use think\Config;
use think\Session;
use think\Db;
use think\Cache;
\think\Loader::import('controller/Jump', TRAIT_PATH, EXT);

class Login
{

    /** 登录
     * @param Request $request
     * @return mixed
     */
    public function checkLogin(Request $request)
    {
        $where['account']=$request->param('account','');
        $where['pwd']=md5($request->param('password',''));       
        $userInfo=Db::name('member')->field('uid,account,truename,status')->where($where)->find();
        if($userInfo){
           if($userInfo['status']==0){
               return json(['message'=>'账号被禁用'],200);
           }
           //Session::set(Config::get('rbac.user_auth_key'), $userInfo['id']);//session要共域
           Cache::set(Config::get('rbac.user_auth_key'), $userInfo['uid']);
        // 超级管理员标记
            if ($userInfo['uid'] == 1) {
                Cache::set(Config::get('rbac.admin_auth_key'), true);
            }
           return json($userInfo,200);
        }else{
           return json(['message'=>'用户名密码错误'],200); 
        }
    }

    /** 获取验证码
     * @param string $id
     * @return mixed
     */
    public function getCode($id="")
    {
        return captcha($id);
    }
    
     /** 登出
     * @param Request $request
     * @return mixed
     */
    public function logout()
    {
        //Session::delete('userInfo');
        Cache::rm(Config::get('rbac.user_auth_key'));
        Cache::rm(Config::get('rbac.admin_auth_key'));
        return json(['message'=>'退出成功'],200);
    }
}