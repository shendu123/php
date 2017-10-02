angular.module('basic.System.shopProcess', [

]).controller('controller.basic.System.shopProcess', ["$scope" ,"$rootScope" , "$stateParams", "security" , "utils", 'basic.System.shopProcess', function($scope,$rootScope, $stateParams, security, utils, systemService){
    $scope.systemService = systemService;
    $scope.utils = utils;
         systemService.getshopProcess().success(function (res,status) {

         	
         	console.log(res)
         	$rootScope.shopProcess=res
//       	 $rootScope.shopProcess.integral_reg=res.integral.integral_money.config_remarks;

    });
    $scope.shopProcessSubmit=function(item){
        console.log("shopProcessSubmit");
        
        systemService.shopProcessPost(item).success(function(res,status){
            if(status==200){
            	console.log(res)
                utils.message(res.msg);
                
            }else{
                utils.message(res.error);
            }
        });        
    }
}]);
