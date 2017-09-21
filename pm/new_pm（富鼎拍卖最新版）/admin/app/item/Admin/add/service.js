angular.module('item.Admin.add.service',[

]).service('item.Admin.add', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };

    this.getBrandList = function(cat_id){
    	return $http.get(HOST + '/goods/Brand/index?cat_id='+cat_id);
    };
}]);