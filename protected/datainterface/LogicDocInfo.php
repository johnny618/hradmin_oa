<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicDocInfo extends DAO_Base{

    private static $tableName = 'document_info';                      
    private static $_field = array('id','tid','uid','uname','title','tip','top','created','updated');

    public static function get_data_by_owner_count($tids,$uid = '',$uname = '',$title = '',$tid = ''){
        if (empty($tids)){
            return array();
        }
        $sql = "select count(1) from ".self::$tableName . " where  tid in (".implode(',',$tids).")";
        if (!empty($uid)){
            $sql .= " and  uid=".$uid;
        }

        if (!empty($uname)){
            $sql .= " and uname like '".$uname."%'";
        }

        if (!empty($title)){
            $sql .= " and title like '".$title."%'";
        }

        if (!empty($tid)){
            $sql .= " and tid = ".$tid;
        }
        return self::querySql($sql,array(),'count');
    }
    
    public static function get_data_by_owner($tids,$uid = '',$uname = '',$title = '',$tid = '',$currentPage, $page_size = 15){
        if (empty($tids)){
            return array();
        }
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName . " where  tid in (".implode(',',$tids).")";
        if (!empty($uid)){
            $sql .= " and  uid=".$uid;
        }

        if (!empty($uname)){
            $sql .= " and uname like '".$uname."%'";
        }

        if (!empty($title)){
            $sql .= " and title like '".$title."%'";
        }

        if (!empty($tid)){
            $sql .= " and tid = ".$tid;
        }
        $sql .= " order by created desc ";
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }
        return self::querySql($sql);
    }
    
    public static function get_data_by_term_count($uid = '',$uname = '',$title = '',$tid = ''){
        $sql = "select count(1) from ".self::$tableName." where 1=1 ";
        if (!empty($uid)){ 
            $sql .= " and  uid=".$uid;
        }
        
        if (!empty($uname)){
            $sql .= " and uname like '".$uname."%'";
        }

        if (!empty($title)){
            $sql .= " and title like '".$title."%'";
        }

        if (!empty($tid)){
            $sql .= " and tid = ".$tid;
        }
        return self::querySql($sql,array(),'count');
    }
    
    public static function get_data_by_term($uid = '',$uname = '',$title = '',$tid = '',$currentPage, $page_size = 15){
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where 1=1 ";
        if (!empty($uid)){ 
            $sql .= " and  uid=".$uid;
        }
        
        if (!empty($uname)){
            $sql .= " and uname like '".$uname."%'";
        }

        if (!empty($title)){
            $sql .= " and title like '".$title."%'";
        }

        if (!empty($tid)){
            $sql .= " and tid = ".$tid;
        }
        $sql .= " order by created desc ";
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }
        return self::querySql($sql);
    }
        
    public static function get_data_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName ." where id = :id";
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'row');
    }

    public static function get_data_by_tid_count($type=1){
        $sql = "select count(1) from ".self::$tableName ." where tid = :tid ";
        $params = array(':tid'=>$type);
        return self::querySql($sql,$params,'count');
    }

    public static function get_data_by_tid($type=1,$currentPage, $page_size = 15){
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName ." where tid = :tid order by top desc ,created desc ";
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;
        }
        $params = array(':tid'=>$type);
        return self::querySql($sql,$params);
    }

    public static function get_index_data($type=1,$limit=3){
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName ." where tid = :tid order by top desc ,created desc limit ".$limit;
        $params = array(':tid'=>$type);
        return self::querySql($sql,$params);
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
