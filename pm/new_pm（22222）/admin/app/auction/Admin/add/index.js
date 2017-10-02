var auctionApp = angular.module('auction.Admin.add', []);

auctionApp.controller('controller.auction.Admin.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "auction.Admin.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, auctionAddService, HOST) {
    $scope.auctionAddService = auctionAddService;
    $scope.utils = utils;

    auctionAddService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.getMapBrand = function(cat_id){
    	auctionAddService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }

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

//    function getNowFormatDate() {
//        var date = new Date();
//        var seperator1 = "-";
//        var seperator2 = ":";
//        var month = date.getMonth() + 1;
//        var strDate = date.getDate();
//        if (month >= 1 && month <= 9) {
//            month = "0" + month;
//        }
//        if (strDate >= 0 && strDate <= 9) {
//            strDate = "0" + strDate;
//        }
//        var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
//                + " " + date.getHours() + seperator2 + date.getMinutes()
//                + seperator2 + date.getSeconds();
//        return currentdate;
//    }
//    
//    var str = getNowFormatDate();
//
//    console.log(str);
    
    $scope.addSubmit = function (item,auction_mode){
        item.auction_starttime=$("input[name=auction_starttime]").val();
        item.auction_endtime=$("input[name=auction_endtime]").val();
    	item.auction_mode = auction_mode;
        $http({
            method  : 'POST',
            url     : HOST + '/auction/Admin/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
        	if(data.status != 200){
        		$.MsgBox.Alert("操作提示", data.error);
        	}else{
                $.MsgBox.Confirm("操作提示", data.msg + '是否继续添加', function(){
                	$state.reload();
                }, function(){
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
        	}
       });
    };
}]);
