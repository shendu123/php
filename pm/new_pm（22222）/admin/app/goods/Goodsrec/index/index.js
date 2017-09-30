angular.module('goods.Goodsrec.index', [

]).controller('controller.goods.Goodsrec.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.Goodsrec.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, GoodsrecService) { 
	$scope.GoodsrecService = GoodsrecService;
    $scope.utils = utils;
    
    $scope.onsale = $stateParams.onsale || 'egt|0';
    switch($scope.onsale){
    	case 'egt|0':
    		$scope.tagSwitch_all = 'on';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		break;
    	case 'eq|1':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = 'on';
    		break;
    	case 'eq|0':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = 'on';
    		$scope.tagSwitch_wait = '';
    		break;
    }

    $scope.onsaleAll = function (value){
    	var ids = fdCheckGet("ids[]");
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Goodsrec/onsaleAll',
            data	: { ids: ids ,value: value},
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
            	$state.reload();
            });
        });
    };
    
    $scope.openWindow = function (item,tpl) {        
    	if(tpl == "tpl-changeTime.html"){
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                	$scope.form = {'id':item.id, 'rec_starttime':item.rec_starttime_tag, 'rec_endtime':item.rec_endtime_tag};
                    $scope.cancel = function() {
                        $modalInstance.dismiss('cancel');
                    };
                    //推荐申请
                    $scope.submitEditRecommend = function(formData) {
                        formData.rec_starttime=$("input[name=rec_starttime]").val();
                        formData.rec_endtime=$("input[name=rec_endtime]").val();   
                        $http({
                            method  : 'POST',
                            url     : HOST + '/goods/Goodsrec/edit',
                            data	: formData,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                        	if(data.status == 200){
                        		$.MsgBox.Alert("操作提示", '推荐时间修改成功', function(){
                        			$modalInstance.dismiss('cancel');
                        			$state.go("goods-Goodsrec-index");
                        		});
                        	}else{
                        		$.MsgBox.Alert("操作提示", data.msg, function(){
                        			
                        		});
                        	}
                        });
                    };
                        
                }]
            });
    	}
    	
    };
    
}]);
