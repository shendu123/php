angular.module('basic.User.index.service',[

]).service('basic.User.index', [ "$http" , "$state", "API_WD_DOMAIN" ,function( $http , $state, HOST){

    this.get = function(page, condition) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/User/index/p/'+page['currentPage']+'/s/'+page['pageSize'],
            params: condition
        });
    };

    this.add = function (user) {
        return $http.post(HOST + '/basic/User/add', user).success(function(res,status){ $state.reload();});
    };

    this.update = function (user) {
        return $http.post(HOST + '/basic/User/edit', user).success(function(res,status){ 
            $state.reload();
        });
    };
    
    this.check = function (user) {
        return $http({
            method: 'GET',
            url: HOST + '/basic/User/check',
            params: user
        });
    };
    
    this.checkSub = function (uid,status,checkmsg) {
        return $http({
            method: 'POST',
            url: HOST + '/basic/User/check',
            params: {'uid': uid,'status':status,'checkmsg':checkmsg}
        });
    };
    
    this.changePwdSub = function (uid,oldPwd,newPwd) {
        return $http({
            method: 'POST',
            url: HOST + '/basic/User/changePwd',
            params: {'uid': uid,'oldPwd':oldPwd,'newPwd':newPwd}
        });
    };

    this.delete = function (user) {
        return $http.delete(HOST + '/basic/User/delete', user);
    };
    
    this.roleList = function() {
        return $http({
            method: 'GET',
            url: HOST + '/basic/Role/index?toHtml=0',
            params: {}
        });
    };
    
     
}]);