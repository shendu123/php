angular.module('goods.Spec.index.service',[

]).service('goods.Spec.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function() {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Spec/'
        });
    };

    this.getCategory = function() {
        return $http({
            method: 'GET',
            url: HOST + '/goods/category/catList'
        });
    };
    //  this.remove = function (id) {
    //     return $http({
    //         method: 'post',
    //         url: HOST + '/goods/spec/del',
    //         params: {'id': id}
    //     });
    // };
}]);