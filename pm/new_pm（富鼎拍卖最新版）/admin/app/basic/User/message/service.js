angular.module('basic.User.message.service',[]).service('basic.User.message', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/User/message/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (message) {
        return $http.post(HOST + '/basic/User/message', message);   
    }; 
}]);