// 分类的高度
function screenBoxHeight(){
    var screenH = Math.floor($('.screen_box').height());
    $('.screen_box .titl').css({ 'height': screenH, 'line-height': screenH+'px' });
    $('.screen_box .titl').css({ 'height': screenH, 'line-height': screenH+'px' });
}    
// 筛选条件右侧的高度控制
function rightHeight(){
    var n1h = Math.floor($('#fielt_box').height()/2);
    var n2h = $('#fielt_box').height()-n1h;

    $('.notice li.n1').css({ 'height': n1h, 'line-height': n1h+'px' });
    $('.notice li.n2').css({ 'height': n2h, 'line-height': n2h+'px' });
}
// ------点击获取子级条件
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
    getFiltArr(); 
    rightHeight();
});
// -----生成条件表单info[filtrate]的值
function getFiltArr(){
    var filtId = '';
    $('.filtParent.current').each(function(i, o){
        filtId += $(o).attr('fid')+',';
    });
    filtId=filtId.substring(0,filtId.length-1);
    $('input[name="info[filtrate]"]').val(filtId);  
}
$(function() {
	// 地区鼠标事件二级菜单
    $('.list_region li').hover(function(){
        $(this).find("ul").first().show();
    },function(){
        $(this).find("ul").first().hide();
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
	// 初始化筛选条件右侧高度
    rightHeight();
    screenBoxHeight();
	// 分类鼠标事件
    var btb=$(".bla");
    var tempS;
    $(".bla").hover(function(){
            var thisObj = $(this);
            tempS = setTimeout(function(){
            thisObj.find(".brand").each(function(i){
                var tA=$(this);
                var childs=tA.children("ul").children();
                var length=childs.length>0?childs.length:1;
                length=length>10?length-1:length;
                var ht=Math.ceil(length/10)*57;
                length>10?$('.brmore').hide():$('.brmore').html('没有更多');
                setTimeout(function(){ tA.animate({height:ht},300);},50*i);
            });
        },200);

    }
    ,function(){
        if(tempS){ clearTimeout(tempS); }
        $(this).find(".brand").each(function(i){
            var tA=$(this);
            length<10?$('.brmore').show():$('.brmore').html('查看更多');
            setTimeout(function(){ tA.animate({height:"57"},300,function(){
            });},50*i);
        });

    });
    // 分类鼠标事件——end
});












	
	
	
	
	