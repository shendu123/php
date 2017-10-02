angular.module('basic.Member.garden', [

]).controller('controller.basic.Member.garden', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Member.garden", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, memberService) {
    $scope.utils = utils;
    $scope.uid = $stateParams.uid;
    
    $scope.type = $stateParams.type || 'garden';
    switch($scope.type){
		case 'garden':
			$scope.tagSwitch_garden = 'on';
			$scope.tagSwitch_all = '';
			$scope.tagSwitch_crowd = '';
			$scope.tagSwitch_auction = '';
			$scope.tagSwitch_wallet = '';
			$scope.tagSwitch_delivery = '';
			break;
    	case 'all':
			$scope.tagSwitch_garden = '';
    		$scope.tagSwitch_all = 'on';
    		$scope.tagSwitch_crowd = '';
    		$scope.tagSwitch_auction = '';
    		$scope.tagSwitch_wallet = '';
    		$scope.tagSwitch_delivery = '';
    		break;
    	case 'auction':
			$scope.tagSwitch_garden = '';
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_crowd = '';
    		$scope.tagSwitch_auction = 'on';
    		$scope.tagSwitch_wallet = '';
    		$scope.tagSwitch_delivery = '';
    		break;
    	case 'crowd':
			$scope.tagSwitch_garden = '';
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_crowd = 'on';
    		$scope.tagSwitch_auction = '';
    		$scope.tagSwitch_wallet = '';
    		$scope.tagSwitch_delivery = '';
    		break;
    	case 'delivery':
			$scope.tagSwitch_garden = '';
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_crowd = '';
    		$scope.tagSwitch_auction = '';
    		$scope.tagSwitch_wallet = '';
    		$scope.tagSwitch_delivery = 'on';
    		break;
    	case 'wallet':
			$scope.tagSwitch_garden = '';
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_crowd = '';
    		$scope.tagSwitch_auction = '';
    		$scope.tagSwitch_wallet = 'on';
    		$scope.tagSwitch_delivery = '';
    		break;
    }
    
    $scope.openWindow = function (tpl,item) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
            	$scope.item = item;
            	
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                if(tpl == 'tpl-adjustMoney.html'){
                    $scope.updateMemberSubmuit = function(formData) {
                    	var pwd_1st = $scope.item.password_first;
                    	var pwd_2nd = $scope.item.password_second;

                    	if(pwd_1st != pwd_2nd || typeof(pwd_1st) == 'undefined'){
                    		$.MsgBox.Alert("操作提示", '密码输入有误~', function(){});
                    		return;
                    	}
                		url = HOST + '/basic/Member/add';

                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: $scope.item,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
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
                }
         
            }]
        });
    }
    
}]);
