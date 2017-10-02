angular.module('pay.companyCash.index.service',[

]).service('pay.companyCash.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/finance/withdraw/businessList/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
}]);