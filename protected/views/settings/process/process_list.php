<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="pb20">
	<div id="roadheight" class="set">
	<div id="road_right" class="road_right"><!--右侧工作流 开始-->
            	<div class="node_tab"><!--节点tab菜单 开始-->
                	<ul class="clearfix">
                    	<li><a href="<?php echo Yii::app()->createUrl('/settings/formnode/index/' . $fid)?>">节点信息</a></li>
                        <li class="node_tabborder"><a href="<?php echo Yii::app()->createUrl('/settings/process/index/' . $fid)?>">出口信息</a></li>
                        <li><a href="<?php echo Yii::app()->createUrl('/settings/formview/index/' , array('fid'=>$fid))?>">图形编辑</a></li>
                    </ul>
                </div><!--节点tab菜单 结束-->
                <div class="wknde etne"><!--工作流节点 开始-->
                	<div class="etne_title">
                    	<select id="sel_node" class="fl" name="nownode">
                            <option value="0">请选择当前节点</option>
                            <?php foreach ($Nodelist as $NodelistVal) :?>
                                <option value="<?php echo $NodelistVal['id'];?>"><?php echo $NodelistVal['name'];?></option>
                            <?php endforeach;?>
                        </select>
                        <div class="etne_title_btn"><a id="a_addnode">添加节点</a><a id="a_delnode">删除节点</a></div>
                    </div>
                    <div class="wknde_table etne_table"><!--工作流节点表格 开始-->
                    	<form name="etne_form" action="" method="post">
                        	<table id="tb_list" width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <th width="10%"><h4 class="wknde_h4"><input type="checkbox" id="check_choose"/>选中</h4></th>
                                        <th width="26%"><h4>节点名称</h4></th>
                                        <th width="8%"><h4><input type="checkbox" id="check_back"/>是否退回</h4></th>
                                        <th width="9%"><h4>条件</h4></th>
                                        <th width="20%"><h4>出口名称</h4></th>
                                        <th width="27%"><h4>目标节点</h4></th>
                                    </tr>
                                    <?php if (!empty($ProcessList)):?>
                                        <?php foreach($ProcessList as $ProcessListVal):?>                                    
                                            <tr>
                                                <td><input type="checkbox" b="<?php echo $ProcessListVal->id;?>" name="checkworke" class="wknde_check"></td>
                                                <td><input type="hidden" d="<?php echo $ProcessListVal->id;?>" value="<?php echo $ProcessListVal->init_id;?>"/><?php echo $AllNodelist[$ProcessListVal->init_id];?></td>
                                                <td>
                                                    <?php if (!empty($ProcessListVal->isback)){ ?>
                                                        <input type="checkbox" checked="checked" name="whether">
                                                    <?php }else{?>
                                                        <input type="checkbox" name="whether">
                                                    <?php }?>
                                                </td>
                                                <td><a href="javascript:show_eten_div('<?php echo $ProcessListVal->id;?>')"></a></td>
                                                <td><input type="text" value="<?php echo $ProcessListVal->next_goal;?>" name="names" class="etne_input fl"
                                                           onkeyup="ch_text('<?php echo $ProcessListVal->id;?>')" onblur="ch_text('<?php echo $ProcessListVal->id;?>')"
                                                           id="txt_input_<?php echo $ProcessListVal->id;?>">
                                                    <span class="etne_style fl" id="txt_span_<?php echo $ProcessListVal->id;?>"></span></td>
                                                <td><select name="objective" id="txt_select_<?php echo $ProcessListVal->id;?>">
                                                        <?php foreach($AllNodelist as $AllNodelistKey => $AllNodelistVal):?>
                                                            <?php if($ProcessListVal->init_id != $AllNodelistKey):?>
                                                                <?php if($AllNodelistKey == $ProcessListVal->node_id): ?>
                                                                    <option selected="selected" value="<?php echo $AllNodelistKey?>"><?php echo $AllNodelistVal;?></option>
                                                                <?php else:?>
                                                                    <option value="<?php echo $AllNodelistKey?>"><?php echo $AllNodelistVal;?></option>
                                                                <?php endif;?>

                                                            <?php endif;?>
                                                        <?php endforeach;?>
                                                    </select></td>
                                            </tr>
                                        <?php endforeach;?>
                                    <?php endif;?>
                        	</table>
                            <div class="wknde_btn etne_btn"><a style="cursor:pointer" id="fsave">保存</a></div>
                    	</form>
                    </div><!--工作流节点表格 结束-->
                </div><!--工作流节点 结束-->
                <div class="etne_cdn"><!--条件弹出框 开始-->
                    <div id="term_content"></div>
                    <form name="etne_cdn" action="" method="post">
                        <div id='term_div'>

                        </div>

                        <div class="etne_cdnbtn"><a id='div_save'>确定</a><a class="esc">返回</a></div>
                    </form>
		</div><!--条件弹出框 结束-->
                <div id='div_dept' class="aut_adddiv"><!--部门弹出层 开始-->
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

                <div class="aut_adddiv" id="div_role"><!--角色弹出层 开始-->
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
                
                <div id='div_person' class="aut_adddiv"><!--人力资源 开始-->
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

                <div id="eten_div"><!--遮罩层 开始--></div><!--遮罩层 结束-->
            </div><!--右侧工作流 结束-->
         </div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
    var NodeList = $.parseJSON('<?php echo json_encode($Nodelist);?>');
    var ajaxurl = '<?php echo $this->createUrl('/settings/process/ajax/');?>';
    var ajaxgetpurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';
    var ajaxRoleUrl = '<?php echo $this->createUrl('/settings/role/ajax/');?>';
    var fid = '<?php echo $fid;?>'; //表单ID
    var Processindexurl = '<?php echo $this->createUrl('/settings/process/index/' . $fid);?>';
    var selectId = '';
    var node_id = '';     //节点ID

//自适应高度
function heightChange(){
	var roadRight = document.getElementById("road_right");
	var bodyHeight = document.documentElement.clientHeight;
	roadRight.style.minHeight = bodyHeight -9 - 15 + "px";   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
}
window.onload = heightChange();
window.onresize = heightChange;
//表格设置
$(function(){
	$(".wknde_table tr:odd").find("td").css({"background-color":"#f9f9f9","border-bottom-color":"#f4f6f7"});
	$(".etne_cdn table tr:odd").find("td").css({"background-color":"#f9f9f9","border-bottom-color":"#f4f6f7"});
        $(".etne_cdnbtn .esc").click(function(){
		$(".etne_cdn").animate({top:-537},"slow",function(){
			$(".etne_cdn").hide();
			$("#eten_div").hide();
		});
	});
});

$(function(){
	//角色弹出层样式
       $(".aut_justxt li").live('mouseover',function(){
           $(this).find(".aut_justxt_bg").show();
		$(this).css("color","#fff");
		$(this).siblings().find(".aut_justxt_bg").hide();
		$(this).siblings().css("color","#7c7c7c");
       })
});


var tr_index = 0;   //每个TR的下标，用来动态定义元素ID

//添加节点事件
$('#a_addnode').click(function(){

    var sel_text = $('#sel_node').find("option:selected").text();
    var sel_val = $('#sel_node').find("option:selected").val();
    if (sel_val == '0'){
        alert('请选择节点');
        return false;
    }

    //检查最新的数据是否填写
    var i=$('#tb_list tr').size();
    if (i>1){
        var lastTXT = $('#tb_list tr').eq(i-1).find("td").eq(4).find("input").eq(0).val(); //出口名称
        var lastSELECT = $('#tb_list tr').eq(i-1).find("td").eq(5).find("select").find("option:selected").val(); //目标节点
        if ('' == $.trim(lastTXT) ){
            alert('请输入出口名称');
            return false;
        }
        if (lastSELECT == 0){
            alert('请选择目标节点');
            return false;
        }
    }


    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"saveprocessone",initid:sel_val,fid:fid},
        dataType:"json",
        async:false,
        success:function(data){
            if (data.code == "success"){
                var tb_list = document.getElementById("tb_list");
                var tr = document.createElement("tr");

                var optionhtml = '';
                optionhtml +=  '<option value="0">请选择目标节点</option>';
                for(var i=0;i<NodeList.length;i++) {
                    if (sel_val != NodeList[i]['id'])
                        optionhtml +=  '<option  value="'+ NodeList[i]['id'] +'">'+NodeList[i]['name']+'</option>';
                }                

                tb_list.appendChild(tr);
                tr.innerHTML = '<td>' +'<input class="wknde_check" b="'+data.info+'" type="checkbox" name="checkworke" />' + '</td>'
                                      + '<td><input d="'+data.info+'" type="hidden" value="'+ sel_val +'"/>'+ sel_text +'</td>'
                                      + '<td><input type="checkbox" name="whether" /></td>'
                                      + '<td><a href="javascript:show_eten_div(\''+data.info+'\')"></a></td>'
                                      + '<td><input id="txt_input_'+ tr_index +'" onblur="ch_text(\''+ tr_index +'\')" onkeyup="ch_text(\''+ tr_index +'\')"  class="etne_input fl"  type="text" name="names" value="" />'
                                      +'<span id="txt_span_'+ tr_index +'" class="etne_style fl">!</span></td>'
                                      + '<td>'
                                      + '<select id="txt_select_'+ tr_index +'" name="objective">'
                                      + optionhtml
                                      +'</select>'
                                      +'</td>' ;
                tr_index++;
            }
        }
    });

});

function show_eten_div(nodeid){
    node_id = nodeid;
    //获取原来条件数据
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"getTermData",fid:fid,nodeid:node_id},
        dataType:"json",
        async:false,
        success:function(data){
            $('#term_content').html(data['info']);
        }
    });

    show_term_div();
    //获取work_item表单列表数据
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"getItemData",fid:fid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#term_div').html(data['info']);
        }
    });
}

function show_term_div(){
    var etneHeight = $("#road_right").height();
    $("#eten_div").css("min-height",etneHeight);
    $("#eten_div").show();
    $(".etne_cdn").show();
    $(".etne_cdn").animate({top:28},"slow");
}

function ch_text(idname){
    var txt = 'txt_input_';
    var span = 'txt_span_';
    if ('' !=  $.trim($("#"+txt+idname).val()) ){
        $("#"+span+idname).html('');
    }else{
        $("#"+span+idname).html('!');
    }
}


//删除节点事件
$('#a_delnode').click(function(){
    $('input[name="checkworke"]:checked').each(function(){
        var processId = $(this).eq(0).attr('b');

        if (processId.length > 0){
            $.ajax({
                type:'post',
                url:ajaxurl,
                data:{type:"delete",id:processId,fid:fid},
                dataType:"json",
                async:false,
                success:function(data){
                    if (data.code == 'error'){
                        alert('删除失败');
                        return false;
                    }
                }
            });
        }
        $(this).parent().parent().remove();
    });
});

$('#fsave').click(function(){
    var i=$('#tb_list tr').size();
    var j = 1;
    if (i>1){
        var trArrOld = []; //存行数据
        for(j = 1 ; j < i; j++){
            if (j == (i-1)){
                var lastTXT = $('#tb_list tr').eq(j).find("td").eq(4).find("input").eq(0).val(); //出口名称
                var lastSELECT = $('#tb_list tr').eq(j).find("td").eq(5).find("select").find("option:selected").val(); //目标节点
                if ('' == $.trim(lastTXT) ){
                    alert('请输入最后一行的出口名称');
                    return false;
                }
                if (lastSELECT == 0){
                    alert('请选择最后一行的目标节点');
                    return false;
                }
            }

            trArrOld.push([
                $('#tb_list tr').eq(j).find("[name=whether]").is(":checked"), //是否退回
                $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).val(),        //节点名称ID
                $('#tb_list tr').eq(j).find("td").eq(4).find("input").eq(0).val(),        //出口名称
                $('#tb_list tr').eq(j).find("td").eq(5).find("select").find("option:selected").val(), //目标节点
                $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).attr('d') //流程ID
            ]);

            //原始分两类 一类原来的数据做更新 一类做添加
//            var dataType = $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).attr('b');  //获取数据类型
//            if (dataType == 'new'){
//                trArr.push([
//                    $('#tb_list tr').eq(j).find("[name=whether]").is(":checked"), //是否退回
//                    $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).val(),        //节点名称ID
//                    $('#tb_list tr').eq(j).find("td").eq(4).find("input").eq(0).val(),        //出口名称
//                    $('#tb_list tr').eq(j).find("td").eq(5).find("select").find("option:selected").val() //目标节点
//                ]);
//            }else{
//                trArrOld.push([
//                    $('#tb_list tr').eq(j).find("[name=whether]").is(":checked"), //是否退回
//                    $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).val(),        //节点名称ID
//                    $('#tb_list tr').eq(j).find("td").eq(4).find("input").eq(0).val(),        //出口名称
//                    $('#tb_list tr').eq(j).find("td").eq(5).find("select").find("option:selected").val(), //目标节点
//                    $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).attr('d') //流程ID
//                ]);
//            }

        }
//        if (trArr && trArr.length > 0 ){
//            $.ajax({
//                type:'post',
//                url:ajaxurl,
//                data:{type:"addProcessData",fid:fid,data:trArr},
//                dataType:"json",
//                async:false,
//                success:function(data){
//                    location.href = Processindexurl;
//                }
//            });
//        }

        if(trArrOld && trArrOld.length > 0 ){
            $.ajax({
                type:'post',
                url:ajaxurl,
                data:{type:"modifyProcessData",data:trArrOld,fid:fid},
                dataType:"json",
                async:false,
                success:function(data){
                    location.href = Processindexurl;
                }
            });
        }

    }
});


//******* 弹出层JS START

function chk_text(id,type){
    if ($.trim($('#'+type+'text_'+id).val()) != ''){
        $('#chk_'+id).attr("checked",true);
    }else{
        $('#chk_'+id).attr("checked",false);
    }
}

$('#btn_dept').click(function(){
    var deptArr = get_dept();
    if (deptArr != ''){
        $('#chk_'+selectId).attr("checked",true);
    }else{
        $('#chk_'+selectId).attr("checked",false);
    }
    $('#selectStr'+selectId).html(deptArr);
    close_aut_div();
});

$('#btn_deptinfo').click(function(){
    var deptinfostr = '';
   $("#ul_add_deptinfo li").each(function(){
       deptinfostr += '<span id="'+$(this).find('span').data('id')+'">'+ $(this).text() + '</span>&nbsp;&nbsp;&nbsp;';
   });
   if (deptinfostr != ''){
        $('#chk_'+selectId).attr("checked",true);
   }else{
        $('#chk_'+selectId).attr("checked",false);
   }
   $('#selectStr'+selectId).html(deptinfostr);
   close_aut_div();
});

//jquery获取复选框值
function get_dept(){
    var deptstr='';
    $('input[name="deptname"]:checked').each(function(){
        deptstr +='<span id="'+$(this).attr('id')+'">'+ $(this).attr('b') + '</span>&nbsp;&nbsp;&nbsp;'
    });
    return deptstr;
}

//页面弹层关闭方法 通用三个弹窗
function close_aut_div(){
    $(".aut_adddiv").hide();
}

function showDeptDiv(id){
    selectId = id;
    $("#div_dept").show();
    $("#div_dept").css({
            left:($(window).width() - $(".aut_adddiv").width())/2,
            top:100+"px"
      });   
}

function showRoleDiv(id){
    selectId = id;
    $("#div_role").show();
    $("#div_role").css({
            left:($(window).width() - $(".aut_adddiv").width())/2,
            top:100+"px"
      });   
    getroleinfo($.trim($('#rolesearchtxt').val()));            
}

$("#rolesearchtxt").keyup(function(){
    getroleinfo($.trim($('#rolesearchtxt').val()));
});

$("#rolesearchtxt").blur(function(){
    getroleinfo($.trim($('#rolesearchtxt').val()));
});

$('span[name=roles]').live('dblclick', function(){    
    $('#roleStr'+selectId).append('<span id="'+$(this).attr('id')+'">'+ $(this).text() + '</span>&nbsp;&nbsp;&nbsp;');  
    $('#chk_'+selectId).attr("checked",true);
    $('#close_aut_adddiv').click();
});

$('#close_aut_adddiv').click(function(){    
    $("#div_role").hide();
});


$('#check_back').click(function(){    
    if ($(this).prop("checked")) {
        $("input[name='whether']").not(':checked').prop("checked",true);
    }else{
        $("input[name='whether']").filter(':checked').prop("checked",false);
    } 
});

$('#check_choose').click(function(){    
    if ($(this).prop("checked")) {
        $("input[name='checkworke']").not(':checked').prop("checked",true);
    }else{
        $("input[name='checkworke']").filter(':checked').prop("checked",false);
    } 
});


//获取弹出层角色内容
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

function showPersonDiv(id){
    selectId = id;
    $("#div_person").show();
    $("#div_person").css({
            left:($(window).width() - $(".aut_adddiv").width())/2,
            top:100+"px"
      });   
}

$('#dept_cls').click(function(){
   $("input[name='deptname']").filter(':checked').prop("checked",false);
});

//人力资源弹出层JS START
function get_dept_info(deptid){
    $.ajax({
        type:'post',
        url:ajaxgetpurl,
        data:{type:"getdeptinfo",deptid:deptid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#ul_deptinfo').html(data['info']);
        }
    });
}

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
//人力资源弹出层JS END

function clsspan(id){
    $('#'+id).html('');
}

//弹出层保存按钮
$('#div_save').click(function(){
    $('input[name="cdn_check"]:checked').each(function(){
        var item_id = $(this).attr('b');
        var item_type = $(this).attr('t');
        var dataArr;
        if (item_type == '103'){
            var selectValOne = $(this).parents('tr').find("select").eq(0).val();      //第一个下拉框的值
            var selectValTwo = $(this).parents('tr').find("select").eq(1).val();     //第二个下拉框的值
            var ltext = $('#ltext_'+item_id).val();
            var rtext = $('#rtext_'+item_id).val();
            dataArr = {type:"addnodeterm",fid:fid,nodeid:node_id,itemid:item_id,itemtype:item_type,lselect:selectValOne,ltext:$.trim(ltext),rselect:selectValTwo,rtext:$.trim(rtext)};
            ajaxdata(dataArr);
        }else if(item_type == '102'){
            var ids = new Array();
            var term = $(this).parents('tr').find("select").find("option:selected").val();      //下拉框的值
            $('#selectStr'+item_id+' span').each(function(){
                ids.push($(this).attr('id'));
            });
            dataArr = {type:"addnodeterm",fid:fid,nodeid:node_id,itemid:item_id,itemtype:item_type,term:term,termcontent:ids}; 
            ajaxdata(dataArr);
        }else if(item_type == '101') {
            var ids = new Array();
            var roleids = new Array();
            var term = $(this).parents('tr').find("select").find("option:selected").val();      //下拉框的值
            $('#selectStr'+item_id+' span').each(function(){
                ids.push($(this).attr('id'));
            });
            dataArr = {type:"addnodeterm",fid:fid,nodeid:node_id,itemid:item_id,itemtype:item_type,term:term,termcontent:ids}; 
            ajaxdata(dataArr);
            $('#roleStr'+item_id+' span').each(function(){
                roleids.push($(this).attr('id'));
            });            
            dataArr = {type:"addnodeterm",fid:fid,nodeid:node_id,itemid:item_id,itemtype:'104',term:term,termcontent:roleids}; 
            ajaxdata(dataArr);                        
        }else if (item_type = '4'){
            var ids = new Array();
            var term = $(this).parents('tr').find("select").eq(0).find("option:selected").val();      //下拉框的值
            var body = $(this).parents('tr').find("select").eq(1).find("option:selected").html();      //下拉框的值                      
            dataArr = {type:"addnodeterm",fid:fid,nodeid:node_id,itemid:item_id,itemtype:'4',term:term,termcontent:body}; 
            ajaxdata(dataArr);
        }

    });
    
    
    function ajaxdata(dataArr){
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:dataArr,
            dataType:"json",
            async:false,
            success:function(data){

            }
        });
    }

    //关闭条件选择弹层
    $(".etne_cdn").animate({top:-537},"slow",function(){
            $(".etne_cdn").hide();
            $("#eten_div").hide();
    });
});
//*******弹出层JS END

</script>