angular.module('user.Role.index.directive',['basic.Role.index.service']).directive("selectRole" , [ "basic.Role.index", "$timeout", function( roleService, $timeout){
    return {
        require: '?ngModel',
        link: function( $scope, elm, attrs, ctrl ) {
            roleService.get().success(function( res ) {
                $scope.roles = res.data ;
            });
        }
    };
}]).filter('trustHtml', function($sce) {
    return function (input) {
        return $sce.trustAsHtml(input);
    }
});

