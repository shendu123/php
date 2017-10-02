angular.module('operator.Operator.addSecondOperator', [

]).controller('controller.operator.Operator.addSecondOperator', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "operator.Operator.addSecondOperator", function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,addSecOperatorService) {
    $scope.addSecOperatorService = addSecOperatorService;
    $scope.utils = utils;
    addSecOperatorService.percent().success(function(res,status){
        $rootScope.percent=res;
    });

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    $scope.addSecondOperator=function(){
        var code=$("#code").val();
        var Pwd=$("#Pwd").val();
        var confirmPwd=$("#confirmPwd").val();
        var buyin=$("#buyin").val();
        var sellout=$("#sellout").val();
        if(!Pwd){
            utils.message('密码不能为空');
            return;
        }
        if(Pwd!=confirmPwd){
            utils.message('确认密码与密码不一致');
            return;
        }
        var info={"code":code,"pwd":Pwd,"buyin":buyin,"sellout":sellout};
        addSecOperatorService.add(info).success(function(res,status){
            if(status!=200){
                utils.message(res.msg);
            }else{
                $state.reload();
            }
        });
    };
}]);
