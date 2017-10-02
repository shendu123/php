var crowdApp = angular.module('crowd.Admin.add', []);

crowdApp.controller('controller.crowd.Admin.add', ["$http", "$scope", "$rootScope", "$state", "$stateParams", "utils", "crowd.Admin.add", "API_WD_DOMAIN", 
    function($http, $scope, $rootScope, $state, $stateParams, utils, crowdAddService, HOST) {
    $scope.crowdAddService = crowdAddService;
    $scope.utils = utils;

    crowdAddService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    
    $scope.item = [];
    
    $scope.getMapBrand = function(cat_id){
    	crowdAddService.getBrandList(cat_id).success(function (brandList) {
            $scope.brandList = brandList.data;
        });
    }
    
    $scope.addSubmit = function (item){
        item.crowd_starttime=$("input[name=crowd_starttime]").val();
        item.crowd_endtime=$("input[name=crowd_endtime]").val();
        $http({
            method  : 'POST',
            url     : HOST + '/crowd/Admin/add',
            data	: $scope.item,
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
        	if(data.status == 200){
        		$.MsgBox.Confirm("操作提示", data.msg + ' 是否继续添加', function(){
        			$state.reload();
        		}, function(){
        			$state.go("crowd-Admin-index");
        		});
        	}else{
        		$.MsgBox.Alert("操作提示", data.error, function(){
        			
        		});
        	}
        });
    };
}]);
