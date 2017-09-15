'use strict';


function usereaCtrl($rootScope,$scope,$cookieStore) {

  $scope.ea_url = "app.user.ea";
  $scope.list_url = "app.user.index";

  var typeppo = "user";
  var this_id = "this_user_id";

  var pdata = {};
  
  $scope.$watch('file', function() {
    if ($scope.file !== null) {
      $scope.files = [$scope.file];
    }
  });
  $scope.log = '';

  $scope.postUserData = function(data){
      var url='';
      if(data.uid){
          url='/admin/admin_user/update/id/'+data.uid;
      }else{
          url='/admin/admin_user/add';
      }
    $.post(apiHost+url, {
      account:data.account,
      truename:data.truename,
      password:data.password,
      status:data.status
    })
    .success(function(data) {
      if(!data.message){
        $scope.data = getData(apiHost+'/admin/admin_user/index',pdata);
        $rootScope.statGoto($scope.list_url);
      }else{
        $cookieStore.put("userid",data.id);
      }
      $rootScope.showNoty(data);

    });
  };
  

  $scope.data = {};

  if(!$cookieStore.get('userid')){

  }else{
      $.get(apiHost+'/admin/admin_user/edit/', {
        id:$cookieStore.get('userid')
      }).success(function(data) {
          $scope.data = data;
      });
    $("#email_user").attr("disabled",true);
    $("#button_pri").html("保存修改");
    $cookieStore.remove('userid');
  }


}
angular.module('app').controller('usereaCtrl', ['$rootScope','$scope','$cookieStore',usereaCtrl]);