<!DOCTYPE html>
<html>
  <head>
    <title><?php echo Yii::app()->name;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>


<!--  <frameset>
       <frame name="Top" rows="80,*" scrolling="No" noresize="noresize" id="Top" title="topFrame" src="<?php echo $this->createUrl('/Menu/top')?>" />
       <frameset cols="142,*">
        <frame name="Left" noresize="noresize" id="Left" title="leftFrame" target="Main" src="<?php echo $this->createUrl('/Menu')?>" />
    <frameset rows="48,*">
      <frame name="Main" id="Main" title="mainFrame" src="<?php echo $this->createUrl('/settings/workformitem')?>" />
    </frameset>
       </frameset>
  </frameset>    -->
<frameset rows="47,*" border="0">
    <frame name="Top" scrolling="No" noresize="noresize" id="Top" title="topFrame" src="<?php echo $this->createUrl('/Menu/top')?>" />
    <frameset cols="142,*" framespacing="0" frameborder="no" border="0">
      <frame name="Left" noresize="noresize" id="Left" title="leftFrame" target="Main" src="<?php echo $this->createUrl('/Menu')?>" />
      <frameset>
        <frame name="Main" id="Main" title="mainFrame" src="<?php echo $this->createUrl('/index/show')?>" />
      </frameset>
    </frameset>
</frameset>
</html>
