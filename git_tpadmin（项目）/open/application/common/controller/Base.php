<?php
namespace app\common\controller;

use think\Config;
use think\Controller;
use Odan\Jwt\JsonWebToken;

/**
 * 基类
 */
class Base extends Controller
{
    public function createToken()
    {
        $key = Config::get('jwt_key');
        $payload = [
            'iss' => 1,
            'exp' => strtotime(date('Y-m-d H:i:s') . ' + 1 day'),
            'aud' => '',
            'nbf' => time(),
            'iat' => time(),
            'jti' => uniqid('', true),
            'user_id' => '100001'
        ];
        $jwt = new JsonWebToken();
        $token = $jwt->encode($payload, $key);
        return $token;
    }
}