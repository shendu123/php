angular.module('basic.MemberRecharge.index', [

]).controller('controller.basic.MemberRecharge.index', ["$window","$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.MemberRecharge.index", function($window,$http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, companyService) {
    $scope.companyService = companyService;
    $scope.utils = utils;

    // console.log("11111111")
    // console.log($stateParams.node_id)

   //   console.log("777777") 

   // console.log($window.sessionStorage.getItem('quanxuan')) 
    
    $scope.check = $stateParams.check || 'egt|0';
    switch($scope.check){
        case 'egt|0'://全部
            $scope.tagSwitch_all = 'active';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = '';
            break;
        case 'eq|0'://待付款
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = 'active';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = '';
            break;
        case 'eq|2'://待发货
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = 'active';
            $scope.tagSwitch_sucess = '';
            break;   
        case 'eq|20'://交易成功
            $scope.tagSwitch_all = '';
            $scope.tagSwitch_pay = '';
            $scope.tagSwitch_wait = '';
            $scope.tagSwitch_sucess = 'active';
            break;
    }
}]).filter('statusName',['$filter',function($filter){
        // var statusToName=[
        // {'name':'待付款','status':'0'},
        // {'name':'付款中','status':'1'},
        // {'name':'已付款/处理中/待发货','status':'2'},
        // {'name':'付款失败','status':'3'},
        // {'name':'已发货','status':'10'},
        // {'name':'已完成','status':'20'},
        // {'name':'申请退货','status':'30'},
        // {'name':'驳回退货','status':'35'},
        // {'name':'退货处理中','status':'40'},
        // {'name':'已退货','status':'45'},
        // {'name':'作废','status':'99'}];
         var statusToName=[
        {'name':'待付款','status':'0'},
        {'name':'付款中','status':'1'},
        {'name':'已付款','status':'2'},
        {'name':'付款失败','status':'3'}];
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
    }]).filter('payName',['$filter',function($filter){
        var statusToName=[
        {'name':'余额支付','status':'0'},
        {'name':'微信支付','status':'1'},
        {'name':'支付宝','status':'2'},
        {'name':'银行卡','status':'3'},
        {'name':'汇潮','status':'4'},
        {'name':'其他','status':'99'}];
        return function(status,a,b){
            for(var i=0;i<statusToName.length;i++){
                if(status==statusToName[i].status){
                    // if(status==0){
                    //     if(a!=0&&b==0){
                    //         return statusToName[i].name;
                    //     }
                    //     else{
                    //          return "未支付";
                    //     }

                    // }else{
                        return  statusToName[i].name;
                    // }
                    
                }
            }
           
        }
    }]);
