<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>添加、编辑商品-后台管理-<?php echo ($site["SITE_INFO"]["name"]); ?></title>
        <?php $currentNav ='商品管理 > 添加编辑商品'; ?>
<base href="<?php echo ($site["WEB_ROOT"]); ?>"/>

<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/base.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/layout.css" />
<link rel="stylesheet" type="text/css" href="/Public/Admin/Css/common.css" />
<link rel="stylesheet" type="text/css" href="/Public/Css/pop_status.css" />
<link rel="stylesheet" type="text/css" href="/Public/Js/asyncbox/skins/default.css" />
<script type="text/javascript" src="/Public/Js/jquery-1.7.2.min.js"></script>
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
                        <div class="current">添加编辑商品</div>
                    </div>
                    <form id="goodsForm">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table1">
                            <tr>
                                <th width="150">所属用户：</th>
                                <td>
                                    根据：
                                        <select id="ac-field">
                                            <option value="account">账号</option>
                                            <option value="nickname">昵称</option>
                                            <option value="email">邮箱</option>
                                            <option value="mobile">手机</option>
                                            <option value="uid">用户UID</option>
                                        </select>
                                        查找：
                                        <input type="text" id="ac-keyword" class="input" placeholder="搜索对应字段关键字" />
                                        &nbsp;&nbsp;<a href="javascript:void(0);" class="btn searchbtn">筛选</a>
                                        <div id="ac-userbox">
                                            <?php if(($info["sellerid"]) != "0"): ?><div class="clearfix" style="margin-top: 10px; line-height: 22px;">
                                                    <img class="usimg" src="<?php echo (getuserpic($info["sellerid"],2)); ?>" alt="" />
                                                    <p class="fl">账号：<?php echo ($info["seller"]["account"]); ?><br/>昵称：<?php echo ($info["seller"]["nickname"]); ?></p>
                                                    <input type="hidden" name="info[sellerid]" value="<?php echo ($info["sellerid"]); ?>" />
                                                </div><?php endif; ?>
                                        </div>
                                        
                                </td>
                            </tr>
                            
                                <tr>
                                    <th width="150">商品标题：</th>
                                    <td><input id="title" type="text" class="input" size="60" name="info[title]" value="<?php echo ($info["title"]); ?>"/></td>
                                </tr>
                                <tr>
                                    <th>所属频道、分类：</th>
                                    <td>
                                        <select id="cateSel" name="info[cid]">
                                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo[cid] == $info[cid]): ?><option value="<?php echo ($vo["cid"]); ?>" selected="selected"><?php echo ($vo["fullname"]); if(($vo[pid]) == "0"): ?>--&lt;频道&gt;<?php endif; ?></option>
                                                    <?php else: ?>
                                                    <option value="<?php echo ($vo["cid"]); ?>"><?php echo ($vo["fullname"]); if(($vo[pid]) == "0"): ?>--&lt;频道&gt;<?php endif; ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>地区：</th>
                                    <td id="region_box">
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>筛选条件：</th>
                                    <td>
                                        <div id="filtHtml"></div>
                                        <input type="hidden" name="info[filtrate]" value="<?php echo ($info["filtrate"]); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>商品价格：</th>
                                    <td><input type="text" class="input" size="10" name="info[price]" value="<?php echo ($info["price"]); ?>"/></td>
                                </tr>
                                <tr>
                                    <th>商品关键词：</th>
                                    <td><input type="text" class="input" size="60" name="info[keywords]" value="<?php echo ($info["keywords"]); ?>"/> 多关键词间用半角逗号（,）分开，用于SEO的keywords、商品关键词的检索和显示</td>
                                </tr>
                                <tr>
                                    <th>商品描述：</th>
                                    <td><textarea class="input" style="height: 60px; width: 600px;" name="info[description]"><?php echo ($info["description"]); ?></textarea> 用于SEO的description和商品详细页的商品描述</td>
                                </tr>
                                
                                <tr>
                                    <th>商品内容：</th>
                                    <td>
                                        <div id="tab">
                                           <div id="tab_menu">
                                              <ul class="clearfix">
                                                    <li class="selected">商品详情</li>
                                              </ul>
                                           </div>
                                           <div id="tab_box">
                                                <div >
                                                    <textarea id="content" style="width: 88%; height:400px;" name="info[content]"><?php echo ($info["content"]); ?></textarea>
                                                </div>
                                           </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>商品图片：</th>
                                    <td>
                                        <div class="up_btn_box">
                                            <div class="up_explain">
                                            下面是上传的图片，如果图片看着不舒服，可以点击小剪刀来修剪一下！
                                            </div>
                                            <div id="goodsPic_upload" class="btn up_but"><div class="up_but_ico"></div>上传图片</div>
                                        </div>
                                        <div class="cuitclear"></div>
                                        <ul id="uploadImageList" class="clearfix">
                                            <?php if(!empty($info[pictures])): if(is_array($info[pictures])): foreach($info[pictures] as $key=>$pv): ?><li class="photo">
                                                        <img src="<?php echo ($upWholeUrl); echo (picrep($pv,3)); ?>" width="<?php echo picSize(3,'width');?>" height="<?php echo picSize(3,'height');?>" />
                                                        <div class="imper clearfix">
                                                            <a class="delImg" title="删除" imgurl="<?php echo ($pv); ?>" href="javascript:;"></a>
                                                            <a class="bigImg" title="大图" href="<?php echo C('UPLOADS_PICPATH'); echo (picrep($pv,1)); ?>"  target="_blank"></a>
                                                            <a class="cutImg" title="裁剪" imgurl="<?php echo ($upWholeUrl); echo (picrep($pv,0)); ?>" href="javascript:;"></a>
                                                        </div>
                                                        <input type="hidden" name="pic[]" value="<?php echo ($pv); ?>" />
                                                    </li><?php endforeach; endif; endif; ?>
                                        </ul>
                                        <input name="list1SortOrder" type="hidden" />
                                    </td>
                                </tr>
                                <input type="hidden" name="info[id]" value="<?php echo ($info["id"]); ?>" />
                        </table>
                    </form>
                    <div class="commonBtnArea" >
                        <button to="" class="btn submit">保存</button>
                        <button to="js" class="btn submit">保存【去发布到单品拍】</button>
                        <button to="zc" class="btn submit">保存【去发布到专场】</button>
                        <button to="pmh" class="btn submit">保存【去发布到拍卖会】</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="region" class="hide"><?php echo W('Oncoo/region',array($info[province],$info['city'],$info['area'],$info['layer']));?></div>
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
<!-- 选项卡 -->
<script type="text/javascript" src="/Public/Admin/Js/tab.js"></script>
<!-- 拖动排序 -->
<script type="text/javascript" src="/Public/Js/jquery.dragsort-0.5.1.min.js"></script>
<!-- Ueditor编辑器js -->
<script type="text/javascript" src="/Public/ueditor/ueditor.config.js"></script><script type="text/javascript" src="/Public/ueditor/ueditor.all.min.js"></script><script type="text/javascript" src="/Public/ueditor/lang/zh-cn/zh-cn.js"></script>
<!-- 上传插件【 -->
<script type="text/javascript" src="/Public/plupload/plupload.full.min.js"></script>
<script type="text/javascript" src="/Public/plupload/jquery.plupload.queue/jquery.plupload.queue.min.js"></script>
<script type="text/javascript" src="/Public/plupload/i18n/zh_CN.js"></script>
<!-- 上传插件】 -->
<!-- title提示插件 -->
<link rel="stylesheet" type="text/css" href="/Public/Js/poshytip/tip-yellow/tip-yellow.css" /><link rel="stylesheet" type="text/css" href="/Public/Js/poshytip/tip-yellowsimple/tip-yellowsimple.css" />
<script type="text/javascript" src="/Public/Js/poshytip/jquery.poshytip.min.js"></script>
<script type="text/javascript">
var getUserUrl = "<?php echo U('Member/search','','');?>";
var goodsId = "<?php echo ($info["id"]); ?>"; //商品图片id
var uploadPath ="<?php echo C('UPLOADS_PICPATH');?>"; //图片上传根目录
var imgOrderUrl = "<?php echo U('Goods/goodPicOrder');?>"; //排序商品图片提交的地址
var cutImgpPag = "<?php echo U('Goods/cutview','','');?>"; //剪裁窗口视图地址

var cutImgUrl = "<?php echo U('Goods/cutoper');?>"; //剪裁提交地址
var upPathRoot="<?php echo ($upWholeUrl); ?>"; //图片上传根目录完整路径
var miPicW="<?php echo picSize(3,'width');?>"; //商品图片小图的宽度
var miPicH="<?php echo picSize(3,'height');?>"; //商品图片小图的高度

$('.imper a').poshytip();

// 上传变量配置【
var moxieswf = "/Public/plupload/Moxie.swf";
var moxiesxap = "/Public/plupload/Moxie.xap";
// 上传变量配置】
$(function(){

        $(".searchbtn").click(function(){
            //裁剪成功后更新裁剪的图片
            asyncbox.open({
                url : getUserUrl+'?field='+$("#ac-field").val()+'&keyword='+$("#ac-keyword").val()+"&page=getUser",
                cache : false,
                width   : 650,
                height  : 500, 
                buttons : [{
                  value : "选定",
                  result : "ok"
                }],
                callback : function(btnRes,cntWin,returnValue){
                    //判断 btnRes 值。
                    if(btnRes == 'ok'){
                        $('#ac-userbox').html(returnValue);
                    }
                }
            });
        });
        var uplode_url = '<?php echo U("Upload/upGoodsPic");?>';//PHP处理脚本地址
        var uplode_path = '/Public';
        var sid = '<?php echo session_id();?>';//sessionID
        // 图片上传【
        
            var uploader = new plupload.Uploader({//创建实例的构造方法
                runtimes: 'html5,flash,silverlight,html4', //上传插件初始化选用那种方式的优先级顺序
                browse_button: 'goodsPic_upload', // 上传按钮
                url: uplode_url, //远程上传地址
                flash_swf_url: moxieswf, //flash文件地址
                silverlight_xap_url: moxiesxap, //silverlight文件地址
                filters: {
                    max_file_size: '4mb', //最大上传文件大小（格式100b, 10kb, 10mb, 1gb）
                    mime_types: [//允许文件上传类型
                        {title: "files", extensions: "jpg,gif"}
                    ]
                },
                multi_selection: true, //true:ctrl多文件上传, false 单文件上传
                init: {
                    FilesAdded: function(up, files) { //文件上传前
                        if ($("#uploadImageList").children("li").length > 30) {
                            alert("您上传的图片太多了！");
                            uploader.destroy();
                        } else {
                            var li = '';
                            plupload.each(files, function(file) { //遍历文件
                                li += "<li class='photo' id='" + file['id'] + "'><div style='width: "+miPicW+"px;' class='progress'><span class='bar'></span><span class='percent'>0%</span></div></li>";
                            });
                            $("#uploadImageList").append(li);
                            uploader.start();
                        }
                    },
                    UploadProgress: function(up, file) { //上传中，显示进度条
                        var percent = file.percent;
                        $("#" + file.id).find('.bar').css({"width": percent + "%"});
                        $("#" + file.id).find(".percent").text(percent + "%");
                    },
                    FileUploaded: function(up, file, info) { //文件上传成功的时候触发
                        var data = JSON.parse(info.response);
                         $("#" + file.id).html('<img src="'+upPathRoot+data.minipath+'" width="'+miPicW+'" height="'+miPicH+'"/><div class="imper"><a class="delImg" imgurl="'+data.path+'" href="javascript:;"></a><a class="bigImg" href="'+uploadPath+data.maxpath+'"  target="_blank"></a></div><input type="hidden" name="pic[]" value="'+data.path+'" />');
                    },
                    Error: function(up, err) { //上传出错的时候触发
                        alert(err.message);
                    }
                }
            });
            uploader.init();
        
        // 图片上传】
        $(".submit").click(function(){
            commonAjaxSubmit('','',{'to' : $(this).attr('to')});
            return false;
        });
    });

// 百度编辑器
window.UEDITOR_CONFIG.imageUrl = "<?php echo U('Upload/editorUpload');?>";
window.UEDITOR_CONFIG.wordImageUrl = "<?php echo U('Upload/editorUpload');?>";
window.UEDITOR_CONFIG.imagePath = '<?php echo ($upWholeUrl); ?>';
window.UEDITOR_CONFIG.wordImagePath = '<?php echo ($upWholeUrl); ?>';
window.UEDITOR_CONFIG.savePath = ['<?php echo ($upWholeUrl); ?>'];
// var editor = new UE.ui.Editor({initialFrameHeight:400,initialFrameWidth:1180 });  
// editor.render("content"); 
UE.getEditor('content');
// 百度编辑器_end
// 选择分类获取匪类对应筛选条件
var getFiltUrl = "<?php echo U('Goods/getFilt');?>"; //获取筛选条件的提交地址
var getExtendsUrl = "<?php echo U('Goods/getExtends');?>"; //获取字段扩展的提交地址
getFilHtml($('#cateSel').val(),$('input[name="info[filtrate]"]').val()); //初始化筛选条件
getExtendsHtml($('#cateSel').val(),goodsId); //初始化扩展字段
$('#cateSel').on("change",function(){
    var cateCid = $(this).children('option:selected').attr('value');
    $('input[name="info[filtrate]"]').val(''); //更换分类把筛选设置成空的
    // 初始化tab
    $('#tab_menu ul li').eq(1).addClass("selected");
    $("#tab_box>div").eq(1).show();
    getFilHtml(cateCid);
    getExtendsHtml(cateCid,goodsId);
});
// 函数------获取筛选条件html
function getFilHtml(cateCid,filtStr){
    $.post(getFiltUrl,{'cid':cateCid,'filtStr':filtStr},function(data){      //ajax后台
    if (data.status) {
            $('#filtHtml').html(data.html);
        } else {
            alert(data.msg);
        }
    },'json'); 
}
// 函数------获取扩展字段
function getExtendsHtml(cateCid,goodsId){
    $.post(getExtendsUrl,{'cid':cateCid,'gid':goodsId},function(data){      //ajax后台
    $('#tab .ext').remove();
    if (data.status) {
            if(data.region!='no' && data.region!=0){
                $('#region_box').parents('tr').show();
                $('#region_box').html($('#region').html());
            }else{
                $('#region_box').html('');
                $('#region_box').parents('tr').hide();
            }
            $('#tab_menu ul').append(data.ulhtml);
            $('#tab_box').append(data.divhtml);
            $(data.textarr).each(function(i,val) {
                UE.getEditor(val);
            });
        } else {
            alert(data.msg);
        }
    },'json'); 
}
// ------点击获取子级条件
var getChildUrl = "<?php echo U('Goods/getChild');?>";
$(document).on('click','.filtParent',function(){
    
    var filtFid = $(this).attr('fid');
    var newFilt = $(this).parents('ul');

    newFilt.nextUntil('ul').each(function(i, o){
        if($(o).attr('fid')==filtFid){
            $(o).css("display", "block");
        }else{
            $(o).css("display", "none");
            $(o).find('.filtParent').removeClass('current');
        }
    });
    newFilt.find('.filtParent').removeClass('current');
    $(this).addClass('current');
    getFiltArr(); //设置表单info[filtrate]"]的值
    // if(newFilt.next('.filtLi').attr('fid') != filtFid){ //判断是否已经加载过子条件，加载过不在请求
    //    newFilt.find('.filtParent').removeClass('current');
    //     $(this).addClass('current');
    //     getFiltArr(); //设置表单info[filtrate]"]的值
    //     newFilt.next('.filtLi').remove();
    //     $.post(getChildUrl,{'fid':filtFid},function(data){      //ajax后台
    //         if (data.status) {
    //             newFilt.after(data.msg);
    //         } else {
    //             alert(data.msg);
    //         }
    //     },'json'); 
    // }
});
// -----生成条件表单info[filtrate]的值
function getFiltArr(){
    var filtId = '';
    $('.filtParent.current').each(function(i, o){
        filtId += $(o).attr('fid')+'_';
    });
    filtId=filtId.substring(0,filtId.length-1);
    $('input[name="info[filtrate]"]').val(filtId);  
}
//图像处理裁剪操作
$('#uploadImageList').on("click",".cutImg",function(){
    var cutImgPath = $(this).attr('imgurl'); //裁剪图片的地址
    var cutImgP = $(this).parent('.imper').next('input').attr('value'); //数据库内图片要裁剪原图
    var upImgBox = $(this).parent('.imper').prev('img');
    var upDataImg = upImgBox.attr('src')
    //裁剪成功后更新裁剪的图片
    asyncbox.open({
        url : cutImgpPag+ '/' + Math.random(),
        cache : false,
        data:{imgurl:cutImgPath},
        buttons : [{
          value : "裁剪",
          result : "ok"
        }],
        callback : function(btnRes,cntWin,returnValue){
            //判断 btnRes 值。
            if(btnRes == 'ok'){
                $.post(cutImgUrl,{'cutSize':returnValue , 'cutImgP':cutImgP},function(data){
                    if (data.status) {
                        upImgBox.attr('src',upDataImg+'?'+Math.random());
                    } else {
                        alert(data.msg);
                    }
                },'json'); 
            }
        }
    });
});
//图像处理裁剪操作_end
// 商品图片删除
    var delUrl = "<?php echo U('Goods/del_pic');?>";
    $('#uploadImageList').on("click",'.delImg',function(){
        var delImgUrl = $(this).attr('imgurl');
        var delDiv = $(this);
        $.post(delUrl,{'goodsId':goodsId,'imgUrl':delImgUrl},function(data){      //ajax后台
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
// 商品图片删除_end
//拖动排序
    if(goodsId){ //如果商品id存在表示编辑商品可有以下操作
        $("#uploadImageList").dragsort({ dragSelector: "li", dragBetween: true, dragEnd: saveOrder, placeHolderTemplate: "<li class='placeHolder'></li>" });     
    }else{ //如果商品id不存在表示添加商品排序不进行保存
        $("#uploadImageList").dragsort({ dragSelector: "li", dragBetween: true, placeHolderTemplate: "<li class='placeHolder'></li>" });  
    }
    function saveOrder() {
        var data = $("#uploadImageList li").map(function() { return $(this).children("input").val(); }).get();
        var imgArr = data.join("|"); //组合图片从新排列数据
        $.post(imgOrderUrl,{'goodsId':goodsId,'imgArr':imgArr},function(data){  //ajax提交到后台排序
            if (data.status) {
                popup.success(data.msg);
                setTimeout(function(){
                    popup.close("asyncbox_success");
                },1000);
            } else {
                popup.error(data.msg);
                setTimeout(function(){
                    popup.close("asyncbox_success");
                },2000);
            }
        },'json');
    };
//拖动排序_end

    
</script>
    </body>
</html>