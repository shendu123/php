<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            <?php if((ACTION_NAME) == "index"): echo ($saytyp["ch"]); endif; ?>
            <?php if((ACTION_NAME) == "search"): echo ($saytyp["ch"]); ?>搜索结果<?php endif; ?>
            -<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php if(ACTION_NAME == 'index'){ $pagname = '拍卖列表'; }elseif(ACTION_NAME == 'search'){ $pagname = '搜索结果'; }; $currentNav ='商品管理 > '.$pagname; $this->currentNav->$currentNav; ?>
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
		<script type="text/javascript" src="/Public/WebSocketMain/js/swfobject.js"></script>
		<script type="text/javascript" src="/Public/WebSocketMain/js/web_socket.js"></script>
    </head>
    <body onload="connect();">
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
                            <?php if((ACTION_NAME) == "index"): echo ($saytyp["ch"]); endif; ?>
                            <?php if((ACTION_NAME) == "search"): echo ($saytyp["ch"]); ?>搜索结果<?php endif; ?>
                        </div>
                        <?php if(empty($ginfo)): ?><div class="fl">
                                <a href="<?php echo U('Auction/index',array('typ'=>'biding'));?>" class="sbtn <?php if(($saytyp["get"]) == "biding"): ?>on<?php endif; ?>">正在拍卖</a>
                                <a href="<?php echo U('Auction/index',array('typ'=>'future'));?>" class="sbtn <?php if(($saytyp["get"]) == "future"): ?>on<?php endif; ?>">未开拍拍卖</a>
                                <a href="<?php echo U('Auction/index',array('typ'=>'bidend'));?>" class="sbtn <?php if(($saytyp["get"]) == "bidend"): ?>on<?php endif; ?>">已结束拍卖</a>
                            </div><?php endif; ?>
                        <div class="search">
                            <form action="<?php echo U('search');?>" method='get'>
                            关键字：
                            <input type="hidden" value="<?php echo ($saytyp["get"]); ?>" name="typ" class="input"/>
                                <input type="text" value="<?php echo ($keys["keyword"]); ?>" name="keyword" class="input" placeholder="搜索标题的关键字" />
                                &nbsp;&nbsp;模式：
                                <select name="type">
                                    <option value="" <?php if(($keys["type"]) == ""): ?>selected="selected"<?php endif; ?> >所有</option>
                                    <option value="0" <?php if(($keys["type"]) == "0"): ?>selected="selected"<?php endif; ?>>竞拍</option>
                                    <option value="1" <?php if(($keys["type"]) == "1"): ?>selected="selected"<?php endif; ?>>竞标</option>
                                    </select>
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
                            <?php if(empty($ginfo)): ?>在<span class="keyword"><?php echo ($keys["chname"]); ?></span>频道的<span class="keyword"><?php echo ($keys["catname"]); ?></span>分类下找到<span class="keyword"><?php echo ($keys["count"]); ?></span>个<?php if($keys['keyword'] != ''): ?>与<span class="keyword"><?php echo ($keys["keyword"]); ?></span>相关的<?php endif; ?>
                                <span class="keyword"><?php echo ($keys["tname"]); ?></span>商品！
                            <?php else: ?>
                                找到属于商品：<span class="keyword"><?php echo ($ginfo["title"]); ?></span>的拍品<span class="keyword"><?php echo ($keys["count"]); ?></span>个<?php endif; ?>
                        </div><?php endif; ?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab">
                        <thead>
                            <tr>
                                <td width="5%">PID/GID</td>
                                <td width="14%">拍品名称</td>
                                <td width="14%">所在专场/拍卖会</td>
                                <td width="9%">频道/分类</td>
                                <td width="5%">模式</td>
                                <td width="7%">开始时间</td>
                                <td width="7%">结束时间</td>
                                <td width="5%">状态</td>
                                <td width="15%">所属用户</td>
                                <td>操作</td>
                                
                            </tr>
                        </thead>
                        <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr align="center" pid="<?php echo ($vo["pid"]); ?>">
                                <td><?php echo ($vo["pid"]); ?>/<?php echo ($vo["gid"]); ?></td>
                                <td align="left">
                                    <a style="color:#ff6600;" href="<?php echo U('Home/Auction/details',array('pid'=>$vo[pid]));?>" target="_blank">
                                        <img style="margin-right: 5px; display: inline; float:left;" src="<?php echo ($upWholeUrl); echo (picrep($vo["pimg"],3)); ?>" width="50px" /><?php echo ($vo["pname"]); ?>
                                    </a>
                                </td>
                                <td align="left">
                                <?php if(in_array(($vo["pattern"]), explode(',',"1,2"))): ?>专场： <a target="_blank" style="color: #ff6600;" href="<?php echo U('Home/Special/speul',array('sid'=>$vo['sid']));?>"><?php echo ($vo["sname"]); ?></a><?php endif; ?>
                                <?php if(in_array(($vo["pattern"]), explode(',',"3,4"))): ?>拍卖会：<a target="_blank" style="color: #ff6600;" href="<?php echo U('Home/Meeting/meetul',array('mid'=>$vo['mid']));?>"><?php echo ($vo["mname"]); ?></a><?php endif; ?>
                                <?php if(in_array(($vo["pattern"]), explode(',',"0"))): ?><div align="center">单品拍</div><?php endif; ?>
                                    <?php if(($vo["mid"]) != "0"): ?><strong><?php endif; ?>
                                </td>
                                <td><?php echo ($vo["pidName"]); ?>-><?php echo ($vo["cidName"]); ?></td>
                                <td>
                                    <?php if(($vo["type"]) == "0"): ?>竞拍<?php endif; ?>
                                    <?php if(($vo["type"]) == "1"): ?>竞标<?php endif; ?>
                                </td>
                                <td title="<?php echo (date("Y-m-d H:i",$vo["starttime"])); ?>">
                                    <?php echo (date("m-d H:i",$vo["starttime"])); ?></td>
                                <td title="<?php echo (date("Y-m-d H:i",$vo["endtime"])); ?>">
                                    <?php if(($saytyp["get"]) != "bidend"): if(in_array(($vo["pattern"]), explode(',',"3,4"))): ?>最快<br/><?php endif; endif; ?>
                                    <?php echo (date("m-d H:i",$vo["endtime"])); ?>
                                </td>
                                <td><?php echo ($vo["st"]); ?></td>
                                <td align="left">
                                    <div class="ushow">
                                        <img class="usimg" src="<?php echo (getuserpic($vo["sellerid"],2)); ?>" alt="" />
                                        <p class="fl">账号：<?php echo ($vo["seller"]["account"]); ?><br/>昵称：<?php echo ($vo["seller"]["nickname"]); ?></p>
                                    </div>
                                </td>
                                <td>
                                [ <a href="/Admin/Auction/showset?pid=<?php echo ($vo["pid"]); ?>">查看 </a> ]
                                <?php if(($saytyp["get"]) != "bidend"): ?><!-- 没有开始不能撤拍 -->
                                    <?php if(($saytyp["get"]) == "biding"): ?>[ <a class="cancelpai" pid="<?php echo ($vo["pid"]); ?>" href="javascript:void(0)" name="<?php echo ($vo["pname"]); ?>">撤拍 </a> ]<?php endif; ?>
                                    <!-- 没有开始不能撤拍 -->
                                    <neq name="saytyp.get" value="bidend">
                                    <?php if(($vo["uid"]) == "0"): ?>[ <a href="/Admin/Auction/edit?pid=<?php echo ($vo["pid"]); ?>">编辑 </a> ]<?php endif; endif; ?>
                                    <?php if(($saytyp["get"]) != "biding"): ?>[ <a pid="<?php echo ($vo["pid"]); ?>" href="javascript:void(0)" name="<?php echo ($vo["pname"]); ?>" class="del">删除 </a> ]<?php endif; ?>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                            <td colspan="11" align="right" class="page">
                            <?php if(($saytyp["get"]) == "biding"): ?><span class="fl">提示：发布的拍品一旦有人出价将不能对其进行编辑!请谨慎操作！</span><?php endif; ?>
                            <?php if(($saytyp["get"]) == "future"): ?><span class="fl">提示：在拍品未开始状态！请检查商品数据！一旦开始且有人出价，您将无法对拍品进行编辑！</span><?php endif; ?>
                            <?php if(($saytyp["get"]) == "bidend"): ?><span class="fl">提示：为了数据安全！结束的拍品将无法进行编辑和删除！</span><?php endif; ?>
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
            var ws_rom_pre = "<?php echo C('BID_PRE');?>";
            // 拍品撤拍提交地址
            var cancelLink = "<?php echo U('Auction/cancelPai');?>";
            // 拍品删除提交地址
            var delLink = "<?php echo U('Auction/del');?>";

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
                getCateHtml(catePid,selectObj);
                // 撤拍
                $(".cancelpai").click(function(){
                    var canceltr = $(this).parents('tr');
                    var cancelpid = $(this).attr('pid');
                    popup.confirm('你真的打算将【<b>'+$(this).attr("name")+'</b>】撤拍吗?<br/>撤拍将结束拍卖，如果拍品已有人出价，将解冻用户冻结的保证金。','温馨提示',function(action){
                        if(action == 'ok'){
                            $.post(cancelLink,{'pid':cancelpid},function(data){      //ajax后台
                            if (data.status) {
                                    popup.success(data.msg);
                                    ws.send(JSON.stringify({"type":"drive","pre":ws_rom_pre,"data":data.result}));
                                    canceltr.remove();
                                    setTimeout(function(){
                                        window.top.location.reload();
                                    },2000);
                                    
                                } else {
                                    alert(data.msg);
                                }
                            },'json');
                        }
                    });
                    return false;
                });
                // 删除
                $(".del").click(function(){
                    var deltr = $(this).parents('tr');
                    var delpid = $(this).attr('pid');

                    popup.confirm('你真的打算删除【<b>'+$(this).attr("name")+'</b>】吗?','温馨提示',function(action){
                        if(action == 'ok'){
                            $.post(delLink,{'pid':delpid},function(data){      //ajax后台
                            if (data.status) {
                                    popup.success(data.msg);
                                    ws.send(JSON.stringify({"type":"drive","data":data.result}));
                                    deltr.remove();
                                    setTimeout(function(){
                                        window.top.location.reload();
                                    },2000);
                                } else {
                                    alert(data.msg);
                                }
                            },'json');
                        }
                    });
                    return false;
                });
            });
// 等待提示框【
popStatus(3, '正在建立连接.....', 0,'',true);
// 等待提示框】
// web_socket【
var ws_room_id = 'admin';
var ws_my_name = 'adminer';
var ws_my_uid = '0';
var ltnr = '/Public/Admin/Img/ltnr_pic.png';
var domain = 'http://'+window.location.host+'/'

if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
    WEB_SOCKET_SWF_LOCATION = "/Public/WebSocketMain/swf/WebSocketMain.swf";
    WEB_SOCKET_DEBUG = true;
    var ws, client_list={};

    // 连接服务端
    function connect() {
        // 创建websocket
        ws = new WebSocket("ws://"+document.domain+":7272");
        // 当socket连接打开时，输入用户名
        ws.onopen = onopen;

        // 当有消息时根据消息类型显示不同信息
        ws.onmessage = onmessage; 
        ws.onclose = function() {
          console.log("连接关闭，定时重连");
          connect();
        };
        ws.onerror = function() {
            popStatus(4, '出现错误,请联系网站管理员！', 0,'',true);
            console.log("出现错误");
        };
    }

    // 连接建立时发送登录信息
    function onopen(){
        // 登录
        var login_data = '{"type":"login","client_name":"'+ws_my_name+'","room_id":'+ws_room_id+'}';
        // 移除等待提示【
        popStatusOff();
        // 移除等待提示】
        console.log("websocket握手成功，发送登录数据:"+login_data);
        ws.send(login_data);
    }
    // 服务端发来消息时
    function onmessage(e){
        console.log(e.data);
        var data = eval("("+e.data+")");
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong","domain":'+domain+'}');
                break;
            // 登录 更新用户列表
            case 'login':
                //{"type":"login","client_id":xxx,"client_name":"xxx","client_list":"[...]","time":"xxx"}
                say(data['client_id'], data['client_name'],  data['client_name']+' 进入拍场', data['time']);
                if(data['client_list']){
                    client_list = data['client_list'];
                }
                else{
                    client_list[data['client_id']] = data['client_name']; 
                }
                // 更新用户列表
                flush_client_list();
                console.log(data['client_name']+"登录成功");
                break;
            // 出价
            case 'drive':
                // bidChange(data.thisS);
                alert('drive');
                break;
            // 用户退出 更新用户列表
            case 'logout':
                //{"type":"logout","client_id":xxx,"time":"xxx"}
                say(data['from_client_id'], data['from_client_name'], data['from_client_name']+' 退出了', data['time']);
                delete client_list[data['from_client_id']];
                flush_client_list();
        }
    }
    // 撤拍
// web_socket】
//



            
        </script>
    </body>
</html>