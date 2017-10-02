var goodsAddModule = angular.module('goods.Goods.add.service',[]);

goodsAddModule.service('goods.Goods.add', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
}]);