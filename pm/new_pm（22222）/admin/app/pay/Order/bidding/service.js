angular.module('pay.Order.bidding.service',[

]).service('pay.Order.bidding', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/pay/Order/bidding/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.update = function (bidding) {
        return $http.post(HOST + '/pay/Order/editBidding', bidding);
    };
    this.getExpressCompany = function () {
        return $http.get(HOST + '/pay/order/getExpressCompany');
    };
}]);