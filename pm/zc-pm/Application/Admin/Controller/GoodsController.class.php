<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController {
    /**
     +----------------------------------------------------------
     * 商品列表
     +----------------------------------------------------------
     */
    public function index() {
        $channel = M('goods_category')->where('pid=0')->select(); //读取频道
        $this->channel=$channel; //分配频道
        $M = M("Goods");
        $count = $M->count();
        $pConf = page($count,C('PAGE_SIZE'));

        //增加企业id
        $business_id = $_SESSION['business_id'];
        if($business_id!=null){
            $where['business_id'] = array('in',$business_id);
        }else{
            $where = " 1 = 1 ";
        }



        $this->page = $pConf['show'];
        $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list'],$where);
        C('TOKEN_ON',false);
        $this->display();
    }
    //异步获取频道下分类
    public function getcate(){
        $pid=I('post.pid');
        $cateHtml='';
        if($pid!=''){
            $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
            $cate=$cat->getList(NULL, $pid,NULL);
            $cateHtml='<span id="cid_select">->&nbsp;&nbsp;<select name="cid"><option value="">所有分类</option>';
            foreach ($cate as $ck => $cv) {
                $cateHtml.='<option value="'.$cv['cid'].'">'.$cv['fullname'].'</option>';
            }
            $cateHtml.='</select></span>';
        }
        echojson(array("status" => 1, "htm" => $cateHtml));
    }
    /**
     +----------------------------------------------------------
     * 搜索商品
     +----------------------------------------------------------
     */
    public function search(){
            $keyW = I('get.');
            $encode = mb_detect_encoding($keyW['keyword'], array("ASCII","UTF-8","GB2312","GBK","BIG5"));
            $keyW['keyword'] = iconv($encode,"utf-8//IGNORE",$keyW['keyword']);
            $cate=M('Goods_category');

            //增加企业id
            $business_id = $_SESSION['business_id'];
            if($business_id!=null){
                $where['business_id'] = array('in',$business_id);
            }

            if($keyW['pid']!=''){
                $chname=  $cate->where('cid='.$keyW['pid'])->getField('name');
                if($keyW['cid']==''){
                    $keyW['cid']=array();
                    $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                    $catecid = $cat->getList(NULL, $keyW['pid'],NULL);
                    foreach ($catecid as $cik => $civ) {
                        $keyW['cid'][$cik]=$civ['cid'];
                    }
                    array_push($keyW['cid'], $keyW['pid']); //将频道添加到条件
                    $where['cid'] = array('in',$keyW['cid']);
                    $catname = '所有'; 
                }else{
                    if($keyW['cid']!=''){
                        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                        $catecid = $cat->getList(NULL,$keyW['cid']);
                        foreach ($catecid as $cak => $cav) {
                            $catecid[$cak]=$cav['cid'];
                        }
                        $catecid[]=$keyW['cid'];
                        $where['cid'] = array('in',$catecid);
                        $catname = $cate->where('cid='.$keyW['cid'])->getField('name');
                    }else{
                        $catname = '所有'; 
                    }
                }
            }else{
                $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name', 'fullname'));
                $catecid = $cat->getList(NULL, 0);
                foreach ($catecid as $cik => $civ) {
                    $catecid[$cik]=$civ['cid'];
                }
                $where['cid'] = array('in',$catecid);
                $chname = '所有';
                $catname = '所有'; 
            }
            if($keyW['keyword'] != '') $where['title'] = array('LIKE', '%' . $keyW['keyword'] . '%');
            $M = M("Goods");
            $count = $M->where($where)->count();
            $pConf = page($count,C('PAGE_SIZE'));
            
            $channel = $cate->where('pid=0')->select(); //读取频道
            $keyS = array('count' =>$count,'keyword'=>$keyW['keyword'],'chname' => $chname,'catname' => $catname,'pid'=>$keyW['pid']);
            $this->keys = $keyS;
            $this->page = $pConf['show'];
            
            $this->channel=$channel; //分配频道

            $this->list = D("Goods")->listGoods($pConf['first'], $pConf['list'],$where);
            C('TOKEN_ON',false);
            $this->display('index');
    }
    /**
     +----------------------------------------------------------
     * 添加商品
     +----------------------------------------------------------
     */
    public function add() {
        if (IS_POST) {
            echojson(D("Goods")->addEdit('add'));
        } else {
            $describe = include APP_PATH . 'Common/Conf/FieldsDescribe.php';
            $info=array(
                'layer'=>C('goods_region'),
                'content'=>stripslashes($describe['FIELDS_DESCRIBE'])
            ); //获取地区的层数并分配
            $info['business_id'] = $_SESSION['business_id'];//增加企业id
            $this->info=$info;

            $this->assign("list", D("Goods")->category());
            C('TOKEN_ON',false);
            $this->display();
        }

    }
    // ------通过分类cid获取对应筛选条件
    public function getFilt(){
        echojson(array("status" => 1, "html" => getFiltrateHtmlSeller(I('post.cid'),I('post.filtStr'))));
    }
    // ------通过分类cid获取对应扩展字段
    public function getExtends(){
        $rtdata=getExtendsHtml(I('post.cid'),I('post.gid'));
        echojson(array("status" => 1, "ulhtml" => $rtdata['eUrlHtml'],"divhtml" => $rtdata['eDivHtml'],'textarr'=>$rtdata['textarea'],'region'=>$rtdata['region']));
    }
    // ------检查标题是否重复
    public function checkNewsTitle() {
        $M = M("Goods");
        $where = "title='" .I('get.title') . "'";
        if (!empty($_GET['id'])) {
            $where.=" And id !=" . (int) $_GET['id'];
        }
        if ($M->where($where)->count() > 0) {
            echojson(array("status" => 0, "info" => "已经存在，请修改标题"));
        } else {
            echojson(array("status" => 1, "info" => "可以使用"));
        }
    }
    /**
     +----------------------------------------------------------
     * 编辑商品
     +----------------------------------------------------------
     */
    public function edit() {
        $M = M("Goods");
        if (IS_POST) {
            echojson(D("Goods")->addEdit('edit'));
        } else {
            $info = $M->where("id=" . (int) $_GET['id'])->find();
            if ($info['id'] == '') {
                $this->error("不存在该记录");
            }

            if ($info['pictures']) {
                $info['pictures'] = explode('|', $info['pictures']);
            }
            $info['seller'] = M('member')->where(array('uid'=>$info['sellerid']))->field('account,nickname,avatar')->find();
            $info['content']=stripslashes($info['content']);
            $info['layer']=C('goods_region'); //获取地区的层数并分配
            $this->assign("info", $info);
            $this->assign("list", D("Goods")->category());
            C('TOKEN_ON',false);
            $this->display("add");
        }
    }
    //------异步排序商品图片
    public function goodPicOrder(){
        C('TOKEN_ON',false);
        if (IS_POST) {
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => I('post.imgArr')
                );
            if(M('Goods')->save($data)){
                echojson(array('status' => 1, 'msg' => "排序成功，已保存到数据库"));
            }else{
                echojson(array('status' => 0, 'msg' => "排序失败，请刷新页面尝试操作"));
            }
        }
    }
    //------删除商品
    public function del_goods() {
        $goods = M("Goods");
        $where = array('id'=>I('get.id'));
        $pictures = $goods->where($where)->getField('pictures');
        $picarr = explode('|', $pictures);
        $fixct = count(explode(',', C('GOODS_PIC_PREFIX')));
        $imgDelUrl = C('UPLOADS_PICPATH');
        foreach ($picarr as $pk => $pv) {
            $fixkey = 0;
            for ($i=0; $i < $fixct; $i++) { 
                @unlink($imgDelUrl.picRep($pv,$i));
            }
            @unlink($imgDelUrl.$pv);
        }
        if ($goods->where($where)->delete()) {
            $this->success("成功删除");
           // echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    //------异步删除商品图片
    public function del_pic() {
        $imgUrl = I('post.imgUrl');
        $imgDelUrl = C('UPLOADS_PICPATH').I('post.imgUrl'); //要删除图片地址
        $goodsId = I('post.goodsId'); //商品ID
        if($goodsId){
            $goods = M('Goods');
            $gd_pic = $goods->where(array('id'=>$goodsId))->find();
            //组合要写入数据
            $newPic = str_replace('||','|',trim(str_replace($imgUrl, '', $gd_pic['pictures']),'|'));
            $data = array(
                'id' => I('post.goodsId'),
                'pictures' => $newPic
                );

            if($goods->save($data)){
                $ecJson = array(
                    'status' => 1,
                    'msg' => '删除成功!'
                    );
                @unlink($imgDelUrl);
                //循环删除缩略图
                $picFix = explode(',',C('GOODS_PIC_PREFIX'));
                foreach ($picFix as $pfK => $pfV) {
                    @unlink( C('UPLOADS_PICPATH').picRep($imgUrl,$pfK));
                }
                //输出结果
                echojson($ecJson);
            }else{
                $ecJson = array(
                    'status' => 0,
                    'msg' => '删除失败，刷新页面重试!'
                    );
                echojson($ecJson);
            }
        }else{
            if(@unlink($imgDelUrl)){
                echojson(array(
                'status' => 1,
                'msg' => '已从服务器删除成功!'
                ));
            }else{
                echojson(array(
                'status' => 0,
                'msg' => '删除失败，请检查文件权限!'
                ));
            }
            
        }
    }
    //------异步裁剪图片
    public function cutview() {
        $this->display();
    }
    public function cutoper(){
        $cutsize = explode('|',I('post.cutSize'));
        $cutImgP = I('post.cutImgP');
        $upFixPath = C('UPLOADS_PICPATH');
        $parImgUrl = $upFixPath.picRep($cutImgP,0);//生成最大备份的图片地址
        $maxImgUrl = $upFixPath.picRep($cutImgP,1);//生成大图片地址

        $imCut = new \Think\Image(); 
        $imCut->open($parImgUrl);
        $cStutas = $imCut->crop($cutsize[2],$cutsize[3],$cutsize[0], $cutsize[1])->save($maxImgUrl);
        //生成缩略图
        if($cStutas){
            $imCut->open($maxImgUrl);
            $picFixArr=explode(',', C('GOODS_PIC_PREFIX'));
            foreach ($picFixArr as $pFixK => $pFixV) {
                if($pFixK > 0){
                    $imSizeW = picSize($pFixK,'width');
					$imSizeH = picSize($pFixK,'height');
                    $imCut->thumb($imSizeW,$imSizeH,\Think\Image::IMAGE_THUMB_FIXED)->save($upFixPath.picRep($cutImgP,$pFixK));
                }
            }
        }

        echojson(array(
            'status'=>1
            ));
    }
/**
 +----------------------------------------------------------
 * 分类
 +----------------------------------------------------------
 */
    public function category() {
        if (IS_POST) {
            echojson(D("Goods")->category());
        } else {
            $this->assign("list", D("Goods")->category());
            //分配图片
            $this->cateW = C('CATE_ICO_WIDTH');
            $this->cateH = C('CATE_ICO_HEIGHT');
            $this->display();
        }
    }
    //------删除分类图标
    public function delIco(){
        M('Goods_category')->where('cid='.I('post.cid'))->setField('ico','');
        @unlink(C('UPLOADS_PICPATH').I('post.imgUrl'));
        echojson(array("status" => 1, "info" => "已删除"));
    }
    // 商品筛选条件
    public function filtrate(){
        if (IS_POST) {
            echojson(D("Goods")->filtrate());
        } else {
            $this->assign("list", D("Goods")->filtrate());
            $this->display();
        }
    }
    //---分类异步排序
    public function order_cate() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('goods_category');
            $where=array('cid'=>$getInfo['cid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }
        } else {
            echojson(array('status'=>'0','msg'=>'什么情况'));
        }
    }
    //---扩展字段异步排序
    public function order_filtrate() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('goods_filtrate');
            $where=array('fid'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('sort')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }
        } else {
            echojson(array('status'=>'0','msg'=>'什么情况'));
        }
    }
/**
 +----------------------------------------------------------
 * 分类条件关联
 +----------------------------------------------------------
 */
    public function cate_filt(){
        if (IS_POST) {
            echojson(D("Goods")->cate_filt());
        } else {
            $c_f = M('Goods_category_filtrate');
            $cfMap = $c_f->select();
            $cMap = $c_f->getField('cid',true);
            $cMap = array_unique($cMap); //去除重复的Cid
            sort($cMap); //对数组进行排序

            // 根据分类输出关联关系
            $newMap = array();
            $i = 0;
            foreach ($cMap as $cK => $cV) {
               foreach ($cfMap as $fK => $fV) {
                    if($cV ==$fV['cid']){
                        $newMap[$i]['cid']=$cV;
                        $newMap[$i]['fid'][]=$fV['fid'];
                    }
                } 
                $i +=1;
            }
            // 通过父级条件查询到下二级子条件
            $filtMap = M('Goods_filtrate')->select();
            foreach ($newMap as $mK => $mV) {
                foreach ($mV['fid'] as $sfk => $sfv) {
                    foreach($filtMap as $v){
                      if($v['pid']==$sfv){
                        $newMap[$mK]['sid'][$sfk][]=$v['fid'];
                      }
                    }
                }
            }
            $this->map=$newMap;
            $this->cate = D("Goods")->category();
            $this->filt = D("Goods")->filtrate();
            $this->display();
        }
    }
    //------获取组合后的下级条件
    public function getChild(){
        if (IS_POST) {
            if(I('post.fid') != ''){
                echojson(array('status' => 1, 'msg' => getChildHtml(I('post.fid'))));
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
    // ------删除关联
    public function delLink(){
        if (IS_POST) {
            $where = array('cid'=>I('post.cid'));
            if(I('post.fid') != 0){
                $where['fid'] = I('post.fid');
            }
            if(M('Goods_category_filtrate')->where($where)->delete()){
               echojson(array('status' => 1, 'msg' => '解除关联成功')); 
            }else{
               echojson(array('status' => 0, 'msg' => '解除关联失败，请刷新重试')); 
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
    /**
     +----------------------------------------------------------
     * 商品扩展字段配置
     +----------------------------------------------------------
     */
    public function fields_list(){
        $this->gdcof = include APP_PATH . 'Common/Conf/SetExtend.php';
        $list = M('goods_extend')->order('rank desc')->select();
        $this->list=$list;
        $this->display();
    }
    // 添加/编辑扩展字段
    public function fields_add(){
        if (IS_POST) {
            echojson(D('goods')->fields_add());
        }else{
            $info = M('Goods_extend')->where(array('eid'=>I('get.eid')))->find();
            $info['default']=stripslashes($info['default']);
            $this->info=$info;
            $this->display();
        }
    }

    // 商品详情默认值编辑
    public function fields_describe(){
        if (IS_POST) {
            $this->checkToken();
            $config = APP_PATH . "Common/Conf/FieldsDescribe.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            if (set_config("FieldsDescribe", I('post.'), APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'info' => '用户协议已更新','url'=>U('Goods/fields_list')));
            } else {
                echojson(array('status' => 0, 'info' => '用户协议失败，请检查', 'url' => __ACTION__));
            }
        } else {
            $FieldsDescribe = include APP_PATH . 'Common/Conf/FieldsDescribe.php';
            $this->describe=stripslashes($FieldsDescribe['FIELDS_DESCRIBE']);
            $this->display();
        }

    }

    // 删除扩展字段
    public function delField(){
        if (M("Goods_extend")->where("eid=" . (int) $_GET['id'])->delete()) {
            $this->success("成功删除");
            //echojson(array("status"=>1,"info"=>""));
        } else {
            $this->error("删除失败，可能是不存在该ID的记录");
        }
    }
    // ------异步字段排序
    public function order_fields() {
        if (IS_POST) {
            $getInfo = I('post.');
            $M = M('Goods_extend');
            $where=array('eid'=>$getInfo['odAid']);
            if($getInfo['odType'] == 'rising'){
                if($M->where($where)->setInc('rank')){
                    echojson(array('status'=>'1','msg'=>'排序写入数据库成功'));
                }
            }elseif($getInfo['odType'] == 'drop'){
                if($M->where($where)->setDec('rank')){
                    echojson(array('status'=>'0','msg'=>'排序写入数据库失败'));
                }
            }
        } else {
            E('页面不存在');
        }
    }
    // ------异步字段开关
    public function onOff_fields() {

        if (IS_POST) {
            $data = array(
                'eid'=>I('post.eid'),
                'status'=>I('post.val')
                );
            $sta = $data['status'] == 0 ? '关闭':'开启';
            if(M('Goods_extend')->save($data)){
                echojson(array('status'=>'1','msg'=>'成功'.$sta)); 
            }else{
                echojson(array('status'=>'0','msg'=>$sta.'失败')); 
            }
        } else {
            E('页面不存在');
        }
    }
    // ------异步区域字段设置
    public function region_fields() {
        if (IS_POST) {
            $config = APP_PATH . "Common/Conf/SetExtend.php";
            $config = file_exists($config) ? include "$config" : array();
            $config = is_array($config) ? $config : array();
            $data = array(I('post.key')=>I('post.val'));
            if (set_config("SetExtend", $data, APP_PATH . "Common/Conf/")) {
                delDirAndFile(WEB_CACHE_PATH . "Cache/Admin/");
                echojson(array('status' => 1, 'msg' => '设置成功'));
            } else {
                echojson(array('status' => 0, 'msg' => '设置失败，请检查'));
            }
        } else {
            E('页面不存在');
        }
    }
    // ------异步获取地区
    public function region(){
        if (IS_POST) {
            $region = M('region');
            $field = array('region_id','region_name');
            if (I('post.tier') == 1) {
                $tier = 2;
                $selected = '——选择城市——';
            }elseif (I('post.tier') == 2) {
                $tier = 3;
                $selected = '——选择区、县——';
            }
            $option = $region->field($field)->where(array('parent_id'=>I('post.pid')))->select();
            $optionHtml = '<option selected="selected" tier="'.$tier.'" value="0">'.$selected.'</option>';
            foreach ($option as $ok => $ov) {
                $optionHtml .= '<option tier="'.$tier.'" value="'.$ov['region_id'].'">'.$ov['region_name'].'</option>';
            }
            echojson(array('status' => 1, 'msg' => $optionHtml)); 
        }
    }
    /**
     +----------------------------------------------------------
     *频道、分类与扩展字段关联
     +----------------------------------------------------------
     */
     public function cate_extend(){
        if (IS_POST) {
            echojson(D("Goods")->cate_extend());
        } else {
            $extend = M('goods_extend');

            $c_e = M('Goods_category_extend');
            $ceMap = $c_e->select();
            $cMap = $c_e->getField('cid',true);
            $cMap = array_unique($cMap); //去除重复的Cid
            sort($cMap); //对数组进行排序
            // 根据分类输出关联关系
            $newMap = array();
            $i = 0;
            foreach ($cMap as $cK => $cV) {
               foreach ($ceMap as $fK => $fV) {
                    if($fV['eid']!=0){  //判断字段是不是地区 不是地区读数据库
                        if($cV ==$fV['cid']){
                            $newMap[$i]['cid']=$cV;
                            $newMap[$i]['extend'][$fV['eid']]=$extend->where('eid='.$fV['eid'])->getField('name');
                        }  
                    }else{
                        if($cV ==$fV['cid']){
                            $newMap[$i]['cid']=$cV;
                            $newMap[$i]['extend'][0]='地区';
                        }
                    }
                } 
                $i +=1;
            }

            $this->map=$newMap;
            $this->cate = D("Goods")->category(); //分配频道分类
            $this->fdlist = $extend->field('eid,name')->select(); //分配扩展字段
            $this->display();
        }
     }
    // ------删除关联
    public function delExtend(){
        if (IS_POST) {
            $where = array('cid'=>I('post.cid'));
            if(I('post.eid') != ''){
                $where['eid'] = I('post.eid');
            }
            if(M('Goods_category_extend')->where($where)->delete()){
               echojson(array('status' => 1, 'msg' => '解除关联成功')); 
            }else{
               echojson(array('status' => 0, 'msg' => '解除关联失败，请刷新重试')); 
            }
        } else {
            E('哎哟！怎么到这里了?');
        }
    }
}