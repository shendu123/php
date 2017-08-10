<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>微信图文列表-微信配置-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
        <?php $currentNav ='微信配置 > 微信图文列表'; ?>
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
    <div class="wrap"> <div id="Top">
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
        <div class="mainBody"> <div id="Left">
    <div id="control" class=""></div>
    <div class="subMenuList">
        <div class="itemTitle"><?php if(CONTROLLER_NAME == 'Index'): ?>常用操作<?php else: ?>子菜单<?php endif; ?> </div>
        <ul>
            <?php if(is_array($sub_menu)): foreach($sub_menu as $key=>$sv): ?><li><a href="<?php echo ($sv["url"]); ?>"><?php echo ($sv["title"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>

</div>
            <div id="Right">
                <div class="contentArea">
                    <div class="Item hr clearfix">
                        <div class="current">微信图文列表</div>
                    </div>
                    <div>由于微信规则，仅推送从微信公众账号进入本站时间不超48小时的用户！</div>
                    <form id="formObj">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                            <thead>
                                <tr align="center">
                                    <td width="3%">选择</td>
                                    <td width="5%">ID</td>
                                    <td width="15%">所属用户</td>
                                    <td width="15%">图文标题</td>
                                    <td>头条图片</td>
                                    <td>列表图片</td>
                                    <td>本站页面网址</td>
                                    <td width="20%">图文说明</td>
                                    <td width="10%">发送结果</td>
                                    <td width="10%">操作</td>
                                </tr>
                            </thead>
                            <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr align="center">
                                    <td style="vertical-align: middle;">
                                        <input name="wid[]" type="checkbox" value="<?php echo ($vo["id"]); ?>" >
                                    </td>
                                    <td><?php echo ($vo["id"]); ?></td>
                                    <td >
                                        <?php if(($vo["sellerid"]) == "0"): ?>网站
                                        <?php else: ?>
                                            <div class="clearfix" style="line-height: 22px; text-align: left;">
                                                <img class="usimg" src="<?php echo (getuserpic($vo["sellerid"],2)); ?>"/>
                                                <p class="fl">账号：<?php echo ($vo["seller"]["account"]); ?><br/>昵称：<?php echo ($vo["seller"]["nickname"]); ?></p>
                                            </div><?php endif; ?>
                                        
                                    </td>
                                    <td><?php echo ($vo["name"]); ?></td>
                                    <td><img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo ($vo["toppic"]); ?>" height="50px" /></td>
                                    <td><img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo ($vo["picture"]); ?>" height="50px" /></td>
                                    <td style="word-break:break-all;"><input class="input" type="text" size="30" value="<?php echo ($vo["url"]); ?>"></td>
                                    <td align="left">
                                        <?php if(($vo["type"]) == "auction"): ?>图文类型：拍卖图文<br/><?php endif; ?>
                                        <?php if(($vo["type"]) == "admin"): ?>图文类型：管理员添加<br/><?php endif; ?>
                                        图文描述：<?php echo ($vo["comment"]); ?></td>
                                    <td>成功：<?php echo ($vo["succount"]); ?>条<br/>失败：<?php echo ($vo["errcount"]); ?>条</td>
                                    <td>[ <a href="/Admin/Weixin/editurl?id=<?php echo ($vo["id"]); ?>">修改</a> ][ <a link="<?php echo U('Weixin/delurl',array('id'=>$vo['id']));?>" href="javascript:void(0)" name="<?php echo ($vo["name"]); ?>" class="del">删除 </a> ]</td>
                                </tr><?php endforeach; endif; ?>
                            <tr>
                                <td valign="middle" align="center" >
                                    
                                </td>
                                <td colspan="20" align="right" class="page"><?php echo ($page); ?></td>
                            </tr>
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <label class="boderb"><input type="checkbox" id="allcbox" value="0">全选</label>
                        <button class="btn submit">发送图文</button>
                    </div>
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
    $(function(){
        var weipush = "<?php echo U('Weixin/weipush');?>";
        $(".submit").click(function(){
            popStatus(3, '正在提交数据至微信，请等待...', 0,'',true);
            commonAjaxSubmit(weipush,formObj,{"type":'image-text'},'');
            return false;
        });


         $("#allcbox").click(function() {
            $('input[name="wid[]"]').prop("checked",this.checked);
        });
        var $subBox = $("input[name='wid[]']");
        $subBox.click(function(){
            $("#allcbox").prop("checked",$subBox.length == $("input[name='wid[]']:checked").length ? true : false);
        });





        $(".del").click(function(){
            var delLink=$(this).attr("link");
            popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】这条图文吗?','温馨提示',function(action){
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