angular.module('basic.Member.Trade.service',[

]).service('basic.Member.Trade', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/finance/Order/getTradeList/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
}]);