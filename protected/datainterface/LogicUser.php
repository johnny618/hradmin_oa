<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicUser extends DAO_Base{

    private static $tableName = 'user';                      

    public static function check_is_leader(){     
        $sql = "select count(1) from ".self::$tableName." where leader_id = ".Yii::app()->user->id; 
        return self::querySql($sql,array(),'count');
    }
    
    public static function check_user_is_exite($uid){     
        if (empty($uid)){
            return '';
        }
        $sql = "select count(1) from ".self::$tableName." where uid=:uid and leader_id = ".Yii::app()->user->id; 
        $params = array('uid'=>$uid);
        return self::querySql($sql,$params,'count');
    }
    
    
    public static function get_sub_of_leader(){             
        $sql = "select uid from ".self::$tableName." where leader_id = ".Yii::app()->user->id;        
        return self::querySql($sql,array(),'column');
    }

    public static function get_subs_of_leader($uids){
        if (empty($uids)){
            return '';
        }
        if (is_array($uids)){
            $ids = implode(',', $uids);
        }else{
            $ids = $uids;
        }
        $sql = "select uid from ".self::$tableName." where leader_id in (".$ids.")";
        return self::querySql($sql,array(),'column');
    }
    
    public static function get_leader_by_userid($uid){
        if (empty($uid)){
            return '';
        }
        $sql = "select leader_id from ".self::$tableName." where uid=:uid";        
        $params = array('uid'=>$uid);
        return self::querySql($sql,$params,'count');
    }
    
    public static function check_exite_by_uid($uid){
        if (empty($uid)){
            return '';
        }
        $sql = "select count(1) from ".self::$tableName." where uid=:uid";        
        $params = array('uid'=>$uid);
        return self::querySql($sql,$params,'count');
    }
    
    public static function check_email_by_uid($uid,$email){
        if (empty($uid) || empty($email)){
            return '';
        }
        $sql = "select count(1) from ".self::$tableName." where uid != :uid and email = :email";        
        $params = array('uid'=>$uid,'email'=>$email);
        return self::querySql($sql,$params,'count');
    }
    
    public static function get_info_by_userid($uid){
        if (empty($uid)){
            return '';
        }
        $sql = "select uid,uname,dept_cn,mobile,c_mobile from ".self::$tableName." where uid=:uid";  
        $params = array('uid'=>$uid);
        return self::querySql($sql,$params,'row');
    }
    
    public static function get_info_by_userids($uids){
        if (empty($uids)){
            return array();
        }
        if (is_array($uids)){
            $ids = implode(',', $uids);
        }else{
            $ids = $uids;
        }          
        $sql = "select uid,uname from ".self::$tableName.' where uid in ('.$ids.')'; 
        return self::querySql($sql);

    }
    
    public static function get_dept_by_userids($uids){
        if (empty($uids)){
            return array();
        }
        if (is_array($uids)){
            $ids = implode(',', $uids);
        }else{
            $ids = $uids;
        }          
        $sql = "select uid,dept_cn from ".self::$tableName.' where uid in ('.$ids.')'; 
        return self::querySql($sql);

    }
    
    public static function get_info_by_uid_id($id,$uids){
        if (empty($id)){
            return array();
        }   
        if (is_array($id)){
            $ids = implode(',', $id);
        }else{
            $ids = $id;
        }  
        $sql = "select uid,uname,dept_cn from ".self::$tableName.' where id in ('.$ids.')'; 
        if (!empty($uids)){
            if (is_array($uids)){
                $uidstr = implode(',', $uids);
            }else{
                $uidstr = $uids;
            } 
            $sql .= ' and uid in ('.$uidstr.') ';
        }
        return self::querySql($sql);
    }
    
    public static function insert_user_info($DataArr){               
        if (empty($DataArr)){
            return array();
        }        
        return self::insert_data($DataArr,self::$tableName);         
    }
    
    public static function update_user_info($DataArr,$WhereArr){
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
