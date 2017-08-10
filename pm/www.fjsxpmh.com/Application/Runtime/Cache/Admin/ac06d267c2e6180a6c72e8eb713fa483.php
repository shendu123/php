<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>频道、分类与条件关联-商品管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='商品管理 > 频道、分类与条件关联'; ?>
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
                        <div class="current">频道、分类与条件关联</div>
                    </div>
                    <form action="" method="post" class="userInfo formConfl" id="quickForm">
                        <b class="thead">添加关联：</b>
                        <input type="hidden" name="act" value="add" /> &nbsp;
                        <select name="data[cid]">
                            <option value="0">所有频道</option>
                            <?php if(is_array($cate)): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["fullname"]); if(($vo[pid]) == "0"): ?>--&lt;频道&gt;<?php endif; ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select><---&nbsp;关联&nbsp;--->
                        <select name="data[fid]">
                            <option value="0">顶级条件</option>
                            <?php if(is_array($filt)): $i = 0; $__LIST__ = $filt;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["fid"]); ?>"><?php echo ($vo["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>  &nbsp;

                        <button class="btn quickSubmit">确定关联</button>

                    </form>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                        <thead>
                            <tr align="center">
                                <td width="10%">商品分类</td>
                                <td width="80%">筛选条件</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($map)): foreach($map as $key=>$vo): ?><tr>
                                    <td><?php echo (catename($vo["cid"])); ?></td>
                                    <td>
                                        <div class="sellfiltbox">
                                            <?php if(is_array($vo['fid'])): foreach($vo['fid'] as $k=>$v): ?><ul class="clearfix plus">
                                                    <li><span><?php echo (filtname($v)); ?>:</span></li>
                                                    <?php if(is_array($vo['sid'][$k])): foreach($vo['sid'][$k] as $k1=>$v1): ?><li><a class="filtParent" fid="<?php echo ($v1); ?>" href="javascript:void(0);"><?php echo (filtname($v1)); ?>
                                                        <?php if(countChild($v1) != 0): ?>(<?php echo (countchild($v1)); ?>)<?php endif; ?>
                                                        </a></li><?php endforeach; endif; ?>
                                                    <li class="btnBox">
                                                        <div class="delLinkBox" >[ <a class="delLinkBtn" href="javascript:void(0);" cid="<?php echo ($vo["cid"]); ?>" fid="<?php echo ($v); ?>">解除关联</a> ]</div>
                                                    </li>
                                                </ul><?php endforeach; endif; ?>
                                        </div>
                                    <td align="center">
                                    [ <a class="delLinkBtn" href="javascript:void(0);" cid="<?php echo ($vo["cid"]); ?>" fid="0">解除关联</a> ]
                                    </td>
                                </tr><?php endforeach; endif; ?>
                        </tbody>
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
        // 点击获取子级条件
        var getChildUrl = "<?php echo U('Goods/getChild');?>";
        $('.sellfiltbox').on('click','.filtParent',function(){
            var filtFid = $(this).attr('fid');
            var newFilt = $(this).parents('ul');
            if(newFilt.next('.filtLi').attr('fid') != filtFid){ //判断是否已经加载过子条件，加载过不在请求
               newFilt.find('.filtParent').removeClass('current');
                $(this).addClass('current');
                newFilt.next('.filtLi').remove();
                $.post(getChildUrl,{'fid':filtFid},function(data){      //ajax后台
                    if (data.status) {
                        newFilt.after(data.msg);
                    } else {
                        alert(data.msg);
                    }
                },'json'); 
            }
        });
        // 删除关联
        var delLinkUrl = "<?php echo U('Goods/delLink');?>";
        $('tr').on('click','.delLinkBtn',function(){
            var delFid = $(this).attr('fid');
            var delCid = $(this).attr('cid');
            var thisObj = $(this);
            $.post(delLinkUrl,{'fid':delFid,'cid':delCid},function(data){
                if(data.status){
                    if(delFid == 0){
                        thisObj.parents('tr').remove();
                    }else{
                        if(thisObj.parents('.sellfiltbox').children('ul').length == 1){
                            thisObj.parents('tr').remove();
                        } else {
                            thisObj.parents('ul').remove();
                        }
                    }
                    shortBox(data.msg,data.status);
                } else {
                    shortBox(data.msg,data.status);
                }
            });
        });
        // 短暂提示框
        function shortBox(msg,yn){
            if(yn == 1){
                popup.success(msg);
            } else {
                popup.error(msg);
            }
            setTimeout(function(){
                popup.close("asyncbox_success");
            },1000);
        }
        // 提交添加关联

        $(".quickSubmit").click(function(){
            commonAjaxSubmit("","#quickForm");
            return false;
        });
    });
</script>
    </body>
</html>