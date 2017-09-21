var goodsApp = angular.module('adv.Adv.edit', []);

goodsApp.controller('controller.adv.Adv.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "adv.Adv.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, articleAddService, HOST) {
    $scope.articleAddService = articleAddService;
    $scope.catList = articleAddService.getCatList();
    $scope.utils = utils;

    articleAddService.getCatList().success(function (catList) {
        $scope.catList = catList.data;
    });
    articleAddService.edit($stateParams.id).success(function (data) {
        $scope.item = data;
    });
    $scope.editSubmit = function (item){
        item.start_time=$("input[name=start_time]").val();
        item.end_time=$("input[name=end_time]").val();
        $http({
            method  : 'POST',
            url     : HOST + '/adv/Adv/edit',
            data	: item,  // pass in data as strings
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status==200){
                $.MsgBox.Confirm("操作提示", "修改成功,是否继续？", function(){
                    $state.reload();
                }, function(){
                    $state.go("adv-Adv-index");
                });
            }else{
                utils.message(res.error);
            }
            
       });
    };
}]);
