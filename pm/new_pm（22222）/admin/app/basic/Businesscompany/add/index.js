var curApp = angular.module('basic.Businesscompany.add', []);

curApp.controller('controller.basic.Businesscompany.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Businesscompany.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinesscompanyService, HOST) {
    $scope.BusinesscompanyService = BusinesscompanyService;
    $scope.utils = utils;
    
    BusinesscompanyService.getProvinceList().success(function (list) {
        $scope.provList = list;
    });
    
    $scope.getMapCity = function(id){
    	BusinesscompanyService.getCityList(id).success(function (list) {
            $scope.cityList = list;
            // 清空area
            $scope.areaList = {};
        });
    }
    
    $scope.getMapArea = function(id){
    	BusinesscompanyService.getAreaList(id).success(function (list) {
            $scope.areaList = list;
        });
    }
    
    $scope.addSubmit = function(){
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Business_Company/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
        	if(status != 200){
        		$.MsgBox.Alert("操作提示", res.error);
        	}else{
                    $.MsgBox.Confirm("操作提示", res.msg + '是否继续添加', function(){
                            $state.reload();
                    }, function(){
                            $state.go("basic-Businesscompany-index");
                    });
        	}
       });
    };
}]);
