<?php $this->widget('RequestTableWidget', array('fid' => $request->fid, 'current_form_node' => $current_form_node, 'request' => $request, 'is_edit' => true));?>



<?php if (false) {?>
<!--[if IE]>
<style type="text/css">
.qjia_radio{margin-top: 1px;}
</style>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/liucheng/liucheng.css" />
<div class="pb20">
	<div id="liuch">
    	<div class="liuch_title">请求:创建 - <?php echo $work_form->name;?> - 创建</div>
        <div class="qjia"><!--请假申请 开始-->
        	<div class="qjia_title"><?php echo $work_form->name;?></div>
            <div class="qjia_table">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="17%"><span class="qjia_span">标题</span></td>
                        <td width="83%" class="qjia_bgcolor">
                            <div class="qjia_td clearfix">
                                <input class="qjia_input fl" type="text" name="title" value="<?php echo $request['title'];?>" readonly />
                            </div>
                        </td>
                    </tr>
                <?php foreach ($default_items as $item) {?>
                    <tr>
                    	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
                        <td class="qjia_bgcolor">
                        	<div class="qjia_td clearfix"><?php echo $item->field_type == 101 ? Yii::app()->user->name : Yii::app()->user->dept_cn;?></div>
                        </td>
                    </tr>
                <?php }?>
                <?php
                    foreach ($main_items as $m_item) {
                        if (in_array($m_item->id, $nodes['show'])) {
                            $this->renderPartial('main_form_' . $m_item->field_type, array('request' => $request, 'item' => $m_item, 'type' => 'main', 'can_edit' => in_array($m_item->id, $nodes['edit'])));
                        }
                    }
                ?>
                </table>
            </div>
        </div>
        <style>
        .sltable,.business{ border-collapse: collapse; width: 98%; margin: 20px auto; border: 1px solid #e7e7e7; background-color: #fff;}
        .sltable caption,.business caption{ text-align: left; margin-bottom: 10px;}
        .sltable td,.sltable th,.business td,.business th{ border: 1px solid #e7e7e7; padding: 5px;}
        .business tbody tr:nth-of-type(2n+1){background-color: #f9f9f9;}
        </style>
    <?php
        if ($detail_items) {
            foreach ($detail_items as $k => $detail_item) {
    ?>
    <form id="detail_form_<?php echo $k;?>">
        <table class="business">
            <caption>
                <a href="javascript:;" class="oa-btn" name="add_detail_line" data-id="detail_line_<?php echo $k;?>">添加</a><a href="javascript:;" class="oa-btn" name="del_detail_line">删除</a>
            </caption>
            <thead>
                <tr>
                <th>序号</th>
                <?php
                foreach ($detail_item as $detail_line) {
                    echo '<th>' . $detail_line->field_name . '</th>';
                }?>
                </tr>
            </thead>
            <tbody id="detail_tr_<?php echo $k;?>">
                <tr>
                <td><input type="checkbox" name="xuhao"></td>
                <?php
                foreach ($detail_item as $detail_line) {
                    $this->renderPartial('main_form_' . $detail_line->field_type, array('item' => $detail_line, 'type' => 'detail'));
                }
                ?>
                <input type="hidden" name="detail_line_type" value="<?php echo $detail_line->type;?>"/>
                </tr>
            </tbody>
            <script>
            <?php
                $html = '<td><input type="checkbox" name="xuhao"></td>';
                foreach ($detail_item as $detail_line) {
                    $html .= $this->renderPartial('main_form_' . $detail_line->field_type, array('request' => $request, 'item' => $detail_line, 'type' => 'detail'), true);
                }
            ?>
            var detail_line_<?php echo $k;?> = <?php echo json_encode('<tr>' . $html. '<input type="hidden" name="detail_line_type" value="' . $detail_line->type . '"/></tr>')?>;
            </script>
        </table>
    </form>
        <?php }
        }?>
        <div class="qjia_btn"><a href="#" id="submit_request" class="oa-btn">提交</a></div>
    </div>
</div>
<script type="text/javascript">
$('table [name=del_detail_line]').click(function(){
	var $this = $(this);
	if ($this.parents('table').find('tbody tr').length <= $this.parents('table').find('input[name=xuhao]:checked').length) {
	    alert('不能全部删除');
	    return false;
	}
	$this.parents('table').find('input[name=xuhao]:checked').each(function(index){
        $(this).parents('tr').remove();
	});
	return false;
});
$('table [name=add_detail_line]').click(function(){
	var $this = $(this);
    var _id = $this.data('id');
    if ($this.parents('table').find('tbody tr:last').length > 0) {
        $this.parents('table').find('tbody tr:last').after(eval(_id));
    } else {
    	$this.parents('table').find('tbody:last').append(eval(_id));
    }
    $this.parents('table').find('tr:last input[attr-type=1-3]').each(function(){
        var _this = $(this);
        _this.attr('id', 'time' + parseInt(Math.random() * 10000));
        $('#' + _this.attr('id')).datetimepicker({
            timeFormat: "HH:mm:ss",
            dateFormat: "yy-mm-dd"
        });
    });
    return false;
});
<?php
if (isset($request['body']['detail_datas'])) {
    foreach ($request['body']['detail_datas'] as $key => $data) {
        foreach ($data as $d) {?>
            $('table [name=add_detail_line][data-id=detail_line_<?php echo $key?>]').click();
            <?php foreach ($d as $k => $v) {?>
            if ($('table [name=add_detail_line][data-id=detail_line_<?php echo $key?>]').parents('table').find('tr:last [name=<?php echo $k?>]').is(':checkbox')) {
            	$('table [name=add_detail_line][data-id=detail_line_<?php echo $key?>]').parents('table').find('tr:last [name=<?php echo $k?>]').attr('checked', <?php echo $v == 1 ? 'true' : 'false'?>);
            } else {
            	$('table [name=add_detail_line][data-id=detail_line_<?php echo $key?>]').parents('table').find('tr:last [name=<?php echo $k?>]').val('<?php echo $v;?>');
            }
            <?php }?>
        <?php }?>
        	$('table [name=add_detail_line][data-id=detail_line_<?php echo $key?>]').parents('table').find('tr').eq(1).remove();
        <?php
    }
}
?>
$('#submit_request').click(function(){
<?php
$datas = array();
$datas[] = 'id:' . $main_items[0]->fid;
foreach ($main_items as $m_item) {?>
    <?php if ($m_item->field_type == 3) {?>
    var <?php echo $m_item->db_field_name;?> = $('#<?php echo $m_item->db_field_name;?>').val();
    <?php } elseif ($m_item->field_type == 5) {?>
    var <?php echo $m_item->db_field_name;?> = <?php echo $m_item->db_field_name;?>_imgs;
    <?php } elseif ($m_item->field_type == 6) {
        continue;
    } else {?>
    var <?php echo $m_item->db_field_name;?> = $('#<?php echo $m_item->db_field_name;?>').val()
    <?php }
    if ($m_item->field_type != 6) {
        $datas[] = $m_item->db_field_name . ':' . $m_item->db_field_name;
    }
}
$detail_datas = array();
foreach ($detail_items as $k => $v) {
    $datas[] = 'detail_form_' . $k . ':' . '$("#detail_form_' . $k . '").serializeArray()';
}
?>
    $.post('<?php echo $this->createUrl('/ajax/request/edit')?>', {<?php echo implode(',', $datas)?>}, function(rs){
        if (rs.code == 0) {
            alert(rs.msg);
            location.href = '<?php echo $this->createUrl('/request/my?type=0');?>';
        } else {
        	alert(rs.msg);
        }
    }, 'json');
    return false;
});
//自适应高度
function liuCheng(){
	var liuCh = document.getElementById("liuch");
	var bodyHeight = document.documentElement.clientHeight;
	liuCh.style.minHeight = bodyHeight + "px";
}
window.onload = liuCheng;
window.onresize = liuCheng;
</script>
<?php }?>