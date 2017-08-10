<?php
namespace Home\Model;

use Think\Model;

class CrowdOrderModel extends Model {

    public function generate($item, $user) {
        do {// 生成不重复的定代号$order_no
            $order_no = createNo('CRD');
            $reno = $this->where(array('crd_no' => $order_no))->count();
        } while ($reno != 0);

        $oData = array(
            'crd_no' => $order_no,
            'crowd_id' => $item['crowd_id'],
            'ciid' => $item['ciid'],
            'gid' => $item['gid'],
            'uid' => $user['uid'],
            'total_price' => $item['price'] + $item['delivery_fee'],
            'price' => $item['price'],
            'broker' => perbroker($item['broker_type'], $item['price'], $item['broker']),
            'status' => 0,
            'is_refund' => 0,
            'business_id' => M('Crowd')->where(array('crowd_id' => $item['crowd_id']))->field('business_id')->find()['business_id'],
            'prom_business_id' => $user['business_id'],
            'prom_aid' => $user['aid']?$user['aid']:0,
            'time' => time()
        );

        $commit = $this->add($oData);
/*
        $this->startTrans();
        $commit = $item['is_limit_buy'] == 'yes' ? false : true;

        if($item['is_limit_buy'] == 'yes' && $item['limit_stock'] > 0) {
            if(D('CrowdItems')->where('ciid='.(int)$item['ciid'].' AND limit_stock > 0')->setDec('limit_stock', 1)) {
                $commit = true;
            }
        }

        if($commit) {
            D('CrowdItems')->where(array('ciid' => $item['ciid']))->setInc('support_count', 1);
            D('CrowdItems')->where(array('ciid' => $item['ciid']))->setInc('support_money', $item['price']);
            D('Crowd')->where(array('crowd_id' => $item['crowd_id']))->setInc('support_count', 1);
            D('Crowd')->where(array('crowd_id' => $item['crowd_id']))->setInc('support_money', $item['price']);
            $commit = $this->add($oData);
        }

        if($commit) {
            $this->commit();
        } else {
            $this->rollback();
        }
*/
        return $commit ? $order_no : $commit;
    }

    public function updateAddress($crd_no, $address) {
        return $this->save(array(
            'crd_no' => $crd_no,
            'truename' => $address['truename'],
            'mobile' => $address['mobile'],
            'postalcode' => $address['postalcode'],
            'province' => $address['province'],
            'city' => $address['city'],
            'area' => $address['area'],
            'address' => $address['address']
        ));
    }
}