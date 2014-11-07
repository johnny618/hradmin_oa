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
        		    <?php echo $form->label($model, 'desc', array('class' => 'fl'))?>
        		    <?php echo $form->textField($model, 'desc', array('class' => 'fl'));?>
                    <span class="fl">!</span>
                    <?php echo $form->error($model, 'desc', array('style' => 'color:red;')); ?>
            	</div>
            	<div class="tabfd_title">
        		    <?php echo $form->label($model, 'pid', array('class' => 'fl'))?>
        		    <?php echo $form->dropDownList($model, 'pid', WorkForm::model()->getTopMenu(), array('empty' => '请选择', 'class' => 'fl'));?>
                    <span class="fl">!</span>
                    <?php echo $form->error($model, 'pid', array('style' => 'color:red;')); ?>
            	</div>
                <div class="tabfd_btn"><?php echo CHtml::link('保存', '#', array('onclick' => '$("#edit_form").submit();return false;'))?><a href="<?php echo $this->createUrl('/settings/workform/');?>">返回</a></div>
            <?php $this->endWidget();?>
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