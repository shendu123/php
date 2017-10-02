var goodsApp = angular.module('goods.Goods.add', []);

goodsApp.controller('controller.goods.Goods.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "goods.Goods.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, goodsAddService, HOST) {
    $scope.goodsAddService = goodsAddService;
    $scope.utils = utils;

    goodsAddService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.addSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Goods/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
        	if(data.status != 200){
        		$.MsgBox.Alert("操作提示", data.msg);
        	}else{
                $.MsgBox.Confirm("操作提示", data.msg + '是否继续添加', function(){
                	$state.reload();
                }, function(){
                	$state.go("goods-Goods-index");
                });
        	}
       });
    };
}]);
