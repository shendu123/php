<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($info["keywords"]); ?>" />
		<meta name="description" content="<?php echo ($info["description"]); ?>" />
        <title><?php echo ($info["pname"]); ?>-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
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
		<link rel="stylesheet" type="text/css" href="/Public/Home/Css/picshow.css" />
		<script type="text/javascript" src="/Public/WebSocketMain/js/swfobject.js"></script>
		<script type="text/javascript" src="/Public/WebSocketMain/js/web_socket.js"></script>
        <script type="text/javascript" src="/Public/Js/jquery_raty/jquery.raty.min.js"></script>
		<script type="text/javascript" src="/Public/Home/Js/bid_details.js"></script>
        <script type="text/javascript" src="/Public/Home/Js/picshow.js"></script>
        <!-- 图片查看器【 -->
        <link rel="stylesheet" type="text/css" href="/Public/Js/viewer/viewer.min.css" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="/Public/Js/viewer/html5shiv.min.js"></script>
        <script src="/Public/Js/viewer/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="/Public/Js/viewer/viewer.min.js"></script>
        <script type="text/javascript" src="/Public/Js/viewer/main.js"></script>
        
        <!-- 图片查看器】 -->
    </head>
    <body onload="connect();">
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
        <div class="clearfix">
            <div class="main_b3_top">
                <a href="">首页</a>&nbsp;&gt;&gt;&nbsp;
                <?php if(is_array($chalist)): foreach($chalist as $key=>$clv): ?><a href="<?php echo U('Auction/index',array('gt'=>$clv['cid']));?>"><?php echo ($clv["name"]); ?></a>
                    &nbsp;&gt;&gt;&nbsp;<?php endforeach; endif; ?>
                <?php if(($info["type"]) == "0"): ?>竞拍<?php endif; if(($info["type"]) == "1"): ?>竞标<?php endif; ?>详细
                <?php if(($info["sid"]) != "0"): ?><a class="fr f14 red1" href="<?php echo U('Special/speul',array('sid'=>$info['sid']));?>">进入该拍品专场&nbsp;&gt;</a><?php endif; ?>
                <?php if(($info["mid"]) != "0"): ?><span class="fr f14 red1">
                        <?php if(($mtdata["nexbid"]) != ""): ?>下一件<strong class="pd05"><?php echo ($mtdata["nexbid"]["msort"]); ?></strong>号拍品：<a href="<?php echo U('Auction/details',array('mid'=>$info['mid'],'pid'=>$mtdata['nexbid']['pid']));?>"><?php echo ($mtdata["nexbid"]["pname"]); ?>&nbsp;&gt;</a>
                        <?php else: ?>
                        这已是拍卖会最后一件拍品<?php endif; ?>
                    </span><?php endif; ?>
            </div>
            <div class="main_b3_1 fl">
                <?php if(($info["type"]) == "0"): ?><div class="mtype0">竞拍</div><?php endif; ?>
                <?php if(($info["type"]) == "1"): ?><div class="mtype1">竞标</div><?php endif; ?>

                <!-- 正在拍图标 -->
                <?php if(($info["nstatus"]) == "ing"): ?><span class="icons <?php if(($info["status"]) == "0"): ?>icon01<?php endif; ?> <?php if(($info["status"]) == "1"): ?>icon02<?php endif; ?>">
                    </span><?php endif; ?>
                <!-- 成交图标 -->
                <?php if(($info["nstatus"]) == "end"): ?><span class="icons icon05"></span><?php endif; ?>
                <!-- 预告图标 -->
                <?php if(($info["nstatus"]) == "fut"): ?><span class="icons icon04"></span><?php endif; ?>
                <!-- 拍卖会图标 -->
                <?php if(in_array(($info["pattern"]), explode(',',"3,4"))): ?><a title="<?php echo ($info["msort"]); ?>号拍品" href="<?php echo U('Meeting/meetul',array('mid'=>$info['mid']));?>">
                        <span class="icons icon03"></span>
                    </a><?php endif; ?>
                <!-- 专场图标 -->
                <?php if(in_array(($info["pattern"]), explode(',',"1,2"))): ?><span class="icons icon06"></span><?php endif; ?>

                <div class="bid_bh">【拍品编号：<?php echo ($info["bidnb"]); ?>】</div>
                <div id="picShow">
                    <ul class="image docs-pictures" id="bigpics" title="">
                        <?php if(!empty($info['pictures'])): if(is_array($info['pictures'])): foreach($info['pictures'] as $key=>$pv): ?><li <?php if(($key) == "0"): ?>style="display: block;"<?php endif; ?>> 
                                    <a href="javascript:void(0);"><img alt="<?php echo ($info["pname"]); ?>" data-original="<?php echo ($upWholeUrl); echo (picrep($pv)); ?>" src="<?php echo ($upWholeUrl); echo (picrep($pv,1)); ?>"/></a>
                                </li><?php endforeach; endif; endif; ?>
                    </ul>
                    <div class="switch">
                        <div class="icon1"><a class="prev_img" href="javascript:void(0);" title="上一个"></a></div>
                        <div class="switch_center" id="pics">
                            <ul>
                                <?php if(!empty($info['pictures'])): if(is_array($info['pictures'])): foreach($info['pictures'] as $key=>$pv): ?><li class="photo">
                                            <a href="javascript:void(0);"><img width="83px" height="62px" alt="<?php echo ($info["pname"]); ?>" data-original="<?php echo ($upWholeUrl); echo (picrep($pv)); ?>" lksrc="<?php echo ($upWholeUrl); echo (picrep($pv,1)); ?>" src="<?php echo ($upWholeUrl); echo (picrep($pv,3)); ?>"/></a>
                                        </li><?php endforeach; endif; endif; ?>
                            </ul>
                      </div>
                        <div class="icon2"><a class="next_img" href="javascript:void(0);" title="下一个" onfocus="this.blur();"></a></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            <div class="main_b3_2 fl">
                <div class="showtimebox clearfix">
                    <div class="hleft">
                        <h1><?php echo ($info["pname"]); ?></h1>
                        <div class="onBidTbox">
                            <?php if($info["nstatus"] == 'end'): ?><ul>
                                    <li class="clearfix">开始于：<?php echo (date('Y-m-d H:i',$info["starttime"])); ?></li>
                                    <li class="clearfix">结束于：<?php echo (date('Y-m-d H:i',$info["endtime"])); ?></li>
                                </ul>
                            <?php elseif($info["nstatus"] == 'fut'): ?>
                                <div class="noStartBidTbox clearfix">
                                    <div class="th" id="bidTimeStatus">未开始<span class="zt">距开始</span></div>
                                    <div class="noStartTime" id="noStartTime">
                                        <span class="day">-</span>
                                        <span class="dw">天</span>
                                        <span class="hour">-</span>
                                        <span class="dw">时</span>
                                        <span class="minute">-</span>
                                        <span class="dw">分</span>
                                        <span class="second">-</span>
                                        <span class="dw">秒</span>
                                        <span class="msec">-</span>
                                    </div>
                                    <script type="text/javascript">
                                        $(function(){
                                            startDown("<?php echo ($info["starttime"]); ?>","<?php echo ($nowtime); ?>",".noStartTime",".noStartTime .day",".noStartTime .hour",".noStartTime .minute",".noStartTime .second",".noStartTime .msec");
                                        });
                                    </script>
                                </div>
                            <?php else: ?>
                                <div class="onBidTbox clearfix">
                                    <div class="th" id="bidTimeStatus">正在拍卖<span class="zt">距结束</span></div>
                                    <div class="onBidtime" id="onBidtime">
                                        <span class="day">-</span>
                                        <span class="dw">天</span>
                                        <span class="hour">-</span>
                                        <span class="dw">时</span>
                                        <span class="minute">-</span>
                                        <span class="dw">分</span>
                                        <span class="second">-</span>
                                        <span class="dw">秒</span>
                                        <span class="msec">-</span>
                                    </div>
                                    <script type="text/javascript">
                                        $(function(){
                                            endDown("<?php echo ($info["endtime"]); ?>","<?php echo ($nowtime); ?>",".onBidtime",".onBidtime .day",".onBidtime .hour",".onBidtime .minute",".onBidtime .second",".onBidtime .msec");
                                        });
                                    </script>
                                </div><?php endif; ?>
                        </div>
                        <!-- 即时成交【 -->
                        <?php if(($info["succtype"]) == "1"): ?><div class="jishi">即时成交：<span><?php echo ($info["succprice"]); ?></span>元</div><?php endif; ?>
                        <!-- 即时成交】 -->
                    </div>
                    <div class="gzbox ac-pointer clearfix">
                        <a class="ac-tx tx"  st="<?php echo ($ustx); ?>"  href="javascript:void(0);" stype="<?php echo ($info["nstatus"]); ?>" <?php if(empty($alerttype)): ?>id="settx"<?php else: ?>id="tx"<?php endif; ?>>
                            <div class="ico"></div>
                            <div class="txt"><?php if(($ustx) == "0"): ?>设置提醒<?php else: ?>已设提醒<?php endif; ?></div>
                        </a>
                        <a id="gz" class="gz" st="<?php echo ($usgz); ?>" href="javascript:void(0);">
                            <div class="ico"></div>
                            <div class="txt"><?php if(($usgz) == "0"): ?>关注拍品<?php else: ?>已关注<?php endif; ?></div>
                        </a>
                    </div>
                </div>
                <div class="defcon">
                    <ul class="bid_info">
                        <li>
                            <div id="nowth" class="th"><?php if(($info["uid"]) == "0"): ?>起拍价：<?php else: ?>当前价：<?php endif; ?></div>
                            <span id="nowprice" class="nowprice">
                                <!-- 竞拍模式 -->
                                <?php if(($info["type"]) == "0"): if($info["uid"] == 0): echo (wipezero($info["onset"])); ?>
                                    <?php else: ?>
                                    <?php echo (wipezero($info["nowprice"])); endif; ?>
                                    <span class="unit">元</span><?php endif; ?>
                                <?php if(($info["type"]) == "1"): ?><span class="unit">竞标保密</span><?php endif; ?>
                            </span>
                            <!-- 竞标模式 -->
                        </li>
                        <li><div class="th">保证金：</div>
                            <span class="onset">
                                <?php echo ($info["pledge"]); ?>
                            </span>
                        </li>
                    </ul>
                    <?php if(($login) == "0"): ?><div id="pm-bid-0" class="pm-bid">
                            <div class="auction_login">
                            <h3>请登录后参与拍卖</h3>
                                <div class="loginarea clearfix">
                                    <a class="thickbox fl" title="请登录" href="<?php echo U('Login/index');?>"><strong>登录</strong></a> 
                                    <a class="pm_btn_5 fl" href="<?php echo U('Login/register');?>"><strong>注册</strong></a>
                                </div>
                                <div class="loginarea_list">
                                    <ul class="clearfix">
                                        <li><a target="_blank" href="<?php echo U('Article/help',array('id'=>1));?>">拍卖须知</a>&#12288;|&#12288;<a target="_blank" href="<?php echo U('Article/help',array('id'=>2));?>">如何竞买</a></li>
                                        <li>客服热线：<?php echo ($site["SITE_INFO"]["tel"]); ?></li>
                                    </ul>
                                </div>
                            </div>
                        </div><?php endif; ?>
                    <!-- 判断登录 -->
                    <?php if(($login) == "1"): ?><!-- 判断竞标模式——end -->
                        <div class="pm-bid">
                            <?php if($info["nstatus"] == 'end'): ?><!-- 已结束拍品 -->
                                <div class="endinfo">
                                    <ul>
                                        <li class="clearfix tit">拍卖已结束</li>
                                        <li class="clearfix">
                                            <div class="th">开始于：</div>
                                            <div class="td"><?php echo (date('Y-m-d H:i',$info["starttime"])); ?></div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="th">结束于：</div>
                                            <div class="td"><?php echo (date('Y-m-d H:i',$info["endtime"])); ?></div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="th">共计出价：</div>
                                            <div class="td"><?php echo ($info["bidcount"]); ?>次</div>
                                        </li>
                                        <li class="clearfix">
                                            <div class="th">结束价：</div>
                                            <div class="td red1 fb"><?php echo ($info["nowprice"]); ?>元</div>
                                        </li>
                                        
                                        <li class="clearfix">
                                            <div class="th">最高出价者：</div>
                                            <div class="td org1 fb">
                                                <?php if(empty($info["nickname"])): ?>无<?php else: echo ($info["nickname"]); endif; ?>
                                            </div>
                                        </li>
                                        <li class="clearfix" style="margin:0px;">
                                            <div class="th">结束类型：</div>
                                            <div class="td fb">
                                                <?php if(($info["endstatus"]) == "1"): ?>成交<?php endif; ?>
                                                <?php if(($info["endstatus"]) == "2"): ?>未达到目标价-流拍<?php endif; ?>
                                                <?php if(($info["endstatus"]) == "3"): ?>无人出价-流拍<?php endif; ?>
                                                <?php if(($info["endstatus"]) == "4"): ?>撤拍<?php endif; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- 已结束拍品——end -->
                            <?php elseif($info["nstatus"] == 'fut'): ?>
                                <!-- 判断权限未开始 -->
                                <?php if($uLimit['yn'] == 1): ?><div class="nostarttip clearfix">
                                        <ul>
                                            <li class="th">拍品还没有开始！</li>
                                            <li class="td">到开始时间该页面会自动刷新！</li>
                                        </ul>
                                    </div>
                                <?php else: ?>
                                    <div class="pm-unlim">
                                        <ul>
                                            <li class="th">
                                            您没有该拍品的出价权限
                                            </li>
                                            <li>您的账户情况如下：</li>
                                            <li>信用额度：<span class="prc"><?php echo (wipezero($uLimit["limsum"])); ?>元</span>可用</li>
                                            <li>保证金：<span class="prc"><?php echo (wipezero($uLimit["pledge"])); ?>元</span>可用</li>
                                            <li>如参与该拍品出价您需要充值保证金<span class="prc"><?php echo (wipezero($uLimit["diff"])); ?>元</span></li>
                                            <li>您可出价：参拍条件小于等于<span class="prc"><?php echo (wipezero($uLimit["count"])); ?>元</span>的拍品</li>
                                            <li class="cz_btn"><a href="<?php echo U('Member/payment');?>"></a></li>
                                        </ul>
                                    </div><?php endif; ?>
                                <!-- 判断权限未开始——end -->
                            <?php else: ?>
                                <!-- 判断权限正在出价 -->
                                <?php if($uLimit['yn'] == 1): if(($info["type"]) == "0"): ?><!-- 判断竞拍模式 出价框 -->
                                        <!-- 手动出价 -->

                                        <div id="manual" <?php if(in_array(($setagency), explode(',',"0,1,2"))): ?>style="display:none;"<?php endif; ?>>
                                            <ul class="pm-price">
                                                <li class="pm-h">竞拍出价</li>
                                                <li class="plus-minus-operation clearfix"  style="padding-left: 13px;">
                                                    <a class="change_step minus_step" act="minus" href="javascript:void(0);">-</a>
                                                    <input type="text"  style="margin: 0px; width:120px;" name="priceFormat" id="bidprice" class="pm-price-input " value="<?php echo (wipezero($info["stepsized"])); ?>">
                                                    <div class="pm-sign">RMB</div>
                                                    <a class="change_step add_step" act="add" href="javascript:void(0);">+</a>
                                                </li>
                                                <li>
                                                    <div class="bid_butbox clearfix">
                                                        <a id="manual_but" class="bid_but fl" href="javascript:void(0);"></a>
                                                        <a id="robot_but" title="代理出价" class="robot_but" href="javascript:void(0);"></a>
                                                    </div>
                                                </li>
                                                <li class="ts">最低出价不能小于<span id="stped"><?php echo (wipezero($info["stepsized"])); ?></span>元</li>
                                                <li class="zy">
                                                    小提示：点击代理出价，切换至代理出价面板。启动后代理出价，一切尽在掌握！
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- 手动出价——end -->
                                        
                                        <!-- 代理出价 -->
                                        <div id="auto" <?php if(($setagency) == "3"): ?>style="display:none;"<?php endif; ?>>
                                            <ul class="pm-price">
                                                <li class="pm-h">代理出价</li>
                                                <li class="plus-minus-operation clearfix">
                                                    <input type="text" name="priceFormat" id="robotprice" class="pm-price-input " value="<?php echo ($myagprice); ?>" <?php if(in_array(($setagency), explode(',',"0,1,2"))): ?>disabled="disabled"<?php endif; ?>>
                                                    <div class="pm-sign">RMB</div>
                                                </li>
                                                <li class="pm-sign-c">
                                                    <button id="isbegin" class="on-webact-auto <?php if(in_array(($setagency), explode(',',"0,1,2"))): ?>stopBtn<?php else: ?>startBtn<?php endif; ?>" type="button">
                                                        <?php if(in_array(($setagency), explode(',',"0,1,2"))): ?>停止<?php else: ?>启动<?php endif; ?>
                                                    </button>
                                                    <a id="manual_tab" href="javascript:void(0);">手动出价</a>
                                                </li>
                                                <li class="ts">请输入最高目标价后，点击启动出价。</li>
                                                <li class="zy">
                                                    注意：当最高报价达到您设置的目标价后，系统将停止代理出价。关闭此页面，不影响代理出价。
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- 代理出价——end -->
                                    <!-- 判断竞拍模式 出价框——end --><?php endif; ?>
                                    <?php if(($info["type"]) == "1"): ?><!-- 判断竞标模式 出价框-->
                                        <!-- 竞标出价 -->
                                        <div id="jingbiao">
                                            <ul class="pm-price">
                                                <li class="pm-h">竞标出价</li>
                                                <li class="plus-minus-operation clearfix" style="padding-left: 13px;">
                                                    <a class="change_step minus_step" act="minus" href="javascript:void(0);">-</a>
                                                    <input style="margin: 0px; width:120px;" type="text" name="priceFormat" id="bidprice" class="pm-price-input " value="<?php echo ($info["onset"]); ?>">
                                                    <div class="pm-sign">RMB</div>
                                                    <a class="change_step add_step" act="add" href="javascript:void(0);">+</a>
                                                </li>
                                                <li>
                                                    <div class="bid_butbox clearfix" style="margin-left: 105px;">
                                                        <a id="manual_but" class="bid_but fl" href="javascript:void(0);"></a>
                                                    </div>
                                                </li>
                                                <li class="ts">出价最低不能小于<?php echo ($info["onset"]); ?></li>
                                                <li class="zy">
                                                    竞标模式只能出价一次!<br>
                                                    出价应为您能接受支付该拍品的最高价！
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- 竞标出价——end -->
                                    <!-- 判断竞标模式 出价框——end--><?php endif; ?>
                                <?php else: ?>
                                    <div class="pm-unlim">
                                        <ul>
                                            <li class="th">您没有该拍品的出价权限</li>
                                            <li>您的账户情况如下：</li>
                                            <li>信用额度：<span class="prc"><?php echo (wipezero($uLimit["limsum"])); ?>元</span>可用</li>
                                            <li>保证金：<span class="prc"><?php echo (wipezero($uLimit["pledge"])); ?>元</span>可用</li>
                                            <li>如参与该拍品出价您需要充值保证金<span class="prc"><?php echo (wipezero($uLimit["diff"])); ?>元</span></li>
                                            <li>您可出价：参拍条件小于等于<span class="prc"><?php echo (wipezero($uLimit["count"])); ?>元</span>的拍品</li>
                                            <li class="cz_btn"><a href="<?php echo U('Member/payment');?>"></a></li>
                                        </ul>
                                    </div><?php endif; ?>
                                <!-- 判断权限正在出价——end --><?php endif; ?>
                        </div><?php endif; ?>
                    <ul class="bid_info3 clearfix">
                        <li><span><?php echo ($dsr); ?></span>人参拍</li>
                        <li class="bdlr"><span><?php echo ($info["clcount"]); ?></span>次围观</li>
                        <li><span><?php echo ($tcount); ?></span>人关注</li>
                    </ul>
                    <ul class="bid_info2 clearfix">
                        <li class="wfix"><div class="th">起拍价：</div><span class="onset"><?php echo (wipezero($info["onset"])); ?><span class="unit">元</span></span></li>
                        <li class="wfix">
                            <div class="th">加价方式：</div>
                            <?php if(($info["stepsize_type"]) == "0"): ?>阶梯<?php endif; ?>
                            <?php if(($info["stepsize_type"]) == "1"): ?>定额<?php endif; ?>
                            <span class="onset"><span id="steps"><?php echo (wipezero($info["stepsize"])); ?></span><span class="unit">元</span></span>
                        </li>
                        <li><div class="th" title="<?php if(($info["steptime"]) != "0"): ?>最后<?php echo ($info["steptime"]); ?>出价延时<?php echo ($info["deferred"]); endif; ?>">时间延时：</div>
                            <?php if(($info["steptime"]) == "0"): ?><span class="fb">不延时</span>
                            <?php else: ?>
                                <?php echo ($info["deferred"]); ?>/次<?php endif; ?>
                        </li>
                        <li class="wfix">
                            <div class="th">运费：</div>

                            <span class="onset"><?php if(($info["freight"]) != "0"): echo ($info["freight"]); ?><span class="unit">元</span><?php else: ?>包邮<?php endif; ?></span>
                        </li>
                    </ul>
<!--                     <div class="extd clearfix"><div class="fl">分享到：</div><div class="bshare-custom"><div class="bsPromo bsPromo2"></div><a title="分享到微信" class="bshare-weixin" href="javascript:void(0);"></a><a title="分享到QQ空间" class="bshare-qzone"></a><a title="分享到QQ好友" class="bshare-qqim" href="javascript:void(0);"></a><a title="分享到腾讯微博" class="bshare-qqmb" href="javascript:void(0);"></a><a title="分享到新浪微博" class="bshare-sinaminiblog"></a><a title="分享到人人网" class="bshare-renren"></a><a title="更多平台" class="bshare-more bshare-more-icon more-style-addthis"></a><span style="float: none;" class="BSHARE_COUNT bshare-share-count">34.1K</span></div><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/buttonLite.js#style=-1&amp;uuid=&amp;pophcol=1&amp;lang=zh"></script><script type="text/javascript" charset="utf-8" src="http://static.bshare.cn/b/bshareC0.js"></script></div> -->
            </div>
            
            <div class="main_b3_3">
                <div class="addico"></div>
                <ul class="ontab tab_menu clearfix">
                    <li class="tab on"><a href="#recordA">出价记录</a></li>
                    <?php if(($login) == "1"): ?><li class="tab"><a href="#recordB">我的出价</a></li><?php endif; ?>
                </ul>
                <div class="ontab_con">
                    <!-- 出价记录 -->
                    <div id="recordA" class="tab_con">
                        <table id="bid_record" class="<?php if(($info["type"]) == "0"): ?>ac-auction-part<?php endif; ?>">
                            <tr class="th">
                                <?php if(($info["type"]) == "0"): ?><th width="15%">状态</th>
                                    <th width="25%">出价人</th>
                                    <th width="25%">加价</th>
                                    <th width="35%">价格</th><?php endif; ?>
                                <?php if(($info["type"]) == "1"): ?><th>出价人</th>
                                    <th>方式</th>
                                    <th>价格</th>
                                    <th>时间</th><?php endif; ?>
                            </tr>

                            <?php if(empty($bidRecord)): ?><tr class="nobody"><td colspan="4">暂时没有拍友出价</td></tr>
                            <?php else: ?>
                            <?php if(is_array($bidRecord)): $i = 0; $__LIST__ = array_slice($bidRecord,0,10,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brvo): $mod = ($i % 2 );++$i; if(($info["type"]) == "0"): ?><!-- 竞拍出价记录 -->
                                <tr uid="<?php echo ($brvo["uid"]); ?>" title="<?php echo (date('m-d H:i:s',$brvo["time"])); ?>">
                                    <td><div class="bidlistico"></div></td>
                                    <td><span class="on_over" style="width: 60px;"><?php echo ($brvo["nickname"]); ?></span></td>
                                    <td align="right"><?php if(($brvo["type"]) == "代理"): ?><span title="代理出价" class="agency_ico"></span><?php endif; echo (wipezero($brvo["money"])); ?></td>
                                    <td align="right"><?php echo (wipezero($brvo["bided"])); ?></td>
                                </tr>
                                <!-- 竞拍出价记录——end --><?php endif; ?>
                                <?php if(($info["type"]) == "1"): ?><!-- 竞标出价记录 -->
                                <tr uid="<?php echo ($brvo["uid"]); ?>">
                                    <td><span class="on_over" style="width: 60px;">竞标保密</span></td>
                                    <td align="center"><?php echo ($brvo["type"]); ?></td>
                                    <td align="right"><span class="red1 fb">竞标保密</span></td>
                                    <td align="center"><?php echo (date('m-d H:i:s',$brvo["time"])); ?></td>
                                </tr>
                                <!-- 竞标出价记录——end --><?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                        </table>

                        <div class="tip">
                            拍品共计出价<span class="red1 fb" id="bidcount"><?php echo ($info["bidcount"]); ?></span>次，此处显示最近10次出价。在拍品详情查看更多出价！
                        </div>
                    </div>
                    <!-- 出价记录——end -->
                    <!-- 我的出价 -->
                    <?php if(($login) == "1"): ?><div id="recordB" class="tab_con" style="display:none;">
                        <table id="my_record">
                            <tr class="th">
                                <?php if(($info["type"]) == "0"): ?><th width="25%">出价方式</th>
                                    <th width="30%">加价</th>
                                    <th width="45%">价格</th><?php endif; ?>
                                <?php if(($info["type"]) == "1"): ?><th>出价方式</th>
                                    <th>价格</th>
                                    <th>时间</th><?php endif; ?>
                            </tr>
                            <?php if(empty($myRecord)): ?><tr class="nobody"><td colspan="3">您没有出价</td></tr>
                            <?php else: ?>
                            <?php if(is_array($myRecord)): $i = 0; $__LIST__ = $myRecord;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$myvo): $mod = ($i % 2 );++$i;?><tr title="<?php echo (date('m-d H:i:s',$myvo["time"])); ?>">
                                <?php if(($info["type"]) == "0"): ?><td align="center"><?php if(($myvo["type"]) == "代理"): ?><span title="代理出价" class="agency_ico"></span><?php endif; echo ($myvo["type"]); ?></td>
                                    <td align="right"><?php echo (wipezero($myvo["money"])); ?></td>
                                    <td align="right"><span class="red1 fb"><?php echo (wipezero($myvo["bided"])); ?></span></td><?php endif; ?>
                                <?php if(($info["type"]) == "1"): ?><td align="center"><?php echo ($myvo["type"]); ?></td>
                                    <td align="right"><span class="red1 fb"><?php echo (wipezero($myvo["bided"])); ?></span></td>
                                    <td align="right"><?php echo (date('m-d H:i:s',$myvo["time"])); ?></td><?php endif; ?>
                            </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                        </table>
                        <div class="tip">
                            <ul class="mycont">
                                <li class="clearfix"><div class="th">共计出价：</div><div class="td"><span id="mycount"><?php echo ((isset($myCount) && ($myCount !== ""))?($myCount):0); ?></span>次</div></li>
                                <?php if(!empty($uFrezze)): ?><li class="clearfix">
                                        <div class="th"><strong><?php if(($info["sid"]) != "0"): ?>专场<?php else: ?>拍品<?php endif; ?></strong>冻结：</div>
                                        <div class="td">
                                        信用值<span class="red1 fb"><?php echo ($uFrezze["limsum"]); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;保证金<span class="red1 fb"><?php echo ($uFrezze["pledge"]); ?></span>
                                        </div>
                                    </li><?php endif; ?>
                                
                            </ul>
                        </div>
                    </div><?php endif; ?>
                    <!-- 我的出价——end -->
                </div>
            </div>
            </div>
        </div>
        <?php if(!empty($pnarr["prev"])): ?><a href="<?php echo U('Auction/details',array('pid'=>$pnarr['prev']['pid']));?>" id="prev-item" class="pm-item-arrow" style="display: inline;">
                <span class="icon-pai"></span>
                <div class="item-imgCon" data-ex="hide">
                    <img src="<?php echo ($upWholeUrl); echo (getpicurl($pnarr["prev"]["pictures"],2,0)); ?>" alt="<?php echo ($pnarr["prev"]["pname"]); ?>" >
                    <p>上一个拍品</p>
                    <span class="arrow fn-arrow"><span class="arrow-bg fn-arrow"></span></span>
                </div>
            </a><?php endif; ?>
        <?php if(!empty($pnarr["next"])): ?><a href="<?php echo U('Auction/details',array('pid'=>$pnarr['next']['pid']));?>" id="next-item" class="pm-item-arrow" style="display: inline;">
                <span class="icon-pai"></span>
                    <div class="item-imgCon" data-ex="hide">
                    <img src="<?php echo ($upWholeUrl); echo (getpicurl($pnarr["next"]["pictures"],2,0)); ?>" alt="<?php echo ($pnarr["next"]["pname"]); ?>" >
                    <p>下一个拍品</p>
                    <span class="arrow fn-arrow"><span class="arrow-bg fn-arrow"></span></span>
                </div>
            </a><?php endif; ?>
        

        <!-- 竞拍详细页广告 -->
        <div class="details_add"><?php echo showAdvPosition('details_add','span');?></div>
        <!-- 竞拍详细页广告——end -->
        <?php if(C('Auction.chat') == 1): ?><!-- 聊天室chat_box[ -->
            <div class="chat_box row clearfix">
                <div class="chat_tit">
                    <b>拍场聊天室<?php echo C('Auction.verify_mobile');?>：</b><?php echo ($info["pname"]); ?>
                </div>
                <div class="chat_con">
                    <div class="col-md-1 column"></div>
                    <div class="con_box chat_bod">
                       <div class="caption_box">
                           <div class="caption" id="dialog"></div>
                       </div>
                       <form onsubmit="onSubmit(); return false;">
                            <div class="send_box clearfix">
                                <textarea class="textarea" id="textarea"></textarea>
                                <div class="send_btnbox">
                                    <select id="client_list">
                                        <option value="all">所有人</option>
                                    </select>
                                    <div class="say-btn"><input type="submit" class="btn btn-default" value="发 送" /></div>
                                </div>
                                
                            </div>
                       </form>
                    </div>
                    <div class="pop_box chat_bod">
                       <div class="">
                           <div class="caption pop_libox" id="userlist">
                               <h4>在线用户</h4>
                               <ul></ul>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
            <!-- 聊天室chat_box[ --><?php endif; ?>
        <!-- 详情下部【 -->
        <div class="detail_content clearfix mt10">
        <!-- 详情下部右侧【 -->
            <div class="content_left">
                <div class="main_b3_4">
                    <div class="main_b3_4_top"><h2>商品描述</h2></div>
                    <div class="main_b3_4_main">
                    <?php echo ($info["description"]); ?>
                    </div>
                </div>
                <div class="main_b3_content">
                    <ul id="extcon_menu" class="tab_menu">
                        <li class="tab on">拍品详情</li>
                        <?php echo ($info["extend"]["eUrlHtml"]); ?>
                        <li> 出价记录</li>
                    </ul>
                    <div id="extcon_content" class="main_b3_tab_con">
                        <div class="index_con editbox"><?php echo ($info["content"]); ?></div>
                        <?php echo ($info["extend"]["eDivHtml"]); ?>
                        <div id="bid_jlall" class="hide bid_jlall <?php if(($info["type"]) == "0"): ?>ac-auction-all<?php endif; ?>">
                            <table>
                                <tr class="th">
                                    <?php if(($info["type"]) == "0"): ?><th>状态</th>
                                        <th>出价人</th>
                                        <th>出价方式</th>
                                        <th>加价</th>
                                        <th>加价后价格</th>
                                        <th>时间</th><?php endif; ?>
                                    <?php if(($info["type"]) == "1"): ?><th>出价人</th>
                                        <th>出价方式</th>
                                        <th>价格</th>
                                        <th>时间</th><?php endif; ?>
                                </tr>
                                <?php if(empty($bidRecord)): ?><tr class="nobody"><td colspan="6" align="center">暂时没有拍友出价</td></tr>
                                <?php else: ?>
                                    <?php if(is_array($bidRecord)): $i = 0; $__LIST__ = $bidRecord;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brvo): $mod = ($i % 2 );++$i;?><!-- 竞拍出价记录 -->
                                        <?php if(($info["type"]) == "0"): ?><tr>
                                            <td><div class="bidlistico"></div></td>
                                            <td><span class="on_over" style="width: 60px;"><?php echo ($brvo["nickname"]); ?></span></td>
                                            <td align="left"><?php if(($brvo["type"]) == "代理"): ?><span title="代理出价" class="agency_ico"></span><?php endif; echo ($brvo["type"]); ?>出价</td>
                                            <td align="right"><?php echo (wipezero($brvo["money"])); ?></td>
                                            <td align="right"><?php echo (wipezero($brvo["bided"])); ?></td>
                                            <td align="center"><?php echo (date('m-d H:i:s',$brvo["time"])); ?></td>
                                        </tr><?php endif; ?>
                                    <!-- 竞拍出价记录——end -->
                                    <!-- 竞标出价记录 -->
                                        <?php if(($info["type"]) == "1"): ?><tr>
                                            <td><span class="on_over" style="width: 60px;">竞标保密</span></td>
                                            <td align="center"><?php echo ($brvo["type"]); ?></td>
                                            <td align="right"><span class="red1 fb">竞标保密</span></td>
                                            <td align="center"><?php echo (date('m-d H:i:s',$brvo["time"])); ?></td>
                                        </tr><?php endif; ?>
                                    <!-- 竞标出价记录——end --><?php endforeach; endif; else: echo "" ;endif; ?>
                                    <tr><td colspan="4"><?php echo ($page); ?></td></tr><?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 详情下部右侧】 -->
            <!-- 详情下部左侧【 -->
            <div class="content_right">
                <ul class="mhd">
                    <li class=" clearfix mhd_imbox">
                        <a target="_blank" href="<?php echo U('Seller/index',array('sellerid'=>$seller['uid']));?>">
                            <img title="<?php echo ($seller["organization"]); ?>" src="<?php echo (getuserpic($seller["uid"],1)); ?>">
                        </a>
                    </li>
                    <li class="clearfix mhd_text">
                        <div class="th">卖家：</div>
                        <a class="td" target="_blank" href="<?php echo U('Seller/index',array('sellerid'=>$seller['uid']));?>"><?php echo ($seller["organization"]); ?></a>
                    </li>
                    <li class=" clearfix mhd_star"><div class="th">级别：</div><div class="td"><img style="margin-top: 4px;" src="<?php echo ($seller["leval"]); ?>"></div></li>
                    <li class=" clearfix mhd_star"><div class="th">信誉：</div><div class="td" id="credit"></div></li>
                    <li class="ubtn_box">
                        <div class="lybox_min fr clearfix">
                            <a target="_blank" class="ly fl" href="<?php echo U('Member/sendmsg',array('uid'=>$seller['uid'],'pid'=>$info['pid']));?>">
                                <div class="ico"></div>
                                <div class="txt cuit_over">给我留言</div>
                            </a>
                        </div>
                        <div class="gzbox_min ac-attention-box fr clearfix">
                            <a class="gz_sell gz fl selatt<?php echo ($seller["uid"]); ?> <?php if(($gzuser) == "1"): ?>on<?php endif; ?>" sellerid="<?php echo ($seller["uid"]); ?>" st="<?php echo ($gzuser); ?>" href="javascript:void(0);">
                                <div class="ico"></div>
                                <div class="txt cuit_over"><?php if(($gzuser) == "0"): ?>关注卖家<?php else: ?>已关注<?php endif; ?></div>
                            </a>
                        </div>
                    </li>
                </ul>
                
                <div class="morsp">
                    <div class="morsp_tit"></div>
                    <ul class="morsp_con">
                        <li></li>
                    </ul>
                </div>
            </div>
            <!-- 详情下部左侧】 -->
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


<script type="text/javascript">

var acpid = '<?php echo ($info["pid"]); ?>';
// 代理状态
var setagency = "<?php echo ($setagency); ?>";
// 代理价格
var myagprice = "<?php echo ($myagprice); ?>"
// 代理出价知道提醒
var iknowurl ="<?php echo U('Auction/iknow');?>";
//取消代理出价
var cancelAgency ="<?php echo U('Auction/cancel_agency');?>";
// 关注拍品
var setAttentionUrl ="<?php echo U('Auction/attention');?>";
// 设置提醒
var setScheduledUrl ="<?php echo U('Auction/scheduled');?>";
// 设置提醒方式
var setTixingUrl ="<?php echo U('Member/settixing');?>";

// 出价被超越提醒
var send_remind = "<?php echo U('Auction/send_remind');?>";
// 保证金冻结提醒
var freeze_remind = "<?php echo U('Auction/freeze_remind');?>";


// 卖家uid
var sellerid = '<?php echo ($seller["uid"]); ?>';
//拍品状态 
var nstatus = "<?php echo ($info["nstatus"]); ?>";
// 拍卖类型
var bidtype = "<?php echo ($info["type"]); ?>";
//出价统计
var bidCount='<?php echo ($info["bidcount"]); ?>'; 
//出价提交地址
var bidUrl ="<?php echo U('Auction/bid');?>"; 
//商品结束验证生成订单提交地址
var ajaxCheckSucc ="<?php echo U('Auction/checksucc');?>";
// 加价幅度
var steplin = "<?php echo ($info["stepsize"]); ?>";
// 当前价
var nowPrice = "<?php echo ($info["nowprice"]); ?>";
// 当前出价者
var nowUid = "<?php echo ($info["uid"]); ?>";
// 结束类型
var endStatus = "<?php echo ($info["endstatus"]); ?>";
//获取拍卖时间
var ajaxGetTime = "<?php echo U('Auction/ajaxGetTime');?>";
endDowntimer = null;
startDowntimer = null;
// 拍卖会mid
var mid = "<?php echo ($info["mid"]); ?>";
var mname = "<?php echo ($mtdata["mname"]); ?>";
// 拍卖会进行中的拍品地址
// 下一个拍卖链接
var mtnextPid = "<?php echo ($mtdata["nexbid"]["pid"]); ?>";
var mtnextUrl ="<?php echo U('Auction/details',array('mid'=>$info['mid'],'pid'=>$mtdata['nexbid']['pid']));?>";
// 拍卖会进行中的拍品
var mtnowpid = "<?php echo ($mtdata["mtnowpid"]); ?>";
var mtnowUrl = "<?php echo U('Auction/details',array('pid'=>$mtdata['mtnowpid']));?>";
// 拍卖会状态进行
var mtstatus ="<?php echo ($mtdata["mtstatus"]); ?>";
// 结论页面地址
var conclusion = "<?php echo U('Meeting/conclusion',array('mid'=>$info['mid']));?>";
// 下一件拍品pid
// 启动中代理图标
var startautoimg = "/Public/Home/Img/auto_btn_ico.gif";
var stopautoimg = "/Public/Home/Img/auto_btn_ico0.gif";
// 停止中代理图标
// web_socket【
var connectLink = 1;
var ws_rom_pre = "<?php echo C('BID_PRE');?>";
var ws_my_name = '<?php echo ($myname); ?>';
var ws_my_uid = '<?php echo ($uid); ?>';
var ltnr = '/Public/Home/Img/ltnr_pic.png';
var domain = "<?php echo ($site["WEB_ROOT"]); ?>";
if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    WEB_SOCKET_SWF_LOCATION = "./Public/WebSocketMain/swf/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws, client_list={};

// web_socket】
// 拍卖状态
</script>
<script src="/Public/ueditor/ueditor.parse.js"></script>
<script>
setTimeout(function(){uParse('.editbox',
{
 'highlightJsUrl':'/Public/ueditor/third-party/SyntaxHighlighter/shCore.js',
 'highlightCssUrl':'/Public/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css'})
},300);
var start_path = "/Public/Js/jquery_raty/img"
var credit_score = "<?php echo ($seller["credit_score"]); ?>";
$(function(){
    $('#credit').raty({
        readOnly: true,
        score: Number(credit_score),
        path : start_path
    });

});
</script>
</body>
</html>