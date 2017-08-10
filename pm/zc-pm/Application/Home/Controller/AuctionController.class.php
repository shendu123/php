<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class AuctionController extends CommonController {
  /**
   * 正在拍卖
   * @return [type] [description]
   */
    public function index(){
        $ism = $this->ism;
        // $gt[0]：频道分类  
        // $gt[1]:分页显示条数 
        // $gt[2]：结束时间段 (0.正在进行的拍卖 1.今天结束2.明天结束3.其他 )
        // $gt[3]：城市(省——市——区) 
        // $gt[4]：筛选属性(属性1,属性2.....)
        // $gt[5]：拍卖模式(0：竞拍1，：竞标) 
        // $gt[6]：是否出价(a：全部，y：已出价，n：未出价) 
        //设置默认条件 
        $gt = explode('-', I('get.gt'));
        $gtCount = count($gt);
        if($gtCount==1){
            if($gt[0]!=''){
                $gt = array($gt[0],'12','0','0_0_0',getTopField($gt[0]),'i','a');
            }else{
                $gt = array('1','12','0','0_0_0',getTopField(1),'i','a');
            }
        }elseif ($gtCount!=7) {
            $this->error('页面不存在');
        }
        $bidMap = D('Auction');
        // 是否出价条件------------------------------------------------------------
        $bid_yn = array();
        if($gt[6]=='y'){
            $bid_yn = array('uid'=>array('neq',0));
        }elseif ($gt[6]=='n') {
            $bid_yn = array('uid'=>array('eq',0));
        }
        //结束时间段条件------------------------------------------------------------
        $section = bidSection($gt[2]); 
        // 生成地区条件
        $reg_where=bidRegion($gt[3]);
        // 获取抽出的部分返回的值，值为分类id集合
        $bC = bidChannel($gt[0]);
        // 生成控制分页数量列表、地址
        $this->set_page=$bidMap->set_page($gt);
        // 生成拍品结束时间段列表、地址
        $this->end_section=$bidMap->end_section($gt,$bC['gt0'],array_merge($bC['cat_inCid'],$bid_yn));
//商品筛选的操作 ----------------------------------------------------------
        // 组合查询条件
        // $section时间段条件。
        // $inCid频道或分类下的所有分类id，是获取频道或分类下的拍品的条件
        // $reg_where 地区条件
        // 频道对应属性拍品条件
        $filt_where = array_merge($section,$bC['bid_inCid']); //该频道正在拍卖商品
        $filtParMap=$bidMap->where($filt_where)->field('pid,filtrate')->select();
        if($gt[4]){
            $filtSear =explode('_', $gt[4]);
        }else{
            $filtSear = array();
        }
        $unlimited = getTopField($gt[0],'arr'); //该分类不限条件fid
        //筛选条件加进去“不限”条件
        $newFiltSear = array_unique(array_merge($unlimited,$filtSear)); 
        $inSuitFiltPid = array();
        foreach ($filtParMap as $fpk => $fpv) {
            // 当前商品条件加进去“不限”条件
            $newFilt = array_unique(array_merge($unlimited,explode('_', $fpv['filtrate']))); //新商品条件
            if($newFiltSear == array_intersect($newFilt,$newFiltSear)){
                $inSuitFiltPid[]=$fpv['pid']; //符合筛选条件的拍品pid集合
            }
        }
        $bid_inFilt = array('pid'=>array('in',$inSuitFiltPid)); //组合符合筛选的条件
        // 拍卖模式筛选
        $bid_type = $gt[5]!='i' ? array('type'=>$gt[5]) : array();
        //正在拍卖拍品列表处理----------------------------------------------start
        $bid_where = array_merge($filt_where,$bid_inFilt,$reg_where,$bid_type,$bid_yn); //组合条件
        // 分页配置
        $count = $bidMap->where($bid_where)->count();
        $pConf = page($count,$gt[1]);
        $bidArr[0]['bid_list'] = $bidMap->where($bid_where)->limit($pConf['first'].','.$pConf['list'])->order('endtime')->select();
        $bidArr[0]['abc'] = 0;
        // 分配分页到模板
        $this->page = $pConf['show']; 
        // 分配正在拍卖拍品到模板
        $this->bidArr=$bidArr;
//正在拍卖拍品列表处理---------------------------------------------end
        if(!$ism){
//预告拍品列表处理-----------------------------------------------start
            $slist[0]['slistA'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(0))->order('starttime')->limit(4)->select();//全部
            $slist[0]['slistJ'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(1))->order('starttime')->limit(4)->select();//即将
            $slist[0]['slistM'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(2))->order('starttime')->limit(4)->select();//明天
            $slist[0]['slistH'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(3))->order('starttime')->limit(4)->select();//后天
            $slist[0]['slistQ'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(4))->order('starttime')->limit(4)->select();//其他
            $slist[0]['abc']=1;
            $this->slist=$slist;
//预告拍品列表处理-----------------------------------------------end
//最近结束拍品列表处理-----------------------------------------------start
            $elist[0]['elistA'] = $bidMap->where($bC['bid_inCid'])->where(endbid(0))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistJ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(1))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistZ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(2))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistQ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(3))->order('endtime desc')->limit(4)->select();
            $elist[0]['abc'] = 2;
            $this->elist=$elist;
//最近结束拍品列表处理-----------------------------------------------end
        }
        // 分配地区拍品数量显示和筛选
        $this->region=D('Auction')->regionList($gt,array_merge($filt_where,$bid_inFilt,$bid_yn));
        // 在拍分类显示控制
        $this->clist=$bidMap->catList($gt,array_merge($bC['cat_inCid'],$bid_yn)); 
        // 分配商品属性筛选条件到模板------------------------------------------------------------------------
        $this->filt_html=getFiltrateHtml($gt[0],$gt);
        // 分配条件到模板------------------------------------------------------------------------
        $this->gt=$gt;  

        // 分配地区条件到模板---------------------------------------------------------------------
        $this->reg_gt = explode('_', $gt[3]);
        // 分配当前频道ID到模板-------------------------------------------------------------------
        $this->gt0=$bC['gt0'];
        // 分配未出价已出价地址-------------------------------------------------------------------
        $this->ynUrl = array(
            'y'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-y')),
            'n'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-n'))
        );
        // 分配竞拍、竞标地址----------------------------------------------------------------------
        $this->typeUrl = array(
            'pai'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-0'.'-a')),
            'biao'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-1'.'-a'))
        );
        // 分配频道名称
        $this->channelName = M('Goods_category')->where('cid='.$gt[0])->getField('name');
        if($ism){
            $this->stname='在拍';
            $this->display('index');
        }else{
            $this->display();
        }
    }
     /**
      * 即将拍卖
      * @return [type] [description]
      */
    public function waitbid(){
        $ism = $this->ism;
        // $gt[0]：频道分类  
        // $gt[1]:分页显示条数 
        // $gt[2]：开拍时间段 (0.所有未开始拍卖 1.今天开始2.明天开始3.后台开拍4.其他开拍 )
        // $gt[3]：城市(省——市——区) 
        // $gt[4]：筛选属性(属性1,属性2.....)
        // $gt[5]：拍卖模式(0：竞拍1，：竞标) 
        // $gt[6]：是否出价(a：全部，y：已出价，n：未出价) 
        //设置默认条件 
        $gt = explode('-', I('get.gt'));
        $gtCount = count($gt);
        if($gtCount==1){
            if($gt[0]!=''){
                $gt = array($gt[0],'12','0','0_0_0',getTopField($gt[0]),'i','a');
            }else{
                $gt = array('1','12','0','0_0_0',getTopField(1),'i','a');
            }
        }elseif ($gtCount!=7) {
            $this->error('页面不存在');
        }
        $bidMap = D('Auction');
        // 是否出价条件------------------------------------------------------------
        $bid_yn = array();
        if($gt[6]=='y'){
            $bid_yn = array('uid'=>array('neq',0));
        }elseif ($gt[6]=='n') {
            $bid_yn = array('uid'=>array('eq',0));
        }
        //开拍时间段条件------------------------------------------------------------
        $section = foreshow($gt[2]); 
        // 生成地区条件
        $reg_where=bidRegion($gt[3]);
        // 获取抽出的部分返回的值，值为分类id集合
        $bC = bidChannel($gt[0]);
        // 生成控制分页数量列表、地址
        $this->set_page=$bidMap->set_page($gt);
        // 生成开拍时间段列表、地址
        $this->end_section=$bidMap->wait_section($gt,$bC['gt0'],$bC['cat_inCid']);
        //商品筛选的操作 ----------------------------------------------------------
        // 组合查询条件
        // $section时间段条件。
        // $inCid频道或分类下的所有分类id，是获取频道或分类下的拍品的条件
        // $reg_where 地区条件

        // 频道对应属性拍品条件
        $filt_where = array_merge($section,$bC['bid_inCid']); //该频道未开始的拍卖
        $filtParMap=$bidMap->where($filt_where)->field('pid,filtrate')->select();
        if($gt[4]){
            $filtSear =explode('_', $gt[4]);
        }else{
            $filtSear = array();
        }
        $unlimited = getTopField($gt[0],'arr'); //该分类不限条件fid
        //筛选条件加进去“不限”条件
        $newFiltSear = array_unique(array_merge($unlimited,$filtSear));
        $inSuitFiltPid = array(); 
        foreach ($filtParMap as $fpk => $fpv) {
            // 当前商品条件加进去“不限”条件
            $newFilt = array_unique(array_merge($unlimited,explode('_', $fpv['filtrate']))); //新商品条件
            if($newFiltSear == array_intersect($newFilt,$newFiltSear)){
                $inSuitFiltPid[]=$fpv['pid']; //符合筛选条件的拍品pid集合
            }
        }
        $bid_inFilt = array('pid'=>array('in',$inSuitFiltPid)); //组合符合筛选的条件
        // 拍卖模式筛选
        $bid_type = $gt[5]!='i' ? array('type'=>$gt[5]) : array();
        //未开始卖拍品列表处理----------------------------------------------start
        $bid_where = array_merge($filt_where,$bid_inFilt,$reg_where,$bid_type); //组合条件
        // 分页配置
        $count = $bidMap->where($bid_where)->count();
        $pConf = page($count,$gt[1]);
        $bidArr[0]['bid_list'] = $bidMap->where($bid_where)->limit($pConf['first'].','.$pConf['list'])->select();
        $bidArr[0]['abc'] = 1;
        // 分配分页到模板
        $this->page = $pConf['show']; 
        // 分配正在拍卖拍品到模板
        $this->bidArr=$bidArr;
        //未开始拍卖拍品列表处理---------------------------------------------end
        if(!$ism){
            //正在拍卖拍品列表处理-----------------------------------------------start
            $slist[0]['slistA'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(0))->order('starttime')->limit(4)->select();//全部
            $slist[0]['slistJ'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(1))->order('starttime')->limit(4)->select();//即将
            $slist[0]['slistM'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(2))->order('starttime')->limit(4)->select();//明天
            $slist[0]['slistH'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(3))->order('starttime')->limit(4)->select();//后天
            $slist[0]['slistQ'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(4))->order('starttime')->limit(4)->select();//其他
            $slist[0]['abc']=0;
            $this->slist=$slist;
            //正在拍卖拍品列表处理-----------------------------------------------end
            //最近结束拍品列表处理-----------------------------------------------start
            $elist[0]['elistA'] = $bidMap->where($bC['bid_inCid'])->where(endbid(0))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistJ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(1))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistZ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(2))->order('endtime desc')->limit(4)->select();
            $elist[0]['elistQ'] = $bidMap->where($bC['bid_inCid'])->where(endbid(3))->order('endtime desc')->limit(4)->select();
            $elist[0]['abc'] = 2;
            $this->elist=$elist;
            //最近结束拍品列表处理-----------------------------------------------end
        }
        // 分配地区拍品数量显示和筛选
        $this->region=D('Auction')->regionList($gt,array_merge($filt_where,$bid_inFilt));
        // 分配分类列表到模板---------------------------------------------------------------
        $this->clist=$bidMap->catList($gt,$bC['cat_inCid'],'wait'); 
        // 分配商品属性筛选条件到模板------------------------------------------------------------------------
        $this->filt_html=getFiltrateHtml($gt[0],$gt);
        // 分配条件到模板------------------------------------------------------------------------
        $this->gt=$gt;    
        // 分配地区条件到模板---------------------------------------------------------------------
        $this->reg_gt = explode('_', $gt[3]);
        // 分配当前频道ID到模板-------------------------------------------------------------------
        $this->gt0=$bC['gt0'];
        // 分配未出价已出价地址-------------------------------------------------------------------
        $this->ynUrl = array(
            'y'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-y')),
            'n'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-n'))
        );
        // 分配竞拍、竞标地址----------------------------------------------------------------------
        $this->typeUrl = array(
            'pai'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-0'.'-a')),
            'biao'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-1'.'-a'))
        );
        // 分配频道名称
        $this->channelName = M('Goods_category')->where('cid='.$gt[0])->getField('name');

        if($ism){
            $this->stname='待拍';
            $this->display('index');
        }else{
            $this->display();
        }
        
    }
     /**
      * 已结束拍卖
      * @return [type] [description]
      */
    public function endbid(){
        $ism = $this->ism;
        // $gt[0]：频道分类  
        // $gt[1]:分页显示条数 
        // $gt[2]：开拍时间段 (0.所有未开始拍卖 1.今天开始2.明天开始3.后台开拍4.其他开拍 )
        // $gt[3]：城市(省——市——区) 
        // $gt[4]：筛选属性(属性1,属性2.....)
        // $gt[5]：拍卖模式(0：竞拍1，：竞标) 
        // $gt[6]：是否出价(a：全部，y：已出价，n：未出价) 
        //设置默认条件 
        $gt = explode('-', I('get.gt'));
        $gtCount = count($gt);
        if($gtCount==1){
            if($gt[0]!=''){
                $gt = array($gt[0],'12','0','0_0_0',getTopField($gt[0]),'i','a');
            }else{
                $gt = array('1','12','0','0_0_0',getTopField(1),'i','a');
            }
        }elseif ($gtCount!=7) {
            $this->error('页面不存在');
        }
        $bidMap = D('Auction');
        // 是否出价条件------------------------------------------------------------
        $bid_yn = array();
        if($gt[6]=='y'){
            $bid_yn = array('uid'=>array('neq',0));
        }elseif ($gt[6]=='n') {
            $bid_yn = array('uid'=>array('eq',0));
        }
        //开拍时间段条件------------------------------------------------------------
        $section = endbid($gt[2]); 
        // 生成地区条件
        $reg_where=bidRegion($gt[3]);
        // 获取抽出的部分返回的值，值为分类id集合
        $bC = bidChannel($gt[0]);
        // 生成控制分页数量列表、地址
        $this->set_page=$bidMap->set_page($gt);
        // 生成开拍时间段列表、地址
        $this->end_section=$bidMap->endbid_section($gt,$bC['gt0'],$bC['cat_inCid']);
        //商品筛选的操作 ----------------------------------------------------------
        // 组合查询条件
        // $section时间段条件。
        // $inCid频道或分类下的所有分类id，是获取频道或分类下的拍品的条件
        // $reg_where 地区条件

        // 频道对应属性拍品条件
        $filt_where = array_merge($section,$bC['bid_inCid']); //该频道未开始的拍卖
        $filtParMap=$bidMap->where($filt_where)->field('pid,filtrate')->select();
        if($gt[4]){
            $filtSear =explode('_', $gt[4]);
        }else{
            $filtSear = array();
        }
        $unlimited = getTopField($gt[0],'arr'); //该分类不限条件fid
        //筛选条件加进去“不限”条件
        $newFiltSear = array_unique(array_merge($unlimited,$filtSear)); 
        $inSuitFiltPid = array();
        foreach ($filtParMap as $fpk => $fpv) {
            // 当前商品条件加进去“不限”条件
            $newFilt = array_unique(array_merge($unlimited,explode('_', $fpv['filtrate']))); //新商品条件
            if($newFiltSear == array_intersect($newFilt,$newFiltSear)){
                $inSuitFiltPid[]=$fpv['pid']; //符合筛选条件的拍品pid集合
            }
        }
        $bid_inFilt = array('pid'=>array('in',$inSuitFiltPid)); //组合符合筛选的条件
        // 拍卖模式筛选
        $bid_type = $gt[5] != 'i' ? array('type'=>$gt[5]) : array();
        //已结束拍品列表处理----------------------------------------------start
        $bid_where = array_merge($filt_where,$bid_inFilt,$reg_where); //组合条件
        // 分页配置
        $count = $bidMap->where($bid_where)->count();
        $pConf = page($count,$gt[1]);


        $bidArr[0]['bid_list'] = $bidMap->where($bid_where)->limit($pConf['first'].','.$pConf['list'])->order('endtime desc')->select();
        $bidArr[0]['abc'] = 2;
        // 分配分页到模板
        $this->page = $pConf['show']; 
        // 分配正在拍卖拍品到模板
        $this->bidArr=$bidArr;
        //已结束拍卖拍品列表处理---------------------------------------------end
        if(!$ism){
            //正在拍卖拍品列表处理-----------------------------------------------start
            $zlist[0]['zlistA'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(0))->order('endtime')->limit(4)->select();//全部
            $zlist[0]['zlistJ'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(1))->order('endtime')->limit(4)->select();//即将
            $zlist[0]['zlistM'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(2))->order('endtime')->limit(4)->select();//明天
            $zlist[0]['zlistH'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(3))->order('endtime')->limit(4)->select();//后天
            $zlist[0]['zlistQ'] = $bidMap->where($bC['bid_inCid'])->where(bidSection(4))->order('endtime')->limit(4)->select();//其他
            $zlist[0]['abc']=0;
            $this->zlist=$zlist;
            //正在拍卖拍品列表处理-----------------------------------------------end
            //预告拍品列表处理-----------------------------------------------start
            $slist[0]['slistA'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(0))->order('starttime')->limit(4)->select();//全部
            $slist[0]['slistJ'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(1))->order('starttime')->limit(4)->select();//即将
            $slist[0]['slistM'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(2))->order('starttime')->limit(4)->select();//明天
            $slist[0]['slistH'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(3))->order('starttime')->limit(4)->select();//后天
            $slist[0]['slistQ'] = $bidMap->where($bC['bid_inCid'])->where(foreshow(4))->order('starttime')->limit(4)->select();//其他
            $slist[0]['abc']=1;
            $this->slist=$slist;
            //预告拍品列表处理-----------------------------------------------end
        }
        // 分配地区拍品数量显示和筛选
        $this->region=D('Auction')->regionList($gt,array_merge($filt_where,$bid_inFilt));
        // 分配分类列表到模板---------------------------------------------------------------
        $this->clist=$bidMap->catList($gt,$bC['cat_inCid'],'end'); 
        // 分配商品属性筛选条件到模板------------------------------------------------------------------------
        $this->filt_html=getFiltrateHtml($gt[0],$gt);
        // 分配条件到模板------------------------------------------------------------------------
        $this->gt=$gt;    
        // 分配地区条件到模板---------------------------------------------------------------------
        $this->reg_gt = explode('_', $gt[3]);
        // 分配当前频道ID到模板-------------------------------------------------------------------
        $this->gt0=$bC['gt0'];
        // 分配未出价已出价地址-------------------------------------------------------------------
        $this->ynUrl = array(
            'y'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-y')),
            'n'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-i'.'-n'))
        );
        // 分配竞拍、竞标地址----------------------------------------------------------------------
        $this->typeUrl = array(
            'pai'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-0'.'-a')),
            'biao'=>U('index',array('gt'=>$bC['gt0'].'-12'.'-0'.'-0_0_0'.'-'.getTopField($gt[0]).'-1'.'-a'))
        );
        // 分配频道名称
        $this->channelName = M('Goods_category')->where('cid='.$gt[0])->getField('name');
        if($ism){
            $this->stname='结拍';
            $this->display('index');
        }else{
            $this->display();
        }
    }
     /**
      * 所有成交的拍品
      */
     public function allend(){
        $bidMap=D('Auction');
        if(I('get.type')!=''){
            $eWstr['type']=I('get.type');
            $this->type = I('get.type');
        }
        $count = $bidMap->where($eWstr)->where(endbid(0))->count();
        $pConf = page($count,20);
        $endlist[0]['elistA'] = $bidMap->where($eWstr)->where(endbid(0))->limit($pConf['first'].','.$pConf['list'])->order('endtime desc')->select();
        $endlist[0]['abc'] = 2;

        // 分配分页到模板
        $this->endlist=$endlist;
        $this->page = $pConf['show'];
        $this->display();
     }
    // 频道分类页面
    public function channel(){
        $goods_category = M('goods_category');
        $channel = $goods_category->where(array('pid'=>0))->order('sort desc')->select();
        foreach ($channel as $ck => $cv) {
            $cate[$cv['cid']] = $goods_category->where(array('pid'=>$cv['cid']))->order('sort desc')->select();
        }
        $hot = $goods_category->where(array('pid'=>array('neq',0),'hot'=>"1"))->order('sort desc')->select();
        $this->channel=$channel;
        $this->cate=$cate;
        $this->hot=$hot;

        $this->display();
    }
    /**
    * 竞拍商品详情页面
    * @return [type] [description]
    */
    public function details(){
        $this->http_host=$_SERVER['HTTP_HOST'];
        // 为了预防拍卖会中拍品被删除导致轮拍失败
        $ism = $this->ism;
        $M = M('Auction');
        if(I('get.mid')){
            if($M->where(array('pid'=>I('get.pid')))->count()){
                $gtpid = I('get.pid');
            }else{
                $gtpid = $M->where(array('mid'=>I('get.mid'),'endstatus'=>0))->order('msort asc')->getField('pid');
            }
        }else{
            if(!$M->where(array('pid'=>I('get.pid')))->count()){
                $this->error('拍品不存在或已被删除！');
                exit;
            }
            $gtpid = I('get.pid');
        }
        // 为了预防拍卖会中拍品被删除导致轮拍失败_end
        // 实例化用户表
        $member = M('Member');
        $aRecord = M('Auction_record');
        $goods_user = M('Goods_user');
        
        $D = D('Auction');
        $uid = $this->cUid;
        
        // 增加浏览一次
         $info = $D->where(array('pid'=>$gtpid))->find();//dump($info);exit;
        $M->where(array('pid'=>$gtpid))->setInc('clcount',1);
       
        // 处理浮动价格
        $stepsize_type = $info['stepsize_type'];
        $stepsize = $info['stepsize'];
        $info['stepsize'] = setStep($info['stepsize_type'],$info['stepsize'],$info['nowprice']);
        // 首次出价不能小于起拍价，如果起拍价是0不能小于步长，其他不能小于当前价加步长
        if($info['uid']){
            $info['stepsized'] = $info['nowprice']+$info['stepsize'];
        }else{
            if($info['onset']>0){
                $info['stepsized'] = $info['onset'];
            }else{
                $info['stepsized'] = $info['stepsize'];
            }
            
        }
        // 分配拍品状态
        if($info['starttime']<=time()&&$info['endtime'] >= time()){
            $info['nstatus'] = 'ing';
        }elseif ($info['endtime']<time()){
            $info['nstatus'] = 'end';
        }elseif ($info['starttime']>time()) {
            $info['nstatus'] = 'fut';
        }
        // 如果是拍卖会内拍品整合信息-----------------------------------------------
        $ntm = time();
        $mtdata = array();
        if($info['mid']!=0){
            $gpwr = array('mid'=>$info['mid']);
            $gpod = 'msort asc';
            $mtinfo = M('meeting_auction')->where($gpwr)->find();
            // 拍卖会状态
            if($mtinfo['starttime']<=$ntm && $mtinfo['endtime']>=$ntm){
                $mtstatus = 'ing';
            }elseif ($mtinfo['endtime']<$ntm) {
                $mtstatus = 'end';
            }elseif($mtinfo['starttime']>$ntm){
                $mtstatus = 'fut';
            }
            // 拍卖会内正在拍卖的
            $mbidw = array('mid'=>$info['mid'],'endtime'=>array('gt',$ntm));
            $mtnowpid = $M->where($mbidw)->order('msort asc')->getField('pid');
            // 下一件拍品信息
            $nexbid = $M->where(array('mid'=>$info['mid'],'msort'=>array('gt',$info['msort'])))->order('msort asc')->find();
            $mtdata=array(
                'mname'=>$mtinfo['mname'],
                'mtnowpid'=>$mtnowpid,
                'nexbid'=>$nexbid,
                'mtstatus'=>$mtstatus
            );
            $this->mtdata=$mtdata;
        }
        // 如果是拍卖会内拍品整合信息_end----------------------------------------------
        // 结束生成订单
        // create_order($info);
        // 图片字段数组化输出---------------------------------
        if ($info['pictures']) {
            $info['pictures'] = explode('|', $info['pictures']);
        }
        // 最后出价人
        $info['nickname']= nickdis($member->where('uid='. $info['uid'])->getField('nickname'));
        // 全部出价记录
        $recWhere = array('pid'=>$gtpid);
        $bidRecord = $aRecord->where($recWhere)->order('time desc,bided desc')->select();
        if($bidRecord){
            foreach ($bidRecord as $mk => $mv) {
                $bidRecord[$mk]['nickname'] = nickdis($member->where('uid='.$mv['uid'])->getField('nickname'));
            }
        }
        

        // -------分配出价记录到模板

        $this->bidRecord=$bidRecord;
        //用户对该专场出价冻结多少保证金
        $p_l_w = array('gid'=>$info['pid'],'uid'=>$uid,'g-u'=>'p-u');
        // 读取专场信息
        if($info['sid']!=0){
            $gpwr = array('sid'=>$info['sid']);
            $gpod = 'endtime desc';
            $special = M('special_auction')->where($gpwr)->find();
            if ($special['special_pledge_type']==0) {
                $p_l_w = array('gid'=>$info['sid'],'uid'=>$uid,'g-u'=>'s-u');
            }
        }
        // 专场或者拍卖会显示上一件下一件拍卖
        if ($info['sid'] || $info['mid']) {
            $prenex = $D->where($gpwr)->field('pid,pname,pictures')->order($gpod)->select();
            $pnarr = array();
            foreach ($prenex as $pk => $pv) {
                if ($pv['pid']==$info['pid']) {
                    $prek = $pk-1;
                    $nexk = $pk+1;
                    if ($prek>=0) {$pnarr['prev'] =  $prenex[$pk-1];}
                    if ($nexk<count($prenex)) {$pnarr['next'] =  $prenex[$pk+1];}
                }
            }
        }



        $this->pnarr=$pnarr;
        $uFrezze = $goods_user->where($p_l_w)->field('pledge , limsum')->find();

        // 判断对该商品是否有权限----------------------------------------------------------------
        // 无权限操作
        $uLimit = array();
        if(!$uFrezze){
            if($uid){
                // 用户账户输出
                $uLimit = getwallet($uid);
                $uLimit['yn']=0;
                // 判断拍品所在模式--------------------------------------------
                if($info['sid']&&$special['special_pledge_type']==0){
                    // 专场模式且缴纳为专场缴纳
                    if($special['spledge'] <= $uLimit['count']){
                        $uLimit['yn']=1;
                    }else{
                        // 需要多少才能有权限
                        $uLimit['diff'] = round($special['spledge'] - $uLimit['count'],2);
                    }
                }else{
                  // 单品拍模式 
                  if(percent($info['pledge_type'],$info['onset'],$info['pledge']) <= $uLimit['count']){
                      $uLimit['yn']=1;
                  }else{
                    // 需要多少才能有权限
                    $uLimit['diff'] = round(percent($info['pledge_type'],$info['onset'],$info['pledge']) - $uLimit['count'],2);
                  }
                }
            }else{
                // 没有登录
            }
            
        // 有权限操作-------------------------------------------------------------------
        }else{
            $this->uFrezze=$uFrezze;
            // 我的出价记录
            $recWhere['uid'] = $uid;
            $myRecord = $aRecord->where($recWhere)->limit('10')->order('time desc,bided desc')->select();
            $this->myRecord=$myRecord;
            //我的出价次数
            $myCount=$aRecord->where(array('pid'=>$info['pid'],'uid'=>$uid))->count();
            $this->myCount=$myCount;
            $uLimit['yn']=1;
        }
        $this->uid=$uid;
        // 分配用户账户信息
        $this->uLimit=$uLimit;
        // 分配所在频道
        $cat = new \Org\Util\Category('Goods_category', array('cid', 'pid', 'name'));
        $chalist = $cat->getPath($info['cid']);
        // 统计多少人出价
        $recordlist = M('Auction_record')->where(array('pid'=>$info['pid']))->getField('uid',true);
        $this->dsr = count(array_flip($recordlist));
        // 统计多少人关注
        $this->tcount = M('attention')->where(array('gid'=>$info['pid'],'rela'=>'p-u'))->count();
//        if($this->tcount==0){
//            $this->tcount=rand(80,150);
//        }
        $this->chalist=$chalist;
        $gt[0]=$chalist[0]['cid'];
        $this->gt=$gt;
        // 转换佣金显示
        $info['broker'] = brokerShow($info['broker_type'],$info['broker']);
        //mobile-------------------------------------------------------------------------------【
        // 获取扩展字段stripslashes
        if($ism){
            $info['extend']=getExtendsCon($info['cid'],$info['gid'],'wap');
            $this->shimg = C('WEB_ROOT'). str_replace('./', '', C('UPLOADS_PICPATH').picRep($info['pictures'][0],1));
        }else{
            $retHtml =getExtendsCon($info['cid'],$info['gid']);
            $retHtml['eDivHtml']=htmlspecialchars_decode($retHtml['eDivHtml']);
            // 分配扩展字段html
            $info['extend']=$retHtml;
        }
        //】 
        $info['content']=stripslashes($info['content']);
        $info['steptime']=conversionM_S($info['steptime']);
        $info['deferred']=conversionM_S($info['deferred']);


        // 当前用户是否设置代理出价【
        if($uid){
            $agency = M('auction_agency');
            if($myagency = $agency->where(array('pid'=>$gtpid,'uid'=>$uid))->find()){
                $setagency = $myagency['status'];
                $myagprice=$myagency['price'];
            }else{
              // 3为未设置代理出价
               $setagency = 3; 
               $myagprice=$info['nowprice']+thricebid($stepsize_type,$stepsize,$info['nowprice'],0);
            }
            $myname = nickdis($member->where(array('uid'=>$uid))->getField('nickname'));
        }else{
            $setagency = 3;
            $myagprice=$info['nowprice']+thricebid($stepsize_type,$stepsize,$info['nowprice'],0);
            $mycode = get_code(6,0);
            $myname = '游客_'.$mycode;
            $myaccount = $mycode;
        }

        $this->setagency=$setagency;
        $this->myagprice=$myagprice;
        // 分配当前用户名
        $this->myname=$myname;
        // 当前用户是否设置代理出价】
        // 分配关注商品状态
        if(M('attention')->where(array('uid'=>$uid,'gid'=>$gtpid))->count()){$usgz=1;}else{$usgz=0;}
        $this->usgz=$usgz;

        // 分配拍品提醒状态
        if(M('scheduled')->where(array('uid'=>$uid,'pid'=>$gtpid,'stype'=>$info['nstatus']))->count()){$ustx=1;}else{$ustx=0;}

        $this->ustx=$ustx;
        // 分配关注卖家状态
        if(M('attention_seller')->where(array('uid'=>$uid,'sellerid'=>$info['sellerid']))->count()){$gzuser=1;}else{$gzuser=0;}
        $this->gzuser=$gzuser;
        // 卖家信息读取
        $seller = $member->where(array('uid'=>$info['sellerid']))->field('uid,qq,organization,avatar,score')->find();
        $seller['leval'] = getlevel($seller['score']);
        // 卖家信誉
        $seller['credit_score'] = getstarval(M('goods_evaluate'),array('sellerid'=>$info['sellerid']));
        $this->seller=$seller;
        // 必要数据写入缓存【
        $redata = array(
            'uid' => $info['uid'],
            'pname' => $info['pname'],
            'price' => $info['price'],
            'nowprice' => $info['nowprice'],
            'endtime' => $info['endtime'],
            'starttime' => $info['starttime'],
            'nickname' =>$info['nickname'],
            'endstatus' =>$info['endstatus']
            );
        S(C('CACHE_FIX').'bid'.$gtpid,$redata);
        // 必要数据写入缓存】
        
        // 提醒方式设置【
        $alerttype = M('member')->where(array('uid'=>$uid))->getField('alerttype');
        if($alerttype){$this->alerttype = explode(',', $alerttype);}
        // 提醒方式设置】
        // 保证金处理
        $info['pledge'] = pledgeShow($info['pattern'],$info['pledge_type'],$info['onset'],$info['pledge'],$info['spledge'],$info['mpledge']);
        $this->info=$info;
        $this->display();
    }
    // 出价记录
    public function record(){
        $gtpid = I('get.pid');
        $aRecord = M('Auction_record');
        $member = M('member');
        $recWhere = array('pid'=>$gtpid);
        $count = $aRecord->where($recWhere)->count();
        $pConf = page($count,C('PAGE_SIZE'));
        $bidRecord = $aRecord->where($recWhere)->limit($pConf['first'].','.$pConf['list'])->order('time desc,bided desc')->select();
        foreach ($bidRecord as $mk => $mv) {
          $bidRecord[$mk]['nickname'] = nickdis($member->where('uid='.$mv['uid'])->getField('nickname'));
        }
        $this->info = M('Auction')->where(array('pid'=>$gtpid))->find();
        $this->bidRecord=$bidRecord;
        $this->page = $pConf['show']; 
        $this->display();
     }



     // 图片放大列表
     public function details_img(){
        $info = D('Auction')->where(array('pid'=>I('get.pid')))->find();
        if ($info['pictures']) {
            $info['pictures'] = explode('|', $info['pictures']);
        }
        $this->info=$info;
        $this->display();
     }
     /**
      * -------ajax出价
      */
    public function bid(){
        if (IS_POST) {
            $bidMap = D('Auction');
            $m = M('Member');
            $postData = I('post.');
            $uid = $postData['uid'];
            $bidObj=$bidMap->where(array('pid'=>$postData['pid']))->find();
            if($uid==$bidObj['sellerid']){
                echojson(array("status" => 2, "msg" => '您不能参拍自己的拍品！'));
                  exit;
            }

            // 检查系统配置是否需要认证手机号
            $verify = $m->where(array('uid'=>$uid))->getField('verify_mobile');
            if(C('Auction.verify_mobile')==1 && $verify==0){
                echojson(array("status" => 4, "msg" => '<strong>您的手机号未认证，请先认证后进行出价！</strong><br/>现在去认证...','skipurl'=>U('Member/check',array('type'=>'mobile','pid'=>$postData['pid']),'html',true)));
                exit;
            }
            $auth = 0;
            //冻结用户保证金
            $g_uMap=M('Goods_user');
            // 检查专场所在模式并获取是否缴纳保证金--------------------------------------------
            // 专场检查
            $special = M('special_auction')->where(array('sid'=>$bidObj['sid']))->find();
            if($bidObj['sid']&&$special['special_pledge_type']==0){
                // 冻结专场保证金站内信息
                $g_uW = array('gid'=>$bidObj['sid'],'uid'=>$uid,'g-u'=>'s-u');
            }else{
                // 单品拍检查
                $g_uW = array('gid'=>$postData['pid'],'uid'=>$uid,'g-u'=>'p-u');
            }
            // 如果没有拍品权限扣除保证金添加权限---------------------------------------------------
            if(!$g_uMap->where($g_uW)->count()){
                // 获取共需冻结的金额$freeze----------------------------------
                if($bidObj['sid']&&$special['special_pledge_type']==0){
                    // 专场的专场扣除
                    $freeze = $special['spledge'];
                }else{
                    // 单品拍的保证金
                    $freeze = percent($bidObj['pledge_type'],$bidObj['onset'],$bidObj['pledge']);
                }
                // 如果保证金为0元，直接写入出价权限进行出价
                if($freeze==0){
                    $auth = D('Auction')->freeze_pledge_buy($m,$g_uMap,$bidObj,'',0,$g_uW);
                }else{
                    // 用户账户信息----------------------------------
                    $ufield=array('uid','wallet_pledge','wallet_pledge_freeze','wallet_limsum','wallet_limsum_freeze');
                    $uLimit = $m->where('uid='.$uid)->field($ufield)->find();
                    // 首先冻结信用额度
                    $live_limsum = $uLimit['wallet_limsum']-$uLimit['wallet_limsum_freeze'];//可用信用额度
                    $live_pledge = $uLimit['wallet_pledge']-$uLimit['wallet_pledge_freeze'];//可用保证金
                    $chazhi = $live_limsum - $freeze;
                    // 001if
                    if($chazhi>=0){
                        // 先冻结信用额度
                        // 提示用户是否同意冻结保证金
                        if(empty($postData['agr'])){
                            // 专场扣除提醒
                            if($bidObj['sid']&&$special['special_pledge_type']==0){
                                echojson(array("status" => 3, "msg" => '本次出价您将为该专场缴纳信用额度：'.$freeze.'元！<br>缴纳后您可以参与该专场所有拍品的出价格！<br>是否继续？'));
                                exit;
                            // 单品拍扣除提醒
                            }else{
                              echojson(array("status" => 3, "msg" => '本次出价您将为该拍品缴纳信用额度：'.$freeze.'元！<br>是否继续？'));
                              exit;
                            }
                        }else{
                            $auth = D('Auction')->freeze_pledge_buy($m,$g_uMap,$bidObj,'',$freeze,$g_uW);
                        }
                        // 信用额度不足冻结保证金
                    // 001else
                    }else{
                        // 信用额度大于0时作信用额度有多少冻结多少-----------------------------------------
                        // 002if
                        if($live_limsum>0){
                            // 提示用户是否同意冻结保证金
                            if(empty($postData['agr'])){
                                // 专场扣除提醒
                                if($bidObj['sid']&&$special['special_pledge_type']==0){
                                    echojson(array("status" => 3, "msg" => '本次出价您将为该专场缴纳信用额度：'.$live_limsum.'元，保证金'.abs($chazhi).'元！<br>缴纳后您可以参与该专场所有拍品的出价格！<br>是否继续？'));
                                    exit;
                                // 单品拍扣除提醒
                                }else{
                                    echojson(array("status" => 3, "msg" => '本次出价您将为该拍品缴纳信用额度：'.$live_limsum.'元，保证金'.abs($chazhi).'元！<br>是否继续？'));
                                    exit;
                                }
                            }else{
                                $auth = D('Auction')->freeze_pledge_buy($m,$g_uMap,$bidObj,abs($chazhi),$live_limsum,$g_uW);
                            }
                            // 冻结保证金
                        // 002else
                        }else{
                        // 提示用户是否同意冻结保证金
                            if(empty($postData['agr'])){
                                // 专场扣除提醒
                                if($bidObj['sid']&&$special['special_pledge_type']==0){
                                    echojson(array("status" => 3, "msg" => '本次出价您将为该专场缴纳保证金：'.$freeze.'元！<br>缴纳后您可以参与该专场所有拍品的出价格！<br>是否继续？'));
                                    exit;
                                // 单品拍扣除提醒
                                }else{
                                    echojson(array("status" => 3, "msg" => '本次出价您将为该拍品缴纳保证金：'.$freeze.'元！<br>是否继续？'));
                                    exit;
                                }
                            }else{
                                $auth = D('Auction')->freeze_pledge_buy($m,$g_uMap,$bidObj,$freeze,'',$g_uW);
                            }
                        }
                        // 002end
                    }
                }
              // 有出价权限操作
              // 001else
            }else{
                $auth = 1;    
            }
            if($auth){
                // 判断出价是否合法-------------------------------------
                if(!preg_match('/^[0-9][0-9]*(\.[0-9]{0,2})?$/', $postData['bidPric'])&&$postData['agr']!='robot'){
                  echojson(array("status" => 2, "msg" => '必须为正数、数字且小数位最多两位'));
                  exit;
                }
                // 判断拍卖是否已开始
                if($bidObj['starttime']>microtime(true)){
                    echojson(array("status" => 3, "msg" => '当前拍品未开始！请刷新页面！'));
                    exit;
                }
                // 判断拍卖是否已结束
                if($bidObj['endtime']<microtime(true)){
                    echojson(array("status" => 3, "msg" => '当前拍品已结束！请刷新页面！'));
                    exit;
                }
                echojson(D('Auction')->bidprc($postData));
            }  
        }//结束post
    }
    // 冻结卖家保证金提醒
    public function freeze_remind(){
        if(IS_POST){
            $pid = I('post.pid');
            $uid = I('post.uid');
            $jecstr = '';
            $member = M('Member');
            $g_uMap=M('Goods_user');
            $bidObj = M('Auction')->where(array('pid'=>$pid))->find();

            // 保证金冻结模式
            $special = M('special_auction')->where(array('sid'=>$bidObj['sid']))->find();
            if($bidObj['sid']&&$special['special_pledge_type']==0){
                // 冻结专场保证金站内信息
                $g_uW = array('gid'=>$bidObj['sid'],'uid'=>$uid,'g-u'=>'s-u');
                $jecstr = '参拍专场“'.$special['sname'].'”下拍品“'.$bidObj['pname'].'”';
                $jecstrlink = '参拍专场“<a href="'.U('Home/Special/speul',array('sid'=>$special['sid'],'aptitude'=>1)).'">'.$special['sname'].'</a>”下拍品“<a href="'.U('Auction/details',array('pid'=>$bidObj['pid'],'aptitude'=>1)).'">'.$bidObj['pname'].'</a>”';
            }else{
                // 单品拍检查
                $g_uW = array('gid'=>$pid,'uid'=>$uid,'g-u'=>'p-u');
                $jecstr = '参拍“'.$bidObj['pname'].'”';
                $jecstrlink = '参拍“<a href="'.U('Home/Auction/details',array('pid'=>$bidObj['pid'],'aptitude'=>1)).'">'.$bidObj['pname'].'</a>”';
            }
            $finfo = $g_uMap->where($g_uW)->find();

            $wallet = $member->where(array('uid'=>$finfo['uid']))->field('wallet_pledge,wallet_pledge_freeze')->find();
            $usable = $wallet['wallet_pledge']-$wallet['wallet_pledge_freeze'];
            if($finfo['pledge']>0){
            // 提醒通知冻结保证金【
                // 微信提醒内容
                $wei_pledge_freeze['tpl'] = 'walletchange';
                $wei_pledge_freeze['msg']=array(
                    "url"=>U('Member/pledge','','html',true), 
                    "first"=>'您好，参与拍卖已缴纳保证金！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('余额账户','冻结保证金',$jecstr,'-'.$finfo['pledge'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_pledge_freeze = array(
                    'title'=>'参拍冻结保证金',
                    'content'=>$jecstrlink.'冻结保证金【'.$finfo['pledge'].'元】'
                    );
                // 短信提醒内容
                if(mb_strlen($bidObj['pname'],'utf-8')>10){
                    $newname = mb_substr($bidObj['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidObj['pname'];
                }
                $note_pledge_freeze = '参与拍卖“'.$newname.'”'.$jecstr.'保证金【'.$finfo['pledge'].'元】，订单号'.$pledge_data['order_no'].'货款，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_pledge_freeze['title'] = '参拍'.$jecstr.'保证金';
                $mail_pledge_freeze['msg'] = '您好：<br/><p>'.$jecstrlink.'冻结保证金【'.$finfo['pledge'].'】</p><p>您可以<a target="_blank" href="'.U('Home/Member/pledge','','html',true).'">查看账户记录</a></p>';
                sendRemind($member,M('Member_weixin'),array(),array($finfo['uid']),$web_pledge_freeze,$wei_pledge_freeze,$note_pledge_freeze,$mail_pledge_freeze,'buy');
            // 提醒通知冻结保证金【
            }
            if($finfo['limsum']>0){
            // 提醒通知冻结信誉额度【
                // 微信提醒内容
                $wei_limsum_freeze['tpl'] = 'walletchange';
                $wei_limsum_freeze['msg']=array(
                    "url"=>U('Member/limsum','','html',true), 
                    "first"=>'您好，参与拍卖已缴纳信誉额度！',
                    "remark"=>'查看账户记录>>',
                    "keyword"=>array('信誉额度账户','冻结信誉额度',$jecstr,'-'.$finfo['limsum'].'元',$usable.'元')
                );
                // 账户类型，操作类型、操作内容、变动额度、账户余额
                // 站内信提醒内容
                $web_limsum_freeze = array(
                    'title'=>'参拍冻结信誉额度',
                    'content'=>$jecstrlink.'冻结信誉额度【'.$finfo['limsum'].'元】'
                    );
                // 短信提醒内容
                if(mb_strlen($bidObj['pname'],'utf-8')>10){
                    $newname = mb_substr($bidObj['pname'],0,10,'utf-8').'...';
                }else{
                    $newname = $bidObj['pname'];
                }
                $note_limsum_freeze = '参与拍卖“'.$newname.'”'.$jecstr.'信誉额度【'.$finfo['limsum'].'元】，订单号'.$limsum_data['order_no'].'货款，您可以登陆平台查看账户记录。';
                // 邮箱提醒内容
                $mail_limsum_freeze['title'] = '参拍'.$jecstr.'信誉额度';
                $mail_limsum_freeze['msg'] = '您好：<br/><p>'.$jecstrlink.'冻结信誉额度【'.$finfo['limsum'].'】</p><p>您可以<a target="_blank" href="'.U('Home/Member/limsum','','html',true).'">查看账户记录</a></p>';

                sendRemind($member,M('Member_weixin'),array(),array($finfo['uid']),$web_limsum_freeze,$wei_limsum_freeze,$note_limsum_freeze,$mail_limsum_freeze,'buy');
            // 提醒通知冻结信誉额度【
            }
        }else{
            $this->error('页面不存在');
        }

    }

    // 出价成功异步提醒用户
    public function send_remind(){
        if(IS_POST){
            $pid = I('post.pid');
            $member = M('member');
            $where = array('pid'=>$pid);
            $info = D('Auction')->where($where)->find();
            $record = M('Auction_record')->where($where)->order('time desc,bided desc')->limit(2)->select();
            $recordA = $record[0];
            $recordB = $record[1];

        // 出价被超越提醒用户/出价成功提醒【
            if(mb_strlen($info['pname'],'utf-8')>15){
                $newname = mb_substr($info['pname'],0,15,'utf-8').'...';
            }else{
                $newname = $info['pname'];
            }
            $link = '拍品：“<a target="_blank" href="'.U('Home/Auction/details',array('pid'=>$info['pid'],'aptitude'=>1)).'">'.$info['pname'].'</a>”';

            // 出价被超越【
            if (!empty($recordB)) {
                // 微信提醒内容
                $wei_surpass['tpl'] = 'surpass';
                $wei_surpass['msg']=array(
                    "url"=>U('Auction/details',array('pid'=>$info['pid']),'html',true), 
                    "first"=>"您好，您的出价【".$recordB['bided']."元】已被超过。",
                    "remark"=>'立即前往加价',
                    "keyword"=>array($info['pname'],$info['nowprice'].'元'),
                );
                // 站内信提醒内容
                $web_surpass = array(
                    'title'=>'竞拍出价被超越',
                    'content'=>'您参拍'.$link.'出价【'.$recordB['bided'].'元】已被超过。'
                );
                // 短信提醒内容
                $note_surpass = '您参拍“'.$newname.'”的出价【'.$recordB['bided'].'元】已被超越，您可以登陆网站继续加价';
                // 邮箱提醒内容
                $mail_surpass['title'] = '竞拍出价被超越通知';
                $mail_surpass['msg'] = '您好：<br/><p>您参与竞拍'.$link.'的出价【'.$recordB['bided'].'元】被超越。</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站继续加价！</p>';

                sendRemind(M('Member'),M('Member_weixin'),array(),array($recordB['uid']),$web_surpass,$wei_surpass,$note_surpass,$mail_surpass,'buy');
            }
            // 出价被超越】

            // 提醒卖家拍品出价更新【
                // 微信提醒内容
                $wei_youren['tpl'] = 'surpass';
                $wei_youren['msg']=array(
                    "url"=>U('Auction/details',array('pid'=>$info['pid']),'html',true), 
                    "first"=>"您好，拍品当前价【".$info['nowprice']."元】，目前领先。",
                    "remark"=>'查看拍品详情',
                    "keyword"=>array($info['pname'],$info['nowprice'].'元')
                );
                // 站内信提醒内容
                $web_youren = array(
                    'title'=>'拍品出价更新',
                    'content'=>$link.'当前价【'.$info['nowprice'].'元】，目前领先'
                    );
                // 短信提醒内容
                $note_youren = '拍品“'.$newname.'”当前价【'.$info['nowprice'].'元】成功！';
                // 邮箱提醒内容
                $mail_youren['title'] = '拍品出价更新';
                $mail_youren['msg'] = '您好：<br/><p>'.$web_youren['content'].'</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站查看详情！</p>';

                sendRemind(M('Member'),M('Member_weixin'),array(),array($info['sellerid']),$web_youren,$wei_youren,$note_youren,$mail_youren,'sel');
            // 提醒卖家拍品出价更新】
            // 出价成功【
                // 微信提醒内容
                // $wei_success['tpl'] = 'bidsuccess';
                // $wei_success['msg']=array(
                //     "url"=>U('Auction/details',array('pid'=>$info['pid']),'html',true), 
                //     "first"=>"您好，您已成功出价【".$recordA['bided']."元】，目前领先。",
                //     "remark"=>'查看拍品详情',
                //     "keyword"=>array($info['pname'],date('Y年m月d日 H:i',$info['endtime']))
                // );
                // // 站内信提醒内容
                // $web_success = array(
                //     'title'=>'竞拍出价成功',
                //     'content'=>'您参拍'.$link.'出价【'.$recordA['bided'].'元】成功！'
                //     );
                // // 短信提醒内容
                // $note_success = '您参拍“'.$newname.'”出价【'.$recordA['bided'].'元】成功，当出价被超越将提醒您继续出价！';
                // // 邮箱提醒内容
                // $mail_success['title'] = '竞拍出价成功';
                // $mail_success['msg'] = '您好：<br/><p>您参与竞拍'.$link.'已成功出价【'.$recordA['bided'].'元】，目前领先。</p><p>请<a target="_blank" href="'.U('Home/Login/index','','html',true).'">登陆</a>网站查看详情！</p>';

                // sendRemind(M('Member'),M('Member_weixin'),array(),array($recordA['uid']),$web_success,$wei_success,$note_success,$mail_success,'buy');
            // 出价成功】
        // 出价被超越提醒用户/出价成功提醒】
        }else{
            $this->error('页面不存在');
        }
    }




    // public function deltest(){
    //     M('auction_agency')->where(array('uid'=>89,'pid'=>238))->delete();
    //     M('auction_record')->where(array('pid'=>238))->delete();
    //     M('auction')->where(array('pid'=>238))->setField('uid',0);
    //     S(C('CACHE_FIX').'bid'.'139',null);
    //     if(M('goods_user')->where(array('uid'=>89,'gid'=>238))->delete()){
    //       $this->success('删除成功');
    //     }

    // }
    // 取消代理出价
    public function cancel_agency(){
        if(IS_POST){
            $data = array('agency_uid'=>0,'agency_price'=>0);
            $auction_agency = M('auction_agency');
            M('auction')->where(array('agency_uid'=>I('post.uid'),'pid'=>I('post.pid')))->setField($data);
            $where = array('pid'=>I('post.pid'),'uid'=>I('post.uid'));
            if($auction_agency->where($where)->count()){
                if($auction_agency->where($where)->delete()){
                    echojson(array('status'=>1));
                }else{
                    echojson(array('status'=>0));
                }
            }else{
                echojson(array('status'=>1));
            }
        }else{
            $this->error('页面不存在');
        }

    }
    // 客户已知代理出价结束状态
    public function iknow(){
        if(IS_POST){
            $auction_agency = M('auction_agency');
            $where = array('pid'=>I('post.pid'),'uid'=>I('post.uid'));
            if(M('auction_agency')->where($where)->count()){
                if(M('auction_agency')->where($where)->delete()){
                    echojson(array('status'=>1));
                }else{
                    echojson(array('status'=>0));
                }
            }else{
                echojson(array('status'=>1));
            }
            
        }else{
            $this->error('页面不存在');
        }

    }
     // 获取当前拍品时间
     public function ajaxGetTime(){
        if(IS_POST){
          session_write_close();
          $pid=I('post.pid');
          $bidS = S(C('CACHE_FIX').'bid'.$pid);
          $rtime = array('starttime'=>$bidS['starttime'],'endtime'=>$bidS['endtime'],'nowtime'=>time());
          echojson($rtime);
        }else{
            $this->error('页面不存在');
        }
     }
    // --------时间结束提交地址
    public function checksucc(){
        if(IS_POST){
            session_write_close();
            $pid=I('post.pid');
            $bidS = S(C('CACHE_FIX').'bid'.$pid);
            if($bidS['endtime']<time()){
                if($bidS['nowprice']>=$bidS['price']&&$bidS['uid']!=0){
                    if($bidS['endstatus']!=4){
                        $nickname = $bidS['nickname'];
                        echojson(array('status'=>1,'uid'=>$bidS['uid'],'nickname'=>$nickname,'money'=>$bidS['nowprice'],'pname'=>$bidS['pname']));
                    }else{
                        echojson(array('status'=>3,'pname'=>$bidS['pname']));
                    }
                // 流拍处理
                }else{
                    if($bidS['endstatus']!=4){
                        echojson(array('status'=>2,'pname'=>$bidS['pname']));
                    }else{
                        echojson(array('status'=>3,'pname'=>$bidS['pname']));
                    }
                }
            }else{
                echojson(array('status'=>0,'now_time'=>time(),'end_time'=>$pai['endtime']));
            }
        }else{
            $this->error('页面不存在');
        }

    }
    // 关注
    public function attention(){
        if(IS_POST){
        if(I('post.uid')){
            $att=M('attention');
            $data = array(
                'gid'=>I('post.pid'),
                'uid'=>I('post.uid'),
                'rela'=>'p-u'
                );
            if(!$att->where($data)->count()){
              if($att->add($data)){
                echojson(array('status'=>1,'msg'=>'已关注'));
              }
            }else{
              if($att->where($data)->delete()){
                echojson(array('status'=>1,'msg'=>'已取消关注'));
              }
            }
        }else{
          echojson(array('status'=>0,'msg'=>'您没有登陆，请登录后进行设置！'));
        }
        }else{
            $this->error('页面不存在');
        }
    }
    // 提醒
    public function scheduled(){
        if(IS_POST){
        if(I('post.uid')){
            if(I('post.stype')!='end'){
                if(I('post.stype')=='fut'){$rep="开拍";}else{$rep="结束";}

                $att=M('scheduled');
                $data = array(
                    'pid'=>I('post.pid'),
                    'uid'=>I('post.uid'),
                    'stype'=>I('post.stype')
                    );
                if(!$att->where($data)->count()){
                  if($att->add($data)){
                    echojson(array('status'=>1,'info'=>'已设置'.$rep.'提醒！<br>系统会在<strong>'.$rep.'前5分钟</strong>内提醒您参与拍卖！'));
                  }
                }else{
                  if($att->where($data)->delete()){
                    echojson(array('status'=>1,'info'=>'已取消'.$rep.'提醒'));
                  }
                }
            }else{
                echojson(array('status'=>0,'info'=>'商品已结束，不支持设置提醒！'));
            }
            
        }else{
          echojson(array('status'=>0,'info'=>'您没有登陆，请登录后进行设置！'));
        }
        }else{
            $this->error('页面不存在');
        }
    }
    //机器人定时(早上9-12点)出价    
    function robotBid(){
        $start   = strtotime(date("Y-m-d 9:00:00"));
        $end   = strtotime(date("Y-m-d 12:00:00"));        
        if(time() > $start && time() < $end){
            $info=D('Auction')->bidrobot();
            if($info['status']==1){
                echojson(array('status'=>1,'info'=>'success'));
            }else{
                echojson(array('status'=>-1,'info'=>'auction error'));
            }            
        }else{
            echojson(array('status'=>-1,'info'=>'time error'));
        }       
    }
    //拍卖详情在线用户列表
    function onlineUserList(){
        $pid=I('get.pid');
        //S('clist'.$pid,NULL);
        if( S('clist'.$pid)){
            echojson(array('status'=>1,'data'=>S('clist'.$pid)));
        }  
        $whereMem['account']=['like','rob%'];
        $whereMem['status']=1;
        $count=M('member')->where($whereMem)->count();
        $rand=mt_rand(0,$count-1); 
        $limit=$rand.','.'20'; 
        $memberList=M('member')->where($whereMem)->field('nickname')->limit($limit)->select();
//        $client_id=bin2hex(pack('NnN', $local_ip, $local_port, $connection_id));        
        foreach($memberList as $k=>$v){
            $client_id=  randCode(20, $type=0);
            $nickList[$client_id]=$v['nickname'];
        }       
        if($nickList){
            if( !S('clist'.$pid)){
                S('clist'.$pid,$nickList,['expire'=>1800]);//缓存半个小时
                echojson(array('status'=>1,'data'=>$nickList));
            }             
        }else{
            echojson(array('status'=>-1,'info'=>'error'));
        }          
         
    }

}