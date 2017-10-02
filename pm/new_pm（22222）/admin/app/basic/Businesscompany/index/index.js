angular.module('basic.Businesscompany.index', [

]).controller('controller.basic.Businesscompany.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Businesscompany.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, BusinesscompanyService) {
    $scope.BusinesscompanyService = BusinesscompanyService;
    $scope.utils = utils;
    
    $scope.check = $stateParams.check || 'egt|1';
    switch($scope.check){
    	case 'egt|1':
    		$scope.tagSwitch_all = 'on';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = '';
    		break;
    	case 'eq|1':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = 'on';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = '';
    		break;
    	case 'eq|3':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = 'on';
    		break;
    	case 'eq|2':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = 'on';
    		$scope.tagSwitch_failed = '';
    		break;
    		
    };
    
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'GET',
                url: HOST+ '/basic/Business_company/delete',
                params: {'com_id': id}
            });
            $state.reload();
        });        
    };
    
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);
    }
    
    $scope.openWindow = function (param,tpl) {
        if(tpl == 'tpl-check.html'){
            //审核
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                	$scope.item = param;
                    
                    $scope.cancel = function() {
                        $modalInstance.dismiss('cancel');
                    };
                	
                    //审核
                    $scope.check = function(value) {
                        var checkmsg=$("#check_reason").val();
                        if(value==3&&!checkmsg){
                            utils.message('原因不能为空');
                            return;
                        }

                        $http({
                            method: 'POST',
                            url: HOST + '/basic/Businesscompany/check',
                            params: {'uid':param.uid,'com_id': param.com_id,'business_id': param.business_id,'value':value,'reason':checkmsg}
                        }).success(function(data){
                        	if(data.status == '200'){
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                	$modalInstance.dismiss('cancel');
                                	$state.reload();
                                });
                        	}else{
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                	$modalInstance.dismiss('cancel');
                                	$state.reload();
                                });
                        	}
                        }); 
                    };
                        
                }]
            });
        }
    }
}]);
