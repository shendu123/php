'use strict';
angular.module('app').run(['$rootScope', '$state', '$stateParams','$cookieStore',
  function($rootScope, $state, $stateParams,$cookieStore) {
    $rootScope.$state = $state;
    $rootScope.$stateParams = $stateParams;
    $rootScope.$on('$stateChangeStart',function(event, toState, fromState) {
        
    });

    $rootScope.$on('$stateChangeSuccess', function() {
        if(!$cookieStore.get("account")) {
            //$state.go('user.signin');
            $.get(apiHost+'/admin/login/checkLogin')
              .success(function(data) {
                if(data.message){
                    $state.go('user.signin');
                }
            });        
          }else{//alert("fd");
                 $rootScope.leftMenu=getData(apiHost+'/admin/admin_index/menu');
                 $rootScope.authList=getData(apiHost+'/admin/admin_index/auth');
                 $rootScope.authControl=getData(apiHost+'/admin/admin_index/auth2');           
                 $rootScope.user = {
                     fname: $cookieStore.get("account"),
                     jobDesc: 'Human Resources Guy',
                     avatar: 'images/avatar.jpg',
                 };
          }
      window.scrollTo(0, 0);
    });
    FastClick.attach(document.body);
  },
]).config(['$stateProvider', '$urlRouterProvider',
  function($stateProvider, $urlRouterProvider) {
    // For unmatched routes
    $urlRouterProvider.otherwise('/index');
    // Application routes
    $stateProvider
      .state('app', {
        abstract: true,
        templateUrl: 'views/common/layout.html',
        resolve: {
           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/sweetalert/dist/sweetalert.css']
            }, {
              files: ['vendor/sweetalert/dist/sweetalert.min.js', 'vendor/angular-sweetalert/SweetAlert.min.js']
            }]).then(function() {
              // return $ocLazyLoad.load('scripts/controllers/news.js');
            });
          }]
        },
      })
      .state('user', {
        templateUrl: 'views/common/signin.html',
      })
      .state('user.signin', {
        url: '/signin',
        templateUrl: 'views/signin.html',
        resolve: {
          deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load('scripts/controllers/signin.js');
          }]
        },
        data: {
          appClasses: 'signin usersession',
          contentClasses: 'session-wrapper'
        }
      })   
      
      .state('app.index', {
        url: '/index',
        templateUrl: 'views/index.html',
        resolve: {
          deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              serie: true,
              files: ['vendor/flot/jquery.flot.js', 'vendor/flot/jquery.flot.resize.js', 'vendor/flot/jquery.flot.pie.js', 'vendor/flot/jquery.flot.categories.js', 'vendor/flot/jquery.flot.stack.js', 'vendor/flot/jquery.flot.time.js', 'vendor/flot-spline/js/jquery.flot.spline.js', 'vendor/flot.orderbars/js/jquery.flot.orderBars.js']
            }, {
              name: 'angular-flot',
              files: ['vendor/angular-flot/angular-flot.js']
            }]).then(function() {
              //return $ocLazyLoad.load('scripts/controllers/dashboard.js');
            });
          }]
        }
      })
      
            // role Routes
      .state('app.role', {
        url: '/role',
        template: '<div ui-view></div>',
        abstract: true,
      })
      .state('app.role.index', {
        url: '/index',
        templateUrl: 'views/role/index.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js','vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js', 
'vendor/jquery.ui/ui/core.js', 'vendor/jquery.ui/ui/widget.js', 
'vendor/jquery.ui/ui/mouse.js', 'vendor/jquery.ui/ui/sortable.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/role.js');
            });
          }]
        },
      })
      .state('app.role.addrole', {
        url: '/addrole',
        templateUrl: 'views/role/addrole.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-file-upload/ng-file-upload-all.js','vendor/checkbo/src/0.1.4/js/checkBo.min.js']
            }]).then(function() {
            return $ocLazyLoad.load('scripts/controllers/role_ea.js');
            });
          }]
        },
      })
      .state('app.role.role_user_list', {
        url: '/role_user_list',
        templateUrl: 'views/role/role_user_list.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-file-upload/ng-file-upload-all.js','vendor/checkbo/src/0.1.4/js/checkBo.min.js']
            }]).then(function() {
            return $ocLazyLoad.load('scripts/controllers/role_user_list.js');
            });
          }]
        },
      })
      
       .state('app.role.role_access', {
        url: '/role_access',
        templateUrl: 'views/role/role_access_list.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-file-upload/ng-file-upload-all.js','vendor/checkbo/src/0.1.4/js/checkBo.min.js']
            }]).then(function() {
            return $ocLazyLoad.load('scripts/controllers/role_access.js');
            });
          }]
        },
      })
      

      // user Routes
      .state('app.user', {
        url: '/user',
        template: '<div ui-view></div>',
        abstract: true,
      })
      .state('app.user.index', {
        url: '/index',
        templateUrl: 'views/user/index.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js','vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js', 
'vendor/jquery.ui/ui/core.js', 'vendor/jquery.ui/ui/widget.js', 
'vendor/jquery.ui/ui/mouse.js', 'vendor/jquery.ui/ui/sortable.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/user.js');
            });
          }]
        },
      })
      .state('app.user.adduser', {
        url: '/adduser',
        templateUrl: 'views/user/adduser.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-file-upload/ng-file-upload-all.js','vendor/checkbo/src/0.1.4/js/checkBo.min.js']
            }]).then(function() {
            return $ocLazyLoad.load('scripts/controllers/user_ea.js');
            });
          }]
        },
      })
      //privilege
      .state('app.privilege', {
        url: '/privilege',
        template: '<div ui-view></div>',
        abstract: true,
      })
      .state('app.privilege.list', {
        url: '/privilegelist',
        templateUrl: 'views/privilege/privilege_list.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/privilege_list.js');
            });
          }]
        },
      })
      

      // role Routes
      .state('app.node', {
        url: '/node',
        template: '<div ui-view></div>',
        abstract: true,
      })
      .state('app.node.index', {
        url: '/index',
        templateUrl: 'views/node/index.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js','vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js', 
'vendor/jquery.ui/ui/core.js', 'vendor/jquery.ui/ui/widget.js', 
'vendor/jquery.ui/ui/mouse.js', 'vendor/jquery.ui/ui/sortable.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/node.js?v=1.0');
            });
          }]
        },
      })
      .state('app.node.addnode', {
        url: '/addnode',
        templateUrl: 'views/node/addnode.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js','vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js', 
'vendor/jquery.ui/ui/core.js', 'vendor/jquery.ui/ui/widget.js', 
'vendor/jquery.ui/ui/mouse.js', 'vendor/jquery.ui/ui/sortable.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/node_ea.js');
            });
          }]
        },
      })
      
       .state('app.node.addChild', {
        url: '/addChild',
        templateUrl: 'views/node/addnode.html',
        resolve: {

           deps: ['$ocLazyLoad', function($ocLazyLoad) {
            return $ocLazyLoad.load([{
              insertBefore: '#load_styles_before',
              files: ['vendor/ng-table/dist/ng-table.css','vendor/angular-xeditable/dist/css/xeditable.css']
            }, {
              name: 'ngTable',
              files: ['vendor/ng-table/dist/ng-table.js','vendor/angular-xeditable/dist/js/xeditable.js','vendor/ng-file-upload/ng-file-upload-all.js','vendor/perfect-scrollbar/js/perfect-scrollbar.jquery.js', 
'vendor/jquery.ui/ui/core.js', 'vendor/jquery.ui/ui/widget.js', 
'vendor/jquery.ui/ui/mouse.js', 'vendor/jquery.ui/ui/sortable.js']
            }]).then(function() {
              return $ocLazyLoad.load('scripts/controllers/node_ea.js?v=1.1');
            });
          }]
        },
      });;

  }
]).config(['$ocLazyLoadProvider', function($ocLazyLoadProvider) {
  $ocLazyLoadProvider.config({
    debug: false,
    events: false
  });
}]);