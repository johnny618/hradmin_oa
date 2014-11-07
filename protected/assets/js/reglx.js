//验证名字 （2-100中文和英文）
function reglx_name(str){
	var reg =/^[\u4e00-\u9fa5a-zA-Z]{2,100}$/ 
	return reg.test(str);
}

//验证字符串 （上限20中文和英文）
function reglx_string20(str){
	var reg =/^[\u4e00-\u9fa5a-zA-Z]{1,20}$/ 
	return reg.test(str);
}

//验证字符串 （上限30中文和英文）
function reglx_string30(str){
	var reg =/^[\u4e00-\u9fa5a-zA-Z]{1,30}$/ 
	return reg.test(str);
}

//验证字符串 （上限50中文和英文）
function reglx_string50(str){
	var reg =/^[\u4e00-\u9fa5a-zA-Z]{1,50}$/ 
	return reg.test(str);
}

//验证邮件地址
function reglx_email(str){
	var reg =/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/
	return reg.test(str);
}

//验证手机号
function reglx_phone(str){
	var reg =/^[1][358]\d{9}$/
	return reg.test(str);
}

//验证联系电话
function reglx_telephone(str){
	var reg =/((\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/;
	return reg.test(str);
}
 
//验证全球邮编
function reglx_postcode(str){
	var reg =/^[A-Za-z0-9]+$/;
	return reg.test(str);
}

//验证全球护照
function reglx_passport(str){
	var reg =/^[A-Za-z0-9]{2,15}$/;
	return reg.test(str);
}

//验证15位身份证
function reglx_idcard15(str){
	var reg =/^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$/;
	return reg.test(str);
}

//验证18位身份证
function reglx_idcard18(str){
	var reg =/^[1-9]\d{5}[1-9]\d{3}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}([0-9]|X|x)$/;
	return reg.test(str);
}

//验证中文字母
function reglx_zwzm(str){
	var reg =/^[a-zA-Z\u4e00-\u9fa5]+$/;
	return reg.test(str);
}

//验证中文字母
function reglx_zwzm_foreign(str){
	var reg =/^[a-zA-Z\u4e00-\u9fa5\s]+$/;
	return reg.test(str);
}

//验证中文字母数字
function reglx_zys(str){
	var reg =/^[0-9a-zA-Z\u4e00-\u9fa5\s]+$/;
	return reg.test(str);
}

//验证英文数字
function reglx_ywsz(str){
	var reg =/^[0-9a-zA-Z]+$/;
	return reg.test(str);
}

//验证居住地址
function reglx_address(str){
	var reg =/^[#0-9a-zA-Z\u4e00-\u9fa5\s]+$/;
	return reg.test(str);
}
