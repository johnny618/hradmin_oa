<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicPointsInfo extends DAO_Base{

    private static $tableName = 'points_info';                      
    private static $_field = array('id','uid','uname','pid','date','score','cycle');

    public static function get_info_by_id_count($id){
        if (empty($id)){
            return array();
        }
        $sql = 'SELECT COUNT(1) FROM ( select id from '.self::$tableName .' where pid = :pid group by date ) tab';
        $params = array('pid'=>$id);
        return self::querySql($sql, $params,'count');
    }

    public static function get_info_by_id($id,$currentPage, $page_size = 15){
        if (empty($id)){
            return array();
        }
        $sql = 'select id,pid,date,score,cycle,COUNT(1) as num from '.self::$tableName .' where pid = :pid group by date order by date desc';
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;
        }
        $params = array('pid'=>$id);
        return self::querySql($sql, $params);
    }

    public static function get_data_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql = 'select '.implode(',', self::$_field) . ' from '.self::$tableName .' where pid = :pid';
        $params = array('pid'=>$id);
        return self::querySql($sql, $params);
    }

    public static function get_data_by_pid_date($pid,$date){
        if (empty($pid) || empty($date)){
            return array();
        }
        $sql = 'select '.implode(',', self::$_field) . ' from '.self::$tableName .' where pid = :pid and date = :date';
        $params = array('pid'=>$pid,'date'=>$date);
        return self::querySql($sql, $params);
    }
    
    public static function get_data_by_uid($uid,$date){
        if (empty($uid) || empty($date)){
            return array();
        }
                
        $sql = 'select '.implode(',', self::$_field) . ' from '.self::$tableName ;
        $sql .= " where date >= '".date("Y-m-d", strtotime("0 months", strtotime($date))) . "' and date < '".date("Y-m-d", strtotime("+1 months", strtotime($date))) . "'";
        $sql .= " and uid = :uid";
        $params = array('uid'=>$uid);        
        return self::querySql($sql, $params);
    }
    
    public static function get_old_score_by_uid($uid,$date){
        if (empty($uid) || empty($date)){
            return array();
        }
                
        $sql = 'select sum(score) from '.self::$tableName ;
        $sql .= " where date >= '".date("Y-m-d", strtotime("-1 months", strtotime($date))) . "' and date < '".date("Y-m-d", strtotime("0 months", strtotime($date))) . "'";
        $sql .= " and uid = :uid";        
        $params = array('uid'=>$uid);  
        return self::querySql($sql, $params,'count');
    }
    
    public static function get_sum_score_by_uid($uid){
        if (empty($uid)){
            return array();
        }
                
        $sql = 'select sum(score) from '.self::$tableName ;
        $sql .= " where uid = :uid";        
        $params = array('uid'=>$uid);  
        return self::querySql($sql, $params,'count');
    }
    
    //select MONTH(`date`) mn,uname,uid,sum(score) from points_info where `date`>='2014-07-01' and `date` <'2014-09-01'  group by mn,uid;
    public static function get_score_all($date){
        if (empty($date)){
            return array();
        }                
        $sql = 'select MONTH(`date`) mn,uname,uid,sum(score) from '.self::$tableName ;
        $sql .= " where date >= '".date("Y-m-d", strtotime("-1 months", strtotime($date))) . "' and date < '".date("Y-m-d", strtotime("+1 months", strtotime($date))) . "' group by mn,uid";
        return self::querySql($sql);
    }
    
    public static function get_score_uid_by_term($type = '',$date = ''){
        $sql = 'select sum(score) as s,uid,uname from ' .self::$tableName ; 
        if ($type == 1 && !empty($date)){
            $sql .= " where date >= '".date("Y-m-d", strtotime("0 months", strtotime($date))) . "' and date < '".date("Y-m-d", strtotime("+1 months", strtotime($date)))."'";
        }else if ($type == 2 && !empty($date)){            
            $sdate = date("Y-m-d",mktime(0, 0, 0, 1, 1, $date));
            $edate = date("Y-m-d",mktime(0, 0, 0, 1, 1, $date+1));
            $sql .= " where date >= '".$sdate . "' and date < '".$edate."'";
        }
        $sql .= ' group by uid  ORDER BY uid';         
        return self::querySql($sql);
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

    public static function delete_data_info_by_pids($ids){
        if (empty($ids)){
            return array();
        }
        $sql = "delete from ".self::$tableName ." where pid in (".implode(',',$ids).")";
        $command = Yii::app()->db->createCommand($sql);
        return $command->execute();
    }
}
