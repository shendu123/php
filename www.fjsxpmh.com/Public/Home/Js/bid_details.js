
// 初始化代理提示
var loseralert = 0;
var endDowntimer;
$(function(){
    // 等待提示框【
    popStatus(3, '正在建立连接.....', 0,'',true);
    // 等待提示框】
    // 代理结束通知【
    if(setagency==2||setagency==1){
        if(setagency==2){
            var agencymsg = '您设置的代理价'+myagprice+'元被其他用户超越。<br/>代理已取消！';
        }else if(setagency==1){
            var agencymsg = '已达到您设置的代理价'+myagprice+'元。<br/>代理已取消！';
        }
        popup.alert(agencymsg,'代理结束',function(action){
            if(action == 'ok'||action == 'close'){
                $.post(iknowurl,{'pid':acpid,'uid':ws_my_uid},function(data){
                    if (data.status) {
                        popStatus(1, '已取消代理出价！', 2,'',true);
                        agency_butstyl(0);
                        setagency=3;
                    } else {
                        popStatus(2, '取消代理出价失败！', 2,'',true);
                    }
                },'json');
            }
        });
    }
    // 代理结束通知】
    // 上一个加一下拍品【
    $('.pm-item-arrow').on("mouseover mouseout",function(event){
        var exeobj =$(this).children('.item-imgCon');
        if(event.type == "mouseover"){
           exeobj.show();
        }else if(event.type == "mouseout"){
            setTimeout(function(){
                if (exeobj.attr('data-ex')=='hide') {
                    exeobj.hide();
                };
            },500);
        }
    });
    $('.item-imgCon').on("mouseover mouseout",function(event){
        if(event.type == "mouseover"){
           $(this).show();
           $(this).attr('data-ex','show');
        }else if(event.type == "mouseout"){
            $(this).attr('data-ex','hide');
            setTimeout(function(){

                $(this).hide();
            },500);
        }
    });
    // 上一个加一下拍品】

    if(endStatus==0){
        // 初始化拍卖记录状态
        $(".ac-auction-part tr:eq(1)").addClass('lingxian');
        $(".ac-auction-all tr:eq(1)").addClass('lingxian');
    }else if(endStatus==1){
        $(".ac-auction-part tr:eq(1)").addClass('chengjiao');
        $(".ac-auction-all tr:eq(1)").addClass('chengjiao');
    }
    // 加减步长【
    $('.change_step').click(function(){
        var changObj = $(this).parents('.plus-minus-operation').find('#bidprice');
        var originalPric = Number(changObj.val());

        var orbjval  = (originalPric-Number(steplin)).toFixed(2)*100/100;
        var nowbjval = (Number(nowPrice)+Number(steplin)).toFixed(2)*100/100;
        if($(this).attr('act')=='minus'){

            if((Number(nowUid) != 0 && orbjval>=nowbjval) || (Number(nowUid) == 0 && orbjval>=Number(nowPrice))){
                var changval = (originalPric-Number(steplin)).toFixed(2)*100/100;
            }else{
                popStatus(2, '不能再少了！', 1,'',true);
                var changval = originalPric;
            }
        }else if($(this).attr('act')=='add'){
            var changval = (originalPric+Number(steplin)).toFixed(2)*100/100
        }
        changObj.val(changval);
        $('.on-keyboard-input-box').html(changval);
        
    });
    // 加减步长】
    // 详情页关注拍品操作【
    $('.ac-pointer').on('mouseenter','#gz',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('取消关注');
        }
    });
    $('.ac-pointer').on('mouseout','#gz',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('已关注');
        }
    });
    if($('#gz').attr('st')==1){
        $('#gz').addClass('on');
    }
    $('#gz').click(function(){
        if(checkCodemap()){
            var thisbj=$(this);
            var st = $(this).attr('st');
            $.post(setAttentionUrl,{'pid':acpid,'uid':ws_my_uid,'st':st},function(data){
                if (data.status) {
                    if(st==0){
                        thisbj.children('.txt').html('已关注');
                        thisbj.attr('st',1);
                        popStatus(1, data.msg, 1,'',true);
                        thisbj.addClass('on');
                    }else{
                        thisbj.children('.txt').html('关注');
                        thisbj.attr('st',0);
                        popStatus(1, data.msg, 1,'',true);
                        thisbj.removeClass('on');
                    }
                    
                } else {
                    popStatus(2, data.msg, 2,'',true);
                }
            },'json');
        }
        
    });
    // 详情页关注拍品操作】
    // 详情页拍品提醒操作【
    $('.ac-pointer').on('mouseenter','.ac-tx',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('取消提醒');
        }
    });
    $('.ac-pointer').on('mouseout','.ac-tx',function(){
        if($(this).attr('st')=='1'){
            $(this).children('.txt').html('已设提醒');
        }
    });
    if($('.ac-tx').attr('st')==1){
        $('.ac-tx').addClass('on');
    }
    $('.ac-pointer').on('click','#tx',function(){
        if(checkCodemap()){
            changtx();
        }
    });
    $('.ac-pointer').on('click','#settx',function(){
        if(login==0){
            popStatus(2, '请先登陆后在设置提醒！', 2,'',true);
        }else{
            if(checkCodemap()){
                asyncbox.open({
                    id : "open_0",
                    title : '设置提醒',
                    args : {pid:acpid},
                    modal : true,
                    buttons : asyncbox.btn.OKCANCEL,
                    url : setTixingUrl,
                    callback : handler 
                })
            }
            
        }
    });
    // 是否提示关注公众号
    function checkCodemap(){
        if(iswei==1){
            if(mapstate!=1){
                $('#codeMapModal').modal();
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }
    function changtx(){
        var thisbj=$('.ac-tx');
        var st = $('.ac-tx').attr('st');
        var stype = $('.ac-tx').attr('stype');
        $.post(setScheduledUrl,{'pid':acpid,'uid':ws_my_uid,'st':st,'stype':stype},function(data){
            if (data.status) {
                if(st==0){
                    thisbj.children('.txt').html('已设提醒');
                    thisbj.attr('st',1);
                    popStatus(1, data.info, 2,'',true);
                    thisbj.addClass('on');
                }else{
                    thisbj.children('.txt').html('设置提醒');
                    thisbj.attr('st',0);
                    popStatus(1, data.info, 2,'',true);
                    thisbj.removeClass('on');
                }
                
            } else {
                popStatus(2, data.info, 1,'',true);
            }
        },'json');
    }
    function handler(buttonResult,contentWindow,returnValue){
        if(buttonResult=='ok'){
            if(returnValue){
                $.post(setTixingUrl,returnValue,function(data){
                    if (data.status) {
                        $('.ac-tx').attr("id",'tx');
                        changtx();
                    } else {
                        popStatus(2, data.info, 1,'',true);
                    }
                },'json');
            }else{
                popStatus(2, '请选择提醒方式', 1,'',true);
            }
        }
        
        
    }
    // 详情页拍品提醒操作】
    // 如果是拍卖会提示是否进入正在拍卖的拍品
    if(acpid!=mtnowpid && mtstatus=='ing'){
        asyncbox.confirm('拍卖会<strong>《'+mname+'》</strong>正在进行中！<br>是否进入拍卖会？','跳转提示',function(buttonResult){
            if(buttonResult == "ok"){
                connectLink = 0;
                window.location.href = mtnowUrl+'?rand='+Math.random();
                return false;
            }
        });
    }else if(mtstatus=='end'){
        asyncbox.confirm('该拍品所属<strong>《'+mname+'》</strong>拍卖会已结束！<br>是否查看拍卖结论书？','跳转提示',function(buttonResult){
            if(buttonResult == "ok"){
                connectLink = 0;
                window.location.href = conclusion+'?rand='+Math.random();
                return false
            }
        });
    }
    // 手动出价
    $('#manual_but').click(function(){
        postbid(acpid,ws_my_uid,'sd',$('#bidprice').val());
    });
    // 手动和自动切换
    $('#robot_but').click(function(){
        $(this).parents('#manual').css('display','none');
        $('#auto').css('display','block');
    });
    // 取消代理出价
    $('#manual_tab').click(function(){
        $(this).parents('#auto').css('display','none');
        $('#manual').css('display','block');
    });
    // 启动和关闭代理出价
    $('#isbegin').click(function(){
        var thisbegin = $(this);
        // 未设置代理
        if(setagency==3){
            $.post(bidUrl,{'pid':acpid,'uid':ws_my_uid,'bidType':'zd','bidPric':$('#robotprice').val()},function(data){
                if (data.status) {
                    // 有权限进行设置出价
                    if(data.status==1){
                        // 设置代理成功
                        if(data.thisS.agency_succ){
                            if(data.thisS.agency_succ.uid == ws_my_uid){
                                popStatus(1, data.msg, 1,'',true);
                                agency_butstyl(1);
                                setagency=0;
                            }
                        }
                        // 失败代理检查
                        agency_loser(data.thisS.agency_loser);
                        if(data.thisS.recordList){
                            ws.send(JSON.stringify({"type":"bid","thisS":data.thisS}));
                            // 异步发送价格被超越提醒【
                            $.post(send_remind,{'pid':acpid});
                            // 异步发送价格被超越提醒【
                        }
                        // 变更受影响的其他拍品时间
                        if(mid&&data.thisS.drive){
                            ws.send(JSON.stringify({"type":"drive","pre":ws_rom_pre,"data":data.thisS.drive}));
                        }

                    // 出价小于阶梯价
                    }else if(data.status==2){
                        $('#robotprice').removeAttr("disabled");
                        popStatus(2, data.msg, 2,'',true);
                    // 保证金缴纳提醒
                    }else if(data.status==3){
                        asyncbox.confirm(data.msg,'缴纳保证金',function(buttonResult){
                            if(buttonResult == "ok"){
                                $.post(bidUrl,{'pid':acpid,'uid':ws_my_uid,'bidType':'zd','bidPric':$('#robotprice').val(),'agr':1},function(data){
                                    if(data.status==1){
                                        // 设置代理成功
                                        if(data.thisS.agency_succ){
                                            if(data.thisS.agency_succ.uid == ws_my_uid){
                                                popStatus(1, data.msg, 1,'',true);
                                                agency_butstyl(1);
                                                setagency=0;
                                            }
                                        }
                                        if(data.thisS.recordList){
                                            ws.send(JSON.stringify({"type":"bid","thisS":data.thisS}));
                                            // 异步发送价格被超越提醒【
                                            $.post(send_remind,{'pid':acpid});
                                            // 异步发送价格被超越提醒【
                                            // 异步发送价格被超越提醒【
                                            $.post(freeze_remind,{'pid':acpid,'uid':ws_my_uid});
                                            // 异步发送价格被超越提醒【
                                        }
                                        // 变更受影响的其他拍品时间
                                        if(mid&&data.thisS.drive){
                                            ws.send(JSON.stringify({"type":"drive","pre":ws_rom_pre,"data":data.thisS.drive}));
                                        }
                                    }else if(data.status==2){
                                        $('#robotprice').removeAttr("disabled");
                                        popStatus(2, data.msg, 2,'',true);
                                    }
                                },'json');
                            }else{
                                $('#robotprice').removeAttr("disabled");
                            }
                        });
                    }
                } else {
                    alert(data.msg);
                }
            },'json'); 

        // 已设置代理取消代理出价
        }else{
            // 取消代理出价
            $.post(cancelAgency,{'pid':acpid,'uid':ws_my_uid},function(data){
                if (data.status) {
                    popStatus(1, '已取消代理出价！', 1,'',true);
                    agency_butstyl(0);
                    setagency=3;
                } else {
                    popStatus(2, '取消代理出价失败！', 1,'',true);
                }
            },'json');
        }

        
    });
    // 内容选项卡
    $('#extcon_menu').on('click','li',function(){
          $(this).addClass("on").siblings().removeClass("on");
          var div_index = $(this).index();

          $("#extcon_content>div").eq(div_index).show().siblings().hide();

    });
    // 测试
    $('#test').on('click','a',function(){
        clearInterval(endDowntimer);
    });

});

// web_socket【
    // ajax出价
    function postbid(postpid,postuid,posttype,postprice){
        $('#bidprice').attr("disabled", 'disabled');
        $.post(bidUrl,{'pid':postpid,'uid':postuid,'bidType':posttype,'bidPric':postprice},function(data){
            if (data.status) {
                if(data.status==1){
                    ws.send(JSON.stringify({"type":"bid","thisS":data.thisS}));
                    // 异步发送价格被超越提醒【
                    $.post(send_remind,{'pid':postpid});
                    // 异步发送价格被超越提醒【
                    // 变更受影响的其他拍品时间
                    if(mid&&data.thisS.drive){
                        ws.send(JSON.stringify({"type":"drive","pre":ws_rom_pre,"data":data.thisS.drive}));
                    }
                // 出价小于阶梯价
                }else if(data.status==2){
                    $('#bidprice').removeAttr("disabled");
                    popStatus(2, data.msg, 2,'',true);
                // 保证金缴纳提醒
                }else if(data.status==3){
                    asyncbox.confirm(data.msg,'缴纳保证金',function(buttonResult){
                        if(buttonResult == "ok"){
                            $.post(bidUrl,{'pid':acpid,'uid':postuid,'bidType':'sd','bidPric':$('#bidprice').val(),'agr':1},function(data){
                                if (data.status) {
                                    if(data.status==1){
                                        ws.send(JSON.stringify({"type":"bid","thisS":data.thisS}));
                                        // 异步发送价格被超越提醒【
                                        $.post(send_remind,{'pid':postpid});
                                        // 异步发送价格被超越提醒【
                                        // 异步发送价格被超越提醒【
                                        $.post(freeze_remind,{'pid':acpid,'uid':postuid});
                                        // 异步发送价格被超越提醒【
                                        // 变更受影响的其他拍品时间
                                        if(mid&&data.thisS.drive){
                                            ws.send(JSON.stringify({"type":"drive","pre":ws_rom_pre,"data":data.thisS.drive}));
                                        }
                                    }else if(data.status==2){
                                        $('#bidprice').removeAttr("disabled");
                                        popStatus(2, data.msg, 2,'',true);
                                    }else if(data.status==3){
                                        popup.alert(agencymsg,'拍品结束',function(action){
                                            if(action == 'ok'||action == 'close'){
                                                connectLink = 0;
                                                window.location.href=window.location.href+"?id="+10000*Math.random();;
                                            }
                                        });
                                    }
                                }
                            },'json');
                        }else{
                            $('#bidprice').removeAttr("disabled");
                        }
                    });
                }else if(data.status==4){
                    $('#bidprice').removeAttr("disabled");
                    asyncbox.confirm(data.msg,'手机认证',function(buttonResult){
                        if(buttonResult == "ok"){
                            window.location.href = data.skipurl+'?rand='+Math.random();
                        }
                    });
                }
            } else {
                alert(data.msg);
            }
        },'json'); 
    }

    // 连接服务端
    function connect() {
        // 创建websocket
        ws = new WebSocket("ws://"+document.domain+":7272");
        // 当socket连接打开时，输入用户名
        ws.onopen = onopen;

        // 当有消息时根据消息类型显示不同信息
        ws.onmessage = onmessage; 
        ws.onclose = function() {
          console.log("连接关闭，定时重连");
          if(connectLink==1){
            connect();
          }
          
        };
        ws.onerror = function() {
            popStatus(4, '出现错误,请联系网站管理员！', 0,'',true);
            console.log("出现错误");
        };
    }

    // 连接建立时发送登录信息
    function onopen(){
        // 登录
        var login_data = '{"type":"login","client_name":"'+ws_my_name+'","room_id":"'+ws_rom_pre+acpid+'"}';
        // 移除等待提示【
        popStatusOff();
        // 移除等待提示】
        console.log("websocket握手成功，发送登录数据:"+login_data);
        ws.send(login_data);
    }
    // 服务端发来消息时
    function onmessage(e){
        console.log(e.data);
        var data = eval("("+e.data+")");
        switch(data['type']){
            // 服务端ping客户端
            case 'ping':
                ws.send('{"type":"pong","domain":'+domain+'}');
                break;
            // 登录 更新用户列表
            case 'login':
                //{"type":"login","client_id":xxx,"client_name":"xxx","client_list":"[...]","time":"xxx"}
                say(data['client_id'], data['client_name'],  data['client_name']+' 进入拍场', data['time']);
                if(data['client_list']){
                    client_list = data['client_list'];
                }
                else{
                    client_list[data['client_id']] = data['client_name']; 
                }
                // 更新用户列表
                flush_client_list();
                console.log(data['client_name']+"登录成功");
                break;
            // 发言
            case 'say':
                //{"type":"say","from_client_id":xxx,"to_client_id":"all/client_id","content":"xxx","time":"xxx"}
                say(data['from_client_id'], data['from_client_name'], data['content'], data['time']);
                break;
            // 出价
            case 'bid':
                bidChange(data.thisS);
                break;
            // 时间变更
            case 'drive':
                if(data.change.action=='cancel'||data.change.action=='uptime'){
                    if(nstatus=='ing'){
                        clearInterval(endDowntimer);
                        calibrationEndtime(data.change.endtime,data.change.nowtime);
                    }else if(nstatus=='fut'){
                        clearInterval(startDowntimer);
                        calibrationStarttime(data.change.starttime,data.change.nowtime);
                    }
                }else if(data.change.action=='delete'){
                    auctionDeleted();
                }
                break;
            // 用户退出 更新用户列表
            case 'logout':
                //{"type":"logout","client_id":xxx,"time":"xxx"}
                say(data['from_client_id'], data['from_client_name'], data['from_client_name']+' 退出了', data['time']);
                delete client_list[data['from_client_id']];
                flush_client_list();
        }
    }

    // 提交对话
    function onSubmit() {
      var input = document.getElementById("textarea");
      var to_client_id = $("#client_list option:selected").attr("value");
      var to_client_name = $("#client_list option:selected").text();
      ws.send('{"type":"say","to_client_id":"'+to_client_id+'","to_client_name":"'+to_client_name+'","content":"'+input.value+'"}');
      input.value = "";
      input.focus();
    }
// 刷新用户列表框
    function flush_client_list(){
        var userlist_window = $("#userlist ul");
        var client_list_slelect = $("#client_list");
        userlist_window.empty();
        client_list_slelect.empty();
        client_list_slelect.append('<option value="all" id="cli_all">所有人</option>');
        for(var p in client_list){
            userlist_window.append('<li id="'+p+'">'+client_list[p]+'</li>');
            client_list_slelect.append('<option value="'+p+'">'+client_list[p]+'</option>');
        }
        $("#client_list").val(select_client_id);
    }
    // 发言
    function say(from_client_id, from_client_name, content, time){
        $("#dialog").append('<div class="speech_item"><div class="item_head clearfix"><img src="http://lorempixel.com/38/38/?'+from_client_id+'" class="user_icon" /> <div class="head_con">'+from_client_name+' <span class="tm">'+time+'</span></div></div><p class="triangle-isosceles"><img src="'+ltnr+'" class="ltnr" />'+content+'</p> </div>');
        var speed=200;//滑动的速度
        $('.caption_box').animate({ scrollTop: $('#dialog').height()}, speed);
    }
    $(function(){
        select_client_id = 'all';
        $("#client_list").change(function(){
             select_client_id = $("#client_list option:selected").attr("value");
        });
    });
// web_socket】

// 更新页面信息
function bidChange(data){
    // 竞拍出价
    if(bidtype == 0){
        bidCount=data.bidcount;
        steplin = data.stepsize;
        nowPrice = data.nowprice;
        nowUid = data.uid;
        $('#nowth').html("当前价：");
        $('#nowprice').html('<span class="prcl1">'+data.nowprice+'<span class="unit">元</span></span>');
        $('#bidprice').removeAttr("disabled");
        $('#bidprice').val(data.bidprice);
        $('.on-keyboard-input-box').html(data.bidprice);
        $('#stped').html(data.stped);
        $('#steps').html(data.stepsize);
        $('#bidcount').html(data.bidcount);
        $('.nobody').remove();
        $('tr.lingxian').removeClass('lingxian');
        var bid_item = '';
        var bid_itemall = '';
        $.each(data.recordList,function(drk,drv){
            bid_item += '<tr  title="'+drv.time+'" uid="'+drv.uid+'"><td><div class="bidlistico"></div></td><td><span class="on_over" style="width: 60px;">'+drv.nickname+'</span></td><td align="right">';
            if(drv.type=='代理'){
                bid_item += '<span title="代理出价" class="agency_ico"></span>'
            }
            bid_item += drv.money+'</td><td align="right">'+drv.bided+'</td></tr>';
            bid_itemall += '<tr uid="'+drv.uid+'"><td><div class="bidlistico"></div></td><td><span class="on_over" style="width: 60px;">'+drv.nickname+'</span></td><td align="left">';
            if(drv.type=='代理'){
                bid_itemall += '<span title="代理出价" class="agency_ico"></span>'
            }
            bid_itemall += drv.type+'出价</td><td align="right">'+drv.money+'</td><td align="right">'+drv.bided+'</td><td align="center">'+drv.time+'</td></tr>';
            // 我的出价
            if(drv.uid==ws_my_uid){
                popStatus(1, '出价成功', 1,'',true);
                var my_item='<tr title="'+drv.time+'" uid="'+drv.uid+'"><td align="center">'+drv.type+'</td><td align="right">'+drv.money+'</td><td align="right"><span class="red1 fb">'+drv.bided+'</span></td></tr>';
                $('#my_record .th').after(my_item);
                if($('#my_record tr').size()>11){
                    $('#my_record tr:last-child').remove();
                }
                $('#mycount').html(parseInt($('#mycount').html())+1);
            } 
        });
        $('#bid_record .th').after(bid_item);
        if($('#bid_record tr').size()>10){
            $('#bid_record tr').eq(10).nextAll().remove();
        }
        // 全部出价
        $('#bid_jlall .th').after(bid_itemall);
        // 设置领先样式
        $('#bid_record tr').eq(1).addClass('lingxian');
        $('#bid_jlall tr').eq(1).addClass('lingxian');

        // 判断该用户代理是否失效【
        agency_loser(data.agency_loser);
        // 判断该用户代理是否失效】
        // 更新结束时间
        clearInterval(endDowntimer);
        calibrationEndtime(data.endtime,data.nowtime);
    // 竞标出价
    }else if(bidtype == 1){
        bidCount=data.bidcount;
        $('#bidcount').html(data.bidcount);
        $('.nobody').remove();
        // 全部部分出价
        var bid_item='<tr uid="'+data.uid+'"><td><span class="on_over" style="width: 60px;">竞标保密</span></td><td align="center">'+data.type+'</td><td align="right"><span class="red1 fb">竞标保密</span></td><td align="center">'+data.time+'</td></tr>';
        $('#bid_record .th').after(bid_item);
        if($('#bid_record tr').size()>11){
            $('#bid_record tr:last-child').remove();
        }
        // 全部出价
        $('#bid_jlall .th').after(bid_item);
        // 我的出价
        if(data.uid==ws_my_uid){
            var my_item='<tr uid="'+data.uid+'"><td align="center">'+data.type+'</td><td align="right"><span class="red1 fb">'+data.bided+'</span></td><td align="center">'+data.time+'</td></tr>';
            $('#my_record .th').after(my_item);
            if($('#my_record tr').size()>11){
                $('#my_record tr:last-child').remove();
            }
            $('#mycount').html(parseInt($('#mycount').html())+1);
        }
    }
}


// 结束倒计时
function endDown(etime,ntime,boxobj,day_elem,hour_elem,minute_elem,second_elem,msec_elem){
    var now_time = new Date(ntime*1000);
    var end_time = new Date(etime*1000);
    var native_time = new Date().getTime(); //本地时间
    var now_cha = now_time - native_time; //服务器和本地时间差
    var native_end_time = end_time - now_cha; //本地结束时间
    var sys_second = 0;
    endDowntimer = setInterval(function(){
        // 检查本地时间是否更改
        if(Math.abs(native_time - new Date().getTime())>5000){
            clearInterval(endDowntimer);
            $.post(ajaxGetTime, {'pid':acpid},function(data){
                calibrationEndtime(data.endtime,data.nowtime);
            });
        }
        sys_second = (native_end_time - new Date().getTime())/100; //本地结束剩余时间
        if (sys_second > 0) {
            sys_second -= 1;
            var day = Math.floor((sys_second / 36000) / 24);
            var hour = Math.floor((sys_second / 36000) % 24);
            var minute = Math.floor((sys_second / 600) % 60);
            var second = Math.floor((sys_second/10) % 60);
            var msec = Math.floor(sys_second % 10); //毫秒
            day_elem && $(day_elem).text(day);//计算天
            $(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
            $(minute_elem).text(minute<10?"0"+minute:minute);//计算分
            $(second_elem).text(second<10?"0"+second:second);// 计算秒
            $(msec_elem).text(msec);// 计算秒的1/10
            native_time = new Date().getTime();
        } else { 
            clearInterval(endDowntimer);
            // 本地时间结束提交服务器验证是否结束
            $.post(ajaxCheckSucc, {'pid':acpid},function(data){
                if(data.status==0){
                    calibrationEndtime(data.end_time,data.now_time);
                }else{
                    clearInterval(endDowntimer);
                    if(data.status==1){
                        $('#bidTimeStatus').remove();
                        $(boxobj).parents('.onBidTbox').html('<div class="into">拍卖已结束...</div>');
                        var user = data.nickname;
                        if(data.uid==ws_my_uid){user ='您';}
                        var msg = '恭喜'+user+'以'+data.money+'元，拍到《'+data.pname+'》';
                    }else if (data.status==2){
                        var msg = '《'+data.pname+'》未达到保留价，流拍！'
                    }else if (data.status==3){
                        $('#bidTimeStatus').remove();
                        $(boxobj).html('<div class="into">拍品已撤拍...</div>');
                        var msg = '《'+data.pname+'》管理员撤拍！<br/>如果您缴纳过保证金，现在已退还到您的账户。请注意查收'
                    }
                    // 判断当前拍品归属执行操作
                    // 拍卖会操作
                    if(mid!=0){
                        // 显示结束信息
                        if(mtnextPid!=''){
                            var msgtz = '<br/>即将开始下一件拍品！'; 
                        }else{
                            var msgtz = '<br/>正在生成结论书！'; 
                        }
                        popStatus(1, msg+msgtz, 0,'',true);
                        setTimeout(function(){
                            popStatusOff();
                            connectLink = 0;
                            if(mtnextPid!=''){
                                window.location.href = mtnextUrl+'?rand='+Math.random();
                            }else{
                                window.location.href = conclusion+'?rand='+Math.random();
                            }
                        },2000);
                        // 如果下一件拍品存在则跳转到链接地址 否则生成结论书
                        
                    // 普通拍品操作
                    }else{
                        popup.success(msg,'结束提示',function(action){
                    　　　//success 返回两个 action 值，分别是 'ok' 和 'close'。
                            if(action == 'ok'||action == 'close'){
                                connectLink = 0;
                                window.location.href=window.location.href+"?id="+10000*Math.random();;
                            }
                        });
                    } 
                }
            });
        }
    }, 100);
}
// 开始时间倒计时
function startDown(stime,ntime,boxobj,day_elem,hour_elem,minute_elem,second_elem,msec_elem){
    var now_time = new Date(ntime*1000);
    var end_time = new Date(stime*1000);
    var native_time = new Date().getTime(); //本地时间
    var now_cha = now_time - native_time; //服务器和本地时间差
    var native_end_time = end_time - now_cha; //本地结束时间
    var sys_second = 0;
    startDowntimer = setInterval(function(){
        if(Math.abs(native_time - new Date().getTime())>5000){
            clearInterval(startDowntimer);
            $.post(ajaxGetTime, {'pid':acpid},function(data){
                calibrationStarttime(data.starttime,data.nowtime);
            });
        }
        sys_second = (native_end_time - new Date().getTime())/100; //本地结束剩余时间
        if (sys_second > 0) {
            sys_second -= 1;
            var day = Math.floor((sys_second / 36000) / 24);
            var hour = Math.floor((sys_second / 36000) % 24);
            var minute = Math.floor((sys_second / 600) % 60);
            var second = Math.floor((sys_second/10) % 60);
            var msec = Math.floor(sys_second % 10); //毫秒
            day_elem && $(day_elem).text(day);//计算天
            $(hour_elem).text(hour<10?"0"+hour:hour);//计算小时
            $(minute_elem).text(minute<10?"0"+minute:minute);//计算分
            $(second_elem).text(second<10?"0"+second:second);// 计算秒
            $(msec_elem).text(msec);// 计算秒的1/10
            native_time = new Date().getTime();
        } else { 
            $('.noStartBidTbox .th').html('拍卖已开始');
            $(boxobj).html('<div class="into">正在进入拍卖...</div>');
            connectLink = 0;
            clearInterval(startDowntimer);
            window.location.href=window.location.href+"?id="+10000*Math.random();;
        }
    }, 100);
}
// 拍卖被删除操作
function auctionDeleted(etime,ntime){
    if(mid!=0){
        // 显示结束信息
        if(mtnextPid!=''){
            var msgtz = '<br/>即将开始下一件拍品！'; 
        }else{
            var msgtz = '<br/>正在生成结论书！'; 
        }
        popStatus(2, '该拍品已被管理员删除！'+msgtz, 0,'',true);
        setTimeout(function(){
            popStatusOff();
            connectLink = 0;
            if(mtnextPid!=''){
                window.location.href = mtnextUrl+'?rand='+Math.random();
            }else{
                window.location.href = conclusion+'?rand='+Math.random();
            }
        },2000);
        // 如果下一件拍品存在则跳转到链接地址 否则生成结论书
    // 普通拍品操作
    }else{
        popStatus(2, '该拍品已被管理员删除！', 0,'',true);
        setTimeout(function(){
            popStatusOff();
            connectLink = 0;
            window.location.href=window.location.href+"?id="+10000*Math.random();;
        },2000);
    }
}
// 校准结束时间
function calibrationEndtime(etime,ntime){
    endDown(etime,ntime,".onBidtime",".onBidtime .day",".onBidtime .hour",".onBidtime .minute",".onBidtime .second",".onBidtime .msec");
}

// 校准开始时间
function calibrationStarttime(stime,ntime){
    startDown(stime,ntime,".noStartTime",".noStartTime .day",".noStartTime .hour",".noStartTime .minute",".noStartTime .second",".noStartTime .msec");
}
// 代理失败检查提醒
function agency_loser(loserlist){
    if(loserlist){
        $.each(loserlist,function(loserk,loserv){
            if(loserv.uid==ws_my_uid){
                popup.alert(loserv.msg,'代理结束',function(action){
                    if(action == 'ok'||action == 'close'){
                        $.post(iknowurl,{'pid':acpid,'uid':ws_my_uid},function(data){
                            if (data.status) {
                                popup.alert('已取消代理出价！');
                                agency_butstyl(0);
                                setagency=3;
                            } else {
                                popup.alert('取消代理出价失败！');
                            }
                        },'json');
                    }
                });
            }
        });
    }
}
// 代理出价按钮样式改变
function agency_butstyl(sta){
    if(sta==0){
        $('.on-webact-auto').html('启动');
        $('.on-webact-auto').removeClass('stopBtn');
        $('.on-webact-auto').addClass('startBtn');
        $('#robotprice').removeAttr("disabled");
        // 触屏代理按钮显示控制【
        $('.on-wapact-autoimg').attr('src',stopautoimg);
        $('.on-wapact-autotxt').html('启动代理出价');
        // 触屏代理按钮显示控制】
    }else{
        $('.on-webact-auto').html('停止');
        $('.on-webact-auto').removeClass('startBtn');
        $('.on-webact-auto').addClass('stopBtn');
        $('#robotprice').attr("disabled", 'disabled'); 
        // 触屏代理按钮显示控制【
        $('.on-wapact-autoimg').attr('src',startautoimg);
        $('.on-wapact-autotxt').html('取消代理出价');
        // 触屏代理按钮显示控制【
    }
    
}
