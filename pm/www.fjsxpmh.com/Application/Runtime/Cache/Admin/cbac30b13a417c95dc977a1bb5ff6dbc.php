<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8">
    <title>添加、编辑用户-用户管理-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
    <?php $currentNav ='用户管理 > 添加、编辑用户'; ?>
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
<div class="wrap"> <div id="Top">
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
    <div class="mainBody"> <div id="Left">
    <div id="control" class=""></div>
    <div class="subMenuList">
        <div class="itemTitle"><?php if(CONTROLLER_NAME == 'Index'): ?>常用操作<?php else: ?>子菜单<?php endif; ?> </div>
        <ul>
            <?php if(is_array($sub_menu)): foreach($sub_menu as $key=>$sv): ?><li><a href="<?php echo ($sv["url"]); ?>"><?php echo ($sv["title"]); ?></a></li><?php endforeach; endif; ?>
        </ul>
    </div>

</div>
        <div id="Right">
            <div class="contentArea">
                
                <form action="" method="post">
                    <div class="Item hr clearfix">
                        <div class="current">基本信息</div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th>登录账号：</th>
                            <td><input name="info[account]" type="text" class="input" size="30" value="<?php echo ($info["account"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">密码：</th>
                            <td><input name="info[pwd]" type="password" class="input" size="30" value="" />  不修改留空</td>
                        </tr>
                        <tr>
                            <th width="120">昵称：</th>
                            <td><input name="info[nickname]" type="text" class="input" size="20" value="<?php echo ($info["nickname"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">真实姓名：</th>
                            <td><input name="info[truename]" type="text" class="input" size="20" value="<?php echo ($info["truename"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">买家得分：</th>
                            <td><input name="info[scorebuy]" type="text" class="input" size="10" value="<?php echo ($info["scorebuy"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">个性签名：</th>
                            <td><input name="info[intr]" type="text" class="input" size="40" value="<?php echo ($info["intr"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">性别：</th>
                            <td>
                                <label>
                                    <input type="radio" name="info[sex]" value="1" <?php if($info['sex'] == 1): ?>checked<?php endif; ?> >男
                                </label>
                                <label><input type="radio" name="info[sex]" value="0" <?php if($info['sex'] == 0): ?>checked<?php endif; ?>>女</label></td>
                        </tr>
                        
                        <tr>
                            <th>邮箱：</th>
                            <td>
                                <input name="info[email]" type="text" class="input" size="30" value="<?php echo ($info["email"]); ?>" />
                                <label>
                                    <input type="radio" name="info[verify_email]" value="1" <?php if($info['verify_email'] == 1): ?>checked<?php endif; ?>>已认证
                                </label>
                                <label>
                                    <input type="radio" name="info[verify_email]" value="0" <?php if($info['verify_email'] == 0): ?>checked<?php endif; ?>>未认证
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <th width="120">手机号码：</th>
                            <td>
                                <input name="info[mobile]" type="text" class="input" size="30" value="<?php echo ($info["mobile"]); ?>" />
                                <label>
                                    <input type="radio" name="info[verify_mobile]" value="1" <?php if($info['verify_mobile'] == 1): ?>checked<?php endif; ?>>已认证
                                </label>
                                <label>
                                    <input type="radio" name="info[verify_mobile]" value="0" <?php if($info['verify_mobile'] == 0): ?>checked<?php endif; ?>>未认证
                                </label>
                            </td>
                        </tr>
                        
<!--                         <tr>
                            <th width="120">QQ：</th>
                            <td><input name="info[qq]" type="text" class="input" size="30" value="<?php echo ($info["qq"]); ?>" /></td>
                        </tr> -->
                        <tr>
                            <th width="120">固定电话：</th>
                            <td><input name="info[phone]" type="text" class="input" size="30" value="<?php echo ($info["phone"]); ?>" /></td>
                        </tr>
                        <tr class="clearfix">
                            <th>邮政编码：</th>
                            <td><input name="info[postalcode]" class="input" type="text" value="<?php echo ($info["postalcode"]); ?>" /></td>
                        </tr>
                        <tr class="clearfix">
                            <th>地址：</th>
                            <td>
                                <?php echo W('Home/Oncoo/region',array($info[province],$info[city],$info[area],3));?>
                            </td>
                        </tr>
                        <tr class="clearfix">
                            <th>街道地址：</th>
                            <td><textarea name="info[address]" class="input" style=" padding: 5px; width:350px; height:48px;" placeholder="不需要重复填写省市区，必须大于5个字符，小于120个字符"><?php echo ($info["address"]); ?></textarea></td>
                        </tr>

                        <tr>
                            <th width="120">状态：</th>
                            <td>
                                <label>
                                    <input type="radio" name="info[status]" value="1" <?php if($info['status'] == 1): ?>checked<?php endif; ?> >启用
                                </label>
                                <label><input type="radio" name="info[status]" value="0" <?php if($info['status'] == 0): ?>checked<?php endif; ?>>禁用</label></td>
                        </tr>
                    </table>

                    <div class="Item hr clearfix">
                        <div class="current">卖家信息</div>
                    </div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                        <tr>
                            <th width="120">卖家得分：</th>
                            <td><input name="info[score]" type="text" class="input" size="10" value="<?php echo ($info["score"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">卖家名称：</th>
                            <td><input name="info[organization]" type="text" class="input" size="30" value="<?php echo ($info["organization"]); ?>" /></td>
                        </tr>
                        <tr>
                            <th width="120">卖家简介：</th>
                            <td><textarea name="info[intro]" class="input" style=" padding: 5px; width:350px; height:48px;"><?php echo ($info["intro"]); ?></textarea></td>
                        </tr>
                    </table>
                    <input type="hidden" name="uid" value="<?php echo ($info["uid"]); ?>"/>
                </form>
                <div class="commonBtnArea" >
                    <button class="btn submit">提交</button>
                </div>
            </div>
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
        $(".submit").click(function(){
            commonAjaxSubmit();
            return false;
        });
    });
</script>
</body>
</html>