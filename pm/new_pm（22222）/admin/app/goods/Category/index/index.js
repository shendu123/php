angular.module('goods.Category.index', [

]).controller('controller.goods.Category.index',
["$http", "$scope", "$state", "$rootScope", "$stateParams", "utils", "API_WD_DOMAIN", "goods.Category.index", "treeRender",
function($http, $scope, $state, $rootScope, $stateParams, utils, HOST, categoryService , treeRender ) {
    $scope.categoryService = categoryService;
    $scope.utils = utils;
  //  '+ item.cat_icon[0].url +'
  $scope.cancel=function(){
  	
  }
    function initTable(){
        $('.tree-table').empty();
        categoryService.get().success(function( res ){
            $scope.nodes = res.slice(0);
            $scope.nodes.unshift({ id: 0  ,leaf: false  ,cat_name: "根" , pid : 0 , pname: "根"  });
            treeRender.renderTable( res  , null  , function(  item , icon ){
                var url = item.cat_icon && item.cat_icon[0] ? item.cat_icon[0].url : '' ;
                var img = '<img src="' + url  +'"/>' ;
                return  '<div class="table-list-inner">' +
                    '<div class=" row " data-id="'+ item.id +'">' +

                    '<div class="table-list-col col-xs-3 text-center tree-node">'+ icon + '&nbsp;&nbsp;' + item.cat_name  + ' </div>' +
                    '<div class="table-list-col col-xs-1">'+ item.pname +'</div>' +
                    '<div class="table-list-col col-xs-1">'+ item.goods_count +'</div>' +
                    '<div class="table-list-col col-xs-1"><a href="javascirpt:void(0);" tooltip-panel=""><img src="'+ url +'" alt="" style="height: 50px;"/><span class="tooltip-panel" style="display: none">'+ img +'</span></a></div>' +
                    '<div ng-show="{{userAuthority[4].userHave}}"  title="{{userAuthority[4].title}}" class="table-list-col col-xs-1" style="text-align:-webkit-center;"><input class="form-control" style="width:50px;" type="text" value="'+ item.cat_sort +'" ng-blur="changeSort('+ item.id +',$event)"></div>' +
                    '<div class="table-list-col col-xs-1"> <span class="checkbox-wrap"><input ng-show="{{userAuthority[3].userHave}}"  title="{{userAuthority[3].title}}" ng-click="show('+item.id+',$event)" type="checkbox" '+ (item.is_show==1? 'checked="checked"'  : '') +' class="checkbox-slide" ng-true-value="1" ng-false-value="0"  data-id="'+ item.id +'" /><label></label></span></div>' +
                    '<div class="table-list-col col-xs-1">'+ item.cat_recomend_tag +'</div>' +
                    '<div class="table-list-col col-xs-1">'+ item.cat_disable_tag +'</div>' +
                    '<div class="table-list-col col-xs-1">'+ item.cat_uptime_tag +'</div>' +
                    '<div class="table-list-col col-xs-1">' +
                    '<button ng-show="{{userAuthority[1].userHave}}"  title="{{userAuthority[1].title}}" class="btn btn-info btn-xs glyphicon glyphicon-edit btn-update" ></button>&nbsp;' +
                    '<button ng-show="{{userAuthority[2].userHave}}"  title="{{userAuthority[2].title}}" class="btn btn-danger btn-xs glyphicon glyphicon-remove-circle" ></button>' +
                    '</div>' +
                    '</div>' +
                    '<div class="row">' +
                    '<div class="table-list-children node-'+ ( item.id || 0 ) +'" style="display: none; padding-left: 20px;"></div>' +
                    '</div>' +
                    '</div>';
            } , $scope );
            $('.table-list').on('click' , '[type=checkbox]',function(){
                var _this = this;
                //$scope.show( $(this).data('id') ,($(this).prop('checked') ? 1 : 0 ) );
                // roleService.changeStatus( ($(this).prop('checked') ? 1 : 0 ), $(this).data('id')).success(function(res,status){
                //      if(status!=200){
                //      utils.message(res.error);
                //      $(_this).prop('checked' , !$(_this).prop('checked') );
                //      }
                //  })
            }).on('click','.btn-update', function(){
                $scope.item = $(this).closest('.table-list-inner').data('item');
                $scope.update( $scope.item );
            }).on('click','.glyphicon-remove-circle', function(){
                $scope.itemid = $(this).closest('.row').data('id');
                $scope.removeb( $scope.itemid );
            });
        })
    }
    initTable();

    $scope.$on('modalLoaded' , function( e, scope ){
        treeRender.renderList( $scope.nodes , null  , function(  item , icon ){
            return  '<li data-id="'+ item.id +'" class="dropdown-slide-item text-left tree-node">' +
                '<a href="javascript:void(0)">'+ icon + '&nbsp;<span class="dropdown-tag">' + item.cat_name + '</span></a>' +
                '<div class="dropdown-slide-children node-'+ ( item.id || 0 ) +'" style="display:none;padding-left: 5px;"></div>' +
                '</li> ';
        } , $scope );
    });
    
    $(document).bind('click',function(e){
        var $target = $(e.target);
        if($target[0].className != 'btn  dropdown-toggle ng-binding'){
            $('.dropdown-menu').hide();            
        }

    })
    $scope.$on('modalUpdateSuccess' , function( e, scope ){
        initTable();
    });
    $scope.$on('modalAddSuccess' , function( e, scope ){
        initTable();
    });
    $scope.removeb = function (id) {
        $.MsgBox.Confirm("操作提示", "该操作不可恢复,确定要删除？", function(){
            $http({
                method: 'DELETE',
                url: HOST+ '/goods/Category/delete',
                params: {'id': id}
            }).success(function(res,status){
                if(status != 200){
                    utils.message(res.error);
                }else{
                    $.MsgBox.tipbox("操作提示", "删除成功");
                    initTable();
                }
            });
        });        
    };
    $scope.deleteAll=function(){
        var ids = fdCheckGet("ids[]");
        $scope.removeb(ids);       
    }


    $scope.ableAll = function (value){
    	var ids = fdCheckGet("ids[]");
        $http({
            method  : 'POST',
            url     : HOST + '/goods/Category/ableAll',
            data	: { ids: ids ,value: value},
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' }  
        }).success(function(data) {
            $.MsgBox.Alert("操作提示", data.msg, function(){
                initTable();
            });
        });
    };
    
    categoryService.getCatList().success(function (catList) {
        $rootScope.catList = catList.data;
    });
    
    //排序
    $scope.changeSort = function (id,event) {
        var sort=$(event.target).val();
        categoryService.changeSort(id,sort).success(function(res,status){
            if(status==200){
                $.MsgBox.tipbox("操作提示", "修改成功");
                initTable();
            }else{
                utils.message(res.error);
            }
        })       
    };
    //是否显示
    $scope.show = function (id,event) {
        var checked=$(event.target).prop('checked');
        var is_show = checked == true ? 1 : 0;
        categoryService.show(id,is_show).success(function(res,status){
            if(status==200){
               //$state.reload();
                initTable();
            }else{
                utils.message(res.error);
            }
        });            
    };
    
    
}]);
