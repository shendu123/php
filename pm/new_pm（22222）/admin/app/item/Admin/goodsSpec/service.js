angular.module('item.Admin.goodsSpec.service',[

]).service('item.Admin.goodsSpec', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){

    this.get = function(page, condition) {
//  	console.log(condition)
        return $http({
        	
            method: 'GET',
            url: HOST +'/goods/Category/catList'
//         params: condition
        });
    };
       this.getlist = function() {
//     	console.log('111')
        return $http({
            method: 'GET',
            url: HOST + '/goods/Category/catList',
           
        });
    };
    this.getlistchild=function(id) {
//     console.log(id)
        return $http({
            method: 'GET',
            url: HOST + '/goods/SpecItem/',
           params: {spec_id:id}
        });
    };
    this.getlistitem = function(id) {
      
        return $http({
            method: 'GET',
            url: HOST + '/goods/spec/',
           params: {cat_id:id}
        });
    };
        this.getgoodslistitem = function(id,specid) {
      
        return $http({
            method: 'GET',
            url: HOST + '/goods/SpecGoods/get_spec_goods',
           params: {goodsid:id,spec_type:specid}
        });
    };
      this.postitem = function(item) {
//    	console.log(item)
        return $http({
            method: 'POST',
            url: HOST + '/goods/SpecGoods/manage/',
           data:item
        });
    };
    //  this.remove = function (id) {
    //     return $http({
    //         method: 'post',
    //         url: HOST + '/goods/spec/del',
    //         params: {'id': id}
    //     });
    // };
}]);