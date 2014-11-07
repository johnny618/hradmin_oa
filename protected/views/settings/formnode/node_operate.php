<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">  
	<div id="roadheight" class="set">
	<div id="road_right" class="road_right"><!--右侧工作流 开始-->            	
                <form name="autoform" id="autoform" action="" method="post">
                	<div class="aut_basic">
                		<h3>基本信息</h3>
                    	<div class="aut_name">
                    		<label class="fl">操作组名称</label>
                                <input class="fr" type="text" readonly="operater" disabled="false"  name="names" value="<?php echo $operater?>" />
                    	</div>
                	</div>
                	<div class="aut_cts">
                        <div class="aut_ctsbox">
                        	<ul class="clearfix">
                            	<li>
                                    <input id="dept" class="fl" type="radio" name="radio_cts" />
                                    <label for="door" class="fl">部门</label>
                                    <select class="fl" name="isdept" id="isdept">
                                    	<option value="0">属于</option>
                                        <option value="1">不属于</option>
                                    </select>
                                    <a class="fl"></a>
                                    <div class="aut_cts_text fl"><span id="deptstr"></span></div>
                                </li>
                                <li>
                                    <input id="role" class="fl" type="radio" name="radio_cts" />
                                    <label for="role" class="fl">角色</label>
                                    <select class="fl" name="door_select"  id="isrole">
                                    	<option value="0">包含</option>
                                        <option value="1">不包含</option>
                                    </select>
                                    <a class="fl" id="showRoleDiv"></a>
                                    <div class="aut_cts_text fl"><span id="rolestr"></span></div>
                                </li>
                                <li>
                                	<input id="person" class="fl" type="radio" name="radio_cts" />
                                    <label for="person" class="fl">人力资源</label>
                                    <select class="fl" name="isperson" id="isperson">
                                    	<option value="0">包含</option>
                                        <option value="1">不包含</option>
                                    </select>
                                    <a class="fl"></a>
                                    <div class="aut_cts_text fl"><span id="deptinfostr"></span></div>
                                </li>
                                <li>
                                	<input id="lender" class="fl" type="radio" name="radio_cts" />
                                        <label for="lender" class="fl">上级</label>
                                </li>
                                <li>
                                	<input id="allbody" class="fl" type="radio" name="radio_cts" />
                                        <label for="allbody"  class="fl">所有人</label>
                                </li>
                            </ul>
                        </div>
                	</div>
                    <div class="aut_act">
                        <div class="aut_actbtn"><a class="aut_actbtn_a" onclick="javascript:addCondition()">添加条件</a><a onclick="javascript:delCondition()">删除条件</a></div>
                        <div class="aut_table">
                            <table id="aut_table" width="100%" cellpadding="0" cellspacing="0">
                            	<tr>
                            		<th width="11%"><input type="checkbox" name="check_all" id="check_all" /></th>
                                	<th width="18%"><h4>类型</h4></th>
                                	<th width="43%"><h4>名称</h4></th>                                	
                            	</tr>
                                <div id="tb_tr">
                                    <?php foreach($oldoperate as $oldoperateKey => $oldoperateVal):?>
                                         <tr>
                                            <td><input type="checkbox" name="appcheck" id="<?php echo $oldoperateVal['operater']?>"></td>
                                            <td name="<?php echo $operateType[$oldoperateVal['type']]?>"><?php echo $operateZhType[$oldoperateVal['type']]?></td>
                                            <td><span addterm="<?php echo $oldoperateVal['term']?>" addid="<?php echo $oldoperateVal['operater']?>" 
                                                      addtype="<?php echo $operateType[$oldoperateVal['type']]?>" name="item"><?php echo $oldoperateVal['operater_zh'];?></span></td>
                                        </tr>
                                    <?php endforeach;?>
                                </div>
                            </table>
                            <div class="aut_act_btn"><a href="javascript:void(0)" id="fsave">保存</a><a href="<?php echo $this->createUrl('/settings/formnode/index/' . $fid);?>">返回</a></div>
                        </div>
                    </div>
                </form>
                <div id="aut_div" class="aut_div"><!--遮罩层 --></div>
                <div class="aut_adddiv"><!--部门弹出层 开始-->
                    <div class="aut_ddiv_nav">
                    	<h4>易班</h4>
                        <ul class="set_tree">
                             <?php foreach($deptArr as $deptArrKey =>$deptArrVal):?>                                    
                                        <li><input type="checkbox" name="deptname" id="<?php echo $deptArrKey?>" b="<?php echo $deptArrVal?>" /><label><?php echo $deptArrVal?></label></li>                                            
                             <?php endforeach;?>
                        </ul>                        
                    </div>

                    <div class="aut_add_btn"><a id="btn_dept">确定</a><a id="dept_cls">清除</a><a class="aut_close">取消</a></div>
                </div><!--部门弹出层 结束 -->
                <style>
                    .aut_adddiv a.close{background: url(<?php echo Yii::app()->baseUrl . '/protected/assets/'?>/images/close-icon.png) no-repeat; position:absolute;right:5px;top:5px; width:20px; height:20px;}
                    .aut_adddiv a.close:hover{ background-position:0 -20px;}
                </style>
                <div class="aut_adddiv" id="aut_adddiv"><!--角色弹出层 开始-->
                    <a href="javascript:;" class="close" id="close_aut_adddiv"></a>
                	<div class="aut_jus">
                            <div style="padding: 36px 30px 0;width: 396px;">
                        <input type="text" name="" id="rolesearchtxt"style=" width:99%; display:block; border-radius:5px; border: 1px solid #666; height: 30px; line-height:30px;"/>
                        </div>
                    	<div class="aut_justit">
                            <ul>
                            	<li>角色名称</li>                                
                            </ul>
                        </div>
                      <div class="aut_justxt">
                            <ul class="clearfix" id="rolecontent">
                            	
                            </ul>
                        </div>
                    </div>
                </div><!--角色弹出层 结束 -->
                
                <div class="aut_adddiv"><!--人力资源 开始-->
                	<div class="aut_ddiv_nav aut_people"><!--人力资源上部分 开始-->
                    	<h4>易班</h4>
                        <ul class="set_tree">
                             <?php foreach($deptArr as $deptArrKey =>$deptArrVal):?>                                    
                                        <li><span onclick="javascript:get_dept_info('<?php echo $deptArrKey;?>')"><?php echo $deptArrVal?></span></li>                                            
                             <?php endforeach;?>
                        </ul>
                        
                    </div><!--人力资源上部分 结束-->
                    <div class="atu_pbox">
                    	<div class="atu_pboxtit">已选择 <span id="choose_number">0</span> 人</div>
                        <div class="atu_pbbox">
                        	<div class="atu_pbbox_box fl"><!--左边选择框 开始-->
                            	<ul class="clearfix" id="ul_deptinfo">
                                    
                                </ul>
                            </div><!--左边选择框 结束-->
                            <div class="atu_pbbox_box fr"><!--右边选择框 结束-->
                            	<ul id="ul_add_deptinfo">
                                                                    	
                                </ul>
                            </div><!--右边选择框 结束-->
                        </div>
                    </div>
                    <div class="aut_add_btn"><a id="btn_deptinfo">确定</a><a id="deptinfo_cls">清除</a><a class="aut_close">取消</a></div>
                </div><!--人力资源 结束-->
            </div><!--右侧工作流 结束-->
         </div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
 <script type="text/javascript">
     var ajaxurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';
     var nodeindexurl = '<?php echo $this->createUrl('/settings/formnode/index/' . $fid);?>';
     var ajaxRoleUrl = '<?php echo $this->createUrl('/settings/role/ajax/');?>';
     var fid = '<?php echo $fid;?>';
 //自适应高度
function heightChange(){
	var bodyHeight = document.documentElement.clientHeight;
	var autDiv = document.getElementById("aut_div");
	autDiv.style.height = bodyHeight + "px";
}
$(function(){
	//表单/边框背景等等设置
	$(".aut_ctsbox li:odd").css("background-color","#f9f9f9");
	$(".aut_ctsbox li:last").css("border","none");
	$(".aut_table table tr:odd").find("td").css("background-color","#f9f9f9");
	$(".aut_justxt li").mouseover(function(){
		$(this).find(".aut_justxt_bg").show();
		$(this).css("color","#fff");
		$(this).siblings().find(".aut_justxt_bg").hide();
		$(this).siblings().css("color","#7c7c7c");	
	});
       $(".aut_justxt li").live('mouseover',function(){
           $(this).find(".aut_justxt_bg").show();
		$(this).css("color","#fff");
		$(this).siblings().find(".aut_justxt_bg").hide();
		$(this).siblings().css("color","#7c7c7c");
       })
	$(".aut_justxt li:even").css({"background-color":"#f9f9f9","border-bottom-color":"#f4f6f7 "});
	//功能
});


$('#showRoleDiv').click(function(){        
    $('#aut_adddiv').show();    
    getroleinfo($.trim($('#rolesearchtxt').val()));        
});

function getroleinfo(txt){
    $.ajax({
        type:'post',
        url:ajaxRoleUrl,
        data:{type:"getroleinfo",searchtxt:txt},
        dataType:"json",
        async:false,
        success:function(data){           
            $('#rolecontent').html(data.info);
        }
    });
}

$('span[name=roles]').live('dblclick', function(){
    $('#rolestr').html( '<span id="'+$(this).attr('id')+'">'+ $(this).text() + '</span>');
    $('#close_aut_adddiv').click();
});

$('#close_aut_adddiv').click(function(){
    $('#aut_adddiv').hide();    
    $(".aut_div").hide();
});

$("#rolesearchtxt").keyup(function(){
    getroleinfo($.trim($('#rolesearchtxt').val()));
});

$("#rolesearchtxt").blur(function(){
    getroleinfo($.trim($('#rolesearchtxt').val()));
});

//添加条件
function addCondition(){
    var radiotype = $("input[name='radio_cts']:checked").attr('id'); 
   
    var autTable = document.getElementById("aut_table");
    
    if (radiotype == 'dept' ){        
        $('#deptstr span').each(function(){            
            var tr = document.createElement("tr");	
            autTable.appendChild(tr);
            tr.innerHTML = '<td>' +'<input type="checkbox" id="'+$(this).attr('id')+'" name="appcheck">' + '</td>' + 
                                       '<td>部门</td>' +
                                       '<td ><span name="item" addtype="tdept" addid="'+$(this).attr('id')+'" addterm="'+ $("#isdept").val()+'">' + $(this).text() + '</span></td>';
        });        
    }else if(radiotype == 'person'){        
        $('#deptinfostr span').each(function(){
            var tr = document.createElement("tr");	
            autTable.appendChild(tr);
            tr.innerHTML = '<td>' +'<input type="checkbox"  id="'+$(this).attr('id')+'"  name="appcheck">' + '</td>' + 
                                       '<td name="tperson">人力资源</td>' +
                                       '<td><span name="item" addtype="tperson" addid="'+$(this).attr('id')+'" addterm="'+ $("#isperson").val()+'">' + $(this).text() + '</span></td>';
        });
    }else if(radiotype == 'role'){
        $('#rolestr span').each(function(){
            var tr = document.createElement("tr");	
            autTable.appendChild(tr);
            tr.innerHTML = '<td>' +'<input type="checkbox"  id="'+$(this).attr('id')+'"  name="appcheck">' + '</td>' + 
                                       '<td name="tperson">角色</td>' +
                                       '<td><span name="item" addtype="trole" addid="'+$(this).attr('id')+'" addterm="'+ $("#isrole").val()+'">' + $(this).text() + '</span></td>';
        });
    }else if(radiotype == 'lender'){  
	var tr = document.createElement("tr");	
	autTable.appendChild(tr);
	tr.innerHTML = '<td>' +'<input type="checkbox" id="td_lender" name="appcheck">' + '</td>' + 
				   '<td name="lender">上级</td>' +
				   '<td ><span name="item" addtype="tlender" addid="4" addterm="0">上级</span></td>';                           
    }else if(radiotype == 'allbody'){  
        $(autTable).find('tr').each(function(index){ 
            if (index != 0) $(this).remove();
        });
	var tr = document.createElement("tr");	
	autTable.appendChild(tr);
	tr.innerHTML = '<td>' +'<input type="checkbox" id="td_allbody" name="appcheck">' + '</td>' + 
				   '<td name="allbody">所有人</td>' +
				   '<td ><span name="item" addtype="tall" addid="0" addterm="0">所有人</span></td>';
    }else{
        alert('请选择要添加的类型！');
    }
    					   
}

//删除条件
function delCondition(){
    $('input[name="appcheck"]:checked').each(function(){
        $(this).parent().parent().remove();
    });    
}

//选中所有TABLE复选框
$('#check_all').click(function(){
    if ($(this).prop("checked")) {
        $("input[name='appcheck']").not(':checked').prop("checked",true);
    }else{
        $("input[name='appcheck']").filter(':checked').prop("checked",false);
    }    
});


//部门弹出层JS START
$('#btn_dept').click(function(){
    var deptArr = get_dept();      
    $('#deptstr').html(deptArr);
    close_aut_div();
});

$('#dept_cls').click(function(){   
   $("input[name='deptname']").filter(':checked').prop("checked",false); 
});

//jquery获取复选框值
function get_dept(){  
    var deptstr='';
    $('input[name="deptname"]:checked').each(function(){
        deptstr +='<span id="'+$(this).attr('id')+'">'+ $(this).attr('b') + '</span>&nbsp;&nbsp;&nbsp;'
    });
    return deptstr;
}

//eid员工ID 
function addemployee(obj){     
    if ($('#ul_add_deptinfo #' + $(obj).attr('id')).length > 0) {
        return false;
    }
    var html = $(obj).parent().clone();
    $(html).attr('ondblclick', 'removeemployee(this)');
    $('#choose_number').text(parseInt($('#choose_number').text())+1); 
    $('#ul_add_deptinfo').append(html);    
}

function removeemployee(obj){        
    $(obj).remove();    
    if (parseInt($('#choose_number').text()) > 0){
        $('#choose_number').text(parseInt($('#choose_number').text())-1);
    }
}

$('#deptinfo_cls').click(function(){
    $('#choose_number').text(0);
    $('#ul_add_deptinfo').html('');
});

$('#btn_deptinfo').click(function(){
    var deptinfostr = '';
   $("#ul_add_deptinfo li").each(function(){            
       deptinfostr += '<span id="'+$(this).find('span').data('id')+'">'+ $(this).text() + '</span>&nbsp;&nbsp;&nbsp;';
   }); 
   $('#deptinfostr').html(deptinfostr);
   close_aut_div();
});

//部门弹出层JS END


//人力资源弹出层JS START
function get_dept_info(deptid){
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"getdeptinfo",deptid:deptid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#ul_deptinfo').html(data['info']);
        }
    });
}
//人力资源弹出层JS END


//页面弹层关闭方法 通用三个弹窗
function close_aut_div(){    
    $(".aut_adddiv").hide();
    $(".aut_div").hide();	
}

//表单提交
//页面保存按钮
$('#fsave').click(function(){
    var datas = new Array();
    var nodeid = '<?php echo $id?>';
    $('[name="item"]').each(function(){
        var $this = $(this);
        datas.push([$this.attr('addterm'), $this.attr('addid'), $this.attr('addtype'),$this.text()]);
    });      
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"adddata",nodeid:nodeid,data:datas},
        dataType:"json",
        async:false,
        success:function(data){
            location.href = nodeindexurl;
        }
    });        
    
});

</script>
