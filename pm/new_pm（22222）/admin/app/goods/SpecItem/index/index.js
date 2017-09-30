angular.module('goods.SpecItem.index', [

]).controller('controller.goods.SpecItem.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.SpecItem.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, specService) {
    $scope.specService = specService;
    $scope.utils = utils;
    console.log($stateParams)
    var listupdate=[];
        specService.get().success(function (info) {
        console.log(info);
        $scope.list=info;
//      $scope.listitem=info;
    })
        specService.getlistitem($stateParams.id).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.data;
    })
        
//  specService.getlist().success(function (info) {
//      console.log(info);
////      $scope.list=info;
//  })
    
    $scope.listselect=function(id){
    	specService.getlistitem(id).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.data;
        

    })
 
    }
//specService.getlistchild(1).success(function (info) {
//      console.log(info);
//  })
var listch=[];
    $scope.listchild=function(id){
 
    	specService.getlistchild(id).success(function (info) {
        console.log(info);
        listch[id-1]=info.result.data
//     listch.push(info.result.data);
        
         $scope.listchilditem=listch;
    })
    	 }
    
    $scope.listupdate=function(id,name){
    	var leng=listupdate.length;
	if(listupdate[0]){
		
	
    	
    	  for (var i=0;i<leng;i++) {
    	  	if(listupdate[i].id==id){
    	  		listupdate[i]={id:id,item:name}
    	  	}else{
    	  		listupdate.push({id:id,item:name})
    	  	}
    	  	
    	  }
    	}else{
    		listupdate.push({id:id,item:name})
    	}
    	
    	}
    $scope.updateitem=function(){
    console.log(listupdate)
    	listupdate.forEach(function(currentValue, index, arr){
    		console.log(currentValue)
    		specService.postitem(currentValue).success(function(data) {
                if(data.status == '200'){
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }else{
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }
            });
    	})
    	listupdate=[]
    }
    $scope.removeid=function(idValue){
    	
        $http({
                method  : 'POST',
                url     : HOST + '/goods/SpecItem/del',
                data    : {id:idValue},
                headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
            }).success(function(data) {
            	console.log(data)
                if(data.status == '200'){
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }else{
                	
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }
            }).error(function(data, status, headers, config) {  
    //处理错误  
    console.log(data,status)
})
    }
    $scope.openWindow = function (tpl,item) {
        $modal.open({
            templateUrl: tpl,
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
            	$scope.item = item;
            	
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                if(tpl == 'tpl-add.html'){
                    $scope.updateMemberSubmuit = function(formData) {
                    	

//                  	if($scope.item.item == ""){
//                  		$.MsgBox.Alert("操作提示", '规格名称不能为空', function(){});
//                  		return;
//                  	}
//                      if($scope.item.spec_id == ""){
//                          $.MsgBox.Alert("操作提示", '规格分类不能为空', function(){});
//                          return;
//                      }
//                      console.log("添加数据");
//                      console.log($scope.item)
//                      console.log({spec_id:$scope.item.cat_id,item:$scope.item.item});
                        var postData = {};
                		postData.spec_id = formData.spec_id;
                		postData.item = formData.item;
                		console.log(postData);
                		url = HOST + '/goods/SpecItem/add';

                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: postData,
                            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                        }).success(function(res,status) {
                        
                        	if(status == '200'){
                                $.MsgBox.Alert("操作提示", res.spec_item_id, function(){
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
                }else if(tpl == 'tpl-edit.html'){
                    console.log("修改的数据");
                    console.log(item);
                    $scope.updateMemberSubmuit = function(item) {
                    	if($scope.item.item == ""){
                            $.MsgBox.Alert("操作提示", '规格名称不能为空', function(){});
                            return;
                        }
                        if($scope.item.spec_id == ""){
                            $.MsgBox.Alert("操作提示", '规格分类不能为空', function(){});
                            return;
                        }
                		url = HOST + '/goods/SpecItem/add';
                		// MDZZ
                		var postData = {};
                		postData.spec_id = item.spec_id;
                		postData.item = item.item;
                		console.log(postData);
                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: postData,
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
    
}]);
