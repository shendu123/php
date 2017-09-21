angular.module('basic.System.webConfig.service',[

]).service('basic.System.webConfig', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
     this.webConfig = function (){
         return $http.get(HOST + '/basic/System/webConfig');
     }
     this.webConfigPost = function (item){
         return $http.post(HOST + '/basic/System/webConfig',item);
     }
}]);