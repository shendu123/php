<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
// use Library\Payhuichao\Huichaopay;
// use Library\Aliyunsms\Aliyunsms;
// use Library\Payali\Payali;
use Library\Paywechat\Paywechat;
use Library\Paywechat\Notify;


class IndexController extends CommonController {
    public function index(){
        // 手机
        if($this->ism){
            // 首页广告【
            $this->index_slides = getAdvData('index_slides');
        }
        // 频道列表
        $this->channel=channelAuction(12);
        // 公告列表
        $cate = M("Category");
        $this->caname = $cate->where(array('cid'=>2))->getField('name');
        $this->cbname = $cate->where(array('cid'=>3))->getField('name');
        //最近成交拍品列表处理-----------------------------------------------start
        $endlist[0]['elistA'] = D('Auction')->where(endbid(0))->order('endtime desc')->limit(8)->select();
        $endlist[0]['abc'] = 2;
        $this->endlist=$endlist;
        //最近成交拍品列表处理-----------------------------------------------end
        // 友情链接
        $link = M('link');
        $this->linkA = $link->order('sort desc')->where('rec = 1')->select();
        $this->linkB = $link->order('sort desc')->where('rec = 0')->select();
        $this->display();
     }

     public function search(){
        $auction = D('Auction');
        $news=M('News');
        // 搜索
        if(IS_POST){
            $searchtype=I('post.searchtype');
            $searchkey=I('post.searchkey');
        }
        if(IS_GET){
            $searchtype=I('get.searchtype');
            $searchkey=I('get.searchkey');
        }
        // 拍品条件
        $wa['pname'] = array('LIKE', '%' . $searchkey . '%');
        $wa['keywords'] = array('LIKE', '%' . $searchkey . '%');
        $wa['_logic'] = 'or';
        $whereA = bidSection(0);
        $whereA['_complex'] = $wa;
        // 文章条件
        $wb['title']=array('LIKE', '%' . $searchkey . '%');
        $wb['keywords']=array('LIKE', '%' . $searchkey . '%');
        $wb['_logic'] = 'or';
        $whereB['cid']=3;
        $whereB['_complex'] = $wb;
       switch ($searchtype) {
            case 1:
                $count = $auction->where($whereA)->count();
                $pConf = page($count,12);
                $search['ing'][0]['auction']=$auction->where($whereA)->limit($pConf['first'].','.$pConf['list'])->order('bidcount desc')->select();
                $search['ing'][0]['abc'] = 0;
                break;
            case 2:
                $count = $news->where($whereB)->count();
                $pConf = page($count,20);
                $search['news'] = $news->where($whereB)->limit($pConf['first'].','.$pConf['list'])->select();
                break;
            default:
                $search['ing'][0]['auction']=$auction->where($whereA)->order('bidcount desc')->select();
                $search['ing'][0]['abc'] = 0;
                $search['news'] = $news->where($whereB)->select();
                break;
        } 

        // 搜索
        // 正在拍卖
        $this->page = $pConf['show']; 
        $this->searchtype=$searchtype;
        $this->searchkey=$searchkey;
        $this->search=$search;
        $this->display();
     }
    public function test(){
        if(I('get.del')){
            pre(M('member')->where(array('nickname'=>'ONcoo Service'))->select());
            pre(M('member_weixin')->where(array('nickname'=>'ONcoo Service'))->select());
            M('member')->where(array('nickname'=>'ONcoo Service'))->delete();
            M('member_weixin')->where(array('nickname'=>'ONcoo Service'))->delete();
        }else{
            $weixin = M('member_weixin')->where(array('openid'=>'oL2W_s49jkyOpJIA53adUrkCmWl8'))->find();
            $info = M('member')->where(array('uid'=>$weixin['uid']))->find();
            pre('1');
            pre($weixin);
            pre($info);
        }
        
        die;
        // $this->display();
    }
    public function testa(){
        $url = U('Index/testb','',true);
        $datas = array('gol'=>1,'openid'=>'123456','access_token'=>'654321','create'=>'auto');
        pre(sendPost($url, $datas));
    }
    public function testb(){
        M('auction')->where(array('pid'=>array('not in','330,331')))->delete();
        M('goods')->where(array('id'=>array('not in','45')))->delete();
        M('goods_order')->where(array('gid'=>array('not in','330,331')))->delete();
    }
    public function testpre(){
        pre(S('test'));
        pre(S('test1'));
    }

    //为结束的生成订单
    public function createOrder(){
        $ncow = array(
            'endtime'=>array('lt',time()),
            'endstatus'=>0,
        );
        $nco = D('Auction')->where($ncow)->select();
        // 查找数组内相同值的保留一个
        if(is_array($nco)){
            // 生成订单进入开关
            foreach ($nco as $n => $nv) {
                create_order($nv);
            }
        }

        $data['code'] = '0';
        $data['tip'] = '未知错误';
        $data['data'] = 'null';
        echo  json_encode($data,JSON_UNESCAPED_UNICODE) ;exit();
    }

    public function wechatreturn(){
        //微信回调测试
        $notify = new Notify();
        $notify->Handle(false);
    }

    public function sms(){

        //测试 阿里短信
        // sendNote('13067216009','2wdw','zhuce');
        // exit();
        
        //测试 阿里短信
        // $ff =new Aliyunsms();
        // $ff->sentSms('13067216009','1234','测试001','SMS_47540070');
        // if($ff){
        //     echo "成功";
        // }


        //测试 阿里支付
        // $ff = new Payali();
        // $ff->payByAlipay('9','78','8989','yuyu','fuuuyu');

        //测试微信支付
        // $ff = new Paywechat();
        // $url = $ff->createQrUrl('测试','测试2',1,'产品简介','NATIVE','12321412412','http://www.fjsxpmh.com/Home/Payment/webhookNew?bid=1');
        // var_dump($url);

        //微信回调测试
        $notify = new Notify();
        $notify->Handle(false);
    }

    public function showlog(){
        $fpdemo = fopen("wechat2.log",'r');
        if ($fpdemo){   
            while(!feof($fpdemo)){   
              $datademo = fgets($fpdemo, 1000);
              echo $datademo."<br>";
            }   
            fclose($fpdemo);
        }
    }

    public function clearlog(){
        file_put_contents('wechat2.log','');
    }

    public function weixintest(){
        $ff = new Paywechat();
        $data = $ff->payByWechat('测试','测试2',1,'产品简介','http://www.fjsxpmh.com/Home/Payment/webhookNew?bid=1');
        $this->jsApiParameters = $data['jsApiParameters'];
        $this->editAddress = $data['editAddress'];

        $this->display();
    }

    public function wxFrontProxy() {
        $payUrl = urldecode(I('get.payUrl'));

        $this->payUrl = str_replace('&amp;', '&', $payUrl);
        $this->rd = urlencode(I('get.redirect'));


        $this->display();
    }

    public function wxRecirect() {
        $redirect = urldecode(I('get.redirect'));

        header('Location: '.$redirect);
    }

    public function wechattest(){
        $this->data = I('post.data');
        $this->display();
    }
    
    public function wechatgetapi(){
        
        $this->display();
    }


    public function wechatreturnB(){
        // $session
        $this->display();
    }
    
    public function importAccount(){

        $robot_nick_data=file_get_contents( './Public/robot_nick.txt');


        /*$robot_nick_data=file_get_contents( './Public/robot_nick.txt');


        $arr_nick=explode("\n",$robot_nick_data);
        $model=D('Member');
        foreach($arr_nick as $k=>$v){
            $data[$k]['account']='rob_'.randCode(12,2);
            $data[$k]['nickname']=$v;
            $data[$k]['pwd']=encrypt(123123);  
            $data[$k]['reg_date']=time();
            $data[$k]['reg_ip']=get_client_ip();
            $data[$k]['find_pwd_time']=0;
            $data[$k]['find_pwd_exp_time']=0;
            $data[$k]['birthday']=0;
            $data[$k]['sex']=0;
            $data[$k]['postalcode']=0;
            $data[$k]['qq']=0;
            $data[$k]['login_time']=time();
            $data[$k]['status']=1;
        }
        //echo "<pre>";print_r($data);exit;
        $model->startTrans();
        try{
            $model->addAll($data);
            $model->commit();
            exit('添加成功');
        }catch (\Exception $e){
            $model->rollback();
            exit('添加失败');
        }*/
    }
}