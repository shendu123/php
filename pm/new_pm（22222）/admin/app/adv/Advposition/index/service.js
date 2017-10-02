angular.module('adv.Advposition.index.service',[

]).service('adv.Advposition.index', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http , $state,HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/adv/Adv_position/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.add = function (ap) {
        return $http.post(HOST + '/adv/Adv_position/add', ap).success(function(res,status){ $state.reload();});  
    }; 
    this.update = function (ap) {
        return $http.post(HOST + '/adv/Adv_position/edit', ap);
    };
   
   
}]);