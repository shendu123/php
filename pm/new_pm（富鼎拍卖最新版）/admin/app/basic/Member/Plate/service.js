angular.module('pay.Order.auction.service',[

]).service('pay.Order.auction', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/finance/Auction/getList/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.update = function (auction) {
        return $http.post(HOST + '/pay/Order/editAuction', auction);
    };

//    this.remove = function (id) {
//        return $http({
//            method: 'DELETE',
//            url: HOST + '/pay/Order/delete',
//            params: {'id': id}
//        });
//    };
}]);