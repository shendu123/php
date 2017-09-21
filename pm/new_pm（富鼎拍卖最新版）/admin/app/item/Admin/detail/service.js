angular.module('item.Admin.detail.service',[

]).service('item.Admin.detail', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/item/Admin/detail?id='+id
        });
    };
}]);