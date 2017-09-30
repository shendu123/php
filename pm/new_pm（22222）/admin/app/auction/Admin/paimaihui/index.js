angular.module('auction.Admin.paimaihui', [

]).controller('controller.auction.Admin.paimaihui', ["$http", "$scope","$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "auction.Admin.paimaihui", function($http, $scope, $rootScope, $stateParams, utils, $modal, Host, adminService) {
    $scope.adminService = adminService;
    $scope.utils = utils;
       
    $scope.check = $stateParams.check || 'egt|0';
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
    
    $scope.openWindow = function (id,tpl) {
    	if(tpl == 'tpl-check.html'){
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                	adminService.getDetail(id).success(function (data) {
                        $scope.item = data.data;
                    });
                	
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
                        
                        adminService.checkSub(id,value,checkmsg).success(function(res, status) {
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
    	}else if(tpl == "tpl-recommend.html"){
    		
    		adminService.getDetail(id).success(function (data) {
    			// 该竞价是否审核通过
    			var auctionDetail = data.data;
    			if(auctionDetail.auction_check_status != 1){
    				$.MsgBox.Alert("操作提示", '该竞价暂未审核通过,不能进行推荐');
    				return;
    			}

                $modal.open({
                    templateUrl: tpl,
                    size: 'lg',
                    controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", "API_WD_DOMAIN", function($scope, $rootScope, $modalInstance, $state, utils, HOST) {
                    	$scope.id = id;
                    	
                    	adminService.getRecpositionList().success(function (data) {
                            $scope.posList = data.data;
                        });
                    	
                        $scope.cancel = function() {
                            $modalInstance.dismiss('cancel');
                        };
                        
                        //竞价申请推荐
                        $scope.submitEditRecommend = function(item) {
                                item.apply_starttime=$("input[name=apply_starttime]").val();
                                item.apply_endtime=$("input[name=apply_endtime]").val();
                        	var ids = fdCheckGet("apply_pos_ids[]");
                        	
                        	if(ids == ''){
                        		$.MsgBox.Alert("操作提示", '请选择推荐区域');
                        		return;
                        	}
                        	
                        	item.apply_pos_ids = ids;
                        	item.apply_stuff_id = id; //拍卖业务id
                        	item.apply_stuff_type = 14; // 拍卖会

                            $http({
                                method  : 'POST',
                                url     : HOST + '/goods/Recapply/add',
                                data	: item,
                                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                            }).success(function(data) {
                            	if(data.status == 200){
                            		$.MsgBox.Alert("操作提示", '推荐申请成功', function(){
                            			$modalInstance.dismiss('cancel');
                            			$state.go("auction-Admin-paimaihui");
                            		});
                            	}else{
                            		$.MsgBox.Alert("操作提示", data.msg, function(){
                            			
                            		});
                            	}
                            });
                        };
                            
                    }]
                });
                
                $scope.crowdDetail = data.data;
            });
    	} 
    };
}]);
