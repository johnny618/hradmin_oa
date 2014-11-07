<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">

<div class="pb20">
	<div id="roadheight" class="set">
	<div id="road_right" class="road_right"><!--右侧工作流 开始-->            	
                <div class="wknde"><!--工作流节点 开始-->
                	<div class="wknde_title">
                    	工作流节点
                        <div class="wknde_title_btn"><a id="a_addnode">添加节点</a><a id="a_delnode">删除节点</a></div>
                    </div>
                    <div class="wknde_table"><!--工作流节点表格 开始-->
                    	<form name="wknde_form" action="" method="post">
                        	<table id="tb_list" width="100%" cellpadding="0" cellspacing="0">
                        	<tr>
                            		<th width="12%"><h4 class="wknde_h4">选中</h4></th>
                                	<th width="27%"><h4>节点名称</h4></th>
                                	<th width="28%"><h4>节点类型</h4></th>
                            	</tr>
                                <?php foreach($dataArr as $dataArrKey => $dataArrVal):?>
                                    <tr>
                            		<td><input class="wknde_check" b="<?php echo $dataArrVal['id']?>" type="checkbox" name="checkworke" /></td>
                                	<td><input class="wknde_names" id="<?php echo $dataArrVal['id']?>" type="text" name="names" value="<?php echo $dataArrVal['name']?>" /></td>
                                	<td>
                                            <select name="type">
                                                <?php foreach(MyConst::$nodeType as $nodeTypeKey => $nodeTypeVal):?>
                                                    <?php if ($nodeTypeKey == $dataArrVal['type']):?>
                                                        <option selected="selected" value="<?php echo $nodeTypeKey?>"><?php echo $nodeTypeVal?></option>
                                                    <?php else:?>
                                                        <option value="<?php echo $nodeTypeKey?>"><?php echo $nodeTypeVal?></option>
                                                    <?php endif;?>
                                                <?php endforeach;?>
                                            </select>
                                	</td>
                                    </tr>
                                <?php endforeach;?>

                        	</table>
                            <div class="wknde_btn"><a id="fsave" href="javascript:;">保存</a><a href="<?php echo $this->createUrl('/settings/formnode/index/' . $fid);?>">返回</a></div>
                    	</form>
                    </div><!--工作流节点表格 结束-->
                </div><!--工作流节点 结束-->
            </div><!--右侧工作流 结束-->
         </div>
</div>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/template" id="node_input_select">
<?php echo CHtml::dropDownList('type', '', array('' => '请选择节点类型') + MyConst::$nodeType);?>
</script>
<script type="text/javascript">
    var NodeType = $.parseJSON('<?php echo json_encode(MyConst::$nodeType);?>');//节点类型
    var DelIdArr = new Array();
    var fid = '<?php echo $fid?>'; //表单ID
    var ajaxurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';
    var listurl = '<?php echo $this->createUrl('/settings/formnode/index/' . $fid);?>';

//自适应高度
function heightChange(){    
	var roadRight = document.getElementById("road_right");
	var bodyHeight = document.documentElement.clientHeight;
	roadRight.style.minHeight = bodyHeight -9 - 15 + "px";   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
}
window.onload = heightChange();
window.onresize = heightChange;
//表格设置
$(".wknde_table tr:odd").find("td").css({"background-color":"#f9f9f9","border-bottom-color":"#f4f6f7"});

//添加节点事件
$('#a_addnode').click(function(){
    var tb_list = document.getElementById("tb_list");
    var tr = document.createElement("tr");
    var optionhtml = $('#node_input_select').html();
    tb_list.appendChild(tr);
    tr.innerHTML = '<td><input class="wknde_check" b="" type="checkbox" name="checkworke" /></td>'+
                   '<td><input class="wknde_names" type="text" name="names" value="" /></td>'+
                   '<td>'+optionhtml+'</td>' ;
    window.parent.heightChange();
});

//删除节点事件
$('#a_delnode').click(function(){
    $('input[name="checkworke"]:checked').each(function(){
        if ('' != $.trim($(this).eq(0).attr('b'))){
            DelIdArr.push($(this).eq(0).attr('b'));
        }
        $(this).parent().parent().remove();
    });
});

var checkDel = false;
var checkModify = false;
var checkAdd = false;


//保存事件
$('#fsave').click(function(){
    if (confirm("确认要保存么？")){
        var i=$('#tb_list tr').size();
        var j = 1;

        if (i>1){                
            var trArr = [];     //更新行数据
            var trArrOld = [];  //添加行数据
            for(j = 1 ; j < i; j++){

                if ('' != $.trim($('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).attr('id'))){
                    trArrOld.push([
                        $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).attr('id'),        //节点名称ID
                        $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).val(),              //节点名称
                        $('#tb_list tr').eq(j).find("td").eq(2).find("select").find("option:selected").val(), //目标节点
                    ]);
                }else{
                    trArr.push([
                        $('#tb_list tr').eq(j).find("td").eq(1).find("input").eq(0).val(),              //节点名称
                        $('#tb_list tr').eq(j).find("td").eq(2).find("select").find("option:selected").val(), //目标节点
                    ]);
                }
            }

            checkDel = false;
            checkModify = false;
            checkAdd = false;

            if (DelIdArr && DelIdArr.length > 0 ){
                $.ajax({
                    type:'post',
                    url:ajaxurl,
                    data:{type:"deleteNodeData",data:DelIdArr,fid:fid},
                    dataType:"json",
                    success:function(data){
                         checkDel = true;
                         goBackList();
                    }
                });
            }else{
                 checkDel = true;
                 goBackList();
            }

            if (trArr && trArr.length > 0 ){
                $.ajax({
                    type:'post',
                    url:ajaxurl,
                    data:{type:"addNodeData",fid:fid,data:trArr},
                    dataType:"json",                
                    success:function(data){
                        checkAdd = true;
                        goBackList();
                    }
                });
            }else{
                checkAdd = true;
                goBackList();
            }

            if(trArrOld && trArrOld.length > 0 ){
                $.ajax({
                    type:'post',
                    url:ajaxurl,
                    data:{type:"modifyNodeData",data:trArrOld,fid:fid},
                    dataType:"json",
                    success:function(data){
                        checkModify = true;
                        goBackList();
                    }
                });
            }else{
                checkModify = true;
                goBackList();
            }

        }
    }
    
    
});

function goBackList(){
    if (checkDel && checkModify && checkAdd){
        location.href = listurl;
    }
}

</script>