angular.module('operator.Operator.secondOperatorData', [

]).controller('controller.operator.Operator.secondOperatorData', [ "$http","$scope" ,"$rootScope" , "$stateParams", "utils", "$state","$compile", "operator.Operator.secondOperatorData", function($http,$scope, $rootScope, $stateParams, utils, $state, $compile,secOperatorService) {
    $scope.secOperatorService = secOperatorService;
    $scope.utils = utils;

    $rootScope.$on('modalUpdateSuccess', function (e, $scope ,data) {
        $state.reload();
    })
}]);
