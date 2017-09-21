angular.module('pay.Order.bidding', [

]).controller('controller.pay.Order.bidding', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "API_WD_DOMAIN","pay.Order.bidding", function($http, $scope, $rootScope, $stateParams, utils, $state, HOST,biddingService) {
    $scope.biddingService = biddingService;
    $scope.utils = utils;
    biddingService.getExpressCompany().success(function (expressList) {
        $rootScope.expressList = expressList;
    });
    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
     $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/pay/Order/delBidding',
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
