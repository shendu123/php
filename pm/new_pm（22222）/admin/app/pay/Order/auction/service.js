angular.module('pay.Order.auction.service',[

]).service('pay.Order.auction', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/finance/Auction/getList/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };

}]);