angular.module('basic.Company.index.service',[

]).service('basic.Company.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Company/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getUserDetail = function(uid){
        return $http({
            method: 'GET',
            url: HOST + '/basic/Company/getMemberDetail?uid=' + uid
        });
    }
}]);