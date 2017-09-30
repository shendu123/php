angular.module('basic.Role.authorize', [

]).controller('controller.basic.Role.authorize', [ "$scope" ,"$rootScope" , "$stateParams", "utils", "$state", '$modal', "basic.Role.authorize", function( $scope, $rootScope, $stateParams, utils, $state, $modal, roleService) {
    $scope.roleService = roleService;
    $scope.utils = utils;   
    $rootScope.$on('modalauthorizeSuccess', function (e, $scope ,data) {
        $state.reload();
    });  
    roleService.allNodes().success(function(data, status) {
        $scope.menu = data.nodes;
    }); 
    roleService.roleNodes($stateParams.id).success(function(nodes, status) {
        $scope.authorize = nodes;//console.log($scope.authorize);
    });
    $scope.in_array=function (search,array){
        for(var i in array){
            if(array[i]==search){
                return true;
            }
        }
        return false;
    }   
    $scope.checkAll=function(event){                  
        var check1=$(event.target).parent('span').find("input[type=checkbox]");
        var cboxList=$(event.target).parents('li').find('ol').find("input[type=checkbox]");
        cboxList.prop('checked',check1.prop("checked"));
    }
    $scope.checkOne = function(event,type){// 当一个选中时
        var check=$(event.target).parent('span').find("input[type=checkbox]");                     
        var check1='',check2='',check3='',checkedLength='';                 
        check1=$(event.target).parents('ol').siblings('span').find("input[name=checkbox1]");
        if(type==2){
            checkedLength=$(event.target).parent('span').parent('li').parent('ol').find("input[name=checkbox2]:checked").length; 
            check3=$(event.target).parent('span').siblings('ol').find("input[name=checkbox3]");
            check1.prop("checked",checkedLength>0?true:false);
            check3.prop("checked",check.prop('checked'));
        }else{
            checkedLength=$(event.target).parent('span').parent('li').parent('ol').find("input[name=checkbox3]:checked").length;//console.log(checkedLength);
            check2=$(event.target).parent('span').parent('li').parent('ol').siblings('span').find("input[name=checkbox2]"); 
            check1.prop('checked',checkedLength>0?true:false); 
            check2.prop('checked',checkedLength>0?true:false); 
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
            roleService.authorize(nodeId,$stateParams.id).success(function(res, status) {
                switch(status) {
                    case 200:
                        utils.message(res.msg);
                        $state.go("basic-Role-index");
                        break;
                    default:
                        utils.message(res.error);
                }
            }).error(function () {
                utils.message('服务器无响应！');
            })
        }
    }

}]);
