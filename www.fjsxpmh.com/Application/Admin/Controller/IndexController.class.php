<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index() {
        // 取款请求
        $take = M('member_pledge_take');
        $this->takeAll = $take->count();
        $this->takeUn = $take->where('status=0')->count();
        // 过期拍卖订单
        $lbid = array(
            'type'=>array('in',array('0','1')),
            'deftime1'=>array('lt',time()),
            'status'=>array('in',array('0','4')),
            );
        // ----全部过期
        $losebidAll = M('goods_order')->where($lbid)->count();
        // ----未处理过期
        $lbid['status']=0;
        $losebidUn = M('goods_order')->where($lbid)->count();
        $this->losebidAll=$losebidAll;
        $this->losebidUn=$losebidUn;

        //服务器信息
        if (function_exists('gd_info')) {
            $gd = gd_info();
            $gd = $gd['GD Version'];
        } else {
            $gd = "不支持";
        }
        $info = array(
            '操作系统' => PHP_OS,
            '主机名IP端口' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            '程序目录' => WEB_ROOT,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            'GD库版本' => $gd,
//            'MYSQL版本' => mysql_get_server_info(),
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '采集函数检测' => ini_get('allow_url_fopen') ? '支持' : '不支持',
            'register_globals' => get_cfg_var("register_globals") == "1" ? "ON" : "OFF",
            'magic_quotes_gpc' => (1 === get_magic_quotes_gpc()) ? 'YES' : 'NO',
            'magic_quotes_runtime' => (1 === get_magic_quotes_runtime()) ? 'YES' : 'NO',
        );
        $this->assign('server_info', $info);
        // 计划任务状态
        if (S(C('CACHE_FIX').'scheduled')) {$scheduled = '已配置';}else{$scheduled = '未配置';}
        $this->scheduled = $scheduled;
        $this->display();
    }
    // 资金统计
    public function statistics(){
        $member = M('member');
        $where = array();
        $uwhere = array();
        $wstar = '';
        $bktime = '';
        if(I('get.')){
            if(I('get.start_time')!=''){
                $wstar .= "time >= ".strtotime(I('get.start_time'))." and ";
                $bktime .= "time3 >= ".strtotime(I('get.start_time'))." and ";
            }
            if(I('get.end_time')!=''){
                $wstar .= "time <= ".strtotime(I('get.end_time'));
                $bktime .= "time3 <= ".strtotime(I('get.end_time'));
            }
            if($wstar!=''){
                $where['_string'] = $wstar;
                $bkwhere['_string'] = $bktime;
            }
            if(I('get.account')!=''){
                $user = $member->where(array('account'=>I('get.account')))->field('uid,nickname,account')->find();
                if ($user) {
                    $where['uid'] = $user['uid'];
                    $uwhere['uid'] = $user['uid'];
                    $bkwhere['uid'] = $user['uid'];
                }else{
                    $this->error('用户不存在！',U('Index/statistics'));
                }
            }
            $keys= I('get.');
            $this->keys = $keys;
        }
        $wallet_bill = M('member_pledge_bill');
        $limsum_bill = M('member_limsum_bill');
        $walletlist = $member->where($uwhere)->field('uid,wallet_pledge,wallet_pledge_freeze,wallet_limsum,wallet_limsum_freeze')->select();
        $walletsum = array(
            'wallet_pledge'=>array_sum(array_reduce($walletlist, create_function('$v,$w', '$v[$w["uid"]]=$w["wallet_pledge"];return $v;'))),
            'wallet_pledge_freeze'=>array_sum(array_reduce($walletlist, create_function('$v,$w', '$v[$w["uid"]]=$w["wallet_pledge_freeze"];return $v;'))),
            'wallet_limsum'=>array_sum(array_reduce($walletlist, create_function('$v,$w', '$v[$w["uid"]]=$w["wallet_limsum"];return $v;'))),
            'wallet_limsum_freeze'=>array_sum(array_reduce($walletlist, create_function('$v,$w', '$v[$w["uid"]]=$w["wallet_limsum_freeze"];return $v;'))),
            );
        // 建站到开始时间冻结金额 freeze_where():返回冻结的查询条件
        $pledge_where_freeze = $wallet_bill->where($where)->where(freeze_where())->sum('expend');
        $limsum_where_freeze = $limsum_bill->where($where)->where(freeze_where())->sum('expend');

        // 建站到开始时间解冻金额 unfreeze_where():返回解冻的查询条件
        $pledge_where_unfreeze = $wallet_bill->where($where)->where(unfreeze_where())->sum('income');
        $limsum_where_unfreeze = $limsum_bill->where($where)->where(unfreeze_where())->sum('income');

        // 建站到开始时间扣除的金额 reduce_where():返回扣除的查询条件
        $pledge_where_reduce = $wallet_bill->where($where)->where(reduce_where())->sum('expend');
        $limsum_where_reduce = $limsum_bill->where($where)->where(reduce_where())->sum('expend');

        // 建站到开始时间增加的金额 increase_where():返回增加的查询条件
        $pledge_where_increase = $wallet_bill->where($where)->where(increase_where())->sum('income');
        $limsum_where_increase = $limsum_bill->where($where)->where(increase_where())->sum('income');

        // 建站到开始时间扣除冻结的金额 increase_freeze_where():返回扣除冻结的查询条件
        $pledge_where_increase_freeze = $wallet_bill->where($where)->where(increase_freeze_where())->sum('expend');
        $limsum_where_increase_freeze = $limsum_bill->where($where)->where(increase_freeze_where())->sum('expend');

        // pre(freeze_where());
        // pre(unfreeze_where());
        // pre(reduce_where());
        // pre(increase_where());
        // pre(increase_freeze_where());
        // die;
        // 查询条件余额
        $walletsum['wallet_pledge_where'] = ($pledge_where_increase-$pledge_where_reduce)-$pledge_where_increase_freeze;
        // 冻结余额
        $walletsum['wallet_pledge_where_freeze'] = $pledge_where_freeze-$pledge_where_unfreeze-$pledge_where_increase_freeze;
        // 查询条件内可用余额
        $walletsum['wallet_pledge_where_usable'] = $walletsum['wallet_pledge_where']-$walletsum['wallet_pledge_where_freeze'];

        // 查询条件信誉
        $walletsum['wallet_limsum_where'] = ($limsum_where_increase-$limsum_where_reduce)-$limsum_where_increase_freeze;
        // 冻结信誉
        $walletsum['wallet_limsum_where_freeze'] = $limsum_where_freeze-$limsum_where_unfreeze-$limsum_where_increase_freeze;
        // 查询条件内可用信誉
        $walletsum['wallet_limsum_where_usable'] = $walletsum['wallet_limsum_where']-$walletsum['wallet_limsum_where_freeze'];





        
        // 开始到结束时间


        // $walletsum['wallet_all_pledge_freeze'] = $wallet_bill->where(array(''))
        // // 账户增加条件
        // $iw = array('changetype'=>array('in',array('admin_deposit','pay_deposit','share_add','profit')));
        // $walletsum['wallet_all_pledge_increase']
        // $walletsum['wallet_all_pledge_usable']

// 余额
        // 可用余额
        $walletsum['wallet_pledge_usable'] = $walletsum['wallet_pledge']-$walletsum['wallet_pledge_freeze'];
        // 可用信誉
        $walletsum['wallet_limsum_usable'] = $walletsum['wallet_limsum']-$walletsum['wallet_limsum_freeze'];

        // 拍卖冻结
        $walletsum['wallet_pledge_bid_expend'] = $wallet_bill->where($where)->where(array('changetype'=>'bid_freeze'))->sum('expend');
        // 发布拍卖冻结
        $walletsum['wallet_pledge_add_expend'] = $wallet_bill->where($where)->where(array('changetype'=>'add_freeze'))->sum('expend');
        // 管理员冻结
        $walletsum['wallet_pledge_admin_freeze'] = $wallet_bill->where($where)->where(array('changetype'=>'admin_freeze'))->sum('expend');
        // 提现冻结
        $walletsum['wallet_pledge_take_freeze'] = $wallet_bill->where($where)->where(array('changetype'=>'extract_freeze'))->sum('expend');

        // 拍卖解冻
        $walletsum['wallet_pledge_bid_income'] = $wallet_bill->where($where)->where(array('changetype'=>'bid_unfreeze'))->sum('income');
        // 交易成功解冻
        $walletsum['wallet_pledge_add_income'] = $wallet_bill->where($where)->where(array('changetype'=>'add_unfreeze'))->sum('income');
        // 管理员解冻
        $walletsum['wallet_pledge_admin_unfreeze'] = $wallet_bill->where($where)->where(array('changetype'=>'admin_unfreeze'))->sum('income');

        // 卖家未按时发货扣除
        $walletsum['wallet_pledge_seller_break_deliver'] = $wallet_bill->where($where)->where(array('changetype'=>'seller_break_deliver'))->sum('expend');
        // 订单过期扣除
        $walletsum['wallet_pledge_buy_break_nopay'] = $wallet_bill->where($where)->where(array('changetype'=>'buy_break_nopay'))->sum('expend');
        
        // 保证金抵货款
        $walletsum['wallet_pledge_paypledge_expend'] = $wallet_bill->where($where)->where(array('changetype'=>'pay_pledge'))->sum('expend');
        // 支付扣除
        $walletsum['wallet_pledge_pay_expend'] = $wallet_bill->where($where)->where(array('changetype'=>'pay_deduct'))->sum('expend');
        // 管理员扣除余额
        $walletsum['wallet_pledge_admin_expend'] = $wallet_bill->where($where)->where(array('changetype'=>'admin_deduct'))->sum('expend');
        // 提现扣除
        $walletsum['wallet_pledge_take'] = $wallet_bill->where($where)->where(array('changetype'=>'extract'))->sum('expend');

        // 卖家未按时发货收入
        $walletsum['wallet_pledge_buy_break_deliver'] = $wallet_bill->where($where)->where(array('changetype'=>'buy_break_deliver'))->sum('income');
        // 订单过期收入
        $walletsum['wallet_pledge_seller_break_nopay'] = $wallet_bill->where($where)->where(array('changetype'=>'seller_break_nopay'))->sum('income');

        // 在线充值
        $walletsum['wallet_pledge_inlin_income'] = $wallet_bill->where($where)->where(array('changetype'=>'pay_deposit'))->sum('income');
        // 管理员充值余额
        $walletsum['wallet_pledge_admin_income'] = $wallet_bill->where($where)->where(array('changetype'=>'admin_deposit'))->sum('income');
        // 分享奖励
        // $walletsum['wallet_pledge_share_income'] = $wallet_bill->where($where)->where(array('changetype'=>'share_add'))->sum('income');
        // 交易收入
        $walletsum['wallet_pledge_profit_income'] = $wallet_bill->where($where)->where(array('changetype'=>'profit'))->sum('income');
        
// 信誉额度
        // 拍卖冻结
        $walletsum['wallet_limsum_bid_expend'] = $limsum_bill->where($where)->where(array('changetype'=>'bid_freeze'))->sum('expend');
        // 发布拍卖冻结
        $walletsum['wallet_limsum_add_expend'] = $limsum_bill->where($where)->where(array('changetype'=>'add_freeze'))->sum('expend');
        // 管理员冻结
        $walletsum['wallet_limsum_admin_freeze'] = $limsum_bill->where($where)->where(array('changetype'=>'admin_freeze'))->sum('expend');
        // 提现冻结
        $walletsum['wallet_limsum_take_freeze'] = $limsum_bill->where($where)->where(array('changetype'=>'extract_freeze'))->sum('expend');

        // 拍卖解冻
        $walletsum['wallet_limsum_bid_income'] = $limsum_bill->where($where)->where(array('changetype'=>'bid_unfreeze'))->sum('income');
        // 交易成功解冻
        $walletsum['wallet_limsum_add_income'] = $limsum_bill->where($where)->where(array('changetype'=>'add_unfreeze'))->sum('income');


        // 卖家未按时发货收入
        $walletsum['wallet_limsum_buy_break_deliver'] = $limsum_bill->where($where)->where(array('changetype'=>'buy_break_deliver'))->sum('income');
        // 订单过期收入
        $walletsum['wallet_limsum_seller_break_nopay'] = $limsum_bill->where($where)->where(array('changetype'=>'seller_break_nopay'))->sum('income');

        // 卖家未按时发货扣除
        $walletsum['wallet_limsum_seller_break_deliver'] = $limsum_bill->where($where)->where(array('changetype'=>'seller_break_deliver'))->sum('expend');
        // 订单过期扣除
        $walletsum['wallet_limsum_buy_break_nopay'] = $limsum_bill->where($where)->where(array('changetype'=>'buy_break_nopay'))->sum('expend');

        // 管理员解冻
        $walletsum['wallet_limsum_admin_unfreeze'] = $limsum_bill->where($where)->where(array('changetype'=>'admin_unfreeze'))->sum('income');

        // 管理员扣除余额
        $walletsum['wallet_limsum_admin_expend'] = $limsum_bill->where($where)->where(array('changetype'=>'admin_deduct'))->sum('expend');

        // 管理员充值余额
        $walletsum['wallet_limsum_admin_income'] = $limsum_bill->where($where)->where(array('changetype'=>'admin_deposit'))->sum('income');
        // 分享奖励
        $walletsum['wallet_limsum_share_income'] = $limsum_bill->where($where)->where(array('changetype'=>'share_add'))->sum('income');
// 佣金
        $goods_order = M('goods_order');
        $walletsum['broker_where'] = $goods_order->where($bkwhere)->where(array('status'=>array('in',array(3,11))))->sum('broker');
        $walletsum['broker_where_predict'] = $goods_order->where($bkwhere)->where(array('status'=>array('in',array(0,1,2))))->sum('broker');

        $walletsum['broker'] = $goods_order->where(array('status'=>array('in',array(3,11))))->sum('broker');
        $walletsum['broker_predict'] = $goods_order->where(array('status'=>array('in',array(0,1,2))))->sum('broker');

        $this->walletsum=$walletsum;
        $this->display();
    }
    //取款申请
    public function take(){
        $take = M('member_pledge_take');
        $member= M('member');
        if (IS_POST) {
            $this->checkToken();
            $post = I('post.');
            $sdata = array(
                'tid'=>$post['tid'],
                'status'=>$post['status'],
                'cause'=>$post['cause'],
                'dtime'=>time()
                );
            if($take->save($sdata)){
                // 扣除冻结的保证金
                $w = array('uid'=>$post['uid']);
                if($post['status']==1){
                    if($member->where($w)->setDec('wallet_pledge_freeze',$post['money'])&&$member->where($w)->setDec('wallet_pledge',$post['money'])){
                        // 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台解冻admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $pledge_data = array(
                            'order_no'=>createNo('rtk'),
                            'uid'=>$post['uid'],
                            'changetype'=>'extract',
                            'time'=>time(),
                            'annotation'=>$post['cause'],
                            'expend' => $post['money']
                            );
                        if(M('member_pledge_bill')->add($pledge_data)){
                            // 给用户发消息
                            sendSms($pledge_data['uid'],'系统发送','管理员已同意您的'.$pledge_data['expend'].'元保证金提现申请！即将为您转账请注意查收！备注：'.$pledge_data['expend']);
                            echojson(array('status' => 1, 'info' => '已处理申请为已提现','url'=>U('Index/take')));
                        } //写入用户账户记录
                    }
                }elseif ($post['status']==2) {
                    if($member->where($w)->setDec('wallet_pledge_freeze',$post['money'])){
						// 变动方式changetype 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台解冻admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
                        $pledge_data = array(
                            'order_no'=>createNo('suf'),
                            'uid'=>$post['uid'],
                            'changetype'=>'admin_unfreeze',
                            'time'=>time(),
                            'annotation'=>$post['cause'],
                            'income'=>$post['money'],
                            );
                        if(M('member_pledge_bill')->add($pledge_data)){
                            // 给用户发消息
                            sendSms($pledge_data['uid'],'系统发送','网站驳回了您'.$pledge_data['income'].'元提现申请！解冻保证金'.$pledge_data['income'].'元！备注：'.$pledge_data['remark']);
                            echojson(array('status' => 1, 'info' => '已处理申请为驳回申请'.$pledge_data['income'],'url'=>U('Index/take')));
                        } //写入用户账户记录
                    }
                }
            }
        }else{
            if(I('get.tid')){
                $tinfo = $take->where('tid='.I('get.tid'))->find();
                $tinfo['uaccount'] = $member->where('uid='.I('get.tid'))->getField('account');
                $this->tinfo=$tinfo;
                $this->display('rtake');
            }else{
                if(I('get.sw')!=''){
                    $sw=array('status'=>I('get.sw'));
                }
                // 分页配置
                $count = $take->where($sw)->count();
                $pConf = page($count,20);
                $take_list = $take->where($sw)->limit($pConf['first'].','.$pConf['list'])->order('time desc')->select();
                foreach ($take_list as $tk => $tv) {
                    $take_list[$tk]['uaccount'] = $member->where('uid='.$tv['uid'])->getField('account');
                }
                // 分配分页到模板
                $this->sw=I('get.sw');
                $this->page = $pConf['show']; 
                $this->take_list = $take_list;
                $this->display();
            }
        }
        

        
    }

    public function myInfo() {
        if (IS_POST) {
            $this->checkToken();
            echojson(D("Index")->my_info($_POST));
        } else {
            $this->display();
        }
    }

    public function cache() {
        $caches = array(
            "ConfigCache" => array("name" => "网站配置缓存", "path" => WEB_CACHE_PATH . "common~runtime.php"),
            "HomeCache" => array("name" => "网站前台缓存文件", "path" => WEB_CACHE_PATH . "Cache/Home/"),
            "AdminCache" => array("name" => "网站后台缓存文件", "path" => WEB_CACHE_PATH . "Cache/Admin/"),
            "HomeData" => array("name" => "网站前台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Data/Home/"),
            "AdminData" => array("name" => "网站后台数据库字段缓存文件", "path" => WEB_CACHE_PATH . "Data/Admin/"),
            "HomeLog" => array("name" => "网站日志缓存文件", "path" => WEB_CACHE_PATH . "Logs/"),
            "HomeTemp" => array("name" => "网站临时缓存文件", "path" => WEB_CACHE_PATH . "Temp/"),
            "MinFiles" => array("name" => "JS\CSS压缩缓存文件", "path" => WEB_CACHE_PATH . "MinFiles/")
        );
        if (IS_POST) {
            foreach ($_POST['cache'] as $path) {
                if (isset($caches[$path]))
                    delDirAndFile($caches[$path]['path']);
            }
           $this->checkToken();
            echojson(array("status"=>1,"info"=>"缓存文件已清除"));
        } else {
            $this->assign("caches", $caches);
            $this->display();
        }
    }

}