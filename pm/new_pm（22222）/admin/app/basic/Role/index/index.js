
angular.module('basic.Role.index', [

]).controller('controller.basic.Role.index', [ "$http", "$scope" ,"$rootScope" , "$stateParams", "utils","API_WD_DOMAIN", "$state", '$modal', "basic.Role.index", "$compile", "treeRender" ,
    function( $http, $scope, $rootScope, $stateParams, utils, HOST, $state, $modal, roleService,$compile , treeRender) {
    $scope.roleService = roleService;
    $scope.utils = utils;
    $scope.$on('seniorTableLoaded' , function( e, res ){
        $scope.roles =  res.data.slice(0);
        $scope.roles.unshift({ id: 0  ,leaf: false  ,name: "根" , pid : 0 , pname: "根"  })
        //roleDataRender(  res.data  );
        treeRender.renderTable( res.data  , 0  , function(  item , icon  , index ){
            return  '<div class="table-list-inner" >' +
            '<div class=" row " data-id="'+ item.id +'">' +
            '<div class="table-list-col col-xs-3 text-center tree-node">'+ icon + '&nbsp;&nbsp; '+ item.name +' </div>' +
            '<div class="table-list-col col-xs-3">'+ item.remark +'</div>' +
            '<div class="table-list-col col-xs-3"> <span class="checkbox-wrap"><input ng-show="{{userAuthority[4].userHave}}" title="{{userAuthority[4].title}}" type="checkbox" '+ (item.status==1? 'checked="checked"'  : '') +' class="checkbox-slide" ng-true-value="1" ng-false-value="0"   data-id="'+ item.id +'" /><label></label></span></div>' +
            '<div class="table-list-col col-xs-3">' +
            '<button ng-show="{{userAuthority[3].userHave}}" title="{{userAuthority[3].title}}" class="btn btn-info btn-xs glyphicon"  modal-open="tpl-role.html" controller="controller.basic.Role.index.modal"><i class="fa fa-fw fa-key"></i></button>&nbsp;' +
            '<button ng-show="{{userAuthority[1].userHave}}" title="{{userAuthority[1].title}}" class="btn btn-info btn-xs glyphicon glyphicon-edit btn-update" modal-open="tpl-edit.html" controller="controller.basic.Role.index.modal"></button>&nbsp;' +
            (item.id != 1 ? '<button ng-show="{{userAuthority[2].userHave}}" title="{{userAuthority[2].title}}" class="btn btn-danger btn-xs glyphicon glyphicon-remove-circle" ng-click="remove()"></button>' : '') +

            /*'<button class="btn btn-danger btn-xs glyphicon glyphicon-remove-circle" ng-click="remove()"></button>' +*/
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="table-list-children node-'+ item.id  +'" style="display: none; padding-left: 20px;"></div>' +
            '</div>' +
            '</div>';
        } , $scope );
        $('.table-list').on('click' , '[type=checkbox]',function(){
            var _this = this;
            roleService.changeStatus( ($(this).prop('checked') ? 1 : 0 ), $(this).data('id')).success(function(res,status){
                if(status!=200){
                    utils.message(res.error);
                    $(_this).prop('checked' , !$(_this).prop('checked') );
                }

            })
        }).on('click','.btn-update', function(){
           $rootScope.modifyGetObj = $(this).closest('.table-list-inner').data('item');


            roleService.getlistitem($rootScope.modifyGetObj.sysid).success(function(info) {
           $rootScope.modifyGetObj['Rolelist']=info.data;
           console.log($rootScope.modifyGetObj);
        });
            //console.log($rootScope.modifyGetObj)
            // $scope.item = $(this).closest('.table-list-inner').data('item');
            // console.log($scope.item)
            // $scope.update( $scope.item );
        }).on('click','.glyphicon-remove-circle', function(){
        	$scope.itemid = $(this).closest('.row').data('id');
        	console.log($scope.itemid);
                $scope.removeb( $scope.itemid );
        });;
    });

    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/basic/Role/delete',
                params: {'id': id}
            }).success(function(res,status){
                if(status != 200){
                    utils.message(res.error);
                }else{
                    $state.reload();
                }
            });
            
        });        
    };
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

    $rootScope.$on('modalauthorizeSuccess', function (e, $scope ,data) {
        $state.reload();
    });
   roleService.getsysall().success(function(data, status) {
           //console.log(data)
           $scope.items = data
        });
    $scope.openWindow = function (tpl, item) {
    	
        roleService.getsysall().success(function (catList) {
            $modal.open({
                templateUrl: tpl,
                size: 'lg',
                controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                	$scope.catList = catList
                	$scope.items = item;

                	$scope.listselect=function(id){
                            console.log(id)
                        	roleService.getlistitem(id).success(function (info) {
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
                    
                    //修改编辑提交
                    $scope.submitAddForm = function(item) {
                    	console.log(item)
                   
                    		url = HOST + '/basic/Role/add';
                    	
                    	
                        $http({
                            method  : 'POST',
                            url     : url,
                            data	: item,
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
        
    };
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
}]) .controller('controller.basic.Role.index.modal',
    [ "$scope" ,"$rootScope" , "$stateParams", "utils", "$state", '$modal', "basic.Role.authorize", "$compile", "$modalInstance", "modalBasic", "item","API_WD_DOMAIN","$http",
    function( $scope, $rootScope, $stateParams, utils, $state, $modal, roleService,$compile,$modalInstance , modalBasic , item , HOST , $http ) {

        $scope = $.extend(  $scope , modalBasic );
        $scope.cancel = function (options) {
        	$state.reload();
            $modalInstance.dismiss("cancel");
        };

        $scope.roleService = roleService;
        $scope.utils = utils;


        $rootScope.$on('modalauthorizeSuccess', function (e, $scope ,data) {
            $state.reload();
        });
     
        roleService.allNodes().success(function(data, status) {
//      	console.log(data)
            $scope.menu = data.nodes;
        });
        roleService.roleNodes(item.id).success(function(nodes, status) {
//      	console.log(nodes)
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
            var checked=$("input[type=checkbox]:checked" , '.modal-body');
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
                roleService.authorize(nodeId,item.id).success(function(res, status) {
                    switch(status) {
                        case 200:
                            utils.message(res.msg);
                            //$state.go("basic-Role-index");
                            $modalInstance.dismiss("cancel");
                            break;
                        default:
                            utils.message(res.error);
                    }
                }).error(function () {
                    utils.message('服务器无响应！');
                })
            }
        }
 


        //edit 修改页面信息
        //console.log($rootScope.modifyGetObj)
       

        //修改编辑提交
        $scope.submiteditForm = function(item) {
            console.log(item)
       
                url = HOST + '/basic/Role/edit';
            
            
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

    }])

