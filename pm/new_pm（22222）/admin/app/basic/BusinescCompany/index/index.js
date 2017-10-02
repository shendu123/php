angular.module('basic.Company.index', [

]).controller('controller.basic.Company.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Company.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, companyService) {
    $scope.companyService = companyService;
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
    
    $scope.openWindow = function (param,tpl) {
    	if(tpl == "tpl-changepwd.html"){
    		companyService.getUserDetail(param).success(function(data){
                $modal.open({
                    templateUrl: tpl,
                    size: 'lg',
                    controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                    	$scope.item = data.data;
                        
                        $scope.cancel = function() {
                            $modalInstance.dismiss('cancel');
                        };
                    	
                        //修改密码
                        $scope.submitChangePwd = function() {
                        	
                        	var pwd_1st = $scope.item.password_first;
                        	var pwd_2nd = $scope.item.password_second;

                        	if(pwd_1st != pwd_2nd || typeof(pwd_1st) == 'undefined'){
                        		$.MsgBox.Alert("操作提示", '密码输入有误~', function(){});
                        		return;
                        	}
                        	
                        	var formData = {'uid':$scope.item.uid,'password_first':pwd_1st, 'password_second':pwd_2nd};
                        	
                            $http({
                                method  : 'POST',
                                url     : HOST + '/basic/Company/changepwd',
                                data	: formData,
                                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                            }).success(function(data) {
                            	$modalInstance.dismiss('cancel');
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                	$state.go("basic-Company-index");
                                });
                            });  
                        };
                            
                    }]
                });
    		});
    	}else if(tpl == 'tpl-check.html'){
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
                            url: HOST + '/basic/Company/check',
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
