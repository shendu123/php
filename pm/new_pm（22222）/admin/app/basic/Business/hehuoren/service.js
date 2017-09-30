angular.module('basic.Business.hehuoren.service',[

]).service('basic.Business.hehuoren', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business/businessList/sysid/2/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (method,data) {
        return $http.post(HOST + '/basic/Business/'+method, data);
    };
    this.getParentBusiness=function() {
        return $http.get(HOST + '/basic/Business/getParentBusiness?sysid=2');
    };
    this.percent = function() {
        return $http({method: 'GET',url: HOST + '/basic/Business/percent/'});
    };
    this.edit = function (id) {
        return $http.get(HOST + '/basic/Business/edit?id='+id);
    };   
}]);