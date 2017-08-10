<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=1200,initial-scale=1.0"/>
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <meta http-equiv="X-UA-Compatible" content="edge" />
        <title>登录-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <base href="<?php echo ($site["WEB_ROOT"]); ?>"/>
		<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/base.css" />
		<link rel="stylesheet" type="text/css" href="/Public/Css/pop_status.css" />
		<link rel="stylesheet" type="text/css" href="/Public/Js/asyncbox/skins/default.css" />
        <script type="text/javascript" src="/Public/Js/jquery-1.7.2.min.js"></script>

		<script type="text/javascript" src="/Public/Js/pop_status.js"></script>
		<script type="text/javascript" src="/Public/Js/functions.js"></script>
		<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
		<script type="text/javascript" src="/Public/Js/asyncbox/asyncbox.js"></script>
    </head>

<body class="loginWeb">
    <div class="loginBox">
        <div class="innerBox">
            <div class="logo"> <img src="/Public/Admin/Img/login_logo.gif" /></div>
            <form id="form1" action="" method="post">
                <div class="loginInfo">
                    <ul class="clearfix">
                        <li class="clearfix">
                            <div class="row1">登录账号：</div>
                            <div class="row2"><input class="input" name="email" id="email" size="30" type="text" /></div>
                        </li>
                        
                        <li class="clearfix">
                            <div class="row1">登录密码：</div>
                            <div class="row2"><input class="input" name="pwd" id="pwd" size="30" type="password" /></div>
                        </li>
                        <li class="clearfix">
                            <div class="row1">验证码：</div>
                            <div class="row2"><input class="input" id="verify_code" name="verify_code" type="text" style="width:100px;" />&nbsp;&nbsp;&nbsp;&nbsp;<img class="verify" src="<?php echo U('Public/verify_code');?>"  title="看不清？单击此处刷新" onclick="this.src+='?rand='+Math.random();"/></div>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="op_type" id="op_type" value="1"/>
            </form>
            <div class="clear"></div>
            <div class="operation"><button class="btn submit">登录</button>   <button class="btn findPwd">忘记密码？</button></div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            $(".submit").click(function(){
                $("#op_type").val("1");
                if($("#email").val()==''||$("#pwd").val()==''||$("#verify_code").val()==''){
                    popup.alert("填写完整方可登陆");
                    return false;
                }
                commonAjaxSubmit('','','',function(){
                    var newcode = $('.verify').attr('src');
                    $('.verify').attr('src',newcode+'?rand='+Math.random());
                    $('#verify_code').val('');
                });
            });
            $(".findPwd").click(function(){
                $("#op_type").val("2");
                if($("#email").val()==''){
                    popup.alert("填写了你的邮箱方可找回密码");
                    return false;
                }
                if($("#verify_code").val()==''){
                    popup.alert("请写验证码方可找回密码");
                    return false;
                }
                commonAjaxSubmit();
            });
        });
    </script>
</body>
</html>