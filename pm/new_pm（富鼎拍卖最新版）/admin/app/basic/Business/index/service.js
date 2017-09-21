angular.module('basic.Business.index.service',[

]).service('basic.Business.index', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Business/index/page/'+page['currentPage']+'/page_size/'+page['pageSize'],
            params: condition
        });
    };
    
    //排序
    this.changeSort = function (business_id,sort) {
        return $http({
            method: 'POST',
            url: HOST + '/basic/Business/changeSortOrRec',
            params: {'business_id': business_id,'business_sort':sort}
        });
    };
    //是否推荐、店铺状态、店铺商品是否在商城展示、店铺是否在商城展示
    this.changeStatus = function (business_id,field_status){
        return $http({
            method: 'POST',
            url: HOST + '/basic/Business/changeSortOrRec',
            params: {'business_id': business_id,field_status:field_status}
        });
    }
}]);