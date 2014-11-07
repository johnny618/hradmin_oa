<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">表单管理：字段</div>
		<div id="setheight" class="settype_main tabfd">
        	<?php $form = $this->beginWidget('CActiveForm', array('id' => 'edit_form', 'enableClientValidation'=>true));?>
        		<div class="tabfd_title">
        		    <?php echo $form->label($model, 'name', array('class' => 'fl'))?>
        		    <?php echo $form->textField($model, 'name', array('class' => 'fl'))?>
                    <span class="fl">!</span>
                    <?php echo $form->error($model, 'name', array('style' => 'color:red;')); ?>
            	</div>
            	<div class="tabfd_title">
        		    <?php echo $form->label($model, 'pid', array('class' => 'fl'))?>
        		    <?php echo $form->dropDownList($model, 'pid', WorkForm::model()->getTopMenu(), array('empty' => '请选择', 'class' => 'fl'));?>
                    <span class="fl">!</span>
                    <?php echo $form->error($model, 'pid', array('style' => 'color:red;')); ?>
            	</div>
                <div class="tabfd_btn"><?php echo CHtml::link('保存', '#', array('onclick' => '$("#edit_form").submit();return false;'))?><a href="<?php echo $this->createUrl('/settings/workform/');?>">返回</a></div>
            <?php $this->endWidget();?>
			<div class="settype_table tabfd_table">
            	<div class="tabfd_add"><a href="<?php echo $this->createUrl('/settings/workform/editformitem/' . $item->id);?>">批量添加</a></div>
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<th width="19"><div class="settype_margin"><p>字段名称</p></div></th>
						<th width="19%"><p>字段显示名</p></th>
						<th width="15%"><p>表现形式</p></th>
                        <th width="15%"><p>字段类型</p></th>
                        <th width="10%"><p>显示顺序</p></th>
                        <th width="22%"><p class="settype_p">操作</p></th>
					</tr>
				<?php foreach ($form_items as $_item) {?>
                    <tr>
						<td><div class="settype_margin"><a href="#"><?php echo $_item->db_field_name;?></a></div></td>
						<td><?php echo $_item->field_name;?></td>
                        <td>主表字段</td>
                        <td><?php echo MyConst::$formType[$_item->field_type];?></td>
                        <td><?php echo $_item->dsporder;?></td>
						<td class="tabmae_td"><a href="<?php echo $this->createUrl('/settings/workform/editformitem/' . $_item->fid);?>">编辑</a></td>
					</tr>
				<?php }?>
				</table>
			</div>
		</div>
	</div><!--流程类型 结束-->
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.minHeight = bodyHeight + "px";
}
window.onload = heightChange();
window.onresize = heightChange;
</script>
</div>