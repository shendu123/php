angular.module('item.Admin.goodsSpec', [

]).controller('controller.item.Admin.goodsSpec', ["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", '$modal', "API_WD_DOMAIN", "item.Admin.goodsSpec", function($http, $scope, $state, $rootScope, $stateParams, utils, $modal, HOST, specService) {
    $scope.specService = specService;
    $scope.utils = utils;
   $scope.guige=[];
   var idarray=[];
   var newguige=[]
   $scope.iteminfo={goodsid:$stateParams.goods_id}
    $scope.$watch('guige',function(newValue,oldValue){
//        console.log($('.formgetdata'))
     
    });

    $scope.dataid=[]
 
         specService.get().success(function (info) {
        console.log(info);
        $scope.list=info;
//        $scope.classify=$stateParams.id;
          
//        $scope.listselect(info.data[0].id)
//      $scope.listitem=info;
    })
          
    $scope.sbmit=function(keyvalue){
    	var data={}
    	
    	var xx=  $('.formgetdata').map(function(){
        var s=	$(this).parents('.getgoodid').map(function(){
        		return	$(this).data('id')
        	}).get()
         var itemname =	$(this).parents('.getgoodid').map(function(){
        		return	$(this).data('itemname')
        	}).get()
        	var itemnames=itemname.join(',')
        	$(this).find('input').eq(0).val(itemnames)
        	
        	var m=s.sort().reverse().join('_')
        	console.log(m)
        	$(this).data('n',m)
        	var keyname ='item['+m+'][key_name]';
        	 var price='item['+m+'][price]';
        	 var inventory='item['+m+'][inventory]';
        	 $(this).attr('name',m)
        	$(this).find('input').eq(0).attr('name',keyname)
        	$(this).find('input').eq(1).attr('name',price)
        	$(this).find('input').eq(2).attr('name',inventory)
//      var data=$(this).serialize();
//var data=new FormData(this);


data[keyname]=$(this).find('input').eq(0).val();
data[price]=$(this).find('input').eq(1).val();
data[inventory]=$(this).find('input').eq(2).val();
data.goodsid=$stateParams.goods_id
//data.goodsid=$stateParams.goods_id
//data.append("goodsid",$stateParams.goods_id)


   console.log(data)     
  
     
        	return m
        }).get()
        console.log(data)
              if(keyvalue==true){
        	   specService.postitem(data).success(function(data) {
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
        console.log(xx)
        
    }
  $scope.$on('ngRepeatFinishedguige', function (ngRepeatFinishedEvent) {
  	
          //下面是在table render完成后执行的js
          setTimeout(function(){
          	        $('.item-goodsSpec-btn').map(function(){
//          	console.log($(this).data('id'))
var _this=$(this)
            $scope.spec_goods2.forEach(function(ites){
            
            	   if(_this.data('id')==ites)
       {
       	console.log('我成功了')
       	_this.click()
       }
            })
        	
       return $(this).data('id')
        }) 
          },500)
    
         console.log('heihei')

          
       
});
 $scope.$on('ngRepeatFinished', function (ngRepeatFinishedEvent) {
  	
    
    
        
      $scope.sbmit(false)
      var spec_goods=$scope.spec_goods
        var itemn =	$('.formgetdata').map(function(){
        	   for (var ite in spec_goods) {
        	   	  if(ite==$(this).attr('name')){
        	   	  	$(this).find('input').eq(1).val(spec_goods[ite].price)
        	   	  	$(this).find('input').eq(2).val(spec_goods[ite].total)
        	   	  	break;
        	   	  }
        	   }
        		return	$(this).data('id')
        	}).get()   
       
});
//  var n='';
    
    var guige=[{id:0,child:[]}]
    var arryn=[]
$scope.itemchildselect=function($event,itemid,itemname,childid){
//	console.log(itemid)
	var leng=guige.length
	for(var i=0;i<leng;i++){
//		console.log(guige[i])

		if(guige[i].id==itemid){
			for(var t=0;t<guige[i].child.length;t++){
    if(guige[i].child[t].id==childid){
       guige[i].child.splice(t,1)
        break
    }else{
    	if(t==guige[i].child.length-1)
    	{guige[i].child.push({itemname:itemname,id:childid});
    	  break;
    	}
  
    }
}
//				  if(guige[i].child.indexOf(itemname)==-1){
//  	
//  	guige[i].child.push(itemname);
//  }else{
//  	guige[i].child.splice(guige.indexOf(itemname),1)
//  }
			
			break;
		}else{
			if(i==guige.length-1){
				guige.push({id:itemid,child:[{itemname:itemname,id:childid}]});
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
	newguige=guige

	$scope.guige=guige.reduce(function(a,b,index,arr){
		if(a.length==0){
			for (var i=0;i<b.child.length;i++) {
				a.push({value:b.child[i].itemname,child:[],id:b.child[i].id})
			}
			return a
		}else{
		      var sun=[]
            for (var j=0;j<b.child.length;j++) {
            	sun.push({value:b.child[j].itemname,child:a,id:b.child[j].id})
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
 
// if(arryn.indexOf(itemid)==-1){
//  	
//  	arryn.push(itemid)
//  }else{
//  	arryn.splice(arryn.indexOf(itemid),1)
//  }
//   arryn.sort()
//   
//		n=arryn.join('_');
//	
//	console.log(n)
//	$scope.key_name='item['+n+'][key_name]'
//	console.log($('#item-goodsSpec-form .btn-primary'))

//		$('#item-goodsSpec-form .btn-primary').map(function(){
//			
//			 $scope.guige.push($(this).text())
//		})


  
	
//	$scope.price='item['+n+'][price]';
//	$scope.inventory='item['+n+'][inventory]';
	$($event.target).toggleClass('btn-primary')
	
}
// 	$('tbody').on('click','.item-goodsSpec-btn',function(){
//			console.log('sss')
//			$(this).toggleClass('btn-primary')
//		})
    console.log($stateParams)
  
    var listupdate=[];

        specService.getgoodslistitem($stateParams.goods_id,$stateParams.spec_type).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.spec
        $scope.spec_goods2=info.result.spec_goods2;
        $scope.spec_goods=info.result.spec_goods;
        $scope.listitem.forEach(function(currentValue){
        	$scope.listchild(currentValue.id,currentValue.name)
        })
     
    })
        
//  specService.getlist().success(function (info) {
//      console.log(info);
////      $scope.list=info;
//  })
    
    $scope.listselect=function(id){
      $scope.spec_goods2=[]
    	$scope.spec_goods={}
    	$scope.guige=[]
    	guige=[{id:0,child:[]}]
    	$('.item-goodsSpec-btn').removeClass('btn-primary')
    	specService.getlistitem(id).success(function (info) {
        console.log(info);
        $scope.listitem=info.result.data;
        

    })
 
    }

var listch={};

    $scope.listchild=function(id,itname){
         
    	specService.getlistchild(id).success(function (info) {
//      console.log(info);
listch[itname]=info.result.data
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
//      $scope.iteminfo[key_name]=$scope.guige.join()
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

   
    
}]).directive('onfinishrende', function ($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function() {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    };
}).directive('onfinishguige', function ($timeout) {
    return {
        restrict: 'A',
        link: function(scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function() {
                    scope.$emit('ngRepeatFinishedguige');
                });
            }
        }
    };
});
