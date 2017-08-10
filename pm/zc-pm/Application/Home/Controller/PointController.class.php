<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
use Library\Aliyunsms\Aliyunsms;
use Library\Util\Util;

//积分商城的 相关
class PointController extends CommonController {

    public function index(){

        $ws = " 1 = 1 ";
        $type = I('get.typ');


        //手机端 课程
        if(intval($type)==1){
            $count = D('point_course')->where($ws)->count();
            $pConf = page($count, 8);
            $list = D('point_course')->where($ws)->limit($pConf['first'].','.$pConf['list'])->order('id DESC')->select();
            $this->type = 1;
        }else if(intval($type)==2){//手机端 礼品
            $count = D('point_gift')->where($ws)->count();
            $pConf = page($count, 8);
            //$where['type']=intval($type);
            $where['type']=0;
            $list = D('point_gift')->where($where)->limit($pConf['first'].','.$pConf['list'])->order('id DESC')->select();//dump($list);exit;
            $this->type = 2;
        }else if(intval($type)==3){//手机端 礼品
            $count = D('point_school')->where($ws)->count();
            $pConf = page($count, 8);
            //$where['type']=intval($type);
            $list = D('point_school')->limit($pConf['first'].','.$pConf['list'])->order('school_level asc')->select();//dump($list);exit;
            $this->type = 3;
        }else{            

            $count = D('point_course')->where($ws)->count();
            $countb = M('point_gift')->where($ws)->count();//dump($count);

            $pConf = page($count, 8);
            $pConfb = page($countb, 18);
            $pConfA=page($count+$countb, 8);
            $list = D('point_course')->where($ws)->limit($pConf['first'].','.$pConf['list'])->order('id DESC')->select();
            $school_list = D('point_school')->where($ws)->limit($pConf['first'].','.$pConf['list'])->order('school_level asc')->select();
            
            $listb = M('point_gift')->where(array('type' => 0))->limit($pConfb['first'].','.$pConfb['list'])->order('id DESC')->select();
            $listc = M('point_gift')->where(array('type' => 1))->limit($pConfb['first'].','.$pConfb['list'])->order('id DESC')->select();
            $listd = M('point_gift')->where(array('type' => 2))->limit($pConfb['first'].','.$pConfb['list'])->order('id DESC')->select();
            $this->listb = $listb;
            $this->listc = $listc;
            $this->listd = $listd;
            $this->pageb = $pConfb['show']; //分页分配
        }
        $slist=$type==3?$list:$school_list;//积分学堂
        $sLevel=['1'=>'入门基础课','2'=>'中级提高课','3'=>'高级精品课'];
            foreach($slist as $k=>$v){
                foreach($sLevel as $key=>$val){
                    if($key==$v['school_level']){
                        $sList[$key]['level_name']=$val;
                        $sList[$key]['list'][]=$v;
                        
                    }
                }
            }
        //dump($sList);exit;
        $this->listb=$type==2?$list:$this->listb;//积分换礼品
        //$this->listd=$type==2?$list:$this->listd;//积分兑礼品
        $this->school_list=$sList;//积分学堂
        // var_dump($_SESSION);exit();
        $this->list = $list;
        $this->page = $type==1?$pConf['show']:($type==2?$pConfb['show']:$pConfA['show']); //分页分配      
        $this->verphone = $_SESSION["verify_mobile"];
        $this->mobile = $_SESSION["mobile"];

        $this->display();
    }

    public function tixingb(){
         $jifen = I('get.jifen');
            $name = I('get.name');
            $this->name = $name;
            $this->jifen = $jifen;
            $this->display();
    }

    public function isbuy(){
        $ggid = I('get.ggid');
        $type = I('get.type');
        $uid = $_SESSION['uid'];
        $wsb = " uid = ".$uid." and ggid = ".$ggid." and type = ".$type." ";
        $orderpoint = D('point_order');
        $orderU = $orderpoint->where($wsb)->select();
        if($orderU){
            echojson(array('code'=>0,'type'=>2,'time'=>1,'status' => 0, 'info' =>"jkj"));
        }else{
            echojson(array('code'=>1,'type'=>2,'time'=>1,'status' => 0, 'info' =>"jkj"));
        }

    }

    public function tixing(){
        if(IS_POST){
            $jifen = I('post.jifen');
            $ggid = I('post.ggid');
            $name = I('post.name');
            $type = I('post.type');
            $account = $_SESSION['account'];
            $uid = $_SESSION['uid'];


            $ws45 = " uid = ".$uid." ";
            $memberB = D('member');
            $jifenU = $memberB->where($ws45)->select();

            if( intval($jifenU[0]['point'])< intval($jifen)){
                //积分不足
                $type = 2;
                $info ="积分不足，请努力赚积分";
                // $info =$jifen;
                $time = 1;
            }else{
                $wsb = " uid = ".$uid." and ggid = ".$ggid." and type = ".$type." ";
                $orderpoint = D('point_order');
                $orderU = $orderpoint->where($wsb)->select();
                if($orderU){
                    //买过
                    $type = 1;
                    $info ="恭喜您！您已经购买过该课程，我们的客服人员正在联系您，请耐心等待，谢谢！";
                    $time = 3;
                }else{
                    $data = array(
                        'name'=>$name,
                        'type'=>$type,
                        'ggid'=>$ggid,
                        'uid'=>$uid,
                        'point'=>$jifen
                    );




                    $nowkk  = intval($jifenU[0]['point']) - intval($jifen);
                    $datagg['point'] = $nowkk;
                    $memberB->where($ws45)->save($datagg);//遗漏事务

                    if($orderpoint->add($data)){
                        //消费积分纪录表
                        $pData['uid']=$uid;
                        $pData['nickname']=$jifenU[0]['nickname'];
                        $pData['point_change']=$jifen;
                        $pData['type']=1;//0增加，1消费
                        $pData['point_now']=$nowkk;
                        $pData['ggid']=$ggid;
                        $pData['name']=$name;
                        $pData['time']=time();
                        M('point_record')->add($pData);

                        //在gp.qianjingtv.com  生成帐号，并发送短信提醒
                        //在gp.qianjingtv.com  生成帐号，并发送短信提醒 ----------------------------------测试
                        // var_dump($jifenU);exit();
                        // if($jifenU[0]['first_buy']==0){
                        //     $rr = new Util();
                        //     $yy = $rr->getQiangjingTv('http://qianjingtv/room/registerB.php?name='.$account);

                        //     $dduui = explode('/', $yy);
                        //     $mess['name'] = $account;

                        //     $mess['uname'] = $dduui[0];
                        //     $mess['passa'] = "123123";
                        //     $mess['passb'] = $dduui[1];

                        //     // 发送短信提醒
                        //     $ff = new Aliyunsms();
                        //     $rr = $ff->sendSms('13067216009',$mess,'duihuan');

                        //     $memberB->where($ws45)->setInc('first_buy');

                        // }

                        //在gp.qianjingtv.com  生成帐号，并发送短信提醒 ----------------------------------测试
                       

                       //成功购买
                        $type = 1;
                        $info ="恭喜您！该课程已成功消费积分".$jifen."！稍后将有客服人员发送课程密码及个人账户信息给到您，请耐心等待，谢谢！";
                        $time = 4; 
                    }else{
                        //成功出错
                        $type = 1;
                        $info ="哟，您的操作出现异常，您可以及时将错误码(9909)反馈给我们的客服，我们将尽快为您解决";
                        $time = 2; 
                    }
                    
                }

            }


            echojson(array('type'=>$type,'time'=>$time,'status' => 0, 'info' =>$info));
        }else{
            $jifen = I('get.jifen');
            $name = I('get.name');
            $this->name = $name;

            $this->jifen = $jifen;
            $this->display();
        }
    }


    //gift detail
    public function giftdetail(){
        // $ism = $this->ism;
        // var_dump();exit();
        $M = M('point_gift');
        $O = M('point_order');
        $isbuy = 1;
        $jifenbuzu = 1;
        $ff = $O->where(array('ggid'=>I('get.id'),'uid'=>$_SESSION['uid'],'type'=>'2'))->select();
        // var_dump($ff);exit();
        if($ff!=null){
            $isbuy = 0;
        }


        

        if(I('get.id')){
            $gift = $M->where(array('id'=>I('get.id')))->select();
            if($gift){
                $jifenU = M('member')->where(array('uid'=>$_SESSION['uid']))->select();

                if( intval($jifenU[0]['point'])< intval($gift[0]['point'])){
                     $jifenbuzu= 0;
                }
            }else{
                 $gift[0] = 0;
            }
        }else{
            $gift[0] = 0;
        }
        $login = $this->checkLogin(0);
        $this->login = $login;
        // var_dump($login);exit();

        $this->verphone = $_SESSION["verify_mobile"];
        $this->mobile = $_SESSION["mobile"];
        $this->info = $gift[0];
        $this->jifenbuzu  =$jifenbuzu;
        $this->isbuy=$isbuy;
        $this->display();
    }





    public function giftdetailc(){
        // $ism = $this->ism;
        // var_dump();exit();
        $M = M('point_gift');
        $O = M('point_order');
        $isbuy = 1;
        $jifenbuzu = 1;
        $ff = $O->where(array('ggid'=>I('get.id'),'uid'=>$_SESSION['uid'],'type'=>'2'))->select();
        // var_dump($ff);exit();
        if($ff!=null){
            $isbuy = 0;
        }

        if(I('get.id')){
            $gift = $M->where(array('id'=>I('get.id')))->select();
            if ($gift[0]['picurl3']) {
                $gift[0]['picurl3'] = explode('|', $gift[0]['picurl3']);
            }
            if($gift){
                $jifenU = M('member')->where(array('uid'=>$_SESSION['uid']))->select();

                if( intval($jifenU[0]['point'])< intval($gift[0]['point'])){
                     $jifenbuzu= 0;
                }
            }else{
                 $gift[0] = 0;
            }
        }else{
            $gift[0] = 0;
        }
        $login = $this->checkLogin(0);
        $this->login = $login;
        // var_dump($login);exit();

        $this->verphone = $_SESSION["verify_mobile"];
        $this->mobile = $_SESSION["mobile"];
        $this->info = $gift[0];
        $this->jifenbuzu  =$jifenbuzu;
        $this->isbuy=$isbuy;
        $this->display();
    }


    public function coursedetail(){
        // $ism = $this->ism;
        // var_dump();exit();
        $M = M('point_course');
        $O = M('point_order');
        $isbuy = 1;
        $jifenbuzu = 1;
        $ff = $O->where(array('ggid'=>I('get.id'),'uid'=>$_SESSION['uid'],'type'=>'2'))->select();
        // var_dump($ff);exit();
        if($ff!=null){
            $isbuy = 0;
        }


        

        if(I('get.id')){
            $where['id']=array('eq',I('get.id'));
            $pre = C("DB_PREFIX");
            $pc=$pre.'point_course';
            $ot=$pre.'online_teacher';
            $gift = $M->join($pre . 'online_teacher on ' . $pre . 'point_course.teacher_id = ' .$pre . 'online_teacher.ol_teacher_id ')->field($pc.'.*,'.$ot.'.name as teacher_name'
                    . ','.$ot.'.picurl as teacher_pic_url,'.$ot.'.type,'.$ot.'.jianjie')->where($where)->select();
            //$gift = $M->where($where)->select();
            if($gift){
                $jifenU = M('member')->where(array('uid'=>$_SESSION['uid']))->select();

                if( intval($jifenU[0]['point'])< intval($gift[0]['point'])){
                     $jifenbuzu= 0;
                }
            }else{
                 $gift[0] = 0;
            }
        }else{
            $gift[0] = 0;
        }
        $login = $this->checkLogin(0);
        $this->login = $login;
        // var_dump($login);exit();
        //dump($gift);exit;
        $this->verphone = $_SESSION["verify_mobile"];
        $this->mobile = $_SESSION["mobile"];
        $this->info = $gift[0];
        $this->jifenbuzu  =$jifenbuzu;
        $this->isbuy=$isbuy;
        $this->display();

        // $this->display();
    }
    
    
    //school detail
    public function schooldetail(){
        // $ism = $this->ism;
        // var_dump();exit();
        $M = M('point_school');
        $O = M('point_order');
        $isbuy = 1;
        $jifenbuzu = 1;
        $ff = $O->where(array('ggid'=>I('get.id'),'uid'=>$_SESSION['uid'],'type'=>'2'))->select();
        // var_dump($ff);exit();
        if($ff!=null){
            $isbuy = 0;
        }


        

        if(I('get.id')){
            $where['id']=array('eq',I('get.id'));
            $pre = C("DB_PREFIX");
            $pc=$pre.'point_school';
            $ot=$pre.'online_teacher';
            $gift = $M->join($pre . 'online_teacher on ' . $pre . 'point_school.teacher_id = ' .$pre . 'online_teacher.ol_teacher_id ')->field($pc.'.*,'.$ot.'.name as teacher_name'
                    . ','.$ot.'.picurl as teacher_pic_url,'.$ot.'.type,'.$ot.'.jianjie')->where($where)->select();
            //$gift = $M->where($where)->select();
            if($gift){
                $jifenU = M('member')->where(array('uid'=>$_SESSION['uid']))->select();

                if( intval($jifenU[0]['point'])< intval($gift[0]['point'])){
                     $jifenbuzu= 0;
                }
            }else{
                 $gift[0] = 0;
            }
        }else{
            $gift[0] = 0;
        }
        $login = $this->checkLogin(0);
        $this->login = $login;
        // var_dump($login);exit();
        //dump($gift);exit;
        $this->verphone = $_SESSION["verify_mobile"];
        $this->mobile = $_SESSION["mobile"];
        $this->info = $gift[0];
        $this->jifenbuzu  =$jifenbuzu;
        $this->isbuy=$isbuy;
        $this->display();

        // $this->display();
    }
   
















   
}