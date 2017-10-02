angular.module('pay.Order.stat.service',[

]).service('pay.Order.stat', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/pay/Stat/getSumByFrom',
            params: condition
        });
    };

}]);