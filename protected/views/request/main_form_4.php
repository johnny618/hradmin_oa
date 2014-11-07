<?php
if (!isset($request['body'][$item->db_field_name])) {
    $request['body'][$item->db_field_name] = null;
}
$options = json_decode($item->field_body);?>
<?php if ($type == 'main') {?>
<tr>
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
	<td class="qjia_bgcolor">
		<div class="qjia_td clearfix">
		<?php
		$htmlOptions = array('class' => 'qjia_select');
		if (!$can_edit) {
            echo $request['body'][$item->db_field_name];
		} else {
            echo CHtml::dropDownList($item->db_field_name, $request['body'][$item->db_field_name], array_combine($options, $options), $htmlOptions);
        }
		?>
		</div>
	</td>
</tr>
<?php } elseif ($type == 'detail') {?>
<td>
<?php echo CHtml::dropDownList($item->db_field_name, null, array_combine($options, $options), array('id' => $item->db_field_name));?>
</td>
<?php }?>