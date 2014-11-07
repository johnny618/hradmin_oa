<?php
if ($tips) {
    echo '成功!<br/>';
}
?>

<?php
$form = $this->beginWidget('CActiveForm');
?>
 <div class="row">
    <?php echo $form->errorSummary($model);?>
    <?php echo $form->label($model,'name'); ?>
    <?php echo $form->textField($model,'name') ?>
</div>
 <div class="row submit">
    <?php echo CHtml::submitButton('提交'); ?>
</div>

<?php $this->endWidget();?>