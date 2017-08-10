<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="keywords" content="<?php echo ($site["SITE_INFO"]["keyword"]); ?>" />
		<meta name="description" content="<?php echo ($site["SITE_INFO"]["description"]); ?>" />
        <title>拍卖会-<?php echo ($site["SITE_INFO"]["title"]); ?></title>
        <meta name="viewport" content="width=1200,initial-scale=1.0"/>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="edge" />
<base href="<?php echo ($site["WEB_ROOT"]); ?>"/>
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Home/Css/index.css" />
<link rel="stylesheet" type="text/css" href="/Public/Css/pop_status.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/asyncbox/skins/oncoo.css" />
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="/Public/Js/functions.js"></script>
<script type="text/javascript" src="/Public/Home/Js/common.js"></script>
<script type="text/javascript" src="/Public/Js/pop_status.js"></script>
<script type="text/javascript" src="/Public/Js/jquery.form.js"></script>
<script type="text/javascript" src="/Public/Js/asyncbox/asyncbox.js"></script>
<script type="text/javascript">

	var attUrl = "<?php echo U('Member/attention');?>";
	// 关注商家地址
	var setAttentionSellerUrl ="<?php echo U('Seller/attention');?>";
	var getusercard = "<?php echo U('Public/getusercard');?>"
	var login = "<?php echo ($login); ?>";
	var iswei="<?php echo ($iswei); ?>";
	var domain = "<?php echo ($site["WEB_ROOT"]); ?>";
	
</script>

		<link rel="stylesheet" type="text/css" href="/Public/Home/Css/cuitindex.css" />
		<link rel="stylesheet" type="text/css" href="/Public/Home/Css/list.css" />
		<script type="text/javascript" src="/Public/Home/Js/indexjs.js"></script>
    </head>
    <body>
    <div class="indexheader">
    <div class="top bg_wide">
        <div class="topcon w_wide"> 
            <div class="top_fl fl">
    <?php echo ($site["SITE_INFO"]["summary"]); ?>
    
    <?php if($login): ?>您好，尊敬的<strong><?php echo ($nickname); ?></strong>,欢迎来到<?php echo ($site["SITE_INFO"]["name"]); ?>！
    <?php else: ?>
        您好，欢迎来到<?php echo ($site["SITE_INFO"]["name"]); ?>！
        <a href="<?php echo U('Login/index');?>" title="请登录">请登录</a>
        <a href="<?php echo U('Login/register');?>">免费注册</a><?php endif; ?>
</div>
<ul class="top_fr fr">
    <?php if($login): ?><li><a href="<?php echo U('Member/index');?>">我的<?php echo ($site["SITE_INFO"]["name"]); ?></a></li>
        <li><a href="<?php echo U('Public/loginOut');?>">退出</a></li><?php endif; ?>
    
    <li><a href="<?php echo U('Article/help');?>">帮助中心</a></li>
    <li>
        <div class="serviceTel">客服热线：<span class="tel_no"><?php echo ($site["SITE_INFO"]["tel"]); ?></span></div>
    </li>
</ul>
        </div>
    </div>
    <div class="head" style="position:relative;" >
        <h1 class="logo">
            <?php echo showAdvPosition('web_logo','span');?>
        </h1>
        <div class="logo_r_ad">
            <?php echo showAdvPosition('web_logo_right','span');?>
        </div>
        
        <div class="search">
            <ul class="search-slec">
              <li class="searcur"><a val="0" href="javascript:void(0);">全部</a></li>
              <li ><a val="1" href="javascript:void(0);">拍卖</a></li>
              <li ><a val="2" href="javascript:void(0);">资讯</a></li>
            </ul>
            <div class="search-panel">
                <form id="form_search" name="form_search" method="post" action="<?php echo U('Index/search');?>">
                    <input id="seakey" class="text"  type="text"  value="请输入关键词"  name="searchkey" autocomplete="off" />
                    <input type="hidden" id="searchtype" name="searchtype" value = "0" />
                    <input id="seaForm" type="button" class="button" value="查 询" />
                </form>
           </div>
        </div>    
        <div class="mybox">
            <a href="<?php if(($login) == "1"): echo U('Member/mybid'); else: echo U('Login/index'); endif; ?>" rel="nofollow">我的拍卖</a>                     
        </div>
    </div>
    <div class="nav"> 
        <div class="navcon clearfix">

            <div <?php if(!((CONTROLLER_NAME == 'Index') and (ACTION_NAME == 'index'))): ?>id="navleft"<?php endif; ?> class="navleft">
                <h2>导航、推荐
                <?php if(!((CONTROLLER_NAME == 'Index') and (ACTION_NAME == 'index'))): ?><span class="xiala"></span><?php endif; ?>
                </h2>
                <div class="leftlist">
                    <ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a" target="_self" href="">二手车拍卖</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="http://www.oncoo.net">死地方</a></li><li> <a class="" target="_self" href="">正在拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">即将拍卖</a></li><li> <a class="" target="_self" href="">拍卖资讯</a></li></ul></li><li class="one_li"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">艺术品拍卖</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="">一口价</a></li><li> <a class="" target="_self" href="">二手车拍卖</a></li><li> <a class="" target="_self" href="">现代工艺</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">珠宝玉器</a></li><li> <a class="" target="_self" href="index.php/Auction/index">收藏车拍卖</a></li><li> <a class="" target="_self" href="index.php/Auction/index">报废车拍卖</a></li></ul></li><li class="one_li cor_ff"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">拍卖咨询</a><ul class="menu_twolayer clearfix"><li> <a class="two_cor" target="_self" href="javascript:void(0);">我要拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">如何拍卖</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">发布二手车</a></li></ul></li><li class="one_li"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">昂酷网络</a><ul class="menu_twolayer clearfix"><li> <a class="" target="_self" href="http://www.oncoo.net">拍卖系统</a></li><li> <a class="" target="_self" href="http://www.oncoo.net">竞拍系统</a></li><li> <a class="" target="_self" href="http://www.baidu.com">在线拍卖程序</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">怎么样拍成功</a></li><li> <a class="two_cor" target="_self" href="javascript:void(0);">如何购买呢</a></li></ul></li></ul>
                </div>
            </div>

            <div class="navmain cearfix">
                <div class="defaultNav">
                    <ul>
                        <li <?php if((CONTROLLER_NAME) == "Index"): if((ACTION_NAME) != "search"): ?>class="navcur"<?php endif; endif; ?>>
                           <a href="<?php echo U('Index/index');?>" title="<?php echo ($site["SITE_INFO"]["title"]); ?>"> 首页</a> 
                        </li>

                        <?php if(is_array($channelMenu)): foreach($channelMenu as $key=>$cm): ?><li <?php if(($gt["0"]) == $cm["cid"]): ?>class="navcur"<?php endif; ?>>
                               <a href="<?php echo U('Auction/index',array('gt'=>$cm['cid']));?>"> <?php echo ($cm["name"]); ?></a> 
                            </li><?php endforeach; endif; ?>
                        <li <?php if((CONTROLLER_NAME) == "Special"): ?>class="navcur"<?php endif; ?>><a href="<?php echo U('Special/index');?>">专场拍卖</a></li>
                        <li <?php if((CONTROLLER_NAME) == "Meeting"): ?>class="navcur"<?php endif; ?>><a href="<?php echo U('Meeting/index');?>">拍卖会</a></li>
                        <li><ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a one_cor" target="_self" href="javascript:void(0);">添加的导航</a></li></ul></li>
                        <?php if((ACTION_NAME) == "search"): ?><li class="navcur"><a href=""> 搜索结果</a></li><?php endif; ?>
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var seakey =$('#seakey');
    $(function(){
        // 搜索框
        var keyval = seakey.val();  
        seakey.focus(function() {if ($(this).val() == keyval) {$(this).val("");}});
        seakey.blur(function() {if ($(this).val()== "") {$(this).val(keyval);}}); 
        $('.search-slec a').click(function(){
            $(this).parents('ul').children('li').removeClass("searcur");
            $(this).parents('li').addClass("searcur");
            $('#searchtype').attr('value',$(this).attr('val'));
        });
        $('#seaForm').click(function(){
            if (seakey.val()==""||seakey.val()=="请输入关键词"){ 
              popup.error("请输入关键词");
              setTimeout(function(){
                popup.close("asyncbox_error");
              },2000);
              seakey.focus();
              return false;
            }else{
              $('#form_search').submit();
            }
        });
    });
</script>

    <div  class="container auction_list">
     <div class="auction">
        <div class="meeting clearfix">
            <!-- 拍卖会顶部广告 -->
            <div class="ad_special_top">
                <?php echo showAdvPosition('auction_meeting_top','span');?> 
            </div>
            <div class="meeting_list">
            <div class="selection mt0">
                <div class="contitle" id="contit">
                    <a href="<?php echo U('Meeting/index',array('typ'=>'biding'));?>" <?php if(($saytyp["get"]) == "biding"): ?>class="on"<?php endif; ?> >进行中拍卖会</a>  
                    <a href="<?php echo U('Meeting/index',array('typ'=>'future'));?>" <?php if(($saytyp["get"]) == "future"): ?>class="on"<?php endif; ?>>预展拍卖会</a>
                    <a href="<?php echo U('Meeting/index',array('typ'=>'bidend'));?>" <?php if(($saytyp["get"]) == "bidend"): ?>class="on"<?php endif; ?>>历史拍卖会</a> 
                </div>
             </div>
            <!-- 拍卖会顶部广告——end -->
            <div class="content">
                <ul>
                <?php if(empty($list)): ?><li class="datanone">暂时没有<?php echo ($saytyp["ch"]); ?></li>
                    <?php else: ?> 
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li class="conbox li li<?php echo ($vo["mid"]); ?> clearfix">
                        <a href="<?php echo U('Meeting/meetul',array('mid'=>$vo['mid']));?>" class="img_box" target="_blank">
                            <?php if(!empty($vo["mpicture"])): ?><img alt="<?php echo ($vo["mname"]); ?>" src="<?php echo ($upWholeUrl); echo ($vo["mpicture"]); ?>"><?php endif; ?>
                        </a>
                        <div class="cb_text <?php if(($saytyp["get"]) == "biding"): ?>biding<?php endif; if(($saytyp["get"]) == "future"): ?>future<?php endif; if(($saytyp["get"]) == "bidend"): ?>bidend<?php endif; ?>">

                            <h2 class="cuit_over"><a title="<?php echo ($vo["mname"]); ?>" href="<?php echo U('Meeting/meetul',array('mid'=>$vo['mid']));?>" target="_blank"><?php echo ($vo["mname"]); ?></a></h2>
                            <div class="tgld">
                                <p><?php echo ($vo["description"]); ?></p>
                            </div>
                            <ul class="cblist clearfix">
                                <li><span>开始时间：</span><p><?php echo (date('Y-m-d H:i',$vo["starttime"])); ?></p> </li>
                                <li><span>拍品总数：</span><p><strong><?php echo ($vo["count"]); ?></strong>件</p></li>
                                <li><span>保证金缴纳：</span><p>分别缴纳</p></li>
                                <li><span>每件流拍时间：</span><p><?php echo (conversionm_s($vo["losetime"])); ?></p></li>
                                <li><span>每件间隔时间：</span><p><?php echo (conversionm_s($vo["intervaltime"])); ?></p></li>
                                <li><span>每件拍卖时间：</span><p><?php echo (conversionm_s($vo["bidtime"])); ?></p></li>
                            </ul>
                            
                            <div class="specialBidTbox special_timebox clearfix">
                                <!-- 进行中 -->
                                <?php if(($saytyp["get"]) == "biding"): ?><div class="th" id="bidTimeStatus">
                                    预计结束剩余：
                                    </div>
                                    <div class="onBidtime<?php echo ($vo["mid"]); ?>" id="onBidtime">
                                        <span class="day">-</span>
                                        <span class="dw">天</span>
                                        <span class="hour">-</span>
                                        <span class="dw">时</span>
                                        <span class="minute">-</span>
                                        <span class="dw">分</span>
                                        <span class="second">-</span>
                                        <span class="dw">秒</span>
                                        <span class="msec">-</span>
                                    </div>
                                    <script type="text/javascript">
                                        $(function(){
                                            specialCountDown("cke","<?php echo ($vo["mid"]); ?>","<?php echo ($vo["endtime"]); ?>","<?php echo ($nowtime); ?>",".onBidtime<?php echo ($vo["mid"]); ?>",".onBidtime<?php echo ($vo["mid"]); ?> .day",".onBidtime<?php echo ($vo["mid"]); ?> .hour",".onBidtime<?php echo ($vo["mid"]); ?> .minute",".onBidtime<?php echo ($vo["mid"]); ?> .second",".onBidtime<?php echo ($vo["mid"]); ?> .msec");
                                        });
                                    </script><?php endif; ?>
                                <!-- 进行中——end -->
                                <?php if(($saytyp["get"]) == "bidend"): ?><div class="th">拍卖会状态：</div>
                                    <div class="td"> 已结束...</div><?php endif; ?>
                                <!-- 未开始 -->
                                <?php if(($saytyp["get"]) == "future"): ?><div class="th" id="bidTimeStatus">距离开始：</div>
                                <div class="onBidtime<?php echo ($vo["mid"]); ?>" id="onBidtime">
                                    <span class="day">-</span>
                                    <span class="dw">天</span>
                                    <span class="hour">-</span>
                                    <span class="dw">时</span>
                                    <span class="minute">-</span>
                                    <span class="dw">分</span>
                                    <span class="second">-</span>
                                    <span class="dw">秒</span>
                                    <span class="msec">-</span>
                                </div>
                                <script type="text/javascript">
                                    $(function(){
                                        specialCountDown("cks","<?php echo ($vo["mid"]); ?>","<?php echo ($vo["starttime"]); ?>","<?php echo ($nowtime); ?>",".onBidtime<?php echo ($vo["mid"]); ?>",".onBidtime<?php echo ($vo["mid"]); ?> .day",".onBidtime<?php echo ($vo["mid"]); ?> .hour",".onBidtime<?php echo ($vo["mid"]); ?> .minute",".onBidtime<?php echo ($vo["mid"]); ?> .second",".onBidtime<?php echo ($vo["mid"]); ?> .msec");
                                    });
                                </script><?php endif; ?>
                                <!-- 未开始——end -->
                            </div>
                            
                            <div class="countbid">
                                <?php if(($saytyp["get"]) == "biding"): ?><span class="side-num"><?php echo ($vo["mcount"]); ?></span>
                                    <span class="side-text">次出价</span><?php endif; ?>
                                <?php if(($saytyp["get"]) == "future"): ?><span class="side-num"><?php echo ($vo["clcount"]); ?></span>
                                    <span class="side-text">人想拍</span><?php endif; ?>
                                <?php if(($saytyp["get"]) == "bidend"): ?><span class="side-num"><?php echo ($vo["endcount"]); ?></span>
                                    <span class="side-text">件成交</span><?php endif; ?>
                            </div>
                        </div>
                    </li><?php endforeach; endif; else: echo "" ;endif; endif; ?>
            </ul>
            <div class="bid_list_page mb20"><?php echo ($page); ?></div>
            </div>
        </div>     
        </div>
    <!-- 广告列表 -->
    
    <!-- 广告列表 -->
<!---底部开始-->
<div class="main_a8 help_wide clearfix">
	<div class="help_wide_box">
	    <div class="main_a8_main clearfix">
	        <?php echo W('Oncoo/helpList',array(1,4,10));?>
	    </div>
	    <div class="help_right">
	    	<?php echo showAdvPosition('common_help_right','div','false');?> 
	    </div>
    </div>
</div>




<div class="main_a9">
    <ul class="menu_onelayer clearfix"><li class="one_li cor_ff"> <a class="one_a" target="_self" href="">合作媒体</a></li><li class="one_li"> <a class="one_a" target="" href="">隐私保护</a></li><li class="one_li cor_ff"> <a class="one_a" target="" href="">版权声明</a></li><li class="one_li"> <a class="one_a" target="" href="">诚聘英才</a></li><li class="one_li cor_ff"> <a class="one_a" target="_self" href="baidu.com">一口价</a></li></ul>
    <div>
    <?php if(!empty($site['SITE_INFO']['tel'])): ?>客服电话：<?php echo ($site["SITE_INFO"]["tel"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <?php if(!empty($site['SITE_INFO']['service'])): ?>客服邮箱：<?php echo ($site["SITE_INFO"]["service"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <?php if(!empty($site['SITE_INFO']['address'])): ?>地址：<?php echo ($site["SITE_INFO"]["address"]); ?>&nbsp;&nbsp;<?php endif; ?>
    <br/>
    <?php echo ($site["SITE_INFO"]["name"]); ?>—<?php echo ($site["SITE_INFO"]["summary"]); ?>&nbsp;&nbsp;
    <?php echo ($site["SITE_INFO"]["name"]); ?>_<?php echo ($site["SITE_INFO"]["version"]); ?>&nbsp;&nbsp;
    <?php echo ($site["SITE_INFO"]["icp"]); ?>
    </div>
</div>
<!-- 底部浮动广告 -->
<a class="reg" id="reg" href="<?php echo U('Login/register');?>" target="_blank">
    <img src="/Public/Home/Img/regift.gif" width="43" height="43"/>
</a>
<!-- 底部浮动广告——结束 -->
<div class="linktips" id="linktips" >
    <ul>
        <li class="tipstit"></li>
        <?php if(!empty($site["SITE_INFO"]["tweibo"])): ?><li class="tipsweibo"><a href="<?php echo ($site["SITE_INFO"]["tweibo"]); ?>" target="_blank">关注微博</a></li><?php endif; ?>
        <li class="tipsweixin">
            <p>微信扫二维码</p>
            <div class="ad"><?php echo showAdvPosition('weixin','span','false');?> </div>
        </li>
        <li id="returnTop" class="tiptop"></li>
        <li class="tipbot"></li>
    </ul>
</div>


<script type="text/javascript">
var ajaxGetSpecialTime = "<?php echo U('Meeting/ajaxmeetinggettime');?>";
var ajaxCheckSpecialSucc = "<?php echo U('Meeting/checkmeetingsucc');?>";
var endDowntimer = [];
// 结束倒计时
function specialCountDown(ck,mid,etime,ntime,boxobj,day_elem,hour_elem,minute_elem,second_elem,msec_elem){
    var now_time = new Date(ntime*1000);
    var end_time = new Date(etime*1000);
    var native_time = new Date().getTime(); //本地时间
    var now_cha = now_time - native_time; //服务器和本地时间差
    var native_end_time = end_time - now_cha; //本地结束时间
    var sys_second = 0;
    endDowntimer['mid'] = setInterval(function(){
        // 检查本地时间是否更改
        if(Math.abs(native_time - new Date().getTime())>1000){
            clearInterval(endDowntimer['mid']);
            $.post(ajaxGetSpecialTime, {'ck':ck,'mid':mid},function(data){
                clearInterval(endDowntimer['mid']);
                specialCountDown(ck,mid,data.cktime,data.nowtime,boxobj,day_elem,hour_elem,minute_elem,second_elem,msec_elem);
            });
        }
        sys_second = (native_end_time - new Date().getTime())/100; //本地结束剩余时间
        if (sys_second > 0) {
            sys_second -= 1;
            var day = Math.floor((sys_second / 36000) / 24);
            var hour = Math.floor((sys_second / 36000) % 24);
            var minute = Math.floor((sys_second / 600) % 60);
            var second = Math.floor((sys_second/10) % 60);
            var msec = Math.floor(sys_second % 10); //毫秒
            day_elem && $(day_elem).text(day);//计算天
            $(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
            $(minute_elem).text(minute<10?"0"+minute:minute);//计算分
            $(second_elem).text(second<10?"0"+second:second);// 计算秒
            $(msec_elem).text(msec);// 计算秒的1/10
            native_time = new Date().getTime();
        } else { 
            clearInterval(endDowntimer['mid']);
            // 本地时间结束提交服务器验证是否结束
            $.post(ajaxCheckSpecialSucc, {'ck':ck,'mid':mid},function(cdata){
                if(cdata.status==0){
                    clearInterval(endDowntimer['mid']);
                    specialCountDown(ck,mid,cdata.cktime,cdata.nowtime,boxobj,day_elem,hour_elem,minute_elem,second_elem,msec_elem);
                }else{
                    $('.li'+mid).remove();
                    // popup.success(cdata.info);
                    // setTimeout(function(){
                    //     popup.close("asyncbox_success");
                    // },2000);
                    
                }
            });
        }
    }, 100);
}

</script>
</body>
</html>