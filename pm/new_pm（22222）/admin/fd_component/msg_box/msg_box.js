/* 弹窗整理 begin */
(function () {
    $.MsgBox = {
        tipbox: function (title, msg) {
            GenerateHtml("tipbox", title, msg);
            //$('body').addClass('overflowHide');
            btnCancel();
            setTimeout(function(){
                lsDiaClose();
            },2000);
        },
        Alert: function (title, msg, alert_callback) {
            GenerateHtml("alert", title, msg);
            $('body').addClass('overflowHide');
            btnAlertCfm(alert_callback);  //alert只是弹出消息，因此没必要用到回调函数callback
            btnCancel();
        },
        Confirm: function (title, msg, callback,cancel_callback) {
            GenerateHtml("confirm", title, msg);
            $('body').addClass('overflowHide');
            btnCfm(callback);
            btnCancel(cancel_callback);
        }
    }

 // 生成Html
	var GenerateHtml = function (type, title, msg) {

        var _html = "";
        
        _html += '<div class="fd-dialog-wrap">';
        _html += '<div class="hd">' + title + '</div>';
        _html += '<div class="bd" style="text-align: center">' + msg + '</div>';
        _html += '<div class="ft">';

        if (type == "tipbox") {

        }
        if (type == "alert") {
            _html += '<a class="btn-cfm">确定</a>';
        }
        if (type == "confirm") {
            _html += '<a class="btn-cancel">取消</a> <a class="btn-cfm">确定</a>';
        }
        _html += '</div></div><div class="fd-dialog-mark"></div>';

        // 必须先将_html添加到body，再设置Css样式
        $("body").append(_html); GenerateCss();
    }

 //修改CSS 让提示框居中
    var GenerateCss = function () {
        var win_h = $(window).height();

        var diaHeight = $(".fd-dialog-wrap").height();

        $(".fd-dialog-wrap").css({ top: (win_h - diaHeight) / 2 + "px" });
        
    }
    
    //关闭弹窗事件
    function lsDiaClose() {
    	$(".fd-dialog-mark,.fd-dialog-wrap").remove();
    	$('body').removeClass('overflowHide');
	}
    
    //确定按钮事件
    var btnCfm = function (callback) {
        $(".fd-dialog-wrap .btn-cfm").click(function () {
        	lsDiaClose();
            if (typeof (callback) == 'function') {
                callback();
            }
        });
    }
    
    var btnAlertCfm = function (alert_callback) {
    	$(".fd-dialog-wrap .btn-cfm").click(function () {
    		lsDiaClose();
    		if (typeof (alert_callback) == 'function') {
    			alert_callback();
    		}
    	});
    }

    //取消按钮事件
    var btnCancel = function (cancel_callback) {
        $(".fd-dialog-wrap .btn-cancel").click(function () {
        	lsDiaClose();
        	if (typeof (cancel_callback) == 'function') {
        		cancel_callback();
    		}
        });
    }
})();
/* 弹窗整理 end */