<!--[if IE]>
<style type="text/css">
.qjia_radio{margin-top: 1px;}
</style>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/liucheng/liucheng.css" />
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo Yii::app()->createUrl('/ajax/apiajax/ajax')?>';
    r_mail = true;
    r_power = true;
</script>
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
                            <?php if ($this->is_edit) {?>
                                <?php echo $request['title'];?>
                                <input class="qjia_input fl" type="hidden" name="title" value="<?php echo $request['title'];?>" />
                            <?php } else {?>
                                <?php echo isset($request['title']) ? $request['title'] : ($work_form->name . '-' . Yii::app()->user->name . '-' . date('Y-m-d'))?>
                                <input class="qjia_input fl" type="hidden" name="title" value="<?php echo isset($request['title']) ? $request['title'] : ($work_form->name . '-' . Yii::app()->user->name . '-' . date('Y-m-d'))?>" readonly />
                            <?php }?>
                            </div>
                        </td>
                    </tr>
                <?php foreach ($default_items as $item) {?>
                    <tr>
                    	<td><span class="qjia_span"><?php echo $item->field_name;?></span></td>
                        <td class="qjia_bgcolor">
                            <div class="qjia_td clearfix"><?php echo $item->field_attr == 101 ? (isset($request['title']) ? $request['title'] : Yii::app()->user->name) : (isset($request['dept_cn']) ? $request['dept_cn'] : Yii::app()->user->dept_cn); ?></div>
                        </td>
                    </tr>
                <?php }?>
                <?php
                    foreach ($main_items as $m_item) {
                        if (in_array($m_item->id, $nodes['show'])) {
                            $this->controller->renderPartial('main_form_' . $m_item->field_type, array('request' => $request, 'item' => $m_item, 'type' => 'main', 'can_edit' => in_array($m_item->id, $nodes['edit'])));
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
            <tbody>
                <tr>
                <td><input type="checkbox" name="xuhao"></td>
                <?php
                foreach ($detail_item as $detail_line) {
                    $this->controller->renderPartial('main_form_' . $detail_line->field_type, array('item' => $detail_line, 'type' => 'detail'));
                }?>
                <input type="hidden" name="detail_line_type" value="<?php echo $detail_line->type;?>"/>
                </tr>
            </tbody>
            <script>
            <?php
                $html = '<td><input type="checkbox" name="xuhao"></td>';
                foreach ($detail_item as $detail_line) {
                    $html .= $this->controller->renderPartial('main_form_' . $detail_line->field_type, array('item' => $detail_line, 'type' => 'detail'), true);
                }
            ?>
            var detail_line_<?php echo $k;?> = <?php echo json_encode('<tr>' . $html. '<input type="hidden" name="detail_line_type" value="' . $detail_line->type . '"/></tr>')?>;
            </script>
        </table>
    </form>
        <?php }
        }?>
        <?php if ($this->is_approve) { ?>
            <textarea name="tip" id="tip" class="tip"></textarea>
        <?php }?>
        <?php if (!$this->is_show) {?>
        <div class="qjia_btn">
            <?php if (!$next_node) {?>
            <a href="#" id="submit_request" class="oa-btn">提交</a>
            <?php } else {?>
            <a href="#" id="submit_request" class="oa-btn"><?php echo $next_node['nodeinfo']['name'];?></a>
            <?php if (isset($next_node['isback']) && $next_node['isback'] == 1) {?>
            <a href="#" id="submit_back" class="oa-btn">退回</a>
            <?php }?>
            <?php }?>
            <?php if ($this->is_edit) {?>
                <a class="oa-btn" href="#" name="del_request">删除</a>
                <script>
                    $('[name=del_request]').click(function(){
                        if (confirm('确认删除?')) {
                            $.post('<?php echo $this->controller->createUrl('/ajax/request/del')?>', {id:<?php echo $request['id'];?>}, function(rs){
                                if (rs.code == 0) {
                                    alert('删除成功');
                                    window.close();
                                } else {
                                    alert(rs.msg);
                                }
                            }, 'json');
                        }
                        return false;
                    });
                </script>
            <?php }?>
        </div>
        <?php }?>
        <?php if (empty($request['id'])){ ?>
            <div style="margin-left:10px;"><a target="_blank" href="<?php echo $this->controller->createUrl('/settings/formview/index/fid/' . $work_form->id. '?viewtype=1&status=' . $this->current_form_node->id);?>" class="oa-btn">查看流程图</a><a class="oa-btn" href="#" name="print_btn" >切换打印模式</a></div>
        <?php }else{?>
            <div style="margin-left:10px;"><a target="_blank" href="<?php echo $this->controller->createUrl('/settings/formview/index/fid/' . $work_form->id. '?viewtype=1&requestid='.$request['id'].'&status=' . $this->current_form_node->id);?>" class="oa-btn">查看流程图</a><a class="oa-btn" href="#" name="print_btn" >切换打印模式</a></div>
        <?php }?>
        
        <script>
            $('[name=print_btn]').click(function(){
                $('input[type=text],select').each(function(){
                    var $this = $(this);
                    $this.parent().append($this.val());
                    $this.hide();
                });
                $(this).hide();
                return false;
            });
        </script>
        <?php if ($operate_table) {?>
        <table class="search-result">
			<thead>
				<tr>
					<th><p>节点</p></th>
					<th><p>意见</p></th>
					<th><p>操作</p></th>
				</tr>
			</thead>
			<tbody>
			<?php
			$back_result = false;
			foreach ($operate_table as $key => $operate) {
                            $operate_tip = $operate->current_node->name;
                            if ($key == 0) {
                                $back_result = $operate->current_node->id;
                            } else {
                                if ($operate->current_node->id == $back_result && !$operate->next_status) {
                                    $operate_tip = '退回';
                                }
                            }
                        ?>
				<tr>
					<td><?php echo $operate->current_node->name;?></td>
                                        <td><span style="color: blue"><?php echo addslashes($operate->tip)?></span><br/><?php echo $operate->operater->uname;?><br/><?php echo $operate->updated?></td>
					<td><?php echo $operate_tip;?></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
		<?php }?>
    </div>
</div>
<script type="text/javascript"> 
<?php if ($this->is_approve) {?>
    $(document).ready(function () {
            tip = CKEDITOR.replace( 'tip',{
                skin:'kama',
                toolbar:[    ['Font','-','FontSize','-','TextColor','BGColor','-','Bold','Italic','Underline','-','JustifyLeft','JustifyCenter','JustifyRight','-','NumberedList','BulletedList','Table']],
                resize_minWidth:'510',
                resize_maxWidth:'616',
                width:'98%',
                margin:'10px auto 0',
                //colorButton_colors:'333333,008000,000080,800080,C90000,FFFF00,EBEBEB',
                colorButton_enableMore:false,
                fontSize_sizes:'12/12px;14/14px;16/16px;18/18px;24/24px',
                font_names:'宋体/宋体,Arial, Helvetica, sans-serif;黑体/黑体,Arial, Helvetica, sans-serif;楷体/楷体, 楷体_GB2312,Arial, Helvetica, sans-serif;',
                pasteFromWordRemoveFontStyles:true,
                pasteFromWordRemoveStyles:true
            });
    });
        
$('#submit_back').click(function(){    
    $.post('<?php echo $this->controller->createUrl('/ajax/request/back');?>', {id:<?php echo $request['id'];?>, UE_tip:tip.document.getBody().getHtml() }, function(rs){
        alert(rs.msg);
        try {
            window.opener.location.reload();
        } catch (err) {}
        window.close();
    }, 'json');
    return false;
});
<?php }?>
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
if (isset($request['body']['detail_datas']) && is_array($request['body']['detail_datas'])) {
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

    if (!r_mail){
        return false;
    }
<?php
$datas = array();
$datas[] = 'id:' . $main_items[0]->fid;
foreach ($main_items as $m_item) {?>
    <?php if ($m_item->field_type == 3) {?>
    var <?php echo $m_item->db_field_name;?> = $('#<?php echo $m_item->db_field_name;?>').is(':checked');
    <?php } elseif ($m_item->field_type == 5) {?>
    var <?php echo $m_item->db_field_name;?> = typeof <?php echo $m_item->db_field_name;?>_imgs == 'undefined' ? '' : <?php echo $m_item->db_field_name;?>_imgs;
    <?php } elseif ($m_item->field_type == 6) {
        continue;
    }else {?>
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
if ($this->is_edit) {
    $datas[] = 'request_id:' . $request['id'];
}
if ($this->is_approve) {
    $datas[] = 'request_id:' . $request['id'];
    $datas[] = 'next_goal:' . $next_node['node_id'];
    $datas[] = 'UE_tip:tip.document.getBody().getHtml()';
}
$datas[] = 'current_form_node_id:' . $this->current_form_node->id;
?>
    $.post('<?php echo $this->controller->createUrl('/ajax/request/update')?>', {<?php echo implode(',', $datas)?>}, function(rs){
        if (rs.code == 0) {
            alert(rs.msg);
            try {
            	window.opener.location.reload();
            } catch (err) {}
            window.close();
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