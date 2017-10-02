angular.module('crowd.Admin.applylist.service',[

]).service('crowd.Admin.applylist', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Brandapply/getList/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
}]);