<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>易班OA-登录</title>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/base.css');
$cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/home.css');
$cs->registerCoreScript('jquery');
?>
<style>
body{ background:#4771a1;
	background:-webkit-linear-gradient(left,#4771a1 0%,#93b8e2 50%,#4771a1 100%);
	background:-moz-linear-gradient(left,#4771a1 0%,#93b8e2 50%,#4771a1 100%);
	background:-ms-linear-gradient(left,#4771a1 0%,#93b8e2 50%,#4771a1 100%);
	background:-o-linear-gradient(left,#4771a1 0%,#93b8e2 50%,#4771a1 100%);
}
.textBox .getMobileYZM{
text-indent: 0;
background: url(<?php echo Yii::app()->baseUrl?>/protected/assets/images/sprite-icon.png) -27px -3px;
width: 120px;
color:#fff;
font-size:14px;
}
.textBox .getMobileYZM-Wait{
text-indent: 0;
background: url(<?php echo Yii::app()->baseUrl?>/protected/assets/images/sprite-icon.png) -27px -38px;
width: 120px;
color:#fff;
font-size:14px;
}
</style>
</head>
<body>
	<div class="loginBox" id="loginBox">
		<div class="logo"></div>
		<div class="textBox">
			<?php $form = $this->beginWidget('CActiveForm');?>			    
			    <?php echo $form->textField($model,'password', array('class' => 'text', 'placeholder' => '验证码')) ?>
			    <?php echo CHtml::submitButton('登录', array('class' => 'subBtn')); ?>
                            <input class="subBtn getMobileYZM" id="btn_ag_msg" type="button" value="" />
			<?php $this->endWidget();?>
		</div>
		<?php echo $form->errorSummary($model);?>
		<div class="boxbg"></div>
	</div>
<script type="text/javascript">
    var ajaxurl =  '<?php echo $this->createUrl('/login/ajax/');?>';

    $(document).ready(function(){
        regetvcode($("#btn_ag_msg"));
    });


window.onresize = setPos;
setPos();
function setPos(){
	var oBox = document.getElementById('loginBox');
	var iClientHeight = document.documentElement.clientHeight;
	oBox.style.marginTop = parseInt((iClientHeight - oBox.offsetHeight)/2)+'px';

}
var GLOBAL_EDIT_URL = "<?php echo Yii::app()->baseUrl;?>";

function regetvcode ($obj) {
		var total = 30;
		$obj.attr("value",total+"秒重新获取").attr("disabled","disabled");
        $obj.addClass('getMobileYZM-Wait');
		var interId = setInterval(function () {
			total--;
			$obj.attr("value",total + "秒重新获取");

			if (total <= 0) {
				clearInterval(interId);
				$obj.attr("value","获取短信验证码").removeAttr("disabled");
                $obj.removeClass('getMobileYZM-Wait');
			};
		} , 1000);
	}
        
        
(function(t,o,f){
    o=t[0];
    o.z=o.value='获取短信验证码';
    f=function(){
            o.value=o.w?(o.w--)+'秒重新获取':o.z;
            if(o.z===o.value)t.removeClass('getMobileYZM-Wait');
    };
    clear = function(){
        
    }
    t.click(function(){
        if(o.w)return;
        //ajax开始
        $.ajax({
            type:'post',
            url:ajaxurl,
            data:{type:"ag_msg"},
            dataType:"json",
            async:false,
            success:function(data){
                if (data.code == 'error'){
                    alert(data.info);                    
                }else{
                    o.w=60;f();
                    t.addClass('getMobileYZM-Wait');
                    o.p=o.p||setInterval(f,1e3);
                }
            }
        });
        
        
    });
})($('.getMobileYZM'));        
</script>
</body>
</html>