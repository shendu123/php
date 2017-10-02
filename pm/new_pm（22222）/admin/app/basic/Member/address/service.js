angular.module('basic.Member.address.service',[

]).service('basic.Member.address', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getAddress = function(uid) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Member/address/',
            params: {uid:uid}
        });
    };
}]);