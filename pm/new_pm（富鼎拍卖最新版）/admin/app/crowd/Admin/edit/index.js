var crowdApp = angular.module('corwd.Admin.edit', []);

crowdApp.controller('controller.crowd.Admin.edit', ["$http", "$scope", "$rootScope", "$state", "$stateParams", "utils", "crowd.Admin.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $state, $stateParams, utils, crowdEditService, HOST) {
    $scope.crowdEditService = crowdEditService;
    $scope.utils = utils;
    
    crowdEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });

    crowdEditService.getDetail($stateParams.id).success(function (data) {
    	$scope.item = [];
    	$scope.item.id = data.data.id;
        $scope.item.crowd_name = data.data.crowd_name;
        $scope.item.crowd_code = data.data.crowd_code;
        $scope.item.crowd_price = data.data.crowd_price;
        $scope.item.crowd_total = data.data.crowd_total;
        $scope.item.crowd_seller_price = data.data.crowd_seller_price;
        $scope.item.crowd_broker_price = data.data.crowd_broker_price;
        $scope.item.crowd_starttime = data.data.crowd_starttime_tag;
        $scope.item.crowd_endtime = data.data.crowd_endtime_tag;
        
        $scope.item.goods_id = data.data.goods_info.id;
        $scope.item.goods_name = data.data.goods_info.goods_name;
        $scope.item.cat_id = data.data.goods_info.cat_id;
        $scope.item.brand_id = data.data.goods_info.brand_id;
        $scope.item.goods_price = data.data.goods_info.goods_price;
        $scope.item.goods_thumb = data.data.goods_info.goods_thumb;
        $scope.item.goods_pictures = data.data.goods_info.goods_pictures;
        $scope.item.gallery_pic_url = data.data.goods_info.gallery_pic_url;
        $scope.item.goods_content = data.data.goods_info.goods_content;
        
        $scope.getMapBrand($scope.item.cat_id);
    });
    crowdEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.getMapBrand = function(cat_id){
    	crowdEditService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }

    $scope.editSubmit = function (item){
        item.crowd_starttime=$("input[name=crowd_starttime]").val();
        item.crowd_endtime=$("input[name=crowd_endtime]").val();
    	$.MsgBox.Confirm("操作提示", "确定修改？修改后将会重新发起审核！", function(){
            $http({
                method  : 'POST',
                url     : HOST + '/crowd/Admin/edit',
                data	: item,
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
            	if(data.status == 200){
            		$.MsgBox.Alert("操作提示", data.msg, function(){
            			$state.go("crowd-Admin-index");
            		});
            	}else{
            		$.MsgBox.Alert("操作提示", data.error, function(){});
            	}
            });
    	});
    };
    
}]);
