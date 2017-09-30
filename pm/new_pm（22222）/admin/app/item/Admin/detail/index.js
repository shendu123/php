angular.module('item.Admin.detail', [

]).controller('controller.item.Admin.detail', ["$state", "$scope", "$rootScope", "$stateParams", "utils", "item.Admin.detail", function($state, $scope, $rootScope, $stateParams, utils, detailService) {
    $scope.detailService = detailService;
    $scope.utils = utils;
    
    detailService.getDetail($stateParams.id).success(function (data) {
        $scope.item = data.data;
    });

}]);
