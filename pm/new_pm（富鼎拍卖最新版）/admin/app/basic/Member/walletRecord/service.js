angular.module('basic.Member.walletRecord.service',[

]).service('basic.Member.walletRecord', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page,condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Member/walletRecord/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.adjustMoney = function (info) {
        return $http.post(HOST + '/basic/Member/adjustMoney', info);
    };
}]);