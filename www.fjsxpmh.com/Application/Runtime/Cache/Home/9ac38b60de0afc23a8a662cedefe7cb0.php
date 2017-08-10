<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
		<meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title>注册-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
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
    <!-- 主体开始 -->
	<div id="container_white">
		<div class="main_b3">
        	<div class="register_add">
				<?php echo showAdvPosition('register_add','span');?>
			</div>
			<!--注册开始-->	
			<div class="main_b8_1">
				<div class="main_b8_1_main">
					<div class="wellcome">
						<ul>
							<li class="welltitle">欢迎注册<?php echo ($site["SITE_INFO"]["name"]); ?></li>
							<li class="denglu">已注册？&nbsp;<a href="<?php echo U('Login/index');?>">登录</a></li>
						</ul>
					</div>
					<?php if(empty($registerType)): ?><div class="closRegister">
							网站已暂停用户注册！请和管理员联系
						</div>
					<?php else: ?>
						<div class="loginTypeTit">
							<div class="loginType">
								<?php if(($rtype["account"]) == "on"): ?><a <?php if(($registerType) == "account"): ?>class="on"<?php endif; ?> href="<?php echo U('Login/register');?>">账号注册</a><?php endif; ?>
								<?php if(($rtype["email"]) == "on"): ?><a <?php if(($registerType) == "email"): ?>class="on"<?php endif; ?> href="<?php echo U('Login/register',array('registerType'=>'email'));?>">邮箱注册</a><?php endif; ?>
								<?php if(($rtype["mobile"]) == "on"): ?><a <?php if(($registerType) == "mobile"): ?>class="on"<?php endif; ?> href="<?php echo U('Login/register',array('registerType'=>'mobile'));?>">手机注册</a><?php endif; ?>
							</div>
						</div><?php endif; ?>
					<form id="RegForm" class="reg-form" name="register" method="post">
						<?php if(($registerType) == "account"): ?><!-- 账号注册 -->
							 <dl class="clearfix">
								 <dt>登陆账号</dt>
								 <dd><input id="account" name="account" size="30" type="text" class="input"/></dd>
								 <dd><div id="accountTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>昵称</dt>
								 <dd><input id="nickname" name="nickname" size="30" type="text" class="input"/></dd>
								 <dd><div id="nicknameTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>用户姓名</dt>
								 <dd><input id="truename" name="truename" size="30" type="text" class="input"/></dd>
								 <dd><div id="truenameTip"></div></dd>  
							 </dl>
							 <dl class="clearfix">
		                        <dt>手机号码</dt>
		                        <dd><input id="mobile" type="text" size="30" class="input" name="mobile" value="<?php echo ($my_info["mobile"]); ?>"/></dd>
		                        <dd><div id="mobileTip"></div></dd>
		                     </dl>
							<input type="hidden" name="registerType" value="account"><?php endif; ?>
						<!-- 账号注册——end -->
						<!-- 邮箱注册表单 -->
						<?php if(($registerType) == "email"): ?><dl class="clearfix">
								 <dt>邮箱</dt>
								 <dd><input id="email" name="email" size="30" type="text" class="input" value="<?php echo ($email); ?>" /></dd>
								 <dd><input checktp="email" class="checkbtnto"  style="margin-left: 5px;" type="button" value="发送验证码" /></dd>
								 <dd><div id="emailTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>邮箱验证码</dt>
								 <dd><input size="10" id="email_verify" name="email_verify" type="text" class="input" value="" /></dd>
								 <dd><div id="email_verifyTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>昵称</dt>
								 <dd><input id="nickname" name="nickname" size="30" type="text" class="input"/></dd>
								 <dd><div id="nicknameTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>用户姓名</dt>
								 <dd><input id="truename" name="truename" size="30" type="text" class="input"/></dd>
								 <dd><div id="truenameTip"></div></dd>   
							 </dl>
							 <dl class="clearfix">
		                        <dt>手机号码</dt>
		                        <dd><input id="mobile" type="text" size="30" class="input" name="mobile" value="<?php echo ($my_info["mobile"]); ?>"/></dd>
		                        <dd><div id="mobileTip"></div></dd>
		                     </dl>
							<input type="hidden" name="registerType" value="email"><?php endif; ?>
						<!-- 邮箱注册表单——end -->
						<!-- 手机注册表单 -->
						<?php if(($registerType) == "mobile"): ?><dl class="clearfix">
								 <dt>手机号码：</dt>
								 <dd><input size="30" id="mobile" name="mobile" type="text" class="input" value="" /></dd>
								 <dd><input checktp="mobile" class="checkbtnto"  style="margin-left: 5px;" type="button" value="发送验证码" /></dd>
								 <dd><div id="mobileTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>手机验证码</dt>
								 <dd><input size="10" id="mobile_verify" name="mobile_verify" type="text" class="input" value="" /></dd>
								 <dd><div id="mobile_verifyTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>昵称</dt>
								 <dd><input id="nickname" name="nickname" size="30" type="text" class="input"/></dd>
								 <dd><div id="nicknameTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								 <dt>用户姓名</dt>
								 <dd><input id="truename" name="truename" size="30" type="text" class="input"/></dd>
								 <dd><div id="truenameTip"></div></dd>   
							 </dl>
							 <dl class="clearfix">
		                        <dt>邮箱</dt>
		                        <dd><input id="email" type="text" size="30" class="input" name="email"/></dd>
								<dd><div id="emailTip"></div></dd>
		                     </dl>
							<input type="hidden" name="registerType" value="mobile"><?php endif; ?>
						<?php if(!empty($registerType)): ?><!-- 手机注册表单——end -->
							<dl class="clearfix">
								 <dt>登录密码</dt>
								 <dd><input id="pwd" name="pwd" size="30" type="password" class="input" /></dd>
								 <dd><div id="pwdTip"></div></dd>
							 </dl>
							 <dl class="clearfix">
								<dt>确认密码</dt>
								<dd><input id="pwded" name="pwded" size="30" type="password" class="input" /></dd>
								<dd><div id="pwdedTip"></div></dd>
							 </dl>
							 
							 <dl class="clearfix">
							 	<dt>验证码</dt>
							 	<dd>
							 		<input class="input" id="verify_code" name="verify_code" type="text" size="5" /> <img class="verify" src="<?php echo U('Public/verify_code');?>"  title="看不清？单击此处刷新" onclick="this.src+='?rand='+Math.random();" />
							 	</dd>
							 	<dd><div id="verify_codeTip"></div></dd>

							 </dl>
							 <?php if(!empty($feedback)): ?><dl class="clearfix">
								 	<dt>&nbsp;</dt>
									<dd class="feedback">
										<div class="tit">你是通过什么途径了解到<?php echo ($site["SITE_INFO"]["name"]); ?>的?</div>
										<?php if(is_array($feedback)): $i = 0; $__LIST__ = $feedback;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><label><input name="feedback" type="radio" value="<?php echo ($vo["id"]); ?>"/>&nbsp;<?php echo ($vo["name"]); ?>&nbsp;</label><?php endforeach; endif; else: echo "" ;endif; ?>
									</dd>
								 </dl><?php endif; ?>
							 <dl class="clearfix">
							   <dt>&nbsp;</dt>
							   <dd class="xieyi"><input name="isAgree" name="isAgree" type="checkbox" id="isAgree" value="1" checked="checked" /><span class="text">我已阅读并接受《<a href="<?php echo U('Public/information');?>" target="_blank"><?php echo ($site["SITE_INFO"]["name"]); ?>服务协议</a>》</span><span id="clauseTips"></span>
							   </dd>
							   <dd><div id="isAgreeTip"></div></dd>
							   <input  type="hidden" name="referer" value="<?php echo ($referer); ?>" />
							</dl>
							 <dl>
							   <dt>&nbsp;</dt>
								<dd><input class="submit pm_btn_5" type="submit" value='马上注册' id='submit'/></dd>
							</dl><?php endif; ?>
					</form>
				</div>
			</div>
			<!--注册结束-->

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


<script type="text/javascript" src="/Public/Js/formValidator/formValidator-4.1.3.js"></script>
<script type="text/javascript" src="/Public/Js/formValidator/formValidatorRegex.js"></script>

<script type="text/javascript">
var checkAccount = "<?php echo U('Login/checkAccount');?>";
var checkMobile = "<?php echo U('Login/checkMobile');?>";
var checkEmail = "<?php echo U('Login/checkEmail');?>";
var checkVerify = "<?php echo U('Login/checkVerify');?>";
var checkEmailCode = "<?php echo U('Login/checkEmailCode');?>";
var checkMobileCode = "<?php echo U('Login/checkMobileCode');?>";

var sendCodeUlrl = "<?php echo U('Login/sendCode');?>";
var wait=60;
    $(function(){
    	// 重新发送验证码
    	$('.checkbtnto').click(function(){
    		popStatus(3, '发送中...', 0,'',true);
    		var checkadr = $('#'+$(this).attr('checktp')).val();
			var checktp = $(this).attr('checktp');
			$.post(sendCodeUlrl,{'checkadr':checkadr,'checktp':checktp,'how':'register'},function(data){
				popStatusOff();
                if (data.status) {
                    popup.success(data.info);
                    setTimeout(function(){
                        popup.close("asyncbox_success");
                    },2000);
                    $('.checkadrbox input').attr("disabled", 'disabled');
                    time($('.checkbtnto'));
                } else {
                    popup.error(data.info);
                    setTimeout(function(){
                        popup.close("asyncbox_error");
                    },2000);
                }
            },'json');
        });
        // 重新发送验证码】
	// 表单验证【
	$.formValidator.initConfig({formID:"RegForm",submitButtonID:"submit"});
	$("#submit").click(function(){
        if($.formValidator.pageIsValid('1')==true){
            commonAjaxSubmit('','','',function(){
                var newcode = $('.verify').attr('src');
                $('.verify').attr('src',newcode+'?rand='+Math.random());
                $('#verify_code').val('');
            });
        }
        return false;
    });


	$("#account").formValidator({onShow:"请输入用账号",onFocus:"以字母开头，5-17 字母、数字、下划线'_'",onCorrect:"该用账号可以注册"}).inputValidator({min:5,max:17,onError:"你输入的用账号不正确,请确认"}).functionValidator({fun:formAccount}).ajaxValidator({
			url : checkAccount,
			type : 'POST',
			dataType : "json",
			data : "&account="+$('#account').val(),
			async : true,
			success : function(data){
				if(data){
					return true;
				}else{
					return false;
				}
			},
			buttons: $("#button"),
			error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
			onError : "该用账号已被注册，请更换用账号",
			onWait : "正在对用账号进行合法性校验，请稍候..."
		});
	$("#nickname").formValidator({onShow:"你在这里的名字",onFocus:"要求最少3个不超过20个字符(一个汉字占用2个字符)",onCorrect:"输入正确"}).inputValidator({min:3,max:20,onError:"你输入的昵称不正确,请确认"});

	$("#truename").formValidator({onShow:"请输入你的中文姓名",onFocus:"要求2-10个中文字符",onCorrect:"输入正确"}).functionValidator({fun:trueName});
	$("#email").formValidator({onShow:"请输入邮箱",onFocus:"邮箱6-100个字符",onCorrect:"输入正确",defaultValue:"@"}).inputValidator({min:6,max:100,onError:"你输入的邮箱长度不正确,请确认"}).regexValidator({regExp:"^[a-z0-9]+([._\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$",onError:"你输入的邮箱格式不正确"}).ajaxValidator({
			url : checkEmail,
			type : 'POST',
			dataType : "json",
			data : "&email="+$('#email').val()+"&how=register", 
			async : true,
			success : function(data){
				return data;
			},
			error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
			onError : "该邮箱已被注册！请更换",
			onWait : "正在对邮箱进行合法性校验，请稍候..."
		});
	$("#email_verify").formValidator({onShow:"收到邮件中的验证码",onFocus:"完成注册必须项",onCorrect:"输入正确"}).inputValidator({min:1,max:8,onError:"验证码错误,请确认"}).ajaxValidator({
			url : checkEmailCode,
			type : 'POST',
			dataType : "json",
			data : "&email="+$('#email').val()+"&email_verify="+$('#email_verify').val(),
			async : true,
			success : function(data){
				return data;
			},
			error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
			onError : "邮箱验证码错误！请检查",
			onWait : "正在对邮箱验证码进行合法性校验，请稍候..."
		});
	$("#mobile").formValidator({onShow:"主要用于交易通知",onFocus:"11位数字，如“13812345678”",onCorrect:"谢谢你的合作",onEmpty:"该项为必填项"}).inputValidator({min:11,max:11,onError:"手机号码必须是11位的,请确认"}).regexValidator({regExp:"mobile",dataType:"enum",onError:"你输入的手机号码格式不正确"}).ajaxValidator({
			url : checkMobile,
			type : 'POST',
			dataType : "json",
			data : '&mobile='+$('#mobile').val()+'&how=register',
			async : true,
			success : function(data){
				return data;
			},
			error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
			onError : "手机号已被注册！请更换",
			onWait : "正在对手机号进行合法性校验，请稍候..."
		});
	$("#mobile_verify").formValidator({onShow:"收到手机中的验证码",onFocus:"完成注册必须项",onCorrect:"输入正确"}).inputValidator({min:1,max:8,onError:"验证码错误,请确认"}).ajaxValidator({
			url : checkMobileCode,
			type : 'POST',
			dataType : "json",
			data : "&mobile="+$('#mobile').val()+"&mobile_verify="+$('#mobile_verify').val(),
			async : true,
			success : function(data){
				return data;
			},
			error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
			onError : "手机验证码错误！请检查",
			onWait : "正在对手机验证码进行合法性校验，请稍候..."
		});

	$("#pwd").formValidator({onShow:"请输入密码",onFocus:"至少6个字符",onCorrect:"密码合法"}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"密码两边不能有空符号"},onError:"密码至少6个字符,请确认"});
	$("#pwded").formValidator({onShow:"输再次输入密码",onFocus:"至少6个字符",onCorrect:"密码一致"}).inputValidator({min:6,empty:{leftEmpty:false,rightEmpty:false,emptyError:"重复密码两边不能有空符号"},onError:"重复密码至少6个字符,请确认"}).compareValidator({desID:"pwd",operateor:"=",onError:"2次密码不一致,请确认"});
	$("#verify_code").formValidator({onShow:"请输入验证码",onFocus:"验证码不能为空",onCorrect:"输入正确"}).inputValidator({min:1,max:8,onError:"验证码错误,请确认"});
	// .ajaxValidator({
	// 		url : checkVerify,
	// 		type : 'POST',
	// 		dataType : "json",
	// 		data : "&verify_code="+$('#verify_code').val(),
	// 		async : true,
	// 		success : function(data){
	// 			return data;
	// 		},
	// 		error: function(jqXHR, textStatus, errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},
	// 		onError : "验证码错误！请检查",
	// 		onWait : "正在对验证码进行合法性校验，请稍候..."
	// 	});
	$(":checkbox[name='isAgree']").formValidator({tipID:"isAgreeTip",onShow:"选择网站服务协议",onFocus:"必须同意网站服务协议",onCorrect:"已同意网站服务协议"}).inputValidator({min:1,onError:"必须同意网站服务协议"});
	// 表单验证】
    });
// 重新发送验证码
function time(o) {
    if (wait == 0) {
        o.attr("disabled", false);
        o.attr('value','重新发送');       
        wait = 60;
    } else {
        o.attr("disabled", true);
        o.attr('value','重新发送(' + wait + ')');
        wait--;
        setTimeout(function() {
            time(o)
        },
        1000)
    }
}
</script>
</body>
</html>