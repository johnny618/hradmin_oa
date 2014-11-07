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
</style>
</head>
<body>
	<div class="loginBox" id="loginBox">
		<div class="logo"></div>
		<div class="textBox">
			<?php $form = $this->beginWidget('CActiveForm');?>
			    <?php echo $form->textField($model,'username', array('class' => 'text', 'placeholder' => '用户名','value'=>isset($_COOKIE['loginuid']) ? $_COOKIE['loginuid'] :'' )) ?>
			    <?php echo $form->passwordField($model,'password', array('class' => 'text', 'placeholder' => '密码')) ?>
			    <?php echo CHtml::submitButton('登录', array('class' => 'subBtn')); ?>
<!-- 				<input type="text" name="username" class="text" placeholder="用户名"/> -->
<!-- 				<input type="password" class="text" name="pass" placeholder="密码"/> -->
<!-- 				<input type="submit" value="登录" class="subBtn"> -->
<!-- 				<a href="">找回密码</a> -->
			<?php $this->endWidget();?>
		</div>
		<?php echo $form->errorSummary($model);?>
		<div class="boxbg"></div>
	</div>
<script>
window.onresize = setPos;
setPos();
function setPos(){
	var oBox = document.getElementById('loginBox');
	var iClientHeight = document.documentElement.clientHeight;
	oBox.style.marginTop = parseInt((iClientHeight - oBox.offsetHeight)/2)+'px';

}
var GLOBAL_EDIT_URL = "<?php echo Yii::app()->baseUrl;?>";
</script>
</body>
</html>