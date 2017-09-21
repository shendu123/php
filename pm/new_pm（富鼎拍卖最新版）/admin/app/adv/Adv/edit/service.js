var goodsAddModule = angular.module('adv.Adv.edit.service',[]);

goodsAddModule.service('adv.Adv.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/adv/Adv/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getCatList = function(){
    	return $http.get(HOST + '/adv/Adv_position/index');
    };
    this.edit = function(id){
        return $http.get(HOST + '/adv/Adv/edit?id='+id);
    };
}]);