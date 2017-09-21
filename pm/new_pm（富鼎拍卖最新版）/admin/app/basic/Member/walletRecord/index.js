angular.module('basic.Member.walletRecord', [

]).controller('controller.basic.Member.walletRecord', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Member.walletRecord", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, memberService) {
    $scope.memberService = memberService;
    $scope.utils = utils;
    $scope.openWindow = function (index,tpl) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {    
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                $scope.adjustMoneySubmit = function(item) {
                    item.uid=$stateParams.uid;
                    console.log(item)
                    memberService.adjustMoney(item).success(function(res, status) {
                        switch(status) {
                                case 200:
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                    break;
                                default:
                                    utils.message(res.error);
                        }
                    }).error(function () {
                            utils.message('服务器无响应！');
                    });  
                };                                    
            }]
        })
        
    };
       
}]);
