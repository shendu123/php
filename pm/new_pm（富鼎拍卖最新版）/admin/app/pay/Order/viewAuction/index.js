angular.module('pay.Order.view', [

]).controller('controller.pay.Order.view', ["$state", "$scope", "$rootScope", "$stateParams", "utils", "pay.Order.view", function($state, $scope, $rootScope, $stateParams, utils, detailService) {
    $scope.detailService = detailService;
    $scope.utils = utils;
    detailService.getDetail($stateParams).success(function (info) {
        $scope.item = info;
        console.log($scope.item);
    });
}]);
