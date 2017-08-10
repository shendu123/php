<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>添加、编辑拍卖-后台管理-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='拍卖管理 > 添加编辑拍卖'; ?>

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
                        <div class="current">添加编辑拍卖</div>
                        <?php if((ACTION_NAME) == "add"): ?><div class="search">
                                <a href="<?php echo U('Auction/add',array('to'=>js,'gid'=>$info[gid]));?>" class="sbtn <?php if(($info["to"]) == "js"): ?>on<?php endif; ?> ">添加到单品拍</a>
                                <a href="<?php echo U('Auction/add',array('to'=>zc,'gid'=>$info[gid]));?>" class="sbtn <?php if(($info["to"]) == "zc"): ?>on<?php endif; ?>">添加到专场</a>
                                <a href="<?php echo U('Auction/add',array('to'=>pmh,'gid'=>$info[gid]));?>" class="sbtn <?php if(($info["to"]) == "pmh"): ?>on<?php endif; ?>">添加到拍卖会</a>
                            </div><?php endif; ?>
                    </div>
                    <form>
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
                                <input type="hidden" name="info[gid]" value="<?php echo ($info["gid"]); ?>" />
                                </td>
                            </tr>
                            <?php if(($info["to"]) == "zc"): ?><!-- 专场显示字段 -->
                            <tr>
                                <th width="100">发布的专场</th>
                                <td>
                                    <select id="sidselect">
                                        <option value="0" <?php if(($info["sse"]) == "0"): ?>selected="selected"<?php endif; ?> >未开拍专场</option>
                                        <option value="1" <?php if(($info["sse"]) == "1"): ?>selected="selected"<?php endif; ?> >已开拍专场</option>
                                    </select>&nbsp;&nbsp;下的&nbsp;&nbsp;
                                    <select class="hide" id="futureSelect" name="info[sid]">
                                        <?php if(is_array($futureList)): $i = 0; $__LIST__ = $futureList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fvo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($fvo["sid"]); ?>" spledge="<?php echo ($fvo["special_pledge_type"]); ?>" sttime="<?php echo (date('Y-m-d H:i',$fvo["starttime"])); ?>" edtime="<?php echo (date('Y-m-d H:i',$fvo["endtime"])); ?>" <?php if(($info[sid]) == "fvo.sid"): ?>selected="selected"<?php endif; ?> ><?php echo ($fvo["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    <select class="hide" id="bidingSelect" name="info[sid]">
                                        <?php if(is_array($bidingList)): $i = 0; $__LIST__ = $bidingList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fvo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($fvo["sid"]); ?>" spledge="<?php echo ($fvo["special_pledge_type"]); ?>" sttime="<?php echo (date('Y-m-d H:i',$fvo["starttime"])); ?>" edtime="<?php echo (date('Y-m-d H:i',$fvo["endtime"])); ?>" <?php if(($info[sid]) == "fvo.sid"): ?>selected="selected"<?php endif; ?> ><?php echo ($fvo["sname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    专场
                                </td>
                            </tr>
                            <!-- 专场显示字段——end --><?php endif; ?>
                            <?php if(($info["to"]) == "pmh"): ?><!-- 拍卖会显示字段 -->
                            <tr>
                                <th width="100">发布的拍卖会：</th>
                                <td>
                                    <select id="midselect">
                                        <option value="0" <?php if(($info["mse"]) == "0"): ?>selected="selected"<?php endif; ?> >未开拍拍卖会</option>
                                    </select>&nbsp;&nbsp;下的&nbsp;&nbsp;

                                    <select name="info[mid]">
                                        <?php if(is_array($futureList)): $i = 0; $__LIST__ = $futureList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$fvo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($fvo["mid"]); ?>" spledge="<?php echo ($fvo["special_pledge_type"]); ?>" <?php if(($info[mid]) == "fvo.mid"): ?>selected="selected"<?php endif; ?> ><?php echo ($fvo["mname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                    拍卖会
                                </td>
                            </tr>
                            <!-- 拍卖会显示字段——end --><?php endif; ?>
                            <tr>
                                <th>拍卖标题：</th>
                                <td><input type="text" class="input" size="60" name="info[pname]" value="<?php echo ($info["pname"]); ?>"/></td>
                            </tr>
                            <tr>
                                <th>拍卖模式：</th>
                                <td>
                                    <label>
                                        <input name="info[type]" type="radio" value="0" <?php if(($info[type]) == "0"): ?>checked="checked"<?php endif; if(($info[type]) == ""): ?>checked="checked"<?php endif; ?> />竞拍 
                                    </label> 
                                    <?php if(($info["to"]) == "js"): ?><label>
                                            <input name="info[type]" type="radio" value="1" <?php if(($info[type]) == "1"): ?>checked="checked"<?php endif; ?> />竞标 
                                        </label><?php endif; ?>
                                    &nbsp;&nbsp;&nbsp;&nbsp;（竞拍）：规定时间，多次出价，价高者得。<?php if(($info["to"]) == "js"): ?>（竞标）：规定时间，一次出价，价高者得。<?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>成交模式：</th>
                                <td>
                                    <label>
                                        <input name="info[succtype]" type="radio" value="0" <?php if(($info[succtype]) == "0"): ?>checked="checked"<?php endif; if(($info[succtype]) == ""): ?>checked="checked"<?php endif; ?> />普通模式
                                    </label> &nbsp;&nbsp;&nbsp;&nbsp;
                                    <label>
                                        <input name="info[succtype]" type="radio" value="1" <?php if(($info[succtype]) == "1"): ?>checked="checked"<?php endif; ?> />即时成交 -->
                                    </label>
                                    成交价：<input type="text" class="input" size="6" name="info[succprice]" value="<?php echo ($info["succprice"]); ?>"/>&nbsp;&nbsp;元
                                    &nbsp;&nbsp;&nbsp;&nbsp;（即时成交）：当用户出价等于或大于成交价时；拍品结束；用户以成交价拍到拍品。（仅限竞拍模式）
                                </td>
                            </tr>
                            <tr>
                                <th>拍品状态：</th>
                                <td>
                                    <label>
                                        <input name="info[status]" type="radio" value="0" <?php if(($info[status]) == "0"): ?>checked="checked"<?php endif; if(($info[status]) == ""): ?>checked="checked"<?php endif; ?> />新增 
                                    </label> 
                                    <label>
                                        <input name="info[status]" type="radio" value="1" <?php if(($info[status]) == "1"): ?>checked="checked"<?php endif; ?> />降价 
                                    </label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;（新增）：表示第一次参与拍卖的商品——默认。（降价）：表示之前该商品有发布拍卖，但未成交，用于让客户了解到该商品已经降价。
                                </td>
                            </tr>
                            <!-- 单品拍下才可以设置开始结束时间 -->
                            <?php if(($info["to"]) == "js"): ?><tr>
                                    <th>开始时间：</th>
                                    <td><input id="start_time" type="text" class="input" size="20" name="info[starttime]" value="<?php if(($info[starttime]) != ""): echo (date('Y-m-d H:i',$info["starttime"])); endif; ?>"/></td>
                                </tr>
                                <tr>
                                    <th>结束时间：</th>
                                    <td><input id="end_time" type="text" class="input" size="20" name="info[endtime]" value="<?php if(($info[starttime]) != ""): echo (date('Y-m-d H:i',$info["endtime"])); endif; ?>"/></td>
                                </tr><?php endif; ?>
                            <!-- 单品拍下才可以设置开始结束时间——end -->
                            <?php if((ACTION_NAME) == "edit"): ?><tr>
                                    <th>当前价：</th>
                                    <td><input type="text" class="input" size="10" name="info[nowprice]" value="<?php echo ($info["nowprice"]); ?>"/></td>
                                </tr><?php endif; ?>
                            
                            <tr>
                                <th>拍卖起拍价：</th>
                                <td><input type="text" class="input" size="10" name="info[onset]" value="<?php echo ($info["onset"]); ?>"/></td>
                            </tr>
                            <tr>
                                <th>拍卖保留价：</th>
                                <td><input type="text" class="input" size="10" name="info[price]" value="<?php echo ($info["price"]); ?>"/></td>
                            </tr>
                            <tr>
                                <th>拍品运费：</th>
                                <td><input type="text" class="input" size="10" name="info[freight]" value="<?php echo ($info["freight"]); ?>"/></td>
                            </tr>
                            <tr>
                                <th>价格浮动：</th>
                                <td>
                                    <select id="stepsize_type" name="info[stepsize_type]">
                                        <option value="0" <?php if(($info[stepsize_type]) == "0"): ?>selected="selected"<?php endif; ?> >阶梯</option>
                                        <option value="1" <?php if(($info[stepsize_type]) == "1"): ?>selected="selected"<?php endif; ?> >定额</option>
                                    </select>
                                    <span id="stepsize"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>时间延时：</th>
                                <td>最后
                                    <input type="text" class="input" size="5" name="info[steptime]" value="<?php echo ($info["steptime"]); ?>"/>
                                    秒内出价，时间延时
                                    <input type="text" class="input" size="5" name="info[deferred]" value="<?php echo ($info["deferred"]); ?>"/>
                                    秒&nbsp;&nbsp;&nbsp;&nbsp;（60秒=1分钟）</td>
                            </tr>
                            <tr id="pledge_box">
                                <th>保证金：</th>
                                <td>
                                    <select id="pledge_type" name="info[pledge_type]">
                                        <option value="ratio" <?php if(($info["pledge_type"]) == "ratio"): ?>selected="selected"<?php endif; ?> >比例</option>
                                        <option value="fixation" <?php if(($info["pledge_type"]) == "fixation"): ?>selected="selected"<?php endif; ?> >定额</option>
                                    </select>
                                    <span>
                                        <input id="pledge" type="text" class="input" size="5" name="info[pledge]" value="<?php echo ($info["pledge"]); ?>"/>
                                        <span class="ratioTip hidden">% 起拍价的比例冻结保证金</span><span class="fixationTip hidden">该拍品冻结的保证金</span>
                                    </span>
                                    <span id="pledgeTip"></span>
                                </td>
                            </tr>
                            <tr id="broker_box">
                                <th><?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>：</th>
                                <td>
                                    <select id="broker_type" name="info[broker_type]">
                                        <option value="ratio" <?php if(($info["broker_type"]) == "ratio"): ?>selected="selected"<?php endif; ?> >比例</option>
                                        <option value="fixation" <?php if(($info["broker_type"]) == "fixation"): ?>selected="selected"<?php endif; ?> >定额</option>
                                    </select>
                                    <span>
                                        <input id="broker" type="text" class="input" size="5" name="info[broker]" value="<?php echo ($info["broker"]); ?>"/>
                                        <span class="broker_ratioTip hidden">% 按照比例收取<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>(如：1/100，就是订单成交价为1000元的商品收取10元<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>)</span>
                                        <span class="broker_fixationTip hidden">按照定额收取<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>（如：填写100，就是订单支付固定收取100元<?php echo ((isset($info["broker_name"]) && ($info["broker_name"] !== ""))?($info["broker_name"]):"佣金"); ?>）</span>
                                    </span>
                                </td>
                            </tr>
                            <?php if(C('Weixin.appid') and C('Weixin.appsecret')): ?><tr>
                                    <th>微信推送：</th>
                                    <td>
                                        <label>
                                            <input name="weixin[send]" <?php if(empty($weixin)): ?>checked="checked"<?php endif; ?> type="radio" value="0"/>不设置推送 
                                        </label> 
                                        <label>
                                            <input name="weixin[send]" <?php if(!empty($weixin)): ?>checked="checked"<?php endif; ?> type="radio" value="1"/>以后推送 
                                        </label>
                                        <label>
                                            <input name="weixin[send]" type="radio" value="2"/>立即推送 
                                        </label>
                                        &nbsp;&nbsp;&nbsp;&nbsp;(直接推送可不上传列表图片；也可在【微信平台】->【图文消息列表】选择多个图文进行推送，注意：仅推送从微信公众账号进入本站时间不超48小时的用户！)
                                    </td>
                                </tr>
                                <tr id="weicontent">
                                    <th>推送内容(选填)：</th>
                                    <td>
                                        <ul class="trul">
                                            <li class="li">标题：<input type="text" class="input" size="50" name="weixin[name]" value="<?php echo ($weixin["name"]); ?>"/></li>
                                            <li class="li">描述：<input type="text" class="input" size="70" name="weixin[comment]" value="<?php echo ($weixin["comment"]); ?>"/></li>
                                            <li class="li" id="topPicBox">
                                                <div class="up_btn_box"><div class="up_explain">图片格式：*.gif; *.jpg; 尺寸：宽<?php echo C('WEI_TOP_WIDTH');?>&nbsp; 高<?php echo C('WEI_TOP_HEIGHT');?>。不上传则使用对应商品第一张图片</div>
                                                <div id="topPic_upload" class="btn up_but"><div class="up_but_ico"></div>头条图片</div>
                                                <div class="clearfix"></div>
                                                <ul id="uploadImageList" class="clearfix">
                                                    <?php if(!empty($weixin["toppic"])): ?><li class="photo"><img id="upImgSize" src="<?php echo ($upWholeUrl); echo ($weixin["toppic"]); ?>" width="<?php echo C('WEI_TOP_WIDTH');?>" height="<?php echo C('WEI_TOP_HEIGHT');?>"/>
                                                    <div class="imper">
                                                    <a class="bigImg" href="<?php echo ($upWholeUrl); echo ($info["picture"]); ?>"  target="_blank"></a></div>
                                                    <input type="hidden" name="weixin[toppic]" value="<?php echo ($weixin["toppic"]); ?>" />
                                                    </li><?php endif; ?>
                                                </ul>
                                            </li>
                                            <li class="li" id="listPicBox">
                                                <div class="up_btn_box"><div class="up_explain">图片格式：*.gif; *.jpg; 尺寸：宽<?php echo C('WEI_LIST_WIDTH');?>&nbsp; 高<?php echo C('WEI_LIST_HEIGHT');?>。不上传则使用对应商品第一张图片</div>
                                                <div id="listPic_upload" class="btn up_but"><div class="up_but_ico"></div>列表图片</div>
                                                <div class="clearfix"></div>
                                                <ul id="uploadImageList" class="clearfix">
                                                    <?php if(!empty($weixin["picture"])): ?><li class="photo"><img id="upImgSize" src="<?php echo ($upWholeUrl); echo ($weixin["picture"]); ?>" width="<?php echo C('WEI_LIST_WIDTH');?>" height="<?php echo C('WEI_LIST_HEIGHT');?>"/>
                                                    <div class="imper">
                                                    <a class="bigImg" href="<?php echo ($upWholeUrl); echo ($info["picture"]); ?>"  target="_blank"></a></div>
                                                    <input type="hidden" name="weixin[picture]" value="<?php echo ($weixin["picture"]); ?>" />
                                                    </li><?php endif; ?>
                                                </ul>
                                            </li>
                                            <input type="hidden" name="weixin[id]" value="<?php echo ($weixin["id"]); ?>" />
                                        </ul>
                                    </td>
                                </tr><?php endif; ?>
                            <?php if((ACTION_NAME) == "edit"): ?><tr>
                                <th>注意：</th>
                                <td>如果拍品已开始且已有人出价。请不要编辑除标题以外的数据。否则会导致数据混乱！请根据情况酌情处理！</td>
                            </tr><?php endif; ?>
                        </table>
                        <input type="hidden" name="info[to]" value="<?php echo ($info["to"]); ?>" />
                        <input type="hidden" name="info[pid]" value="<?php echo ($info["pid"]); ?>" />
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 隐藏数据 -->
        <!-- 加价浮动 -->
        <div id="step_ratio" class="hide">
            初始浮动额度为<input type="text" class="input" size="5" name="info[stepsize_ratio_r]" value="<?php echo ($info["stepsize_ratio_r"]); ?>" placeholder="浮动额度"/>,
            当前价大于等于<input type="text" class="input" size="5" name="info[stepsize_ratio_s]" value="<?php echo ($info["stepsize_ratio_s"]); ?>" placeholder="当前价"/>以后，开始按照单位(十百千...)
            <input type="text" class="input" size="5" name="info[stepsize_ratio]" value="<?php echo ($info["stepsize_ratio"]); ?>" placeholder="比例"/>%规则实行浮动，浮动最高不超过
            <input type="text" class="input" size="5" name="info[stepsize_ratio_t]" value="<?php echo ($info["stepsize_ratio_t"]); ?>" placeholder="浮动价"/>
        </div>
        <div id="step_fixation" class="hide">
            <input type="text" class="input" size="5" name="info[step_fixation]" value="<?php echo ($info["step_fixation"]); ?>"/> &nbsp;&nbsp;每次出价固定加价额度
        </div>
        <!-- 加价浮动——end -->

        <!-- 隐藏数据——end -->
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
        <!-- 日期时间插件 -->
        <link rel="stylesheet" type="text/css" href="/Public/Js/datetimepicker/jquery.datetimepicker.css" />
        <script type="text/javascript" src="/Public/Js/datetimepicker/jquery.datetimepicker.js"></script>
        <!-- 日期时间插件 -->

        <!-- 上传插件【 -->
        <script type="text/javascript" src="/Public/plupload/plupload.full.min.js"></script>
        <script type="text/javascript" src="/Public/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
        <script type="text/javascript" src="/Public/plupload/i18n/zh_CN.js"></script>
        <!-- 上传插件】 -->
        <script type="text/javascript">
        // 上传变量配置【
        var moxieswf = "/Public/plupload/Moxie.swf";
        var moxiesxap = "/Public/plupload/Moxie.xap";
        // 上传变量配置】
        var pledge_ratio = "<?php echo ($info["pledge_ratio"]); ?>";
        var pledge_fixation = "<?php echo ($info["pledge_fixation"]); ?>";
        var broker_ratio = "<?php echo ($info["broker_ratio"]); ?>";
        var broker_fixation = "<?php echo ($info["broker_fixation"]); ?>";
            $(function(){
                //上传初始化变量【
                var uplode_weitop_url = '<?php echo U("Upload/upWeiTopPic");?>';//PHP处理脚本地址
                var uplode_weilist_url = '<?php echo U("Upload/upWeiListPic");?>';//PHP处理脚本地址
                var uplode_path = '/Public'; //插件公共目录
                var sid = '<?php echo session_id();?>';//sessionID
                var upPathRoot="<?php echo ($upWholeUrl); ?>"; //图片上传根目录完整路径
                var uploadPath ="<?php echo C('UPLOADS_PICPATH');?>"; //图片上传根目录
                var topPicW = "<?php echo C('WEI_TOP_WIDTH');?>";
                var topPicH = "<?php echo C('WEI_TOP_HEIGHT');?>";
                var listPicW = "<?php echo C('WEI_LIST_WIDTH');?>";
                var listPicH = "<?php echo C('WEI_LIST_HEIGHT');?>";
                //上传初始化变量】
                // 微信头条图片上传【
                
                    var uploaderTop = new plupload.Uploader({//创建实例的构造方法
                        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                        browse_button: 'topPic_upload', // 上传按钮
                        url: uplode_weitop_url, //远程上传地址
                        flash_swf_url: moxieswf, //flash文件地址
                        silverlight_xap_url: moxiesxap, //silverlight文件地址
                        filters: {
                            max_file_size: '4mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                            mime_types: [//允许文件上传类型
                                {title: "files", extensions: "jpg,gif"}
                            ]
                        },
                        multi_selection: false, //true:ctrl多文件上传, false 单文件上传
                        init: {
                            FilesAdded: function(up, files) { //文件上传前
                                if ($("#topPicBox #uploadImageList").children("li").length > 1) {
                                    alert("您上传的图片太多了！");
                                    uploaderTop.destroy();
                                } else {
                                    var li = '';
                                    plupload.each(files, function(file) { //遍历文件
                                        li += "<li class='photo' id='" + file['id'] + "'><div style='width: "+topPicW+"px;' class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                                    });
                                    $("#topPicBox #uploadImageList").html(li);
                                    uploaderTop.start();
                                }
                            },
                            UploadProgress: function(up, file) { //上传中，显示进度条
                         var percent = file.percent;
                                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                                $("#" + file.id).find(".percent").text(percent + "%");
                            },
                            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                                var data = JSON.parse(info.response);
                                 $("#" + file.id).html('<img id="upImgSize" src="'+upPathRoot+data.path+'" width="'+topPicW+'" height="'+topPicH+'"/><div class="imper"><a class="bigImg" href="'+uploadPath+data.path+'"  target="_blank"></a></div><input type="hidden" name="weixin[toppic]" value="'+data.path+'" />');
                            },
                            Error: function(up, err) { //上传出错的时候触发
                                alert(err.message);
                            }
                        }
                    });
                    uploaderTop.init();
                
                // 微信头条图片上传】
                // 微信列表图片上传【
                
                    var uploaderList = new plupload.Uploader({//创建实例的构造方法
                        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                        browse_button: 'listPic_upload', // 上传按钮
                        url: uplode_weilist_url, //远程上传地址
                        flash_swf_url: moxieswf, //flash文件地址
                        silverlight_xap_url: moxiesxap, //silverlight文件地址
                        filters: {
                            max_file_size: '4mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                            mime_types: [//允许文件上传类型
                                {title: "files", extensions: "jpg,gif"}
                            ]
                        },
                        multi_selection: false, //true:ctrl多文件上传, false 单文件上传
                        init: {
                            FilesAdded: function(up, files) { //文件上传前
                                if ($("#listPicBox #uploadImageList").children("li").length > 1) {
                                    alert("您上传的图片太多了！");
                                    uploaderList.destroy();
                                } else {
                                    var li = '';
                                    plupload.each(files, function(file) { //遍历文件
                                        li += "<li class='photo' id='" + file['id'] + "'><div  style='width: "+listPicW+"px;' class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                                    });
                                    $("#listPicBox #uploadImageList").html(li);
                                    uploaderList.start();
                                }
                            },
                            UploadProgress: function(up, file) { //上传中，显示进度条
                         var percent = file.percent;
                                $("#" + file.id).find('.bar').css({"width": percent + "%"});
                                $("#" + file.id).find(".percent").text(percent + "%");
                            },
                            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                                var data = JSON.parse(info.response);
                                 $("#" + file.id).html('<img id="upImgSize" src="'+upPathRoot+data.path+'" width="'+listPicW+'" height="'+listPicH+'"/><div class="imper"><a class="bigImg" href="'+uploadPath+data.path+'"  target="_blank"></a></div><input type="hidden" name="weixin[picture]" value="'+data.path+'" />');
                            },
                            Error: function(up, err) { //上传出错的时候触发
                                alert(err.message);
                            }
                        }
                    });
                    uploaderList.init();
                
                // 微信列表图片上传】
                // 微信推送内容设置显示隐藏【
                if($('input:radio[name="weixin[send]"]:checked').val()>0){
                    $('#weicontent').show();
                }else{
                    $('#weicontent').hide();
                }
                $('input:radio[name="weixin[send]"]').click(function(){
                    if($(this).val()>0){
                        $('#weicontent').show();
                    }else{
                        $('#weicontent').hide();
                    }
                });
                // 微信推送内容设置显示隐藏【




                //初始化价格浮动字段
                restepsize($('#stepsize_type').val()); //初始化扩展字段
                resid($('#sidselect').val()); //初始化专场
                remid($('#midselect').val()); //初始化扩展字段
                //为input添加时间插件
                $('#start_time').datetimepicker({lang:'ch'});
                $('#end_time').datetimepicker({lang:'ch'});
                //为input添加插件_end
                $(".submit").click(function(){
                    if($('input:radio[name="weixin[send]"]:checked').val()==2){
                        popStatus(3, '正在提交数据至微信，请等待...', 0,'',true);
                    }
                    commonAjaxSubmit();
                    return false;
                });
            });
            //初始化价格浮动字段 ---------------------------------
            // 价格浮动动态监听
            $('#stepsize_type').on("change",function(){
                var type = $(this).children('option:selected').val();
                restepsize(type);
            });
            // 价格浮动函数
            function restepsize(stepsize_type){
                if(stepsize_type==0){
                    $('#stepsize').html($('#step_ratio').html());
                }else if(stepsize_type==1){
                    $('#stepsize').html($('#step_fixation').html());
                }
            }
            //初始化价格浮动字段_end ---------------------------------
            // 根据select动态改变时间
            $('#bidingSelect').on("change",function(){
                changtime($(this));
            });
            $('#futureSelect').on("change",function(){
                changtime($(this));
            });
            // 专场动态改变结束时间函数
            function changtime(thisobj){
                var etim = thisobj.children('option:selected').attr('edtime');
                $('#end_time').val(etim);
            }
            //初始化专场选项-------------------------------------------
            $('#sidselect').on("change",function(){
                var stype = $(this).children('option:selected').val();
                resid(stype);
            });
            function resid(sid){
                if(sid==0){
                    $('#bidingSelect').addClass('hide');
                    $('#bidingSelect').removeAttr('name');

                    $('#futureSelect').removeClass('hide');
                    $('#futureSelect').attr('name','info[sid]');
                    rhs($('#futureSelect').children('option:selected').attr('spledge'));
                    changtime($('#futureSelect'));
                }else if(sid==1){
                    $('#bidingSelect').removeClass('hide');
                    $('#bidingSelect').attr('name','info[sid]');

                    $('#futureSelect').addClass('hide');
                    $('#futureSelect').removeAttr('name');
                    rhs($('#bidingSelect').children('option:selected').attr('spledge'));
                    changtime($('#bidingSelect'));
                }
            }
            //初始化专场选项_end -----------------------------------------
            //初始化拍卖会选项------------------------------------------
            $('#midselect').on("change",function(){
                var stype = $(this).children('option:selected').val();
                remid(stype);
            });
            function remid(sid){
                if(sid==0){
                    $('#bidingSelect').addClass('hide');
                    $('#bidingSelect').removeAttr('name');
                    $('#futureSelect').removeClass('hide');
                    $('#futureSelect').attr('name','info[mid]');
                }else if(sid==1){
                    $('#bidingSelect').removeClass('hide');
                    $('#bidingSelect').attr('name','info[mid]');
                    $('#futureSelect').addClass('hide');
                    $('#futureSelect').removeAttr('name');
                }
            }
            //初始化拍卖会选项——end------------------------------------------
            // 专场动态增加删除保证金字段
            $('#bidingSelect').on("change",function(){
                rhs($(this).children('option:selected').attr('spledge'));
            });
            $('#futureSelect').on("change",function(){
                rhs($(this).children('option:selected').attr('spledge'));
            });
            // 动态添加删除保证金字段-------------------------------------
            function rhs(rhsv){
                if(rhsv==0){
                    $('#pledge_box').addClass('hide');
                    $('#pledge_box select').removeAttr('name');
                    $('#pledge').removeAttr('name');
                }else{
                    $('#pledge_box').removeClass('hide');
                    $('#pledge_box select').attr('name','info[pledge_type]');
                    $('#pledge').attr('name','info[pledge]');
                }
            }
            // 动态添加删除保证金字段——end-------------------------------------
            //初始化保证金字段----------------------------------------
            repledge($('#pledge_type').val()); //初始化扩展字段
            $('#pledge_type').on("change",function(){
                var type = $(this).children('option:selected').val();
                repledge(type);
            });
            function repledge(pledge_type){
                if(pledge_type=='ratio'){
                    $('#pledge').val(pledge_ratio);
                    $('.ratioTip').show();
                    $('.fixationTip').hide();
                }else if(pledge_type=='fixation'){
                    $('#pledge').val(pledge_fixation);
                    $('.ratioTip').hide();
                    $('.fixationTip').show();
                }
            }
            //初始化保证金字段_end ------------------------------------------
            //初始化佣金字段----------------------------------------
            rebroker($('#broker_type').val()); //初始化扩展字段
            $('#broker_type').on("change",function(){
                var type = $(this).children('option:selected').val();
                rebroker(type);
            });
            function rebroker(broker_type){
                if(broker_type=='ratio'){
                    $('#broker').val(broker_ratio);
                    $('.broker_ratioTip').show();
                    $('.broker_fixationTip').hide();
                }else if(broker_type=='fixation'){
                    $('#broker').val(broker_fixation);
                    $('.broker_ratioTip').hide();
                    $('.broker_fixationTip').show();
                }
            }
            //初始化佣金字段_end ------------------------------------------
            
        </script>
    </body>
</html>