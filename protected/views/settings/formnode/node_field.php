<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">

	<div id="roadheight" class="set">
	<div id="road_right" class="road_right"><!--右侧工作流 开始-->            	
                <div class="node_table"><!--节点表格 开始-->
                	<div class="node_btn">节点字段设置</div>
                    <form id="nodeset_fomr" name="nodeset_fomr" action="" method="post">
                    	<table width="96%" cellpadding="0" cellspacing="0">
                    	    <tr>
                        	<th width="37%"><h4 class="node_margin">字段名称</h4></th>
                        <th width="21%"><h4><input id="check_show"  type="checkbox" />是否显示</h4></th>
                                <th width="21%"><h4><input id="check_edit"  type="checkbox" />是否编辑</h4></th>
                                <th width="21%"><h4><input id="check_null"  type="checkbox" />是否必填</h4></th>
                            </tr>
                            
                            <?php foreach ($list as $item) {?>
                                <tr>
                                     <td><label><?php echo $item->field_name;?></label></td>
                                     <?php if(in_array($item->id,$FieldArr)){?>
                                        <td><input checked="checked" type="checkbox" name="showsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }else{?>
                                        <td><input type="checkbox" name="showsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }?>   
                                        
                                     <?php if(in_array($item->id,$editArr)){?>
                                        <td><input checked="checked" type="checkbox" name="editsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }else{?>
                                        <td><input type="checkbox" name="editsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }?>    
                                     
                                    <?php if(in_array($item->id,$notnullArr)){?>
                                        <td><input checked="checked" type="checkbox" name="notnullsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }else{?>
                                        <td><input type="checkbox" name="notnullsub" b="<?php echo $item->id;?>" /></td>
                                     <?php }?>      
                                        
                                        
                                </tr>
                            <?php }?>                            
                    	</table>
                        <input type="hidden" name="showfields" id="showfields" value="">
                        <input type="hidden" name="editfields" id="editfields" value="">
                        <input type="hidden" name="notnullfields" id="notnullfields" value="">
                        <div class="nodeset_btn"><a class="nodeset_margin" href="javascript:void(0)" id="fsave">保存</a><a href="<?php echo $this->createUrl('/settings/formnode/index/' . $fid);?>">返回</a></div>
                    </form>
                </div><!--节点表格 结束-->
            </div><!--右侧工作流结束-->
         </div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>	
 <script type="text/javascript">
 //自适应高度
function heightChange(){
	var roadRight = document.getElementById("road_right");
	var bodyHeight = document.documentElement.clientHeight - 9 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	roadRight.style.height = bodyHeight + "px";
	roadRight.style.backgroundColor = "#fff";
}
heightChange();
window.onreset = heightChange;
//表单设置
$(function(){
	$(".node_table tr:odd").find("td").css({"background-color":"#f9f9f9","border-bottom-color":"#eef1f2"});
	});

//三个复选框 的全部选中按钮 START
$('#check_show').click(function(){
    if ($(this).prop("checked")) {
        $("input[name='showsub']").not(':checked').prop("checked",true);
    }else{
        $("input[name='showsub']").filter(':checked').prop("checked",false);
    } 
});

$('#check_edit').click(function(){
    if ($(this).prop("checked")) {
        $("input[name='editsub']").not(':checked').prop("checked",true);
    }else{
        $("input[name='editsub']").filter(':checked').prop("checked",false);
    } 
});

$('#check_null').click(function(){
    if ($(this).prop("checked")) {
        $("input[name='notnullsub']").not(':checked').prop("checked",true);
    }else{
        $("input[name='notnullsub']").filter(':checked').prop("checked",false);
    } 
});
//三个复选框 的全部选中按钮 END


//页面保存按钮
$('#fsave').click(function(){
    var showArr = basechk('showsub');
    var editArr = basechk('editsub');
    var notnullArr = basechk('notnullsub');
    $('#showfields').val(showArr);
    $('#editfields').val(editArr);
    $('#notnullfields').val(notnullArr);
    $('#nodeset_fomr').submit();
});

//jquery获取复选框值
function basechk(chname){  
    var chk_value =[];
    $('input[name="'+chname+'"]:checked').each(function(){
        chk_value.push($(this).attr('b'));
    });
    return chk_value;
}
        
</script>
