'use strict';


function roleCtrl($rootScope,$scope,$state,$cookieStore, NgTableParams, $filter, $http, editableOptions, editableThemes, SweetAlert, COLORS,$timeout, $compile, Upload) {
  editableThemes.bs3.inputClass = 'input-sm';
  editableThemes.bs3.buttonsClass = 'btn-sm';
  editableOptions.theme = 'bs3';


  $scope.ea_url = "app.role.ea";
  $scope.list_url = "app.role.index";

  var pdata = {};
  //pdata = {"id":$cookieStore.get("privilegeid"),"type":typeppo};

  $scope.carsData = getData(apiHost+'/admin/admin_role/index',pdata);
  //console.log($scope.carsData);
  


  $scope.editRole = function(id){
          $cookieStore.put("roleid",id);
          $state.go('app.role.addrole');     
  } 
  
  //角色用户列表
  $scope.role_user = function(id) {
          $cookieStore.put("roleid",id);
          $state.go('app.role.role_user_list');   
  };
    //角色权限列表
  $scope.role_access = function(id) {
          $cookieStore.put("roleid",id);
          $state.go('app.role.role_access');   
  };



  $scope.deleteById = function(id) {
    SweetAlert.swal({
      title: '你确定?',
      text: '删除后将不能恢复!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: COLORS.danger,
      confirmButtonText: '删除',
      cancelButtonText: '取消',
      closeOnConfirm: true,
      closeOnCancel: true
    }, function(isConfirm) {
      if (isConfirm) {
        $scope.postDelData(id);
        swal('已删除!', '该条数据已删除！', 'success');
      } else {
        swal('取消', '该条数据未删除', 'error');
      }
    });

  };


  $scope.postDelData = function(id) {
      $.post(apiHost+'/admin/admin_role/delete',{id:id})
      .success(function(data) {
        $scope.data = getData(apiHost+'/admin/admin_role/index',pdata);
        $rootScope.statGoto($scope.list_url);

//        $scope.tableParams = new NgTableParams({
//          count: 20
//        }, {
//          counts: [10, 25, 50],
//          data: $scope.data
//        });
//        
//        $scope.tableParams.reload();
        $rootScope.showNoty(data);
      });


  };

  // add Role
  $scope.addRole = function(gotou) {
      $state.go(gotou);
  };

  $scope.tableParams = new NgTableParams({
    count: 20
  }, {
    counts: [10, 25, 50],
    data: $scope.carsData
  });

  $scope.deleteAll = function() {
    $http.post('/Savedata/deleteWzcxAll')
        .success(function(json) {
          $rootScope.showNoty(json);
      });
  };

}
angular.module('app').controller('roleCtrl', ['$rootScope','$scope','$state','$cookieStore' ,'NgTableParams','$filter', '$http', 'editableOptions', 'editableThemes','SweetAlert', 'COLORS','$timeout', '$compile', 'Upload', roleCtrl]);