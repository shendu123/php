<?php
namespace Home\Controller;
use Think\Controller;
class PublicController extends CommonController {
	// 用户分享
	public function shareaward(){
		if (IS_POST) {
            $share = M('share');
       		$uid = $this->cUid;
       		$yn = 0;
       		$data = array(
        		'uid'=>$uid,
        		'terrace'=>I('post.terrace'),
        		'title'=>I('post.title'),
        		'link'=>I('post.link'),
        		'time'=>time(),
        		'limsum'=>0
        		);
       		if(!$uid){
       			$uid = 0;
       			$limsum = 0;
       			$yn = 1;
       		}else{
       			$data['limsum'] = sprintf("%.2f",C('Weixin.giveintegral'));
       			$where['uid'] = $uid;
	        	$lifecount = $share->where($where)->count();
	        	$lifeyn = 0;
	        	if(!C('Weixin.limitlife')){
	        		// 没有限制
	        		$lifeyn = 1;
	        	}else{
	        		// 有限制检查限制
	        		if($lifecount<C('Weixin.limitlife')){
	        			$lifeyn = 1;
	        		}else{
	        			$data['limsum'] = 0;
	        			$share->add($data);
	        			return array('status' => 0, 'msg' => '奖励已经达到上限，不在获得奖励！');
	        			exit();
	        		}
	        	}
	        	$dayyn = 0;
	        	if(!C('Weixin.limitday')){
	        		// 没有限制
	        		$dayyn = 1;
	        	}else{
	        		// 有限制检查限制
	        		$where['time'] = array(array('lt',strtotime(date("Y-m-d",strtotime("+1 day")))),array('egt',strtotime(date("Y-m-d",time()))));
	        		$daycount = $share->where($where)->count();
	        		if($daycount<C('Weixin.limitday')){
	        			$dayyn = 1;
	        		}else{
	        			$data['limsum'] = 0;
	        			$share->add($data);
	        			return array('status' => 0, 'msg' => '今天的奖励已经达到上限！');
	        			exit();
	        		}
	        	}
       		}
        	// 分享写入数据库记录
    		if($share->add($data)){
    			// 如果不在限制内进行操作
    			if(($lifeyn&&$dayyn)||$yn){
    				// 注册用户奖励操作
        			if($uid!=0){
        				if(M('member')->where(array('uid'=>$data['uid']))->setInc('wallet_limsum',$data['limsum'])){
			                // 变动方式changetype  share_add 竞拍冻结bid_freeze 竞拍解冻bid_unfreeze 后台充值admin_deposit 管理员扣除 admin_deduct 后台冻结admin_freeze 后台冻结admin_unfreeze 支付充值pay_deposit 支付扣除pay_deduct  提现extract  
			                $limsum_data = array(
			                    'order_no'=>createNo('sad'),
			                    'uid'=>$data['uid'],
			                    'changetype'=>'share_add',
			                    'time'=>time(),
			                    'annotation'=>'分享链接<a href="'.$data['link'].'">【'.$data['title'].'】</a>到'.sharename($data['terrace']).'奖励'.$data['limsum'].'信誉额度。',
			                    'income'=>$data['limsum']
			                    );
			                if(M('member_limsum_bill')->add($limsum_data)){
			                    // 给用户发消息
			                    sendSms($data['uid'],'系统发送','您好，分享链接获得信用额度'.$limsum_data['income'].'元！备注：'.$limsum_data['annotation']);
			                    // 返回状态
			                    return array('status' => 1, 'msg' => '奖励成功');
			                } //写入用户账户记录
			            }
        			}
        		}else{
	        		return array('status' => 0, 'msg' => '超出设置奖励范围');
	        	}
        	}
        	
        } else {
       		E('页面错误！');
        }
	}

	public function getusercard(){
		if (IS_POST) {
			$seller = I('post.seller');
			$uid = I('post.uid');
			$pid = I('post.pid');
			$where = array('uid'=>$uid);
			$info = M('member')->where($where)->field('uid,nickname,intr,organization,intro,score,scorebuy')->find();
			$who = defineView();
			if($info){
				$redata = array(
					'leval'=>getlevel($info['score']),
					'name'=>$info['organization'],
					'intr'=>$info['intr'],
					'head'=>getUserpic($info['uid'],2),
					'uid'=>$info['uid']
					);
				if($seller){
					$attention_seller = M('attention_seller');
					// 读取是否已关注卖家
					if($attention_seller->where(array('uid'=>$this->cUid,'sellerid'=>$uid))->count()){$gzuser=1;}else{$gzuser=0;}
					$redata = array(
						'seller'=>1,
						'role'=>'卖家等级',
						'leval'=>getlevel($info['score']),
						'url'=>U('Home/Seller/index',array('sellerid'=>$info['uid']),'html',true),
						'name'=>$info['organization'],
						'intr'=>$info['intro'],
						'head'=>getUserpic($info['uid'],2),
						'uid'=>$info['uid'],
						'attention'=>$attention_seller->where(array('sellerid'=>$uid))->count(),
						'gzuser'=>$gzuser,
						'auctionurl'=>U('Home/Member/sendmsg',array('uid'=>$uid,'pid'=>$pid),'',true)
					);
				}else{
					$redata = array(
						'seller'=>0,
						'role'=>'买家等级',
						'leval'=>getlevel($info['score'],1),
						'url'=>'javascript:void(0);',
						'name'=>$info['nickname'],
						'intr'=>$info['intr'],
						'head'=>getUserpic($info['uid'],2),
						'uid'=>$info['uid']
					);
				}
				$redata['status']=1;
				echojson($redata);
			}else{
				echojson(array('status'=>0,'msg'=>'获取用户信息失败！'));
			}
			
			
		} else {
       		E('页面错误！');
        }
	}
	public function search_ajax(){
        $searchtype=I('post.searchtype');
        $searchkey=I('post.searchkey');
        $auction = D('Auction');
        $news=M('News');
       switch ($searchtype) {
            case 1:
                $whereA['pname'] = array('LIKE', '%' . $searchkey . '%');
                $search['auction']=array_unique($auction->where($whereA)->where(bidSection(0))->order('bidcount desc')->limit(10)->getField('title',true));
                break;
            case 2:
                $whereB['title']=array('LIKE', '%' . $searchkey . '%');
                $whereB['cid']=3;
                $search['news'] = array_unique($news->where($whereB)->limit(10)->getField('title',true));
                break;
            default:
                $whereA['pname'] = array('LIKE', '%' . $searchkey . '%');
                $search['auction']=array_unique($auction->where($whereA)->where(bidSection(0))->order('bidcount desc')->limit(5)->getField('title',true));
                $whereB['title']=array('LIKE', '%' . $searchkey . '%');
                $whereB['cid']=3;
                $search['news'] = array_unique($news->where($whereB)->limit(5)->getField('title',true));
                break;
        }
        if($search['auction']){
            foreach ($search['auction'] as $ak => $av) {
                $shtml[]='<li class="cuit_over"><a href="javascript:void(0);">'.str_replace($searchkey, '<span>'.$searchkey.'</span>', $av).'</a></li>';
            }
        }
        if($search['news']){
            foreach ($search['news'] as $nk => $nv) {
                $shtml[]='<li class="cuit_over"><a href="javascript:void(0);">'.str_replace($searchkey, '<span>'.$searchkey.'</span>', $nv).'</a></li>';
            }
        }
        if($shtml){
            echo json_encode(array('status' => 1, 'shtml' => $shtml));
        }else{
            echo json_encode(array('status' => 0, 'shtml' => '没有搜索到包含关键词的数据！'));
        }
        
    }
    // 用户协议
    public function information(){
    	$userAgreement = include APP_PATH . 'Common/Conf/UserAgreement.php';
    	$this->userAgreement = htmlspecialchars_decode($userAgreement['USER_AGREEMENT']);
    	$this->display();
    }
    // 退出登录
    Public function loginOut() {
        $systemConfig = include APP_PATH . '/Common/Conf/systemConfig.php';
        $loginMarked = md5($systemConfig['TOKEN']['member_marked']);
        setcookie($loginMarked, NULL, -$systemConfig['TOKEN']['member_timeout'], "/");
        unset($_SESSION[$loginMarked], $_COOKIE[$loginMarked]);
        session_destroy();
        $this->redirect("Index/index");
    }
    // 验证码
    public function verify_code(){
        ob_clean();
        $Verify = new \Think\Verify();
        $Verify->fontSize = 17;
        $Verify->length   = 4;
        $Verify->codeSet = '0123456789';
        $Verify->entry();
    }


}
