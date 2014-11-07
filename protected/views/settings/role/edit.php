<style>
	body{ background-color: #fff;}
        .role-set-edit a.fl{width: 21px; float:none;  height: 20px; position:relative; top:3px; background: url(<?php echo Yii::app()->baseUrl . '/protected/assets/'?>images/set_ico7.png) no-repeat 0 0; display: inline-block; margin: 7px 10px 0 7px; cursor:pointer;}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'htmlOptions' => array(
        'class' => 'bs-example'
    )
));
?>
<div class="process">
<?php echo $form->errorSummary($role); ?>
	<!-- 角色设置编辑start -->
	<h3 class="title">编辑：角色设置</h3>
	<div class="pro-content">
		<table class="role-set-edit">
			<caption><strong>角色设置</strong></caption>
			<tbody>
				<tr>
					<th width="10%">角色名称</th>
                    <td><?php echo $form->textField($role, 'name', array('style' => 'width:400px;', 'id' => 'rolename'));?><span id="ch_title"/></td>
				</tr>
                <tr>
					<th>角色成员 <a href="javascript:showPersonDiv();" class="fl"/></th>
					<td><span id="deptinfostr"></span></td>
				</tr>
			</tbody>
		</table>
		<input name="role_ids" type="hidden"/>
		<div class="subBox">
			<a href="javascript:;" id="fsave" class="oa-btn">保存</a>
			<a href="<?php echo $this->createUrl('/settings/role/index')?>" class="oa-btn">返回</a>
		</div>
	</div>
	<!-- 角色设置编辑end -->
</div>
<?php $this->endWidget();?>
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

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
var ajaxurl = '<?php echo $this->createUrl('/settings/formnode/ajax/');?>';
var ajaxRoleUrl = '<?php echo $this->createUrl('/settings/role/ajax/');?>';


function showPersonDiv(){
    $(".aut_adddiv").animate({top:350},"slow");
    $(".aut_adddiv").show();
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
       deptinfostr += '<span id="'+$(this).find('span').data('id')+'">'+ $(this).text() + '</span>&nbsp;&nbsp;&nbsp;';
   });
   $('#deptinfostr').html(deptinfostr);
   close_aut_div();
});

<?php if ($role_infos) {?>
$(function(){
    var _html = _li = '';
    <?php foreach ($role_infos as $info) {?>
    _html += '<span id="<?php echo $info->userid;?>"><?php echo $info->User ? $info->User->uname : $info->userid;?></span>&nbsp;&nbsp;&nbsp;';
    _li += '<li ondblclick="removeemployee(this)"><span style="cursor:pointer" id="e_<?php echo $info->userid?>" class="fl" ondblclick="javascript:addemployee(this)" data-id="<?php echo $info->userid?>"><?php echo $info->User ? $info->User->uname : $info->userid;?></span></li>';
    <?php }?>
    $('#deptinfostr').html(_html);
    $('#ul_add_deptinfo').append(_li);
});
<?php }?>

//清除
$('#deptinfo_cls').click(function(){
    $('#choose_number').text(0);
    $('#ul_add_deptinfo').html('');
});

//页面弹层关闭方法
function close_aut_div(){
    $(".aut_adddiv").css('top','50%');
    $(".aut_adddiv").hide();
    //$(".aut_div").hide();
}

$('#fsave').click(function(){
    var roleids = new Array();
    $('#deptinfostr span').each(function(){
        roleids.push($(this).attr('id'));
    });
    $('[name=role_ids]').val(roleids.join(','));
    $('form').submit();
    return false;
});



function checkTitle() {   //检查角色名称
    var rolename = $.trim($("#rolename").val());
    var intMaxLength = 20;
    var intMinLength = 2;

    if(rolename.length <= intMaxLength){
        if( '' != rolename ) {
            if(rolename.length<intMinLength){
                $("#ch_title").html('×角色名称至少2个字');
                return false;
            }
        }else{
            if(0 == rolename.length){
                $("#ch_title").html('×请填写角色名称');
                return false;
            }
        }
        $("#ch_title").html('');
        return true;
    }else{
        $("#ch_title").html('×角色名称不能超过20个字');
        return false;
    }
}

$("#rolename").keyup(function(){
    checkTitle();
});

$("#rolename").blur(function(){
    checkTitle();
});
</script>
