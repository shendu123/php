angular.module('adv.Adv.index.service',[

]).service('adv.Adv.index', [ "$http" ,"$state", "API_WD_DOMAIN" ,function( $http ,$state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/adv/Adv/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };
    this.add = function (article) {
        return $http.post(HOST + '/adv/Adv/add', article).success(function(res,status){
            if(status==!200){
                
            }else{
                $state.reload();
            }
        });   
    }; 
    this.update = function (article) {
        return $http.post(HOST + '/adv/Adv/edit', article);
    };
   
    this.getCatList = function(){
    	return $http.get(HOST + '/adv/Adv/index');
    };
    
}]);