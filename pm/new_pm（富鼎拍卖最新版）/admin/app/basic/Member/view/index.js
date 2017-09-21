angular.module('pay.Order.view', [

]).controller('controller.pay.Order.view', ["$state", "$scope", "$rootScope", "$stateParams", "utils",'$modal', "$interval","pay.Order.view", function($state, $scope, $rootScope, $stateParams, utils,$modal,$interval, detailService,HOST) {
    $scope.detailService = detailService;
    $scope.utils = utils;

    console.log($stateParams)
    if($stateParams.type=="Auction"){
    	detailService.getDetailAuction($stateParams).success(function (info) {
	        $scope.item = info;
	        console.log($stateParams)
	        console.log($scope.item);
          var status=$scope.item.order_status;
           if(status == 20){
                $scope.fourFinishOn =true;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==10){
               $scope.fourFinishOn =false;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if (status ==2){
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==1) {
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=false;
                $scope.oneOrderOn=true;
            }
              
             //定时器
             var time = $interval(function () {
                var upTime=Math.round(new Date().getTime()/1000)-$scope.item.order_uptime;
                upTime--;
                $scope.upTimeText =parseInt(upTime/60 / 60 / 24 , 10)+"天"+parseInt(upTime/ 60 / 60 % 24 , 10)+"时"+parseInt(upTime/ 60 % 60, 10)+ "分"+parseInt(upTime%60,10)+"秒" ;
                if (upTime == 0)
                {
                    $interval.cancel(time);
                }

            },1000);
	    });


    }
    if($stateParams.type=="Crowd"){
    	detailService.getDetailCrowd($stateParams).success(function (info) {
	        $scope.item = info;
	        console.log($stateParams)
	        console.log($scope.item);
            var status=$scope.item.order_status;
           if(status == 20){
                $scope.fourFinishOn =true;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==10){
               $scope.fourFinishOn =false;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if (status ==2){
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==1) {
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=false;
                $scope.oneOrderOn=true;
            }
	    });
    }
    if($stateParams.type=="Freetrading"){
    	detailService.getDetailFreetrading($stateParams).success(function (info) {
	        $scope.item = info;
	        console.log($stateParams)
	        console.log($scope.item);
            var status=$scope.item.order_status;
           if(status == 20){
                $scope.fourFinishOn =true;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==10){
               $scope.fourFinishOn =false;
                $scope.threeSendOn=true;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if (status ==2){
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=true;
                $scope.oneOrderOn=true;
            }
           else if(status ==1) {
                $scope.fourFinishOn =false;
                $scope.threeSendOn=false;
                $scope.twoPayOn=false;
                $scope.oneOrderOn=true;
            }
	    });
    }


   


    $scope.openWindow = function (tpl,item) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils","$http","API_WD_DOMAIN", function($scope, $rootScope, $modalInstance, $state, utils,$http,HOST) {
                $scope.item = item;
                
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };

                
                
                if(tpl == 'tpl-logist.html'){
                    detailService.getLogistics().success(function (info) {
                       $scope.Logistics = info;
                    });
                  

                    $scope.updateMemberSubmuit = function(formData) { 
                          $scope.wuliu={'order_id':$stateParams.order_id,'type':$stateParams.type,'order_express_info':$scope.myLogist.id,'express_id':$scope.myLogist_id};
                          console.log($scope.wuliu)
                        url = HOST + '/finance/order/orderDelivery';
                        console.log(url)
                        $http({
                            method  : 'POST',
                            url     : url,
                            data    : $scope.wuliu,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(res,status) {
                            if(status == '200'){
                                $.MsgBox.Alert("操作提示", res.msg, function(){
                                    $modalInstance.dismiss('cancel');
                                    $state.reload();
                                });
                            }else{
                                $.MsgBox.Alert("操作提示", res.error, function(){
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
   

    
}]).filter('statusName',['$filter',function($filter){
        var statusToName=[
        {'name':'待付款','status':'1'},
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
                    if(status==0){
                        if(a!=0&&b==0){
                            return statusToName[i].name;
                        }
                        else{
                             return "未支付";
                        }

                    }else{
                        return  statusToName[i].name;
                    }
                    
                }
            }
           
        }
    }]).filter('toMoney',['$filter',function($filter){
        
        return function(fen){
           
           fen=fen*0.01;
           return fen;
        }
    }]);

