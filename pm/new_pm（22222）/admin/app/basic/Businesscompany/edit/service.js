var curModule = angular.module('basic.Businesscompany.edit.service',[]);

curModule.service('basic.Businesscompany.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.getDetail = function(com_id){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business_company/edit?com_id='+com_id
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