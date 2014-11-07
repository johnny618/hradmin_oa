<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicFormRequest extends DAO_Base{
    private static $tableName = 'work_form_request';   
    private static $_field = array('id','fid','uid','uname','dept','title','body','status','created');   
    
    public static function get_form_id_by_id($id){
        if (empty($id)){
            array();
        }
              
        $sql = "select fid from ".self::$tableName." where `id` =:id";        
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'count');
    }
    
    /**
     * 代办事宜页面数据
     * @param type $id
     * @return type
     */
    public static function get_need_do_list($request_ids){
        if (empty($request_ids)){
            array();
        }
        if (is_array($request_ids)){
            $request_ids = implode(',', $request_ids);
        }
        $sql = "select a.*,b.name as workname from ".self::$tableName." where id in (".$request_ids.") order by created desc";      
        return self::querySql($sql);
    }
    
    /**
     * 根据请求ID获取信息
     * @param type $id
     * @return type
     */
    public static function get_uid_by_id($id){
        if (empty($id)){
            array();
        }        
        $sql = "select uid from ".self::$tableName." where id=:id";
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'count');
    }
    
    public static function get_work_by_uids($uids){
        if (empty($uids)){
            array();
        }
        if (is_array($uids)){
            $ids = implode(',', $uids);
        }else{
            $ids = $uids;
        }
        $sql = "select id from ".self::$tableName." where `status` != 999 and isDelete = 0 and  uid in (".$ids.")";
        return self::querySql($sql,array(),'column');
    }

    public static function get_done_list_by_request_id($ids){
        if (empty($ids)){
            array();
        }
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }
        $sql = "select a.*,b.name as workname from work_form_request a ,work_form b where a.isDelete = 0 and a.fid = b.id and a.id in (".$ids.") order by created desc ";          
        return self::querySql($sql);
    }
    
    /**
     * 获取流程监控列表数据 START
     */       
    public static function getMonitorCount($startTime,$endTime,$title,$nodetype,$createrid,$fid){
        $sql = "select count(1) from work_form_request ";
        $sql .= "where isDelete = 0 ";
        if (!empty($startTime)){
            $sql .= " and created >= '".strtotime($startTime)."'";   
        }        
        if (!empty($endTime)){
            $sql .= " and created <= '".strtotime($endTime)."'";
        }   
        if (!empty($title)){
            $sql .= " and title like '".$title."%'";
        }
        if (isset($nodetype) && trim($nodetype)!=''){
            $sql .= " and status = '".$nodetype."'";
        }
        if (!empty($createrid)){
            $sql .= " and uid  = '".$createrid."'";
        }
        if (!empty($fid)){
            $sql .= " and fid  = '".$fid."'";
        }
        return self::querySql($sql,array(),'count');
    }
    
    public static function getMonitorList($startTime,$endTime,$title,$nodetype,$createrid,$fid,$currentPage, $page_size = 15){
        $sql = "select a.*,b.name as workname from work_form_request a left join work_form b on a.fid = b.id where  a.isDelete = 0  ";        
        if (!empty($startTime)){
            $sql .= " and a.created >= '".strtotime($startTime)."'";   
        }        
        if (!empty($endTime)){
            $sql .= " and a.created <= '".strtotime($endTime)."'";
        }   
        if (!empty($title)){
            $sql .= " and a.title like '".$title."%'";
        }
        if (isset($nodetype) && trim($nodetype)!=''){
            $sql .= " and a.status = '".$nodetype."'";
        }
        if (!empty($createrid)){
            $sql .= " and a.uid  = '".$createrid."'";
        }
        if (!empty($fid)){
            $sql .= " and a.fid  = '".$fid."'";
        }
        $sql .= " order by a.created desc";            
        if (!empty($currentPage) && !empty($page_size)){
            $sql .= " limit ".($currentPage-1)*$page_size.",".$page_size;    
        } 
        return self::querySql($sql);
    }
    /**
     * 获取流程监控列表数据 END
     */


    public static function check_show_by_id_uid($request_id){
        if (empty($request_id)){
            return array();
        }
        $sql = "select count(1) from ".self::$tableName." where id = :id and uid = :uid";
        $params = array('id'=>$request_id , 'uid'=>Yii::app()->user->id);
        return self::querySql($sql,$params,'count');
    }
}
