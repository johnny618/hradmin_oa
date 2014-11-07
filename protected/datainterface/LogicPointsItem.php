<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicPointsItem extends DAO_Base{

    private static $tableName = 'points_item';                      

    public static function get_data_all_count(){
        $sql = "select count(1) from ".self::$tableName ;                 
        return self::querySql($sql,array(),'count');     
    }
    
    public static function get_data_all($currentPage, $page_size = 15){
        $sql = "select id,name,parent_id from ".self::$tableName ;         
        $sql .= ' order by id desc';
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }   
        return self::querySql($sql);     
    }
    
    public static function get_parent_item_all(){
        $sql = "select id,name from ".self::$tableName .' where parent_id=0';                 
        return self::querySql($sql);     
    }
    
    public static function check_name($name,$id = ''){
        if (empty($name)){
            return '';
        }
        $sql = "select count(1) from ".self::$tableName .' where name = :name';
        if (!empty($id)){
            $sql .= ' and id != '.$id;
        }
        $params = array('name'=>$name);
        return self::querySql($sql,$params,'count');   
    }
    
    public static function get_data_row_by_id($id){
        if (empty($id)){
            return array();
        }
        
        $sql = "select id,name from ".self::$tableName . ' where id = :id'; 
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'row');     
    }
    
    public static function get_data_row_by_ids($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }else{
            $ids = $ids;
        }
        $sql = "select id,name from ".self::$tableName . " where id in (".$ids.")";            
        return self::querySql($sql);     
    }
    
    public static function get_parent_all(){
        $sql = "select id,name from ".self::$tableName .' where parent_id = 0 ' ;                 
        return self::querySql($sql);     
    }
    
    public static function get_data_all_count_by_child(){
        $sql = "select count(1) from ".self::$tableName .' where parent_id != 0' ;                 
        return self::querySql($sql,array(),'count');     
    }
    
    public static function get_data_all_by_child($currentPage, $page_size = 15){
        $sql = "select id,name,parent_id from ".self::$tableName ;         
        $sql .= ' where parent_id != 0 order by id desc';
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }   
        return self::querySql($sql);     
    }

    public static function get_child_item_by_parent_id($pid){
        if (empty($pid)){
            return array();
        }
        $sql = "select id from ".self::$tableName .' where parent_id='.$pid;
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

    public static function delete_data_info($id){
        if (empty($id)){
            return array();
        }
        $sql = "delete from ".self::$tableName ." where id=".$id." or parent_id=".$id;
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();

    }

}
