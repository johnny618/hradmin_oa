<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">员工信息修改</h3>
	<div class="pro-content">
            <form method="post" id="frm_submit" action="<?php echo Yii::app()->createUrl('/settings/entry/modify')?>">	   
		<table class="renli">                    
			<tbody>
			<tr>
				<th width="15%">员工号</th>
                                <td><label type="text"><?php echo $user['id']?></label>                                
                                <input type="hidden" id="uid" name="uid" value="<?php echo $user['id']?>" /></td>
			</tr>
                        <tr>
				<th>拼音姓</th>
                                <td><input type="text" name="sur" id="sur" value="<?php echo $user['surName']?>">
                                    <span style="color:red" id="t_sur"></span>
                                </td>
			</tr>
                        <tr>
				<th>拼音名</th>
                                <td><input type="text" name="give" id="give" value="<?php echo $user['givenName']?>">
                                <span style="color:red" id="t_give"></span></td>
			</tr>                        
                        <tr>
				<th>中文名</th>
                                <td><input type="text" name="name_cn" id="name_cn" value="<?php echo $user['displayName']?>">
                                <span style="color:red" id="t_name_cn"></span></td>
			</tr>
			<tr>
				<th>邮箱</th>
                                <td><input type="text" name="email" id="email" onblur="javascript:check_mail();" value="<?php echo $user['email']?>">
                                    <span style="color:red" id="t_email"></span></td>
			</tr>
                        <tr>
				<th>座机</th>
                                <td><input type="text" name="phone" id="phone" value="<?php echo $user['officePhone']?>">
                                <span style="color:red" id="t_phone"></span></td>
			</tr>
                        <tr>
				<th>部门</th>
                                <td><a href="javascript:;" onclick="javascript:showDept();" class="fl"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                    <input type="text" readonly="readonly"  id="dept"  name="dept" value="<?php echo $user['department_cn']?>" />
                                <span style="color:red" id="t_dept"></span>
                                <input type="hidden" id="deptid"  name="deptid" value="<?php echo $user['department']?>" /></td>
			</tr>
                        <tr>
				<th>职位</th>
                                <td><input type="text" name="title" id="title" value="<?php echo $user['title']?>">
                                <span style="color:red" id="t_title"></span></td>
			</tr>
                        <tr>
				<th>小部门 (可不填)</th>
                                <td><input type="text" name="division" id="division" value="<?php echo $user['division']?>">
                                <span style="color:red" id="t_division"></span>
                                </td>
			</tr>
                        <tr>
				<th>手机号</th>
                                <td><input type="text" name="mobile" id="mobile" value="<?php echo $userother['mobile']?>">
                                <span style="color:red" id="t_mobile"></span>
                                </td>
			</tr>
                        <tr>
				<th>是否开启手机验证</th>
                                <td>
                                    <select name="c_mobile">
                                        <?php foreach ($is_mobile as $is_mobile_key => $is_mobile_val): ?>
                                            <?php if ($is_mobile_key == $userother['c_mobile']):?>
                                            <option selected="selected" value="<?php echo $is_mobile_key?>"><?php echo $is_mobile_val?></option>
                                            <?php else:?>
                                            <option  value="<?php echo $is_mobile_key?>"><?php echo $is_mobile_val?></option>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </select>                                
                                </td>
			</tr>
                        <tfoot>
				<tr>
                                    <td colspan="2" align="center">                        
                                        <a href="javascript:;" class="oa-btn" id="fsave">保存</a>
                                        <a href="<?php echo $this->createUrl('/workreport/mywork/list/');?>" class="oa-btn">返回</a>
                                    </td>
				</tr>
			</tfoot>
		</table>
	</form>
	</div>
	
</div>

<div class="aut_adddiv" id="dept_div"><!--类型弹出层 开始-->
    <div class="div_note_tab" name="opensub">
            <h4>易班</h4>
            <ul class="set_tree">
                    <?php foreach($deptArr as $deptArrKey => $deptArrVal){?>
                        <li>
                            <span id="<?php echo $deptArrKey?>" ondblclick="javascript:adddept(this)" style="cursor:pointer"><?php echo $deptArrVal?></span>
                        </li>
                    <?php }?>
            </ul>
    </div>
    <div class="aut_add_btn"><a class="aut_close">取消</a></div>
</div><!--类型弹出层 结束 -->
<script>
$("[name=opensub] h4").each(function(index){
    $(this).toggle(function () {
        $(this).addClass("active");
        $(this).siblings(".set_tree").eq(index).show();
      },
      function () {
        $(this).removeClass("active");
        $(this).siblings(".set_tree").eq(index).hide();
      });
});
</script>

<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/keypreg.js"></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo Yii::app()->createUrl('/ajax/apiajax/ajax')?>';

    $(document).ready(function(){
        perg_str('sur');
        perg_str('give');
        perg_str('name');
        perg_number('phone');        
    });
    
    $('#fsave').click(function(){
        var b = true;
        
        if ('' == $.trim($('#sur').val())){
            $('#t_sur').html('拼音姓不能为空');
            b = false;
        }else{
            $('#t_sur').html('');
        }
        if ('' == $.trim($('#give').val())){
            $('#t_give').html('拼音名不能为空');
            b = false;
        }else{
            $('#t_give').html('');
        }
        if ('' == $.trim($('#name_cn').val())){
            $('#t_name_cn').html('中文名不能为空');
            b = false;
        }else{
            $('#t_name_cn').html('');
        }
        
        if ('' == $.trim($('#phone').val())){
            $('#t_phone').html('座机不能为空');
            b = false;
        }else{
            $('#t_phone').html('');
        }
        if ('' == $.trim($('#deptid').val())){
            $('#t_dept').html('部门不能为空');
            b = false;
        }else{
            $('#t_dept').html('');
        }
        if ('' == $.trim($('#title').val())){
            $('#t_title').html('职位不能为空');
            b = false;
        }else{
            $('#t_title').html('');
        }
        check_mail();         
        if (b && ch_mail && check_mobile()){
            $('#frm_submit').submit();
        }
    });
    
    function check_mobile(){
        if (0 == $.trim($('#mobile').val())){
            return true;
        }
        
        if ('' == $.trim($('#mobile').val())){
            $('#t_mobile').html('手机号不能为空');
            return false;
        }else{
            $('#t_mobile').html('');
        }
        var mobile_reg = /^[1][358]\d{9}$/;
        if (!mobile_reg.test($('#mobile').val())){   
            $('#t_mobile').html('手机号不合法');                    
            return false;
        }else{
            $('#t_mobile').html('');
        }  
        return true
    }
    
    var ch_mail = false;
    function check_mail(){    
        if ('' == $.trim($('#email').val())){
            $('#t_email').html('邮箱不能为空');
            ch_mail = false;
            return false;
        }else{
            $('#t_email').html('');
        }
    
        var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test($('#email').val())){   
            $('#t_email').html('邮箱不合法');
            ch_mail = false;            
            return false;
        }else{
            $('#t_email').html('');
        }       
        $.ajax({
            type:"post",
            url:ajaxurl,
            data:{type:"checkEamil",uid:$('#uid').val(),email:$('#email').val()},
            dataType:"json",
            async:false,
            success:function(data){
                if (data.code == "success"){
                    ch_mail = true;
                }else{
                    $('#t_email').html('邮箱已占用');
                    ch_mail = false;
                }
            }
        });        
    }

    function showDept(){    
        $("#dept_div").show();
        $("#dept_div").css({
                left:($(window).width() - $("#dept_div").width())/2,
                top:100+"px"
          });
    }
    
    function adddept(obj){
        $('#dept').val($(obj).html());
        $('#deptid').val($(obj).attr('id'));
        close_aut_div();
    }
    
    //页面弹层关闭方法
    function close_aut_div(){
        $(".aut_adddiv").css('top','50%');
        $(".aut_adddiv").hide();
        //$(".aut_div").hide();
    }

</script>