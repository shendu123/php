<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>查看拍卖-后台管理-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='拍卖管理 > 查看拍卖'; ?>

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
                        <div class="current">拍卖设置</div>
                    </div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <td colspan="2">
                                <?php if(($info["to"]) == "js"): ?><!-- 单品拍说明 -->
                                <div class="say_remark"><strong>添加拍品到单品拍：</strong>在昂酷将拍卖发布到单品拍是指该拍品的开始时间、结束时间、保证金的冻结和解冻都是独立的且仅针对该拍品的。<br>单品拍仅在频道内显示,用户在频道内可通过分类和条件进行筛选来找到该拍品。</div>
                                <!-- 单品拍说明——end --><?php endif; ?>
                                <?php if(($info["to"]) == "zc"): ?><!-- 专场说明 -->
                                <div class="say_remark"><strong>添加拍品到专场：</strong>在昂酷将拍卖发布到专场是指该专场开始时间都是相同的,结束时间可以单独设置，默认是专场结束时间。  专场的结束时间会根据专场内最后结束拍品的时间的不同而变动，专场时间的变动会有以下动作触发：1，发布拍品的结束时间比专场大；2：待最后结束拍品有被触发时间延时。发布到专场的拍品在频道和专场内显示。
                                </div>
                                <!-- 专场说明——end --><?php endif; ?>
                                <?php if(($info["to"]) == "pmh"): ?><!-- 拍卖会说明 -->
                                <div class="say_remark"><strong>添加拍品到拍卖会：</strong>在昂酷将拍卖发布到拍卖会是指该拍卖会内拍品会仿照真实拍卖会实行轮拍。<br>拍卖会是仿照真实拍卖会操作流程，所有拍品按照顺序进行轮拍，拍卖会流程为拍品预展->拍卖会开始->商品按照顺序轮拍<br>轮拍规则为：拍卖会开始，第一件拍品开始拍卖并进入《流拍时间》倒计时，在【流拍倒计时未结束】时有人出价时间变为拍品《拍卖时间》继续倒计时，在相应时间和价格会触发拍品相应的时间延时和价格浮动；【流拍倒计时结束】无人出价则拍品流拍。进入下一拍品《间隔时间》倒计时，间隔倒计时结束进入下一件拍品的流程，以此类推！</div>
                                <!-- 拍卖会说明——end --><?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="100">商品ID：</th>
                                <td><?php echo ($info["gid"]); ?>
                                
                                </td>
                            </tr>
                            <?php if(($info["to"]) == "zc"): ?><!-- 专场显示字段 -->
                            <tr>
                                <th width="100">发布的专场</th>
                                <td>
                                    <?php if(!empty($info["special"])): if(($info["special"]["nowtype"]) == "fut"): ?>未开拍专场<?php endif; ?>
                                        <?php if(($info["special"]["nowtype"]) == "ing"): ?>已开拍专场<?php endif; ?>
                                        <?php if(($info["special"]["nowtype"]) == "end"): ?>已结束专场<?php endif; ?>
                                        <a target="_blank" href="<?php echo U('Home/Special/speul',array('sid'=>$info['sid']));?>"><?php echo ($info["special"]["sname"]); ?></a><?php endif; ?>
                                </td>
                            </tr>
                            <!-- 专场显示字段——end --><?php endif; ?>
                            <?php if(($info["to"]) == "pmh"): ?><!-- 拍卖会显示字段 -->
                            <tr>
                                <th width="100">发布的拍卖会：</th>
                                <td>
                                    <?php if(!empty($info["meeting"])): if(($info["meeting"]["nowtype"]) == "fut"): ?>未开拍拍卖会<?php endif; ?>
                                        <?php if(($info["meeting"]["nowtype"]) == "ing"): ?>已开拍拍卖会<?php endif; ?>
                                        <?php if(($info["meeting"]["nowtype"]) == "end"): ?>已结束拍卖会<?php endif; ?>
                                        <a href="<?php echo U('Home/Meeting/meetul',array('sid'=>$info['sid']));?>"><?php echo ($info["meeting"]["mname"]); ?></a><?php endif; ?>
                                </td>
                            </tr>
                            <!-- 拍卖会显示字段——end --><?php endif; ?>
                            <tr>
                                <th>拍卖标题：</th>
                                <td><?php echo ($info["pname"]); ?></td>
                            </tr>
                            <tr>
                                <th>拍卖模式：</th>
                                <td>
                                    <?php if(($info[type]) == "0"): ?>竞拍：规定时间，多次出价，价高者得。<?php endif; ?>
                                    <?php if(($info[type]) == "1"): ?>竞拍：规定时间，一次出价，价高者得。<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>成交模式：</th>
                                <td>
                                    <?php if(($info[succtype]) == "0"): ?>普通模式<?php endif; ?>
                                    <?php if(($info[succtype]) == "1"): ?>即时成交->成交价：<?php echo ($info["succprice"]); endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>拍品状态：</th>
                                <td>
                                    <?php if(($info[status]) == "0"): ?>新增：表示第一次参与拍卖的商品——默认。<?php endif; ?>
                                    <?php if(($info[status]) == "1"): ?>降价：表示之前该商品有发布拍卖，但未成交，用于让客户了解到该商品已经降价。<?php endif; ?>
                                </td>
                            </tr>
                            <!-- 单品拍下才可以设置开始结束时间 -->
                            <?php if(($info["to"]) == "js"): ?><tr>
                                <th>开始时间：</th>
                                <td><?php echo (date('Y-m-d H:i',$info["starttime"])); ?></td>
                            </tr><?php endif; ?>
                            <!-- 单品拍下才可以设置开始结束时间——end -->
                            <!-- 拍卖会不需要拍卖时间 -->
                            <?php if(($info["to"]) != "pmh"): ?><tr>
                                    <th>结束时间：</th>
                                    <td><?php echo (date('Y-m-d H:i',$info["endtime"])); ?></td>
                                </tr><?php endif; ?>
                            <!-- 拍卖会不需要拍卖时间——end -->
                            <?php if((ACTION_NAME) == "edit"): ?><tr>
                                    <th>当前价：</th>
                                    <td><?php echo ($info["nowprice"]); ?></td>
                                </tr><?php endif; ?>
                            
                            <tr>
                                <th>拍卖起拍价：</th>
                                <td><?php echo ($info["onset"]); ?></td>
                            </tr>
                            <tr>
                                <th>拍卖保留价：</th>
                                <td><?php echo ($info["price"]); ?></td>
                            </tr>
                            <tr>
                                <th>价格浮动：</th>
                                <td>
                                    <?php if(($info[stepsize_type]) == "0"): ?>阶梯：初始浮动额度为<?php echo ($info["stepsize_ratio_r"]); ?>当前价大于等于<?php echo ($info["stepsize_ratio_s"]); ?>以后，开始按照单位(十百千...)<?php echo ($info["stepsize_ratio_b"]); ?>/<?php echo ($info["stepsize_ratio_g"]); ?>规则实行浮动，浮动最高不超过<?php echo ($info["stepsize_ratio_t"]); endif; ?>
                                    <?php if(($info[stepsize_type]) == "1"): ?>定额：每次出价固定加价<?php echo ($info["step_fixation"]); endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>时间延时：</th>
                                <td>最后<?php echo ($info["steptime"]); ?>秒内出价，时间延时<?php echo ($info["deferred"]); ?>秒&nbsp;&nbsp;&nbsp;&nbsp;（60秒=1分钟）</td>
                            </tr>
                            <tr id="pledge_box">
                                <th>保证金：</th>
                                <td>
                                    <?php if(($info[pledge_type]) == "ratio"): ?>比例：按照比例<?php echo ($info["pledge_ratio"]); ?>%冻结保证金(如：1%，就是拍1000元的商品冻结10元保证金)<?php endif; ?>
                                    <?php if(($info[pledge_type]) == "fixation"): ?>定额：每件拍品冻结保证金<?php echo ($info["pledge_fixation"]); ?>（如：填写100，就是每件商品冻结100，与商品价格无关）<?php endif; ?>
                                </td>
                            </tr>
                            <tr id="broker_box">
                                <th><?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>：</th>
                                <td>
                                    <?php if(($info[broker_type]) == "ratio"): ?>比例：按照<?php echo ($info["broker_ratio"]); ?>%比例收取<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>(如：1%，就是订单成交价为1000元的商品收取10元<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>)<?php endif; ?>
                                    <?php if(($info[broker_type]) == "fixation"): ?>按照定额<?php echo ($info["broker_fixation"]); ?>收取<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>（如：填写100，就是订单支付固定收取100元<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>）<?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    <div class="Item hr clearfix">
                        <div class="current">当前状态</div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th width="100">当前状态：</th>
                            <td>
                                <strong>
                                <?php if(($info["nowtype"]) == "fut"): ?>未开拍<?php endif; ?>
                                <?php if(($info["nowtype"]) == "ing"): ?>已开拍<?php endif; ?>
                                <?php if(($info["nowtype"]) == "end"): ?>已结束<?php endif; ?>
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <th width="100">出价记录</th>
                            <td>
                                <p>共计出价：<strong><?php echo ($count); ?></strong>次</p>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tab recordall">
                                    <thead>
                                        <tr class="th">
                                            <?php if(($info["type"]) == "0"): ?><td>状态</td>
                                                <td>出价人</td>
                                                <td>出价方式</td>
                                                <td>出价</td>
                                                <td>时间</td><?php endif; ?>
                                            <?php if(($info["type"]) == "1"): ?><td>出价人</td>
                                                <td>出价方式</td>
                                                <td>价格</td>
                                                <td>时间</td><?php endif; ?>
                                        </tr>
                                    </thead>
                                    <?php if(empty($bidRecord)): ?><tr class="nobody"><td colspan="6" align="center">暂时没有拍友出价</td></tr>
                                    <?php else: ?>
                                        <?php if(is_array($bidRecord)): $i = 0; $__LIST__ = $bidRecord;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$brvo): $mod = ($i % 2 );++$i;?><!-- 竞拍出价记录 -->
                                            <?php if(($info["type"]) == "0"): ?><tr>
                                                <td><div class="bidlistico"></div></td>
                                                <td><span class="on_over" style="width: 60px;"><?php echo ($brvo["nickname"]); ?></span></td>
                                                <td align="center"><?php if(($brvo["type"]) == "代理"): ?><span title="代理出价" class="agency_ico"></span><?php endif; echo ($brvo["type"]); ?></td>
                                                <td align="right"><?php echo ($brvo["bided"]); ?></td>
                                                <td align="center"><?php echo (date('m-d H:i',$brvo["time"])); ?></td>
                                            </tr><?php endif; ?>
                                        <!-- 竞拍出价记录——end -->
                                        <!-- 竞标出价记录 -->
                                            <?php if(($info["type"]) == "1"): ?><tr>
                                                <td><span class="on_over" style="width: 60px;">竞标保密</span></td>
                                                <td align="center"><?php echo ($brvo["type"]); ?></td>
                                                <td align="right"><span class="red1 fb">竞标保密</span></td>
                                                <td align="center"><?php echo (date('m-d H:i',$brvo["time"])); ?></td>
                                            </tr><?php endif; ?>
                                        <!-- 竞标出价记录——end --><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                </table>
                            </td>
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
         var endStatus ="<?php echo ($info["endstatus"]); ?>"
            $(function(){
                if(endStatus==0){
                    // 初始化拍卖记录状态
                    $(".recordall tr:eq(1)").addClass('lingxian');
                }else if(endStatus==1){
                    $(".recordall tr:eq(1)").addClass('chengjiao');
                }
            });
        </script>
    </body>
</html>