<?php
    $cs = Yii::app()->clientScript;
//    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/fileupload/jquery.ui.widget.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/timepicker/jquery-ui.min.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/fileupload/jquery.iframe-transport.js');
    $cs->registerScriptFile(Yii::app()->baseUrl . '/protected/assets/js/fileupload/jquery.fileupload.js');
    if (!isset($request['body'][$item->db_field_name])) {
        $request['body'][$item->db_field_name] = array();
    }
?>
<tr name="tr_<?php echo $item->db_field_name;?>">
	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
	<td class="qjia_bgcolor">
		<div class="qjia_td clearfix">
		    <form>
		        <input type="hidden" name="type" value="<?php echo $item->field_attr;?>">
    		    <input id="<?php echo $item->db_field_name;?>" type="file" name="files[]" data-url="<?php echo $this->createUrl('/ajax/upload/' . ($item->field_attr == 1 ? '?file=1' : ''));?>" multiple class="fl" <?php echo $can_edit ? '' : 'disabled';?>>
    		    <input type="hidden" name="<?php echo $item->db_field_name;?>_src" value="" />
    			<a class="qjia_clear fl" href="javascript:void(0)" id="<?php echo $item->db_field_name;?>_clean">清除所有选择</a>
    			<div></div>
			</form>
		</div>
	</td>
</tr>

<script>
var <?php echo $item->db_field_name;?>_imgs = new Array();
var baseUrl = '<?php echo Yii::app()->baseUrl?>';
<?php foreach ($request['body'][$item->db_field_name] as $val) {?>
    <?php echo $item->db_field_name;?>_imgs.push('<?php echo $val?>');
    <?php if ($item->field_attr == 1) {?>
    var _path = '<?php echo $val;?>'.split('/');
    $('#<?php echo $item->db_field_name;?>').parents('form').find('div').append('<a target="_blank" href="' + (baseUrl + '<?php echo $val?>') + '">' + _path[_path.length - 1].substr(32) + '</a>');
    <?php } else {?>
    $('#<?php echo $item->db_field_name;?>').parents('form').find('div').append('<a target="_blank" href="' + (baseUrl + '<?php echo $val?>') + '"><img style="width:70px;height:70px;margin-right:5px;" src="' + (baseUrl + '<?php echo $val?>') + '" /></a>');
    <?php }?>
<?php }?>
$('#<?php echo $item->db_field_name;?>').fileupload({
    dataType: 'json',
    done: function (e, data) {
    	if (data.jqXHR.status == 200) {
            if (data.result.code == 0) {
            	<?php echo $item->db_field_name;?>_imgs.push(data.result.msg);
            	<?php if ($item->field_attr == 1) {?>
            	var _path = data.result.msg.split('/');
            	$('#<?php echo $item->db_field_name;?>').parents('form').find('div').append('<a target="_blank" href="' + (baseUrl + data.result.msg) + '">' + _path[_path.length - 1].substr(32) + '</a>');
            	<?php } else {?>
            	$('#<?php echo $item->db_field_name;?>').parents('form').find('div').append('<a target="_blank" href="' + (baseUrl + data.result.msg) + '"><img style="width:70px;height:70px;margin-right:5px;" src="' + (baseUrl + data.result.msg) + '" /></a>');
            	<?php }?>
            } else {
            	alert(data.result.msg);
            }
        } else {
        	alert('批量上传失败');
        }
    }
});
$('#<?php echo $item->db_field_name;?>_clean').click(function(){
    $(this).parents('form').find('div img').remove();
    <?php echo $item->db_field_name;?>_imgs = [];
    return false;
});
</script>
