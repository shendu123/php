angular.module('pay.Order.view.service',[

]).service('pay.Order.view', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getDetail = function(param){
        return $http({
            method: 'GET',
            url: HOST + '/finance/Auction/getDetail',
            params:{order_id:param.order_id}
        });
    };
}]);