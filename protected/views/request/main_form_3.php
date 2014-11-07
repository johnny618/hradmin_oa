<?php
if (!isset($request['body'][$item->db_field_name])) {
    $request['body'][$item->db_field_name] = false;
}
if ($type == 'main') {?>
<tr>
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
	<td class="qjia_bgcolor">
		<div class="qjia_td clearfix">
		<?php
		    $htmlOptions = array();
    		if (!$can_edit) {
    		    echo $request['body'][$item->db_field_name];
    		} else {
                echo CHtml::checkBox($item->db_field_name, $request['body'][$item->db_field_name], $htmlOptions);
            }
            ?>
			<span class="qjia_importan qjia_importan2">!</span>
		</div>
	</td>
</tr>
<?php } elseif ($type == 'detail') {?>
<td>
<?php echo CHtml::checkBox($item->db_field_name, null, array('id' => $item->db_field_name));?>
</td>
<?php }?>