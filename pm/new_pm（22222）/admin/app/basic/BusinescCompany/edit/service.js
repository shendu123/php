var curModule = angular.module('basic.Company.edit.service',[]);

curModule.service('basic.Company.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.getDetail = function(com_id){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Company/getDetail?com_id='+com_id
        });
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
    
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
}]);