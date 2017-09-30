angular.module('operator.Operator.secondOperatorData.service',[

]).service('operator.Operator.secondOperatorData', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/pay/Operator/secondOperatorData/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
   
}]);