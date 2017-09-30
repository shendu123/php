angular.module('basic.User.changepwd.service',[

]).service('basic.User.changepwd', [ "$http" , "$state", "API_WD_DOMAIN" ,function( $http , $state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/User/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };   
}]);