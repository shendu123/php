<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            提现申请
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php $currentNav ='首页 > 提现申请'; ?>
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
                        <div class="current">
                            提现申请列表
                        </div>
                        <div class="search">
                        <a href="<?php echo U('Index/take');?>" class="sbtn <?php if(($sw) == ""): ?>on<?php endif; ?>">全部</a>
                            <a href="<?php echo U('Index/take',array('sw'=>0));?>" class="sbtn <?php if(($sw) == "0"): ?>on<?php endif; ?>">未处理</a>
                            <a href="<?php echo U('Index/take',array('sw'=>1));?>" class="sbtn <?php if(($sw) == "1"): ?>on<?php endif; ?>">已转账</a>
                            <a href="<?php echo U('Index/take',array('sw'=>2));?>" class="sbtn <?php if(($sw) == "2"): ?>on<?php endif; ?>">已驳回</a>
                        </div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="10%">用户账号</td>
                                <td width="10%">提现金额</td>
                                <td width="25%">收款账户</td>
                                <td width="15%">备注</td>
                                <td width="10%">申请时间</td>
                                <td width="20%">状态</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <?php if(empty($take_list)): ?><tr><td colspan="7">哎哟！这里空空如也</td></tr>
                        <?php else: ?>
                            <?php if(is_array($take_list)): $i = 0; $__LIST__ = $take_list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["id"]); ?>">
                                    <td align="left"><?php echo ($vo["uaccount"]); ?></td>
                                    <td><?php echo ($vo["money"]); ?></td>
                                    <td>
                                        <ul class="bankinfo">
                                            <li class="clearfix"><div class="th">银行：</div><div class="td"><?php echo ($vo["bank"]); ?></div></li>
                                            <li class="clearfix"><div class="th">开户行：</div><div class="td"><?php echo ($vo["bankhome"]); ?></div></li>
                                            <li class="clearfix"><div class="th">姓名：</div><div class="td"><?php echo ($vo["name"]); ?></div></li>
                                            <li class="clearfix"><div class="th">账号：</div><div class="td"><?php echo ($vo["account"]); ?></div></li>
                                        </ul>
                                    </td>
                                    <td align="left"><?php echo ($vo["remark"]); ?></td>
                                    <td><?php echo (date('Y-m-d H:i',$vo["time"])); ?></td>
                                    <td>
                                        <?php if(($vo["status"]) == "0"): ?><span class="striking s2">等待提现</span><?php endif; ?>
                                            <?php if(($vo["status"]) == "1"): ?><span class="striking s2">已转账</span>
                                            <div class="tl">
                                            时间：<?php echo (date('Y-m-d H:i',$vo["dtime"])); ?><br>
                                            回复：<?php echo ($vo["cause"]); ?>
                                            </div><?php endif; ?>
                                            <?php if(($vo["status"]) == "2"): ?><span class="striking s1">被驳回</span>
                                            <div class="tl">
                                            时间：<?php echo (date('Y-m-d H:i',$vo["dtime"])); ?><br>
                                            原因：<?php echo ($vo["cause"]); ?>
                                            </div><?php endif; ?>
                                    </td>
                                    <td>
                                    <?php if(($vo["status"]) == "0"): ?>[ <a href="<?php echo U('Index/take',array('tid'=>$vo[tid]));?>">回复申请 </a> ]<?php else: ?>无<?php endif; ?>
                                        
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>

                            <tr>
                                <td colspan="7" align="right" class="page"><?php echo ($page); ?></td>
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
        <script type="text/javascript">
            $(function(){
                $(".del").click(function(){
                    var delLink=$(this).attr("link");
                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                        if(action == 'ok'){
                            top.window.location.href=delLink;
                        }
                    });
                    return false;
                });
            });
        </script>
    </body>
</html>