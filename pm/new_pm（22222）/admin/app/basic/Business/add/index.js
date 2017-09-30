var curApp = angular.module('basic.Business.add', []);

curApp.controller('controller.basic.Business.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Business.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinessService, HOST) {
    $scope.BusinessService = BusinessService;
    $scope.utils = utils;
    
    BusinessService.getCompanyList().success(function (list) {
        $scope.companyList = list.data;
    });
    
            if($stateParams.pid){
                BusinessService.getDetail($stateParams.pid).success(function (data) {
                    $scope.item = data;
                        $scope.item.name='';
                        $scope.item.business_account='';
                        $scope.item.business_broker='';

                });
            }
    
    
    $scope.addSubmit = function(){
        $scope.item.status=$("input[ng-model='item.status']").prop('checked')?1:2;
        $scope.item.business_allow_login=$("input[ng-model='item.business_allow_login']").prop('checked')?1:2;
        $scope.item.business_allow_goods_show=$("input[ng-model='item.business_allow_goods_show']").prop('checked')?1:2;
        $scope.item.business_allow_show=$("input[ng-model='item.business_allow_show']").prop('checked')?1:2;
        $scope.item.business_starttime= $("input[ng-model='item.business_starttime']").val();
        $scope.item.business_endtime= $("input[ng-model='item.business_endtime']").val();
        if($stateParams.pid){
            $scope.item.pid = $stateParams.pid;
        }
        console.log($scope.item)
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Business/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
        	if(status != 200){
        		$.MsgBox.Alert("操作提示", res.error);
        	}else{
                    $.MsgBox.Confirm("操作提示", res.msg + '是否继续添加', function(){
                            $state.reload();
                    }, function(){
                            $state.go("basic-Business-index");
                    });
        	}
       });
    };
}]);
