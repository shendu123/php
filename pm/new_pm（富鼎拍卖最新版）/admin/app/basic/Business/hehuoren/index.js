angular.module('basic.Business.hehuoren', [

]).controller('controller.basic.Business.hehuoren', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Business.hehuoren", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, businessService) {
    $scope.businessService = businessService;
    $scope.utils = utils;
    businessService.getParentBusiness().success(function (data) {
        $rootScope.bList = data;
    });
    businessService.percent().success(function(res,status){
        $rootScope.percent=res;
    });
    $scope.Ym=getYm();
    $scope.openWindow = function (item,tpl) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) { 	
            	$scope.service_code_pre = '100';
            	$scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                if(item.business_id){
                    $scope.showii =false;
                    businessService.edit(item.business_id).success(function (data) {
                        $rootScope.info = data;//console.log($rootScope.info);
                    });                      
                }else{
                    $scope.showii =true;
                    $rootScope.info={};
                    $rootScope.info.service_inrate=0;
                }                
                $scope.submitAddForm = function(form){//console.log(form);return;
                    if(!item.business_id){
                        if(!form.pwd){
                            utils.message('密码不能为空');
                            return;
                        }
                        if(form.pwd!=form.confirmPwd){
                            utils.message('确认密码与密码不一致');
                            return;
                        }                        
                    }
                    form.name=$("#comName").val();
                    form.pid=$("#pid").val();
                    form.code=$("#pid").attr('code');
                    form.service_inrate=$("#service_inrate").val();
                    form.type='level_top';
                    var method=item.business_id?'edit':'add';
                    businessService.add(method,form).success(function(res,status){
                            if(status!=200){
                                utils.message(res.error);
                            }else{
                                var msg=res.msg;
                                msg+=(method=='add')?',用户名为'+res.code:'';
                                utils.message(msg);
                                $modalInstance.dismiss('cancel');
                                $state.reload();
                            }
                    });
                };
                $scope.submitManage = function(form){//console.log(form);return;
                    var business_status=1;
                    if($('#status').prop('checked')){
                         business_status=2;
                    }
                    if(form.pwd!=form.confirmPwd){
                        utils.message('确认密码与密码不一致');
                        return;
                    }                        
                    form.business_id=item.business_id;
                    form.status=business_status;                   
                    businessService.add('manage',form).success(function(res,status){
                            if(status!=200){
                                utils.message(res.error);
                            }else{
                                $modalInstance.dismiss('cancel');
                                $state.reload();
                            }
                    });
                }
            }]
        })
        
    };
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/basic/Business/delete',
                params: {'business_id': id}
            });
            $state.reload();
        });        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }
    
}]);
