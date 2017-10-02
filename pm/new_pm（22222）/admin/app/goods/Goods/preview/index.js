angular.module('goods.Goods.preview', [

]).controller('controller.goods.Goods.preview', ["$state", "$scope", "$rootScope", "$stateParams", "utils", "goods.Goods.preview", function($state, $scope, $rootScope, $stateParams, utils, previewService) {
    $scope.previewService = previewService;
    $scope.utils = utils;
    
    previewService.getDetail($stateParams.id).success(function (data) {
        $scope.item = data.data;
        
    });

}]);
