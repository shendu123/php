<?php
namespace Admin\Controller;
use Think\Controller;
use Library\Util\Util;


//加盟商相关
class AllianceController extends CommonController {
    /**
     * 生成管理员帐号为新增的加盟商
     */
    public function createAdminForBusiness(){
        $role = M('role');
        $da1 = M('business')->select();

        $admin = M('admin');
        $da2 = $admin->select();

        $adminbusi = array();

        foreach ($da2 as $k) {
            $adminbusi[] = $k['business_id'];
        }

        $bb = new Util();
        $adminbusi=$bb->a_array_unique($adminbusi);

        foreach ($da1 as $k) {
            if(!in_array($k['business_id'], $adminbusi)){
                //生成初始化 管理员
                $in['nickname'] = $k['name']."管理员";
                $in['email'] = 'super@fjsxpmh.com';
                $in['pwd'] = encrypt('admin');
                $in['status'] = '1';
                $in['remark'] =  $k['name'];

                $in['time'] = time();
                $in['business_id'] = $k['business_id'];
                $guliid= $admin->add($in);

                //生成初始化 管理员组（角色）
                $roii = $role->where(array('name' => '超级管理员','business_id'=>$k['business_id'] ))->select();
                if($roii[0]['id']){
                    $zuid = $roii[0]['id'];
                }else{
                    $ro['name']="超级管理员";
                    $ro['pid']='0';
                    $ro['status']='1';
                    $ro['remark']="系统内置超级管理员组，不受权限分配账号限制";
                    $ro['business_id'] = $k['business_id'];
                    $zuid = $role->add($ro);
                }

                //初始化 角色-用户关联
                $lineRo = M('role_user');
                $lro['role_id'] = $zuid;
                $lro['user_id'] = $guliid;
                $lro['business_id'] = $k['business_id'];
                $lineRo->add($lro);

                //输出
                echo $k['name'].":<br>";
                echo "生成初始管理帐号：super@fjsxpmh.com"."<br>";
                echo "生成初始密码(请记住密码)：admin"."<br>";
                echo "所属组：初始化组"."<br>";
                echo "初始化组权限:".$zuid."<br>";
            }
        }
    }

    /**
     * [a_array_unique 一维数组去重]
     * @param  [type] $array [数组]
     * @return [type]        [0->int(1),...]
     */
    public function a_array_unique($array){
       $out = array();
       foreach ($array as $key=>$value) {
           if (!in_array($value, $out)){
               $out[$key] = $value;
           }
       }
       return array_values($out);
    }
















}