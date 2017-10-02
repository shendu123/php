angular.module('auction.Admin.detail.service',[

]).service('auction.Admin.detail', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/auction/Admin/detail?id='+id
        });
    };
}]);