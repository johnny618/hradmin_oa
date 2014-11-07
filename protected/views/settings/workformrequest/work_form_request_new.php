<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'bs-example'
    )
));
?>
<fieldset>
<legend>新建流程-<?php echo $form_info->form_name; ?></legend>
</fieldset>
<?php foreach ($form_info->items as $item) { ?>
    <?php
        echo CHtml::label($item->field_name, '');
        echo CHtml::textField($item->db_field_name);
    ?>
<?php }?>
<?php
echo CHtml::submitButton('submit');
?>

<?php
$this->endWidget();
?>