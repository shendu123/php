angular.module('crowd.Admin.detail', [

]).controller('controller.crowd.Admin.detail', ["$state", "$scope", "$rootScope", "$stateParams", "utils", "crowd.Admin.detail", function($state, $scope, $rootScope, $stateParams, utils, detailService) {
    $scope.detailService = detailService;
    $scope.utils = utils;
    
    detailService.getDetail($stateParams.id).success(function (data) {
        $scope.item = data.data;
    });

}]);
