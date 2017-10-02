angular.module('basic.System.distributionSet.service',[

]).service('basic.System.distributionSet', [ "$http" , "API_WD_DOMAIN" ,function( $http , HOST){
     // this.webConfig = function (){
     //     return $http.get(HOST + '/basic/System/distributionSet');
     // }
     this.getwebInfo = function(){
        return $http({
            method: 'POST',
            url: HOST + '/basic/config/data',
           params: {group:'bonus'}

 
        });
    };
     this.distributionSetPost = function (item){
         return $http.post(HOST + '/basic/config/distribution/modify/1',item);
     }
}]);