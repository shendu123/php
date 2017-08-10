/* design-note js dev by lshc ,email:lshclshc@163.com*/
/*标签页面转换。*/
$('[href^="#rmd"]').click(function (e) {
    e.preventDefault();
    var targetId = $(this).attr('href'),
        $toggleTarget = $(targetId);
    $toggleTarget.siblings('div').hide();
    //$(this).toggleClass('active');
    $(this).parent().siblings().find('a').removeClass('active');
    $(this).parent().siblings().find('i').hide();
    $(this).parent().find("a").addClass('active');
    $(this).parent().find("i").show();
    $toggleTarget.show();
});
function initMenu() {
  $('.user_li_pg').parents('li ul').addClass('sel');
  $('#menu ul').hide();
  $('#menu ul.sel').show();
  $('#menu li a').click(
    function() {
      var checkElement = $(this).next();
      if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
        return false;
        }
      if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
        $('#menu ul:visible').slideUp('normal');
        checkElement.slideDown('normal');
        return false;
        }
      }
    );
  }
$(function(){
    initMenu();

    $('[href^="#tab-menu"],[href^="#sub-type-"]').click(function(e){
        e.preventDefault();
        var targetId = $(this).attr('href'),
            $toggleTarget = $(targetId);
        $toggleTarget.siblings('div').hide();
        $(this).toggleClass('active');
        $(this).parent().siblings().find('a').removeClass('active');
        $(this).parent().find("span").addClass('active');
        $toggleTarget.toggle();
    });

    $(".after-arrow-white").on("click",function(){
        $(".showtype").slideToggle(100);
    });

    var designSize=$("#desingerlist ul li figure").size()
   /*designer list width */

    var desigerList=$("#desingerlist ul");
    desigerList.css("min-width",function(){
        return designSize*80+designSize*10;
    })

     var designerCompany=$("#designerCompany ul li figure").size()
     var designerCon=$("#designerCompany ul");
     designerCon.css("min-width",function(){
        return designerCompany*80+ designerCompany*10;
    })

    /*edit by 2015-03-02*/
    var detailRemd=$(".hot-3d-recommend li").size();
    var detailsremds=$(".hot-3d-recommend ul")
    detailsremds.css("min-width",function(){
        return detailRemd*115 + detailRemd*10;
    });

    $("#select-itme-type").change(function()
    {
        var selectTxt= $(this).find("option:selected").text();
        $("#getText").text(selectTxt)
        $("#typeText").text(selectTxt)
    });

    $("#select-itme-area").change(function()
    {
        var selectTxt= $(this).find("option:selected").text();
        $("#getTextArea").text(selectTxt)
    });

    $("#s1").change(function()
    {   var selectTxt= $(this).find("option:selected").text();
        $("#getProvinceText").text(selectTxt)
    });

    $("#s2").change(function()
    {   var selectTxt= $(this).find("option:selected").text();
        $("#getCityText").text(selectTxt)
    });

    $("#getText").text("房屋类型");
    $("#getCityText").text("市");
    $("#getProvinceText").text("省");
    $("#getTextArea").text("项目面积");
    $("#typeText").text("项目类型");
    
    /*图像加载。。。*/
    var imgload=$(".lazy");
    imgload.lazyload({
        effect : "fadeIn"
     });

    /*answer type scroll..*/
    var answerType=$(".qa-top-menu li").size();
    var sumWidth =0;
    $(".qa-top-menu").find("li").each(function(){
        sumWidth += $(this).outerWidth();
    });

    var scrollArea=$(".qa-top-menu");
    scrollArea.css("width",function(){
        return sumWidth;
    })
    var linkActive=$(".qa-top-menu li")
    linkActive.on("click",function(){
        $(this).addClass("active");
        $(this).siblings().removeClass("active");
    })
    var linkActive=$(".top-menus li,.room-inner-case ul li,.nav-link li,.hot-recommend ul li,.gally-case li,.answerQuestions li,.clickeffect li a,.case-select li");
    linkActive.on("click",function(){
       $(this).addClass("actives");
      })

    linkActive.on("touchend",function(){
        $(this).removeClass("actives");
    })

    $("#showZx").on("click",function(){
        $(".zx_types").fadeToggle();
    })

    /*显示导航菜单*/
    $("#show-pop-menus").on("click",function(e){
        e.preventDefault();
        $(".pop-menus").animate({height:"show"},50)
    });
    $("#hide-pop-menus").on("click",function(e){
        e.preventDefault();
        $(".pop-menus").animate({height:"hide"},50)
    })
    $(".pop-menus").on("touchmove",function(){
        $(this).hide()
    })
    //拔打电话。
    $("#contact-designer").on("click",function(e){
        e.preventDefault();
        $(".telphone").fadeToggle()
        $(".zx_types").hide()
    })

    $("#tel-cancel").on("click",function(e){
        e.preventDefault();
        $(".telphone").hide()
    })
    var scrollScreen = $("#scrollButton");
    scrollScreen.on("click", function (e) {
        e.preventDefault();
        var nowScroll = $(window).scrollTop(),
            flag = "up";
        var funScroll = function () {
            var top = $(window).scrollTop();
            if (flag == "up") {
                top -= top; //返回顶部
                if (top <= 0) {
                    top = 0;
                    flag = "down";
                }
            }
            else {
                return;
            }
            $(document.body).animate({scrollTop: top}, 400);
        };
        if (nowScroll) {
            funScroll();
        };
    });

    $('#softDesc').find("p:gt(1)").hide();//软件详细页的介绍默认显示两条
});

function showMore(thisObj)
{
    thisText = $(thisObj).text();
    if(thisText=='更多'){
      $('#softDesc').find("p:gt(1)").show();
      $(thisObj).text('收起');
      $('.details-msg').addClass('details-msgd');
    }else{
      $('#softDesc').find("p:gt(1)").hide();
      $(thisObj).text('更多');
      $('.details-msg').removeClass('details-msgd');
    }
}
