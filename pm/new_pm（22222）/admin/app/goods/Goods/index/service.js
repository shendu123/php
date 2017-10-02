angular.module('goods.Goods.index.service',[

]).service('goods.Goods.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Goods/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Goods/delete',
            params: {'id': id}
        });
    };
}]);