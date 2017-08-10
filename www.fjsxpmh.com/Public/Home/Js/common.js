$(function() {
    $("#navleft").hover( 
        function(){$(this).addClass("navlefthover");},
        function(){$(this).removeClass("navlefthover");}
        )
    $(".ltitimg").hover( 
        function(){$(this).addClass("hover");},
        function(){$(this).removeClass("hover");
    });
// wide二级导航
    $('.navmain .menu_onelayer li').hover(function(){
        $(this).find("ul").first().show();
    },function(){
        $(this).find("ul").first().hide();
    });


$(".ac-show-userbox").hover(
    function(){
        $(".aw-card-tips").hide();
        var cardInfoBox = $(this);
        // 获取用户信息
        if($(this).attr('cardtips')==0){
            $.post(getusercard,{'seller':$(this).attr('seller'),'uid':$(this).attr('uid'),'pid':$(this).attr('pid')},function(data){  //ajax提交到后台排序
                var cardinfo = '';
                if (data.status) {
                    cardinfo+= '<div class="aw-card-tips"><div class="aw-mod"><div class="mod-head">';
                    cardinfo+='<a target="_blank" class="img" href="'+data.url+'"><img src="'+data.head+'"></a>';
                    cardinfo+='<p class="title clearfix"><a target="_blank" class="name pull-left" href="'+data.url+'">'+data.name+'</a><i title="" class=" pull-left"></i></p>';
                    cardinfo+='<p class="aw-user-center-follow-meta"><span>'+data.role+': <img src="'+data.leval+'"></span></p></div><div class="mod-body"><p>'+data.intr+'</p>';
                    cardinfo+='</div>';
                    if(data.seller){
                        cardinfo+='<div class="mod-footer clearfix">';
                        cardinfo+='<div class="lybox_min fr clearfix"><a target="_blank" class="ly fl" href="'+data.auctionurl+'"><div class="ico"></div><div class="txt cuit_over">给我留言</div></a></div>';
                        if(data.gzuser==0){
                            cardinfo+='<div class="gzbox_min ac-attention-box fr clearfix"><a pid="'+data.pid+'" sellerid='+data.uid+' class="gz_sell gz fl selatt'+data.uid+'" st="0" href="javascript:void(0);"><div class="ico"></div><div class="txt cuit_over">关注卖家</div></a></div>';

                        }else{
                            cardinfo+='<div class="gzbox_min ac-attention-box fr clearfix"><a pid="'+data.pid+'" sellerid='+data.uid+' class="gz_sell gz fl selatt'+data.uid+' on" st="1" href="javascript:void(0);"><div class="ico"></div><div class="txt cuit_over">取消关注</div></a></div>';
                        }
                        cardinfo+='</div>';
                    }
                    cardinfo+='</div></div>';
                    cardInfoBox.append(cardinfo);
                } else {
                    popup.error(data.msg);
                    setTimeout(function(){
                        popup.close("asyncbox_success");
                    },2000);
                }
            },'json');
            $(this).attr('cardtips',1);
            $(this).children(".aw-card-tips").show();
        }else{
            $(this).children(".aw-card-tips").show();
        }
    },
    function(){
        $(this).children(".aw-card-tips").hide();
    }
);




// 回到顶部【
$(window).scroll(function(){
    if ($(window).scrollTop()>100){
        $("#returnTop").show();
    }else{
        $("#returnTop").hide();
    }
});
$("#returnTop").click(function () {
    var speed=200;//滑动的速度
    $('body,html').animate({ scrollTop: 0 }, speed);
    return false;
 });
// 回到顶部】

$('#tab_menu').on('click','li',function(){
      $(this).addClass("selected").siblings().removeClass("selected");
      var div_index = $(this).index();

      $("#tab_box>div").eq(div_index).show().siblings().hide();

}).hover(function(){
      $(this).addClass("hover");
},function(){
      $(this).removeClass("hover");
});


// 选项卡操作
    var $tabs = $(".tab_menu a");
    $tabs.bind("click", function(){
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
    $('.auctionbox').on('mouseenter','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('取消');
        }
    });
    $('.auctionbox').on('mouseout','.att',function(){
        if($(this).attr('yn')=='y'){
            $(this).html('已关注');
        }
    });
    $('.auctionbox ').on("click",".att",function(){
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
                    popStatus(2, data.msg, 2,'',true);
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











	
	
	
	
	