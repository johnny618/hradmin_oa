<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>head</title>
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>css/home.css">
</head>
<body>
	<div class="right">
		<div class="head">
			<div class="head_left">
				<a class="fl" href="#"><img src="<?php echo Yii::app()->baseUrl . '/protected/assets/'?>images/head_logo.png"></a>
				<h3>OA管理平台</h3>
			</div>
			<div class="head_right">
                            <p><span><?php echo Yii::app()->user->name;?></span><span>|</span>
                <span><?php echo Yii::app()->user->dept_cn;?></span>
                <a class="head_a2" href="<?php echo $this->createUrl('/login/out');?>"></a>
                
            </p>

                        </div>
		</div>
		<div class="new"></div>
	</div>
</body>
</html>