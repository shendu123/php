var goodsApp = angular.module('news.Article.add', []);

goodsApp.controller('controller.news.Article.add', ["$http", "$scope", "$rootScope", "$stateParams", "utils", "$state", "news.Article.add", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, articleAddService, HOST) {
    $scope.articleAddService = articleAddService;
    $scope.catList = articleAddService.getCatList();
    $scope.utils = utils;

    articleAddService.getCatList().success(function (catList) {
        $scope.catList = catList.data;
    });
    $scope.item = {};
    $scope.addSubmit = function (item){
        $http({
            method  : 'POST',
            url     : HOST + '/news/Article/add',
            data	: item,  // pass in data as strings
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(res,status) {
            if(status==200){
                $.MsgBox.Confirm("操作提示", "添加成功,是否继续？", function(){
                    $state.reload();
                }, function(){
                    $state.go("news-Article-index");
                });                
            }else{
                $.MsgBox.Alert("操作提示", res.error, function(){});
            }
       });
    };
}]);
