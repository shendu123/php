'use strict';


function userCtrl($rootScope,$scope,$state,$cookieStore, NgTableParams, $filter, $http, editableOptions, editableThemes, SweetAlert, COLORS,$timeout, $compile, Upload) {
  editableThemes.bs3.inputClass = 'input-sm';
  editableThemes.bs3.buttonsClass = 'btn-sm';
  editableOptions.theme = 'bs3';


  $scope.ea_url = "app.user.ea";
  $scope.list_url = "app.user.index";

  var pdata = {};
  $scope.carsData = getData(apiHost+'/admin/admin_user/index',pdata);
  $scope.editUser = function(id){
          $cookieStore.put("userid",id);
          $state.go('app.user.adduser');     
  } 
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
      $.post(apiHost+'/admin/admin_user/delete',{id:id})
      .success(function(data) {
        $scope.data = getData(apiHost+'/admin/admin_user/index',pdata);

        $scope.tableParams = new NgTableParams({
          count: 20
        }, {
          counts: [10, 25, 50],
          data: $scope.data
        });
        
        $scope.tableParams.reload();
        $rootScope.showNoty(data);
      });


  };
  // add user
  $scope.addUser = function(gotou) {
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
angular.module('app').controller('userCtrl', ['$rootScope','$scope','$state','$cookieStore' ,'NgTableParams','$filter', '$http', 'editableOptions', 'editableThemes','SweetAlert', 'COLORS','$timeout', '$compile', 'Upload', userCtrl]);