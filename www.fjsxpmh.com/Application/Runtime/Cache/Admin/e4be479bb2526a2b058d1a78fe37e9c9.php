<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php if((ACTION_NAME) == "index"): ?>广告列表<?php endif; ?>
            <?php if((ACTION_NAME) == "search"): ?>筛选结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php if(ACTION_NAME == 'index'){ $pagname = '商品列表'; }elseif(ACTION_NAME == 'search'){ $pagname = '筛选结果'; }; $currentNav ='广告管理 > '.$pagname; ?>
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
                            <?php if((ACTION_NAME) == "index"): ?>广告列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search"): ?>筛选结果<?php endif; ?>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                                广告位：
                                <select name="id">
                                    <option value="">==所有广告位==</option>
                                    <?php if(is_array($search)): $i = 0; $__LIST__ = $search;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[id] == $keys[id]): ?><option value="<?php echo ($vo["id"]); ?>" selected="selected"><?php echo ($vo["name"]); ?></option>
                                            <?php else: ?>
                                            <option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                &nbsp;&nbsp;广告类型：
                                <select id="advType" name="type">
                                    <option value="" <?php if(empty($keys[type])): ?>selected="selected"<?php endif; ?>>==所有类型==</option>

                                    <option value="1" <?php if(($keys[type]) == "1"): ?>selected="selected"<?php endif; ?>>图片广告</option>
                                    <option value="2" <?php if(($keys[type]) == "2"): ?>selected="selected"<?php endif; ?>>Flash广告</option>
                                    <option value="3" <?php if(($keys[type]) == "3"): ?>selected="selected"<?php endif; ?>>自定义代码广告</option>
                                </select>
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td>(ID)</td>
                                <td>广告名称</td>
                                <td>广告类型</td>
                                <td>广告位置</td>
                                <td width="130">排序</td>
                                <td width="150">操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" id="<?php echo ($vo["id"]); ?>">
                                <td align="left"><?php echo ($vo["id"]); ?></td>
                                <td align="left"><?php echo ($vo["name"]); ?></td>
                                <td><?php echo (getadvtype($vo["type"])); ?></td>
                                <td><?php echo ($vo["position"]); ?></td>
                                <td>
                                    <div class="ajax_order">
                                        <a class="rising" href="javascript:void(0)">加</a>
                                        <span class="input" aid="<?php echo ($vo["id"]); ?>"><?php echo ($vo["sort"]); ?></span>
                                        <a class="drop" href="javascript:void(0)">减</a>
                                    </div>
                                </td>
                                <td>
                                    [ <a class="forbid" href="javascript:void(0)" aid="<?php echo ($vo["id"]); ?>" forType="<?php echo ($vo["status"]); ?>" ><?php if(($vo[status]) == "1"): ?>禁用<?php endif; if(($vo[status]) == "0"): ?>恢复<?php endif; ?> </a> ]
                                    [ <a href="/Admin/Advertising/edit_advertising?id=<?php echo ($vo["id"]); ?>">编辑 </a> ]
                                    [ <a link="<?php echo U('Advertising/del_advertising/',array('id'=>$vo['id']));?>" href="javascript:void(0)" name="<?php echo ($vo["name"]); ?>" class="del">删除 </a> ]
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="6" align="right" class="page"><?php echo ($page); ?></td>
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
    var odUrl = "<?php echo U('Advertising/order_advertising');?>"; //排序提交地址
    var forUrl = "<?php echo U('Advertising/forbid');?>"; //禁用提交地址
        $(function(){
            $('.forbid').on("click",function(){
            var forType = $(this).attr('forType');
            var forAid = $(this).attr('aid');
            var forObj = $(this);
            $.post(forUrl,{'forType':forType,'forAid':forAid},function(data){      //ajax后台
                if (data.status) {
                    if(data.type == '1'){
                        forObj.html('恢复');
                        forObj.attr('forType',0);
                    }else if(data.type == '0'){
                        forObj.html('禁用');
                        forObj.attr('forType',1);
                    }
                } else {
                    alert(data.msg);
                }
            },'json');        
        });
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