var curApp = angular.module('basic.Business.check', []);

curApp.controller('controller.basic.Business.check', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Business.check", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinessService, HOST) {
    $scope.utils = utils;

    
    
    
    BusinessService.getProvinceList().success(function (list) {
        $scope.provList = list;
    });
    
    $scope.getMapCity = function(id){
    	BusinessService.getCityList(id).success(function (list) {
            $scope.cityList = list;
            // 清空area
            $scope.areaList = {};
        });
    }
    
    $scope.getMapArea = function(id){
    	BusinessService.getAreaList(id).success(function (list) {
            $scope.areaList = list;
        });
    }
    
    BusinessService.getDetail($stateParams.com_id).success(function (data) {
        $scope.item = data;
    	BusinessService.getCityList($scope.item.com_province).success(function (list) {
            $scope.cityList = list;
        });
    	BusinessService.getAreaList($scope.item.com_city).success(function (list) {
            $scope.areaList = list;
        });
    });
    
    $scope.checkSubmit = function (item){
        item.business_id=$stateParams.business_id;
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Business/check',
            data	: item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status==200){
                $.MsgBox.Alert("操作提示", res.msg, function(){
                    if(res.data.business_id && res.data.sysid<4){//不是二级运营商才能添加二级运营商
                        $state.go("basic-Business-add",{pid:res.data.business_id});
                    }else{
                        $state.go("basic-Business-index");
                    }                    
                });
            }else{
                $.MsgBox.Alert("操作提示", res.error);
            }
            
        });
    };
}]);
