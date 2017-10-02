angular.module('goods.Recapply.index', [

]).controller('controller.goods.Recapply.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.Recapply.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, RecapplyService) { 
	$scope.RecapplyService = RecapplyService;
    $scope.utils = utils;
    
    $scope.check = $stateParams.check || 'eq|0';
    switch($scope.check){
    	case 'egt|0':
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
    	case 'eq|0':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = 'on';
    		$scope.tagSwitch_failed = '';
    		break;
    	case 'eq|2':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = 'on';
    		break;
    }

    $scope.deleteAll = function (){
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
        	// 确定
        	var ids = fdCheckGet("ids[]");
            $http({
                method  : 'POST',
                url     : HOST + '/goods/Recapply/delete',
                data	: { ids: ids },
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
                $.MsgBox.Alert("操作提示", data.msg, function(){
                	$state.reload();
                });
            });
        });
    };
    
    $scope.openWindow = function (item,tpl) {
    	var apply_stuff_type = item.apply_stuff_type;
    	if(apply_stuff_type >= 21 && apply_stuff_type <=30){
    		tpl = "tpl-check_crowd.html";
    	}else if(apply_stuff_type >= 10 && apply_stuff_type <=20){
    		tpl = "tpl-check_auction.html";
    	}
    	
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
            	$scope.item = item;
            	
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                //审核
                $scope.check = function(value) {
                    var checkmsg=$("#reason").val();
                    if(value==2 && !checkmsg){
                        utils.message('审核失败原因不能为空');
                        return;
                    }

                    var id = item.id;
                    
                    RecapplyService.checkSub(id,value,checkmsg).success(function(res, status) {
                    	$modalInstance.dismiss('cancel');
                    	$.MsgBox.Alert('操作提示', res.msg, function(){
                    		$state.reload();
                    	});
                    }).error(function () {
                            utils.message('服务器无响应！');
                    });  
                };
                    
            }]
        });
    };
    
}]);
