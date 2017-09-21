//@action: 选中和取消选中*/
function fdCheckAll(o, n) {
	o = o || 'ids[]';
	n = n || 0;
	var i, str = document.getElementsByName(o), len = str.length, chestr = '';
	for (i = 0; i < len; i++) {
		if (n == 1) {
			if (str[i].checked) {
				chestr += (chestr == '' ? '' : ',') + str[i].value;
			}
		} else {
			if (str[i].checked) {
				str[i].checked = false;
			} else {
				str[i].checked = true;
			}
		}
	}
	return chestr;
}
/* @action: 复选框的选择与获取值 */
function fdCheckGet(o) {
	return fdCheckAll(o, 1);
}

function getYm(){
    var date=new Date();
    var time1=date.getFullYear()+"年"+date.getMonth()+"月";
    var time2=date.getFullYear()+"年"+(date.getMonth()-1)+"月";
    var time3=date.getFullYear()+"年"+(date.getMonth()-2)+"月";
    return {'time1':time1,'time2':time2,'time3':time3};    
}
