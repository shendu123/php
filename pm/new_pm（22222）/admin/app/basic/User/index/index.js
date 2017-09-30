angular.module('basic.User.index', [

]).controller('controller.basic.User.index', ["$http","$scope","$rootScope", "$stateParams", "utils","$state",'$modal', "API_WD_DOMAIN","basic.User.index","treeRender",
    function( $http,$scope, $rootScope, $stateParams, utils,$state, $modal,Host,userService,treeRender) {
    $scope.userService = userService;
    $scope.utils = utils;
    userService.roleList().success(function(res,status){
        $scope.roles =  res.data.slice(0);
        $scope.roles.unshift({ id: 0  ,leaf: false  ,name: "根" , pid : 0 , pname: "根"  })
    });
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: Host+ '/basic/User/delete',
                params: {'id': id}
            });
            $state.reload();
        });        
    };

    // $scope.changeStatus( ($(this).prop('checked') ? 1 : 0 ), $(this).data('id')).success(function(res,status){
    //     if(status!=200){
    //         utils.message(res.error);
    //         $(_this).prop('checked' , !$(_this).prop('checked') );
    //     }
    //
    // })
    $scope.$on('modalLoaded' , function( e, scope ){
        // scope.roles =  $scope.roles;
        //   delete scope.item.child;
        treeRender.renderList( $scope.roles , 0  , function(  item , icon , index ){
            return  '<li data-id="'+ item.id +'" class="dropdown-slide-item text-left  tree-node">' +
                '<a href="javascript:void(0)">'+ icon + '&nbsp;<span class="dropdown-tag">' + item.name + '</span></a>' +
                '<div class="dropdown-slide-children node-'+ ( item.id ) +'" style="display:none;padding-left: 5px;""></div>' +
                '</li> ';
        } , $scope );
    });
    $scope.$on('modalUpdateSuccess' , function( e, scope ){
        $state.reload();
    });
    $scope.$on('modalAddSuccess' , function( e, scope ){
        $state.reload();
    });

    $scope.changeStatus = function (status) {
        var id_str=$rootScope.idChecked();
        var str=status==1?'禁用':'启用';
        if(id_str){
            $.MsgBox.Confirm("操作提示","确定"+str+"？",function(){
                $http({
                    method: 'POST',
                    url: Host+ '/basic/User/changeStatus',
                    params: {'id': id_str,'status':status}
                });
                $state.reload();
             });
        }        
    };


    $scope.change = function () {
        var id_str = this.item.uid ;
        var status = this.item.status  ;
        var str= status == 0 ?'禁用':'启用';
        if(id_str){
            $.MsgBox.Confirm("操作提示","确定"+str+"？",function(){
                $http({
                    method: 'POST',
                    url: Host+ '/basic/User/changeStatus',
                    params: {'id': id_str,'status': status  }
                });
            });
        }
    };
    
    $rootScope.delChecked  = function(){
        var id_str=$rootScope.idChecked();
        if(id_str){
            $scope.removeb(id_str);
        }
    };
    
    $rootScope.checkAll = function(event){
        var obj=event.target;
        var chbox=$(obj).parents("tr").siblings("tr").find("input[type=checkbox]");
        chbox.prop('checked',$(obj).prop('checked'));
    }
    
    $rootScope.idChecked  = function(){
        var id_arr= new Array();
        var id_str='';
        var checked=$("input[type=checkbox]:not(.firstCb):checked");
        if(checked.length>0){
            angular.forEach(checked,function(index,key){
                var id=index.value;
                id_arr.push(id);
            });
            id_str=id_arr.join();
        }
        return id_str;
    };

    $scope.openWindow = function (tpl,index) {
    	// console.log($scope.userService)
     //    $modal.open({
     //        templateUrl: tpl,
     //        size: 'lg',
     //        controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
     //            //获取审核信息    
     //            userService.check(index).success(function(info, status) {
     //                $scope.mComInfo = info;             
     //            });
     //            $scope.item=index
     //            $scope.cancel = function() {
     //            	console.log('111')
                	
     //                $modalInstance.dismiss('cancel');
     //                 $state.reload();
                    
     //            };
     //            //审核
     //            $scope.check = function(status) {
     //                var checkmsg=$("#reason").val();
     //                if(status==-1&&!checkmsg){
     //                    utils.message('拒绝原因不能为空');
     //                    return;
     //                }
     //                userService.checkSub(index.uid,status,checkmsg).success(function(res, status) {
     //                    switch(status) {
     //                            case 200:
     //                                $modalInstance.dismiss('cancel');
     //                                break;
     //                            default:
     //                                utils.message(res.error);
     //                    }
     //                }).error(function () {
     //                        utils.message('服务器无响应！');
     //                });  
     //            };
     //            //修改密码
     //            $scope.changePwdSub = function() {
     //                var oldPwd=$("#oldPwd").val();
     //                var newPwd=$("#newPwd").val();
     //                var confirmPwd=$("#confirmPwd").val();
     //                if(!oldPwd){
     //                    utils.message('旧密码不能为空');
     //                    return;
     //                }
     //                if(!newPwd){
     //                    utils.message('新密码不能为空');
     //                    return;
     //                }
     //                if(newPwd!=confirmPwd){
     //                    utils.message('确认密码与新密码不一致');
     //                    return;
     //                }
     //                userService.changePwdSub(index.uid,oldPwd,newPwd).success(function(res, status) {
     //                    switch(status) {
     //                            case 200:
     //                                $modalInstance.dismiss('cancel');
     //                                break;
     //                            default:
     //                                utils.message(res.error);
     //                    }
     //                }).error(function () {
     //                        utils.message('服务器无响应！');
     //                });  
     //            };
                    
     //        }]
     //    })

         if(tpl=="tpl-add.html"){
                userService.getsysall().success(function (catList) {
                    $modal.open({
                        templateUrl: tpl,
                        size: 'lg',
                        controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils","API_WD_DOMAIN", function($scope, $rootScope, $modalInstance, $state, utils ,HOST) {
                            $scope.catList = catList
                            $scope.items = catList;

                            $scope.listselect=function(id){
                                    console.log(id)
                                    userService.getlistitem(id).success(function (info) {
                                    console.log(info);
                                    $scope.itemschild=info.data;
                                    $scope.childselect.pname=info.data[0].id;
                                    $scope.childselect.sysid=id
                                })
                             
                            }

                            $scope.cancel = function() {
                                $state.reload();
                                $modalInstance.dismiss('cancel');
                            };
                            
                            //新增提交
                            $scope.submitAddForm = function(item) {
                                console.log(item)
                           
                                url = HOST + '/basic/User/add';
                                
                                
                                $http({
                                    method  : 'POST',
                                    url     : url,
                                    data    : item,
                                    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                                }).success(function(data) {
                                    $modalInstance.dismiss('cancel');
                                    if(data.status == 200){
                                        $.MsgBox.Alert("操作提示", data.msg, function(){
                                            $state.reload();
                                        });
                                    }else{
                                        $.MsgBox.Alert("操作提示", data.msg, function(){
                                            $state.reload();
                                        });
                                    }
                                });  
                            };


                                
                        }]
                    })
                });
         }
        
        if(tpl=="tpl-update.html"){
            userService.getlistitem(index.business_id).success(function(info) {
               $modal.open({
                    templateUrl: tpl,
                    size: 'lg',
                    controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils","API_WD_DOMAIN", function($scope, $rootScope, $modalInstance, $state, utils ,HOST) {
                             $scope.item=index;
                             $scope.item['Rolelist']=info.data;
                             console.log("ghhhhhhhhhhhhhhhhhhhhh")
                             console.log( $scope.item);

                            $scope.cancel = function() {
                                console.log("11111")
                                $state.reload();
                                $modalInstance.dismiss('cancel');
                            };

                            //新增提交
                            $scope.submitUpdateForm = function(item) {
                                console.log(item)
                           
                                url = HOST + '/basic/User/edit';
                                
                                
                                $http({
                                    method  : 'POST',
                                    url     : url,
                                    data    : item,
                                    headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
                                }).success(function(data) {
                                    $modalInstance.dismiss('cancel');
                                    if(data.status == 200){
                                        $.MsgBox.Alert("操作提示", data.msg, function(){
                                            $state.reload();
                                        });
                                    }else{
                                        $.MsgBox.Alert("操作提示", data.msg, function(){
                                            $state.reload();
                                        });
                                    }
                                });  
                            };
                    }]
                })

            });
         }
        
        
    };
    
}]);
