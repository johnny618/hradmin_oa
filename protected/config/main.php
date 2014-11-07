<?php
//db_localhost
//$db_config = array(
//    'connectionString' => 'mysql:host=221.130.201.102;dbname=oa',
//    'emulatePrepare' => true,
//    'username' => 'oa_dev',
//    'password' => '123456',
//    'charset' => 'utf8'
//);

//db_test
$db_config = array(
    'connectionString' => 'mysql:host=10.21.168.170;dbname=oa',
    'emulatePrepare' => true,
    'username' => 'clent',
    'password' => 'clent_test123',
    'charset' => 'utf8'
);

if ($_SERVER['SERVER_ADDR'] == '10.21.168.170') {
    $db_config = array(
        'connectionString' => 'mysql:host=localhost;dbname=oa',
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => 'dba@168.168',
        'charset' => 'utf8'
    );
}

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '易班OA',
    'timeZone' => 'Asia/Shanghai',  //设置时区为上海
    'language' => 'zh_cn',
    'layout' => 'right',

    'defaultController' => 'index',
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.widgets.*',
        'application.components.YYiiRedis.*',             
        'application.datainterface.*'
    ),
    'components' => array(
        'db' => $db_config,
        'user' => array(
            'loginUrl' => array(
                '/login'
            )
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                'settings/<controller:\w+>/<action:\w+>/<id:\d+>' => 'settings/<controller>/<action>',
                '<controller:\w+>/<id:\d+>' => '<controller>/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>'
            )
        ),
        "redis" => array(
            "class" => "application.components.YYiiRedis.ARedisConnection",
            "hostname" => "localhost",
            "port" => 6379,
            "database" => 1,
            "prefix" => "Yii.redis."
        ),
    )
);
