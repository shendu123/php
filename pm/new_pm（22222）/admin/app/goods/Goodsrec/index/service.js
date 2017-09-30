angular.module('goods.Goodsrec.index.service',[

]).service('goods.Goodsrec.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Goodsrec/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Goodsrec/add', data);
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Goodsrec/edit', data);
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Goodsrec/delete',
            params: {'id': id}
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/goods/Goodsrec/check',
            params: {'id': id,'value':value,'reason':reason}
        });
    };
}]);