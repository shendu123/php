angular.module('pay.PromotionBusiness.index.service',[

]).service('pay.PromotionBusiness.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/finance/withdraw/drawlist/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
}]);