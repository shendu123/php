<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
		<meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title><?php echo ($channelName); ?>在拍商品-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
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
		<script type="text/javascript" src="/Public/Home/Js/bid_list.js"></script>
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

    <div  class="container auction_list">
    <?php echo W('Oncoo/catelist',array($gt[0]));?>
<!-- 今日拍卖【 -->
<div class="bla">
    <div class="brand">
        <ul class="clearfix">
            <li class="brtit_today">
                <?php if((ACTION_NAME) == "index"): ?>在拍分类<?php endif; ?>
                <?php if((ACTION_NAME) == "waitbid"): ?>待拍分类<?php endif; ?>
                <?php if((ACTION_NAME) == "endbid"): ?>成交分类<?php endif; ?>
            </li>
            <li class="brmore">更多<?php if((ACTION_NAME) == "index"): ?>在拍<?php endif; if((ACTION_NAME) == "waitbid"): ?>待拍<?php endif; if((ACTION_NAME) == "endbid"): ?>成交<?php endif; ?></li>
            <?php if(empty($clist)): ?><li style="text-align: center; line-height: 56px;">无</li>
                <?php else: ?>
                    <?php if(is_array($clist)): $i = 0; $__LIST__ = $clist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cvo): $mod = ($i % 2 );++$i;?><li class="">
                            <a <?php if(($cvo["cid"]) == $gt["0"]): ?>class="brandcur"<?php endif; ?> title="" target="_self" href="<?php echo U('',array('gt'=>$cvo['gt']));?>">
                                <?php if(!empty($cvo["ico"])): ?><span class="m_9_b">
                                        <img src="<?php echo ($upWholeUrl); echo ($cvo["ico"]); ?>">
                                    </span><?php endif; ?>
                                <font><?php echo ($cvo["name"]); ?></font>
                            </a>
                        </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            
        </ul>
    </div>
</div>
<!-- 今日拍卖】 -->
    <?php if(!empty($filt_html)): ?><div class="clearfix list_fielt_box">
        <div id="fielt_box"><?php echo ($filt_html); ?></div>
        <div class="notice">
            <ul>
                <li class="bot_border n1"><a target="_blank" href="<?php echo U('Article/help',array('id'=>1));?>">拍卖须知></a></li>
                <li class="n2"><a target="_blank" href="<?php echo U('Member/payment');?>">充值保证金></a></li>
            </ul>
        </div>
    </div><?php endif; ?>
    <div class="selection">
        <div id="contit" class="contitle">
            <a <?php if((ACTION_NAME == 'index')and($gt[6] == 'a')): ?>class="on"<?php endif; ?> href="<?php echo U('Auction/index',array('gt'=>$gt0));?>">全部在拍</a>  
            <a <?php if((ACTION_NAME == 'index')and($gt[6] == 'n')): ?>class="on"<?php endif; ?>  href="<?php echo ($ynUrl["n"]); ?>">未出价</a>
            <a <?php if((ACTION_NAME == 'index')and($gt[6] == 'y')): ?>class="on"<?php endif; ?>  href="<?php echo ($ynUrl["y"]); ?>">已出价</a>
            <a <?php if((ACTION_NAME == 'waitbid')): ?>class="on"<?php endif; ?> href="<?php echo U('Auction/waitbid',array('gt'=>$gt0));?>">即将开拍</a>
            <a <?php if((ACTION_NAME == 'endbid')): ?>class="on"<?php endif; ?> href="<?php echo U('Auction/endbid',array('gt'=>$gt0));?>">已成交</a> 
        </div>
        <div class="jiesao">
            <strong><a <?php if(($gt[5]) == "0"): ?>class="on"<?php endif; ?> href="<?php echo ($typeUrl["pai"]); ?>">竞拍</a>：</strong>  规定时间，多次出价，价高者得。 
            <strong><a <?php if(($gt[5]) == "1"): ?>class="on"<?php endif; ?>  href="<?php echo ($typeUrl["biao"]); ?>">竞标</a>：</strong>  规定时间，一次出价，价高者得。 
        </div>
     </div>
     <div class="auction">
        <div class="auctionhead clearfix">
            <div class="acactop">
                <h2 class="autit"><a href="">正在拍卖</a></h2>
                <!-- 时间段条件和统计循环输出 -->
                <ul class="autittxt">
                    <?php if(is_array($end_section)): foreach($end_section as $key=>$svo): ?><li>
                        <a <?php if(($svo['key']) == $gt["2"]): ?>class="on"<?php endif; ?> href="<?php echo ($svo["href"]); ?>"><?php echo ($svo["name"]); ?>（<span><?php echo ($svo["count"]); ?></span>个）
                        </a>
                    </li><?php endforeach; endif; ?>
                </ul>
                <!-- 时间段条件和统计循环输出_end -->
            </div>
            <!-- 地区循环输出 -->
            <?php if($region): ?><ul class="list_region clearfix">
                <?php if(is_array($region)): foreach($region as $key=>$rvo): ?><li class="region_p">
                        <a class="p_s <?php if(($rvo['mark']) == $reg_gt["0"]): ?>on<?php endif; ?>"  rid="<?php echo ($rvo["mark"]); ?>" href="<?php echo ($rvo["href"]); ?>"><?php echo ($rvo["name"]); ?>(<span><?php echo ($rvo["count"]); ?></span>个)</a>
                        <ul class="p_c">
                            <?php if(is_array($rvo['city'])): foreach($rvo['city'] as $key=>$cvo): ?><li>
                                <a rid="<?php echo ($cvo["mark"]); ?>" class="<?php if(($cvo['mark']) == $reg_gt["1"]): ?>on<?php endif; ?>" href="<?php echo ($cvo["href"]); ?>"><?php echo ($cvo["name"]); ?>(<span><?php echo ($cvo["count"]); ?></span>个)</a>
                                <ul class="p_a">
                                    <?php if(is_array($cvo['area'])): foreach($cvo['area'] as $key=>$avo): ?><li>
                                        <a rid="<?php echo ($avo["mark"]); ?>" class="<?php if(($avo['mark']) == $reg_gt["2"]): ?>on<?php endif; ?>" href="<?php echo ($avo["href"]); ?>"><?php echo ($avo["name"]); ?>(<span><?php echo ($avo["count"]); ?></span>个)</a>
                                    </li><?php endforeach; endif; ?>
                                </ul>
                            </li><?php endforeach; endif; ?>
                        </ul>
                    </li><?php endforeach; endif; ?>
            </ul><?php endif; ?>
        </div>
        <!-- 地区循环输出——end -->
        <!-- 正在拍卖上方广告 -->
        <div class="ad_list_a">
            <?php echo showAdvPosition('auction_list_a','span','false');?> 
        </div>
        <!-- 正在拍卖上方广告——end -->
        <!-- 正在拍卖 -->
        <div class="auctionbox clearfix">
            <?php if(is_array($bidArr)): foreach($bidArr as $key=>$bav): if(empty($bav["bid_list"])): ?><div class="datanone">很抱歉该条件下暂无拍品，您可以重新查询！</div> 
                <?php else: ?>
                    <?php if(is_array($bav["bid_list"])): $i = 0; $__LIST__ = $bav["bid_list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; endif; endforeach; endif; ?>
        </div>
        <!-- 正在拍卖——end -->
        <!--分页开始-->
        <div class="mod_page clearfix">
            <div class="bid_list_page">
            <?php echo ($page); ?>
            </div>
            <div class="fr">
                <span class='mod_page_lk'>每页显示</span>
                <!-- 设置每页显示数循环 -->
                <?php if(is_array($set_page)): foreach($set_page as $key=>$svo): if($svo['key'] == $gt[1]): ?><span class='mod_page_on'><?php echo ($svo["sz"]); ?></span>
                    <?php else: ?>
                        <a class='mod_page_lk' href='<?php echo ($svo["href"]); ?>'><?php echo ($svo["sz"]); ?></a><?php endif; endforeach; endif; ?>
                <!-- 设置每页显示数循环_end -->
                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            </div>
            
        </div>
        <!--------分页结束-------->
                    
        </div>
        <!-- 正在拍卖中部广告 -->
        <div class="ad_list_a">
            <?php echo showAdvPosition('auction_list_b','span','false');?> 
        </div>
        <!-- 正在拍卖中部广告——end -->
    
  <!-- 拍卖预告   -->
     <div class="yugao">
         <div class="auctionhead clearfix">
                <div class="acactop" >
                    <h2 class="autit"><a href="<?php echo U('Auction/waitbid',array('gt'=>$gt0));?>">拍卖预告</a></h2>
                    <ul class="tab_menu" id="yugaolist">                         
                        <li class="on" style="display: block;"><a href="#slistA">全部</a></li>
                        <?php if(is_array($slist)): foreach($slist as $key=>$bav): if(!empty($bav["slistJ"])): ?><li><a href="#slistJ">即将开拍</a></li><?php endif; ?>
                        <?php if(!empty($bav["slistM"])): ?><li><a href="#slistM">明天开拍</a></li><?php endif; ?>
                        <?php if(!empty($bav["slistH"])): ?><li><a href="#slistH">后天开拍</a></li><?php endif; ?>
                        <?php if(!empty($bav["slistQ"])): ?><li><a href="#slistQ">其他开拍</a></li><?php endif; endforeach; endif; ?>
                    </ul>
                    <a id="yugaolink" href="<?php echo U('Auction/waitbid',array('gt'=>$gt0));?>" target="_blank" class="showmore">查看更多</a>
                </div>
         </div>
         <?php if(is_array($slist)): foreach($slist as $key=>$bav): ?><!-- 全部未开拍 -->
            <div id="slistA" class="auctionbox tab_con clearfix" style="display:block;">
                <?php if(empty($bav["slistA"])): ?><div class="datanone">很抱歉该条件下暂无拍品，您可以重新查询！</div>
                <?php else: ?>
                    <?php if(is_array($bav["slistA"])): $i = 0; $__LIST__ = $bav["slistA"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
            </div>
            <!-- 全部未开拍_end -->
            <!-- 即将开拍 -->
            <?php if(!empty($bav["slistJ"])): ?><div id="slistJ" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["slistJ"])): $i = 0; $__LIST__ = $bav["slistJ"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 即将开拍_end -->
            <!-- 明天开拍 -->
            <?php if(!empty($bav["slistM"])): ?><div id="slistM" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["slistM"])): $i = 0; $__LIST__ = $bav["slistM"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 明天开拍_end -->
            <!-- 后天开拍 -->
            <?php if(!empty($bav["slistH"])): ?><div id="slistH" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["slistH"])): $i = 0; $__LIST__ = $bav["slistH"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 后天开拍_end -->
            <!-- 其他开拍 -->
            <?php if(!empty($bav["slistQ"])): ?><div id="slistQ" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["slistQ"])): $i = 0; $__LIST__ = $bav["slistQ"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 其他开拍_end --><?php endforeach; endif; ?>
    </div>
    <!-- 正在拍卖下方广告 -->
    <div class="ad_list_a">
        <?php echo showAdvPosition('auction_list_c','span','false');?> 
    </div>
    <!-- 正在拍卖下方广告——end -->
    
    <!-- 最新成交   -->
     <div class="deal clearfix">
        <div class="auctionhead clearfix">
                <div class="acactop">
                    <h2 class="autit"><a href="<?php echo U('Auction/endbid',array('gt'=>$gt0));?>">最新成交</a></h2>
                    <ul class="tab_menu" id="deallist">                         
                        <li class="on" style="display: block;"><a href="#elistA">全部</a></li>
                        <?php if(is_array($elist)): foreach($elist as $key=>$bav): if(!empty($bav["elistJ"])): ?><li><a href="#elistJ">今天成交</a></li><?php endif; ?>
                        <?php if(!empty($bav["elistZ"])): ?><li><a href="#elistZ">昨天成交</a></li><?php endif; ?>
                        <?php if(!empty($bav["elistQ"])): ?><li><a href="#elistQ">前天成交</a></li><?php endif; endforeach; endif; ?>
                    </ul>
                    <a id="deallink" href="<?php echo U('Auction/endbid',array('gt'=>$gt0));?>" target="_blank" class="showmore">查看更多</a>
                </div>
         </div>
         <?php if(is_array($elist)): foreach($elist as $key=>$bav): ?><!-- 全部已结束 -->
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
            </div>
            <!-- 全部已结束_end -->
            <!-- 今天结束 -->
            <?php if(!empty($bav["elistJ"])): ?><div id="elistJ" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["elistJ"])): $i = 0; $__LIST__ = $bav["elistJ"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 今天结束_end -->
            <!-- 昨天结束 -->
            <?php if(!empty($bav["elistZ"])): ?><div id="elistZ" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["elistZ"])): $i = 0; $__LIST__ = $bav["elistZ"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 昨天结束_end -->
            <!-- 前天结束 -->
            <?php if(!empty($bav["elistQ"])): ?><div id="elistQ" class="auctionbox tab_con clearfix">
                    <?php if(is_array($bav["elistQ"])): $i = 0; $__LIST__ = $bav["elistQ"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$avo): $mod = ($i % 2 );++$i;?><ul class="bidbox <?php if(($bav["abc"]) == "0"): ?>biding<?php endif; if(($bav["abc"]) == "1"): ?>future<?php endif; if(($bav["abc"]) == "2"): ?>bidend<?php endif; ?>">
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
    
    
    
</ul><?php endforeach; endif; else: echo "" ;endif; ?>
                </div><?php endif; ?>
            <!-- 前天结束_end --><?php endforeach; endif; ?>
    </div>
    <!-- 广告列表 -->
    <div class="data clearfix">
    <ul>
    <?php echo showAdvPosition('auction_list_d','li','false');?> 
    </ul>
</div>
    <!-- 广告列表 -->
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