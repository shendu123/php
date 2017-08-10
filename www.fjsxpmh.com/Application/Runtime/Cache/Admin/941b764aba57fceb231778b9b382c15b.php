<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            用户账户记录-<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php $currentNav ='用户账户记录'; ?>
        <meta name="viewport" content="width=1200,initial-scale=1.0"/>
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="edge" />
<base href="<?php echo ($site["WEB_ROOT"]); ?>"/>
<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/layout.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Css/pop_status.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/asyncbox/skins/default.css" />
<script type="text/javascript" src="/Public/Js/jquery-1.9.0.min.js"></script>
<script type="text/javascript" src="/Public/Js/pop_status.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script>
<script type="text/javascript" src="/Public/Admin/Js/base.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Js/asyncbox/asyncbox.js"></script>
    </head>
    <body>
        <div class="wrap">
            <div id="Top">
    <div class="logo"><a href="<?php echo ($site["WEB_ROOT"]); ?>"><img src="/Public/Admin/Img/logo.gif" /></a></div>
    <div class="help"><a target="_blank" href="http://www.oncoo.net">使用帮助</a><span><a target="_blank" href="http://oncoo.net">关于</a></span></div>
    <div class="menu">
        <ul> <?php echo ($menu); ?> </ul>
    </div>
</div>
<div id="Tags">
    <div class="userPhoto"><img src="/Public/Admin/Img/userPhoto.jpg" /> </div>
    <div class="navArea">
        <div class="userInfo">
            <div>
                <a href="<?php echo U('Webinfo/index');?>" class="sysSet"><span>&nbsp;</span>系统设置</a>
                <a href="<?php echo U("Public/loginOut");?>" class="loginOut"><span>&nbsp;</span>退出系统</a>
            </div>
            欢迎您，<?php echo ($my_info["email"]); ?>
        </div>
        <div class="nav"><font id="today"><?php echo date("Y-m-d H:i:s"); ?></font>您的位置：<?php echo ($currentNav); ?></div>
    </div>
</div>
<div class="clear"></div>
            <div class="mainBody">
                <div id="Left">
    <div id="control" class=""></div>
    <div class="subMenuList">
        <div class="itemTitle"><?php if(CONTROLLER_NAME == 'Index'): ?>常用操作<?php else: ?>子菜单<?php endif; ?> </div>
        <ul>
            <?php if(is_array($sub_menu)): foreach($sub_menu as $key=>$sv): ?><li><a href="<?php echo ($sv["url"]); ?>"><?php echo ($sv["title"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>

</div>
                <div id="Right">
                    <div class="Item hr clearfix">
                        <div class="current fl">
                            用户账户记录
                        </div>
                        <div class="fl">
                            <a class="sbtn <?php if(($wallet) == "pledge"): ?>on<?php endif; ?>" href="<?php echo U('Member/walletbill',array('wallet'=>'pledge'));?>">余额记录</a>
                            <a class="sbtn <?php if(($wallet) == "limsum"): ?>on<?php endif; ?>" href="<?php echo U('Member/walletbill',array('wallet'=>'limsum'));?>">信用记录</a>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('Member/walletbill');?>" method='get'>
                                开始时间：<input id="start_time" size="15" type="text" value="<?php echo ($keys["start_time"]); ?>" name="start_time" class="input" placeholder="默认为建站时间" />&nbsp;&nbsp;
                                结束时间：<input id="end_time" size="15" type="text" value="<?php echo ($keys["end_time"]); ?>" name="end_time" class="input" placeholder="默认为当前时间" />&nbsp;&nbsp;
                                单号：<input type="text" size="10" value="<?php echo ($keys["order_no"]); ?>" name="order_no" class="input" placeholder="搜索单号" />
                                &nbsp;&nbsp;
                                用户账号：<input type="text" size="10" value="<?php echo ($keys["account"]); ?>" name="account" class="input" placeholder="用户账号" />
                                &nbsp;&nbsp;
                                类型：
                                <select name="changetype">
                                    <option value="" <?php if(($keys["changetype"]) == ""): ?>selected="selected"<?php endif; ?>>全部</option>
                                    <?php if(is_array($changetype)): foreach($changetype as $key=>$cv): ?><option value="<?php echo ($key); ?>" <?php if(($keys["changetype"]) == $key): ?>selected="selected"<?php endif; ?>><?php echo ($cv); ?></option><?php endforeach; endif; ?>
                                </select>
                                <input type="hidden" name="wallet" value="<?php echo ($wallet); ?>" />
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                        
                    </div>
                    
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="10%">单号</td>
                                <td width="15%">所属用户</td>
                                <td width="10%">类型</td>
                                <td width="10%">收入</td>
                                <td width="10%">支出</td>
                                <td width="20%">说明</td>
                                <td width="5%">时间</td>
                            </tr>
                        </thead>
                        <?php if(empty($list)): ?><tr><td colspan="10">哎哟！什么也没有！</td></tr>
                        <?php else: ?> 
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center">
                                    <td align="left"><?php echo ($vo["order_no"]); ?></td>
                                    <td align="left">
                                        <div class="ushow">
                                            <img class="usimg" src="<?php echo (getuserpic($vo["sellerid"],2)); ?>" alt="" />
                                            <p class="fl">账号：<?php echo ($vo["account"]); ?><br/>昵称：<?php echo ($vo["nickname"]); ?></p>
                                        </div>
                                    </td>
                                    <td><?php echo changetype($vo['changetype']);?></td>
                                    <td><?php echo ($vo["income"]); ?></td>
                                    <td><?php echo ($vo["expend"]); ?></td>
                                    <td align="left"><?php echo ($vo["annotation"]); ?></td>
                                    <td><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            <tr>
                                <td colspan="20"><div class="page"  style="width: 60%; text-align: right; float: right;"><?php echo ($page); ?></div></td>
                            </tr><?php endif; ?>
                        
                    </table>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <script type="text/javascript">
    $(window).resize(autoSize);
    $(function(){
        autoSize();
        $(".loginOut").click(function(){
            var url=$(this).attr("href");
            popup.confirm('你确定要退出吗？','你确定要退出吗',function(action){
                if(action == 'ok'){ window.location=url; }
            });
            return false;
        });

        var time=self.setInterval(function(){$("#today").html(date("Y-m-d H:i:s"));},1000);


    });

</script>
    </body>
<!-- 日期时间插件 -->
<link rel="stylesheet" type="text/css" href="/Public/Js/datetimepicker/jquery.datetimepicker.css" />
<script type="text/javascript" src="/Public/Js/datetimepicker/jquery.datetimepicker.js"></script>
<!-- 日期时间插件 -->
<script type="text/javascript">
    //为input添加时间插件
    $('#start_time').datetimepicker({lang:'ch'});
    $('#end_time').datetimepicker({lang:'ch'});
</script>
</html>