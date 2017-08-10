<?php
namespace Admin\Controller;
use Think\Controller;
class OrderController extends CommonController {
    /**
     * 有效订单
     * @return [type] [description]
     */
    public function index() {
        $where = array();
        if (I('get.field')) {
            $where[I('get.field')] = I('get.val');
        }
        $this->where = $where;
        // 网站发布条件
        $data = D('Order')->listOrder($where);
        $this->mct = $data['mct'];
        $this->list = $data['list'];
        $this->page = $data['page'];
        $this->display(); 
    }
    /**
     * 订单搜索
     * @return [type] [description]
     */
    public function search(){
        if(I('get.account')!=''){
            $uidarr = M('member')->where(array('account'=>array('LIKE', '%' . I('get.account') . '%')))->getField('uid',true);
            $where['uid'] = array('in',$uidarr);
        }
        // 订单号
        if(I('get.order_no')!=''){
            $where['order_no']=array('LIKE', '%' . I('get.order_no') . '%');
        }
        // 类型
        if(I('get.type')!=''){
            $where['type']=I('get.type');
        }
        // 状态
        if(I('get.status')!=''){
            $where['status']=I('get.status');
        }
        $data = D('Order')->listOrder($where);
        $this->mct = $data['mct'];
        $this->list = $data['list'];
        $this->page = $data['page'];
        C('TOKEN_ON',false);
        $this->display('index');
            
    }
    // 订单配置
    public function set_order(){
        if (IS_POST) {
            $this->checkToken();
            $data['Order'] = I('post.order');
            if (set_config("SetOrder", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '设置成功'));
            } else {
                echojson(array('status' => 0, 'info' => '设置失败，请检查'));
            }
        } else {
            $this->order=C('Order');
            $this->display();
        }
    }
    // 订单编辑
    public function edit(){
        $M = M("Goods_order");
        if (IS_POST) {
            $pow =I('post.info');
            if($pow['status']=='2'){
                if($pow['express']=='' and $pow['express_no']==''){
                    echojson(array('status' => 0, 'info' => '已发货状态请填写快递信息！'));
                    exit;
                }else{
                    $data['express'] = $pow['express']; 
                    $data['express_other'] = $pow['express_other'];
                    $data['express_no'] = $pow['express_no']; 
                }
            }
            $odarr = explode('_', $pow['order_no']);
            $ct = 0;
            foreach ($odarr as $ok => $ov) {
                $where = array('order_no'=>$ov);
                $order = $M->where($where)->find();
                if ($pow['deftime']!='') {
                    if($pow['act']!=''){
                        if($pow['act']=='add'){
                            $data[$pow['deftime']] = $order[$pow['deftime']]+(60*60*24*$pow['day']);
                        }
                        if($pow['act']=='sub'){
                            $data[$pow['deftime']] = $order[$pow['deftime']]-(60*60*24*$pow['day']);
                        }
                    }
                }
                if($pow['downpay']==1){
                    if($pow['status']==0){
                        $data['status'] = 1;
                    }else{
                       $data['status'] = $pow['status'];
                    }
                    $data['remark']='管理员确认线下已支付';
                    $data['downpay']=1;
                    $data['time1']=time();
                    // 退还保证金
                    $rs = payBidUnfreeze(I('get.order_no'),1);
                }else{
                   $data['remark']=$pow['remark'];
                   $data['status'] = $pow['status']; 
                }
                if($data['status']!=0){
                    $data['time'.$data['status']] = time();
                }
                $M->where($where)->save($data);
                $ct+=1;
            }
            if($ct>0){
                echojson(array('status' => 1, 'info' => '编辑成功<br/>'.$rs,'url' => U('Order/index'))); 
            }else{
                echojson(array('status' => 0, 'info' => '编辑失败，请检查'));
            }
        } else {
            if(count(explode('_', I('get.order_no')))==1){
                $info = $M->where(array('order_no'=>I('get.order_no')))->find();
                $info=$info;

            }else{
                $info = array('order_no'=>I('get.order_no'));
            }
            $info['address']=unserialize($info['address']);

            // 快递选择
            $this->express_list=expressCompany();
            $this->info=$info;
            $this->display();
        }
    }
    // 删除文章
    public function del() {
        if (M("Goods_order")->where(array('order_no'=>$_GET['order_no']))->delete()) {
            $this->success("成功删除");
        } else {
            $this->error("删除失败，可能是不存在该订单号的记录");
        }
    }


}