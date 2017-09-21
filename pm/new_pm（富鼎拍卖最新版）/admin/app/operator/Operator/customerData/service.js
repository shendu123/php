angular.module('operator.Operator.customerData.service',[

]).service('operator.Operator.customerData', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/pay/Operator/customerData/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
   
}]);