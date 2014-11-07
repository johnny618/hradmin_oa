<?php
$form = $this->beginWidget('CActiveForm');
?>
<h1>分类:<?php echo $category->name;?></h1>
<?php echo $form->errorSummary($model);?>
 <div class="row">
    <?php echo $form->label($model,'name'); ?>
    <?php echo $form->textField($model,'name') ?>
</div>
 <div class="row submit">
    <?php echo CHtml::submitButton('提交'); ?>
</div>

<?php $this->endWidget();?>