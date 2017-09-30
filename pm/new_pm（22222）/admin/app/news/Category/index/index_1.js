angular.module('news.Category.index', [

]).controller('controller.news.Category.index', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "news.Category.index", function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,categoryService) {
    $scope.categoryService = categoryService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    })
    $scope.Host='http://'+location.host+'/api.wode-mall.com';        
    $scope.addCat=function(){
        var str= $compile("<tr><td></td><td></td><td><input type='text'></td><td><a href='javascript:;' ng-click='save($event)'>保存</a>&nbsp;&nbsp;<a href='javascript:;' class='cancel' ng-click='cancel($event)'>取消</a></td></tr>")($scope);
        $(".addCat").parents("tr").before(str);
    }
    $scope.save=function(event,id){
        var msg='添加',method='add';
        var name=$(event.target).parent('td').siblings('td').find("input[type=text]").val();
        if(id){
            method='edit';
            msg='编辑';
        }
        if(!name){
            $scope.utils.message('栏目名不能为空');
            return;
        }
        return $http({
            method: 'POST',
            url: $scope.Host + '/news/Category/'+method,
            params: {'name':name,'id':id}
        }).success(function(res,status){
            if(status==200){
                $scope.utils.message(msg+'成功');
                $state.reload();
            }else{
                utils.message(res.error);
            }
        });        
    }
    $scope.editCat=function(event,item){
        var save= $compile("<a href='javascript:;' ng-click='save($event,"+item.id+")'>保存</a>")($scope);
        var input="<input type='text' value='"+item.name+"'>";
        $(event.target).parent('td').siblings('td').eq(2).html(input);
        $(event.target).parent('td').html(save);
    }
    $scope.cancel=function(event){
        $(event.target).parents('tr').remove();
    }
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: $scope.Host+ '/news/Category/delete',
                params: {'id': id}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }
}]);
