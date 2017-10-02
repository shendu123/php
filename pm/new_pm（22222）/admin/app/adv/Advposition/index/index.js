angular.module('adv.Advposition.index', [

]).controller('controller.adv.Advposition.index', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "adv.Advposition.index", "API_WD_DOMAIN",function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,AdvpositionService,HOST) {
    $scope.AdvpositionService = AdvpositionService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/adv/Adv_position/delete',
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
