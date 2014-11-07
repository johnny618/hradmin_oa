<?php
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii/framework/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

//测试变量 TRUE为开启测试
const JOHNNYTEST = true;

require_once($yii);
Yii::createWebApplication($config)->run();
