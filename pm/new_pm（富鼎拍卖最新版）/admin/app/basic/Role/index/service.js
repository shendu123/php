angular.module('basic.Role.index.service',[

]).service('basic.Role.index', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Role/index?toHtml=0',
            params: condition
        });
    };

    this.add = function (role) {

        return $http.post(HOST + '/basic/Role/add', role).success(function(res,status){ $state.reload();});

    };

    this.update = function (role) {
        return $http.post(HOST + '/basic/Role/edit', role).success(function(res,status){ $state.reload();});
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/basic/Role/delete',
            params: {'id': id}
        });
    };
    
    this.changeStatus = function (status,id) {
        return $http({
            method: 'POST',
            url: HOST+ '/basic/Role/changeStatus',
            params: {'id': id,'status':status}
        });
    }   
}]).service('basic.Role.authorize', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){
    this.allNodes = function() {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Node/allNodes',
            params: {}
        });
    };
    this.roleNodes = function(rid) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Role/authorize',
            params:{'id':rid}
        });
    };
    this.authorize = function (nodeId,roleId) {
        return $http({
            method: 'POST',
            url: HOST + '/basic/Role/authorize',
            params: {'nodeId': nodeId,'roleId':roleId}
        });
    };
}]);