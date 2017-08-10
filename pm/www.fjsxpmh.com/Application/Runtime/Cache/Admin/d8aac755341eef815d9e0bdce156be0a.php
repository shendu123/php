<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>扩展字段、默认值-商品配置-商品管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='商品管理 > 商品配置 > 扩展字段、默认值'; ?>
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
                    <div class="Item hr clearfix clearfix">
                        <div class="current fl">扩展字段、默认值</div>
                        <a href="<?php echo U('Goods/fields_add');?>" class="btn fr">添加扩展字段</a>
                    </div>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                        <thead>
                            <tr align="center">
                                <td width="10%">字段名</td>
                                <td width="55%">描述</td>
                                <td width="10%">排序</td>
                                <td width="20%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>*<strong>地区</strong></td>
                                <td class="region">
                                    <?php echo W('Home/Oncoo/region',array(0,0,0,3));?>
                                    系统内置字段扩展，可用于商品的筛选。
                                </td>
                                <td align="center">
                                    无
                                </td>
                                <td>
                                    <div class="clearfix">
                                        <div val="0" act="<?php if($gdcof["goods_region"] == 0): ?>act<?php endif; ?>" kTit="goods_region" class="region_check checkIco clearfix">
                                            <div class="fl hd_ico <?php if($gdcof["goods_region"] == 0): ?>act<?php endif; ?>"></div>
                                            <div class="fl">不启用</div>
                                        </div>
                                        <div val="1" act="<?php if($gdcof["goods_region"] == 1): ?>act<?php endif; ?>" kTit="goods_region" class="region_check checkIco clearfix">
                                            <div class="fl hd_ico <?php if($gdcof["goods_region"] == 1): ?>act<?php endif; ?>"></div>
                                            <div class="fl">一级</div>
                                        </div>
                                        <div val="2" act="<?php if($gdcof["goods_region"] == 2): ?>act<?php endif; ?>" kTit="goods_region" class="region_check checkIco clearfix">
                                            <div class="fl hd_ico <?php if($gdcof["goods_region"] == 2): ?>act<?php endif; ?>"></div>
                                            <div class="fl">二级</div>
                                        </div>
                                        <div val="3" act="<?php if($gdcof["goods_region"] == 3): ?>act<?php endif; ?>" kTit="goods_region" class="region_check checkIco clearfix">
                                            <div class="fl hd_ico <?php if($gdcof["goods_region"] == 3): ?>act<?php endif; ?>"></div>
                                            <div class="fl">三级</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>*<strong>商品详情</strong></td>
                                <td class="region">
                                    系统内置字段，可设默认值，默认值可作为文本模板，方便内容编辑。
                                </td>
                                <td align="center">无</td>
                                <td>
                                    [<a href="<?php echo U('Goods/fields_describe');?>">编辑</a>]
                                </td>
                            </tr>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($vo["name"]); ?></td>
                                    <td class="region">
                                        富文本编辑内容，可设置默认值，默认值可作为文本模板，方便内容编辑。仅用于显示。
                                    </td>
                                    <td>
                                        <div class="ajax_order" style="margin: 0px auto; text-align: center;">
                                            <a href="javascript:void(0)" class="rising">加</a>
                                            <span aid="<?php echo ($vo["eid"]); ?>" class="input"><?php echo ($vo["rank"]); ?></span>
                                            <a href="javascript:void(0)" class="drop">减</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="fl onOffBox">
                                                <div val="0" act="<?php if($vo["status"] == 0): ?>act<?php endif; ?>" eid="<?php echo ($vo["eid"]); ?>" class="onOff checkIco clearfix">
                                                    <div class="fl hd_ico <?php if($vo["status"] == 0): ?>act<?php endif; ?>"></div>
                                                    <div class="fl">不启用</div>
                                                </div>
                                                <div val="1" act="<?php if($vo["status"] == 1): ?>act<?php endif; ?>" eid="<?php echo ($vo["eid"]); ?>" class="onOff checkIco clearfix">
                                                    <div class="fl hd_ico <?php if($vo["status"] == 1): ?>act<?php endif; ?>"></div>
                                                    <div class="fl">启用</div>
                                                </div>
                                            </div>
                                            
                                            <div class="fr">
                                                [<a href="<?php echo U('Goods/fields_add',array('eid'=>$vo[eid]));?>">编辑</a>]
                                                [<a link="<?php echo U('Goods/delField/',array('id'=>$vo['eid']));?>" href="javascript:void(0)" name="<?php echo ($vo["name"]); ?>" class="del">删除</a>]
                                                
                                            </div>
                                        </div>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
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
    
    var odUrl = "<?php echo U('Goods/order_fields');?>"; //异步排序提交地址
    var onOffUrl = "<?php echo U('Goods/onOff_fields');?>"; //异步设置字段开启关闭URL
    var setRegionUrl= "<?php echo U('Goods/region_fields');?>"; ////异步设置区域字段URL
    $(function(){
        // 异步设置区域字段
        $('.region_check').click(function(){
            var thisObj = $(this);
            var kTit=thisObj.attr('kTit');
            var vl=thisObj.attr('val');
            var act=thisObj.attr('act');
            if(act == ''){
                $.post(setRegionUrl,{'key':kTit,'val':vl},function(data){      //ajax后台
                    if (data.status) {
                        thisObj.siblings('.region_check').attr('act','');
                        thisObj.siblings('.region_check').children('.hd_ico').removeClass('act');
                        thisObj.attr('act','act');
                        thisObj.children('.hd_ico').addClass('act');
                    } else {
                        alert(data.msg);
                    }
                },'json');
            }
        });
        // 异步开启关闭字段
        $('.onOff').click(function(){
            var thisObj = $(this);
            var id=thisObj.attr('eid');
            var vl=thisObj.attr('val');
            var act=thisObj.attr('act');
            if(act == ''){
                $.post(onOffUrl,{'eid':id,'val':vl},function(data){      //ajax后台
                    if (data.status) {
                        thisObj.siblings('.onOff').attr('act','');
                        thisObj.siblings('.onOff').children('.hd_ico').removeClass('act');
                        thisObj.attr('act','act');
                        thisObj.children('.hd_ico').addClass('act');
                    } else {
                        alert(data.msg);
                    }
                },'json');
            }
        });
        // 字段异步排序
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
        // 删除字段
        $(".del").click(function(){
            var delLink=$(this).attr("link");
            popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                if(action == 'ok'){
                    top.window.location.href=delLink;
                }
            });
            return false;
        });
        //根据选择省份显示下一级
        
        $(".quickSubmit").click(function(){
            commonAjaxSubmit("","#quickForm");
            return false;
        });
    });
</script>
    </body>
</html>