var goodsAddModule = angular.module('news.Article.add.service',[]);

goodsAddModule.service('news.Article.add', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
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
}]);