<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicNodeTerm extends DAO_Base{

    private static $tableName = 'node_term';    
    private static $_field = array('id','fid','node_id','item_id','term','term_content','term_type');       
    

    public static function delete_node_term_by_idArr($WhereArr){        
        if (empty($WhereArr)){
            return array();
        }        
        return self::delete_data($WhereArr,self::$tableName);        
    }
    
    public static function insert_node_term($DataArr){        
        if (empty($DataArr)){
            return array();
        }        
        return self::insert_data($DataArr,self::$tableName);        
    }

    /**
     * 根据表单和节点ID获取条件详细信息     
     * @param type $fid
     * @param type $nodeid
     * @return type
     */
    public static function get_node_term_by_fid_nodeid($fid,$nodeid){
        if (empty($fid) || empty($nodeid)){
            return array();
        }
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where fid=:fid and node_id=:node_id";
        $params=array('fid'=>$fid,'node_id'=>$nodeid);
        return self::querySql($sql, $params);            
    }
    
    
    /**
     * 根据表单和节点ID获取条件详细信息     
     * @param type $fid
     * @param type $nodeid
     * @return type
     */
    public static function get_node_term_by_fid_nodeidArr($fid,$nodeidArr){
        if (empty($fid) || empty($nodeidArr)){
            return array();
        }
        if (is_array($nodeidArr)){
            $ids = implode(',', $nodeidArr);
        }else{
            $ids = $nodeidArr;
        }   
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where fid=:fid and node_id in (".$ids.")";
        $params=array('fid'=>$fid);
        return self::querySql($sql, $params);            
    }
    
    /**
     * 根据表单和节点ID获取条件详细信息     
     * @param type $fid
     * @param type $nodeid
     * @return type
     */
    public static function get_node_term_by_nodeidArr($nodeidArr){
        if (empty($nodeidArr)){
            return array();
        }
        if (is_array($nodeidArr)){
            $ids = implode(',', $nodeidArr);
        }else{
            $ids = $nodeidArr;
        }   
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where node_id in (".$ids.")";            
        return self::querySql($sql);            
    }
}
