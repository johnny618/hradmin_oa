<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>设置-流程类型</title>
<?php
$cs = Yii::app()->clientScript;
$cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/home.css');
$cs->registerCssFile(Yii::app()->baseUrl . '/protected/assets/css/base.css');
$cs->registerCoreScript('jquery');
?>
</head>
<body>
<script>
var GLOBAL_EDIT_URL = "<?php echo Yii::app()->baseUrl;?>";
</script>
<?php echo $content;?>
</body>
</html>