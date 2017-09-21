angular.module('pay.Order.crowd', [

]).controller('controller.pay.Order.crowd', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state", "API_WD_DOMAIN","pay.Order.crowd", function($http, $scope, $rootScope, $stateParams, utils, $state, HOST,crowdService) {
    $scope.crowdService = crowdService;
    $scope.utils = utils;
    
    $scope.order_status = $stateParams.order_status || 'egt|0';
    switch($scope.order_status){
        case 'egt|0'://全部
            $scope.tagSwitch_all = 'on';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = '';
            break;
        case 'eq|0'://待付款
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = 'on';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = '';
            break;
        case 'eq|2'://待发货
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = 'on';
            $scope.tagSwitch_sucess = '';
            break;   
        case 'eq|20'://交易成功
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = 'on';
            break;
    }

}]).filter('statusName',['$filter',function($filter){
        var statusToName=[
        {'name':'待付款','status':'0'},
        {'name':'付款中','status':'1'},
        {'name':'已付款/处理中/待发货','status':'2'},
        {'name':'付款失败','status':'3'},
        {'name':'已发货','status':'10'},
        {'name':'已完成','status':'20'},
        {'name':'申请退货','status':'30'},
        {'name':'驳回退货','status':'35'},
        {'name':'退货处理中','status':'40'},
        {'name':'已退货','status':'45'},
        {'name':'作废','status':'99'}];
        return function(status){
            for(var i=0;i<statusToName.length;i++){
                if(status==statusToName[i].status){
                    return  statusToName[i].name;
                }
            }
           
        }
    }]).filter('toMoney',['$filter',function($filter){
        
        return function(fen){
           
           fen=fen*0.01;
           return fen;
        }
    }]);
