angular.module('goods.Recapply.index.service',[

]).service('goods.Recapply.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Recapply/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Recapply/add', data);
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Recapply/edit', data);
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Recapply/delete',
            params: {'id': id}
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/goods/Recapply/check',
            params: {'id': id,'value':value,'reason':reason}
        });
    };
}]);