angular.module('basic.Business.index', [

]).controller('controller.basic.Business.index', ["$window","$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Business.index", function($window,$http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, BusinessService) {
    $scope.BusinessService = BusinessService;
    $scope.utils = utils;
    $scope.sysid = $window.sessionStorage.sysid;
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
                url: HOST+ '/basic/Business/delete',
                params: {'business_id': id}
            }).success(function(res,status){
                if(status != 200){
                    utils.message(res.error);
                }else{
                    $scope.reload();
                }
            });
        })      
    };
    
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);
    }
    
    //排序
    $scope.changeSort = function (id,event) {
        var sort=$(event.target).val();
        BusinessService.changeSort(id,sort).success(function(res,status){
            if(status==200){
                $.MsgBox.tipbox("操作提示", "修改成功");
                $scope.reload();
               //$state.reload(); 
            }else{
                utils.message(res.error);
            }
        })       
    };
    
    $scope.changeStatus = function (id,field,event) {
        var checked=$(event.target).prop('checked');
        var status = checked == true ? 1 : (field == 'business_is_recommend' ? 0 : 2);
        var field_status = field+'|'+status;
        BusinessService.changeStatus(id,field_status).success(function(res,status){
            if(status==200){
                //$scope.reload();
               //$state.reload(); 
            }else{
                utils.message(res.error);
            }
        });            
    };        
    $scope.openWindow = function (item,tpl) {
        $rootScope.business_id=item.business_id;  
        if(tpl == 'tpl-pay.html'){
            //审核
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {                    
                    $scope.cancel = function() {
                        $modalInstance.dismiss('cancel');
                    };                	                    
                    $scope.paySubmit = function(item) { 
                        item.business_id=$rootScope.business_id;  
                        item.pay_time= $("input[ng-model='item.pay_time']").val();
                        //console.log(item);
                        $http({
                            method: 'POST',
                            url: HOST + '/finance/Business_pay/add',
                            data: item,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(res,status){
                        	if(status == '200'){
                                    $.MsgBox.Alert("操作提示", res.msg, function(){
                                            $modalInstance.dismiss('cancel');
                                            $state.reload();
                                    });
                        	}else{
                                    $.MsgBox.Alert("操作提示", res.error, function(){});
                        	}
                        }); 
                    };
                        
                }]
            });
        }
    }
}]);
