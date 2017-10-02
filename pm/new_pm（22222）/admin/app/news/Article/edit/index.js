var goodsApp = angular.module('news.Article.edit', []);

goodsApp.controller('controller.news.Article.edit', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "news.Article.edit", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, articleAddService, HOST) {
    $scope.articleAddService = articleAddService;
    $scope.catList = articleAddService.getCatList();
    $scope.utils = utils;

    articleAddService.getCatList().success(function (catList) {
        $scope.catList = catList;
    });
    articleAddService.edit($stateParams.id).success(function (data) {
        $scope.info = data;
    });
    $scope.item = {};
    $scope.editSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/news/Article/edit',
            data	: item,  // pass in data as strings
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status==200){
                $.MsgBox.Confirm("操作提示", "修改成功,是否继续？", function(){
                    $state.reload();
                }, function(){
                    $state.go("news-Article-index");
                });
            }else{
                utils.message(res.error);
            }
            
       });
    };
}]);
