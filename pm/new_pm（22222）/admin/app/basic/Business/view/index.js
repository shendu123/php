var curApp = angular.module('basic.Business.view', []);

curApp.controller('controller.basic.Business.view', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Business.view", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinessService, HOST) {
    $scope.utils = utils;

    
    
    BusinessService.getDetail($stateParams.business_id).success(function (data) {
        $scope.item = data;
    });
    
}]);
