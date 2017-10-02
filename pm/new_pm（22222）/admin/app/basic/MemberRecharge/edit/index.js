var curApp = angular.module('basic.Company.edit', []);

curApp.controller('controller.basic.Company.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Company.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, companyService, HOST) {
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
    
    companyService.getDetail($stateParams.com_id).success(function (data) {
        $scope.item = data.data;
    	companyService.getCityList($scope.item.com_province).success(function (list) {
            $scope.cityList = list;
        });
    	companyService.getAreaList($scope.item.com_city).success(function (list) {
            $scope.areaList = list;
        });
    });
    
    $scope.editSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Company/edit',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
            	$state.go("basic-Company-index");
            });
        });
    };
}]);
