<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicNodeOperate extends DAO_Base{

    private static $tableName = 'node_operate';    
    private static $_field = array('id','node_id','term','type','operater','operater_zh');
    
    /**
     * 根据节点ID获取数据
     * @param type $nodeid
     * @return type
     */
    public static function get_data_by_id($nodeid){
        if (empty($nodeid)){
            return array();
        }
        if (is_array($nodeid)){
            $ids = implode(',', $nodeid);
        }else{
            $ids = $nodeid;
        }
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where node_id in (".$ids.")";        
        return self::querySql($sql);        
    }
    
    /**
     * 根据节点ID获取数据
     * @param type $nodeid
     * @return type
     */
    public static function get_data_by_id_row($nodeid){
        if (empty($nodeid)){
            return array();
        }
        if (is_array($nodeid)){
            $ids = implode(',', $nodeid);
        }else{
            $ids = $nodeid;
        }
        $sql = "select ".implode(',', self::$_field)." from ".self::$tableName." where node_id in (".$ids.")";             
        return self::querySql($sql,array(),'row');        
    }
    
    
    public static function delete_node_operate_by_id($WhereArr){        
        if (empty($WhereArr)){
            return array();
        }        
        return self::delete_data($WhereArr,self::$tableName);        
    }
    
    /**
     * 根据用户名称或者部门查找要显示的全部字段
     * @param type $userid
     * @param type $deptid
     * @return type
     */
    public static function find_handle_node($userid,$deptid){
        if (empty($userid) || empty($deptid)){
            array();
        }
        $sql = "select node_id from ".self::$tableName." where (`type` = 0) or (`type` = 2 and operater = :operater) or (`type` = 1 and operater = :dept )  group by node_id";
        $params = array('operater'=>$userid,'dept'=>$deptid);        
        return self::querySql($sql, $params,'column');
    }

}
