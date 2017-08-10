<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>推广反馈管理-用户管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='用户管理 > 推广反馈管理'; ?>
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
                        <div class="current">推广反馈管理</div>
                    </div>
                    <form action="" method="post" class="userInfo clearfix formConfl" id="quickForm">
                        <b class="fl thead">添加推广项：</b>
                        <input class="fl" type="hidden" name="act" value="add" /> &nbsp;
                        <input placeholder="你要添加的推广项" id="newName" class="input fl" type="text" name="data[name]" value="" /> &nbsp;
                        <button class="btn quickSubmit fl">确定添加</button>

                    </form>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                        <thead>
                            <tr align="center">
                                <td width="10%">ID</td>
                                <td width="15%" align="left">推广名</td>
                                <td width="15%" align="left">推广统计</td>
                                <td width="15%" align="left">操作属性</td>
                                <td width="15%">修改后的名称</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td align="center"><?php echo ($vo["id"]); ?><input type="hidden" name="id" value="<?php echo ($vo["id"]); ?>"/></td>
                                    <td align="center"><?php echo ($vo["name"]); ?></td>
                                    <td align="center"><?php echo ($vo["count"]); ?></td>
                                    <td align="center">
                                        <select name="act" class="act">
                                            <option selected="selected" value="edit">修改该项</option>
                                            <option value="del">删除该项</option>
                                        </select>
                                    </td>
                                    <td align="center"><input type="text" value="" name="name" class="input" placeholder="你要修改推广的新名称"/></td>
                                    <td align="center"><button class="btn opCat">确定</button></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <form action="" method="post" id="opForm">
            <input id="id" type="hidden" name="data[id]" />
            <input id="act" type="hidden" name="act" />
            <input id="name" type="hidden" name="data[name]" />
        </form>
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
        $(".opCat").click(function(){
            var obj=$(this).parents("tr");
            $("#id").val(obj.find("input[name='id']").val());
            $("#act").val(obj.find("select[name='act']").val());
            $("#name").val(obj.find("input[name='name']").val());
            if($("#act").val()=="del"){
                popup.confirm('你真的打算删除该项吗?','温馨提示',function(action){
                    if(action == 'ok'){
                        commonAjaxSubmit("","#opForm");
                    }
                });
                return false;
            }
            if($("#act").val()=="edit"){
                if(obj.find("input[name='name']").val()==''){
                    popup.alert("推广名称不能为空滴！");
                    return false;
                }
            }
            commonAjaxSubmit("","#opForm");
        });
        $(".quickSubmit").click(function(){
            if($("#newName").val()==''){
                popup.alert("推广名称不能为空滴！");
                return false;
            }
            commonAjaxSubmit("","#quickForm");
            return false;
        });
    });
</script>
    </body>
</html>