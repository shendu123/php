var crowdEditModule = angular.module('crowd.Admin.edit.service',[]);

crowdEditModule.service('crowd.Admin.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){  
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/crowd/Admin/detail?id='+id
        });
    };
    
    
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };

    this.getBrandList = function(cat_id){
    	return $http.get(HOST + '/goods/Brand/index?cat_id='+cat_id);
    };
}]);