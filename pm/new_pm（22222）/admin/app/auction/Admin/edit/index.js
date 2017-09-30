var auctionApp = angular.module('auction.Admin.edit', []);

auctionApp.controller('controller.auction.Admin.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "auction.Admin.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, auctionEditService, HOST) {
    $scope.auctionEditService = auctionEditService;
    $scope.catList = auctionEditService.getCatList();
    $scope.utils = utils;
    
    // 10竞价 11拍卖 12VIP 13专场 14拍卖会
    if($stateParams.type == 'jingjia'){
    	$scope.auction_mode = 10;
    }else if($stateParams.type == 'paimai'){
    	$scope.auction_mode = 11;
    }else if($stateParams.type == 'vip'){
    	$scope.auction_mode = 12;
    }else if($stateParams.type == 'zhuanchang'){
    	$scope.auction_mode = 13;
    }else if($stateParams.type == 'paimaihui'){
    	$scope.auction_mode = 14;
    }

    auctionEditService.getDetail($stateParams.id).success(function (data) {
    	$scope.item = {};
    	$scope.item.id = data.data.id;
        $scope.item.auction_name = data.data.auction_name;
        $scope.item.auction_code = data.data.auction_code;
        $scope.item.auction_type = data.data.auction_type;
        $scope.item.auction_succtype = data.data.auction_succtype;
        $scope.item.auction_succ_price = data.data.auction_succ_price;
        $scope.item.auction_onset_price = data.data.auction_onset_price;
        $scope.item.auction_reserve_price = data.data.auction_reserve_price;
        $scope.item.auction_seller_price = data.data.auction_seller_price;
        $scope.item.auction_buier_price = data.data.auction_buier_price;
        $scope.item.auction_broker_price = data.data.auction_broker_price;
        $scope.item.auction_stepsize_price = data.data.auction_stepsize_price;
        $scope.item.auction_apply_stuff = data.data.auction_apply_stuff;
        $scope.item.auction_starttime = data.data.auction_starttime_tag;
        $scope.item.auction_endtime = data.data.auction_endtime_tag;
        
        $scope.item.goods_id = data.data.goods_info.id;
        $scope.item.goods_name = data.data.goods_info.goods_name;
        $scope.item.cat_id = data.data.goods_info.cat_id;
        $scope.item.brand_id = data.data.goods_info.brand_id;
        $scope.item.goods_price = data.data.goods_info.goods_price;
        $scope.item.goods_keywords = data.data.goods_info.goods_keywords;
        $scope.item.goods_unit = data.data.goods_info.goods_unit;
        $scope.item.goods_thumb = data.data.goods_info.goods_thumb;
        $scope.item.goods_pictures = data.data.goods_info.goods_pictures;
        $scope.item.gallery_pic_url = data.data.goods_info.gallery_pic_url;
        $scope.item.goods_content = data.data.goods_info.goods_content;
        $scope.getMapBrand($scope.item.cat_id);
    });
    auctionEditService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });

    $scope.getMapBrand = function(cat_id){
    	auctionEditService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }

    $scope.editSubmit = function (item, auction_mode){
    	item.auction_starttime=$("input[name=auction_starttime]").val();
        item.auction_endtime=$("input[name=auction_endtime]").val();
    	$.MsgBox.Confirm("操作提示", "确定修改？修改后将会重新发起审核！", function(){
            $http({
                method  : 'POST',
                url     : HOST + '/auction/Admin/edit',
                data	: $scope.item,
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
            	if(data.status == 200){
            		$.MsgBox.Alert("操作提示", data.msg, function(){
                        if(auction_mode == 10){
                        	$state.go("auction-Admin-jingjia");
                        }else if(auction_mode == 11){
                        	$state.go("auction-Admin-paimai");
                        }else if(auction_mode == 12){
                        	$state.go("auction-Admin-vip");
                        }else if(auction_mode == 13){
                        	$state.go("auction-Admin-zhuanchang");
                        }else if(auction_mode == 14){
                        	$state.go("auction-Admin-paimaihui");
                        }
            		});
            	}else{
            		$.MsgBox.Alert("操作提示", data.error, function(){});
            	}
            });
    	});
    };
}]);
