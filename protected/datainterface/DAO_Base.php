<?php

class DAO_Base {
    
    /**
     * 得到数据库的连接
     */
    private static function getConnection(){
        return Yii::app()->db;
    } 
        

    protected static function querySql($sql,$params = array(),$select_type='all'){
        if (empty($sql)){
            return false;
        }
        $command = self::getConnection()->createCommand($sql);           
        switch(strtolower($select_type)) {     
            case "row" :
                return $command->queryRow(true,$params);
            case "column" :
                return $command->queryColumn($params);
            case "count":                
                return $command->queryScalar($params);
            case "all" :     
            default :
                return $command->queryAll(true,$params);
        }        
    }
    
    
    /**
     * 删除数据公用函数
     * @param type $whereArr
     * @param type $table
     * @return boolean
     */
    protected static function delete_data($whereArr = array(),$table){
        if (empty($table)){
            return false;
        }    
        list($sql,$params) = self::join_sql(array(),$whereArr,$table,'delete');            
        $command = self::getConnection()->createCommand($sql);   
        return $command->execute($params);        
    }
    
    /**
     * 更新数据公用函数
     * @param type $dataArr
     * @param type $whereArr
     * @param type $table
     * @return boolean
     */
    protected static function update_data($dataArr,$whereArr = array(),$table){
        if (empty($dataArr) || empty($table)){
            return false;
        }    
        list($sql,$params) = self::join_sql($dataArr,$whereArr,$table,'update');   
        $command = self::getConnection()->createCommand($sql);   
        return $command->execute($params);        
    }
    
    
    /**
     * 添加数据公用函数
     * @param type $dataArr 
     * @param type $table  表名
     * @param type $insert SQL语句类型 默认是INSERT 也可以是replace
     * @return boolean
     */
    protected static function insert_data($dataArr,$table,$insert = 'insert'){
        if (empty($dataArr) || empty($table)){
            return false;
        }             
        list($sql,$params) = self::join_sql($dataArr,array(),$table,$insert);
        $command = self::getConnection()->createCommand($sql);   
        return $command->execute($params);            
    }

    private static function join_sql($dataArr = array() , $whereArr = array() , $table = "" , $sql_type = "select" , $fields = array(),$limit_str = "",$order_by_str = ""){
        if (empty($fields) || !is_array($fields)) {
            $fields = "*";
        } else {
            $fields = implode(",",$fields);
        }
        
         switch(strtolower($sql_type)) {
            case "replace" :
            case "insert" ://插入
                if ($sql_type == "replace") {
                    $sql_h = "replace";
                } else {
                    $sql_h = "insert";
                }
                $key = $_key = '';
                foreach($dataArr as $dataArrKey => $dataArrVal ){
                    $val[':'.$dataArrKey] = $dataArrVal;                    
                    $key .= $dataArrKey . ',';
                    $_key .= ':'. $dataArrKey . ',';
                }
                $key = rtrim($key, ',');
                $_key = rtrim($_key, ',');            
                $sql = "{$sql_h} into `{$table}` (" . $key . ") values (" . $_key . ")";
                $montage_res = array($sql,$val);                     
                break;
            case "update" ://更新
                $set = '';
                foreach($dataArr as $dataArrKey => $dataArrVal ){
                    $val[':'.$dataArrKey] = $dataArrVal;                    
                    $set .= $dataArrKey . '=:'.$dataArrKey.',';                    
                }
                $set = rtrim($set, ',');                
                
                $sql = "update `{$table}` set " . $set;
                if (!empty($whereArr)) {
                    list($where_val,$sql_add) = self::_init_where_str($whereArr);
                    $sql .= (" " . $sql_add);
                } else {
                    $where_val = array();
                }
                if (!empty($limit_str)) {
                    $sql .= " limit " . $limit_str;
                }
                $montage_res = array($sql,array_merge($val,$where_val));
                break;
            case "delete" ://删除
                $sql = "DELETE from `" . $table . "`";
                list($val,$sql_add) = self::_init_where_str($whereArr);
                $sql .= $sql_add;                
                if (!empty($limit_str)) {
                    $sql .= " limit " . $limit_str;
                }
                $montage_res = array($sql,$val);
                break;
            default :
                $montage_res = array();
                break;
         }
         return $montage_res;
    }
    
    /**
     * 拼接SQL where条件
     * @param array $where
     * @param string $sql_type sql类型
     * @return array
     */
    private static function _init_where_str($where = array(),$sql_type = "select") {
        if (empty($where)) {
            return array(array(),'');
        }

        $where_add = $where_value = array();
        $s_t = ($sql_type == "select") ? "=" : $sql_type;
        foreach($where as $where_key => $where_val) {
            if (is_array($where_val)) {
                if ($sql_type == "select") {                    
                    $where_add[] = ($where_key . " in (:w_{$where_key} )");
                    $where_value[":w_{$where_key}"] = implode(",",$where_val);
                } elseif ($sql_type == "like") {
                    foreach($where_val as $where_val_val) {
                        $where_add[] = ($where_key . " {$s_t} :w_{$where_key}");
                        $where_value[":{$where_key}"] = $where_val_val;
                    }
                }
            } else {
                $where_add[] = ($where_key . " {$s_t} :w_{$where_key}");
                $where_value[":w_{$where_key}"] = $where_val;
            }
        }
        return array($where_value," where " . implode(" and ",$where_add));
    }
    
}
