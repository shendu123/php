var curModule = angular.module('basic.Business.view.service',[]);

curModule.service('basic.Business.view', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.getDetail = function(business_id){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business/view?business_id='+business_id
        });
    };
    
}]);