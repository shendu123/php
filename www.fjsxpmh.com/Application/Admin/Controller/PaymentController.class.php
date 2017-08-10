<?php
namespace Admin\Controller;
use Think\Controller;
class PaymentController extends CommonController {
    /**
     * 支付订单列表
     * @return [type] [description]
     */
    public function index() {
        $M = M("payorder");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show']; //分配分页
        $this->order = D("Payment")->payList($pConf['first'], $pConf['list']);
        C('TOKEN_ON',false);
        $this->display();
    }
    //删除友情链接
    public function del() {
        $where=array('bill_no'=>I('get.bill_no'));
        if (M("payorder")->where($where)->delete()) {
            $this->success("成功删除");
            //echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    // 支付订单搜索
    public function search(){
        $search = I('get.');
        $this->keys =$search;
        $where = array();
        if($search['status']!='') $where['status'] = $search['status'];
        if(!empty($search['start_time']) && !empty($search['end_time'])){
            $where['update_time'] = array(array('egt',strtotime($search['start_time'])),array('elt',strtotime($search['end_time'])), 'and');
        }elseif(!empty($search['start_time'])){
            $where['update_time'] = array('elt',strtotime($search['end_time']));
        }elseif(!empty($search['end_time'])){
            $where['update_time'] = array('egt',strtotime($search['start_time']));
        }
        $M = M("payorder");
        $count = $M->where($where)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $this->page = $pConf['show']; //分配分页
        $this->order = D("Payment")->payList($pConf['first'], $pConf['list'],$where);
        C('TOKEN_ON',false);
        $this->display('index');
    }
    /**
     * 支付接口配置
     * @return [type] [description]
     */
    public function pay_gallery(){
        if (IS_POST) {
            $setPay['payment'] = I('post.payment');
            $setPay['payment']['app_id'] = str_replace(' ','',$setPay['payment']['app_id']);
            $setPay['payment']['appSecret'] = str_replace(' ','',$setPay['payment']['appSecret']);
            $this->checkToken();

            if (set_config("payment", $setPay, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => $str . '已更新', 'url' =>U('Payment/pay_gallery')));
            } else {
                echojson(array('status' => 0, 'info' => $str . '失败，请检查', 'url' => __ACTION__));
            }
        } else {
            $payment = include APP_PATH . 'Common/Conf/payment.php'; //读取支付配置
            $this->webhookurl = U('/Payment/webhook','','',true);
            $this->payment=$payment['payment'];
            $this->weixinurl = str_replace('onreplac', '', U('Home/Payment/online',array('channel'=>'WX_JSAPI','bill'=>'onreplac'),'',true));
            $this->display();
        }
    }
}