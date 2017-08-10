<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "index"): ?>有效拍卖订单列表<?php endif; ?>
            <?php if((ACTION_NAME) == "search"): ?>搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php if(ACTION_NAME == 'index'){ $pagname = '拍卖订单列表'; }elseif(ACTION_NAME == 'search'){ $pagname = '搜索结果'; }; $currentNav ='订单管理 > '.$pagname; ?>
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
                        <div class="current fl">
                            <?php if((ACTION_NAME) == "index"): ?>拍卖订单列表<?php endif; ?>
                            <?php if((ACTION_NAME) == "search"): ?>搜索结果<?php endif; ?>
                        </div>
                        <div class="fl">
                            <a href="<?php echo U('Order/index');?>" class="sbtn <?php if(empty($where)): ?>on<?php endif; ?>">全部订单</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime1st','val'=>'0'));?>" class="sbtn <?php if(($where["deftime1st"]) == "0"): ?>on<?php endif; ?>">有效订单</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime1st','val'=>'1'));?>" class="sbtn <?php if(($where["deftime1st"]) == "1"): ?>on<?php endif; ?>">过期订单</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime2st','val'=>'1'));?>" class="sbtn <?php if(($where["deftime2st"]) == "1"): ?>on<?php endif; ?>">卖家违约</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime3st','val'=>'1'));?>" class="sbtn <?php if(($where["deftime3st"]) == "1"): ?>on<?php endif; ?>">默认收货</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime4st','val'=>'1'));?>" class="sbtn <?php if(($where["deftime4st"]) == "1"): ?>on<?php endif; ?>">默认评价卖家</a>
                            <a href="<?php echo U('Order/index',array('field'=>'deftime10st','val'=>'1'));?>" class="sbtn <?php if(($where["deftime10st"]) == "1"): ?>on<?php endif; ?>">默认评价买家</a>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                                订单号：
                                <input type="text" value="<?php echo ($keys["order_no"]); ?>" name="order_no" class="input" placeholder="搜索订单号" />
                                &nbsp;&nbsp;用户账号：
                                <input type="text" value="<?php echo ($keys["account"]); ?>" name="account" class="input" placeholder="用户账号" />
                                &nbsp;&nbsp;类型：
                                <select name="type">
                                    <option value="" <?php if(($keys["type"]) == ""): ?>selected="selected"<?php endif; ?>>全部拍卖</option>
                                    <option value="0" <?php if(($keys["type"]) == "0"): ?>selected="selected"<?php endif; ?>>竞拍订单</option>
                                    <option value="1" <?php if(($keys["type"]) == "1"): ?>selected="selected"<?php endif; ?>>竞标订单</option>
                                </select>
                                &nbsp;&nbsp;状态：
                                <select name="status">
                                    <option value="" <?php if(($keys["status"]) == ""): ?>selected="selected"<?php endif; ?>>全部订单</option>
                                    <option value="0" <?php if(($keys["status"]) == "0"): ?>selected="selected"<?php endif; ?>>待支付</option>
                                    <option value="1" <?php if(($keys["status"]) == "1"): ?>selected="selected"<?php endif; ?>>待发货</option>
                                    <option value="2" <?php if(($keys["status"]) == "2"): ?>selected="selected"<?php endif; ?>>待收货</option>
                                    <option value="3" <?php if(($keys["status"]) == "3"): ?>selected="selected"<?php endif; ?>>已收货</option>
                                    <option value="4" <?php if(($keys["status"]) == "4"): ?>selected="selected"<?php endif; ?>>已评价</option>
                                    <option value="10" <?php if(($keys["status"]) == "10"): ?>selected="selected"<?php endif; ?>>已互评</option>
                                </select>
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                        
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="10%">订单号</td>
                                <td width="7%">生成时间</td>
                                <td width="15%">对应拍品</td>
                                <td width="10%">拍品/运费</td>
                                <td>订单佣金</td>
                                <td width="10%">所属用户账号</td>
                                <td width="10%">买家保证金</td>
                                <td width="10%">卖家保证金</td>
                                <td width="10%">类型/状态</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <?php if(empty($list)): ?><tr><td colspan="10">哎哟！什么也没有！</td></tr>
                        <?php else: ?> 
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center">
                                    <td align="left"><?php echo ($vo["order_no"]); ?></td>
                                    <td><?php echo (date("Y-m-d H:i:s",$vo["time"])); ?></td>
                                    <td align="left">
                                        <a style="color:#ff6600;line-height: 20px;" href="<?php echo U('Home/Auction/details',array('pid'=>$vo[gid]));?>" target="_blank">
                                        <img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo (picrep($vo["pimg"],3)); ?>" width="50px" />
                                        【<?php if(($vo["type"]) == "0"): ?>竞拍<?php endif; if(($vo["type"]) == "1"): ?>竞标<?php endif; ?>】
                                        <?php echo ($vo["pname"]); ?>
                                        </a>
                                    </td>
                                    <td><?php echo ($vo["price"]); ?>/<?php echo ($vo["freight"]); ?><br/>共计：<?php echo ($vo["prcsum"]); ?></td>
                                    <td><?php echo ($vo["broker"]); ?></td>
                                    <td><?php echo ($vo["account"]); ?></td>

                                    <td align="left">
                                        <?php echo ($vo["pledge_type"]); ?>
                                        <p>保证金：<?php echo ($vo["pledge"]); ?></p>
                                        <?php if(($vo["pledge"]) != "0"): ?><p>信用额度：<?php echo ($vo["limsum"]); ?></p><?php endif; ?>
                                    </td>
                                    <td align="left">
                                        <?php echo ($vo["sell_type"]); ?>
                                        <p>保证金：<?php echo ($vo["sell_pledge"]); ?></p>
                                        <?php if(($vo["sell_limsum"]) != "0"): ?><p>信用额度：<?php echo ($vo["sell_limsum"]); ?></p><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vo['status'] == 0): if(($vo["deftime1st"]) == "0"): ?>待付款
                                            <?php else: ?>
                                                买家违约<?php endif; endif; ?>
                                        <?php if($vo['status'] == 1): if(($vo["deftime2st"]) == "0"): ?>待发货
                                            <?php else: ?>
                                                卖家违约<?php endif; endif; ?>
                                        <?php if(($vo["status"]) == "2"): ?>待收货<?php endif; ?>
                                        <?php if(($vo["status"]) == "3"): ?>交易成功<?php endif; ?>
                                        <?php if(($vo["status"]) == "4"): ?>买家已评价<?php endif; ?>
                                        <?php if(($vo["status"]) == "5"): ?>申请退货<?php endif; ?>
                                        <?php if(($vo["status"]) == "6"): ?>卖家拒绝退货<?php endif; ?>
                                        <?php if(($vo["status"]) == "7"): ?>卖家同意退货，待发货<?php endif; ?>
                                        <?php if(($vo["status"]) == "8"): ?>已发货等待卖家收货<?php endif; ?>
                                        <?php if(($vo["status"]) == "9"): ?>已完成退货<?php endif; ?>
                                        <?php if(($vo["status"]) == "10"): ?>已互评<?php endif; ?>
                                    </td>
                                    <td>
                                        [ <a href="/Admin/Order/edit?order_no=<?php echo ($vo["order_no"]); ?>">编辑 </a> ] 
                                        [ <a link="<?php echo U('Order/del/',array('order_no'=>$vo['order_no']));?>" href="javascript:void(0)" name="<?php echo ($vo["order_no"]); ?>" class="del">删除 </a> ]
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            <tr>
                                <td colspan="20"><div class="fl">买家订单总额：<?php echo ($mct["odmn"]); ?> &nbsp;&nbsp;卖家佣金总额：<?php echo ($mct["bkmn"]); ?></div><div class="page"  style="width: 60%; text-align: right; float: right;"><?php echo ($page); ?></div></td>
                            </tr><?php endif; ?>
                        
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
            var paylistUrl = "<?php echo U('Order/edit','','');?>";
            var thisUrl = "<?php echo U('Order/lose');?>";
            $(function(){
                $("#allcbox").click(function() {
                    $('input[name="pid[]"]').prop("checked",this.checked);
                });
                var $subBox = $("input[name='pid[]']");
                $subBox.click(function(){
                    $("#allcbox").prop("checked",$subBox.length == $("input[name='pid[]']:checked").length ? true : false);
                });
                $(".submit").click(function(){
                    if($("input[name='pid[]']:checked").length!=0){
                        asyncbox.alert('为了数据的正常，请确保您所选择的订单状态是相同的！','操作提示',function(buttonResult){
                            if(buttonResult == 'ok'){
                                var str="";
                                for (var i=0;i<$("input[name='pid[]']").length;i++ ){
                                    if($("input[name='pid[]']")[i].checked){
                                        str=str+$("input[name='pid[]']")[i].value + "_";
                                    }
                                }
                                str=str.substring(0,str.length-1);
                                document.location.href =paylistUrl+'?order_no='+str;
                            }
                        });
                         
                    }else{
                       popup.alert('您至少需要选中一个要处理的订单');
                        setTimeout(function(){
                            popup.close("asyncbox_alert");
                        },2000);
                    }
                    return false;
                });
                // 删除订单【
                $(".del").click(function(){
                    var delLink=$(this).attr("link");
                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                        if(action == 'ok'){
                            top.window.location.href=delLink;
                        }
                    });
                    return false;
                });
                // 删除订单】
            });
        </script>
    </body>
</html>