<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>友情链接列表-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='广告管理 > 友情链接列表'; ?>
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
                            友情链接
                        </div>
                        <div class="search">
                            <a class="sbtn <?php if(($ico) == ""): ?>on<?php endif; ?>" href="<?php echo U('Link/index');?>">全部</a>
                            <a class="sbtn <?php if(($ico) == "1"): ?>on<?php endif; ?>" href="<?php echo U('Link/index',array('ico'=>'1'));?>">图标显示的</a>
                            <a class="sbtn <?php if(($ico) == "0"): ?>on<?php endif; ?>" href="<?php echo U('Link/index',array('ico'=>'0'));?>">图标不显示的</a>
                        </div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>(ID)</td>
                                <td>名称</td>
                                <td>图标</td>
                                <td>链接</td>
                                <td>图标显示</td>
                                <td width="130">排序</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["id"]); ?>">
                                <td align="left"><?php echo ($vo["id"]); ?></td>
                                <td align="left"><?php echo ($vo["name"]); ?></td>
                                <td>
                                <?php if(empty($vo["ico"])): ?>无
                                    <?php else: ?>
                                    <img src="<?php echo ($upWholeUrl); echo ($vo["ico"]); ?>" width="<?php echo C('LINK_ICO_WIDTH');?>" height="<?php echo C('LINK_ICO_HEIGHT');?>"><?php endif; ?>
                                
                                </td>
                                <td align="left"><?php echo ($vo["url"]); ?></td>
                                <td>
                                    <?php if(($vo["rec"]) == "0"): ?>不显示<?php endif; ?>
                                    <?php if(($vo["rec"]) == "1"): ?>显示<?php endif; ?>
                                </td>
                                <td>
                                    <div class="ajax_order">
                                        <a class="rising" href="javascript:void(0)">加</a>
                                        <span class="input" aid="<?php echo ($vo["id"]); ?>"><?php echo ($vo["sort"]); ?></span>
                                        <a class="drop" href="javascript:void(0)">减</a>
                                    </div>
                                </td>
                                <td>
                                    [ <a href="/Admin/Link/edit?id=<?php echo ($vo["id"]); ?>">编辑 </a> ]
                                    [ <a link="<?php echo U('Link/del',array('id'=>$vo['id']));?>" href="javascript:void(0)" name="<?php echo ($vo["name"]); ?>" class="del">删除 </a> ]
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
    var odUrl = "<?php echo U('Link/sort');?>"; //排序提交地址
    $(function(){
        //异步编辑排序字段
        $('.ajax_order a').on("click",function(){
            var odType = $(this).attr('class');
            var odShow = $(this).parents('.ajax_order').children('.input');
            var odVal = odShow.html();
            var odAid = odShow.attr('aid');
            $.post(odUrl,{'odType':odType,'odAid':odAid},function(data){      //ajax后台
                if (data.status) {
                    if(odType == 'rising'){
                        odShow.html(parseInt(odVal) + 1);
                    }else if(odType == 'drop'){
                        odShow.html(parseInt(odVal) - 1);
                    }
                    
                } else {
                    alert(data.msg);
                }
            },'json');        
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