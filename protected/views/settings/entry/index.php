<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">新员工录入</h3>
	<div class="pro-content">
            <form method="post" id="frm_submit" action="entry">	   
		<table class="renli">                    
			<tbody>
			<tr>
				<th width="15%">员工号</th>
                                <td><input type="text" name="uid" id="uid" onblur="javascript:check_uid()">
                                <span style="color:red" id="t_uid"></span></td>
			</tr>
                        <tr>
				<th>拼音姓</th>
                                <td><input type="text" name="sur" id="sur">
                                    <span style="color:red" id="t_sur"></span>
                                </td>
			</tr>
                        <tr>
				<th>拼音名</th>
                                <td><input type="text" name="give" id="give">
                                <span style="color:red" id="t_give"></span></td>
			</tr>
                        <tr>
				<th>拼音全称</th>
                                <td><input type="text" name="name" id="name">
                                    <span style="color:red" id="t_name"></span></td>
			</tr>
                        <tr>
				<th>中文名</th>
                                <td><input type="text" name="name_cn" id="name_cn">
                                <span style="color:red" id="t_name_cn"></span></td>
			</tr>
			<tr>
				<th>邮箱</th>
                                <td><input type="text" name="email" id="email" onblur="javascript:check_mail();">
                                    <span style="color:red" id="t_email"></span></td>
			</tr>
                        <tr>
				<th>座机</th>
                                <td><input type="text" name="phone" id="phone">
                                <span style="color:red" id="t_phone"></span></td>
			</tr>
                        <tr>
				<th>部门</th>
                                <td><a href="javascript:;" onclick="javascript:showDept();" class="fl"><label for="" style="cursor:pointer" class="lbl-type"></label></a>
                                    <input type="text" readonly="readonly"  id="dept"  name="dept" value="" />
                                <span style="color:red" id="t_dept"></span>
                                <input type="hidden" id="deptid"  name="deptid" value="" /></td>
			</tr>
                        <tr>
				<th>职位</th>
                                <td><input type="text" name="title" id="title">
                                <span style="color:red" id="t_title"></span></td>
			</tr>
                        <tr>
				<th>小部门 (可不填)</th>
                                <td><input type="text" name="division" id="division">
                                <span style="color:red" id="t_division"></span>
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
        perg_number('uid');
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
        if ('' == $.trim($('#name').val())){
            $('#t_name').html('拼音全称不能为空');
            b = false;
        }else{
            $('#t_name').html('');
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
        check_uid();
        if (b && ch_mail && ch_uid){            
            $('#frm_submit').submit();
        }
    });
    
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
            data:{type:"check_Email",email:$('#email').val()},
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
    
    var ch_uid = false;
    function check_uid(){
        if ($('#uid').val().length < 4 || $('#uid').val().length > 15){
            $('#t_uid').html('请填写正确员工工号');
            ch_uid = false;
        }else{
            $('#t_uid').html('');
        }
        
        $.ajax({
            type:"post",
            url:ajaxurl,
            data:{type:"check_uid",uid:$('#uid').val()},
            dataType:"json",
            async:false,
            success:function(data){                
                if (data.code == "success"){
                    ch_uid = true;
                }else{
                    $('#t_uid').html('员工工号已存在');
                    ch_uid = false;
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