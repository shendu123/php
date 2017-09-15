'use strict';


function roleuserlistCtrl($rootScope,$scope,$cookieStore) {

  $scope.list_url = "app.role.index";
  var pdata = {};
  pdata = {"id":$cookieStore.get("roleid")};
  
    $scope.isSelected = function($event,id){
      var checkbox = $event.target;
      if(checkbox.checked){
          $scope.check_user.push(id);
      }else{
           for(var i=0;i<$scope.check_user.length;i++){
                if($scope.check_user[i]==id){
                        $scope.check_user.remove(id);
                }
           }
      }
      //console.log($scope.check_user);
  }

  $scope.postRoleUser = function(){
      var url='/admin/admin_role/user';
    $.post(apiHost+url, {
      id:$cookieStore.get('roleid'),
      user_id:$scope.check_user
    })
    .success(function(data) {
      if(!data.message){
        $scope.data = getData(apiHost+'/admin/admin_role/index');
        $rootScope.statGoto($scope.list_url);
      }else{
      }
      $cookieStore.remove('roleid');
      $rootScope.showNoty(data);

    });
  };
  $scope.carsData = getData(apiHost+'/admin/admin_user/index');
  $scope.check_user=getData(apiHost+'/admin/admin_role/user',pdata);//console.log($scope.check_user);
}
angular.module('app').controller('roleuserlistCtrl', ['$rootScope','$scope','$cookieStore',roleuserlistCtrl]);