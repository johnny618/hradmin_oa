<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	<div class="settype">
		<div class="settitle">新建：流程类型</div>
		<div id="setheight" class="settype_main settype_new_main">
			<div class="settype_table">
		    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'edit_form', 'enableClientValidation'=>true));?>
				<div class="settype_new">
					<div class="settype_newbox">
						<h4>基本信息</h4>
							<ul class="clearfix">
								<li>
								    <?php echo $form->label($model, 'name', array('class' => 'fl'))?>
									<?php echo $form->textField($model, 'name', array('class' => 'fl'))?>
									<span class="fl">!</span>
									<?php echo $form->error($model, 'name'); ?>
								</li>
								<li>
									<?php echo $form->label($model, 'desc', array('class' => 'fl'))?>
									<?php echo $form->textField($model, 'desc', array('class' => 'fl settype_newbox_input'))?>
									<span class="fl">!</span>
									<?php echo $form->error($model, 'desc'); ?>
								</li>
								<li>
									<?php echo $form->label($model, 'dsporder', array('class' => 'fl'))?>
									<?php echo $form->textField($model, 'dsporder', array('class' => 'fl'))?>
									<?php echo $form->error($model, 'dsporder'); ?>
								</li>
							</ul>
					</div>
				</div>
				<div class="settype_button"><?php echo CHtml::link('保存', '', array('class' => 'settype_button_a', 'onclick' => '$("#edit_form").submit();return false;'))?><a href="<?php echo $this->createUrl('/settings/workflow/listtype')?>">返回</a></div>
		    <?php $this->endWidget();?><!--新建流程 结束-->
			</div>
		</div>
	</div>
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.height = bodyHeight + "px";
}
window.onload = heightChange();
</script>