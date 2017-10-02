angular.module('basic.System.distributionSet', [

]).controller('controller.basic.System.distributionSet', ["$scope" ,"$rootScope" , "$stateParams", "security" , "utils", 'basic.System.distributionSet', function($scope,$rootScope, $stateParams, security, utils, systemService){
    $scope.systemService = systemService;  
    $scope.utils = utils;
      systemService.getwebInfo().success(function (list) {
      	console.log(list)
        $scope.webInfo = list;
    });

    $scope.distributionSetSubmit=function(item){
        systemService.distributionSetPost(item).success(function(res,status){
            if(status==200){
                utils.message(res.msg);
                
            }else{
                utils.message(res.error);
            }
        });        
    }
}]);
