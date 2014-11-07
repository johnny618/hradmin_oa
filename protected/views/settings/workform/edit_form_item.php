<!--[if IE]>
<style type="text/css">
	.tabbth_redact{margin-top: 2px;}
    .tabbth_chact_check{margin: 3px 16px 0 0;}
</style>
<![endif]-->
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/underscore.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<div class="set">
	 <div class="settype"><!--流程类型 开始-->
		<div class="settitle">表单管理：批量添加字段</div>
		<div id="setheight" class="settype_main tabbth">
        	<div class="tabbth_title">
            	主字段信息
                <div class="tabbth_btn"><a href="javascript:void(0)" name="add_main_tr">添加</a><?php if (!$can_del) {?><a href="javascript:void(0)" name="del_tr_main">删除</a><?php }?></div>
            </div>
			<div class="settype_table tabfd_table">
            	<form name="tabbth_form" action="" method="post">
                    <table class="tabbth_table" width="100%" cellpadding="0" cellspacing="0" name="main_table">
                        <tr>
                            <th width="9"><div class="settype_margin"><p><input type="checkbox" name="tabbth_all" /></p></div></th>
                            <th width="18%"><p>数据库字段名称</p></th>
                            <th width="18%"><p>字段显示名</p></th>
                            <th width="41%"><p>字段类型</p></th>
                            <th width="14%"><p class="settype_p">顺序</p></th>
                        </tr>
                        <?php foreach ($main_items as $item) {?>
<tr>
                            <td><div class="settype_margin"><input type="checkbox" name="tabbth_check" /></div></td>
                            <td><input class="fl" type="text" name="numer_name" value="<?php echo $item->db_field_name;?>" /><span class="fl">!</span></td>
                            <td><input class="fl" type="text" name="text_name" value="<?php echo $item->field_name;?>" /><span class="fl">!</span></td>
                            <td class="tabbth_minwth">
                            <?php echo CHtml::dropDownList('item_type', $item->field_type, MyConst::$formType, array('class' => 'fl tabbth_mr6'));?>
                                <div class="tabbth_box item tabbth_box_show clearfix"><!--单行文本框 开始-->
                                	<label class="fl">类型</label>
                            	    <?php echo CHtml::dropDownList('type_sub', $item->field_type == 1 ? $item->field_attr : '', MyConst::$formItem['1'], array('class' => 'fl'));?>
<!--                                     <em class="fl">文本长度</em> -->
<!--                                     <input class="tabbth_order fl" type="text" name="length" value="" /> -->
<!--                                     <b class="fl">!</b> -->
                                </div><!--单行文本框 结束-->
                                <div class="tabbth_box item clearfix"><!--多行文本框 开始-->
                                	<label class="fl">高度</label>
                                    <input class="tabbth_order fl" type="text" name="height" value="<?php echo $item->field_type == 2 ? $item->field_attr : '1'?>" />
<!--                                     <em class="fl">Html编辑字段</em> -->
<!--                                     <input class="tabbth_redact" type="checkbox" name="redact_check" /> -->
                                </div><!--多行文本框 结束-->
                                <div class="tabbth_box item clearfix"><!--check 开始--></div><!--check 结束-->
                                <div class="tabbth_box item clearfix"><!--选择框 开始-->
                                	<div class="tabbth_choose"><a href="javascript:void(0)" name="add_choose">添加内容</a><a href="javascript:void(0)" name="del_choose">删除内容</a></div>
                                    <div class="tabbth_chact">
                                    	<div class="tabbth_chact_title"><span>选中</span>可选文字</div>
                                    	<?php if ($item->field_type == 4) foreach (json_decode($item->field_body) as $attr){ ?>
                                         <div class="tabbth_chact_input">
                                        	<input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
                                            <input class="fl" type="text" name="chact_text" value="<?php echo $attr?>" />
                                            <b>!</b>
                                        </div>
                                    	<?php }?>
                                    </div>
                                </div><!--选择框 结束-->
                                <div class="tabbth_box item clearfix"><!--附件上传 开始-->
                                	<label class="fl">类型</label>
                                    <?php echo CHtml::dropDownList('type_sub', $item->field_type == 5 ? $item->field_attr : '', MyConst::$formItem['5'], array('class' => 'fl'));?>
                                    <div class="sub_item"></div>
                                    <div class="clearfix sub_item">
                                    	<em class="fl">每行显示图片数</em>
                                    	<input class="tabbth_order fl" type="text" name="length" value="<?php echo ($item->field_type == 5 && json_decode($item->field_body)) ? current(json_decode($item->field_body)) : ''?>" />
                                    </div>
                                </div><!--附件上传 结束-->
                                <div class="tabbth_box item clearfix"><!--特殊字段 开始-->
                                	<div class="tabbth_choose clearfix">
                                    	<label class="fl">类型</label>
                                    	<?php echo CHtml::dropDownList('type_sub', $item->field_type == 6 ? $item->field_attr : '', MyConst::$formItem['6'], array('class' => 'fl'));?>
                                    </div>
                                    <div class="tabbth_chact sub_item">
                                    <?php
                                        $field_attr = '';
                                        if ($item->field_type == 6 && $item->field_attr == 1) {
                                            $field_attr = json_decode($item->field_body);
                                        }
                                    ?>
                                        <ul class="clearfix">
                                        	<li><label class="fl">显示名</label><input type="text" name="show_name" value="<?php echo isset($field_attr[0]) ? $field_attr[0] : '';?>" /></li>
                                            <li><label class="fl">链接地址</label><input type="text" name="show_url" value="<?php echo isset($field_attr[1]) ? $field_attr[1] : ''?>" /></li>
                                        </ul>
                                        <p>外部地址请加上HTTP://</p>
                                    </div>
                                    <div class="tabbth_chact sub_item">
                                        <label class="fl">描述性文字</label>
                                        <?php
                                            $field_attr = '';
                                            if ($item->field_type == 6 && $item->field_attr == 2) {
                                                $field_attr = json_decode($item->field_body);
                                            }
                                        ?>
                                        <textarea class="fl" name="describe_text"><?php echo isset($field_attr[0]) ? $field_attr[0] : '';?></textarea>
                                    </div>
                                </div><!--特殊字段 结束-->
                            </td>
                            <td><input class="tabbth_order" type="text" name="order" value="<?php echo $item->dsporder;?>" /><input type="hidden" name="tr_id" value="<?php echo $item->id;?>" /></td>
                        </tr>
                        <?php }?>
                    </table>
                    <div class="tabbth_add"><a href="#" name="add_detail">添加多明细</a></div>
                <?php
                    foreach ($detail_items as $details) {?>
                    <div style="margin-top:15px;" name="detail_div">
                        <div class="tabbth_title tabbth_title_down">
                            <div class="tabbth_btn"><a href="javascript:void(0)" name="add_detail_tr">添加</a><?php if (!$can_del) {?><a href="javascript:void(0)" name="del_tr">删除</a><?php }?></div>
                		</div>
                        <table class="tabbth_table tabbth_table_down" name="detail_table" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <th width="9"><div class="settype_margin"><p><input type="checkbox" name="tabbth_all" /></p></div></th>
                                <th width="18%"><p>数据库字段名称</p></th>
                                <th width="18%"><p>字段显示名</p></th>
                                <th width="41%"><p>字段类型</p></th>
                                <th width="14%"><p class="settype_p">顺序</p></th>
                            </tr>
                        <?php foreach ($details as $detail_item) {?>
                            <tr>
                                <td><div class="settype_margin"><input type="checkbox" name="tabbth_check" /></div></td>
                                <td><input class="fl" type="text" name="numer_name" value="<?php echo $detail_item->db_field_name;?>" /><span class="fl">!</span></td>
                                <td><input class="fl" type="text" name="text_name" value="<?php echo $detail_item->field_name;?>" /><span class="fl">!</span></td>
                                <td class="tabbth_minwth">
                                    <?php echo CHtml::dropDownList('item_type', $detail_item->field_type, MyConst::$formTypeDetail, array('class' => 'fl tabbth_mr6'));?>
                                    <div class="tabbth_box item tabbth_box_show clearfix"><!--单行文本框 开始-->
                                    	<label class="fl">类型</label>
                                        <?php echo CHtml::dropDownList('type_sub', $detail_item->field_type == 1 ? $detail_item->field_attr : '', MyConst::$formItem[1], array('class' => 'fl'));?>
    <!--                                     <em class="fl">文本长度</em> -->
    <!--                                     <input class="tabbth_order fl" type="text" name="length" value="" /> -->
    <!--                                     <b class="fl">!</b> -->
                                    </div><!--单行文本框 结束-->
                                    <div class="tabbth_box item clearfix"><!--多行文本框 开始-->
                                    	<label class="fl">高度</label>
                                        <input class="tabbth_order fl" type="text" name="height" value="<?php echo $detail_item->field_type == 2 ? $item->field_attr : '1'?>" />
    <!--                                     <em class="fl">Html编辑字段</em> -->
    <!--                                     <input class="tabbth_redact" type="checkbox" name="redact_check" /> -->
                                    </div><!--多行文本框 结束-->
                                    <div class="tabbth_box item clearfix"><!--check 开始--></div><!--check 结束-->
                                    <div class="tabbth_box item clearfix"><!--选择框 开始-->
                                    	<div class="tabbth_choose"><a href="javascript:void(0)" name="add_choose">添加内容</a><a href="javascript:void(0)" name="del_choose">删除内容</a></div>
                                        <div class="tabbth_chact">
                                        	<div class="tabbth_chact_title"><span>选中</span>可选文字</div>
                                        	<?php if ($detail_item->field_type == 4) foreach (json_decode($detail_item->field_body) as $attr){ ?>
                                             <div class="tabbth_chact_input">
                                            	<input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
                                                <input class="fl" type="text" name="chact_text" value="<?php echo $attr?>" />
                                                <b>!</b>
                                            </div>
                                        	<?php }?>
                                        </div>
                                    </div><!--选择框 结束-->
                                </td>
                                <td><input class="tabbth_order" type="text" name="order" value="<?php echo $detail_item->dsporder;?>" /><input type="hidden" name="tr_id" value="<?php echo $detail_item->id;?>" /></td>
                            </tr>
                        <?php }?>
                        </table>
                    </div>
                    <?php }?>
                    <div class="tabbth_btn_down"><a href="#" name="submit_form">保存</a><a href="<?php echo $this->createUrl('/settings/workform/editform/' . $form->id);?>">返回</a></div>
                </form>
			</div>
		</div>
	</div><!--流程类型 结束-->
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/template" id="choose_html">
<div class="tabbth_chact_input">
    <input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
    <input class="fl" type="text" name="chact_text" value="" />
    <b>!</b>
</div>
</script>
<script type="text/template" id="main_tr_html">
<tr>
    <td><div class="settype_margin"><input type="checkbox" name="tabbth_check" /></div></td>
    <td><input class="fl" type="text" name="numer_name" value="" /><span class="fl">!</span></td>
    <td><input class="fl" type="text" name="text_name" value="" /><span class="fl">!</span></td>
    <td class="tabbth_minwth">
    <?php echo CHtml::dropDownList('item_type', '', MyConst::$formType, array('class' => 'fl tabbth_mr6'));?>
        <div class="tabbth_box item tabbth_box_show clearfix"><!--单行文本框 开始-->
        	<label class="fl">类型</label>
    	    <?php echo CHtml::dropDownList('type_sub', '', MyConst::$formItem['1'], array('class' => 'fl'));?>
<!--                                     <em class="fl">文本长度</em> -->
<!--                                     <input class="tabbth_order fl" type="text" name="length" value="" /> -->
<!--                                     <b class="fl">!</b> -->
        </div><!--单行文本框 结束-->
        <div class="tabbth_box item clearfix"><!--多行文本框 开始-->
        	<label class="fl">高度</label>
            <input class="tabbth_order fl" type="text" name="height" value="1" />
<!--                                     <em class="fl">Html编辑字段</em> -->
<!--                                     <input class="tabbth_redact" type="checkbox" name="redact_check" /> -->
        </div><!--多行文本框 结束-->
        <div class="tabbth_box item clearfix"><!--check 开始--></div><!--check 结束-->
        <div class="tabbth_box item clearfix"><!--选择框 开始-->
        	<div class="tabbth_choose"><a href="javascript:void(0)" name="add_choose">添加内容</a><a href="javascript:void(0)" name="del_choose">删除内容</a></div>
            <div class="tabbth_chact">
            	<div class="tabbth_chact_title"><span>选中</span>可选文字</div>
                <div class="tabbth_chact_input">
                	<input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
                    <input class="fl" type="text" name="chact_text" value="" />
                    <b>!</b>
                </div>
            </div>
        </div><!--选择框 结束-->
        <div class="tabbth_box item clearfix"><!--附件上传 开始-->
        	<label class="fl">类型</label>
            <?php echo CHtml::dropDownList('type_sub', '', MyConst::$formItem['5'], array('class' => 'fl'));?>
            <div class="sub_item"></div>
            <div class="clearfix sub_item">
            	<em class="fl">每行显示图片数</em>
            	<input class="tabbth_order fl" type="text" name="length" value="" />
            </div>
        </div><!--附件上传 结束-->
        <div class="tabbth_box item clearfix"><!--特殊字段 开始-->
        	<div class="tabbth_choose clearfix">
            	<label class="fl">类型</label>
            	<?php echo CHtml::dropDownList('type_sub', '', MyConst::$formItem['6'], array('class' => 'fl'));?>
            </div>
            <div class="tabbth_chact sub_item">
                <ul class="clearfix">
                	<li><label class="fl">显示名</label><input type="text" name="show_name" value="" /></li>
                    <li><label class="fl">链接地址</label><input type="text" name="show_url" value="" /></li>
                </ul>
                <p>外部地址请加上HTTP://</p>
            </div>
            <div class="tabbth_chact sub_item">
                <label class="fl">描述性文字</label>
                <textarea class="fl" name="describe_text"></textarea>
            </div>
        </div><!--特殊字段 结束-->
    </td>
    <td><input class="tabbth_order" type="text" name="order" value="1" /></td>
</tr>
</script>
<script type="text/template" id="detail_tr_html">
<tr>
    <td><div class="settype_margin"><input type="checkbox" name="tabbth_check" /></div></td>
    <td><input class="fl" type="text" name="numer_name" value="" /><span class="fl">!</span></td>
    <td><input class="fl" type="text" name="text_name" value="" /><span class="fl">!</span></td>
    <td class="tabbth_minwth">
        <?php echo CHtml::dropDownList('item_type', '', MyConst::$formTypeDetail, array('class' => 'fl tabbth_mr6'));?>
        <div class="tabbth_box item tabbth_box_show clearfix"><!--单行文本框 开始-->
        	<label class="fl">类型</label>
            <?php echo CHtml::dropDownList('type_sub', '', MyConst::$formItem[1], array('class' => 'fl'));?>
<!--                                     <em class="fl">文本长度</em> -->
<!--                                     <input class="tabbth_order fl" type="text" name="length" value="" /> -->
<!--                                     <b class="fl">!</b> -->
        </div><!--单行文本框 结束-->
        <div class="tabbth_box item clearfix"><!--多行文本框 开始-->
        	<label class="fl">高度</label>
            <input class="tabbth_order fl" type="text" name="height" value="1" />
<!--                                     <em class="fl">Html编辑字段</em> -->
<!--                                     <input class="tabbth_redact" type="checkbox" name="redact_check" /> -->
        </div><!--多行文本框 结束-->
        <div class="tabbth_box item clearfix"><!--check 开始--></div><!--check 结束-->
        <div class="tabbth_box item clearfix"><!--选择框 开始-->
        	<div class="tabbth_choose"><a href="javascript:void(0)" name="add_choose">添加内容</a><a href="javascript:void(0)" name="del_choose">删除内容</a></div>
            <div class="tabbth_chact">
            	<div class="tabbth_chact_title"><span>选中</span>可选文字</div>
                <div class="tabbth_chact_input">
                	<input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
                    <input class="fl" type="text" name="chact_text" value="" />
                    <b>!</b>
                </div>
            </div>
        </div><!--选择框 结束-->
    </td>
    <td><input class="tabbth_order" type="text" name="order" value="1" /></td>
</tr>
</script>
<script type="text/template" id="detail_html">
<div style="margin-top:15px;" name="detail_div">
    <div class="tabbth_title tabbth_title_down">
        <div class="tabbth_btn"><a href="javascript:void(0)" name="add_detail_tr">添加</a><?php if (!$can_del) {?><a href="javascript:void(0)" name="del_tr">删除</a><?php }?></div>
    </div>
<table class="tabbth_table tabbth_table_down" name="detail_table" width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <th width="9"><div class="settype_margin"><p><input type="checkbox" name="tabbth_all" /></p></div></th>
        <th width="18%"><p>数据库字段名称</p></th>
        <th width="18%"><p>字段显示名</p></th>
        <th width="41%"><p>字段类型</p></th>
        <th width="14%"><p class="settype_p">顺序</p></th>
    </tr>
    <tr>
        <td><div class="settype_margin"><input type="checkbox" name="tabbth_check" /></div></td>
        <td><input class="fl" type="text" name="numer_name" value="" /><span class="fl">!</span></td>
        <td><input class="fl" type="text" name="text_name" value="" /><span class="fl">!</span></td>
        <td class="tabbth_minwth">
            <?php echo CHtml::dropDownList('item_type', '', MyConst::$formTypeDetail, array('class' => 'fl tabbth_mr6'));?>
            <div class="tabbth_box item tabbth_box_show clearfix"><!--单行文本框 开始-->
            	<label class="fl">类型</label>
                <?php echo CHtml::dropDownList('type_sub', '', MyConst::$formItem[1], array('class' => 'fl'));?>
<!--                                     <em class="fl">文本长度</em> -->
<!--                                     <input class="tabbth_order fl" type="text" name="length" value="" /> -->
<!--                                     <b class="fl">!</b> -->
            </div><!--单行文本框 结束-->
            <div class="tabbth_box item clearfix"><!--多行文本框 开始-->
            	<label class="fl">高度</label>
                <input class="tabbth_order fl" type="text" name="height" value="1" />
<!--                                     <em class="fl">Html编辑字段</em> -->
<!--                                     <input class="tabbth_redact" type="checkbox" name="redact_check" /> -->
            </div><!--多行文本框 结束-->
            <div class="tabbth_box item clearfix"><!--check 开始--></div><!--check 结束-->
            <div class="tabbth_box item clearfix"><!--选择框 开始-->
            	<div class="tabbth_choose"><a href="javascript:void(0)" name="add_choose">添加内容</a><a href="javascript:void(0)" name="del_choose">删除内容</a></div>
                <div class="tabbth_chact">
                	<div class="tabbth_chact_title"><span>选中</span>可选文字</div>
                    <div class="tabbth_chact_input">
                    	<input class="tabbth_chact_check" type="checkbox" name="tabbth_chact" />
                        <input class="fl" type="text" name="chact_text" value="" />
                        <b>!</b>
                    </div>
                </div>
            </div><!--选择框 结束-->
        </td>
        <td><input class="tabbth_order" type="text" name="order" value="1.00" /></td>
    </tr>
</table>
</div>
</script>
<script type="text/javascript">
//自适应高度
function heightChange(){
	var setHeight = document.getElementById("setheight");
	var bodyHeight = document.documentElement.clientHeight - 9 - 32 - 15;   //9代表的是上外边距，32是标题栏的高度，15是距离浏览器下部分的距离
	setHeight.style.minHeight = bodyHeight + "px";
}
window.onload = heightChange();
window.onresize = heightChange;
$(function(){
	// 字段类型选择
	$('[name=type_sub]').live('change', function(){
		var $this = $(this);
		$this.parent().parent().find('.sub_item').hide();
	    $this.parent().parent().find('.sub_item').eq($this.get(0).selectedIndex).show();
	});
	$('[name=item_type]').live('change', function(){
	    var $this = $(this);
	    $this.parent().find('.item').removeClass('tabbth_box_show');
	    $this.parent().find('.item').eq($this.get(0).selectedIndex).addClass('tabbth_box_show');
	    $('[name=type_sub]').change();
	});
	$('[name=item_type]').change();
	// 选择框 添加内容
	$('[name=add_choose]').live('click', function(){
	    var $this = $(this);
	    $this.parent().parent().find('.tabbth_chact_title:last').append($('#choose_html').html());
	    return false;
	});
	// 选择框 删除内容
	$('[name=del_choose]').live('click', function(){
	    var $this = $(this);
	    $this.parent().parent().find('input:checked').parent().remove();
	    return false;
	});
	// 添加多明细
	$('[name=add_detail]').click(function(){
	    $('.tabbth_btn_down').before($('#detail_html').html());
	    return false;
	});
	// 添加主字段
	$('[name=add_main_tr]').click(function(){
	    $('[name=main_table] tr:last').after($('#main_tr_html').html());
	    return false;
	});
	// 添加明细字段
	$('[name=add_detail_tr]').live('click', function(){
		$(this).parents('[name=detail_div]').find('[name=detail_table] tr:last').after($('#detail_tr_html').html());
		return false;
	});
	// 删除字段
	$('[name=del_tr_main]').click(function(){
		$('[name=main_table] input:checked').parents('tr').each(function(){
    	    if (!$(this).find('th').length) {
        	    if ($(this).find('[name=tr_id]').length) {
        	        $.post('<?php echo $this->createUrl('/ajax/workform/delete')?>', {id:$(this).find('[name=tr_id]').val()});
        	    }
    	        $(this).remove();
    	    }
    	});
		return false;
	});
	$('[name=del_tr]').live('click', function(){
	    $(this).parents('[name=detail_div]').find('[name=detail_table] input:checked').parents('tr').each(function(){
    	    if (!$(this).find('th').length) {
    	    	if ($(this).find('[name=tr_id]').length) {
        	        $.post('<?php echo $this->createUrl('/ajax/workform/delete')?>', {id:$(this).find('[name=tr_id]').val()});
        	    }
    	        $(this).remove();
    	    }
    	});
	    return false;
	});
	// 全选
	$('[name=tabbth_all]').live('click', function(){
		var $this = $(this);
		$this.parents('table').find('input:checkbox').attr('checked', $this.is(':checked'));
		return false;
	});
	// 获取tr内的数据
	var get_tr_data = function(obj){
		var $this = obj;
	    if ($this.find('th').length == 0) {
		    var field_attr = '';
		    var field_body = '';
	    	var db_field_name = $this.find('[name=numer_name]').val();
	    	var field_name = $this.find('[name=text_name]').val();
	    	var field_type = $this.find('[name=item_type]').val();
	    	if (field_type == 1) {
	    		field_attr = $this.find('.item').eq($this.find('[name=item_type]').get(0).selectedIndex).find('[name=type_sub]').val();
	    	} else if (field_type == 2) {
	    	    field_attr = $this.find('[name=height]').val();
	    	} else if (field_type == 3) {
	    		field_attr = '';
	    	} else if (field_type == 4) {
	    		$this.find('[name=chact_text]').each(function(){
		    		if ($(this).val() != '') {
		    		    field_body += $(this).val() + '&';
		    		}
	    		});
	    	} else if (field_type == 5) {
	    		field_attr = $this.find('.item').eq($this.find('[name=item_type]').get(0).selectedIndex).find('[name=type_sub]').val();
	    		if (field_attr == 2) {
	    			field_body = $this.find('[name=length]').val();
	    		}
	    	} else if (field_type == 6) {
	    		field_attr = $this.find('.item').eq($this.find('[name=item_type]').get(0).selectedIndex).find('[name=type_sub]').val();
	    		if (field_attr == 1) {
	    			field_body = $this.find('[name=show_name]').val() + '&' + $this.find('[name=show_url]').val();
	    		} else {
	    			field_body = $this.find('[name=describe_text]').val();
	    		}
	    	}
	    	var type = $this.parents('[name=main_table]').length == 1 ? '0' : '';
	    	var dsporder = $this.find('[name=order]').val();
	    	var _id = $this.find('[name=tr_id]').val();
	    	if (!_id) {
	    	    _id = '';
	    	}
	    	return [db_field_name, field_name, field_type, field_attr, dsporder, field_body, type, _id];
	    }
	}
	// 保存
	$('[name=submit_form]').click(function(){
		var main_table_datas = new Array();
		var detail_tables_datas = new Array();
		$('[name=main_table] tr').each(function(){
			var data = get_tr_data($(this));
			if (typeof data == 'object') {
				main_table_datas.push(data);
			}
		});
		$('[name=detail_table]').each(function(){
			var single_table_datas = new Array();
		    $(this).find('tr').each(function(){
		    	var data = get_tr_data($(this));
				if (typeof data == 'object') {
					single_table_datas.push(data);
				}
		    });
		    detail_tables_datas.push(single_table_datas);
		});
		$.post('<?php echo $this->createUrl('/ajax/workform/edititem')?>', {datas:main_table_datas, detail_datas:detail_tables_datas, id:<?php echo $form->id;?>}, function(res){
		    if (res.code == 0) {
		        location.href = '<?php echo $this->createUrl('/settings/workform/editform/' . $form->id);?>';
		    } else {
		        alert(res.msg);
		    }
		}, 'json');
	    return false;
	});
});
</script>