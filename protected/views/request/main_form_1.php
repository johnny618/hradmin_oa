<?php
if ($item->field_attr == 3) {
    $cs = Yii::app()->clientScript;
    $cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/timepicker/jquery-ui.css');
    $cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/timepicker/jquery-ui-timepicker-addon.css');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/timepicker/jquery-ui.min.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/timepicker/jquery-ui-timepicker-addon.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/timepicker/jquery.ui.datepicker-zh-CN.js.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/timepicker/jquery-ui-timepicker-zh-CN.js');
}?>
<?php if ($type == 'main') {
    if (!isset($request['body'][$item->db_field_name])) {
        $request['body'][$item->db_field_name] = '';
    }
?>
<tr>
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
    <td class="qjia_bgcolor">
    	<div class="qjia_td clearfix">
            <?php if ($can_edit) {?>
            <input class="qjia_input2 fl" type="text" name="<?php echo $item->db_field_name;?>" value="<?php echo $request['body'][$item->db_field_name];?>" id="<?php echo $item->db_field_name;?>"/>
            <?php } else {?>
            <?php echo $request['body'][$item->db_field_name];?>
            <input class="qjia_input2 fl" type="hidden" name="<?php echo $item->db_field_name;?>" value="<?php echo $request['body'][$item->db_field_name];?>" id="<?php echo $item->db_field_name;?>"/>
            <?php }?>
        	<?php if ($item->field_attr == 3 && $can_edit) {?>
    	    <script>
        	    $('#<?php echo $item->db_field_name?>').datetimepicker({
                    timeFormat: "HH:mm:ss",
                    dateFormat: "yy-mm-dd"
                });
            </script>
        	<?php }?>
        </div>
    </td>
</tr>
<?php } elseif ($type == 'detail') {?>
<td><?php echo CHtml::textField($item->db_field_name . '', null, array('id' => $item->db_field_name, 'attr-type' => $item->field_type . '-' . $item->field_attr));?></td>
<?php if ($item->field_attr == 3) {?>
<?php $cs->registerScript($item->db_field_name, '$("#' . $item->db_field_name . '").datetimepicker({timeFormat: "HH:mm:ss",dateFormat: "yy-mm-dd"});');?>
<?php }?>
<?php }?>