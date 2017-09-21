angular.module('goods.Spec.index', [

]).controller('controller.goods.Spec.index', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "goods.Spec.index", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, specService) {
    $scope.specService = specService;
    $scope.utils = utils;
    specService.get().success(function (info) {
       // console.log(info);
        $scope.list=info.result.data;
    })
    specService.getCategory().success(function (info) {
         $scope.listCategory=info.data;
         // console.log($scope.listCategory)
    })
 
     if($('body').find('li.active').length>=1){
        for(var i=0,j=$('body').find('li.active').length;i<j;i++){
            if($('body').find('li.active').eq(i).children('ul').children().length==0){
                //console.log($('body').find('li.active').eq(i).children('ul').children().length)
                debugger
                console.log($('body').find('li.active').eq(i).attr('data-id'))
            }
           
        }
     }
 

     $scope.listupdate=function(id,name,sort,cat_id){
        
        url = HOST + '/goods/spec/edit';                 
        var postData = {'id':id, 'cat_id':cat_id, 'name':name, 'sort':sort};
        $http({
            method  : 'POST',
            url     : url,
            data    : postData,
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
        
    }

    $scope.remove=function(idValue){
        $http({
                method  : 'POST',
                url     : HOST + '/goods/spec/del',
                data    : {id:idValue},
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

                     specService.getCategory().success(function (info) {
                         $scope.listCategory=info.data;
                         // console.log($scope.listCategory)
                    })
                    $scope.updateMemberSubmuit = function(formData) {
                    	// console.log($scope.item)

                    	if($scope.item.name == ""){
                    		$.MsgBox.Alert("操作提示", '规格名称不能为空', function(){});
                    		return;
                    	}
                        if($scope.item.cat_id == ""){
                            $.MsgBox.Alert("操作提示", '规格分类不能为空', function(){});
                            return;
                        }
                        // console.log("添加数据");
                        // console.log($scope.item);
                		url = HOST + '/goods/spec/add';

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
                    // console.log("修改的数据");
                    // console.log(item);
                     specService.getCategory().success(function (info) {
                         $scope.listCategory=info.data;
                         // console.log($scope.listCategory)
                    })
                    $scope.updateMemberSubmuit = function(item) {

                    	if($scope.item.name == ""){
                            $.MsgBox.Alert("操作提示", '规格名称不能为空', function(){});
                            return;
                        }
                        if($scope.item.cat_id == ""){
                            $.MsgBox.Alert("操作提示", '规格分类不能为空', function(){});
                            return;
                        }


                		url = HOST + '/goods/spec/edit';
                		
                		var postData = {'id':item.id, 'cat_id':item.cat_id, 'name':item.name, 'sort':item.sort};

                        // console.log("提交的数据");
                        // console.log(postData)

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
                }
         
            }]
        });
    }
    
}]);
