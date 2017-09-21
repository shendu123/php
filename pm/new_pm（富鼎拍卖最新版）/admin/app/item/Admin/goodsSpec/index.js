angular.module('item.Admin.goodsSpec', [

]).controller('controller.item.Admin.goodsSpec', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "item.Admin.goodsSpec", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, specService) {
    $scope.specService = specService;
    $scope.utils = utils;
   $scope.guige=[];
   $scope.iteminfo={goodsid:$stateParams.goods_id}
   
    var n='';
    var key_name='';
    var guige=[{id:0,child:[]}]
$scope.itemchildselect=function($event,itemid,itemname){
//	console.log(itemid)
	var leng=guige.length
	for(var i=0;i<leng;i++){
//		console.log(guige[i])

		if(guige[i].id==itemid){
				  if(guige[i].child.indexOf(itemname)==-1){
    	
    	guige[i].child.push(itemname);
    }else{
    	guige[i].child.splice(guige.indexOf(itemname),1)
    }
			
			break;
		}else{
			if(i==guige.length-1){
				guige.push({id:itemid,child:[itemname]});
				break;
			}
			
			continue;
			
		}
	}
	guige.sort(function(a,b){
		return b.child.length-a.child.length
	})
	if(guige[guige.length-1].child.length==0){
		guige.pop()
	}
	
	console.log(guige)
	

	$scope.guige=guige.reduce(function(a,b,index,arr){
		if(a.length==0){
			for (var i=0;i<b.child.length;i++) {
				a.push({value:b.child[i],child:[]})
			}
			return a
		}else{
		      var sun=[]
            for (var j=0;j<b.child.length;j++) {
            	sun.push({value:b.child[j],child:a})
            }
//				for (var j=0;j<a.length;j++) {
//
//				
//			for (var z=0;z<b.child.length;z++) {
//				
//				a[j].child.push({value:b.child[z],child:[]})
//			}
//		
//			
//		}
		}
	
		return sun;
		
	},[])
//	for(var i=0;i<guige.length-1;i++){
//		for (var j=0;j<guige[i].child.length;j++) {
//			{value:guige[i].child[j],child:guige[i+1].child}
//		}
//	}
console.log($scope.guige)
		n=n+'_'+itemid;
	
	
	key_name='item['+n+'][key_name]'
//	console.log($('#item-goodsSpec-form .btn-primary'))

//		$('#item-goodsSpec-form .btn-primary').map(function(){
//			
//			 $scope.guige.push($(this).text())
//		})


  
	
	$scope.price='item['+n+'][price]';
	$scope.inventory='item['+n+'][inventory]';
	$($event.target).toggleClass('btn-primary')
	
}
// 	$('tbody').on('click','.item-goodsSpec-btn',function(){
//			console.log('sss')
//			$(this).toggleClass('btn-primary')
//		})
    console.log($stateParams)
  
    var listupdate=[];
        specService.get().success(function (info) {
        console.log(info);
        $scope.list=info;
          $scope.classify=$stateParams.id
//      $scope.listitem=info;
    })
        specService.getlistitem($stateParams.goods_id).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.data;
    })
        
//  specService.getlist().success(function (info) {
//      console.log(info);
////      $scope.list=info;
//  })
    
    $scope.listselect=function(id){
    	specService.getlistitem(id).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.data;
        

    })
 
    }

var listch=[];
    $scope.listchild=function(id){
 
    	specService.getlistchild(id).success(function (info) {
        console.log(info);
        listch[id-1]=info.result.data
//     listch.push(info.result.data);
        
         $scope.listchilditem=listch;
    })
    	 }
    
    $scope.listupdate=function(id,name){
    	var leng=listupdate.length;
	if(listupdate[0]){
		
	
    	
    	  for (var i=0;i<leng;i++) {
    	  	if(listupdate[i].id==id){
    	  		listupdate[i]={id:id,item:name}
    	  	}else{
    	  		listupdate.push({id:id,item:name})
    	  	}
    	  	
    	  }
    	}else{
    		listupdate.push({id:id,item:name})
    	}
    	
    	}
    $scope.updateitem=function(currentValue){
        $scope.iteminfo[key_name]=$scope.guige.join()
    	console.log(currentValue);
    		
    		specService.postitem(currentValue).success(function(data) {
                if(data.status == '200'){
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }else{
                    $.MsgBox.Alert("操作提示", data.msg, function(){
//                      $modalInstance.dismiss('cancel');
                        $state.reload();
                    });
                }
            });
    	
    	
    }

   
    
}]);
