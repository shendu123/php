angular.module('pay.Pay.index', [

]).controller('controller.pay.Pay.index', [ "$http" , "$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "API_WD_DOMAIN","pay.Pay.index", function( $http, $scope, $rootScope, $stateParams, utils, $state,HOST, payService) {
    $scope.payService = payService;
    $scope.utils = utils;
    $scope.searchCondition={}
    
   $scope.payService.get({currentPage:1,pageSize:10}).success(function (info) {
        console.log(info);
//      $scope.list=info;
    })
    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
 
     $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/pay/Pay/delOrder',
                params: {'id': id}
            });
            $state.reload();
        });        
    };
    
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);
    }
}]);
