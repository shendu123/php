var auctionEditModule = angular.module('auction.Admin.edit.service',[]);

auctionEditModule.service('auction.Admin.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){  
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/auction/Admin/detail?id='+id
        });
    };
    
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };

    this.getBrandList = function(cat_id){
    	return $http.get(HOST + '/goods/Brand/index?cat_id='+cat_id);
    };
}]);