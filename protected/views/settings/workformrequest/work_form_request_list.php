<table class="table table-hover">
<tr>
    <th>表单名称</th>
    <th>操作</th>
</tr>
<?php foreach ($WorkForms as $form) {?>
<tr>
    <td><?php echo $form->form_name?></td>
    <td><?php echo CHtml::linkButton('申请', array('url' => $this->createUrl('/settings/workformrequest/new/' . $form->id)))?></td>
</tr>
<?php }?>
</table>