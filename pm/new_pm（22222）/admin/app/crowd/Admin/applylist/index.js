angular.module('crowd.Admin.applylist', [

]).controller('controller.crowd.Admin.applylist', ["$http", "$scope","$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "crowd.Admin.applylist", function($http, $scope, $rootScope, $stateParams, utils, $modal, Host, adminService) {
    $scope.adminService = adminService;
    $scope.utils = utils;
}]);
