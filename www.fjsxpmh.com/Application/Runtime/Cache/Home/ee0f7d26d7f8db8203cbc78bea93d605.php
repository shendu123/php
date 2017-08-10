<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
        <meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title>在线充值-账号中心-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
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

        <link rel="stylesheet" type="text/css" href="/Public/Home/Css/user.css" />
        <script type="text/javascript" src="/Public/Home/Js/user.js"></script>
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
    <div class="main_b9">
        <div class="h8 clearfix"></div>
        <div class="main_b3_top"><a href="">首　页</a>&nbsp;&gt;&gt;&nbsp;账号中心&nbsp;&gt;&gt;&nbsp;在线充值</div>
        <div class="main_b9_1 clearfix">
            <!--左侧导航开始-->
            <div class="main_b9_1_left">
    <ul id="menu">
        <li><a href="">账号中心</a>
            <ul>
                <li <?php if((ACTION_NAME) == "index"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/index');?>">账号信息</a></li>
                <li <?php if((ACTION_NAME) == "my_info"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/my_info');?>">个人信息</a></li>
                <?php if((ACTION_NAME) == "my_portrait"): ?><li class="user_li_pg"><a href="<?php echo U('Member/my_info');?>">编辑头像</a></li><?php endif; ?> 
                <li <?php if((ACTION_NAME) == "deliver_address"): ?>class="user_li_pg"<?php endif; ?>><a href="<?php echo U('Member/deliver_address');?>">我的地址薄</a></li>
                <?php if((ACTION_NAME) == "check"): ?><li class="user_li_pg"><a href="<?php echo U('Member/check',array('type'=>'email'));?>">邮箱、手机认证</a></li><?php endif; ?>
                <li <?php if((ACTION_NAME) == "payment"): ?>class="user_li_pg"<?php endif; ?>><a href="<?php echo U('Member/payment');?>" target="_blank">在线充值</a></li>
                <?php if((ACTION_NAME) == "payment_order"): ?><li <?php if((ACTION_NAME) == "payment_order"): ?>class="user_li_pg"<?php endif; ?>><a href="javascript:void(0);">订单支付</a></li><?php endif; ?>
                <li <?php if((ACTION_NAME) == "limsum"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/limsum');?>">信用额度</a></li>
                <li <?php if((ACTION_NAME) == "pledge"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/pledge');?>">账户余额</a></li>
                <li <?php if((ACTION_NAME) == "pledge_take"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/pledge_take');?>">余额取款</a></li>
                <li <?php if((ACTION_NAME) == "mysms"): ?>class="user_li_pg"<?php endif; ?>  style="position: relative;">
                    <a href="<?php echo U('Member/mysms');?>">提醒/站内信</a>
                    <?php if($smsc != 0): ?><span title="<?php echo ($smsc); ?>条未读" class="smsc"><?php echo ($smsc); ?></span><?php endif; ?>
                </li>
                <li <?php if((ACTION_NAME) == "sendmsg"): ?>class="user_li_pg"<?php endif; ?>><a href="<?php echo U('Member/sendmsg');?>">发送站内信</a></li>
                <?php if((ACTION_NAME) == "sendlist"): ?><li class="user_li_pg"><a href="javascript:void(0);">已发送站内信</a></li><?php endif; ?>
                <?php if((ACTION_NAME) == "exchange"): ?><li class="user_li_pg"><a href="javascript:void(0);">会话记录</a></li><?php endif; ?>
                
                <li <?php if((ACTION_NAME) == "reset_pwd"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/reset_pwd');?>">修改密码</a></li>
            </ul>
        </li>
        <li><a href="">我是买家</a>
            <ul>
                <li <?php if((ACTION_NAME) == "myatt"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/myatt',array('type'=>'pm'));?>">我关注的</a></li>
                <li <?php if((ACTION_NAME) == "mybid"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/mybid');?>">我参与的拍卖</a></li>
                <li <?php if((ACTION_NAME) == "mysucc"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/mysucc');?>">我拍到的</a></li>
                <?php if(ACTION_NAME == evaluate): ?><li class="user_li_pg"><a href="javascript:void(0);">商品评价</a></li><?php endif; ?>
                <li <?php if(in_array((ACTION_NAME), explode(',',"my_evaluate,buy_myevaluate"))): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/buy_myevaluate');?>">评价管理</a></li>

            </ul>
        </li>
        <li><a href="">我是卖家</a>
            <ul>
                <li <?php if((ACTION_NAME) == "addGoods"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/addGoods');?>">发布拍卖</a></li>
                <li <?php if((ACTION_NAME) == "goodsList"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/goodsList');?>">待发布拍卖</a></li>
                <li <?php if((ACTION_NAME) == "auctionList"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/auctionList');?>">我的拍卖</a></li>
                <li <?php if((ACTION_NAME) == "myorder"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/myorder');?>">拍卖订单</a></li>
                <li <?php if(in_array((ACTION_NAME), explode(',',"my_evaluatebuy,seller_myevaluate"))): ?>class="user_li_pg"<?php endif; ?>><a href="<?php echo U('Member/seller_myevaluate');?>">评价管理</a></li>
                <?php if(C('Weixin.appid') and C('Weixin.appsecret')): ?><li <?php if((ACTION_NAME) == "weisend"): ?>class="user_li_pg"<?php endif; ?> ><a href="<?php echo U('Member/weisend');?>">微信图文推送</a></li><?php endif; ?>
                
            </ul>
        </li>
    </ul>
</div>
            <!--左侧导航结束-->
            <!---右侧开始-->
            <div class="sider">
                <!-- 余额充值显示 -->
                <h2>在线充值</h2>
                <div class="zhyts">
                    <strong>尊敬的客户，充值余额成功后你将享有对应拍品的出价权限!出价后冻结余额作为保证金，如未拍到拍品，保证金将退回到您的账户！你可以选择提现来获得账户内的余额！详情查看帮助中心</strong>
                </div>
                <form id="remaining" action="<?php echo U('Payment/index');?>" name="remaining" method="post">
                    <div class="my_info">
                        <!-- 余额充值 -->
                        <input type="hidden" name="data[purpose]" value="pledge" />
                        <dl class="clearfix">
                            <dt>充值金额：</dt>
                            <dd><input type="text" id="money" name="data[money]" class="input">&nbsp;元</dd>
                            <dd><div id="moneyTip"></div></dd>
                        </dl>
                        <!-- 余额充值——end -->
                         <dl class="clearfix linp">
                            <dt style="line-height: 42px;">在线支付：</dt>
                            <dd>
                                <ul class="payTypeList clearfix">
                                    <?php if(is_array($channel)): foreach($channel as $key=>$v): ?><li>
                                            <label>
                                                <div class="icobox">
                                                    <input type="radio" id="pay<?php if(($key) != "0"): echo ($key); endif; ?>" value="<?php echo ($v["value"]); ?>" name="data[channel]">
                                                    <img src="<?php echo ($v["img"]); ?>">
                                                </div>
                                            </label>
                                            
                                        </li><?php endforeach; endif; ?>
                                </ul>
                            </dd>
                            <dd style="padding-left: 80px;"><div id="payTip"></div></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt>&nbsp;</dt>
                            <input type="hidden" name="data[payType]" value="recharge" />
                            <dd><input type="submit" value="支付" id="submit" class="on-btn on-btn-red submit"></dd>
                        </dl>
                    </div>
                </form>
            </div>
            <!---右侧结束-->
        </div>
        <!--auction.html结束-->
    </div>
</div>
<!---底部开始-->
<div class="main_a8 help_narrow clearfix">
    <div class="main_a8_main clearfix">
        <?php echo W('Oncoo/helpList',array(1,4,10));?>
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



<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidatorRegex.js"></script>

<script type="text/javascript">
    $(function(){
        // 初始化radio
        $(".payTypeList").find("li:first-child").find("input[name='data[channel]']").attr('checked','checked');
        $(".payTypeList input[name='data[channel]']:checked").parents('li').addClass('cur');
        $(".payTypeList :radio").change(function() {
            $("input[name='data[channel]']").parents('li').removeClass('cur');
            $("input[name='data[channel]']:checked").parents('li').addClass('cur');
        });
        // 表单验证【
        $.formValidator.initConfig({formID:"remaining",submitButtonID:"submit"});
        $("#money").formValidator({onShow:"请输入充值金额",onFocus:"必须为数字，小数点后最多可有两位",onCorrect:"输入正确"}).functionValidator({fun:isMoney});
        $(":radio[name='data[channel]']").formValidator({tipID:"payTip",onShow:"请选择一种支付方式",onFocus:"请选择一种支付方式，才能支付",onCorrect:"已选择"}).inputValidator({min:1,max:1,onError:"性别忘记选了,请确认"});
        // 表单验证】
    });
</script>
</body>
</html>