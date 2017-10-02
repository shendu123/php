<?php
/**
 * @Author AJMstr
 * @date 2017-4-28
 */
namespace app\basic\model;

use think\Model;
use think\Db;

class Member extends Model
{

    public function saveData($po)
    {
        $uid = $this->where(" phone = {$po['phone']} ")->column("uid");
        
        if ($uid) {
            return "zcgd"; // 注册过的
        }
        
        $da['account'] = $this->issetData($po['name'], '');
        $da['nickname'] = substr_replace($po['phone'], '*****', 3, 5);
        $da['pwd'] = md5(md5($this->issetData($po['password'], 0)));
        $da['phone'] = $this->issetData($po['phone'], 2);
        $da['mobile'] = $this->issetData($po['phone'], 2);
        $da['business_id'] = $this->issetData($po['businessid'], 0);
        
        $da['email'] = $this->issetData($po['email'], '');
        $da['truename'] = $this->issetData($po['truename'], '');
        $da['birthday'] = $this->issetData($po['birthday'], 0);
        $da['sex'] = $this->issetData($po['sex'], 0);
        $da['address'] = $this->issetData($po['address'], '');
        $da['city'] = $this->issetData($po['city'], 0);
        $da['province'] = $this->issetData($po['province'], 0);
        $da['aid'] = $this->issetData($po['aid'], 0);
        $da['pay_wallet_id'] = $this->issetData($po['pay_wallet_id'], 0);
        // $da['iscom'] = $this->issetData($po['iscom'], 2);
        
        $id = Db::table('opb_member')->insertGetId($da);
        
        if ($id) {
            $dab['member_id'] = $id;
            $dab['rule_type'] = $po['type'] == 'qiye' ? 10 : 0;
            $dab['rule_oprid'] = $this->issetData($po['rule_oprid'], 0);
            $dab['rule_from'] = $this->issetData($po['rule_from'], 0);
            $dab['business_id'] = $this->issetData($po['businessid'], 0);
            $dab['rule_intime'] = time();
            $dab['rule_uptime'] = $this->issetData($po['rule_uptime'], 0);
            $res = Db::table('opb_member_rule')->insert($dab);
            return [
                $id
            ];
        } else {
            return 0;
        }
    }

    public function issetData(&$a, $b)
    {
        return isset($a) ? $a : $b;
    }

    public function getUidBy($username, $password)
    {
        return $this->where([
            'email|account|mobile' => $username,
            'pwd' => $password
        ])->value('uid');
    }

    public function Info($where)
    {
        return $this->where($wehre)->find();
    }

    public function getName($uid)
    {
        return $this->where(" uid = {$uid} ")->column("account");
    }

    public function changepwd($phone, $new)
    {
        $res = Db::table('opb_member')->where("phone = '" . $phone . "'")->setField("pwd", md5($new));
        return $res;
    }

    public function changeName($uid, $new)
    {
        $res = Db::table('opb_member')->where("uid = {$uid}")->setField("nickname", $new);
        return $res;
    }

    public function changePicurl($uid, $new)
    {
        $res = Db::table('opb_member')->where("uid = {$uid}")->setField("avatar", $new);
        return $res;
    }

    public function changeSex($uid, $new)
    {
        $res = Db::table('opb_member')->where("uid = {$uid}")->setField("sex", $new);
        return $res;
    }

    public function saveCode($id, $code)
    {
        $data['id'] = $id;
        $data['code'] = $code;
        $res = Db::table('opb_code')->insert($data);
        return $res;
    }

    public function getCode($id)
    {
        $res = Db::table('opb_code')->where("id = '{$id}'")->column("code,codetime");
        $data = '';
        foreach ($res as $key => $v) {
            $data['code'] = $key;
            $data['codetime'] = $v;
        }
        return $data;
    }

    public function getUserInfoB($uid)
    {
        $returnData = array();
        
        // case 商户会员信息 TODO rule 连接方式 后期改为inner 并加入条件rule_check_status rule_state
        $fields_member = "mem.uid, mem.nickname, mem.truename, mem.account, mem.phone, mem.mobile, mem.business_id";
        $fields_rule = ",rule.rule_check_status, rule.rule_type, rule.rule_from, rule.rule_state";
        $fields_com = ",com.com_id,com.com_business_id,com.com_name";
        $fields = $fields_member . $fields_rule . $fields_com;
        $userInfo_mixed = Db::table('opb_member')->alias('mem')
            ->join('opb_member_rule rule', 'rule.member_id = mem.uid', 'LEFT')
            ->join('opb_member_company com', 'com.uid = mem.uid', 'LEFT')
            ->where('mem.uid', $uid)
            ->column($fields);
        $userInfo_mixed = $userInfo_mixed[$uid];
        
        // member
        $returnData['user'] = array(
            'user_id' => $userInfo_mixed['uid'],
            'nickname' => $userInfo_mixed['nickname'],
            'truename' => $userInfo_mixed['truename'],
            'account' => $userInfo_mixed['account'],
            'phone' => $userInfo_mixed['phone'],
            'mobile' => $userInfo_mixed['mobile'],
            'business_id' => $userInfo_mixed['business_id'],
            'user_name' => $userInfo_mixed['account']
        );
        // rule
        $returnData['rule'] = array(
            'rule_type' => $userInfo_mixed['rule_type'],
            'rule_from' => $userInfo_mixed['rule_from'],
            'rule_state' => $userInfo_mixed['rule_state'],
            'rule_check_status' => $userInfo_mixed['rule_check_status']
        );
        // if it's member company
        if ($returnData['rule']['rule_type'] == 10) {
            $returnData['com'] = array(
                'com_id' => $userInfo_mixed['com_id'],
                'com_business_id' => $userInfo_mixed['com_business_id'],
                'com_name' => $userInfo_mixed['com_name']
            );
        }

        // case 商户业务系统信息
        $businessInfo = $this->businessInfo($returnData['user']['business_id']);
        
        /** 
        list ($pid, $son_ids) = $this->getIdByBid($returnData['user']['business_id']);
        // case TODO 商户会员等级信息
        // case TODO 所属上级商户基本信息
        $business['parent'] = $this->businessInfo($pid);
        // case TODO 所属下级商户基本信息
        if (is_array($son_ids)) {
            foreach ($son_ids as $k => $v) {
                $business['son'][] = $this->businessInfo($v);
            }
        } else {
            $business['son'] = $this->businessInfo($son_ids);
        }
        $returnData['businessRelative'] = $business;        
        // case TODO 自身商户等级信息
        */
        
        $returnData['business'] = $businessInfo;
        
        
        return $returnData;
    }

    public function getIdByBid($bid)
    {
        $pid = '';
        $sids = '';
        $son_ids = [];
        $pid = Db::table('opb_business')->where([
            'business_id' => $bid
        ])->value('pid');
        $sids = Db::table('opb_business')->where([
            'pid' => $bid
        ])
            ->field('business_id')
            ->select();
        if ($sids) {
            foreach ($sids as $k => $v) {
                $son_ids[] = $v['business_id'];
            }
        }
        return [
            $pid,
            $son_ids
        ];
    }

    public function businessInfo($bid)
    {
        $sql_query = "SELECT b.business_id,b.name,b.sysid, sys.sysid AS sys_id,sys.name AS sys_name,sys.title 
                    FROM opb_system AS sys 
                    INNER JOIN opb_business AS b ON b.sysid = sys.sysid
                    WHERE b.business_id in ('{$bid}')";
        $businessInfo_temp = Db::query($sql_query);
        $businessInfo = array();
        foreach ($businessInfo_temp as $key => $val) {
            $businessInfo['business_id'] = $val['business_id'];
            $businessInfo['name'] = $val['name'];
            $businessInfo['sysid'] = $val['sysid'];
            $businessInfo['systeminfo'][] = array(
                'sysid' => $val['sys_id'],
                'name' => $val['sys_name'],
                'title' => $val['title']
            );
        }
        return $businessInfo;
    }

    public function getUserInfo($uid)
    {
        $res = Db::table('opb_member')->where('uid', $uid)
            ->field('uid,nickname,truename,account,phone,mobile,business_id,avatar,sex')
            ->find();
        // 获取用户默认地址
        $addressId = Db::table('opb_delivery_address')->where([
            'owner_id' => $uid,
            'addr_isdefault' => 3
        ])->value('id');
        if (! $addressId) {
            $addressId = Db::table('opb_delivery_address')->where([
                'owner_id' => $uid
            ])->value('id');
        }
        $addressInfo = '';
        if ($addressId) {
            $addressInfo = model('DeliveryAddress')->getDataById($addressId)[0];
        }
        if ($res) {
            $res['addressInfo'] = $addressInfo;
            return $res;
        } else {
            return "error--" . $uid;
        }
    }

    public function getUserInfoByInid($id , $keyword = '')
    {   
		$res='';
		$where['uid'] = ['in',$id];
		if($keyword){
			$where['nickname'] = $keyword;
		}
        if($id){
            $res = Db::table('opb_member')->where($where)
            ->field('uid,nickname,truename,account,phone,business_id,avatar,sex,mobile')
            ->select();
        }
        return $res;
    }
}