angular.module('item.Admin.index.service',[

]).service('item.Admin.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/item/Admin/index/page/'+page['currentPage']+'/pageSize/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getDetail = function(id){
        return $http({
            method: 'GET',
            url: HOST + '/item/Admin/detail?id='+id
        });
    };
    
    this.checkSub = function (id,value,reason) {
        return $http({
            method: 'POST',
            url: HOST + '/item/Admin/check',
            params: {'id': id,'item_check':value,'item_check_reason':reason}
        });
    };
    
    this.getGoodsCatList = function (){
    	return $http.get(HOST + '/goods/Category/index');
    }
    
    this.getRecpositionList = function (){
    	return $http.get(HOST + '/goods/Recposition/index');
    }
    // 上/下架
    this.onsale = function (id,item_onsale) {
        return $http({
            method: 'POST',
            url: HOST + '/item/Admin/onsale',
            params: {'id': id,'item_onsale':item_onsale}
        });
    };
    //排序
    this.changeSort = function (id,item_sort) {
        return $http({
            method: 'POST',
            url: HOST + '/item/Admin/changeSortOrRec',
            params: {'id': id,'item_sort':item_sort}
        });
    };
    //推荐
    this.recommend = function (id,item_is_recommend) {
        return $http({
            method: 'POST',
            url: HOST + '/item/Admin/changeSortOrRec',
            params: {'id': id,'item_is_recommend':item_is_recommend}
        });
    };  
    
}]);