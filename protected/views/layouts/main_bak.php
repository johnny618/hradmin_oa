<!DOCTYPE html>
<html ng-app >
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Grant's blog">
    <title><?php echo Yii::app()->name;?></title>
    <link rel="stylesheet" href="http://cdn.staticfile.org/twitter-bootstrap/3.0.2/css/bootstrap.min.css" />
    <script src="http://cdn.staticfile.org/jquery/2.0.3/jquery.min.js"></script>
    <script src="http://cdn.staticfile.org/twitter-bootstrap/3.0.2/js/bootstrap.min.js"></script>
    <link rel="shortcut icon" href="/favicon.ico">
</head>
<body>
<style>
.main-container {padding: 60px 15px;}
</style>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo $this->createUrl('/')?>"><?php echo Yii::app()->name;?></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li>首页</a></li>
            <?php if (Yii::app()->user->id) {?>
            <li><a href="<?php echo $this->createUrl('/login/out');?>">退出</a></li>
            <?php }?>
          </ul>
        </div>
      </div>
    </div>
    <div class="container main-container">
      <?php echo $content; ?>
    </div>
</body>
</html>