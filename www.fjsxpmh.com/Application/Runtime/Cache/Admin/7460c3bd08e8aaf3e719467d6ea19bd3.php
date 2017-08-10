<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "index"): ?>商品列表<?php endif; ?>
            <?php if((ACTION_NAME) == "search"): ?>搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php if(ACTION_NAME == 'index'){ $pagname = '商品列表'; }elseif(ACTION_NAME == 'search'){ $pagname = '搜索结果'; }; $currentNav ='商品管理 > '.$pagname; ?>
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
                            <?php if((ACTION_NAME) == "index"): ?>商品列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search"): ?>搜索结果<?php endif; ?>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                            关键字：
                                <input type="text" value="<?php echo ($keys["keyword"]); ?>" name="keyword" class="input" placeholder="搜索标题的关键字" />
                                &nbsp;&nbsp;频道：
                                <select name="pid">
                                    <option value="">所有频道</option>
                                    <?php if(is_array($channel)): $i = 0; $__LIST__ = $channel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[cid] == $keys[pid]): ?><option value="<?php echo ($vo["cid"]); ?>" selected="selected"><?php echo ($vo["name"]); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <?php if((ACTION_NAME) == "search"): ?><div class="seamsg">
                            在<span class="keyword"><?php echo ($keys["chname"]); ?></span>频道的<span class="keyword"><?php echo ($keys["catname"]); ?></span>分类下找到<span class="keyword"><?php echo ($keys["count"]); ?></span>个<?php if($keys['keyword'] != ''): ?>与<span class="keyword"><?php echo ($keys["keyword"]); ?></span>相关的<?php endif; ?>商品！
                        </div><?php endif; ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="5%">ID</td>
                                <td >商品名称</td>
                                <td width="8%">频道/分类</td>
                                <td width="7%">发布时间</td>
                                <td width="15%">所属用户</td>
                                <td width="10%">已发布</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["id"]); ?>">
                                <td align="left"><?php echo ($vo["id"]); ?></td>
                                <td align="left">
                                <img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo (picrep($vo["pimg"],3)); ?>" width="50px" /><?php echo ($vo["title"]); ?>
                                </td>
                                <td align="left"><?php echo ($vo["pidName"]); ?>-><?php echo ($vo["cidName"]); ?></td>
                                <td><?php echo (date("Y-m-d H:i:s",$vo["published"])); ?></td>
                                <td align="left">
                                    <div class="ushow">
                                        <img class="usimg" src="<?php echo (getuserpic($vo["sellerid"],2)); ?>" alt="" />
                                        <p class="fl">账号：<?php echo ($vo["seller"]["account"]); ?><br/>昵称：<?php echo ($vo["seller"]["nickname"]); ?></p>
                                    </div>
                                </td>
                                <td align="left">拍卖：<a href="<?php echo U('Auction/search',array('gid'=>$vo[id]));?>"><?php echo ($vo["bidcount"]); ?>件</a></td>
                                <td>[ 发布拍卖到 <a href="<?php echo U('Auction/add',array('to'=>js,'gid'=>$vo['id']));?>">单品拍</a> <a href="<?php echo U('Auction/add',array('to'=>zc,'gid'=>$vo['id']));?>">专场拍</a> <a href="<?php echo U('Auction/add',array('to'=>pmh,'gid'=>$vo['id']));?>">拍卖会</a>]<br>[ <a href="/Admin/Goods/edit?id=<?php echo ($vo["id"]); ?>">编辑 </a> ] [ <a link="<?php echo U('Goods/del_goods/',array('id'=>$vo['id']));?>" href="javascript:void(0)" name="<?php echo ($vo["title"]); ?>" class="del">删除 </a> ]</td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="8" align="right" class="page"><?php echo ($page); ?></td>
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
            var formUrl ="<?php echo U('Goods/search');?>";
            var getCateUrl ="<?php echo U('Goods/getcate');?>";
            var catePid = '<?php echo ($keys["pid"]); ?>';
            var selectObj = $('select[name=pid]');
            // 频道select事件
            selectObj.on("change",function(){
                var pid = $(this).children('option:selected').attr('value');
                getCateHtml(pid,$(this));
            });
            // 获取分类select的html
            function getCateHtml(cheCid,selectObj){
               $.post(getCateUrl,{'pid':cheCid},function(data){      //ajax后台
                if (data.status) {
                        selectObj.next('#cid_select').remove();
                        selectObj.after(data.htm);
                    } else {
                        alert(data.msg);
                    }
                },'json');
            }
            $(function(){
                getCateHtml(catePid,selectObj)
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