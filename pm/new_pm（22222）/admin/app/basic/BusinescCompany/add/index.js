var curApp = angular.module('basic.Company.add', []);

curApp.controller('controller.basic.Company.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Company.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, companyService, HOST) {
    $scope.companyService = companyService;
    $scope.utils = utils;
    
    companyService.getProvinceList().success(function (list) {
        $scope.provList = list;
    });
    
    $scope.getMapCity = function(id){
    	companyService.getCityList(id).success(function (list) {
            $scope.cityList = list;
            // 清空area
            $scope.areaList = {};
        });
    }
    
    $scope.getMapArea = function(id){
    	companyService.getAreaList(id).success(function (list) {
            $scope.areaList = list;
        });
    }
    
    $scope.addSubmit = function(){
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Company/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
        	if(data.status != 200){
        		$.MsgBox.Alert("操作提示", data.msg);
        	}else{
                $.MsgBox.Confirm("操作提示", data.msg + '是否继续添加', function(){
                	$state.reload();
                }, function(){
                	$state.go("basic-Company-index");
                });
        	}
       });
    };
}]);
