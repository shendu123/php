angular.module('basic.Node.index', [
    'basic.Node.index.service'
]).controller('controller.basic.Node.index', ["$scope", "$rootScope", "$stateParams", '$ocLazyLoad', '$modal','utils','Node.index.service', function($scope, $rootScope, $stateParams, $loader, $modal,utils, nodeService) {

    nodeService.allSystem().success(function (systems) {
        $scope.systems = systems;

        _chooseSys(systems[0].sysid);
    });

    $scope.chooseSys = function ($event) {
        _chooseSys($event.target.id)
    };

    var _chooseSys = function (sysid) {
        $scope.currentSysid = sysid;
        angular.forEach($scope.systems, function(system) {
            if(system.sysid == sysid) {
                $scope.currentSys = system.title;
            }
        });

        nodeService.allNodes(sysid).success(function(nodes, status) {
        	
            $scope.menu = nodes;
           
            console.log(nodes)
        });
    };
   
    $scope.newNode = function (sysid, systitle, pid, ptitle) {
        $modal.open({
            templateUrl: "editNode.html",
            size: 'md',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                $scope.submittedEdit = false;
                $scope.node = {
                    sysid: sysid,
                    pid: pid,
                    is_menu:0
                };
                $scope.from = {
                    systitle: systitle,
                    ptitle: ptitle
                };
                $scope.cancel = function() {
                    $modalInstance.dismiss('cancel');
                };
                $scope.chgType = function () {
                    $scope.$broadcast('$chgType');
                };
                $scope.submitNode = function(isValid) {

                    $scope.submittedEdit = true;
                    $scope.node.icon = $scope.iconClass;
                    if (isValid) {
                        nodeService.add($scope.node).success(function(res, status) {
                            switch(status) {
                                case 200:
                                    $modalInstance.dismiss('cancel');
                                    _chooseSys(sysid);
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
    };

    $scope.editNode = function (systitle, node) {   

        $modal.open({
            templateUrl: "editNode.html",
            size: 'md',
            controller: ["$scope", "$rootScope", "$modalInstance", "$state", "utils", function($scope, $rootScope, $modalInstance, $state, utils) {
                $scope.submittedEdit = false; 
                $scope.from = {
                    systitle: systitle,
                    ptitle: node.title
                };
                $scope.node=node;
                $scope.cancel = function() {
                	  $state.reload();
                    $modalInstance.dismiss('cancel');
                };
                $scope.chgType = function () {
                    $scope.$broadcast('$chgType');
                };
                $scope.submitNode = function(isValid) {
                    $scope.submittedEdit = true;
                    //$scope.node.icon = $scope.iconClass;
                    if (isValid) {
                    	console.log(isValid)
                    	console.log($scope.node)
                    	var data=$scope.node;
                    	if($scope.nodeico){
                    		data.icon=$scope.nodeico
                    	}
                    	
                        nodeService.update(data).success(function(res, status) {
                        	  $modalInstance.dismiss('cancel');
                                    _chooseSys(node.sysid);
                        	console.log(res)
                        	console.log(status)
                            switch(status) {
                                case 200:
//                              console.log(res)
                                    $modalInstance.dismiss('cancel');
                                    _chooseSys(node.sysid);
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
    };

    $scope.delNode = function (sysid, id) {
        nodeService.delete(id).success(function (res, status) {
            switch (status) {
                case 200:
                    _chooseSys(sysid);
                    break;
                default:
                    utils.message(res.error);
            }
        }).error(function () {
            utils.message('服务器无响应！');
        });
    };
}]).directive('urlValue', function () {
    return {
        require: 'ngModel',
        link: function (scope, ele, attrs, ctrl) {
            var validate = function () {
                if(scope.node.is_menu != 1 && ! /\w+\/\w+\/\w+/gi.test(scope.node.url_value)) {
                    ctrl.$setValidity('uv', false);
                } else {
                    ctrl.$setValidity('uv', true);
                }
            };
            scope.$watch(attrs.ngModel, validate);
            scope.$on('$chgType', validate)
        }
    }
})
