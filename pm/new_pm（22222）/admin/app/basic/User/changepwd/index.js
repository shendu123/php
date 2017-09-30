angular.module('basic.User.changepwd', [

]).controller('controller.basic.User.changepwd', ["$http","$scope","$rootScope", "$stateParams", "utils","$state",'$modal', "API_WD_DOMAIN","basic.User.changepwd", function( $http,$scope, $rootScope, $stateParams, utils,$state, $modal,HOST,userService) {
    $scope.userService = userService;
    $scope.utils = utils; 
    
    $scope.addSubmit = function(item){
    	if(item.newPwd != item.confirmPwd){
    		$.MsgBox.Alert("操作提示", '两次输入的密码不一致');
    	}else{
            $http({
                method  : 'POST',
                url     : HOST + '/basic/User/changepwd',
                data	: item,
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
            	if(data.status != 200){
            		$.MsgBox.Alert("操作提示", data.msg, function(){
            			$state.reload();
            		});
            	}
           });
    	}
    }
}]);
