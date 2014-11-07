<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicWorkReport extends DAO_Base{

    private static $tableName = 'work_report';
    private static $_field = array('id','uid','uname','report','reportTime','late','created','updated');

    /**
     * 获取自己工作小结 START
     * @return type
     */
    public static function get_work_report_data_by_uid_count(){
        $sql = "select count(1) from ".self::$tableName ." where uid=:uid";      
        $params = array('uid' => Yii::app()->user->id);
        return self::querySql($sql,$params,'count');      
    }
    
    public static function get_work_report_data_by_uid($currentPage, $page_size = 15){
        $sql = "select ".  implode(',', self::$_field)." from ".self::$tableName ." where uid=:uid order by reportTime desc";   
        
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }   
        $params = array('uid' => Yii::app()->user->id);
        return self::querySql($sql,$params);      
    }    
    /**
     * 获取自己工作小结 END
     */
    
    
    /**
     * 获取所有人工作小结 START
     * @return type
     */
    public static function get_work_report_data_all_count($startTime,$endTime,$uid,$late){
        $sql = "select count(1) from ".self::$tableName . " where 1=1 ";
        if (!empty($startTime)){
            $sql .= " and reportTime >= ".$startTime;
        }
        if (!empty($endTime)){
            $sql .= " and reportTime <= ".$endTime;
        }
        if (!empty($uid)){
            $sql .= " and uid = ".$uid;
        }
        if (isset($late)  && trim($late)!=''){
            $sql .= " and late = ".$late;
        }
        return self::querySql($sql,array(),'count');      
    }
    
    public static function get_work_report_data_all($startTime,$endTime,$uid,$late,$currentPage, $page_size = 15){
        $sql = "select ".  implode(',', self::$_field)." from ".self::$tableName . " where 1=1 ";
        if (!empty($startTime)){
            $sql .= " and reportTime >= ".$startTime;
        }
        if (!empty($endTime)){
            $sql .= " and reportTime <= ".$endTime;
        }
        if (!empty($uid)){
            $sql .= " and uid = ".$uid;
        }
        if (isset($late)  && trim($late) != ''){
            $sql .= " and late = ".$late;
        }
        $sql .= ' order by reportTime desc';
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }   
        return self::querySql($sql);      
    }    
    
    public static function get_work_data_all($startTime,$endTime){
        $sql = "select uid,uname,reportTime,late,created from ".self::$tableName . " where 1=1 ";
        if (!empty($startTime)){
            $sql .= " and reportTime >= ".$startTime;
        }
        if (!empty($endTime)){
            $sql .= " and reportTime <= ".$endTime;
        }
        $sql .= ' order by uid';
        return self::querySql($sql);      
    }    
    
    
    /**
     * 获取所有人工作小结 END
     */
    
    /**
     * 根据登录用户获取所有下属工作小结 START
     * @return type
     */
    public static function get_work_report_data_by_leader_count($sub,$startTime,$endTime,$uid,$late){
        if(empty($sub)){
            return array();
        }
        if (is_array($sub)){
            $subs = implode(',', $sub);
        }else{
            $subs = $sub;
        }
        $sql = "select count(1) from ".self::$tableName ." where uid in (".$subs.")";     
        if (!empty($startTime)){
            $sql .= " and reportTime >= ".$startTime;
        }
        if (!empty($endTime)){
            $sql .= " and reportTime <= ".$endTime;
        }
        if (!empty($uid)){
            $sql .= " and uid = ".$uid;
        }
        if (isset($late)  && trim($late) != ''){
            $sql .= " and late = ".$late;
        }
        return self::querySql($sql,array(),'count');      
    }
    
    public static function get_work_report_data_by_leader($sub ,$startTime,$endTime,$uid,$late ,$currentPage, $page_size = 15){
        if(empty($sub)){
            return array();
        }
        if (is_array($sub)){
            $subs = implode(',', $sub);
        }else{
            $subs = $sub;
        }
        $sql = "select ".  implode(',', self::$_field)." from ".self::$tableName ." where uid in (".$subs.")";   
        if (!empty($startTime)){
            $sql .= " and reportTime >= ".$startTime;
        }
        if (!empty($endTime)){
            $sql .= " and reportTime <= ".$endTime;
        }
        if (!empty($uid)){
            $sql .= " and uid = ".$uid;
        }
        if (isset($late)  && trim($late) != ''){
            $sql .= " and late = ".$late;
        }
        $sql .= ' order by reportTime desc';
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        }   
        return self::querySql($sql);      
    }    
    /**
     * 根据登录用户获取所有下属工作小结 END
     */
    
    public static function get_work_report_info_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql = "select ".  implode(',', self::$_field)." from ".self::$tableName ." where id = :id";   
        $params = array('id' => $id);
        return self::querySql($sql,$params,'row');    
    }
    
    /**
     * 根据时间和用户ID判断是否重复提交日报
     * @param type $reporttime
     * @return string
     */
    public static function check_data_by_date($reporttime){
        if (empty($reporttime)){
            return '';
        }
        $sql = "select count(*) from ".self::$tableName ." where uid = :uid and reportTime=:reportTime";
        $params = array('uid' => Yii::app()->user->id,'reportTime'=>$reporttime);
        return self::querySql($sql,$params,'count');     
    }
    

    public static function check_workdate($date,$id){
        if (empty($date) && empty($id)){
            return array();
        }
        $sql = "select count(1) from ".self::$tableName ." where uid=:uid and reportTime=:reportTime and id != :id";      
        $params = array('uid' => Yii::app()->user->id,'reportTime'=>$date,'id'=>$id);
        return self::querySql($sql,$params,'count');      
    }

    public static function update_work_report_data($DataArr,$WhereArr){
        if (empty($DataArr)){
            return array();
        }
        return self::update_data($DataArr, $WhereArr,self::$tableName);
    }

    public static function insert_work_report_data($DataArr){
        if (empty($DataArr)){
            return array();
        }
        return self::insert_data($DataArr,self::$tableName);
    }

    

}
