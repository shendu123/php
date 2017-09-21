angular.module('adv.Adv.index', [

]).controller('controller.adv.Adv.index', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "adv.Adv.index","API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, AdvService,HOST) {
    $scope.AdvService = AdvService;    
    $scope.utils = utils; 
    //$rootScope.profile=AdvService.getProfile();console.log($scope.profile);
    AdvService.getCatList().success(function (catList) {
        $rootScope.catList = catList.data;
    });
    
    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    
    $scope.removeb = function (id,status) {
        var msg=status==-1?'回收站':(status==1?'恢复':'彻底删除');
        $.MsgBox.Confirm("操作提示", "确定要"+msg+"？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/adv/Adv/delete',
                params: {'id': id,'status':status}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(status){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids,status);       
    }
    
}]);
