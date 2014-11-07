<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicWorkForm extends DAO_Base{

    private static $tableName = 'work_form';         
    private static $_fields = array('id','`name`','`desc`','pid');       
    
    public static function get_data_all(){
        $sql = "select ".implode(',', self::$_fields)." from ".self::$tableName." where isDelete = 0 order by dsporder";                
        return self::querySql($sql);
    }

    
    public static function get_data_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql = "select `name` from ".self::$tableName." where id = :id";
        $params = array(':id'=>$id);
        return self::querySql($sql, $params, 'count');
    }
    
    
    public static function get_index_ids($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }
        $sql = "select * from ".self::$tableName." where id in (".$ids.")";
        return self::querySql($sql);
    }
}
