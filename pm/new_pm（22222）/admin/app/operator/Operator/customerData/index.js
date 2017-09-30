angular.module('operator.Operator.customerData', [

]).controller('controller.operator.Operator.customerData', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "operator.Operator.customerData", function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,customerDataService) {
    $scope.customerDataService = customerDataService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    })
}]);
