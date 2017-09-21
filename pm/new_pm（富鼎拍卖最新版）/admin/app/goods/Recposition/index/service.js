angular.module('goods.Recposition.index.service',[

]).service('goods.Recposition.index', [ "$http" , '$state' , "API_WD_DOMAIN" ,function( $http , $state,HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Recposition/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Recposition/add', data).success(function(res,status){ $state.reload();});
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Recposition/edit', data).success(function(res,status){ $state.reload();});
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Recposition/delete',
            params: {'id': id}
        });
    };
}]);