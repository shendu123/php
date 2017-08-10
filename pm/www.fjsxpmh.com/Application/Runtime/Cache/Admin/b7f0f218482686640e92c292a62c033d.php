<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>
            资金统计-<?php echo ($site["SITE_INFO"]["name"]); ?>
        </title>
        <?php $currentNav ='资金统计'; ?>
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
                            <div class="current">网站账户信息</div>
                        </div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="10%" align="right">余额信息：</th>
                                <td>
                                    共计：<?php echo ($walletsum["wallet_pledge"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    冻结：<?php echo ($walletsum["wallet_pledge_freeze"]); ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                    可用：<?php echo ($walletsum["wallet_pledge_usable"]); ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">信誉额度信息：</th>
                                <td>
                                    共计：<?php echo ($walletsum["wallet_limsum"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    冻结：<?php echo ($walletsum["wallet_limsum_freeze"]); ?> &nbsp;&nbsp;&nbsp;&nbsp;
                                    可用：<?php echo ($walletsum["wallet_limsum_usable"]); ?>
                                </td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">佣金：</th>
                                <td>
                                    已收：<?php echo ($walletsum["broker"]); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    待收：<?php echo ($walletsum["broker_predict"]); ?>
                                </td>
                            </tr>
                        </table>
                        <div class="Item hr clearfix">
                            <div class="current"><?php if(empty($keys["account"])): ?>网站<?php else: echo ($keys["account"]); endif; ?>账户详情</div>
                            <form class="fr" action="<?php echo U('Index/statistics');?>" method='get'>
                                开始时间：<input id="start_time" type="text" value="<?php echo ($keys["start_time"]); ?>" name="start_time" class="input" placeholder="默认为建站时间" />&nbsp;&nbsp;
                                结束时间：<input id="end_time" type="text" value="<?php echo ($keys["end_time"]); ?>" name="end_time" class="input" placeholder="默认为当前时间" />&nbsp;&nbsp;
                                用户账号：<input type="text" value="<?php echo ($keys["account"]); ?>" name="account" class="input" placeholder="请输入用户" />&nbsp;&nbsp;
                                &nbsp;&nbsp;<button class="btn">筛选</button>
                            </form>
                        </div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="10%" align="right">佣金：</th>
                                <td>
                                    已收：<?php echo ((isset($walletsum["broker_where"]) && ($walletsum["broker_where"] !== ""))?($walletsum["broker_where"]):0); ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                    待收：<?php echo ((isset($walletsum["broker_where_predict"]) && ($walletsum["broker_where_predict"] !== ""))?($walletsum["broker_where_predict"]):0); ?>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10"><strong>余额信息</strong></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">
                                    <?php if(($keys["start_time"]) == ""): ?>建站时间&nbsp;至&nbsp;<?php else: echo ($keys["start_time"]); ?>&nbsp;至&nbsp;<?php endif; if(($keys["end_time"]) == ""): ?>当前时间<?php else: echo ($keys["end_time"]); endif; ?>：
                                </th>
                                <td>
                                    余额：<strong><?php echo ((isset($walletsum["wallet_pledge_where"]) && ($walletsum["wallet_pledge_where"] !== ""))?($walletsum["wallet_pledge_where"]):0); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    冻结：<strong><?php echo ((isset($walletsum["wallet_pledge_where_freeze"]) && ($walletsum["wallet_pledge_where_freeze"] !== ""))?($walletsum["wallet_pledge_where_freeze"]):0); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    可用：<strong><?php echo ((isset($walletsum["wallet_pledge_where_usable"]) && ($walletsum["wallet_pledge_where_usable"] !== ""))?($walletsum["wallet_pledge_where_usable"]):0); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10"><strong>余额详情</strong></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">拍卖冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_bid_expend"]) && ($walletsum["wallet_pledge_bid_expend"] !== ""))?($walletsum["wallet_pledge_bid_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'bid_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">发布拍卖冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_add_expend"]) && ($walletsum["wallet_pledge_add_expend"] !== ""))?($walletsum["wallet_pledge_add_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'add_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_admin_freeze"]) && ($walletsum["wallet_pledge_admin_freeze"] !== ""))?($walletsum["wallet_pledge_admin_freeze"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'admin_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">提现冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_take_freeze"]) && ($walletsum["wallet_pledge_take_freeze"] !== ""))?($walletsum["wallet_pledge_take_freeze"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'extract_freeze'));?>">查看记录</a></td>
                            </tr>

                            <tr>
                                <th width="10%" align="right">拍卖解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_bid_income"]) && ($walletsum["wallet_pledge_bid_income"] !== ""))?($walletsum["wallet_pledge_bid_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'bid_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            
                            <tr>
                                <th width="10%" align="right">交易成功解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_add_income"]) && ($walletsum["wallet_pledge_add_income"] !== ""))?($walletsum["wallet_pledge_add_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'add_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_admin_unfreeze"]) && ($walletsum["wallet_pledge_admin_unfreeze"] !== ""))?($walletsum["wallet_pledge_admin_unfreeze"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'admin_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">在线充值：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_inlin_income"]) && ($walletsum["wallet_pledge_inlin_income"] !== ""))?($walletsum["wallet_pledge_inlin_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'pay_deposit'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">交易收入：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_profit_income"]) && ($walletsum["wallet_pledge_profit_income"] !== ""))?($walletsum["wallet_pledge_profit_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'profit'));?>">查看记录</a></td>
                            </tr>

<!--                             <tr>
                                <th width="10%" align="right">分享奖励：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_share_income"]) && ($walletsum["wallet_pledge_share_income"] !== ""))?($walletsum["wallet_pledge_share_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'share'));?>">查看记录</a></td>
                            </tr> -->
                            <tr>
                                <th width="10%" align="right">管理员充值：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_admin_income"]) && ($walletsum["wallet_pledge_admin_income"] !== ""))?($walletsum["wallet_pledge_admin_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'admin_deposit'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">买家订单过期收入：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_seller_break_nopay"]) && ($walletsum["wallet_pledge_seller_break_nopay"] !== ""))?($walletsum["wallet_pledge_seller_break_nopay"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'seller_break_nopay'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">卖家未按时发货收入：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_buy_break_deliver"]) && ($walletsum["wallet_pledge_buy_break_deliver"] !== ""))?($walletsum["wallet_pledge_buy_break_deliver"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'buy_break_deliver'));?>">查看记录</a></td>
                            </tr>
                            
                            <tr>
                                <th width="10%" align="right">保证金抵货款：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_paypledge_expend"]) && ($walletsum["wallet_pledge_paypledge_expend"] !== ""))?($walletsum["wallet_pledge_paypledge_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'pay_pledge'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">支付扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_pay_expend"]) && ($walletsum["wallet_pledge_pay_expend"] !== ""))?($walletsum["wallet_pledge_pay_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'pay_deduct'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">提现扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_take"]) && ($walletsum["wallet_pledge_take"] !== ""))?($walletsum["wallet_pledge_take"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'extract'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_admin_expend"]) && ($walletsum["wallet_pledge_admin_expend"] !== ""))?($walletsum["wallet_pledge_admin_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'admin_deduct'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">订单过期扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_buy_break_nopay"]) && ($walletsum["wallet_pledge_buy_break_nopay"] !== ""))?($walletsum["wallet_pledge_buy_break_nopay"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'buy_break_nopay'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">未按时发货扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_pledge_seller_break_deliver"]) && ($walletsum["wallet_pledge_seller_break_deliver"] !== ""))?($walletsum["wallet_pledge_seller_break_deliver"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'seller_break_deliver'));?>">查看记录</a></td>
                            </tr>
                            
                            <tr>
                                <td colspan="10"><strong>信誉额度信息</strong></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">
                                    <?php if(($keys["start_time"]) == ""): ?>建站时间&nbsp;至&nbsp;<?php else: echo ($keys["start_time"]); ?>&nbsp;至&nbsp;<?php endif; if(($keys["end_time"]) == ""): ?>当前时间<?php else: echo ($keys["end_time"]); endif; ?>：
                                </th>
                                <td>
                                    信誉额度：<strong><?php echo ((isset($walletsum["wallet_limsum_where"]) && ($walletsum["wallet_limsum_where"] !== ""))?($walletsum["wallet_limsum_where"]):0); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    冻结：<strong><?php echo ((isset($walletsum["wallet_limsum_where_freeze"]) && ($walletsum["wallet_limsum_where_freeze"] !== ""))?($walletsum["wallet_limsum_where_freeze"]):0); ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;
                                    可用：<strong><?php echo ((isset($walletsum["wallet_limsum_where_usable"]) && ($walletsum["wallet_limsum_where_usable"] !== ""))?($walletsum["wallet_limsum_where_usable"]):0); ?></strong>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="10"><strong>信誉额度详情</strong></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">拍卖冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_bid_expend"]) && ($walletsum["wallet_limsum_bid_expend"] !== ""))?($walletsum["wallet_limsum_bid_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'bid_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">发布拍卖冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_add_expend"]) && ($walletsum["wallet_limsum_add_expend"] !== ""))?($walletsum["wallet_limsum_add_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'add_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员冻结：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_admin_freeze"]) && ($walletsum["wallet_limsum_admin_freeze"] !== ""))?($walletsum["wallet_limsum_admin_freeze"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'admin_freeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">拍卖解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_bid_income"]) && ($walletsum["wallet_limsum_bid_income"] !== ""))?($walletsum["wallet_limsum_bid_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'bid_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            
                            <tr>
                                <th width="10%" align="right">交易成功解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_add_income"]) && ($walletsum["wallet_limsum_add_income"] !== ""))?($walletsum["wallet_limsum_add_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'add_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员解冻：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_admin_unfreeze"]) && ($walletsum["wallet_limsum_admin_unfreeze"] !== ""))?($walletsum["wallet_limsum_admin_unfreeze"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'admin_unfreeze'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">分享奖励：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_share_income"]) && ($walletsum["wallet_limsum_share_income"] !== ""))?($walletsum["wallet_limsum_share_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'share'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">买家订单过期收入：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_seller_break_nopay"]) && ($walletsum["wallet_limsum_seller_break_nopay"] !== ""))?($walletsum["wallet_limsum_seller_break_nopay"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'seller_break_nopay'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">卖家未按时发货收入：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_buy_break_deliver"]) && ($walletsum["wallet_limsum_buy_break_deliver"] !== ""))?($walletsum["wallet_limsum_buy_break_deliver"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'buy_break_deliver'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">订单过期扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_buy_break_nopay"]) && ($walletsum["wallet_limsum_buy_break_nopay"] !== ""))?($walletsum["wallet_limsum_buy_break_nopay"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'buy_break_nopay'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">未按时发货扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_seller_break_deliver"]) && ($walletsum["wallet_limsum_seller_break_deliver"] !== ""))?($walletsum["wallet_limsum_seller_break_deliver"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'seller_break_deliver'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">管理员充值：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_admin_income"]) && ($walletsum["wallet_limsum_admin_income"] !== ""))?($walletsum["wallet_limsum_admin_income"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'admin_deposit'));?>">查看记录</a></td>
                            </tr>

                            <tr>
                                <th width="10%" align="right">管理员扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_admin_expend"]) && ($walletsum["wallet_limsum_admin_expend"] !== ""))?($walletsum["wallet_limsum_admin_expend"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'wallet'=>'limsum','changetype'=>'admin_deduct'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">订单过期扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_buy_break_nopay"]) && ($walletsum["wallet_limsum_buy_break_nopay"] !== ""))?($walletsum["wallet_limsum_buy_break_nopay"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'buy_break_nopay'));?>">查看记录</a></td>
                            </tr>
                            <tr>
                                <th width="10%" align="right">未按时发货扣除：</th>
                                <td><?php echo ((isset($walletsum["wallet_limsum_seller_break_deliver"]) && ($walletsum["wallet_limsum_seller_break_deliver"] !== ""))?($walletsum["wallet_limsum_seller_break_deliver"]):0); ?>&nbsp;&nbsp;<a target="_blank" href="<?php echo U('Member/walletbill',array('start_time'=>$keys['start_time'],'end_time'=>$keys['end_time'],'account'=>$keys['account'],'changetype'=>'seller_break_deliver'));?>">查看记录</a></td>
                            </tr>
                        </table>
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
    </body>
<!-- 日期时间插件 -->
<link rel="stylesheet" type="text/css" href="/Public/Js/datetimepicker/jquery.datetimepicker.css" />
<script type="text/javascript" src="/Public/Js/datetimepicker/jquery.datetimepicker.js"></script>
<!-- 日期时间插件 -->
<script type="text/javascript">
    //为input添加时间插件
    $('#start_time').datetimepicker({lang:'ch'});
    $('#end_time').datetimepicker({lang:'ch'});
</script>
</html>