var curModule = angular.module('basic.Company.add.service',[]);

curModule.service('basic.Company.add', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
    
    this.getProvinceList = function(){
    	return $http.get(HOST + '/basic/Address/getProvince');
    }
    
    this.getCityList = function(id){
    	return $http.get(HOST + '/basic/Address/getCity?proid=' + id);
    }
    
    this.getAreaList = function(id){
    	return $http.get(HOST + '/basic/Address/getDistrict?tid=' + id);
    }
}]);