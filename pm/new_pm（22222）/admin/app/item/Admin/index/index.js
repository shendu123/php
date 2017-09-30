angular.module('item.Admin.index', [

]).controller('controller.item.Admin.index', ["$window","$http", "$scope","$rootScope", "$stateParams", "utils",'$state', '$modal', "API_WD_DOMAIN", "item.Admin.index", function($window,$http, $scope, $rootScope, $stateParams, utils,$state, $modal, Host, adminService) {
    $scope.adminService = adminService;
    $scope.utils = utils;
    $scope.sysid = $window.sessionStorage.sysid;   
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
    //上下架
    $scope.onsale = function (id,status) {
        var msg=status==1?'上架':'下架';
        if(!id){
            utils.message('请选择你要'+msg+'的商品');
            return false;
        }
        $.MsgBox.Confirm("操作提示", "确定要"+msg+"？", function(){
            adminService.onsale(id,status).success(function(res,status){
                if(status==200){
                   $state.reload(); 
                }else{
                    utils.message(res.error);
                }
            })
            
        });        
    };
    $scope.all_onsale=function(status){
        var ids = fdCheckGet("ids[]");
        $scope.onsale(ids,status);       
    }
    //排序
    $scope.changeSort = function (id,event) {
        var sort=$(event.target).val();
        adminService.changeSort(id,sort).success(function(res,status){
            if(status==200){
               $state.reload(); 
            }else{
                utils.message(res.error);
            }
        })       
    };
    //推荐
    $scope.recommend = function (id,check_status,event) {
        if(check_status!=1){
            utils.message('审核未通过不能推荐');
            return false;
        }
        var checked=$(event.target).prop('checked');
        var recommend_status = checked == true ? 1 : 0;
        adminService.recommend(id,recommend_status).success(function(res,status){
            if(status==200){
               $.MsgBox.tipbox("操作提示", res.msg);
                $scope.reload();
            }else{
                utils.message(res.error);
            }
        });            
    };

    $scope.recommendChange = function () {
        $scope.recommend( this.item.id , this.item.item_check , this.item.item_is_recommend );
    }
    $scope.openWindow = function (id,tpl) {
    	if(tpl == "tpl-check.html"){
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
    	}else if(tpl == "tpl-addBrandApply.html"){
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", "API_WD_DOMAIN", function($scope, $rootScope, $modalInstance, $state, utils, HOST) {
                	adminService.getGoodsCatList().success(function (data) {
                        $scope.catList = data.data;
                    });
                	
                    $scope.cancel = function() {
                        $modalInstance.dismiss('cancel');
                    };
                    
                    //品牌申请
                    $scope.submitAddBrandApply = function(item) {
                        $http({
                            method  : 'POST',
                            url     : HOST + '/goods/Brandapply/add',
                            data	: item,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                        	if(data.status == 200){
                        		$.MsgBox.Alert("操作提示", '品牌申请成功', function(){
                        			$modalInstance.dismiss('cancel');
                        			$state.go("item-Admin-index");
                        		});
                        	}else{
                        		$.MsgBox.Alert("操作提示", data.msg, function(){
                        			
                        		});
                        	}
                        });
                    };
                        
                }]
            });
    	}else if(tpl == "tpl-recommend.html"){
    		
    		adminService.getDetail(id).success(function (data) {
    			// 该自由买卖是否审核通过
    			var itemDetail = data.data;
    			if(itemDetail.item_check != 1){
    				$.MsgBox.Alert("操作提示", '该自由买卖暂未审核通过,不能进行推荐');
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
                        
                        //推荐申请
                        $scope.submitEditRecommend = function(item) {
                                item.apply_starttime=$("input[name=apply_starttime]").val();
                                item.apply_endtime=$("input[name=apply_endtime]").val();
                        	var ids = fdCheckGet("apply_pos_ids[]");
                        	
                        	if(ids == ''){
                        		$.MsgBox.Alert("操作提示", '请选择推荐区域');
                        		return;
                        	}
                        	
                        	item.apply_pos_ids = ids;
                        	item.apply_stuff_id = id; //申请业务id
                        	item.apply_stuff_type = 31; //自由买卖
                            $http({
                                method  : 'POST',
                                url     : HOST + '/goods/Recapply/add',
                                data	: item,
                                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                            }).success(function(data) {
                            	if(data.status == 200){
                            		$.MsgBox.Alert("操作提示", '推荐申请成功', function(){
                            			$modalInstance.dismiss('cancel');
                            			$state.go("item-Admin-index");
                            		});
                            	}else{
                            		$.MsgBox.Alert("操作提示", data.msg, function(){
                            			
                            		});
                            	}
                            });
                        };
                            
                    }]
                });
                
                $scope.itemDetail = data.data;
            });
    	} 
    };
}]);
