angular.module('news.Category.index.service',[

]).service('news.Category.index', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http , $state,HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/news/Category/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.add = function (article) {
        return $http.post(HOST + '/news/Category/add', article).success(function(res,status){ $state.reload();});
    }; 
    this.update = function (article) {
        return $http.post(HOST + '/news/Category/edit', article).success(function(res,status){ $state.reload();});;
    };
   
    this.getCatList = function(){
    	return $http.get(HOST + '/news/Category/index');
    };
    //排序
    this.changeSort = function (id,sort) {
        return $http({
            method: 'POST',
            url: HOST + '/news/Category/changeSortOrShow',
            params: {'id': id,'sort':sort}
        });
    };
    //是否显示
    this.show = function (id,is_show) {
        return $http({
            method: 'POST',
            url: HOST + '/news/Category/changeSortOrShow',
            params: {'id': id,'is_show':is_show}
        });
    }; 
   
}]);