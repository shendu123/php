'use strict';


function roleeaCtrl($rootScope,$scope,$cookieStore) {

  $scope.ea_url = "app.role.ea";
  $scope.list_url = "app.role.index";

  var typeppo = "role";
  var this_id = "this_role_id";

  var pdata = {};
  pdata = {"id":$cookieStore.get("roleid"),"type":typeppo};
  
  $scope.$watch('file', function() {
    if ($scope.file !== null) {
      $scope.files = [$scope.file];
    }
  });
  $scope.log = '';

  $scope.postRoleData = function(data){
      var url='';
      if(data.id){
          url='/admin/admin_role/update/id/'+data.id;
      }else{
          url='/admin/admin_role/add';
      }
    $.post(apiHost+url, {
      name:data.name,
      remark:data.remark,
      status:data.status
    })
    .success(function(data) {
      if(!data.message){
        $scope.data = getData(apiHost+'/admin/admin_role/index',pdata);
        $rootScope.statGoto($scope.list_url);
      }else{
      }
      $rootScope.showNoty(data);

    });
  };
  

  $scope.data = {};

  if(!$cookieStore.get('roleid')){

  }else{
      $.get(apiHost+'/admin/admin_role/edit/', {
        id:$cookieStore.get('roleid')
      }).success(function(data) {
          $scope.data = data;
          console.log(data);
      });
    $("#email_role").attr("disabled",true);
    $("#button_pri").html("保存修改");
    $cookieStore.remove('roleid');
  }


}
angular.module('app').controller('roleeaCtrl', ['$rootScope','$scope','$cookieStore',roleeaCtrl]);