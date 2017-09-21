angular.module('crowd.Admin.detail.service',[

]).service('crowd.Admin.detail', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/crowd/Admin/detail?id='+id
        });
    };
}]);