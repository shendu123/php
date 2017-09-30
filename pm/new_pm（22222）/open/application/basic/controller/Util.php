<?php
/**
 * @Author AJMstr
* @date 2017-5-5
*/
namespace app\basic\controller;

use app\common\controller\NoAuth;
use app\basic\model\Member;
use app\basic\model\Business;
use app\basic\model\Myauction;
use app\basic\model\Collect;
use app\basic\library\Util as Lutil;
use app\bi\model\Auction as bi_Auction;
use app\basic\model\BusinessAttention as BusinessAttention_model;
use app\basic\model\GoodsAttention as GoodsAttention_model;
use app\basic\model\NewsAttention as NewsAttention_model;

class Util extends NoAuth {


    public function getUserInfo(){
        $mem = new Member();
        $res  = $mem->getUserInfo($this->_uid);
        if($res){
            return $res;
        }else{
            $this->_error("获取用户信息错误");
        }
    }


    public function getUserInfoB(){
        $mem = new Member();
        $res  = $mem->getUserInfoB($this->_uid);
        if($res){
            return $res;
        }else{
            $this->_error("获取用户信息错误");
        }
    }
    
    public function getUserInfoByUid($uid_param = 0){
        $uid_req = valueRequest('user_id', 0);
        $uid = !empty($uid_param) ? $uid_param : $uid_req;
        
        $mem = new Member();
        $res  = $mem->getUserInfoB($uid);
        if($res){
            return $res;
        }else{
            $this->_error("获取用户信息错误");
        }
    }


    public function getUserInfoByInid(){
        $po = $this->request->post('inid');
		$keyword = $this->request->post('keyword');
		$keyword = (isset($keyword) && !empty($keyword)) ? $keyword : '';
        $mem = new Member();
        $res  = $mem->getUserInfoByInid($po , $keyword);
        
        if($res){
            return $res;
        }else{
            $this->_error("获取用户信息错误");
        }
    }

    public function postBusinessInfo(){
        $po = $this->request->post('inid');
        
        $bu = new Business();
        $res  = $bu->getListByInid($po);

        if($res){
            return $res;
        }else{
            $this->_error("获取信息错误");
        }
    }


    //收藏商品
    public function collect(){
        $po = $this->request->post();
        $uid = $this->_uid;

        $util = new Lutil();

        $need = ["goodsid","name","price","picurl","from"];

        $util->checkPostIsempty($po,$need);

        $co = new Collect();
        $res  = $co->saveData($po,$uid);

        if($res){
            if ($po['from'] == 'PM') {
                (new bi_Auction())->change_remind($po['goodsid'], 1);
            }
            return ['msg'=>"收藏成功", 'id'=>$res];
        }else{
            $this->_error("收藏失败",200);
        }
        
    }

    // 判断商品是否收藏
    public function isCollect() {
        $this->_checkLogin();
        $goodsid = $this->request->get("goodsid");
        $from = $this->request->get("from");
        if ($goodsid == 0 || empty($from)) {
            $this->_error("参数错误", 400);
        }

        $co = new Collect();
        $isCollect  = $co->isCollect($goodsid, $this->_uid, $from, 1);
        if($isCollect=="kongde"){
            return ['error'=>0, 'is_collect'=>0];
        }else{
            if($isCollect['isdelete']==2){
                return ['error'=>0, 'is_collect'=>1, 'id'=>$isCollect['id']];
            }else{
                return ['error'=>0, 'is_collect'=>0];
            }
        }
    }

    //取消收藏商品
    public function unCollect(){
        $po = $this->request->get('id');
        $co = new Collect();
        $detil = $co->getCollectById($po);

        $res  = $co->deleteById($po);

        if($res){
            if ($detil['from'] == 'PM') {
                (new bi_Auction())->change_remind($detil['goodsid'], 0);
            }

            return ['msg'=>"取消收藏成功"];
        }else{
            $this->_error("取消收藏失败",200);
        }
    }

    //获取收藏列表
    public function getCollectList(){
        $uid = $this->_uid;
        $page['page'] = $this->request->get("page",1);
        $page['pageSize'] =$this->request->get("page_size",10);
        $co = new Collect();
        $res  = $co->getCollectByUid($uid,$page);
        if($res){
            return $res;
        }else{
            $this->_error("获取信息错误");
        }

    }

    //商品、圈子、店铺关注统计
    public function attentionCounter() {
        $this->_checkLogin();

        $rs = [];
        $rs['business_attention_total'] = (new BusinessAttention_model())->counter($this->_uid);
        $rs['goods_attention_total'] = (new GoodsAttention_model())->counter($this->_uid);
        $rs['news_attention_total'] = (new NewsAttention_model())->counter($this->_uid);

        return ['error'=>0, 'result'=>$rs];
    }

    //存入我的竞价
    public function saveMyauction(){
        $po = $this->request->post();
        $uid = $this->_uid;

        $mau = new Myauction();
        $res  = $mau->saveData($po,$uid);

        if($res){
            return ['msg'=>"存入我的竞价 成功"];
        }else{
            $this->_error("存入我的竞价 失败",200);
        }

    }

    //改变竞价状态0-拍卖中
    public function changeMyaStatus(){
        $po = $this->request->post();

        $mau = new Myauction();
        $res  = $mau->changeMyaStatus($po['id'],$po['new']);

        if($res){
            return ['msg'=>"改变竞价状态 成功"];
        }else{
            $this->_error("改变竞价状态 失败",200);
        }


    }

    //获取我的竞价
    public function getMyauction(){
        $po = $this->request->post();

        $mau = new Myauction();
        $res  = $mau->findByUid($this->_uid);

       if($res){
            return $res;
        }else{
            $this->_error("获取信息错误");
        }

    }

    public function getCollectTotal(){
        $uid = $this->_uid;

        $co = new Collect();
        $res  = $co->getCollectTotalByUid($uid);
        if($res){
            return $res;
        }else{
            $this->_error("获取信息错误");
        }
    }

    /**
     * @functon 手机号码是否存在
     * @author ljx
     */
    public function isExist($mobile_param = ""){
        $mobile_request = valueRequest('mobile', '');
        $mobile = $mobile_param ? $mobile_param : $mobile_request;
    
        $model = new \app\basic\model\MemberBack();
        $result = $model->isExist($mobile);
    
        return array(
            'status' => 200,
            'msg' => '成功',
            'data' => $result
        );
    }


}