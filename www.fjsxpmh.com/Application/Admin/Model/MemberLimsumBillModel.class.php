<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class MemberLimsumBillModel extends ViewModel {
    Protected $viewFields = array(
        'Member_limsum_bill' => array(
             'order_no','uid','changetype','time','annotation','income','expend',
            '_type' => 'LEFT'
            ),
        'Member' => array(
            'uid','account','nickname','mobile','avatar',
            '_on' => 'Member_limsum_bill.uid = Member.uid'
            )
    );
}

?>
