angular.module('basic.System.shopProcess.service',[

]).service('basic.System.shopProcess', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
       this.getshopProcess = function(){
        return $http({
            method: 'POST',
            url: HOST + '/basic/config/data',
            params: {group:'shopping'}
        });
    };
    this.shopProcessPost = function (item){
         return $http.post(HOST + '/basic/config/shopping/modify/1',item);
     }
}]);