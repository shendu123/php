angular.module('pay.Pay.index.service',[

]).service('pay.Pay.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
    this.get = function(page, condition) {
    	
    	$.extend(condition,{page:page['currentPage'],pageSize:page['pageSize']});
    	console.log(condition)
    
        return $http({
            method: 'POST',
            url: HOST + '/finance/flow/fund',
            params: {page:page['currentPage'],pageSize:page['pageSize']}
//          {page:page['currentPage'],pageSize:page['pageSize'],...condition}
        });
    };
}]);