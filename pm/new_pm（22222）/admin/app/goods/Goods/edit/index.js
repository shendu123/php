var goodsApp = angular.module('goods.Goods.edit', []);

goodsApp.controller('controller.goods.Goods.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "goods.Goods.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, goodsEditService, HOST) {
    $scope.goodsEditService = goodsEditService;
    $scope.catList = goodsEditService.getCatList();
    $scope.utils = utils;

    goodsEditService.getDetail($stateParams.id).success(function (data) {
        $scope.item = data.data;
    });
    goodsEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });

    $scope.editSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Goods/edit',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
            	$state.go("goods-Goods-index");
            });
        });
    };
}]);
