angular.module('goods.Goods.index', [

]).controller('controller.goods.Goods.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", "API_WD_DOMAIN", "goods.Goods.index", function($http, $scope, $state, $rootScope, $stateParams, utils, HOST, goodsService) { 
	$scope.goodsService = goodsService;
    $scope.utils = utils;

    $scope.deleteAll = function (){
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
        	// 确定
        	var ids = fdCheckGet("ids[]");
            $http({
                method  : 'POST',
                url     : HOST + '/goods/Goods/delete',
                data	: { ids: ids },
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
                $.MsgBox.Alert("操作提示", data.msg, function(){
                	$state.reload();
                });
            });
        });
    };
}]);
