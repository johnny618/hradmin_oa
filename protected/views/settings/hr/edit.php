<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">搜索：人力资源</h3>
	<div class="pro-content">
	<form method="post">
	    <input type="hidden" name="leader_id" id="leader_id_input" />
		<table class="renli">
			<tbody>
			<tr>
				<th width="15%">编号</th>
				<td><?php echo $user->uid;?></td>
			</tr>
			<tr>
				<th>姓名</th>
				<td><?php echo $user->uname;?></td>
			</tr>
			<tr>
				<th>部门</th>
				<td><?php echo $user->dept_cn;?></td>
			</tr>
			<tr>
				<th>上级选择框</th>
				<td id="leader_td"><label for="" class="lbl-type" onclick="showPersonDiv();"></label><?php if ($user->leader) {?><span style="margin-right:5px;" id="<?php echo $user->leader->uid;?>"><?php echo $user->leader->uname;?></span><?php }?></td>
			</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" align="center">
                        <input type="hidden" name="reffer" value="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->createUrl('/settings/hr/search');?>" />
					    <a href="javascript:;" class="oa-btn" id="form_sbtn">保存</a>
                        <a href="<?php echo isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : $this->createUrl('/settings/hr/search');?>" class="oa-btn">返回</a>
			        </td>
				</tr>
			</tfoot>
		</table>
	</form>
	</div>
	<div class="aut_adddiv"><!--人力资源 开始-->
    <div class="aut_ddiv_nav aut_people"><!--人力资源上部分 开始-->
        <h4>易班</h4>
        <ul class="set_tree">
             <?php foreach($deptArr as $deptArrKey =>$deptArrVal):?>
                        <li><span onclick="javascript:get_dept_info('<?php echo $deptArrKey;?>')"><?php echo $deptArrVal?></span></li>
             <?php endforeach;?>
        </ul>

    </div><!--人力资源上部分 结束-->
    <div class="atu_pbox">
        <div class="atu_pboxtit">已选择 <span id="choose_number">0</span> 人</div>
        <div class="atu_pbbox">
                <div class="atu_pbbox_box fl"><!--左边选择框 开始-->
                <ul class="clearfix" id="ul_deptinfo">

                </ul>
            </div><!--左边选择框 结束-->
            <div class="atu_pbbox_box fr"><!--右边选择框 结束-->
                <ul id="ul_add_deptinfo">

                </ul>
            </div><!--右边选择框 结束-->
        </div>
    </div>
    <div class="aut_add_btn"><a id="btn_deptinfo">确定</a><a id="deptinfo_cls">清除</a><a class="aut_close">取消</a></div>
</div><!--人力资源 结束-->
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
$('#form_sbtn').click(function(){
	$('#leader_id_input').val($('#leader_td span').eq(0).attr('id'));
	$('form').submit();;
});
var ajaxurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';

function showPersonDiv(){
    $(".aut_adddiv").show();
    $(".aut_adddiv").css({
            left:($(window).width() - $(".aut_adddiv").width())/2,
            top:100+"px"
      });
}

//人力资源弹出层JS START
function get_dept_info(deptid){
    $.ajax({
        type:'post',
        url:ajaxurl,
        data:{type:"getdeptinfo",deptid:deptid},
        dataType:"json",
        async:false,
        success:function(data){
            $('#ul_deptinfo').html(data['info']);
        }
    });
}
//人力资源弹出层JS END

//eid员工ID
function addemployee(obj){
	if ($('#ul_add_deptinfo li').length > 0) {
	    return false;
	}
    if ($('#ul_add_deptinfo #' + $(obj).attr('id')).length > 0) {
        return false;
    }
    var html = $(obj).parent().clone();
    $(html).attr('ondblclick', 'removeemployee(this)');
    $('#choose_number').text(parseInt($('#choose_number').text())+1);
    $('#ul_add_deptinfo').append(html);
}

function removeemployee(obj){
    $(obj).remove();
    if (parseInt($('#choose_number').text()) > 0){
        $('#choose_number').text(parseInt($('#choose_number').text())-1);
    }
}
//确认人员
$('#btn_deptinfo').click(function(){
    var deptinfostr = '';
   $("#ul_add_deptinfo li").each(function(){
       deptinfostr += '<span style="margin-right:5px;" id="'+$(this).find('span').data('id')+'">'+ $(this).text() + '</span>';
   });
   $('#leader_td span').remove()
   $('#leader_td').append(deptinfostr);
   close_aut_div();
});

//清除
$('#deptinfo_cls').click(function(){
    $('#ul_add_deptinfo').html('');
});

//页面弹层关闭方法
function close_aut_div(){
    $(".aut_adddiv").css('top','50%');
    $(".aut_adddiv").hide();
}
</script>