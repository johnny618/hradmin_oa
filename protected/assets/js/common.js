var Common = {
    alert: function (msg, gotoUrl) {
        if (msg != undefined &&  msg != '') {
            alert(msg);
            if (gotoUrl != undefined && gotoUrl != '') {
                window.location.href = gotoUrl;
            }
        }
    }
};

function get_page_bar(func, page, total_num, total_page, previous_page, next_page, pagenum) {
	pagenum  = pagenum ? pagenum : 10;
	if(total_num<=0) {
		return '<label style="margin-right: 20px;">&nbsp;&nbsp;共0条记录&nbsp;&nbsp;</label>';
	}
	
	var page_bar = '<label style="margin-right: 20px;">共'+total_num+'条记录&nbsp;&nbsp;分'+total_page+'页&nbsp;&nbsp;每页'+pagenum+'条记录</label>';
	page_bar +='<a disabled style="margin-right: 5px;" href="javascript:void(0);" onclick = "'+func+'(1);">第一页</a>';
	if(page == 1) {
		page_bar += '<a disabled style="margin-right: 5px;">上一页</a>';
	}
	else {
		page_bar += '<a disabled style="margin-right: 5px;" href="javascript:void(0);" onclick = "'+func+'('+previous_page+');">上一页</a>';
	}
	page_bar += '<label style="font-weight: Bold; color: red; margin-right: 5px;">['+page+']</label>';
	if(page == total_page) {
		page_bar += '<a disabled style="margin-right: 5px;" title="转到下一页">下一页</a>';
	}
	else {
		page_bar += '<a disabled style="margin-right: 5px;" title="转到下一页"  href="javascript:void(0);" onclick = "'+func+'('+next_page+');">下一页</a>';
	}
	page_bar +='<a disabled style="margin-right: 5px;" title="转到最末页" href="javascript:void(0);" onclick = "'+func+'('+total_page+');">最末页</a>';
	
	return page_bar;
}

//检查输出的字符串是否为null
function checktxt(str){
    if(str == null){
        str = "空";
    }
    return str;
}

function checkpagenum(){
    var reg = /[^/0-9]/g;  //只能数字正则
    // /^(?!0\d+)\d+$/ 
    //var reg = /[^/a-zA-Z0-9]/g;  //只能输入字母正则
    //var reg = /[^\D]/g;  //只能输入字母正则

    $("#itemurl").keyup(function(){
        $(this).val($(this).val().replace(reg,''));
    }).bind("paste",function(){  //CTR+V事件处理
        $(this).val($(this).val().replace(reg,''));
    }); //CSS设置输入法不可用
}
