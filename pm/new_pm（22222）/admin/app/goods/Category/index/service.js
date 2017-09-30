angular.module('goods.Category.index.service',[

]).service('goods.Category.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
    	console.log(condition)
        return $http({
            method: 'GET',
            url: HOST + '/goods/Category/index/p/0/s/10?toHtml=0',
            params: condition
        });
    };
    
    this.add = function (data) {
        return $http.post(HOST + '/goods/Category/add', data);
    };
    
    this.update = function (data) {
        return $http.post(HOST + '/goods/Category/edit', data);
    };

    this.remove = function (id) {
        return $http({
            method: 'DELETE',
            url: HOST + '/goods/Category/delete',
            params: {'id': id}
        });
    };
    this.getCatList = function(){
    	return $http.get(HOST + '/goods/Category/index');
    };
    
    //排序
    this.changeSort = function (id,cat_sort) {
        return $http({
            method: 'POST',
            url: HOST + '/goods/Category/changeSortOrShow',
            params: {'id': id,'cat_sort':cat_sort}
        });
    };
    //是否显示
    this.show = function (id,is_show) {
        return $http({
            method: 'POST',
            url: HOST + '/goods/Category/changeSortOrShow',
            params: {'id': id,'is_show':is_show}
        });
    };  
}]);