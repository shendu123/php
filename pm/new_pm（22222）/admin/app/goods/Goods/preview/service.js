angular.module('goods.Goods.preview.service',[

]).service('goods.Goods.preview', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/goods/Goods/detail?id='+id
        });
    };
}]);