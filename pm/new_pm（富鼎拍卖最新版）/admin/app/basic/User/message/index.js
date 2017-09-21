angular.module('basic.User.message', []).controller('controller.basic.User.message', ["$http", "$scope", "$rootScope", "$stateParams", "utils", '$modal',"$state", "basic.User.message", "API_WD_DOMAIN", function($http, $scope, $rootScope, $stateParams, utils, $modal,$state, userMessageService, HOST) {
    $scope.userMessageService = userMessageService;
    $scope.utils = utils;
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/basic/User/message',
                params: {'id': id,'type':'delete'}
            });
            $state.reload();
        })        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }
    $scope.message = function () {
        $modal.open({
            templateUrl: "tpl-message.html",
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };    
                //消息推送
                $scope.messagePush = function(status) {
                    var theme=$("#title").val();
                    var detail=$("textarea").val();
                    var iscom=$("#iscom").val();
                    if(!theme){
                        utils.message('标题不能为空');
                        return;
                    }
                    if(!detail){
                        utils.message('内容不能为空');
                        return;
                    }
                    var message={'theme':theme,'detail':detail,'iscom':iscom};
                    userMessageService.add(message).success(function(res, status) {
                        if(status!=200){
                            utils.message(res.error);
                        }else{
                            $modalInstance.dismiss('cancel');
                            $state.reload();
                        }
                    }).error(function () {
                            utils.message('服务器无响应！');
                    });  
                };
               
                    
            }]
        })
        
    };
   
}]);
