<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicDocAuthority extends DAO_Base{

    private static $tableName = 'document_authority';                      
    private static $_field = array('id','tid','uid','uname');     

    public static function get_user_info_by_tid($tid){
        if (empty($tid)){
            return array();
        }
        $sql = 'select '.implode(',', self::$_field) . ' from '.self::$tableName .' where tid = :tid';
        $params = array('tid'=>$tid);
        return self::querySql($sql, $params);
    }
    
    public static function get_user_author_of_tid(){        
        $sql = 'select tid from '.self::$tableName .' where uid = '.Yii::app()->user->id;      
        return self::querySql($sql,array(),'column');
    }
    
    public static function insert_data_row($DataArr){
        if (empty($DataArr)){
            return array();
        }
        return self::insert_data($DataArr,self::$tableName);
    }
  
    public static function update_data_row($DataArr,$WhereArr){
        if (empty($DataArr)){
            return array();
        }
        return self::update_data($DataArr, $WhereArr,self::$tableName);
    }
    
    public static function delete_data_info($WhereArr){        
        if (empty($WhereArr)){
            return array();
        }        
        return self::delete_data($WhereArr,self::$tableName);        
    }
}
