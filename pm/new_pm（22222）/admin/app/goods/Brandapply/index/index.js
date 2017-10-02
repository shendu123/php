angular.module('goods.Brandapply.index', [

]).controller('controller.goods.Brandapply.index', ["$window","$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.Brandapply.index", function($window,$http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, brandapplyService) {
    $scope.brandapplyService = brandapplyService;
    $scope.utils = utils;
    $scope.sysid = $window.sessionStorage.sysid;   
    $scope.deleteAll = function (){
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
        	// 确定
        	var ids = fdCheckGet("ids[]");
            $http({
                method  : 'POST',
                url     : HOST + '/goods/Brandapply/delete',
                data	: { ids: ids },
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
                $.MsgBox.Alert("操作提示", data.msg, function(){
                	$state.reload();
                });
            });
        });
    };
    brandapplyService.getCatList().success(function (data){
        $rootScope.catList = data;
    })
    $scope.ableAll = function (value){
    	var ids = fdCheckGet("ids[]");
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Brandapply/ableAll',
            data	: { ids: ids ,value: value},
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
            	$state.reload();
            });
        });
    };
    
    $scope.openWindow = function (item,tpl) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
            	$rootScope.item = item;
            	
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                //审核
                $scope.check = function(value) {
                    var checkmsg=$("#reason").val();
                    if(value==2&&!checkmsg){
                        utils.message('原因不能为空');
                        return;
                    }
                    
                    brandapplyService.checkSub(item.id,value,checkmsg).success(function(res, status) {
                    	$modalInstance.dismiss('cancel');
                    	$.MsgBox.Alert('操作提示', res.msg, function(){
                    		$state.reload();
                    	});
                    }).error(function () {
                            utils.message('服务器无响应！');
                    });  
                };
                
                //修改编辑提交
                    $scope.submitAddForm = function(item) {//console.log(item);
                    	var url = '';
                    	if( item.id ){
                    		url = HOST + '/goods/Brandapply/edit';
                    	}else{
                    		url = HOST + '/goods/Brandapply/add';
                    	}
                    	
                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: $scope.item,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(res,status) {                        	
                        	if(status == 200){
                        		$.MsgBox.Alert("操作提示", res.msg, function(){
                                                $modalInstance.dismiss('cancel');
                        			$state.reload();
                        		});
                        	}else{
                        		utils.message(res.error);
                        	}
                        });  
                    };
                    
            }]
        })
        
    };
}]);
