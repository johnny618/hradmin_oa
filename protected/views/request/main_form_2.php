<?php
if (!isset($request['body'][$item->db_field_name])) {
    $request['body'][$item->db_field_name] = '';
}
if ($type == 'main') {?>
<tr>
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
	<td class="qjia_bgcolor">
		<div class="qjia_td clearfix">
            <?php if ($can_edit) {?>
			<textarea class="qjia_textarea fl" name="<?php echo $item->db_field_name;?>" id="<?php echo $item->db_field_name;?>" rows="<?php echo $item->field_attr;?>" <?php echo $can_edit ? '' : 'readonly'?>><?php echo $request['body'][$item->db_field_name];?></textarea>
            <?php } else {?>
            <textarea class="qjia_textarea fl" name="<?php echo $item->db_field_name;?>" id="<?php echo $item->db_field_name;?>" rows="<?php echo $item->field_attr;?>" style="display:none;"><?php echo $request['body'][$item->db_field_name];?></textarea>
            <?php echo $request['body'][$item->db_field_name];?>
            <?php }?>
		</div>
	</td>
</tr>
<?php } elseif ($type == 'detail') {?>
<td>
    <?php echo CHtml::textArea($item->db_field_name, null, array('style' => 'width:auto;', 'rows' => $item->field_attr, 'id' => $item->db_field_name));?>
</td>
<?php }?>