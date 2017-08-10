<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "index"): ?>支付订单列表<?php endif; ?>
            <?php if((ACTION_NAME) == "search"): ?>支付订单搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php if(ACTION_NAME == 'index'){ $pagname = '支付订单列表'; }elseif(ACTION_NAME == 'search'){ $pagname = '支付订单搜索结果'; }; $currentNav ='支付管理 > '.$pagname; ?>
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
        <!-- 日期时间插件 -->
        <link rel="stylesheet" type="text/css" href="/Public/Js/datetimepicker/jquery.datetimepicker.css" />
        <script type="text/javascript" src="/Public/Js/datetimepicker/jquery.datetimepicker.js"></script>
        <!-- 日期时间插件 -->
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
                            <?php if((ACTION_NAME) == "index"): ?>支付订单列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search"): ?>支付订单搜索结果<?php endif; ?>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                            时间：
                                <input type="text" id="start_time"size="17" value="<?php echo ($keys["start_time"]); ?>" name="start_time" class="input"/> 至
                                <input type="text" id="end_time" size="17" value="<?php echo ($keys["end_time"]); ?>" name="end_time" class="input"/>
                                &nbsp;&nbsp;支付状态：
                                <select name="status">
                                    <option value="" <?php if(($keys[status]) == ""): ?>selected="selected"<?php endif; ?>>所有</option>
                                    <option value="0" <?php if(($keys[status]) == "0"): ?>selected="selected"<?php endif; ?>>未支付</option>
                                    <option value="1" <?php if(($keys[status]) == "1"): ?>selected="selected"<?php endif; ?>>已支付</option>
                                </select>
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab payType">
                        <thead>
                            <tr>
                                <td>支付单号</td>
                                <td>本站单号</td>
                                <td>用户账号</td>
                                <td>支付项</td>
                                <td>在线支付方式</td>
                                <td>支付金额</td>
                                <td>其他支付</td>
                                <td>订单更新时间</td>
                                <td>支付状态</td>
                                <td>操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($order)): foreach($order as $key=>$v): ?><tr align="center">
                                <td><?php echo ($v["bill_no"]); ?></td>
                                <td><?php echo ($v["order_no"]); ?></td>
                                <td><?php echo ($v["account"]); ?></td>
                                <td><?php echo ($v["purpose"]); ?></td>
                                <td align="left"><?php echo ($v["paytype"]); ?></td>
                                <td align="right"><?php echo ($v["money"]); ?></td>
                                <td>
                                    <?php if($v['yuemn'] == 0 and $v['pledge'] == 0): ?>无
                                    <?php else: ?>
                                        <?php if(($v["yuemn"]) != "0"): ?>余额支付：<?php echo ($v["yuemn"]); endif; ?>
                                        <?php if(($v["pledge"]) != "0"): ?>保证金支付：<?php echo ($v["pledge"]); endif; endif; ?>
                                    
                                </td>
                                <td><?php echo ($v["update_time"]); ?></td>
                                <td>
                                    <?php if(($v[status]) == "1"): ?>已支付<?php endif; ?>
                                    <?php if(($v[status]) == "0"): ?>未支付<?php endif; ?>
                                </td>
                                <td>[ <a href="/Admin/Payment/del?bill_no=<?php echo ($v["bill_no"]); ?>">删除</a> ]</td>
                            </tr><?php endforeach; endif; ?>
                        <tr>
                            <td colspan="20" align="right" class="page"><?php echo ($page); ?></td>
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
    </body>
</html>
<script type="text/javascript">
    //为input添加时间插件
    $('#start_time').datetimepicker({lang:'ch'});
    $('#end_time').datetimepicker({lang:'ch'});
    //为input添加插件_end
</script>