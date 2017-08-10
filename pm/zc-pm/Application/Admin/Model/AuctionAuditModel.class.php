<?php
namespace Admin\Model;

use Think\Model\ViewModel;

class AuctionAuditModel extends ViewModel {
    Protected $viewFields = array(
        'Auction_audit' => array(
            'pid', 'gid','type','sellerid','pname','starttime','endtime','aid','pattern','sid','mid','crd_no',
            '_type' => 'LEFT'
            ),
        'Goods' => array(
            'cid','pictures',
            '_on' => 'Auction_audit.gid = Goods.id',
            '_type' => 'LEFT'
            ),
        'Special_auction' => array(
            'sname',
            '_on' => 'Auction_audit.sid = Special_auction.sid',
            '_type' => 'LEFT'
            ),
        'Meeting_auction' => array(
            'mname',
            '_on' => 'Auction_audit.mid = Meeting_auction.mid'
            )
    );
    
    /**
     * [listAuction description]
     * @param  integer $firstRow [分页起始]
     * @param  integer $listRows [分页结束]
     * @param  [type]  $where    [筛选条件]
     * @return [type]            [拍品列表]
     */
    public function listAuction($firstRow = 0, $listRows = 20, $where,$od) {

        $list = $this->limit($firstRow.','.$listRows)->order($od)->where($where)->select();
        // echo  $this->getLastSql();
        // var_dump($list);exit();
        $member=M('member');
        $aidArr = M("Admin")->field("`aid`,`email`,`nickname`")->select();
        foreach ($aidArr as $k => $v) {
            $aids[$v['aid']] = $v;
        }
        unset($aidArr);
        $cidArr = M("Goods_category")->field("`cid`,`name`")->select();
        foreach ($cidArr as $k => $v) {
            $cids[$v['cid']] = $v;
        }
        unset($cidArr);
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
        foreach ($list as $k => $v) {
            $list[$k]['aidName'] =$aids[$v['aid']]['nickname'] == '' ? $aids[$v['aid']]['email'] : $aids[$v['aid']]['nickname'];
            $list[$k]['cidName'] = $cids[$v['cid']]['name'];
            $uPath = $cat->getPath($v['cid']);
            $list[$k]['pidName'] = $uPath[0]['name'];
            $picarr = explode('|', $v['pictures']);
            $list[$k]['pimg'] = $picarr[0];
            // 拍品状态
            $ntime = time();
            if($v['starttime'] <= $ntime && $v['endtime'] >= $ntime){
                $list[$k]['st'] = '在拍';
            }elseif ($v['endtime'] < $ntime) {
                $list[$k]['st'] = '成交';
            }elseif ($v['starttime']>$ntime) {
                $list[$k]['st'] = '待拍';
            }
            $list[$k]['seller'] = $member->where(array('uid'=>$v['sellerid']))->field('account,nickname,avatar')->find();
        }
        return $list;
    }
}