'use strict';


function roleaccessCtrl($rootScope,$scope,$cookieStore) {

  $scope.list_url = "app.role.index";
  var pdata = {};
  pdata = {"id":$cookieStore.get("roleid")};
  
    $scope.isSelected = function($event,value,id){//console.log(value);
      var checkbox = $event.target;
      var className=checkbox.parentNode.parentNode.className;//console.log(className);
      var node=$("#node"+id);
      var pValue=node.parents('ul').find(".firstCb").attr('data-value');
      var noF=node.parents("ul").find('.noFirstCb');
      var checkedSize;
      if(className=='firstCb'){          
            node.parents('ul').find(".noFirstCb").each(function(){
                  var chValue=$(this).attr('data-value');
                  if(checkbox.checked){
                      $scope.check_access.push(chValue);
                      checkedSize=noF.find("input[type=checkbox]").length;
                  }else{
                      $scope.check_access.remove(chValue);
                      checkedSize=0;
                  }               
            });         
      }else{            
            if(checkbox.checked){
                $scope.check_access.push(value);  
                checkedSize=noF.find("input[type=checkbox]:checked").length;
            }else{
                 for(var i=0;i<$scope.check_access.length;i++){
                      if($scope.check_access[i]==value){
                              $scope.check_access.remove(value);
                      }
                 }
            }                                    
      }
      if(checkedSize>0&&!$rootScope.in_array(pValue,$scope.check_access)){//改为in_array
            $scope.check_access.push(pValue);
      }else if(checkedSize==0){
            $scope.check_access.remove(pValue);
      }  
  }
 

  $scope.postRoleAccess = function(){
      var url='/admin/admin_role/access';
    $.post(apiHost+url, {
      id:$cookieStore.get('roleid'),
      node_id:$scope.check_access
    })
    .success(function(data) {
      if(!data.message){
        $rootScope.authList=getData(apiHost+'/admin/admin_index/auth');
        $rootScope.authControl=getData(apiHost+'/admin/admin_index/auth2');
        $rootScope.statGoto($scope.list_url);
      }else{
      }
      $cookieStore.remove('roleid');
      $rootScope.showNoty(data);

    });
  };
  $scope.carsData = getData(apiHost+'/admin/admin_node/index');
    $.ajaxSetup({  
         async : false  
     }); 
  $.get(apiHost+'/admin/admin_role/access',pdata)
  .success(function(data){
      if(data){
          $scope.check_access=data.access_value?data.access_value:[];
          $scope.check_access_id=data.access_id?data.access_id:[];
      }
      
  })
 //console.log($scope.check_access);
}
angular.module('app').controller('roleaccessCtrl', ['$rootScope','$scope','$cookieStore',roleaccessCtrl]);