<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicUserAuthority extends DAO_Base{

    private static $tableName = 'user_authority';                      

    public static function get_info_by_uid($uid){
        if (empty($uid)){
            return array();
        }      
        $sql = "select menuCode from ".self::$tableName.' where uid =:uid'; 
        $params = array('uid'=>$uid);
        return self::querySql($sql,$params,'column');
    }
    
    public static function delete_info_by_uid($WhereArr){        
        if (empty($WhereArr)){
            return array();
        }        
        return self::delete_data($WhereArr,self::$tableName);        
    }
    
    public static function insert_data_info($DataArr){        
        if (empty($DataArr)){
            return array();
        }        
        return self::insert_data($DataArr,self::$tableName);        
    }
}
