var curApp = angular.module('basic.Business.edit', []);

curApp.controller('controller.basic.Business.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "basic.Business.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, BusinessService, HOST) {
    $scope.utils = utils;

    BusinessService.getCompanyList().success(function (list) {
        $scope.companyList = list.data;
    });
    
    
    BusinessService.getDetail($stateParams.business_id).success(function (data) {
        $scope.item = data;
         
    });
    
    $scope.editSubmit = function (item){
        item.status=$("input[ng-model='item.status']").prop('checked')?1:2;
        item.business_allow_login=$("input[ng-model='item.business_allow_login']").prop('checked')?1:2;
        item.business_allow_goods_show=$("input[ng-model='item.business_allow_goods_show']").prop('checked')?1:2;
        item.business_allow_show=$("input[ng-model='item.business_allow_show']").prop('checked')?1:2;
        item.business_starttime= $("input[ng-model='item.business_starttime']").val();
        item.business_endtime= $("input[ng-model='item.business_endtime']").val();
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Business/edit',
            data	: item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status==200){
                $.MsgBox.Alert("操作提示", res.msg, function(){
                    $state.go("basic-Business-index");
                });
            }else{
                $.MsgBox.Alert("操作提示", res.error);
            }
            
        });
    };
}]);
