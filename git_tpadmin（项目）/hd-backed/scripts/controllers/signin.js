'use strict';

function signinCtrl($rootScope,$scope, $state, $cookieStore) {
    
    
  $scope.signShow=function (gotou){
       $state.go(gotou);
  }
  $scope.signIn = function() {
    //先进行判断
    var ini = $scope.checkLoginInp();
    if(ini!=1){
      return;
    }
    $.post(apiHost+'/admin/login/checkLogin', {
      account: $scope.signNo,
      password: $scope.signPsd
    }).success(function(data) {
      if(!data.message){
        $cookieStore.put("account",data.account);
        $rootScope.user = {
          //fid: data.id,
          fname: data.account
        };
        $rootScope.authList=getData(apiHost+'/admin/admin_index/auth');
        $rootScope.authControl=getData(apiHost+'/admin/admin_index/auth2');
        $state.go('app.index');
      }else{
        $("input[name='phone']").before('<span class="tips" id="userTip">' + data.message + '！</span>')
      }
    });
  };
  


  $scope.checkLoginInp = function(){
    if($("#userTip").length > 0){
         $("#userTip").remove();
       }
    if($("#psdTip").length > 0){
          $("#psdTip").remove();
        }
    var _user = $("input[name='phone']");
    var _psd = $("input[name='password']");
    if (_user.val() == '') {

      if($("#userTip").length > 0){
          $("#userTip").remove();
        }
        _user.before('<span class="tips" id="userTip">请输入用户名！</span>');
        return 0;
    } else if (_psd.val() == '') {
      if($("#userTip").length > 0){
          $("#userTip").remove();
        }
        _user.before('<span class="tips" id="userTip">请输入密码！</span>');
        return 0;
    }
    return 1;
  }
}
angular.module('app').controller('signinCtrl', ['$rootScope', '$scope', '$state', "$cookieStore", signinCtrl]);