<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicRoleInfo extends DAO_Base{

    private static $tableName = 'role_info';
    private static $_fields = array('id','roleid','userid');

    public static function check_user_is_exite($roleid){
        if (empty($roleid)){
            return array();
        }
        $sql = "select count(1) from ".self::$tableName.' where roleid=:roleid and userid=:userid';
        $params = array('roleid'=>$roleid,'userid'=>  Yii::app()->user->id);
        return self::querySql($sql,$params,'count');
    }   

    public static function get_uids_by_roleids($roleids){
        if (empty($roleids)){
            return array();
        }
        if (is_array($roleids)){
            $ids = implode(',', $roleids);
        }else{
            $ids = $roleids;
        }  
        
        $sql = "select ".implode(',', self::$_fields)." from ".self::$tableName.' where roleid in ('.$ids.')'; 
        return self::querySql($sql);
    }   
}
