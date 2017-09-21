angular.module('auction.Admin.paimaihui.service',[

]).service('auction.Admin.paimaihui', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/auction/Admin/index/type/paimaihui/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/auction/Admin/detail?id='+id
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/auction/Admin/check',
            params: {'id': id,'value':value,'reason':reason}
        });
    };
    
    this.getGoodsCatList = function (){
    	return $http.get(HOST + '/goods/Category/index');
    }
    
    this.getRecpositionList = function (){
    	return $http.get(HOST + '/goods/Recposition/index');
    }
}]);