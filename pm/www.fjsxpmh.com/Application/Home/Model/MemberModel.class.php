<?php
namespace Home\Model;
use Think\Model;
class MemberModel extends Model {
    
    public function reset_pwd($uid){
        $where = array('uid'=>$uid);
        $M = M('Member');
        // 如果重置密码
        if(I('post.type')=='reset'){
            $pwd = $M->where($where)->getField('pwd');
            if($pwd != encrypt(I('post.pwd'))){
                return(array('status' => 0, 'info' => '当前密码错误','url'=>__SELF__));
                exit;
            }elseif (I('post.new_pwd') != I('post.new_pwded')) {
                return(array('status' => 0, 'info' => '两次密码不一致','url'=>__SELF__));
                exit;
            }
        }
        // 设置密码
        if($M->where($where)->setField('pwd',encrypt(I('post.new_pwd')))){
            // 如果重置密码
            if(I('post.type')=='reset'){
                return(array('status' => 1, 'info' => '修改成功，下次请用新密码进行登陆','url' => U("Member/index")));
            // 如果重置密码
            }else{
                return(array('status' => 1, 'info' => '设置成功，您可以在电脑版用该密码登陆','url' => U("Member/index")));
            }
        }else{
            return(array('status' => 0, 'info' => '修改失败，请重试','url'=>__SELF__));
        }
    }
    public function unfreeze($uid,$gid,$tp){
        // 返还冻结保证金和信用额度
        $gfeez = M('Goods_user')->where(array('g-u'=>'p-u','uid'=>$uid,'gid'=>$gid))->find();
    }
       
}

?>
