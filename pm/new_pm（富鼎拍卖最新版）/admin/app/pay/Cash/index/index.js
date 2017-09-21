angular.module('pay.Cash.index', [

]).controller('controller.pay.Cash.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "pay.Cash.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, memberService) {
    $scope.memberService = memberService;
    $scope.utils = utils;

    $scope.openWindow = function (tpl,item) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                $scope.item = item;
                
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                if(tpl == 'tpl-checkPass.html'){
                    $scope.checkPassSubmuit = function(formData) { 
                        console.log($scope.item);
                        url = HOST + '/finance/withdraw/memberCheck';
                        $scope.passObj={'id':$scope.item.id,'status':$scope.item.pass,'reason':$scope.item.reason};
                        console.log( $scope.passObj);
                        $http({
                            method  : 'POST',
                            url     : url,
                            data    : $scope.passObj,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                            if(data.success == true){
                                $scope.item.status=data.status;
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                });
                            }else{
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                });
                            }
                        });
                    };
                }else if(tpl == 'tpl-checkSucc.html'){  
                    $scope.checkSuccSubmuit = function(item) {
                        url = HOST + '/finance/withdraw/memberCheck';
                        $scope.succObj={'id':$scope.item.id,'status':10};
                        $http({
                            method  : 'POST',
                            url     : url,
                            data    : $scope.succObj,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                            if(data.success == true){
                                $scope.item.status=data.status;
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                });
                            }else{
                                $.MsgBox.Alert("操作提示", data.msg, function(){
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                });
                            }
                        });
                    };
                }
         
            }]
        });
    }
    
}]).filter('statusCash',['$filter',function($filter){
        var statusToName=[
        {'name':'微信','status':'0'},
        {'name':'支付宝','status':'1'},
        {'name':'银行卡','status':'2'}];
        return function(status){
            for(var i=0;i<statusToName.length;i++){
                if(status==statusToName[i].status){
                    return  statusToName[i].name;
                }
            }
           
        }
    }]).filter('orderStatus',['$filter',function($filter){
        var statusToName=[
        {'name':'待审核','status':'0'},
        {'name':'审核通过，转账中','status':'5'},
        {'name':'提现成功','status':'10'},
        {'name':'拒绝','status':'15'}];
        return function(status,a,b){
            for(var i=0;i<statusToName.length;i++){
                if(status==statusToName[i].status){
                    
                        return  statusToName[i].name;
                    
                    
                }
            }
           
        }
    }]);
