angular.module('pay.Pay.stat.service',[

]).service('pay.Pay.stat', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    var HOSTD = "http://192.168.71.231";
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/pay/Stat/getSumByPayment',
            params: condition
        });
    };

}]);