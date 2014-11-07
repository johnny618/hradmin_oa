<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicFormProcess extends DAO_Base{

    private static $tableName = 'form_process';
    private static $_field = array('id','fid','isback','next_goal','init_id','node_id');

    /**
     * 根据表单ID获取所有表单详细流程
     * @param type $fid
     * @return type根据
     */
    public static function get_form_info_by_fid($fid){
        if (empty($fid)){
            return array();
        }
        $sql="select ".implode(',', self::$_field)." from ".self::$tableName."  where fid=:fid order by init_id";
        $params = array('fid'=>$fid);
        return self::querySql($sql, $params);
    }

    public static function delete_form_process_by_id($id){
        if (empty($id)){
            return array();
        }
        $sql="delete from ".self::$tableName."  where id=:id";
        $command =DbUtil::getActivityConnection()->createCommand($sql);
        $command->prepare();
        $command->bindParam(":id", $id, PDO::PARAM_INT);
        return $command->execute();
    }

    public static function modify_form_process_by_id($DataArr,$WhereArr){
        if (empty($DataArr)){
            return array();
        }
        return self::update_data($DataArr, $WhereArr,self::$tableName);
    }

    public static function insert_form_process($DataArr){
        if (empty($DataArr)){
            return array();
        }
        return self::insert_data($DataArr,self::$tableName);
    }

    public static function get_new_id_for_form_process(){
        $sql="select max(id) from ".self::$tableName;
        return self::querySql($sql,array(),'count');
    }

    public static function get_next_nodes($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $idstr = implode(',', $ids);
        }else{
            $idstr = $ids;
        }
        $sql = 'select id,init_id,node_id from '.self::$tableName.' where init_id in ('.$idstr.') ';
        return self::querySql($sql);
    }

    public static function get_next_nodes_by_ids_and_fid($ids,$fid){
        if (empty($ids) || empty($fid)){
            return array();
        }
        if (is_array($ids)){
            $idstr = implode(',', $ids);
        }else{
            $idstr = $ids;
        }
        $sql = 'select init_id from '.self::$tableName.' where init_id in ('.$idstr.') and fid = '.$fid;
        return self::querySql($sql,array(),'column');
    }

    public static function _get_next_nodes($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $idstr = implode(',', $ids);
        }else{
            $idstr = $ids;
        }
        $sql = 'select id,init_id,node_id,next_goal from '.self::$tableName.' where node_id in ('.$idstr.') ';
        return self::querySql($sql);
    }

}
