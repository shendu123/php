'use strict';


function nodeCtrl($rootScope,$scope,$state,$cookieStore, NgTableParams, $filter, $http, editableOptions, editableThemes, SweetAlert, COLORS,$timeout, $compile, Upload) {
  editableThemes.bs3.inputClass = 'input-sm';
  editableThemes.bs3.buttonsClass = 'btn-sm';
  editableOptions.theme = 'bs3';


  $scope.ea_url = "app.node.ea";
  $scope.list_url = "app.node.index";

  var pdata = {};
  //pdata = {"id":$cookieStore.get("privilegeid"),"type":typeppo};

  $scope.carsData = getData(apiHost+'/admin/admin_node/index',pdata);
 //console.log($scope.carsData );
  $scope.editNode = function(id){
          $cookieStore.put("nodeid",id);
          $cookieStore.remove('npid');
          $state.go('app.node.addnode');     
  }
    $scope.addChild = function(id,title){console.log(id);
          $cookieStore.put("npid",id);
          $cookieStore.put("nptitle",title);
          $cookieStore.remove('nodeid');
          $state.go('app.node.addChild');     
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
      $.post(apiHost+'/admin/admin_node/delete',{id:id})
      .success(function(data) {
        $scope.carsData = getData(apiHost+'/admin/admin_node/index',pdata);

        $scope.tableParams = new NgTableParams({
          count: 20
        }, {
          counts: [10, 25, 50],
          data: $scope.carsData
        });
        
        $scope.tableParams.reload();
        $rootScope.showNoty(data);
      });


  };


//  $scope.tableParams = new NgTableParams({
//    count: 20
//  }, {
//    counts: [10, 25, 50],
//    data: $scope.carsData
//  });
  // add user
  $scope.addNode = function(gotou) {
      $cookieStore.remove('nodeid');
      $cookieStore.remove('npid');
      $state.go(gotou);
  };

  $scope.deleteAll = function() {
    $http.post('/Savedata/deleteWzcxAll')
        .success(function(json) {
          $rootScope.showNoty(json);
      });
  };
}
angular.module('app').controller('nodeCtrl', ['$rootScope','$scope','$state','$cookieStore' ,'NgTableParams','$filter', '$http', 'editableOptions', 'editableThemes','SweetAlert', 'COLORS','$timeout', '$compile', 'Upload', nodeCtrl]);