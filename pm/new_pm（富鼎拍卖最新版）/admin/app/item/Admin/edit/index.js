var itemApp = angular.module('item.Admin.edit', []);

itemApp.controller('controller.item.Admin.edit', ["$http", "$scope", "$rootScope", "$state", "$stateParams", "utils", "item.Admin.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $state, $stateParams, utils, itemEditService, HOST) {
    $scope.itemEditService = itemEditService;
    $scope.utils = utils;
    
    itemEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });

    itemEditService.getDetail($stateParams.id).success(function (data) {
    	$scope.item = [];
    	$scope.item.id = data.data.id;
        $scope.item.item_name = data.data.item_name;
        $scope.item.item_code = data.data.item_code;
        $scope.item.item_price = data.data.item_price;
        $scope.item.item_total = data.data.item_total;
        $scope.item.item_seller_price = data.data.item_seller_price;
        $scope.item.item_broker_price = data.data.item_broker_price;
        $scope.item.item_starttime = data.data.item_starttime_tag;
        $scope.item.item_endtime = data.data.item_endtime_tag;
        
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
    itemEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.getMapBrand = function(cat_id){
    	itemEditService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }

    $scope.editSubmit = function (item){
    	$.MsgBox.Confirm("操作提示", "确定修改？修改后将会重新发起审核！", function(){
            $http({
                method  : 'POST',
                url     : HOST + '/item/Admin/edit',
                data	: item,
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
            	if(data.status == 200){
            		$.MsgBox.Alert("操作提示", data.msg, function(){
            			$state.go("item-Admin-index");
            		});
            	}else{
            		$.MsgBox.Alert("操作提示", data.error, function(){});
            	}
            });
    	});
    };
    
}]);
