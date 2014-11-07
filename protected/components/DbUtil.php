<?php
/**
 * 配置数据库连接的工具类
 */
class DbUtil{    
    public static function getActivityConnection(){
        $connection = Yii::app()->db;
        return $connection;
    }
}
?>
