angular.module('goods.Attribute.index', [

]).controller('controller.goods.Attribute.index', ["$http","$scope","$rootScope", "$stateParams", "utils","$state", "goods.Attribute.index","API_WD_DOMAIN", function($http,$scope, $rootScope, $stateParams, utils, $state,attributeService,HOST) {
    $scope.attributeService = attributeService;
    $scope.utils = utils;
    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    attributeService.getCatList().success(function (catList) {
        $rootScope.catList = catList;
    });
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/goods/Attribute/delete',
                params: {'id': id}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }
    $scope.changeStatus = function (status) {
        var ids = fdCheckGet("ids[]");
        var str=status==1?'禁用':'启用';
        $.MsgBox.Confirm("操作提示", "确定要"+str+"？", function(){
            attributeService.changeStatus(status,ids).success(function(res,status){
                if(status!=200){
                    utils.message(res.error);
                }
                $state.reload();
            })            
        })        
    };    
}]);
