angular.module('pay.Order.view.service',[

]).service('pay.Order.view', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    // this.getDetail = function(param){
    //     return $http({
    //         method: 'GET',
    //         url: HOST + '/pay/Order/view',
    //         params:{id:param.id,type:param.type}
    //     });
    // };

    this.getDetailAuction = function(param){
        return $http({
            method: 'GET',
            url: HOST + '/finance/Auction/getDetail',
            params:{order_id:param.order_id,type:param.type}
        });
    };
    this.getDetailCrowd = function(param){
        return $http({
            method: 'GET',
            url: HOST + '/finance/Crowd/getDetail',
            params:{order_id:param.order_id,type:param.type}
        });
    };
    this.getDetailFreetrading = function(param){
        return $http({
            method: 'GET',
            url: HOST + '/finance/Freetrading/getDetail',
            params:{order_id:param.order_id,type:param.type}
        });
    };
    this.getLogistics = function(param){
        return $http({
            method: 'GET',
            url: HOST + '/finance/Order/getExpress'
        });
    };
}]);