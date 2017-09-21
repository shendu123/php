angular.module('operator.Operator.addSecondOperator.service',[

]).service('operator.Operator.addSecondOperator', [ "$http" , "$state", "API_WD_DOMAIN" ,function( $http , $state,HOST){

    
    this.percent = function() {
        return $http({method: 'GET',url: HOST + '/pay/Operator/percent/'});
    };
    
    this.add = function (user) {
        return $http.post(HOST + '/pay/Operator/addSecondOperator', user);  
    }; 
   
}]);