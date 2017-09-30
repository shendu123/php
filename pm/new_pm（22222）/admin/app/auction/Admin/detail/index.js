angular.module('auction.Admin.detail', [

]).controller('controller.auction.Admin.detail', ["$state", "$scope", "$rootScope", "$stateParams", "utils", "auction.Admin.detail", function($state, $scope, $rootScope, $stateParams, utils, detailService) {
    $scope.detailService = detailService;
    $scope.utils = utils;
    
    detailService.getDetail($stateParams.id).success(function (data) {
        $scope.item = data.data;
        console.log($scope.item);
    });
}]);
