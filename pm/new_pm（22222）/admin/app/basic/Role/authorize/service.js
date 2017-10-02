angular.module('basic.Role.authorize.service',[

]).service('basic.Role.authorize', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){

    
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