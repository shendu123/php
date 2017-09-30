var curModule = angular.module('basic.Business.add.service',[]);

curModule.service('basic.Business.add', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    
    this.getCompanyList = function(){
    	return $http.get(HOST + '/basic/Business_company/index');
    }
    
    this.getDetail = function(pid){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business/edit?business_id='+pid
        });
    };
    
}]);