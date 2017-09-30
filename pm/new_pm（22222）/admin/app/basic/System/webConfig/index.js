angular.module('basic.System.webConfig', [

]).controller('controller.basic.System.webConfig', ["$scope" ,"$rootScope" , "$stateParams", "security" , "utils", 'basic.System.webConfig', function($scope,$rootScope, $stateParams, security, utils, systemService){
    $scope.systemService = systemService;
    $scope.utils = utils;
    systemService.webConfig().success(function(res,status){
    	console.log(res)
        $rootScope.webInfo=res;
    });
    $scope.webConfigSubmit=function(item){
        systemService.webConfigPost(item).success(function(res,status){
            if(status==200){
                utils.message(res.msg);
                
            }else{
                utils.message(res.error);
            }
        });        
    }
}]);
