<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'My Console Application',
    'timeZone' => 'Asia/Shanghai',

    // preloading 'log' component
    'preload' => array(
        'log'
    ),

    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.YYiiRedis.*'
    ),

    // application components
    'components' => array(
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=10.21.168.170;dbname=oa',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'dba@168.168',
            'charset' => 'utf8'
        ),
        'urlManager'=>array(
            'class'=>'CUrlManager',
        ),
        "redis" => array(
            "class" => "application.components.YYiiRedis.ARedisConnection",
            "hostname" => "localhost",
            "port" => 6379,
            "database" => 1,
            "prefix" => "Yii.redis."
        )
    )
);