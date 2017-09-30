angular.module('goods.Brandapply.index.service',[

]).service('goods.Brandapply.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/goods/Brandapply/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/catList');
    };
    
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Brandapply/add', data);
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Brandapply/edit', data);
    };
    
    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Brandapply/delete',
            params: {'id': id}
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/goods/Brandapply/check',
            params: {'id': id,'value':value,'reason':reason}
        });
    };
}]);