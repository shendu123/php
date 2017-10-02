angular.module('pay.Order.stat', [

]).controller('controller.pay.Order.stat', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "pay.Order.stat", function($http, $scope, $rootScope, $stateParams, utils, $state, statService) {
    $scope.statService = statService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    Host='http://'+location.host+'/api.wode-mall.com';
     $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: Host+ '/pay/Order/delCrowd',
                params: {'id': id}
            },function(data){
                if(data){
                    alert(data.msg);
                }
            });
            $state.reload();
        });        
    };
}]);
