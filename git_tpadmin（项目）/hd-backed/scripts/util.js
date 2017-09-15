
var apiHost="http://www.open.zxl";
function getData(url,id){
   // console.log(url);
    var _id = id || null;
    var res = '';
	$.ajax({
        url: url,
        async: false,
        type: "get",
        data: _id,
        dataType:'json',
        success: function(json){
        	if(!json.message){
				res = json.data;
        	}else{
        		res = json.message;
        	}
        }
    });
    return res;
}



function getDataChexing(url,id){
    var _id = id || null;
    var res = false;
    $.ajax({
        url: url,
        async: false,
        type: "post",
        data: _id,
        dataType:'json',
        success: function(json){
            res = true;
        }
    });
    return res;
}