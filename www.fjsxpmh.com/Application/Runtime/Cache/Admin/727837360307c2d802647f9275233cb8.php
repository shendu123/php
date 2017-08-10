<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>筛选条件管理-商品管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='商品管理 > 筛选条件管理'; ?>
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
                        <div class="current">筛选条件管理</div>
                    </div>
                    <form action="" method="post" class="userInfo clearfix formConfl" id="quickForm">
                        <b class="fl thead">添加条件：</b>
                        <input class="fl" type="hidden" name="act" value="add" /> &nbsp;
                        <select class="fl" name="data[pid]">
                            <option value="0">顶级条件</option>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["fid"]); ?>"><?php echo ($vo["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>  &nbsp;
                        <input placeholder="筛选条件名称" id="newName" class="input fl" type="text" name="data[name]" value="" /> &nbsp;

                        <button class="btn quickSubmit fl">确定添加</button>
                        <span class="knack">小窍门：添加多个用,号隔开</span>
                    </form>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                        <thead>
                            <tr align="center">
                                <td width="10%">原条件CID</td>
                                <td width="20%">原条件结构 <b title="单击条件隐藏/显示该条件下在子类">[i]</b></td>
                                <td width="20%" align="left">操作属性</td>
                                <td width="15%">新条件</td>
                                <td width="15%">修改后的名称</td>
                                <td width="10%">排序</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><tr pid="<?php echo ($tree["pid"]); ?>" fid="<?php echo ($tree["fid"]); ?>">
                                    <td align="center"><?php echo ($tree["fid"]); ?><input type="hidden" name="fid" value="<?php echo ($tree["fid"]); ?>"/></td>
                                    <td class="tree" style="cursor: pointer;"><?php echo ($tree["fullname"]); ?></td>
                                    <td>
                                        <select name="act" class="act">
                                            <option selected="selected" value="edit">修改该条件</option>
                                            <option value="del">删除该条件</option>
                                            <option value="add">在该条件中添加子条件</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <a class="editpre" href="javascript:void(0);">修改父级条件</a>
                                    </td>
                                    <td><input type="text" value="" name="name" class="input" placeholder="你要修改条件的新名称"/></td>
                                    <td>
                                        <div class="ajax_order">
                                            <a class="rising" href="javascript:void(0)">加</a>
                                            <span class="input tc" aid="<?php echo ($tree["fid"]); ?>"><?php echo ($tree["sort"]); ?></span>
                                            <a class="drop" href="javascript:void(0)">减</a>
                                        </div>
                                    </td>
                                    <td align="center"><button class="btn opCat">确定</button></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <form action="" method="post" id="opForm">
            <input id="fid" type="hidden" name="data[fid]" />
            <input id="act" type="hidden" name="act" />
            <input id="pid" type="hidden" name="data[pid]" />
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
        <div id="cateoption" class="hide">
            <select class="cateSelect" name="pid">
                <option value="0">选择父级条件</option>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["fid"]); ?>"><?php echo ($vo1["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
<script type="text/javascript">
    $(function(){
        $(document).on('click','.editpre',function(){
            $(this).parents('td').html($('#cateoption').html());
        });
        //异步编辑排序字段
        var odUrl = "<?php echo U('Goods/order_filtrate');?>"; //排序提交地址
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
        $(".opCat").click(function(){
            var obj=$(this).parents("tr");
            $("#fid").val(obj.find("input[name='fid']").val());
            $("#act").val(obj.find("select[name='act']").val());
            $("#pid").val(obj.find("select[name='pid']").val());
            $("#name").val(obj.find("input[name='name']").val());
            if($("#act").val()=="del"){
                popup.confirm('你真的打算删除该条件吗?','温馨提示',function(action){
                    if(action == 'ok'){
                        commonAjaxSubmit("","#opForm");
                    }
                });
                return false;
            }
            commonAjaxSubmit("","#opForm");
        });
        $(".quickSubmit").click(function(){
            if($("#newName").val()==''){
                popup.alert("条件名称不能为空滴！");
                return false;
            }
            commonAjaxSubmit("","#quickForm");
            return false;
        });

        var chn=function(fid,op){
            if(op=="show"){
                $("tr[pid='"+fid+"']").each(function(){
                    $(this).removeAttr("status").show();
                    chn($(this).attr("fid"),"show");
                });
            }else{
                $("tr[pid='"+fid+"']").each(function(){
                    $(this).attr("status",1).hide();
                    chn($(this).attr("fid"),"hide");
                });
            }
        }
        $(".tree").click(function(){
            if($(this).attr("status")!=1){
                chn($(this).parent().attr("fid"),"hide");
                $(this).attr("status",1);
            }else{
                chn($(this).parent().attr("fid"),"show");
                $(this).removeAttr("status");
            }
        });
    });
</script>
    </body>
</html>