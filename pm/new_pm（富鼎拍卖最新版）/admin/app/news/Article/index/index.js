angular.module('news.Article.index', [

]).controller('controller.news.Article.index', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "news.Article.index","API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $state, ArticleService,HOST) {
    $scope.ArticleService = ArticleService;    
    $scope.utils = utils; 
    //$rootScope.profile=ArticleService.getProfile();console.log($scope.profile);
    ArticleService.getCatList().success(function (catList) {
        $rootScope.catList = catList.data;
    });
    
    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    
    $scope.removeb = function (id,status) {
        var msg=status==-1?'回收站':(status==1?'恢复':'彻底删除');
        $.MsgBox.Confirm("操作提示", "确定要"+msg+"？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/news/Article/delete',
                params: {'id': id,'status':status}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(status){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids,status);       
    }
    
        //是否显示
    $scope.show = function (id,event) {
        var checked=$(event.target).prop('checked');
        var is_show = checked == true ? 1 : 0;
        ArticleService.show(id,is_show).success(function(res,status){
            if(status==200){
               //$state.reload(); 
            }else{
                utils.message(res.error);
            }
        });            
    };
    
    //是否推荐
    $scope.recommend = function (id,event) {
        var checked=$(event.target).prop('checked');
        var recommend_status = checked == true ? 1 : 0;
        ArticleService.recommend(id,recommend_status).success(function(res,status){
            if(status==200){
               //$state.reload(); 
            }else{
                utils.message(res.error);
            }
        });            
    };
    
}]);
