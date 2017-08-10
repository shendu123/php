var 
	windowWidth,
	windowHeight,
	popstatus,
	//超时时间
	outTime;
/*
* whWindow()	浏览器宽高的获取
*/
function whWindow() {
	windowWidth = $(window).width();
	windowHeight = $(window).height();
}
/*
* windowSize()	窗口监听函数
*/
$(window).resize(function() {
	whWindow();
	popStatuRe();
});
whWindow();
/*
* popStatus()	提示
* status	1正确，2提示，3加载，4失败
* html	提示信息
* timeout	提示时间,单位：秒
* url	是否跳转页面,没有则留空
* bremove	是否使用遮照,不为空时使用
*/
function popStatus(status, html, timeout, url, bremove) {
	//请求超时时间 
	var timeous = 20;
	clearTimeout(popstatus);
	clearTimeout(outTime);
	popStatusOff();
	if(html!=''){
		html = '<p class="wstatus_f">'+html+'</p>';
	}
	if (status == 1) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s1"></div>'+html+'</div>');
	}else if (status == 2) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s2"></div>'+html+'</div>');
	}else if (status == 3) {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s3"></div>'+html+'</div>');
	}else {
		$('body').append('<div id="wstatus"><div class="wstatus_s wstatus_s4"></div>'+html+'</div>');
	}
	$('.wstatus_s').css('margin-top',($('#wstatus').height()-$('.wstatus_s').height())/2);
	popStatuRe();
	//是否使用遮照
	if (bremove) {
		$('body').append('<div id="bremove" />');
	}
	if (!url) {
		url = 0;
	}
	//抖动
	if (status == 2 || status ==4) {
		var sw = (windowWidth/2)-($('#wstatus').width()+18)/2;
		var sh = (windowHeight/2)-($('#wstatus').height()+18)/2;
		$('body #wstatus').animate({left:sw-5+'px'},100);
		$('body #wstatus').animate({left:sw+10+'px'},100);
		$('body #wstatus').animate({left:sw-10+'px'},100);
		$('body #wstatus').animate({left:sw+10+'px'},100);
		$('body #wstatus').animate({left:sw+'px'},100);
		$('body #wstatus').animate({top:sh-5+'px'},100);
		$('body #wstatus').animate({top:sh+10+'px'},100);
		$('body #wstatus').animate({top:sh-10+'px'},100);
		$('body #wstatus').animate({top:sh+10+'px'},100);
		$('body #wstatus').animate({top:sh+'px'},100);
	}
	if(timeout!=0){
		popstatus = setTimeout(function() {
			//判断是否有跳转地址
			if (url != 0) {
				if (url == '?') {
					reloads();
				}else {
					location.href = url;
				}
			}
			popStatusOff();
		},timeout*1000);
		//超时时间设置
		if (timeout >= timeous) {
			outTime = setTimeout(function() {
				if ($('body #wstatus')) {
					clearTimeout(popstatus);
					$('body #wstatus').remove();
					popStatus(4, '连接超时,请重试！', 3, '', true);
				}
			},timeout*1000-1000);
		}
	}
}

function popStatusOff(){
	$('body #wstatus').remove();
	$('body #bremove').remove();
}


/*
* popStatuRe()	位置矫正
*/
function popStatuRe() {
	$('body #wstatus').css({'left':(windowWidth/2)-($('#wstatus').width()+18)/2+'px','top':(windowHeight/2)-($('#wstatus').height()+18)/2+'px'});
}