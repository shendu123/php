angular.module('basic.Member.delivery.service',[

]).service('basic.Member.delivery', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Member/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
}]);