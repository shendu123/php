<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>添加、编辑专场-后台管理-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='拍卖管理 > 添加编辑专场'; ?>
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
                        <div class="current">添加编辑专场</div>
                    </div>
                    <form>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="100">专场名：</th>
                                <td><input id="title" type="text" class="input" size="60" name="info[sname]" value="<?php echo ($info["sname"]); ?>"/></td>
                            </tr>
                            <tr>
                                <th>专场描述：</th>
                                <td><textarea class="input" style="height: 60px; width: 600px;" name="info[description]"><?php echo ($info["description"]); ?></textarea></td>
                            </tr>
                            <?php if(!$edit): ?><tr>
                                    <th>开始时间：</th>
                                    <td><input id="start_time" type="text" class="input" size="20" name="info[starttime]" value="<?php if(($info[starttime]) != ""): echo (date('Y-m-d H:i',$info["starttime"])); endif; ?>"/></td>
                                </tr>
                                <tr>
                                    <th>结束时间：</th>
                                    <td><input id="end_time" type="text" class="input" size="20" name="info[endtime]" value="<?php if(($info[starttime]) != ""): echo (date('Y-m-d H:i',$info["endtime"])); endif; ?>"/></td>
                                </tr>
                                <tr>
                                    <th width="100">保证金扣除模式：</th>
                                    <td>
                                        <select id="special_pledge_type" name="info[special_pledge_type]">
                                            <option value="0" <?php if(($info[special_pledge_type]) == "0"): ?>selected="selected"<?php endif; ?> >专场扣除</option>
                                            <option value="1" <?php if(($info[special_pledge_type]) == "1"): ?>selected="selected"<?php endif; ?> >分别扣除</option>
                                        </select>
                                        <span id="special_pledge"></span>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2">已开拍和已结束的专场禁止编辑开始时间、结束时间、保证金</td>
                                </tr><?php endif; ?>
                            <tr>
                                <th width="100">专场列表图：</th>
                                <td id="speListPicBox">
                                    <div class="up_btn_box">
                                        <div class="up_explain">图片格式：*.gif; *.jpg; *.png；尺寸：宽<?php echo C('SPECIAL_ICO_WIDTH');?>&nbsp; 高<?php echo C('SPECIAL_ICO_HEIGHT');?>。如果上传的图片让您看着不舒服，请检查图片尺寸是否符合要求</div>
                                        <div id="specPic_upload" class="btn up_but"><div class="up_but_ico"></div>上传图片</div>
                                        <div class="clearfix"></div>
                                        <ul id="uploadImageList" class="clearfix">
                                            <?php if(!empty($info[spicture])): ?><li class="photo"><img id="upImgSize" src="<?php echo ($upWholeUrl); echo ($info["spicture"]); ?>" width="<?php echo C('SPECIAL_ICO_WIDTH');?>" height="<?php echo C('SPECIAL_ICO_HEIGHT');?>"/>
                                            <div class="imper">
                                            <a class="delImg" picw="spicture" imgurl="<?php echo ($info["spicture"]); ?>" href="javascript:;"></a><a class="bigImg" href="<?php echo ($upWholeUrl); echo ($info["spicture"]); ?>"  target="_blank"></a></div>
                                            <input type="hidden" name="info[spicture]" value="<?php echo ($info["spicture"]); ?>" />
                                            </li><?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th width="100">专场BANNER图：</th>
                                <td id="specBannerPicBox" >
                                    <div class="up_btn_box">
                                        <div class="up_explain">图片格式：*.gif; *.jpg; *.png；尺寸：宽<?php echo C('SPECIAL_BANNER_WIDTH');?>&nbsp; 高<?php echo C('SPECIAL_BANNER_HEIGHT');?>。如果上传的图片让您看着不舒服，请检查图片尺寸是否符合要求</div>
                                        <div id="specBannerPic_upload" class="btn up_but"><div class="up_but_ico"></div>上传图片</div>
                                        <div class="clearfix"></div>
                                        <ul id="uploadImageList" class="clearfix">
                                            <?php if(!empty($info[sbanner])): ?><li class="photo"><img id="upImgSize" src="<?php echo ($upWholeUrl); echo ($info["sbanner"]); ?>" width="<?php echo C('SPECIAL_BANNER_WIDTH');?>" height="<?php echo C('SPECIAL_BANNER_HEIGHT');?>"/>
                                            <div class="imper">
                                            <a class="delImg" picw="sbanner" imgurl="<?php echo ($info["sbanner"]); ?>" href="javascript:;"></a><a class="bigImg" href="<?php echo ($upWholeUrl); echo ($info["sbanner"]); ?>"  target="_blank"></a></div>
                                            <input type="hidden" name="info[sbanner]" value="<?php echo ($info["sbanner"]); ?>" />
                                            </li><?php endif; ?>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <input type="hidden" name="info[sid]" value="<?php echo ($info["sid"]); ?>" />
                    </form>
                    <div class="commonBtnArea" >
                        <button class="btn submit">提交</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 隐藏数据 -->
        <!-- 保证金 -->
        <div id="ratio" class="hide">
            <input type="text" class="input" size="5" name="info[spledge]" value="<?php echo ($info["spledge"]); ?>" placeholder="保证金"/>&nbsp;&nbsp;仅需缴纳专场保证金，即可享有专场内所有商品的出价。未拍到：专场结束解冻保证金;拍到：支付所有专场订单解冻保证金。
        </div>
        <div id="fixation" class="hide">
            参拍专场内每件拍品都需要缴纳相应保证金。未拍到：商品结束解冻保证金；拍到：支付订单解冻保证金。
        </div>
        <!-- 保证金——end -->
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
    var spesId = "<?php echo ($info["sid"]); ?>";
    //初始化保证金字段
    repledge($('#special_pledge_type').val()); //初始化扩展字段
    $('#special_pledge_type').on("change",function(){
        var type = $(this).children('option:selected').val();
        repledge(type);
    });
    function repledge(special_pledge_type){
        if(special_pledge_type==0){
            $('#special_pledge').html($('#ratio').html());
        }else if(special_pledge_type==1){
            $('#special_pledge').html($('#fixation').html());
        }
    }
    $(function(){
        //为input添加时间插件
        $('#start_time').datetimepicker({lang:'ch'});
        $('#end_time').datetimepicker({lang:'ch'});

        //上传初始化变量
        var uplode_url = '<?php echo U("Upload/upSpecialIco");?>';//PHP处理脚本地址
        var uplode_path = '/Public'; //插件公共目录
        var sid = '<?php echo session_id();?>';//sessionID
        var upPathRoot="<?php echo ($upWholeUrl); ?>"; //图片上传根目录完整路径
        var uploadPath ="<?php echo C('UPLOADS_PICPATH');?>"; //图片上传根目录
        var specPicW = "<?php echo C('SPECIAL_ICO_WIDTH');?>";
        var specPicH = "<?php echo C('SPECIAL_ICO_HEIGHT');?>";
        // 列表图片上传【
        
            var uploaderLi = new plupload.Uploader({//创建实例的构造方法
                runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                browse_button: 'specPic_upload', // 上传按钮
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
                        if ($("#speListPicBox #uploadImageList").children("li").length > 1) {
                            alert("您上传的图片太多了！");
                            uploaderLi.destroy();
                        } else {
                            var li = '';
                            plupload.each(files, function(file) { //遍历文件
                                li += "<li class='photo' id='" + file['id'] + "'><div style='width: "+specPicW+"px;' class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                            $("#speListPicBox #uploadImageList").html(li);
                            uploaderLi.start();
                        }
                    },
                    UploadProgress: function(up, file) { //上传中，显示进度条
                 var percent = file.percent;
                        $("#" + file.id).find('.bar').css({"width": percent + "%"});
                        $("#" + file.id).find(".percent").text(percent + "%");
                    },
                    FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                        var data = JSON.parse(info.response);
                         $("#" + file.id).html('<img id="upImgSize" src="'+upPathRoot+data.path+'" width="'+specPicW+'" height="'+specPicH+'"/><div class="imper"><a class="delImg" imgurl="'+data.path+'" href="javascript:;"></a><a class="bigImg" href="'+uploadPath+data.path+'"  target="_blank"></a></div><input type="hidden" name="info[spicture]" value="'+data.path+'" />');
                    },
                    Error: function(up, err) { //上传出错的时候触发
                        alert(err.message);
                    }
                }
            });
            uploaderLi.init();
        
        // 列表图片上传】
        var uplodeBanner_url = '<?php echo U("Upload/upSpecialBnner");?>';//PHP处理脚本地址
        var specBannerPicW = "<?php echo C('SPECIAL_BANNER_WIDTH');?>";
        var specBannerPicH = "<?php echo C('SPECIAL_BANNER_HEIGHT');?>";
        // BANNER图片上传【
        
            var uploaderTop = new plupload.Uploader({//创建实例的构造方法
                runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                browse_button: 'specBannerPic_upload', // 上传按钮
                url: uplodeBanner_url, //远程上传地址
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
                        if ($("#specBannerPicBox #uploadImageList").children("li").length > 1) {
                            alert("您上传的图片太多了！");
                            uploaderTop.destroy();
                        } else {
                            var li = '';
                            plupload.each(files, function(file) { //遍历文件
                                li += "<li class='photo' id='" + file['id'] + "'><div style='width: "+specBannerPicW+"px;' class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                            $("#specBannerPicBox #uploadImageList").html(li);
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
                         $("#" + file.id).html('<img id="upImgSize" src="'+upPathRoot+data.path+'" width="'+specBannerPicW+'" height="'+specBannerPicH+'"/><div class="imper"><a class="delImg" imgurl="'+data.path+'" href="javascript:;"></a><a class="bigImg" href="'+uploadPath+data.path+'"  target="_blank"></a></div><input type="hidden" name="info[sbanner]" value="'+data.path+'" />');
                    },
                    Error: function(up, err) { //上传出错的时候触发
                        alert(err.message);
                    }
                }
            });
            uploaderTop.init();
        
        // BANNER图片上传】
         // 文章图片删除
        var delUrl = "<?php echo U('Auction/del_specpic');?>";
        $(document).on("click",".delImg",function(){
            var delImgUrl = $(this).attr('imgurl');
            var picw = $(this).attr('picw');
            var delDiv = $(this);
            $.post(delUrl,{'spesId':spesId,'picw':picw,'imgUrl':delImgUrl},function(data){      //ajax后台
                if (data.status) {
                    delDiv.parents('.photo').fadeOut().remove();

                    popup.success(data.msg);
                    setTimeout(function(){
                        popup.close("asyncbox_success");
                    },1000);
                } else {
                    alert(data.msg);
                }
            },'json');        
        });
        // 文章片删除_end
        $("#checkNewsTitle").click(function(){
            $.getJSON("/Admin/Auction/checkNewsTitle", { title:$("#title").val(),id:"<?php echo ($info["id"]); ?>"}, function(json){
                $("#checkNewsTitle").css("color",json.status==1?"#0f0":"#f00").html(json.info);
            });
        });
        $(".submit").click(function(){
            commonAjaxSubmit();
            return false;
        });
    });
</script>
    </body>
</html>