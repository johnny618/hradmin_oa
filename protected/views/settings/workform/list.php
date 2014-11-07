<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">表单管理</div>
		<div id="setheight" class="settype_main">
			<div class="tabmae_title">
            	<div class="settype_newbtn fl"><a href="<?php echo $this->createUrl('/settings/workform/addform');?>">添加</a></div>
                <div class="tabmae_title_right">
                	<form class="clearfix" name="tabmae_form" action="" method="post">
                    	<label class="fl">表单名称</label>
                		<div class="tabmae_input">
                        	<input type="text" name="names" value="<?php echo $searched_name;?>" />
                            <a href="#" onclick="$('form').submit();return false;"></a>
                        </div>
                    </form>
                </div>
            </div>
			<div class="settype_table">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="38%"><div class="settype_margin"><p>表单名称</p></div></th>
						<th width="38%"><p>表单描述</p></th>
						<th width="24%"><p class="settype_p">操作</p></th>
					</tr>
					<?php foreach ($forms as $form) {?>
                    <tr name="tr_<?php echo $form->id;?>">
						<td width="38%"><div class="settype_margin"><a href="<?php echo $this->createUrl('/settings/workform/editform/' . $form->id);?>"><?php echo $form->name;?></a></div></td>
						<td width="38%"><?php echo $form->desc;?></td>
						<td class="tabmae_td" width="24%">
						    <a href="<?php echo $this->createUrl('/settings/workform/editform/' . $form->id);?>">编辑</a>
						    <a href="<?php echo $this->createUrl('/settings/workform/index/' . $form->id);?>">删除</a>
					    </td>
					</tr>
					<?php }?>
				</table>
			</div>
		</div>
	</div><!--流程类型 结束-->
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
$('[name=del_btn]').click(function(){
	var _id = $(this).data('id');
    $.post('<?php echo $this->createUrl('/ajax/workform/delform');?>', {id:_id}, function(rs){
        if (rs.code == 0) {
            $('[name=tr_' + _id + ']').remove();
        } else {
            alert(rs.msg);
        }
    }, 'json');

});
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.minHeight = bodyHeight + "px";
}
window.onload = heightChange();
window.onresize = heightChange;
</script>