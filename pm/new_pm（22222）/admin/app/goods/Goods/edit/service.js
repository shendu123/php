var goodsEditModule = angular.module('goods.Goods.edit.service',[]);

goodsEditModule.service('goods.Goods.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Goods/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/goods/Goods/detail?id='+id
        });
    };
    
    
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
}]);