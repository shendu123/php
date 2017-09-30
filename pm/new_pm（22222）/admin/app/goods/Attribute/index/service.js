angular.module('goods.Attribute.index.service',[

]).service('goods.Attribute.index', [ "$http" , "$state", "API_WD_DOMAIN" ,function( $http , $state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Attribute/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.add = function (attr) {
        return $http.post(HOST + '/goods/Attribute/add', attr).success(function(res,status){ $state.reload();});;
    };
    this.update = function (article) {
        return $http.post(HOST + '/goods/Attribute/edit', article);
    };
   
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
    
    this.changeStatus = function (status,id) {
        return $http({
            method: 'POST',
            url: HOST+ '/goods/Attribute/changeStatus',
            params: {'id': id,'status':status}
        });
    }     
}]);