angular.module('basic.Node.index.service',[

]).service('Node.index.service', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.allNodes = function(sysid) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Node/index',
            params: {'sysid': sysid}
        });
    };

    this.allSystem = function () {
        return $http.get(HOST + '/basic/System/all');
    };

    this.add = function (node) {
        return $http.post(HOST + '/basic/Node/add', node);
    };

    this.update = function (node) {
        return $http.post(HOST + '/basic/Node/edit', node);
    };

    this.delete = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/basic/Node/delete',
            params: {'id': id}
        });
    };
}]);