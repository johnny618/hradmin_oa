<?php
if ($success) {
    echo '成功';
}
if ($error){
    echo '失败';
 }
?>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'bs-example'
    )
));
?>
<fieldset>
<legend>添加流程类型</legend>
<?php
echo $form->textField($model, 'name');
echo $form->textField($model, 'dsporder');
?>
</fieldset>
<?php
echo CHtml::submitButton('submit');
?>

<?php
$this->endWidget();
?>