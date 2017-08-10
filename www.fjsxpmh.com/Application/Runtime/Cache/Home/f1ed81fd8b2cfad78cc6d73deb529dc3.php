<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
		<meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title><?php echo ($site["SITE_INFO"]["title"]); ?></title>
        <style type="text/css">.navleft .leftlist {display: block;}</style>
        <meta name="viewport" content="width=1200,initial-scale=1.0"/>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="edge" />
<base href="<?php echo ($site["WEB_ROOT"]); ?>"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/index.css" />
<link rel="stylesheet" type="text/css" href="/Public/Css/pop_status.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/asyncbox/skins/oncoo.css" />
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script>
<script type="text/javascript" src="/Public/Home/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/pop_status.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Js/asyncbox/asyncbox.js"></script>
<script type="text/javascript">

	var attUrl = "<?php echo U('Member/attention');?>";
	// 关注商家地址
	var setAttentionSellerUrl ="<?php echo U('Seller/attention');?>";
	var getusercard = "<?php echo U('Public/getusercard');?>"
	var login = "<?php echo ($login); ?>";
	var iswei="<?php echo ($iswei); ?>";
	var domain = "<?php echo ($site["WEB_ROOT"]); ?>";
	
</script>

		<link rel="stylesheet" type="text/css" href="/Public/Home/Css/cuitindex.css" />
		<link rel="stylesheet" type="text/css" href="/Public/Home/Css/list.css" />
		<script type="text/javascript" src="/Public/Home/Js/indexjs.js"></script>
    </head>
    <body>
    <div class="indexheader">
    <div class="top bg_wide">
        <div class="topcon w_wide"> 
            <div class="top_fl fl">
    <?php echo ($site["SITE_INFO"]["summary"]); ?>
    
    <?php if($login): ?>您好，尊敬的<strong><?php echo ($nickname); ?></strong>,欢迎来到<?php echo ($site["SITE_INFO"]["name"]); ?>！
    <?php else: ?>
        您好，欢迎来到<?php echo ($site["SITE_INFO"]["name"]); ?>！
        <a href="<?php echo U('Login/index');?>" title="请登录">请登录</a>
        <a href="<?php echo U('Login/register');?>">免费注册</a><?php endif; ?>
</div>
<ul class="top_fr fr">
    <?php if($login): ?><li><a href="<?php echo U('Member/index');?>">我的<?php echo ($site["SITE_INFO"]["name"]); ?></a></li>
        <li><a href="<?php echo U('Public/loginOut');?>">退出</a></li><?php endif; ?>
    
    <li><a href="<?php echo U('Article/help');?>">帮助中心</a></li>
    <li>
        <div class="serviceTel">客服热线：<span class="tel_no"><?php echo ($site["SITE_INFO"]["tel"]); ?></span></div>
    </li>
</ul>
        </div>
    </div>
    <div class="head" style="position:relative;" >
        <h1 class="logo">
            <?php echo showAdvPosition('web_logo','span');?>
        </h1>
        <div class="logo_r_ad">
            <?php echo showAdvPosition('web_logo_right','span');?>
        </div>
        
        <div class="search">
            <ul class="search-slec">
              <li class="searcur"><a val="0" href="javascript:void(0);">全部</a></li>
              <li ><a val="1" href="javascript:void(0);">拍卖</a></li>
              <li ><a val="2" href="javascript:void(0);">资讯</a></li>
            </ul>
            <div class="search-panel">
                <form id="form_search" name="form_search" method="post" action="<?php echo U('Index/search');?>">
                    <input id="seakey" class="text"  type="text"  value="请输入关键词"  name="searchkey" autocomplete="off" />
                    <input type="hidden" id="searchtype" name="searchtype" value = "0" />
                    <input id="seaForm" type="button" class="button" value="查 询" />
                </form>
           </div>
        </div>    
        <div class="mybox">
            <a href="<?php if(($login) == "1"): echo U('Member/mybid'); else: echo U('Login/index'); endif; ?>" rel="nofollow">我的拍卖</a>                     
        </div>
    </div>
    <div class="nav"> 
        <div class="navcon clearfix">

            <div <?php if(!((CONTROLLER_NAME == 'Index') and (ACTION_NAME == 'index'))): ?>id="navleft"<?php endif; ?> class="navleft">
                <h2>导航、推荐
                <?php if(!((CONTROLLER_NAME == 'Index') and (ACTION_NAME == 'index'))): ?><span class="xiala"></span><?php endif; ?>
                </h2>
                <div class="leftlist">
                    <ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a" target="_self" href="">二手车拍卖</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="http://www.oncoo.net">死地方</a></li><li> <a class="" target="_self" href="">正在拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">即将拍卖</a></li><li> <a class="" target="_self" href="">拍卖资讯</a></li></ul></li><li class="one_li"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">艺术品拍卖</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="">一口价</a></li><li> <a class="" target="_self" href="">二手车拍卖</a></li><li> <a class="" target="_self" href="">现代工艺</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">珠宝玉器</a></li><li> <a class="" target="_self" href="index.php/Auction/index">收藏车拍卖</a></li><li> <a class="" target="_self" href="index.php/Auction/index">报废车拍卖</a></li></ul></li><li class="one_li cor_ff"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">拍卖咨询</a><ul class="menu_twolayer clearfix"><li> <a class="two_cor" target="_self" href="javascript:void(0);">我要拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">如何拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">发布二手车</a></li></ul></li><li class="one_li"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">昂酷网络</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="http://www.oncoo.net">拍卖系统</a></li><li> <a class="" target="_self" href="http://www.oncoo.net">竞拍系统</a></li><li> <a class="" target="_self" href="http://www.baidu.com">在线拍卖程序</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">怎么样拍成功</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">如何购买呢</a></li></ul></li></ul>
                </div>
            </div>

            <div class="navmain cearfix">
                <div class="defaultNav">
                    <ul>
                        <li <?php if((CONTROLLER_NAME) == "Index"): if((ACTION_NAME) != "search"): ?>class="navcur"<?php endif; endif; ?>>
                           <a href="<?php echo U('Index/index');?>" title="<?php echo ($site["SITE_INFO"]["title"]); ?>"> 首页</a> 
                        </li>

                        <?php if(is_array($channelMenu)): foreach($channelMenu as $key=>$cm): ?><li <?php if(($gt["0"]) == $cm["cid"]): ?>class="navcur"<?php endif; ?>>
                               <a href="<?php echo U('Auction/index',array('gt'=>$cm['cid']));?>"> <?php echo ($cm["name"]); ?></a> 
                            </li><?php endforeach; endif; ?>
                        <li <?php if((CONTROLLER_NAME) == "Special"): ?>class="navcur"<?php endif; ?>><a href="<?php echo U('Special/index');?>">专场拍卖</a></li>
                        <li <?php if((CONTROLLER_NAME) == "Meeting"): ?>class="navcur"<?php endif; ?>><a href="<?php echo U('Meeting/index');?>">拍卖会</a></li>
                        <li><ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">添加的导航</a></li></ul></li>
                        <?php if((ACTION_NAME) == "search"): ?><li class="navcur"><a href=""> 搜索结果</a></li><?php endif; ?>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var seakey =$('#seakey');
    $(function(){
        // 搜索框
        var keyval = seakey.val();  
        seakey.focus(function() {if ($(this).val() == keyval) {$(this).val("");}});
        seakey.blur(function() {if ($(this).val()== "") {$(this).val(keyval);}}); 
        $('.search-slec a').click(function(){
            $(this).parents('ul').children('li').removeClass("searcur");
            $(this).parents('li').addClass("searcur");
            $('#searchtype').attr('value',$(this).attr('val'));
        });
        $('#seaForm').click(function(){
            if (seakey.val()==""||seakey.val()=="请输入关键词"){ 
              popup.error("请输入关键词");
              setTimeout(function(){
                popup.close("asyncbox_error");
              },2000);
              seakey.focus();
              return false;
            }else{
              $('#form_search').submit();
            }
        });
    });
</script>

    <div class="container">
        <div class="contenttop clearfix">
            <div class="contentright">
                <div class="topad">
                    <?php echo showAdvPosition('index_notice_top');?> 
                </div>
                <div class="notice">
                    <h3><?php echo ($caname); ?><a target="_blank" href="<?php echo U('Article/notice',array('cid'=>2));?>">更多</a></h3>
                    <?php echo W('Oncoo/notice',array(2,5));?>
                </div>
                <div class="notice">
                    <h3><?php echo ($cbname); ?>.<?php echo ($site["SITE_INFO"]["name"]); ?><a target="_blank" href="<?php echo U('Article/notice',array('cid'=>3));?>">更多</a></h3>
                    <?php echo W('Oncoo/notice',array(3,5));?>
                </div>
            </div>
            <!-- 首页幻灯片广告位 -->
            <div id="focus">
                <?php echo showAdvPosition('index_slides');?> 
            </div>
            <!-- 首页幻灯片广告位——end -->
        </div>
        
        
        <!-- 首页频道循环输出 -->
        <?php if(is_array($channel)): foreach($channel as $key=>$vo): ?><div class="paimai clearfix">
    <div class="boxtit">
        <h2><?php echo ($vo["name"]); ?></h2>
        <p>
            <span class="boxtitblack">竞拍</span>
            <span>&nbsp;规定时间，多次出价，价高者得。</span>
            <span class="boxtitblack">竞标</span> 
            <span>&nbsp;规定时间，一次出价，价高者得。</span> 
        </p>
        <a target="_blank" href="<?php echo U('Auction/index',array('gt'=>$vo['cid']));?>">进入频道</a>
    </div>
    <div class="pmboxcenter">
        <h3 class="pmlisttit clearfix">
            <p class="pmlisttitleft"><a target="_blank" href="<?php echo U('Auction/index',array('gt'=>$vo['cid']));?>">正在火热拍卖</a>
                <span></span>
            </p>
            <p class="pmlisttitright">
            <a target="_blank" href="<?php echo U('Auction/endbid',array('gt'=>$vo['cid']));?>">最新成交</a>|
            <a target="_blank" href="<?php echo U('Auction/waitbid',array('gt'=>$vo['cid']));?>">拍卖预告</a>
            </p>
        </h3>
        <div class="pmlistdetail clearfix">
            <?php if(is_array($vo["bid"])): foreach($vo["bid"] as $key=>$bav): ?><!-- 全部未开拍 -->
                <div id="elistA" class="auctionbox tab_con clearfix" style="display:block;">
                    <?php if(empty($bav["elistA"])): ?><div class="datanone">很抱歉该条件下暂无拍品，您可以重新查询！</div>
                    <?php else: ?>
                        <?php if(is_array($bav["elistA"])): $i = 0; $__LIST__ = $bav["elistA"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
    <li class="txt01" gid="<?php echo ($avo["gid"]); ?>">
        <a href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <img width="259" title="<?php echo ($avo["pname"]); ?>  [编号：<?php echo ($avo["bidnb"]); ?>]" height="194" src="<?php echo ($upWholeUrl); echo (getpicurl($avo["pictures"],2,0)); ?>" alt="<?php echo ($avo["pname"]); ?>"></img>
            <!-- 正在拍图标 -->
            <?php if(($bav["abc"]) == "0"): ?><span class="icons <?php if(($avo["status"]) == "0"): ?>icon01<?php endif; ?> <?php if(($avo["status"]) == "1"): ?>icon02<?php endif; ?>">
                </span><?php endif; ?>
            <!-- 成交图标 -->
            <?php if(($bav["abc"]) == "2"): ?><span class="icons icon05"></span><?php endif; ?>
            <!-- 预告图标 -->
            <?php if(($bav["abc"]) == "1"): ?><span class="icons icon04"></span><?php endif; ?>
            <!-- 拍卖会图标 -->
            <?php if(in_array(($avo["pattern"]), explode(',',"3,4"))): ?><span class="icons icon03"></span><?php endif; ?>
            <!-- 专场图标 -->
            <?php if(in_array(($avo["pattern"]), explode(',',"1,2"))): ?><span class="icons icon06"></span><?php endif; ?>
            <span class="icon-jp">
                <?php if(($avo["type"]) == "0"): ?>竞拍<?php endif; ?>
                <?php if(($avo["type"]) == "1"): ?>竞标<?php endif; ?>
            </span>
         </a>
    </li>
    <li class="txt03"><a title="<?php echo ($avo["pname"]); ?>  [编号：<?php echo ($avo["bidnb"]); ?>]" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>"><?php echo ($avo["pname"]); ?></a></li>
    <li class="txt04 clearfix">
        <span class="txt04left">
            <?php if(($bav["abc"]) == "1"): ?><font >¥<strong><?php echo (wipezero($avo["onset"])); ?></strong><span>元</span></font> 起拍<br/><?php endif; ?>
            <?php if(($bav["abc"]) == "0"): if(($avo["type"]) == "1"): ?><!-- 竞标显示起拍价 -->
                    <font >¥<strong><?php echo (wipezero($avo["onset"])); ?></strong><span>元</span></font> 起拍<br/>
                <?php else: ?>
                    <!-- 竞拍显示当前价 -->
                    <font >¥<strong><?php echo (wipezero($avo["nowprice"])); ?></strong><span>元</span></font> 当前价<br/><?php endif; endif; ?>
            <?php if(($bav["abc"]) == "2"): ?><font >¥<strong><?php echo (wipezero($avo["nowprice"])); ?></strong><span>元</span></font>
                <?php if(($avo["endstatus"]) == "1"): ?>成交<?php endif; ?>
                <?php if(in_array(($avo["endstatus"]), explode(',',"2,3"))): ?>流拍<?php endif; ?>
                <?php if(($avo["endstatus"]) == "4"): ?>撤拍<?php endif; endif; ?>
            
        </span>
    </li>
    <li class="txt05">
        <?php if(in_array(($bav["abc"]), explode(',',"0,1"))): ?>保证金：
            <span class="p_col">
                <?php echo pledgeShow($avo['pattern'],$avo['pledge_type'],$avo['onset'],$avo['pledge'],$avo['spledge'],$avo['mpledge']);?>
            </span>
            <br><?php endif; ?>
        <?php if(($bav["abc"]) == "1"): ?>开始时间：<?php echo (date('m-d H:i',$avo["starttime"])); endif; ?>
        <?php if(($bav["abc"]) == "0"): ?>结束时间：<?php echo (date('m-d H:i',$avo["endtime"])); endif; ?>
        <?php if(($bav["abc"]) == "2"): ?>起拍价：<?php echo (wipezero($avo["onset"])); ?>元<br/>
            成交时间：<?php echo (date('m-d H:i',$avo["endtime"])); endif; ?>
        <br/>
        <span class="ac-show-userbox" cardtips="0" uid="<?php echo ($avo["sellerid"]); ?>" pid="<?php echo ($avo["pid"]); ?>" seller="1">
            <span class="userrole">送拍：</span>
            <a target="_blank" class="ac-show-usercard" href="<?php echo U('Seller/index',array('sellerid'=>$avo['sellerid']));?>"><?php echo ($avo["organization"]); ?></a>
        </span>
    </li>
    <?php if(in_array(($bav["abc"]), explode(',',"0,1"))): if(checkAtt('p-u',$avo['pid'],$uid)): ?><a pid="<?php echo ($avo["pid"]); ?>" rela="p-u" yn="y" href="javascript:void(0)" class="focus on att">已关注</a>
        <?php else: ?>
        <a pid="<?php echo ($avo["pid"]); ?>" rela="p-u" yn="n" href="javascript:void(0)" class="focus att">关注</a><?php endif; endif; ?>
    <?php if(($bav["abc"]) == "1"): ?><a class="countshow" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <span class="side-num"><?php echo ($avo["clcount"]); ?></span>
            <span class="side-text">人想拍</span>
        </a><?php endif; ?>
    <?php if(in_array(($bav["abc"]), explode(',',"0,2"))): ?><a class="countshow" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <span class="side-num"><?php echo ($avo["bidcount"]); ?></span>
            <span class="side-text">次出价</span>
        </a><?php endif; ?>
    <?php if(in_array((CONTROLLER_NAME), explode(',',"Special,Meeting"))): if(in_array(($avo["endstatus"]), explode(',',"1,2,3,4"))): ?><div style="right:75px;" class="speend_bg"></div><?php endif; endif; ?>
    <?php if(in_array((CONTROLLER_NAME), explode(',',"Meeting"))): ?><div class="msort"><?php echo ($avo["msort"]); ?>号</div><?php endif; ?>
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </div><?php endforeach; endif; ?>
        </div>
    </div>
</div><?php endforeach; endif; ?>
        <!-- 首页频道循环输出——end -->
        <!-- 首页最近成交 -->
        <div class="paimai clearfix">
            <div class="boxtit mb10">
                <h2>最近成交</h2>
                <p>
                    <span class="boxtitblack"><a href="<?php echo U('Auction/allend',array('type'=>0));?>" target="_blank">竞拍</a></span>
                    <span>&nbsp;规定时间，多次出价，价高者得。</span>
                    <span class="boxtitblack"><a href="<?php echo U('Auction/allend',array('type'=>1));?>" target="_blank">竞标</a></span> 
                    <span>&nbsp;规定时间，一次出价，价高者得。</span> 
                </p>
                <a target="_blank" href="<?php echo U('Auction/allend');?>">更多成交</a>
            </div>
            <div class="pmboxcenter">
                <div class="clearfix">
                    <?php if(is_array($endlist)): foreach($endlist as $key=>$bav): ?><!-- 全部未开拍 -->
                        <div id="elistA" class="auctionbox tab_con clearfix" style="display:block;">
                            <?php if(empty($bav["elistA"])): ?><div class="datanone">很抱歉该条件下暂无拍品，您可以重新查询！</div>
                            <?php else: ?>
                                <?php if(is_array($bav["elistA"])): $i = 0; $__LIST__ = $bav["elistA"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
    <li class="txt01" gid="<?php echo ($avo["gid"]); ?>">
        <a href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <img width="259" title="<?php echo ($avo["pname"]); ?>  [编号：<?php echo ($avo["bidnb"]); ?>]" height="194" src="<?php echo ($upWholeUrl); echo (getpicurl($avo["pictures"],2,0)); ?>" alt="<?php echo ($avo["pname"]); ?>"></img>
            <!-- 正在拍图标 -->
            <?php if(($bav["abc"]) == "0"): ?><span class="icons <?php if(($avo["status"]) == "0"): ?>icon01<?php endif; ?> <?php if(($avo["status"]) == "1"): ?>icon02<?php endif; ?>">
                </span><?php endif; ?>
            <!-- 成交图标 -->
            <?php if(($bav["abc"]) == "2"): ?><span class="icons icon05"></span><?php endif; ?>
            <!-- 预告图标 -->
            <?php if(($bav["abc"]) == "1"): ?><span class="icons icon04"></span><?php endif; ?>
            <!-- 拍卖会图标 -->
            <?php if(in_array(($avo["pattern"]), explode(',',"3,4"))): ?><span class="icons icon03"></span><?php endif; ?>
            <!-- 专场图标 -->
            <?php if(in_array(($avo["pattern"]), explode(',',"1,2"))): ?><span class="icons icon06"></span><?php endif; ?>
            <span class="icon-jp">
                <?php if(($avo["type"]) == "0"): ?>竞拍<?php endif; ?>
                <?php if(($avo["type"]) == "1"): ?>竞标<?php endif; ?>
            </span>
         </a>
    </li>
    <li class="txt03"><a title="<?php echo ($avo["pname"]); ?>  [编号：<?php echo ($avo["bidnb"]); ?>]" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>"><?php echo ($avo["pname"]); ?></a></li>
    <li class="txt04 clearfix">
        <span class="txt04left">
            <?php if(($bav["abc"]) == "1"): ?><font >¥<strong><?php echo (wipezero($avo["onset"])); ?></strong><span>元</span></font> 起拍<br/><?php endif; ?>
            <?php if(($bav["abc"]) == "0"): if(($avo["type"]) == "1"): ?><!-- 竞标显示起拍价 -->
                    <font >¥<strong><?php echo (wipezero($avo["onset"])); ?></strong><span>元</span></font> 起拍<br/>
                <?php else: ?>
                    <!-- 竞拍显示当前价 -->
                    <font >¥<strong><?php echo (wipezero($avo["nowprice"])); ?></strong><span>元</span></font> 当前价<br/><?php endif; endif; ?>
            <?php if(($bav["abc"]) == "2"): ?><font >¥<strong><?php echo (wipezero($avo["nowprice"])); ?></strong><span>元</span></font>
                <?php if(($avo["endstatus"]) == "1"): ?>成交<?php endif; ?>
                <?php if(in_array(($avo["endstatus"]), explode(',',"2,3"))): ?>流拍<?php endif; ?>
                <?php if(($avo["endstatus"]) == "4"): ?>撤拍<?php endif; endif; ?>
            
        </span>
    </li>
    <li class="txt05">
        <?php if(in_array(($bav["abc"]), explode(',',"0,1"))): ?>保证金：
            <span class="p_col">
                <?php echo pledgeShow($avo['pattern'],$avo['pledge_type'],$avo['onset'],$avo['pledge'],$avo['spledge'],$avo['mpledge']);?>
            </span>
            <br><?php endif; ?>
        <?php if(($bav["abc"]) == "1"): ?>开始时间：<?php echo (date('m-d H:i',$avo["starttime"])); endif; ?>
        <?php if(($bav["abc"]) == "0"): ?>结束时间：<?php echo (date('m-d H:i',$avo["endtime"])); endif; ?>
        <?php if(($bav["abc"]) == "2"): ?>起拍价：<?php echo (wipezero($avo["onset"])); ?>元<br/>
            成交时间：<?php echo (date('m-d H:i',$avo["endtime"])); endif; ?>
        <br/>
        <span class="ac-show-userbox" cardtips="0" uid="<?php echo ($avo["sellerid"]); ?>" pid="<?php echo ($avo["pid"]); ?>" seller="1">
            <span class="userrole">送拍：</span>
            <a target="_blank" class="ac-show-usercard" href="<?php echo U('Seller/index',array('sellerid'=>$avo['sellerid']));?>"><?php echo ($avo["organization"]); ?></a>
        </span>
    </li>
    <?php if(in_array(($bav["abc"]), explode(',',"0,1"))): if(checkAtt('p-u',$avo['pid'],$uid)): ?><a pid="<?php echo ($avo["pid"]); ?>" rela="p-u" yn="y" href="javascript:void(0)" class="focus on att">已关注</a>
        <?php else: ?>
        <a pid="<?php echo ($avo["pid"]); ?>" rela="p-u" yn="n" href="javascript:void(0)" class="focus att">关注</a><?php endif; endif; ?>
    <?php if(($bav["abc"]) == "1"): ?><a class="countshow" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <span class="side-num"><?php echo ($avo["clcount"]); ?></span>
            <span class="side-text">人想拍</span>
        </a><?php endif; ?>
    <?php if(in_array(($bav["abc"]), explode(',',"0,2"))): ?><a class="countshow" href="<?php if($avo['mid'] == 0): echo U('Auction/details',array('pid'=>$avo['pid'])); else: echo U('Auction/details',array('mid'=>$avo['mid'],'pid'=>$avo['pid'])); endif; ?>">
            <span class="side-num"><?php echo ($avo["bidcount"]); ?></span>
            <span class="side-text">次出价</span>
        </a><?php endif; ?>
    <?php if(in_array((CONTROLLER_NAME), explode(',',"Special,Meeting"))): if(in_array(($avo["endstatus"]), explode(',',"1,2,3,4"))): ?><div style="right:75px;" class="speend_bg"></div><?php endif; endif; ?>
    <?php if(in_array((CONTROLLER_NAME), explode(',',"Meeting"))): ?><div class="msort"><?php echo ($avo["msort"]); ?>号</div><?php endif; ?>
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </div><?php endforeach; endif; ?>
                </div>
            </div>
        </div>
        <!-- 首页最近成交——end -->
    <div class="paimai hezuo clearfix">
        <div class="boxtit">
            <h2>合作伙伴</h2>
        </div>
        <div class="hezuobox">
            <ul class="piclink clearfix">
                <?php if(is_array($linkA)): foreach($linkA as $key=>$vo): ?><li>
                        <a target="_blank" href="<?php echo ($vo["url"]); ?>">
                            <img title="<?php echo ($vo["name"]); ?>" width="128" height="48" src="<?php echo ($upWholeUrl); echo ($vo["ico"]); ?>"/>
                        </a>
                    </li><?php endforeach; endif; ?>
            </ul>
            <ul class="txtlink clearfix">
                <?php if(is_array($linkB)): foreach($linkB as $key=>$vo): ?><li><a href="<?php echo ($vo["url"]); ?>" target="_blank"><?php echo ($vo["name"]); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
    
</div>
<!---底部开始-->
<div class="main_a8 help_wide clearfix">
	<div class="help_wide_box">
	    <div class="main_a8_main clearfix">
	        <?php echo W('Oncoo/helpList',array(1,4,10));?>
	    </div>
	    <div class="help_right">
	    	<?php echo showAdvPosition('common_help_right','div','false');?> 
	    </div>
    </div>
</div>




<div class="main_a9">
    <ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a" target="_self" href="">合作媒体</a></li><li class="one_li"> <a class="one_a" target="" href="">隐私保护</a></li><li class="one_li cor_ff"> <a class="one_a" target="" href="">版权声明</a></li><li class="one_li"> <a class="one_a" target="" href="">诚聘英才</a></li><li class="one_li cor_ff"> <a class="one_a" target="_self" href="baidu.com">一口价</a></li></ul>
    <div>
    <?php if(!empty($site['SITE_INFO']['tel'])): ?>客服电话：<?php echo ($site["SITE_INFO"]["tel"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <?php if(!empty($site['SITE_INFO']['service'])): ?>客服邮箱：<?php echo ($site["SITE_INFO"]["service"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <?php if(!empty($site['SITE_INFO']['address'])): ?>地址：<?php echo ($site["SITE_INFO"]["address"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <br/>
    <?php echo ($site["SITE_INFO"]["name"]); ?>—<?php echo ($site["SITE_INFO"]["summary"]); ?>&nbsp;&nbsp;
    <?php echo ($site["SITE_INFO"]["name"]); ?>_<?php echo ($site["SITE_INFO"]["version"]); ?>&nbsp;&nbsp;
    <?php echo ($site["SITE_INFO"]["icp"]); ?>
    </div>
</div>
<!-- 底部浮动广告 -->
<a class="reg" id="reg" href="<?php echo U('Login/register');?>" target="_blank">
    <img src="/Public/Home/Img/regift.gif" width="43" height="43"/>
</a>
<!-- 底部浮动广告——结束 -->
<div class="linktips" id="linktips" >
    <ul>
        <li class="tipstit"></li>
        <?php if(!empty($site["SITE_INFO"]["tweibo"])): ?><li class="tipsweibo"><a href="<?php echo ($site["SITE_INFO"]["tweibo"]); ?>" target="_blank">关注微博</a></li><?php endif; ?>
        <li class="tipsweixin">
            <p>微信扫二维码</p>
            <div class="ad"><?php echo showAdvPosition('weixin','span','false');?> </div>
        </li>
        <li id="returnTop" class="tiptop"></li>
        <li class="tipbot"></li>
    </ul>
</div>


</body>
</html>