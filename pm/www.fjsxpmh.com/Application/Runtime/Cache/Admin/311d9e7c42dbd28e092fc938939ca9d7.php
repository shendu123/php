<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "special"): echo ($saytyp["ch"]); endif; ?>
            <?php if((ACTION_NAME) == "search_special"): echo ($saytyp["ch"]); ?>搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php if(ACTION_NAME == 'special'){ $pagname = '专场列表'; }elseif(ACTION_NAME == 'search_special'){ $pagname = '搜索结果'; }; $currentNav ='拍卖管理 > '.$pagname; $this->pagname=$pagname; $this->currentNav->$currentNav; ?>
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
                            <?php if((ACTION_NAME) == "special"): echo ($saytyp["ch"]); endif; ?>
                            <?php if((ACTION_NAME) == "search_special"): echo ($saytyp["ch"]); ?>搜索结果<?php endif; ?>
                        </div>
                        <div class="fl">
                        <a href="<?php echo U('Auction/special',array('typ'=>'biding'));?>" class="sbtn <?php if(($saytyp["get"]) == "biding"): ?>on<?php endif; ?>">已开拍专场</a>
                            <a href="<?php echo U('Auction/special',array('typ'=>'future'));?>" class="sbtn <?php if(($saytyp["get"]) == "future"): ?>on<?php endif; ?>">未开拍专场</a>
                            <a href="<?php echo U('Auction/special',array('typ'=>'bidend'));?>" class="sbtn <?php if(($saytyp["get"]) == "bidend"): ?>on<?php endif; ?>">已结束专场</a>
                        </div>
                        <div class="search">
                            <form action="<?php echo U('search_special');?>" method='get'>
                            关键字：
                            <input type="hidden" value="<?php echo ($saytyp["get"]); ?>" name="typ" class="input"/>
                                <input type="text" value="<?php echo ($keys["keyword"]); ?>" name="keyword" class="input" placeholder="搜索标题的关键字" />
                                &nbsp;&nbsp;保证金扣除模式：
                                <select name="special_pledge_type">
                                    <option value="" <?php if(($keys["type"]) == ""): ?>selected="selected"<?php endif; ?> >全部</option>
                                    <option value="0" <?php if(($keys["type"]) == "0"): ?>selected="selected"<?php endif; ?>>专场扣除</option>
                                    <option value="1" <?php if(($keys["type"]) == "1"): ?>selected="selected"<?php endif; ?>>分别扣除</option>
                                </select>
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                    </div>
                    <?php if((ACTION_NAME) == "search_special"): ?><div class="seamsg">
                            在<span class="keyword"><?php echo ($saytyp["ch"]); ?></span>
                            找到保证金扣除类型为
                            <span class="keyword">
                            <?php if(($keys["type"]) == ""): ?>全部<?php endif; ?>
                            <?php if(($keys["type"]) == "0"): ?>专场扣除<?php endif; ?>
                            <?php if(($keys["type"]) == "1"): ?>分别扣除<?php endif; ?>
                            </span>的
                            <span class="keyword"><?php echo ($keys["count"]); ?></span>个<?php if($keys['keyword'] != ''): ?>与<span class="keyword"><?php echo ($keys["keyword"]); ?></span>相关的<?php endif; ?>专场！
                        </div><?php endif; ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="5%">SID</td>
                                <td width="15%">专场名</td>
                                <td width="15%">描述</td>
                                <td width="9%">开始时间</td>
                                <td width="9%">结束时间</td>
                                <td width="10%">冻结模式/保证金</td>
                                <td width="7%">发布人</td>
                                <td width="15%">操作</td>
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" pid="<?php echo ($vo["sid"]); ?>">
                                <td><?php echo ($vo["sid"]); ?></td>
                                <td align="left">
                                    <img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo ($vo["spicture"]); ?>" width="61" height="26">
                                    <a style="color:#ff6600; line-height: 20px;" target="_blank" href="<?php echo U('Home/Special/speul',array('sid'=>$vo['sid']));?>"><?php echo ($vo["sname"]); ?></a>
                                </td>
                                <td><?php echo ($vo["description"]); ?></td>
                                <td title="<?php echo (date("Y-m-d H:i",$vo["starttime"])); ?>"><?php echo (date("m-d H:i",$vo["starttime"])); ?></td>
                                <td title="<?php echo (date("Y-m-d H:i",$vo["endtime"])); ?>"><?php echo (date("m-d H:i",$vo["endtime"])); ?></td>
                                <td> 
                                <?php if(($vo["special_pledge_type"]) == "0"): ?>专场扣除/<?php echo ($vo["spledge"]); endif; ?>
                                <?php if(($vo["special_pledge_type"]) == "1"): ?>分别扣除<?php endif; ?>
                                </td>
                                <td><?php echo ($vo["aidName"]); ?></td>
                                <td>[ <a target="_blank" href="<?php echo U('Home/Special/speul',array('sid'=>$vo['sid']));?>">专场页面 </a> ] 
                                <?php if(($saytyp["get"]) != "bidend"): ?>[ <a href="/Admin/Auction/edit_special?sid=<?php echo ($vo["sid"]); ?>">编辑 </a> ] [ <a link="<?php echo U('Auction/del_special/',array('sid'=>$vo['sid']));?>" href="javascript:void(0)" name="<?php echo ($vo["sname"]); ?>" class="del">删除 </a> ]<?php endif; ?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="10" align="right" class="page">
                            <?php if(($saytyp["get"]) == "biding"): ?><span class="fl">提示：发布的专场一旦有人缴纳保证金将不能对其进行编辑!请谨慎操作！</span><?php endif; ?>
                            <?php if(($saytyp["get"]) == "future"): ?><span class="fl">提示：在拍品未开始状态！请检查商品数据！一旦开始且有人缴纳保证金或出价，您将无法对拍品进行编辑！</span><?php endif; ?>
                            <?php if(($saytyp["get"]) == "bidend"): ?><span class="fl">提示：为了数据安全！结束的专场将无法进行编辑和删除！</span><?php endif; ?>
                            <?php echo ($page); ?></td>
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
                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?<br/>专场删除后！数据有可能错乱，专场下的拍品会设置为结束！','温馨提示',function(action){
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