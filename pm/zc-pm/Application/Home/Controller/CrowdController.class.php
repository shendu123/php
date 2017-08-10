<?php
namespace Home\Controller;

class CrowdController extends CommonController {

    /**
     * 申购首页
    */
    public function index(){
        $typ = I('get.typ') ? I('get.typ') : 'biding'; 
        $ws = bidType($typ, 3);
        $nowPage    = intval($_GET['p']) == 0 ? 1 : intval($_GET['p']);
        $firstRow   = C('PAGE_SIZE') * ($nowPage - 1);
        $key = S("crowd_list_{$typ}_key");
        $pConf = page($count, C('PAGE_SIZE'));

        $key = S("crowd_list_{$typ}_key");
        if (empty($key)) {
            $key = time();
            S("crowd_list_{$typ}_key", $key);
        }

        $data = S("crowd_list_{$typ}_{$key}_{$firstRow}");
        if (empty($data)) {
            $data['count'] = $count = D('Crowd')->where($ws['bidType'])->count();
            $pConf = page($count, C('PAGE_SIZE'));
            $data['list'] = $list = D('Crowd')->where($ws['bidType'])->limit($pConf['first'].','.$pConf['list'])->order('endtime DESC')->field('crowd_id,name,main_img,target_money,support_money,starttime,endtime')->select();
            S("crowd_list_{$typ}_{$key}_{$pConf['first']}",$data,['expire'=>600]);
        }
        else {
            $count = $data['count'];
            $pConf = page($count, C('PAGE_SIZE'));
            $list = $data['list'];
        }
        // 申购列表格式化
        foreach ($list as $ck => $cv) {
            $list[$ck]['percent'] = $cv['target_money'] > 0 ? round(100 * $cv['support_money'] / $cv['target_money']) :100;
            switch(I('get.typ')) {
                case 'bidend':
                    $list[$ck]['dt'] = '0天';
                    $list[$ck]['dt-tag'] = '剩余时间';
                    break;
                case 'future':
                    $dt = timediff(time(), $cv['starttime']);
                    $list[$ck]['dt'] = $dt['day'] > 0 ? ($dt['day'] +  ($dt['hour'] > 0 ? 1 : 0)) . '天' : $dt['hour'] .'小时' ;
                    $list[$ck]['dt-tag'] = '距开始';
                    break;
                default: //biding
                    $dt = timediff(time(), $cv['endtime']);
                    $list[$ck]['dt'] = $dt['day'] > 0 ? ($dt['day'] +  ($dt['hour'] > 0 ? 1 : 0)) . '天' : $dt['hour'] .'小时' ;
                    $list[$ck]['dt-tag'] = '剩余时间';
            }
        }

        $this->saytyp = $ws['saytyp'];
        $this->list = $list;
        $this->page = $pConf['show']; //分页分配

        $this->display();
    }

    // 申购详情页---------------------------------------------------
    public function items(){
        $ism = $this->ism;

        $this->crowd = D('Crowd')->detail(I('get.cid'));
        $this->items = D('CrowdItems')->items(I('get.cid'));
        // var_dump($this->items);exit();
        $this->display();
    }

    public function support() {
        $this->checkLogin(1);
        if(! M('deliver_address')->where(array('uid'=>$this->cUid))->find()) {
            $this->error('请完善您的地址信息！',U('Member/deliver_address'));
        }
        $item = D('CrowdItems')->where(array('ciid' => I('get.ciid')))->find();
        //刷单id
        if($item['crowd_id']==48){
            $item['price']=0.01;
        }
        if(empty($item)) {
            $this->error('您参与申购的商品不存在，请重新选择！');
        }
        $goods_name=M('goods')->where('id ='.$item['gid'])->getField('title');
        $systemLog=M('system_log');
        $logdata['create_time']=time();
        $logdata['user_name']= M('Member')->where('uid ='.$this->cUid)->getField('nickname');
        $logdata['user_type']=1;//0后台，1前台
        $logdata['url']=$_SERVER['REQUEST_URI'];
        $logdata['action']="申购";
        $logdata['description']="对商品名为”{$goods_name}“,价格为”{$item['price']}“的商品生成申购订单";
        $logdata['ip']=$_SERVER["REMOTE_ADDR"]; 
        if($order = D('CrowdOrder')->generate($item, array('aid' => $_SESSION['aid'], 'business_id' => $_SESSION['business_id'], 'uid' => $this->cUid))) {
            $logdata['description'].=$order;
            $logdata['status']=1;
            $systemLog->add($logdata);
            header('Location:'.U('Member/crd_payment_order', array('crd_no' => $order)));
        } else {       
            $systemLog->add($logdata);
            $this->error('订单生成失败，请稍后再试！');
        }
    }
}