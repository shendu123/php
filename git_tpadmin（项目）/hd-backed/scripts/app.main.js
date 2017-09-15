'use strict';
angular.module('app').controller('AppCtrl', ['$rootScope','$scope', '$http', '$localStorage', '$timeout','$cookieStore','$translate','$state',
  function AppCtrl($rootScope,$scope, $http, $localStorage, $timeout,$cookieStore,$translate,$state) {
    $scope.mobileView = 767;
    $scope.app = {
      name: 'Reactor',
      author: 'Nyasha',
      version: '1.0.0',
      year: (new Date()).getFullYear(),
      layout: {
        isSmallSidebar: false,
        isChatOpen: false,
        isFixedHeader: true,
        isFixedFooter: false,
        isBoxed: false,
        isStaticSidebar: false,
        isRightSidebar: false,
        isOffscreenOpen: false,
        isConversationOpen: false,
        isQuickLaunch: false,
        sidebarTheme: '',
        headerTheme: ''
      },
      isMessageOpen: false,
      isContactOpen: false,
      isConfigOpen: false
    };
    
    $rootScope.statGoto = function(gotou) {
        $state.go(gotou,{},{reload:true});
    };
    
//   if(!$cookieStore.get("account")) {
//       //$state.go('user.signin');
//       $.get(apiHost+'/admin/login/checkLogin')
//         .success(function(data) {
//           if(data.message){
//               $state.go('user.signin');
//           }
//       });        
//     }else{//alert("fd");
//            $rootScope.leftMenu=getData(apiHost+'/admin/admin_index/menu');
//            $rootScope.authList=getData(apiHost+'/admin/admin_index/auth');
//            $rootScope.authControl=getData(apiHost+'/admin/admin_index/auth2');           
//            $rootScope.user = {
//                fname: $cookieStore.get("account"),
//                jobDesc: 'Human Resources Guy',
//                avatar: 'images/avatar.jpg',
//            };
//     }

    if (angular.isDefined($localStorage.layout)) {
      $scope.app.layout = $localStorage.layout;
    } else {
      $localStorage.layout = $scope.app.layout;
    }

    $scope.$watch('app.layout', function() {
      $localStorage.layout = $scope.app.layout;
    }, true);

    $scope.$on('$viewContentLoaded', function() {
      angular.element('.pageload').fadeOut(150);
      $timeout(function() {
        angular.element('body').removeClass('page-loading');
      }, 200);
    });

    $scope.getRandomArbitrary = function() {
      return Math.round(Math.random() * 100);
    };
    

      $rootScope.signOut = function() {
         // alert("e");
       $.get(apiHost+'/admin/login/logout')
         .success(function(data) {
             if(data.message){
                $cookieStore.put("account",'');
                $state.go('user.signin');
             }  
       })
      };
      
    $rootScope.changeStatus = function(url,data){
        var url=apiHost+url;
        var status=data.status==1?0:1;
        $.post(url, {
          id:data.uid?data.uid:data.id,
          status:status
        })
        .success(function(data) {
          if(data.tip){
            //$scope.data = getData(index_url);
            //$scope.tableParams.reload();
            $rootScope.showNoty(data);
          }else{

          }
        });
   };     


     $rootScope.in_array=function (search,array){
        for(var i in array){
            if(array[i]==search){
                return true;
            }
        }
        return false;
    }
    
    Array.prototype.remove = function(val) {  
        var index = this.indexOf(val);  
        if (index > -1) {  
            this.splice(index, 1);  
        }  
    };
    
    $rootScope.showNoty = function(_data) {
      noty({
        theme: 'app-noty',
        text: _data.tip,
//        type: _data.chg,//       
         type:'error',

        timeout: 3000,
        layout: "bottomLeft",
        closeWith: ['button', 'click'],
        animation: {
          open: 'in',
          close: 'out'
        },
      });
    };

    $rootScope.postData = function(data,type,url,id){
      $.post('/ad/data/saveData', {
        type:type,
        data:data
      })
      .success(function(data) {
        var data = $.parseJSON(data);
        if(data.chg == 'success'){
          $rootScope.statGoto(url);
        }else{
          $cookieStore.put(id,data.id);
        }
        $rootScope.showNoty(data);
      });
    };





    $scope.setLang = function(langKey) {
      $translate.use(langKey);
    };
  }
]);