angular.module('news.Article.index.service',[

]).service('news.Article.index', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/news/Article/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.add = function (article) {
        return $http.post(HOST + '/news/Article/add', article).success(function(res,status){ $state.reload();});
    }; 
    this.update = function (article) {
        return $http.post(HOST + '/news/Article/edit', article);
    };
   
    this.getCatList = function(){
    	return $http.get(HOST + '/news/Category/index');
    };
    //是否显示
    this.show = function (id,is_show) {
        return $http({
            method: 'POST',
            url: HOST + '/news/Article/changeRecOrShow',
            params: {'id': id,'is_show':is_show}
        });
    }; 
    //是否推荐
    this.recommend = function (id,is_recommend) {
        return $http({
            method: 'POST',
            url: HOST + '/news/Article/changeRecOrShow',
            params: {'id': id,'is_recommend':is_recommend}
        });
    }; 
    
}]);