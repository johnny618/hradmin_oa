<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicRole extends DAO_Base{

    private static $tableName = 'role';
    private static $_fields = array('id','name');


    public static function insert_role($DataArr){
        if (empty($DataArr)){
            return array();
        }
        return self::insert_data($DataArr,self::$tableName);
    }

    public static function get_max_id(){
        $sql = "select max(id) from ".self::$tableName;
        return self::querySql($sql, array(), 'count');
    }

    public static function get_like_name($name){
        $sql = "select ".implode(',',self::$_fields)." from ".self::$tableName;
        if (!empty($name)){
            $sql .= " where name like '".$name."%'";
        }
        return self::querySql($sql);
    }
    
    public static function get_rolename_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql = "select `name` from ".self::$tableName.' where id=:id';
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'count');
    }

    public static function get_role_and_count(){
        $sql = "select a.id,a.`name`,count(b.roleid) as cou from role a left join role_info b on a.id=b.roleid group by a.id";
        return self::querySql($sql);
    }


}
