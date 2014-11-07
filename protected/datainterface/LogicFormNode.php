<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicFormNode extends DAO_Base{    

    private static $tableName = 'form_node';         
    private static $_field = array('id','fid','`name`','type','`show`','edit','notnull');       
    
    public static function get_form_node_by_fid($fid){               
        if (empty($fid)){
            return array();
        }
        $sql = "select id,name,type from ".self::$tableName." where fid=".$fid;                   
        $command =DbUtil::getActivityConnection()->createCommand($sql);      
        $dataReader=$command->query();
        $data = $dataReader->readAll();
        return $data;                    
    }
    
    public static function get_init_node_by_fid($fid){               
        if (empty($fid)){
            return array();
        }
        $sql = "select id from ".self::$tableName." where fid=".$fid." and `type`=0";                   
        return self::querySql($sql,array(),'column');          
    }
    
    public static function get_next_form_node_by_fid_id($fid,$id){               
        if (empty($fid) || empty($id)){
            return array();
        }
        $sql = "select ".  implode(',', self::$_field)." from ".self::$tableName." where fid=".$fid ." and id=".$id." order by id limit 1";    
        return self::querySql($sql,array(),'row');                
    }
    
    public static function get_names_by_ids($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }
        $sql = "select id,`name` from ".self::$tableName." where id in (".$ids.")";
        return self::querySql($sql);
    }
    
    
    public static function delete_form_node_by_id_fid($WhereArr){               
        if (empty($WhereArr)){
            return array();
        }
        return self::delete_data($WhereArr,  self::$tableName);          
    }
    
    public static function modify_form_node_by_id_fid($DataArr,$WhereArr){             
        if (empty($DataArr) || empty($WhereArr)){            
            return array();
        }        
        return self::update_data($DataArr, $WhereArr,self::$tableName);         
    }
    
    public static function insert_form_node($DataArr){               
        if (empty($DataArr)){
            return array();
        }        
        return self::insert_data($DataArr,self::$tableName,'replace');         
    }

}
