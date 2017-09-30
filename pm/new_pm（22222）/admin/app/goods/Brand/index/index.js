angular.module('goods.Brand.index', [

]).controller('controller.goods.Brand.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.Brand.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, brandService) {
    $scope.brandService = brandService;
    $scope.utils = utils;
//console.log($('.sidebar-menu li.active').attr('data-id'));
    $scope.openWindow = function (tpl, item) {
    	
        brandService.getCatList().success(function (catList) {
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                	$scope.catList = catList.data;
                	$scope.item = item;
                	
                    $scope.cancel = function() {
                    	$state.reload();
                        $modalInstance.dismiss('cancel');
                    };
                    
                    //修改编辑提交
                    $scope.submitAddBrandForm = function(item) {//console.log(item);
                    	var url = '';
                    	if( item.id ){
                    		url = HOST + '/goods/Brand/edit';
                    	}else{
                    		url = HOST + '/goods/Brand/add';
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
        });
        
    };

    $scope.deleteAll = function (){
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
        	// 确定
        	var ids = fdCheckGet("ids[]");
            $http({
                method  : 'POST',
                url     : HOST + '/goods/Brand/delete',
                data	: { ids: ids },
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
                $.MsgBox.Alert("操作提示", data.msg, function(){
                	$state.reload();
                });
            });
        });
    };
}]);
