angular.module('crowd.Admin.index.service',[

]).service('crowd.Admin.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
    	console.log(condition)
        return $http({
            method: 'GET',
            url: HOST + '/crowd/Admin/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/crowd/Admin/detail?id='+id
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/crowd/Admin/check',
            params: {'id': id,'value':value,'reason':reason}
        });
    };
    
    this.getGoodsCatList = function (){
    	return $http.get(HOST + '/goods/Category/catList');
    }
    
    this.getRecpositionList = function (){
    	return $http.get(HOST + '/goods/Recposition/index');
    }
    
        // 上/下架
    this.onsale = function (id,value) {
        return $http({
            method: 'POST',
            url: HOST + '/crowd/Admin/onsale',
            params: {'id': id,'value':value}
        });
    };
    
    //排序
    this.changeSort = function (id,crowd_sort) {
        return $http({
            method: 'POST',
            url: HOST + '/crowd/Admin/changeCrowdSort',
            params: {'id': id,'crowd_sort':crowd_sort}
        });
    }; 
}]);