angular.module('basic.Member.index.service',[

]).service('basic.Member.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Member/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };

   
}]);