<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>网站注册会员管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='网站注册会员管理 > 会员列表'; ?>
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
		<script type="text/javascript" src="/Public/Js/jquery_raty/jquery.raty.min.js"></script>
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
                            <?php if((ACTION_NAME) == "index"): ?>用户列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search"): ?>搜索结果<?php endif; ?>
                        </div>
                       <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                            搜索字段：
                                <select name="field">
                                    <option value="account" <?php if(($keys["field"]) == "account"): ?>selected="selected"<?php endif; ?>>账号</option>
                                    <option value="nickname" <?php if(($keys["field"]) == "nickname"): ?>selected="selected"<?php endif; ?>>昵称</option>
                                    <option value="email" <?php if(($keys["field"]) == "email"): ?>selected="selected"<?php endif; ?>>邮箱</option>
                                    <option value="mobile" <?php if(($keys["field"]) == "mobile"): ?>selected="selected"<?php endif; ?>>手机</option>
                                </select>
                            &nbsp;&nbsp;关键字：
                                <input type="text" value="<?php echo ($keys["keyword"]); ?>" name="keyword" class="input" placeholder="搜索对应字段关键字" />
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <?php if((ACTION_NAME) == "search"): ?><div class="seamsg">
                            搜索的关键词<span class="keyword"><?php echo ($keys["keyword"]); ?></span>在<span class="keyword"><?php echo ($keys["field"]); ?></span>字段内找到<span class="keyword"><?php echo ($keys["count"]); ?></span>条
                        </div><?php endif; ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                        <tr>
                            <td width="5%">选择/UID</td>
                            <td width="15%">登录账号</td>
                            <td width="12%">昵称/买家等级</td>
                            <td width="15%">邮箱/手机号</td>
                            <td width="13%">买家等级</td>
                            <td width="13%">卖家等级/信誉</td>
                            <td width="10%">登录IP</td>
                            <td width="5%">地址薄</td>
                            <td width="20%">操作</td>
                        </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["id"]); ?>">
                                <td align="left"><input name="uid[]" type="checkbox" value="<?php echo ($vo["uid"]); ?>" >&nbsp;/&nbsp;<?php echo ($vo["uid"]); ?></td>
                                <td align="left">
                                    <img class="usimg" src="<?php echo (getuserpic($vo["uid"],2)); ?>" alt="" />
                                    <p>账号：<?php echo ($vo["account"]); ?></p>
                                    <p align="right"><a href="<?php echo U('Member/sendsms',array('uid'=>$vo['uid']));?>">[发站内信]</a></p>
                                </td>
                                <td align="left">
                                    昵称：<?php echo ($vo["nickname"]); ?><br/>性别：<?php if($vo['sex'] == 0): ?>女<?php else: ?>男<?php endif; ?>
                                </td>
                                <td align="left">
                                    邮箱：<?php echo ($vo["email"]); ?><br/>
                                    手机号：<?php echo ($vo["mobile"]); ?>
                                </td>
                                <td align="left"><img  style="vertical-align: middle;" src="<?php echo ($vo["levalbuy"]); ?>" /></td>
                                <td align="left">
                                    等级：<img  style="vertical-align: middle;" src="<?php echo ($vo["leval"]); ?>" /><br/>
                                    信誉：<span style="vertical-align: middle;" id="credit<?php echo ($key); ?>"></span>
                                    <script type="text/javascript">
                                        $(function(){
                                            $('#credit<?php echo ($key); ?>').raty({
                                                readOnly: true,
                                                score: Number("<?php echo ($vo["evaluate"]); ?>"),
                                                path : start_path
                                            });
                                        });
                                    </script>
                                </td>
                                <td><?php echo ($vo["login_ip"]); ?></td>
                                <td><a href="<?php echo U('Member/deliver_address',array('uid'=>$vo['uid']));?>"><?php echo ($vo["adcount"]); ?>个地址</a></td>
                                <td>[ <a href="/Admin/Member/edit?uid=<?php echo ($vo["uid"]); ?>">信息编辑 </a> ] [ <a href="/Admin/Member/wallet?uid=<?php echo ($vo["uid"]); ?>">账户编辑 </a> ] <br/>[ <a link="<?php echo U('Member/del/',array('uid'=>$vo['uid']));?>" href="javascript:void(0)" name="<?php echo ($vo["nickname"]); ?>" class="del">删除 </a> ]</td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="11"><div class="page"  style="width: 60%; text-align: right; float: right;"><?php echo ($page); ?></div></td>
                        </tr>
                    </table>
                    <div class="commonBtnArea" >
                    <label><input type="checkbox" id="allcbox" value="0">&nbsp;全选</label>
                        <input type="button" value="批量发送站内信" class="btn submit">
                    </div>
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
        var paylistUrl = "<?php echo U('Member/sendsms','','');?>";
        var start_path = "/Public/Js/jquery_raty/img";
        var paylistUrl = "<?php echo U('Member/sendsms','','');?>";
            $(function(){
                $("#allcbox").click(function() {
                    $('input[name="uid[]"]').prop("checked",this.checked);
                });
                var $subBox = $("input[name='uid[]']");
                $subBox.click(function(){
                    $("#allcbox").prop("checked",$subBox.length == $("input[name='uid[]']:checked").length ? true : false);
                });
                $(".submit").click(function(){
                    if($("input[name='uid[]']:checked").length!=0){
                        var str="";
                        for (var i=0;i<$("input[name='uid[]']").length;i++ ){
                            if($("input[name='uid[]']")[i].checked){
                                str=str+$("input[name='uid[]']")[i].value + "_";
                            }
                        }
                        str=str.substring(0,str.length-1);
                        document.location.href =paylistUrl+'?uid='+str;
                    }else{
                       popup.alert('您至少需要选中一个要处理的订单');
                        setTimeout(function(){
                            popup.close("asyncbox_alert");
                        },2000);
                    }
                    return false;
                });

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