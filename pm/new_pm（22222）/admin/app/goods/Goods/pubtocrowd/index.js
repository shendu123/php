var goodsApp = angular.module('goods.Goods.pubtocrowd', []);

goodsApp.controller('controller.goods.Goods.pubtocrowd', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "goods.Goods.pubtocrowd", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, goodsEditService, HOST) {
    $scope.goodsEditService = goodsEditService;
    $scope.utils = utils;   

    $scope.publish = function (item){
        item.goods_id=$stateParams.id;
        item.crowd_starttime=$("input[name=crowd_starttime]").val();
        item.crowd_endtime=$("input[name=crowd_endtime]").val();console.log(item);
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Goods/pubToCrowd',
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
