var crowdApp = angular.module('item.Admin.add', []);

crowdApp.controller('controller.item.Admin.add', ["$http", "$scope", "$rootScope", "$state", "$stateParams", "utils", "item.Admin.add", "API_WD_DOMAIN", 
    function($http, $scope, $rootScope, $state, $stateParams, utils, itemAddService, HOST) {
    $scope.itemAddService = itemAddService;
    $scope.utils = utils;

    itemAddService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.item = [];
    
    $scope.getMapBrand = function(cat_id){
    	itemAddService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }
    
    $scope.addSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/item/Admin/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
        	if(data.status == 200){
        		$.MsgBox.Confirm("操作提示", data.msg + ' 是否继续添加', function(){
        			$state.reload();
        		}, function(){
        			$state.go("item-Admin-index");
        		});
        	}else{
        		$.MsgBox.Alert("操作提示", data.error, function(){
        			
        		});
        	}
        });
    };
}]);
