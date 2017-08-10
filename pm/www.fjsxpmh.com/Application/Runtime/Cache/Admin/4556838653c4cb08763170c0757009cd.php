<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "webmail"): ?>站内信列表<?php endif; ?>
            <?php if((ACTION_NAME) == "search_sms"): ?>站内信搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php if(ACTION_NAME == 'webmail'){ $pagname = '站内信列表'; }elseif(ACTION_NAME == 'search_sms'){ $pagname = '搜索结果'; }; $currentNav ='注册用户管理 > '.$pagname; ?>
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
                            <?php if((ACTION_NAME) == "webmail"): ?>站内信列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search_sms"): ?>搜索结果<?php endif; ?>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search_sms');?>" method='get'>
                            消息类型：
                            <select name="tp">
                                <option value="0" <?php if(($keys["tp"]) == "0"): ?>selected="selected"<?php endif; ?>>系统-->用户</option>
                                <option value="1" <?php if(($keys["tp"]) == "1"): ?>selected="selected"<?php endif; ?>>管理员-->用户</option>
                            </select>
                            发送者：<input type="text" value="<?php echo ($keys["ho"]); ?>" name="ho" class="input" placeholder="发送者账号" />&nbsp;&nbsp;
                            接受者：<input type="text" value="<?php echo ($keys["to"]); ?>" name="to" class="input" placeholder="接受者账号" />
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <?php if((ACTION_NAME) == "search_sms"): ?><div class="seamsg">
                            找到关于<span class="keyword"><?php echo ($keys["ho"]); ?></span>和<span class="keyword"><?php echo ($keys["to"]); ?></span>的会话<span class="keyword"><?php echo ($keys["count"]); ?></span>条记录！
                        </div><?php endif; ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>SID</td>
                                <td>发送者</td>
                                <td>接受者</td>
                                <td width="45%">内容</td>
                                <td>状态</td>
                                <td>发送时间</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["sid"]); ?>">
                                <td align="left"><?php echo ($vo["sid"]); ?></td>
                                <td align="left"><?php echo ($vo["ho"]); ?></td>
                                <td align="left"><?php echo ($vo["to"]); ?></td>
                                <td align="left"><?php echo ($vo["content"]); ?></td>
                                <td>
                                    <?php if(($vo["status"]) == "0"): ?>未读<?php endif; ?>
                                    <?php if(($vo["status"]) == "1"): ?>已读<?php endif; ?>
                                    <?php if(($vo["delmark"]) == "1"): ?>已设为删除<?php endif; ?>
                                </td>
                                <td><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
                                <td>
                                [ <a href="javascript:void(0)" sid="<?php echo ($vo["sid"]); ?>" delmark="<?php if(($vo["delmark"]) == "1"): ?>1<?php else: ?>0<?php endif; ?>" class="ac-setdel"><?php if(($vo["delmark"]) == "1"): ?>取消删除<?php else: ?>设置删除<?php endif; ?></a> ]


                                [ <a link="<?php echo U('Member/delsms/',array('sid'=>$vo['sid']));?>" name="是否设置该条信息的删除" href="javascript:void(0)"  class="del">删除</a> ]
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="7" align="right" class="page"><?php echo ($page); ?></td>
                        </tr>
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
        var setdelUrl = "<?php echo U('Member/setdelsms');?>"
            $(function(){

                // 设置删除
                $(".ac-setdel").click(function(){
                    var thisObj = $(this)
                    var sid = $(this).attr('sid');
                    var delmark = $(this).attr('delmark');
                    $.post(setdelUrl,{'sid':sid,'delmark':delmark},function(data){      //ajax后台
                        if (data.status) {
                            popup.success(data.msg);

                            if(delmark==1){
                                thisObj.html('设置删除'); 
                                thisObj.attr('delmark',0);
                            }else{
                                thisObj.html('取消删除'); 
                                thisObj.attr('delmark',1);
                            }


                            setTimeout(function(){
                                popup.close("asyncbox_success");
                            },1000);
                        } else {
                            alert(data.msg);
                        }
                    },'json');
                });
                // 删除消息
                $(".del").click(function(){
                    var delLink=$(this).attr("link");
                    popup.confirm($(this).attr("name"),'温馨提示',function(action){
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