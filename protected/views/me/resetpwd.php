<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/set/set.css">
<style>
	body{ background-color: #fff;}
	.aut_adddiv{top:0px;}
</style>
<div class="process">
	<h3 class="title">修改密码</h3>
	<div class="pro-content">
	<form method="post">	   
		<table class="renli">
			<tbody>
			<tr>
				<th width="15%">姓名</th>
                                <td><?php echo Yii::app()->user->name;?></td>
			</tr>
                        <tr>
				<th>PIN密码 【4-8位，仅限英文、数字】</th>
                                <td><input type="password" name="pin" id="pin">
                                    <span style="color:red" id="t_pin"></span>
                                </td>
			</tr>
                        <tr>
				<th>确认PIN密码</th>
                                <td><input type="password" name="c_pin" id="c_pin"></td>
			</tr>
                        <tr>
				<th>附加码</th>
                                <td><input type="password" name="addpw" id="addpw"><span style="color:red" id="t_addpw"></span></td>
			</tr>
                        <tr>
				<th>确认附加码</th>
                                <td><input type="password" name="c_addpw" id="c_addpw"></td>
			</tr>
			<tr>
				<th>RSA动态密码</th>
                                <td><input type="password" name="rsa" id="rsa"></td>
			</tr>
                        
                        <tfoot>
				<tr>
					<td colspan="2" align="center">                        
					    <a href="javascript:;" class="oa-btn" id="fsave">保存</a>
                                            <a href="<?php echo $this->createUrl('/index/show');?>" class="oa-btn">返回</a>
                                    </td>
				</tr>
                                <tr><td colspan="2">
                                        注：<br>
                                        1.PIN密码为动态密码前的固定密码；<br>
                                        2.附加码为备用密码，用于RSA故障时的系统登录；<br>
                                        3.详细请咨询运维部。
                                    <td>
                                </tr>
			</tfoot>
		</table>
	</form>
	</div>
	
</div>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>js/set/set.js"></script>
<script type="text/javascript">
    var ajaxurl = '<?php echo Yii::app()->createUrl('/ajax/apiajax/ajax')?>';
    var reg = /[^a-zA-Z0-9]/g ;
    $('#fsave').click(function(){
        var b = true;
        if ($('#pin').val().length > 8 || $('#pin').val().length < 4){
            $('#t_pin').html('请输入4-8位密码');
            b = false;
        }

        if (reg.test($('#pin').val())){
            $('#t_pin').html('请输入数字或英文');
            b = false;
        }

        if ($.trim($('#pin').val()) != $.trim($('#c_pin').val())){
            $('#t_pin').html('密码与确认密码须一致');
            b = false;
        }
        
        if ($('#addpw').val().length > 20 || $('#pin').val().length < 4){
            $('#t_addpw').html('请输入4-20位密码');
            b = false;
        }
        
        if ($.trim($('#addpw').val()) != $.trim($('#c_addpw').val())){
            $('#t_addpw').html('密码与确认密码须一致');
            b = false;
        }
        
        if (b){
            $.ajax({
                type:"post",
                url:ajaxurl,
                data:{type:"resetPassword",pin:$('#pin').val(),addpw:$('#addpw').val(),rsa:$('#rsa').val()},
                dataType:"json",
                async:false,
                success:function(data){
                    if (data.code == "success"){
                        location.href = '<?php echo Yii::app()->createUrl('/login/out')?>';
                    }else{
                        alert(data.mes);
                    }
                }
            });
        }
    });
</script>