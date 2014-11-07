<script>
var addline = function() {
	$('tr:last').after($('tr:last').clone());
}
var changeFieldName = function() {
	$('tr').each(function(i){
		var $this = $(this);
	    if (i != 0) {
	        $this.find('input').each(function(j){
	            $(this).attr('name', $(this).attr('name').replace('item', 'item[' + (i - 1) + ']'));
	        });
	    }
	});
	return true;
}
</script>
<h1>编辑字段</h1>
<div style="margin-bottom:5px;">
<?php
echo CHtml::button('添加字段', array(
    'onclick' => 'addline();'
));
?>
</div>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'bs-example'
    )
));
?>
<table class="table table-hover">
<tr>
    <th>数据库字段名称</th>
    <th>字段显示名</th>
    <th>字段类型</th>
    <th>顺序</th>
</tr>
<?php if ($items) {?>
<?php foreach ($items as $key => $item) {?>
<tr>
    <td><?php echo CHtml::textField('item[db_field_name]', $item->db_field_name);?></td>
    <td><?php echo CHtml::textField('item[field_name]', $item->field_name);?></td>
    <td><?php echo CHtml::textField('item[field_type]', $item->field_type);?></td>
    <td><?php echo CHtml::textField('item[dsporder]', $item->dsporder);?></td>
</tr>
<?php }?>
<?php } else {?>
<tr>
    <td><?php echo CHtml::textField('item[db_field_name]');?></td>
    <td><?php echo CHtml::textField('item[field_name]');?></td>
    <td><?php echo CHtml::textField('item[field_type]');?></td>
    <td><?php echo CHtml::textField('item[dsporder]');?></td>
</tr>
<?php }?>
</table>
<?php
echo CHtml::submitButton('提交', array(
        'onclick' => 'return changeFieldName();'
));
$this->endWidget();
?>