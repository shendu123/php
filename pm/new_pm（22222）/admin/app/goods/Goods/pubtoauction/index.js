var goodsApp = angular.module('goods.Goods.pubtoauction', []);

goodsApp.controller('controller.goods.Goods.pubtoauction', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "goods.Goods.pubtoauction", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, goodsEditService, HOST) {
    $scope.goodsEditService = goodsEditService;
    $scope.utils = utils;   

    $scope.publish = function (item){
        item.goods_id=$stateParams.id;
        item.auction_starttime=$("input[name=auction_starttime]").val();
        item.auction_endtime=$("input[name=auction_endtime]").val();//console.log(item);
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Goods/pubToAuction',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status == 200){
                $.MsgBox.Alert("操作提示", res.msg, function(){
                    $state.go("goods-Goods-index");
                });
            }else{
                $.MsgBox.Alert("操作提示", res.error, function(){});               
            }
            
        });
    };
}]);
