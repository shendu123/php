angular.module('goods.Brand.index.service',[

]).service('goods.Brand.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Brand/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Brand/add', data);
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Brand/edit', data);
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Brand/delete',
            params: {'id': id}
        });
    };
    
    this.getCatList = function() {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Category/catList'
        });
    };
}]);