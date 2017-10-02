var curApp = angular.module('basic.Businesscompany.view', []);

curApp.controller('controller.basic.Businesscompany.view', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Businesscompany.view", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinesscompanyService, HOST) {
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
    
    BusinesscompanyService.getDetail($stateParams.com_id).success(function (data) {
        $scope.item = data;
    	BusinesscompanyService.getCityList($scope.item.com_province).success(function (list) {
            $scope.cityList = list;
        });
    	BusinesscompanyService.getAreaList($scope.item.com_city).success(function (list) {
            $scope.areaList = list;
        });
    });
    
}]);
