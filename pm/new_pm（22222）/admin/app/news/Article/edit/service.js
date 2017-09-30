var goodsAddModule = angular.module('news.Article.edit.service',[]);

goodsAddModule.service('news.Article.edit', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/news/Article/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    
    this.getCatList = function(){
    	return $http.get(HOST + '/news/Category/index');
    };
    this.edit = function(id){
        return $http.get(HOST + '/news/Article/edit?id='+id);
    };
}]);