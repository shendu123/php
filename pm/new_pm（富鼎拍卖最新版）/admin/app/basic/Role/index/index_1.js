angular.module('basic.Role.index', [

]).controller('controller.basic.Role.index', [ "$scope" ,"$rootScope" , "$stateParams", "utils", "$state", '$modal', "basic.Role.index", function( $scope, $rootScope, $stateParams, utils, $state, $modal, roleService) {
    $scope.roleService = roleService;
    $scope.utils = utils;

    $rootScope.$on('modalauthorizeSuccess', function (e, $scope ,data) {
        $state.reload();
    });
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要批量删除？", function(){
            roleService.remove(ids).success(function(res,status){
                if(status!=200){
                    utils.message(res.error);
                }
                $state.reload();
            });
        })        
    }
    $scope.changeStatus = function (status) {
        var ids = fdCheckGet("ids[]");
        var str=status==0?'禁用':'启用';
        $.MsgBox.Confirm("操作提示", "确定要"+str+"？", function(){
            roleService.changeStatus(status,ids).success(function(res,status){
                if(status!=200){
                    utils.message(res.error);
                }
                $state.reload();
            })            
        })        
    };
    $scope.authorize = function (index) {
        $modal.open({
            templateUrl: "tpl-authorize.html",
            size: 'lg',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                $scope.submittedEdit = false;
                $scope.node = {

                };
                $scope.from = {

                };
                roleService.allSystem().success(function (systems) {
                    $scope.systems = systems;
                    _chooseSys(systems[0].sysid);
                });   
                var _chooseSys = function (sysid) {
                    roleService.allNodes(sysid).success(function(nodes, status) {
                        $scope.menu = nodes;
                    }); 
                    roleService.roleNodes(index.id).success(function(nodes, status) {
                        $scope.authorize = nodes;//console.log($scope.authorize);
                    });
                }
                               
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                
                $scope.name = index.name;
                
                $scope.in_array=function (search,array){
                    for(var i in array){
                        if(array[i]==search){
                            return true;
                        }
                    }
                    return false;
                }                
                $scope.checkAll=function(obj){
                    var id=obj.node.id;                    
                    var cboxList=$(".ol"+id).find("input[type=checkbox]");
                    var pcheck=$(".ol"+id).siblings('span').find("input[type=checkbox]");
                    cboxList.prop('checked',pcheck.prop("checked"));
                }
                $scope.checkOne = function(obj,type){// 当一个选中时
                    var pid,cboxListChecked2,cboxList3,cboxListChecked3,pcheck,pcheck2,cur;
                    if(type==1){
                        pid=obj.cNode.pid;
                        cur=$(".ol"+pid).find("input[type=checkbox][value="+obj.cNode.id+"]");
                        cboxListChecked2=$(".ol"+pid).find("input[type=checkbox]:checked");//console.log(cboxListChecked2.length);
                        cboxList3=cur.parent('span').siblings('ol').find("input[type=checkbox]");
                        pcheck=$(".ol"+pid).siblings('span').find("input[type=checkbox]");
                        pcheck.prop("checked",cboxListChecked2.length>0?true:false);
                        cboxList3.prop("checked",cur.prop('checked'));
                    }else{
                        pid=obj.tNode.pid; 
                        cboxListChecked3=$(".ol"+pid).find("input[type=checkbox]:checked");
                        pcheck=$(".ol"+pid).parents('ol').siblings('span').find("input[type=checkbox]");
                        pcheck2=$(".ol"+pid).siblings('span').find("input[type=checkbox]");
                        pcheck.prop('checked',cboxListChecked3.length>0?true:false); 
                        pcheck2.prop('checked',cboxListChecked3.length>0?true:false); 
                        
                    }                  
                };                  
                $scope.submitNode = function(isValid) {
                    $scope.submittedEdit = true;
                    var checked=$("input[type=checkbox]:checked");
                    var nodeIdArr=[];
                    var nodeId='';
                    if(checked.length>0){
                        angular.forEach(checked,function(index,key){
                            var id=index.value;
                            nodeIdArr.push(id);
                        });
                        nodeId=nodeIdArr.join();
                    }               
                    if (isValid) {
                        roleService.authorize(nodeId,index.id).success(function(res, status) {
                            switch(status) {
                                case 200:
                                    $modalInstance.dismiss('cancel');
                                    break;
                                default:
                                    utils.message(res.error);
                            }
                        }).error(function () {
                            utils.message('服务器无响应！');
                        })
                    }
                }
            }]
        });
    }
}]);
