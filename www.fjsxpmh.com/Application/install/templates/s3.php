﻿<!doctype html>
<html>
    <head>
        <meta charset="UTF-8" />
        <title><?php echo $Title; ?> - <?php echo $Powered; ?></title>
        <link rel="stylesheet" href="./css/install.css?v=9.0" />
    </head>
    <body>
        <div class="wrap">
            <?php require './templates/header.php'; ?>
            <section class="section">
                <div class="step">
                    <ul>
                        <li class="on"><em>1</em>检测环境</li>
                        <li class="current"><em>2</em>创建数据</li>
                        <li><em>3</em>完成安装</li>
                    </ul>
                </div>
                <form id="J_install_form" action="index.php?step=4" method="post">
                    <input type="hidden" name="force" value="0" />
                    <div class="server">
                        <table width="100%">
                            <tr>
                                <td class="td1" width="100">数据库信息</td>
                                <td class="td1" width="200">&nbsp;</td>
                                <td class="td1">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="tar">数据库服务器：</td>
                                <td><input type="text" name="dbhost" id="dbhost" value="127.0.0.1" class="input"></td>
                                <td><div id="J_install_tip_dbhost"><span class="gray">数据库服务器地址，一般为localhost</span></div></td>
                            </tr>
                            <tr>
                                <td class="tar">数据库端口：</td>
                                <td><input type="text" name="dbport" id="dbport" value="3306" class="input"></td>
                                <td><div id="J_install_tip_dbport"><span class="gray">数据库服务器端口，一般为3306</span></div></td>
                            </tr>
                            <tr>
                                <td class="tar">数据库用户名：</td>
                                <td><input type="text" name="dbuser" id="dbuser" value="root" class="input"></td>
                                <td><div id="J_install_tip_dbuser"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">数据库密码：</td>
                                <td><input type="text" name="dbpw" id="dbpw" value="" class="input" autoComplete="off" onblur="TestDbPwd()"></td>
                                <td><div id="J_install_tip_dbpw"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">数据库名：</td>
                                <td><input type="text" name="dbname" id="dbname" value="" class="input"></td>
                                <td><div id="J_install_tip_dbname"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">数据库表前缀：</td>
                                <td><input type="text" name="dbprefix" id="dbprefix" value="on_" class="input"></td>
                                <td><div id="J_install_tip_dbprefix"><span class="gray">建议使用默认，同一数据库安装多个通用后台时需修改</span></div></td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td class="td1" width="100">网站配置</td>
                                <td class="td1" width="200">&nbsp;</td>
                                <td class="td1">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="tar">域名：</td>
                                <td><input type="text" name="siteurl" value="http://<?php echo $domain ?>/" id="siteurl" class="input" autoComplete="off"></td>
                                <td><div id="J_install_tip_siteurl"><span class="gray">请以“/”结尾</span></div></td>
                            </tr>
                            <tr>
                                <td class="tar">网站名称：</td>
                                <td><input type="text" name="sitename" value="昂酷拍卖" class="input"></td>
                                <td><div id="J_install_tip_sitename"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">网站标题：</td>
                                <td><input type="text" name="sitetitle" value="昂酷拍卖演示站—国内最成熟在线拍卖软件程序" class="input"></td>
                                <td><div id="J_install_tip_sitetitle"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">关键词：</td>
                                <td><input type="text" name="sitekeywords" value="昂酷拍卖系统,昂酷拍卖系统演示站,拍卖软件程序,在线拍卖软件,竞价软件,拍卖网源码,淘宝拍卖源码,苏宁闪拍源码,二手车拍卖系统,艺术品拍卖软件" class="input" autoComplete="off"></td>
                                <td><div id="J_install_tip_sitekeywords"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">描述：</td>
                                <td><textarea class="input" name="siteinfo">昂酷拍卖系统是国内最成熟的通用拍卖软件程序,可配置为淘宝拍卖系统、二手车拍卖软件、艺术品在线拍卖程序等竞价软件程序！昂酷拍卖具有安全、可靠、通用、易配置、易操作的优点！</textarea></td>
                                <td><div id="J_install_tip_siteinfo"></div></td>
                            </tr>
                        </table>
                        <table width="100%">
                            <tr>
                                <td class="td1" width="100">创始人信息</td>
                                <td class="td1" width="200">&nbsp;</td>
                                <td class="td1">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="tar">管理员帐号：</td>
                                <td><input type="text" name="manager_email" class="input" value=""></td>
                                <td><div id="J_install_tip_manager_email">邮件地址</div></td>
                            </tr>
                            <tr>
                                <td class="tar">密码：</td>
                                <td><input type="text" name="manager_pwd" id="J_manager_pwd" class="input" autoComplete="off"></td>
                                <td><div id="J_install_tip_manager_pwd"></div></td>
                            </tr>
                            <tr>
                                <td class="tar">重复密码：</td>
                                <td><input type="text" name="manager_ckpwd" class="input" autoComplete="off"></td>
                                <td><div id="J_install_tip_manager_ckpwd"></div></td>
                            </tr>
                        </table>
                        <input type="hidden" name="webPath" value="<?php echo $rootpath?>/" />
                        <div id="J_response_tips" style="display:none;"></div>
                    </div>
                    <div class="bottom tac"> <a href="./index.php?step=2" class="btn">上一步</a>
                        <button type="submit" class="btn btn_submit J_install_btn">创建数据</button>
                    </div>
                </form>
            </section>
            <div  style="width:0;height:0;overflow:hidden;"> <img src="./images/pop_loading.gif"> </div>
            <script src="./js/jquery.js?v=9.0"></script>
            <script src="./js/validate.js?v=9.0"></script>
            <script src="./js/ajaxForm.js?v=9.0"></script>
            <script>
                function TestDbPwd()
                {

                    var dbHost = $('#dbhost').val();
                    var dbUser = $('#dbuser').val();
                    var dbPwd = $('#dbpw').val();
                    var dbName = $('#dbname').val();
                    var dbPort = $('#dbport').val();
                    data={'dbHost':dbHost,'dbUser':dbUser,'dbPwd':dbPwd,'dbName':dbName,'dbPort':dbPort};
                    var url =  "./index.php?step=3&testdbpwd=1";
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        beforeSend:function(){
                        },
                        success: function(msg){
                            if(msg){

                            }else{
                                $('#dbpw').val("");
                                $('#J_install_tip_dbpw').html('<span for="dbname" generated="true" class="tips_error" style="">数据库链接配置失败</span>');
                            }
                        },
                        complete:function(){
                        },
                        error:function(){
                            $('#J_install_tip_dbpw').html('<span for="dbname" generated="true" class="tips_error" style="">数据库链接配置失败</span>');
                            $('#dbpw').val("");
                        }
                    });
                }
                $(function(){

                    //聚焦时默认提示
                    var focus_tips = {
                        dbhost : '数据库服务器地址，一般为localhost',
                        dbport : '数据库服务器端口，一般为3306',
                        dbuser : '',
                        dbpw : '',
                        dbname : '',
                        dbprefix : '建议使用默认，同一数据库安装多个时需修改',
                        manager : '创始人帐号，拥有站点后台所有管理权限',
                        manager_pwd : '',
                        manager_ckpwd : '',
                        siteurl : '请以“/”结尾',
                        wapurl : '请以“/”结尾',
                        sitename : '网站名称，短小精悍，如：昂酷拍卖',
                        sitetitle : '页面"title"处的内容',
                        sitekeywords : '页面"keywords"处的内容',
                        siteinfo : '页面"description"处的内容',
                        manager_email : ''
                    };


                    var install_form = $("#J_install_form"),
                    reg_username = $('#J_reg_username'),						//用户名表单
                    reg_password = $('#J_reg_password'),						//密码表单
                    reg_tip_password = $('#J_reg_tip_password'),		//密码提示区
                    response_tips = $('#J_response_tips');				//后端返回提示

                    //validate插件修改了remote ajax验证返回的response处理方式；增加密码强度提示 passwordRank
                    install_form.validate({
                        //debug : true,
                        //onsubmit : false,
                        errorPlacement: function(error, element) {
                            //错误提示容器
                            $('#J_install_tip_'+ element[0].name).html(error);
                        },
                        errorElement: 'span',
                        //invalidHandler : , 未验证通过 回调
                        //ignore : '.ignore' 忽略验证
                        //onkeyup : true,
                        errorClass : 'tips_error',
                        validClass		: 'tips_error',
                        onkeyup : false,
                        focusInvalid : false,
                        rules: {
                            dbhost: {
                                required	: true
                            },
                            dbport:{
                                required	: true
                            },
                            dbuser: {
                                required	: true
                            },
                            /*dbpw: {
                                required	: true
                            },*/
                            dbname: {
                                required	: true
                            },
                            dbprefix : {
                                required	: true
                            },
                            manager: {
                                required	: true
                            },
                            manager_pwd: {
                                required	: true
                            },
                            manager_ckpwd: {
                                required	: true,
                                equalTo : '#J_manager_pwd'
                            },
                            manager_email: {
                                required	: true,
                                email : true
                            }
                        },
                        highlight	: false,
                        unhighlight	: function(element, errorClass, validClass) {
                            var tip_elem = $('#J_install_tip_'+ element.name);

                            tip_elem.html('<span class="'+ validClass +'" data-text="text"><span>');

                        },
                        onfocusin	: function(element){
                            var name = element.name;
                            $('#J_install_tip_'+ name).html('<span data-text="text">'+ focus_tips[name] +'</span>');
                            $(element).parents('tr').addClass('current');
                        },
                        onfocusout	:  function(element){
                            var _this = this;
                            $(element).parents('tr').removeClass('current');

                            if(element.name === 'email') {
                                //邮箱匹配点击后，延时处理
                                setTimeout(function(){
                                    _this.element(element);
                                }, 150);
                            }else{

                                _this.element(element);

                            }

                        },
                        messages: {
                            dbhost: {
                                required	: '数据库服务器地址不能为空'
                            },
                            dbport:{
                                required	: '数据库服务器端口不能为空'
                            },
                            dbuser: {
                                required	: '数据库用户名不能为空'
                            },
                            dbpw: {
                                required	: '数据库密码不能为空'
                            },
                            dbname: {
                                required	: '数据库名不能为空'
                            },
                            dbprefix : {
                                required	: '数据库表前缀不能为空'
                            },
                            manager: {
                                required	: '管理员帐号不能为空'
                            },
                            manager_pwd: {
                                required	: '密码不能为空'
                            },
                            manager_ckpwd: {
                                required	: '重复密码不能为空',
                                equalTo : '两次输入的密码不一致。请重新输入'
                            },
                            manager_email: {
                                required	: 'Email不能为空',
                                email : '请输入正确的电子邮箱地址'
                            }
                        },
                        submitHandler:function(form) {
                            form.submit();
                            return true;
                        }
                    });


                    var _data = {};
                });
            </script>
        </div>
        <?php require './templates/footer.php'; ?>
    </body>
</html>