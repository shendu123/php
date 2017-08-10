$(function() {
     /*图像加载。。。*/
    var imgload=$(".lazy");
    imgload.lazyload({
        effect : "fadeIn"
     });

    $("ab_modal").click(function(){
        popup.close("asyncbox_success");
        popup.close("asyncbox_alert");
        popup.close("asyncbox_error");

    });

    // 选项卡操作
    $(".tab_menu a").bind("click", function(){
        var tabId = $(this).attr("href");
        var tabIdStr = tabId.split("#");
        var currentTabId = '#'+tabIdStr[1];
        $(currentTabId).show().siblings(".tab_con").hide();
        $(this).parent("li").addClass("on").siblings().removeClass("on");
        return false;
    })
    .focus(function(){
        $(this).blur();
    });
//用户关注拍品
    $('.bidbox').on('mouseenter','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('取消');
        }
    });
    $('.bidbox').on('mouseout','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('已关注');
        }
    });
    $('.bidbox ').on("click",".att",function(){
        if(login == 1){
            var thisObj = $(this);
            var gid = $(this).attr('pid');
            var rela = $(this).attr('rela');
            var yn = $(this).attr('yn');
            $.post(attUrl,{'gid':gid , 'rela':rela, 'yn':yn},function(data){
                if (data.status) {
                    if(yn =='n'){
                        thisObj.addClass('on');
                        thisObj.html('已关注');
                        thisObj.attr('yn','y');
                    }else if(yn =='y'){
                        thisObj.removeClass('on');
                        thisObj.html('关注');
                        thisObj.attr('yn','n');
                    }
                } else {
                    popup.error(data.msg);
                    setTimeout(function(){
                        popup.close("asyncbox_error");
                    },2000);
                }
            },'json');  
            
        }else{
            popup.alert('<div class="sayOnelin">您没有登录！请登录</div>');
        }
         
    });

// 关注卖家操作【
    $('body').on('mouseenter','.gz_sell',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('取消关注');
        }
    });
    $('body').on('mouseout','.gz_sell',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('已关注');
        }
    });
    if($('.gz_sell').attr('st')==1){
        $('.gz_sell').addClass('on');
    }
    $('body').on('click','.gz_sell',function(){
        var thisbj=$(this);
        var st = $(this).attr('st');
        var attsellerid =  $(this).attr('sellerid');
        var thisall =  $('.gz_sell.selatt'+attsellerid);
        $.post(setAttentionSellerUrl,{'sellerid':attsellerid,'st':st},function(data){
            if (data.status) {
                if(st==0){
                    thisall.children('.txt').html('已关注');
                    thisall.attr('st',1);
                    popStatus(1, data.msg, 1,'',true);
                    thisall.addClass('on');
                    setTimeout(function(){
                        popup.close("asyncbox_success");
                    },2000);
                }else{
                    thisall.children('.txt').html('关注卖家');
                    thisall.attr('st',0);
                    popStatus(1, data.msg, 1,'',true);
                    thisall.removeClass('on');
                }
                
            } else {
                popStatus(2, data.msg, 2,'',true);
            }
        },'json');
    });
// 关注卖家操作】

});











	
	
	
	
	