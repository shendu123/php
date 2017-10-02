angular.module('basic.Member.address', [

]).controller('controller.basic.Member.address', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Member.address", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, memberService) {
    $scope.memberService = memberService;
    $scope.utils = utils;
    memberService.getAddress($stateParams.uid).success(function(res,status){
        $rootScope.addressList=res;
    })
    
}]);
