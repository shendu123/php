'use strict';


function nodeeaCtrl($rootScope,$scope,$cookieStore) {

  $scope.ea_url = "app.node.ea";
  $scope.list_url = "app.node.index";

  var typeppo = "node";
  var this_id = "this_node_id";

  var pdata = {};
  pdata = {"id":$cookieStore.get("nodeid")};
  
  $scope.$watch('file', function() {
    if ($scope.file !== null) {
      $scope.files = [$scope.file];
    }
  });
  $scope.log = '';

  $scope.postNodeData = function(data){console.log(data);
      var url='';
      //console.log($scope.npid);return;
      if($scope.npid){
            url='/admin/admin_node/addChild/npid/'+$scope.npid;
      }else{
            if(data.id){
                url='/admin/admin_node/update/id/'+data.id;
            }else{
                url='/admin/admin_node/add';
            }
            data.pid=document.getElementsByName("pid")[0].value;//alert(data.pid);return;
      }
    $.post(apiHost+url,data)
    .success(function(data) {
      if(!data.message){
        $scope.data = getData(apiHost+'/admin/admin_node/index',pdata);
        $rootScope.statGoto($scope.list_url);
      }else{
        $cookieStore.put("nodeid",data.id);
      }
      $rootScope.showNoty(data);

    });
  };
  

  $scope.data = {};

  if(!$cookieStore.get('nodeid')&&!$cookieStore.get('npid')){console.log($cookieStore.get('npid')+"ccc");

  }else if(!$cookieStore.get('nodeid')&&$cookieStore.get('npid')){console.log($cookieStore.get('npid')+"aaa");
      $scope.npid = $cookieStore.get('npid');
      $scope.nptitle = $cookieStore.get('nptitle');
  }else{console.log($cookieStore.get('npid')+"bbb");
        $.get(apiHost+'/admin/admin_node/edit/', {
          id:$cookieStore.get('nodeid')
        }).success(function(data) {
            $scope.data = data;
        });
        $("#email_node").attr("disabled",true);
        $("#button_pri").html("保存修改");
        $cookieStore.remove('nodeid');
  }


}
angular.module('app').controller('nodeeaCtrl', ['$rootScope','$scope','$cookieStore',nodeeaCtrl]);