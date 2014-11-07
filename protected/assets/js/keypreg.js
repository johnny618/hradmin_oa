var strnum_reg = /[^a-zA-Z0-9]/g ;
var number_reg = /[^0-9]/g;
var str_reg = /[^a-zA-Z]/g;

/**
 * 输入正则验证 {数字}
 * @param {type} id
 * @returns {undefined}
 */
function perg_number(id){    
    $("#"+id).keyup(function(){
        $(this).val($(this).val().replace(number_reg,''));
    }).bind("paste",function(){  //CTR+V事件处理
        $(this).val($(this).val().replace(number_reg,''));
    });
}

/**
 * 输入正则验证 {数字}
 * @param {type} id
 * @returns {undefined}
 */
function perg_str(id){
    $("#"+id).keyup(function(){
        $(this).val($(this).val().replace(str_reg,''));
    }).bind("paste",function(){  //CTR+V事件处理
            $(this).val($(this).val().replace(str_reg,''));
    });
}