<?php
if ($tips) {
    echo '保存成功';
}
$form = $this->beginWidget('CActiveForm');
?>
<h1>分类:<?php echo $category->name;?></h1>
<?php echo $form->errorSummary($model);?>
<div class="row">
    <?php echo $form->label($model,'name'); ?>
    <?php echo $form->textField($model,'name') ?>
</div>
<?php
$this->widget('ext.wdueditor.WDueditor',array(
        'model' => $model,
        'attribute' => 'content',
        'width' =>'100%',
        'height' =>'300px',
        'htmlOptions' => array('value' => '请输入内容')
));
?>
 <div class="row submit">
    <?php echo CHtml::submitButton('提交'); ?>
</div>

<?php $this->endWidget();?>