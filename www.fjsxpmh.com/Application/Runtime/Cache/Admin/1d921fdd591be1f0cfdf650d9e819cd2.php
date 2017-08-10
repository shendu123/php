<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>商品分类管理-商品管理-后台管理首页-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='商品管理 > 商品分类管理'; ?>
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
                        <div class="current">商品分类管理</div>
                    </div>
                    <form action="" method="post" class="userInfo clearfix formConfl" id="quickForm">
                        <b class="fl thead">添加频道、分类：</b>
                        <input class="fl" type="hidden" name="act" value="add" /> &nbsp;
                        <select class="fl" name="data[pid]">
                            <option value="0">商品频道</option>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["fullname"]); if(($vo[pid]) == "0"): ?>--&lt;频道&gt;<?php endif; ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>  &nbsp;
                        <input placeholder="你要添加的频道、分类名称" id="newName" size="25" class="input fl" type="text" name="data[name]" value="" /> &nbsp;

                        <div class="up_cate_ico fl clearfix">
                            <div class="checkIco clearfix" check="0">
                                <div class="fl hd_ico"></div>
                                <div class="fl">图标</div>
                            </div>
                            <div class="fl catimg">无</div>
                            <input class="icoPath" type="hidden" name="data[ico]" value="" />
                            <span class="notes hidden">*图标尺寸应为<?php echo ($cateW); ?>*<?php echo ($cateH); ?>！</span>
                        </div>

                        <button class="btn quickSubmit fl">确定添加</button>
                        <span class="knack">小窍门：添加多个用,号隔开</span>
                    </form>
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tab">
                        <thead>
                            <tr align="center">
                                <td width="5%">CID</td>
                                <td width="18%">原分类结构 <b title="单击分类隐藏/显示该分类下在子类">[i]</b></td>
                                
                                <td width="15%" align="left">操作属性</td>
                                <td width="15%">新分类</td>
                                <td width="5%">新名称</td>
                                <td width="17%">分类图标</td>
                                <td width="5%">排序</td>
                                
                                <td width="5%">推荐</td>
                                <td width="5%">URL</td>
                                <td width="10%">操作</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tree): $mod = ($i % 2 );++$i;?><tr pid="<?php echo ($tree["pid"]); ?>" cid="<?php echo ($tree["cid"]); ?>">
                                    <td align="center"><?php echo ($tree["cid"]); ?><input type="hidden" name="cid" value="<?php echo ($tree["cid"]); ?>"/></td>
                                    <td class="tree" style="cursor: pointer;"><?php echo ($tree["fullname"]); if(($tree[pid]) == "0"): ?>--&lt;频道&gt;<?php endif; ?></td>
                                    <td align="center">
                                        <select name="act" class="act">
                                            <option selected="selected" value="edit">修改该分类</option>
                                            <?php if(!in_array(($tree["cid"]), is_array($lock_id[goods])?$lock_id[goods]:explode(',',$lock_id[goods]))): ?><option value="del">删除该分类</option><?php endif; ?>
                                            <option value="add">在该分类中添加子类</option>
                                        </select>
                                    </td>
                                    <td align="center">
                                        <a class="editpre" href="javascript:void(0);">修改父类</a>
                                    </td>
                                    <td><input type="text" value="" size="6" name="name" class="input" placeholder="新名称"/></td>
                                    <td>
                                        <div class="clearfix">
                                            <div class="up_cate_ico fl clearfix">
                                                <div class="checkIco clearfix" check="0">
                                                    <div class="fl hd_ico"></div>
                                                    <div class="fl">设图标</div>
                                                </div>
                                                <div class="fl catimg">
                                                    <?php if(empty($tree[ico])): ?>无<?php else: ?>
                                                        <img src="<?php echo ($upWholeUrl); echo ($tree["ico"]); ?>" width="26" height="26"><?php endif; ?>
                                                </div>
                                                
                                                <input class="icoPath" type="hidden" name="ico" value="<?php echo ($tree["ico"]); ?>" />
                                            </div>
                                            <?php if(!empty($tree[ico])): ?><a title="删除图标" class="delBtn delIco fr" cid="<?php echo ($tree["cid"]); ?>" href="javascript:void(0);"></a><?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="ajax_order" style="margin: 0px auto; text-align: center;">
                                            <a href="javascript:void(0)" class="rising">加</a>
                                            <span cid="<?php echo ($tree["cid"]); ?>" class="input"><?php echo ($tree["sort"]); ?></span>
                                            <a href="javascript:void(0)" class="drop">减</a>
                                        </div>
                                    </td>
                                    <td>
                                        <label><input type="checkbox" name="hot" style="vertical-align: sub;" <?php if(($tree["hot"]) == "1"): ?>checked="checked"<?php endif; ?> > 推荐</label>
                                    </td>
                                    <td align="center">
                                        <a target="_blank" href="<?php echo U('Home/Auction/index',array('gt'=>$tree[cid]));?>">查看</a>
                                    </td>
                                    <td align="center"><button class="btn opCat">确定</button></td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <form action="" method="post" id="opForm">
            <input id="cid" type="hidden" name="data[cid]" />
            <input id="act" type="hidden" name="act" />
            <input id="pid" type="hidden" name="data[pid]" />
            <input id="hot" type="hidden" name="data[hot]" />
            <input id="name" type="hidden" name="data[name]" />
            <input id="ico" type="hidden" name="data[ico]" />
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
                <option value="0">选择父类</option>
                <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo1): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo1["cid"]); ?>"><?php echo ($vo1["fullname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
        </div>
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
    // 异步排序地址
    var odUrl = "<?php echo U('Goods/order_cate');?>"
    // 读取系统图片配置
    var cateW = '<?php echo ($cateW); ?>';
    var cateH = '<?php echo ($cateH); ?>';
    $(function(){
        $(document).on('click','.editpre',function(){
            $(this).parents('td').html($('#cateoption').html());
        });
        // 删除分类图标
        var delPostUrl = "<?php echo U('Goods/delIco');?>";
        $('.delIco').click(function(){
            var delBut = $(this);
            var delCid = $(this).attr('cid');

            var delCon = $(this).prev('.up_cate_ico').children('.catimg');
            var delImgUrl = $(this).prev('.up_cate_ico').children('.icoPath').attr('value');

            $.post(delPostUrl,{'cid':delCid,'imgUrl':delImgUrl},function(data){      //ajax后台
                if (data.status) {
                    delCon.html('无');
                    delBut.remove();
                } else {
                    alert(data.msg);
                }
            },'json');   
        });
        // 分类图标上传
        var upPathRoot="<?php echo ($upWholeUrl); ?>"; //图片上传根目录完整路径
        var uplode_url = '<?php echo U("Upload/upCateIco");?>';//PHP处理脚本地址
        var uplode_path = '/Public';
        var sid = '<?php echo session_id();?>';//sessionID
        $('.checkIco').click(function(){
            var thisParBox = $(this).parents('.up_cate_ico');

            remove_upUsb(); 
            //初始化复选框
            if($(this).attr('check') == 0){
                $('.checkIco').attr('check',0);
                $('.hd_ico').removeClass("act");
                $(this).attr('check',1);
                $(this).children('.hd_ico').addClass("act");
            }else if($(this).attr('check') == 1){
                $(this).attr('check',0);
                $(this).children('.hd_ico').removeClass("act");
            }
            //添加上传插件
            if($(this).attr('check') == 1){
                thisParBox.children('.catimg').after('<span id="upCateIco" class="up_btn fl"><span class="up_ico">&nbsp;</span>上传</span>');
                thisParBox.children('.notes').show();
                var imgBox = thisParBox.children('.catimg');

                // 列表图片上传【
                
                    var uploader = new plupload.Uploader({//创建实例的构造方法
                        runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                        browse_button: 'upCateIco', // 上传按钮
                        url: uplode_url, //远程上传地址
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
                                $("#upCateIco").after("<div style='width: 110px;' class='progress fl'><span class='bar'></span><span class='percent'>0%</span></div>");
                                uploader.start();
                            },
                            UploadProgress: function(up, file) { //上传中，显示进度条
                         var percent = file.percent;
                                $(".progress .bar").css({"width": percent + "%"});
                                $(".progress .percent").text(percent + "%");
                            },
                            FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                                var data = JSON.parse(info.response);
                                var ranNub=parseInt(Math.random()*100);
                                imgBox.html('<img class="cateIco" src="'+upPathRoot+data.path+'" width="26" height="26"/>');
                                thisParBox.children('.icoPath').attr("value",data.path);
                                $(".progress").remove();
                            },
                            Error: function(up, err) { //上传出错的时候触发
                                alert(err.message);
                            }
                        }
                    });
                    uploader.init();
                
                // 列表图片上传】
            }else{
                remove_upUsb();
            }
        });
        function remove_upUsb(){
            $('.up_cate_ico #upCateIco').remove();
            $('.up_cate_ico #upCateIco-queue').remove();
            $('.up_cate_ico .notes').hide();
        }
        //分类图标上传_end
        // 字段异步排序
        $('.ajax_order a').on("click",function(){
            var odType = $(this).attr('class');
            var odShow = $(this).parents('.ajax_order').children('.input');
            var odVal = odShow.html();
            var cid = odShow.attr('cid');
            $.post(odUrl,{'odType':odType,'cid':cid},function(data){      //ajax后台
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
            $("#cid").val(obj.find("input[name='cid']").val());
            $("#act").val(obj.find("select[name='act']").val());
            if(obj.find("select[name='pid']").val()){
                $("#pid").val(obj.find("select[name='pid']").val());
            }else{
                $("#pid").val(obj.attr('pid'));
            }
            $("#name").val(obj.find("input[name='name']").val());
            $("#ico").val(obj.find("input[name='ico']").val());
            $("#hot").val(obj.find("input[name='hot']").val());
            if(obj.find("input[name='hot']").prop("checked")){
                $("#hot").val(1);
            }else{
                $("#hot").val(0);
            }
            if($("#act").val()=="del"){
                popup.confirm('你真的打算删除该分类吗?','温馨提示',function(action){
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
                popup.alert("分类名称不能为空滴！");
                return false;
            }
            commonAjaxSubmit("","#quickForm");
            return false;
        });

        var chn=function(cid,op){
            if(op=="show"){
                $("tr[pid='"+cid+"']").each(function(){
                    $(this).removeAttr("status").show();
                    chn($(this).attr("cid"),"show");
                });
            }else{
                $("tr[pid='"+cid+"']").each(function(){
                    $(this).attr("status",1).hide();
                    chn($(this).attr("cid"),"hide");
                });
            }
        }
        $(".tree").click(function(){
            if($(this).attr("status")!=1){
                chn($(this).parent().attr("cid"),"hide");
                $(this).attr("status",1);
            }else{
                chn($(this).parent().attr("cid"),"show");
                $(this).removeAttr("status");
            }
        });
    });
</script>
    </body>
</html>