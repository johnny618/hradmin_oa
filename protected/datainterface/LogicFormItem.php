<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicFormItem extends DAO_Base{

    private static $tableName = 'work_form_item';         
    private static $_fields = array('id','fid','db_field_name','field_name','field_type','field_attr','field_body','dsporder','type','created');       
    
    /**
     * 根据表单ID获取需要选择条件的字段 101 102 103
     * @param type $id
     * @return type
     */
    public static function get_form_item_data_by_formid($fid){        
        if (empty($fid)){
            return array();
        }     
        $termKey = implode(',',array_keys(MyConst::$formItemTerm));        
        $sql = "select ".implode(",",self::$_fields)." from ".self::$tableName." where fid=:fid and ( field_attr in (".$termKey.") or field_type = 4 )";
        $params = array('fid'=>$fid);             
        return self::querySql($sql,$params);
    }
    
    
    public static function get_form_item_data_by_id($ids){             
        if (empty($ids)){
            return array();
        } 
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }
        $sql = "select id,field_name,db_field_name from ".self::$tableName." where id in (".$ids.")";  
        return self::querySql($sql);
    }
    
    public static function get_db_field_name_by_id($id){             
        if (empty($id)){
            return array();
        } 
        
        $sql = "select db_field_name from ".self::$tableName." where id =:id and type=0";  
        $params = array('id'=>$id);
        return self::querySql($sql,$params,'count');
    }

}
