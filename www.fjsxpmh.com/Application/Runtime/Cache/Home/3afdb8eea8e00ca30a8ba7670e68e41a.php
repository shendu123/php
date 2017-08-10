<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
		<meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title>登录-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
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

    </head>
    <body>
    <!--  头部开始  -->
<div class="top bg_narrow">
    <div class="topcon w_narrow">
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
<div class="clearfix" id="header_narrow">
    <h1 class="logo">
        <?php echo showAdvPosition('web_logo','span');?>
    </h1>
</div>
<div class="top_nav clearfix" id="nav">
    <div class="nav-bd" id="navview">
        <div class="nav_narrow clearfix">
            <ul class="top_nav_tab clearfix">
                <li class="nav-item">
                    <a href="<?php echo U('Index/index');?>"class='current'>首 页</a>
                </li>
                <?php if(is_array($channelMenu)): foreach($channelMenu as $key=>$cm): ?><li class="nav-item">
                       <a href="<?php echo U('Auction/index',array('gt'=>$cm['cid']));?>" title="<?php echo ($cm["name"]); ?>拍卖"> <?php echo ($cm["name"]); ?></a> 
                    </li><?php endforeach; endif; ?>
                <li class="nav-item"><a href="<?php echo U('Special/index');?>">专场拍卖</a></li>
                <li class="nav-item"><a href="<?php echo U('Meeting/index');?>">拍卖会</a></li>
                <li><ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">添加的导航</a></li></ul></li>
                
            </ul>
            <ul class="right-nav-item">
                <li>
                    <a href="<?php echo U('Article/notice',array('cid'=>3));?>">拍卖资讯</a>
                </li>
            </ul>
        </div>
        <div class="nav-rel">
            <div class="nav-track"></div>
        </div>
    </div>
    <div class="nav-bd-sec clearfix">
        <div class="fl">
            <span class="btn_red1 bg_main fl">竞 拍</span>规定时间，多次出价，价高者得。
        </div>
        <div class="fl">
            <span class="btn_red1 bg_main fl">竞 标</span>规定时间，一次出价，价高者得。
        </div>
    </div>
</div>
<!--  头部结束  -->
<script type="text/javascript">
$(function() {
    $('.nav_narrow .menu_onelayer li').hover(function(){
        $(this).find("ul").first().show();
    },function(){
        $(this).find("ul").first().hide();
    });

    var $nav = $("#navview"), $track = $nav.find(".nav-track"),$tags = $nav.find("a"),$cur = $tags.filter(".current");
    $tags.hover(function(){ track(this) },function(){ track($cur) }).hover(function(){ 
        $tags.removeClass("current"); //$cur = $(this).addClass("current")
    });
    function track($t,l,w){
        $t = $($t);
        l = $t.offset().left - $nav.offset().left;
        w = $t.outerWidth();
        $track.stop().animate({width:w,left:l},400,"swing");
        }
        track( $cur);
});
</script>
	<div id="container_white">
		<div class="main_b3">
			<!--登录开始-->
			<div class="main_b8_1 mainlogin">
				<div class="main_b8_1_main">
					<div class="wellcome">
						<ul>
							<li class="welltitle">欢迎登录<?php echo ($site["SITE_INFO"]["name"]); ?></li>
							<li class="denglu">未注册？&nbsp;<a href="<?php echo U('Login/register');?>">注册</a></li>
						</ul>
					</div>
					<form id="LoginForm" class="reg-form" action="" method="post" name="LoginForm">
						   <dl class="clearfix">
							  <dt>登录账号</dt>
							  <dd><input name="account" size="30" type="text" class="input cl9" value="<?php echo ($ltr); ?>" /></dd>
						  </dl>
						  <dl class="clearfix">
							 <dt>登录密码</dt>
							 <dd>
							 	<input name="pwd" size="30" type="password" class="input" />
								<a href="<?php echo U('Login/findPwd');?>">忘记密码？</a>
							 </dd>
						 </dl>
						 <dl class="clearfix">
							<dt>验 证 码</dt>
							<dd><input class="input" id="verify_code" name="verify_code" type="text" size="5" /> <img class="verify" src="<?php echo U('Public/verify_code');?>"  title="看不清？单击此处刷新" onclick="this.src+='?rand='+Math.random();" />
						 	</dd>
						 </dl>
						 <dl class="clearfix">
						   <dt>&nbsp;</dt>
							<dd>
								<input  type="hidden" name="referer" value="<?php echo ($referer); ?>" />
								<input class="submit pm_btn_5" type="submit" value='登录'/>
							</dd>
						  </dl>
					</form>
				</div>
				<div class="logadd"><?php echo showAdvPosition('logadd','span','false');?></div>
			</div>
			<!--登录结束-->
		</div>
	</div>
	<!---底部开始---->
	<div class="main_a8 clearfix">
	    <div class="main_a8_main clearfix">
	        
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
    var ltr = "<?php echo ($ltr); ?>";
    $(function(){
        // 账号input显示效果
        var accObj=$("input[name='account']");
        var accD = accObj.val();
        if(accD!=ltr){accObj.addClass("cl9");}
        accObj.focus(function() {if ($(this).val() == accD) {$(this).val(""); accObj.removeClass("cl9");}});  
        accObj.blur(function() {if ($(this).val()== "") {$(this).val(accD); accObj.addClass("cl9");}}); 
        // ajax提交
        $(".submit").click(function(){
            commonAjaxSubmit('','','',function(){
                    var newcode = $('.verify').attr('src');
                    $('.verify').attr('src',newcode+'?rand='+Math.random());
                    $('#verify_code').val('');
                });

            return false;
        });
    });
</script>
</body>
</html>