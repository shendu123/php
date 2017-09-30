angular.module('news.Category.index', [

]).controller('controller.news.Category.index', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "news.Category.index", "API_WD_DOMAIN",function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,categoryService,HOST) {
    $scope.categoryService = categoryService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    categoryService.getCatList().success(function (catList) {
        $rootScope.catList = catList.data;
    });
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/news/Category/delete',
                params: {'id': id}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }
    
    //排序
    $scope.changeSort = function (id,event) {
        var sort=$(event.target).val();
        categoryService.changeSort(id,sort).success(function(res,status){
            if(status==200){
               $state.reload(); 
            }else{
                utils.message(res.error);
            }
        })       
    };
    //是否显示
    $scope.show = function (id,event) {
        var checked=$(event.target).prop('checked');
        var is_show = checked == true ? 1 : 0;
        categoryService.show(id,is_show).success(function(res,status){
            if(status==200){
               //$state.reload(); 
            }else{
                utils.message(res.error);
            }
        });            
    };
}]);
