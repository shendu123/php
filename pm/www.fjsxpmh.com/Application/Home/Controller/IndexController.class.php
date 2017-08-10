<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
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

}