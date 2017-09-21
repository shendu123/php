var curModule = angular.module('basic.Business.edit.service',[]);

curModule.service('basic.Business.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.getDetail = function(business_id){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business/edit?business_id='+business_id
        });
    };
    
    this.getCompanyList = function(){
    	return $http.get(HOST + '/basic/Business_company/index');
    }
}]);