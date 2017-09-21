angular.module('basic.Member.index', [

]).controller('controller.basic.Member.index', ["$window","$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "basic.Member.index", function($window,$http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, memberService) {
    $scope.memberService = memberService;
    $scope.utils = utils;
    // console.log("11111111");
    // console.log($stateParams.node_id);
     // $window.sessionStorage.getItem('quanxuan')

    $scope.ableAll = function (value){
    	var ids = fdCheckGet("ids[]");

    	if(typeof(ids) == 'undefined' || ids == ''){
    		$.MsgBox.Alert("操作提示", '请选择记录');
    		return;
    	}
    	
        $http({
            method  : 'POST',
            url     : HOST + '/basic/Member/ableAll',
            data	: { ids: ids ,value: value},
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
            	$state.reload();
            });
        });
    };        
    
    $scope.check = $stateParams.check || 'egt|0';
    switch($scope.check){
    	case 'egt|0':
    		$scope.tagSwitch_all = 'on';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = '';
    		break;
    	case 'eq|1':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = 'on';
    		break;
    	case 'eq|0':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = 'on';
    		$scope.tagSwitch_wait = '';
    		$scope.tagSwitch_failed = '';
    		break;
    	case 'eq|2':
    		$scope.tagSwitch_all = '';
    		$scope.tagSwitch_pass = '';
    		$scope.tagSwitch_wait = 'on';
    		$scope.tagSwitch_failed = '';
    		break;
    		
    }
    
    $scope.openWindow = function (tpl,item) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
            	$scope.item = item;
            	
                $scope.cancel = function() {
                    console.log("11111")
                    $state.reload();
                    $modalInstance.dismiss('cancel');
                };
                
                if(tpl == 'tpl-add.html'){
                    $scope.updateMemberSubmuit = function(formData) {
                    	var pwd_1st = $scope.item.password_first;
                    	var pwd_2nd = $scope.item.password_second;

                    	if(pwd_1st != pwd_2nd || typeof(pwd_1st) == 'undefined'){
                    		$.MsgBox.Alert("操作提示", '密码输入有误~', function(){});
                    		return;
                    	}
                        console.log("添加数据");
                        console.log($scope.item);
                		url = HOST + '/basic/Member/add';

                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: $scope.item,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                        	if(data.status == '200'){
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
                }else if(tpl == 'tpl-edit.html'){
                    console.log("修改的数据");
                    console.log(item);
                    $scope.updateMemberSubmuit = function(item) {
                    	var pwd_1st = $scope.item.password_first;
                    	var pwd_2nd = $scope.item.password_second;

                    	if(pwd_1st != pwd_2nd){
                    		$.MsgBox.Alert("操作提示", '密码输入有误~', function(){});
                    		return;
                    	}
                		url = HOST + '/basic/Member/edit';
                		// MDZZ
                		var postData = {'uid':item.uid, 'business_id':item.business_id, 'rule_type':item.rule_type, 'nickname':item.nickname, 'mobile':item.mobile, 'password_first':pwd_1st, 'password_second':pwd_2nd, 'sex':item.sex};
                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: postData,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(data) {
                        	if(data.status == '200'){
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
                }else if(tpl == 'tpl-check.html'){
                    //审核
                    $scope.check = function(value) {
                        var checkmsg=$("#rule_check_reason").val();
                        if(value==-1&&!checkmsg){
                            utils.message('原因不能为空');
                            return;
                        }

                        $http({
                            method: 'POST',
                            url: HOST + '/basic/Member/check',
                            params: {'id': item.uid,'business_id': item.business_id,'value':value,'reason':checkmsg}
                        }).success(function(data){
                        	if(data.status == '200'){
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
    
}]);
// .run(['$rootScope',"$window","$http","API_WD_DOMAIN",function ($rootScope,$window,$http,HOST) {
//         //当且仅当path或url变化成功后触发
//         $rootScope.$on('$locationChangeSuccess',function (event,msg) {
//             //console.log([event,msg]);
//             $http({
//                 method  : 'POST',
//                 url     : HOST + '/basic/member_node/index',
//                 data    : {url:msg},
//                 headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
//             }).success(function(data) {
//                 console.log(data);
//                 //$rootScope.q=data;
//                // console.log($rootScope.q)
//                $window.sessionStorage.setItem('quanxuan', data);
//             });
       
//         });

// }]);