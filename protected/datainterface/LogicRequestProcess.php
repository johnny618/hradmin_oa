<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LogicRequestProcess extends DAO_Base{
    private static $tableName = 'request_process';
    private static $_field = array('id','request_id','status','operate','tip','updated');


    public static function find_examine_from(){
        $sql = "select request_id,status from ".self::$tableName;
        return self::querySql($sql);
    }

    public static function get_status_by_next_id($request_id,$id){
        if (empty($id) || empty($request_id)){
            array();
        }
        $sql = "select `status` from ".self::$tableName." where request_id = :request_id and next_status =:next_status";
        $params = array('request_id'=>$request_id,'next_status'=>$id);
        return self::querySql($sql,$params,'count');
    }

    public static function get_next_status_by_status($request_id,$id){
        if (empty($id) || empty($request_id)){
            array();
        }
        $sql = "select `next_status` from ".self::$tableName." where request_id = :request_id and `status` =:status and next_status != '' LIMIT 1";
        $params = array('request_id'=>$request_id,'status'=>$id);
        return self::querySql($sql,$params,'count');
    }

    public static function get_next_ids_by_status($request_id,$id){
        if (empty($id) || empty($request_id)){
            array();
        }
        $sql = "select `next_status` from ".self::$tableName." where request_id = :request_id and `status` =:status";
        $params = array('request_id'=>$request_id,'status'=>$id);
        return self::querySql($sql,$params,'column');
    }

    public static function _get_next_ids_by_status($request_id,$id){
        if (empty($id) || empty($request_id)){
            array();
        }
        $sql = "select `status` from ".self::$tableName." where request_id = :request_id and `status` >:status";
        $params = array('request_id'=>$request_id,'status'=>$id);
        return self::querySql($sql,$params,'column');
    }

    public static function find_need_show_form_count(){
        $userid = Yii::app()->user->id;
        $deptid = Yii::app()->user->dept;
        if (empty($userid) || empty($deptid)){
            array();
        }
        $sql = "select count(1) from  ( ";
        $sql .= "select request_id,next_status from ( ";
        $sql .= "   select request_id,next_status from (select request_id,next_status from request_process where request_id in (SELECT id FROM work_form_request WHERE `status` != 999)  order by id desc )tab group by request_id) t ";
        $sql .= "   where t.next_status in ( ";
        $sql .= " select node_id from node_operate where term = 0 and `type` = 0 ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 1 and  operater = '".$deptid."' ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 2 and  operater = '".$userid."' ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 3 and  operater in (select roleid from role_info where userid = '".$userid."') ";

        $subIds = LogicUser::get_sub_of_leader();  //获取上级领导下所有的下属
        if (!empty($subIds)){
            $request_ids = LogicFormRequest::get_work_by_uids($subIds);   //根据下属成员ID获取除办结以外正在审批的所有请求ID
            if (!empty($request_ids)){
                $next_request = self::get_new_data_by_request_ids($request_ids);

                if (!empty($next_request)){
                    $sql .= " union all select node_id from node_operate where term = 0 and `type` = 4 and ";
                    $sql .= " node_id in ( ".implode(',',$next_request)." )";
                    $sql .= " and t.request_id in (".implode(',',$request_ids).")";
                    $sql .= "  group by node_id";
                }
            }
        }
        $sql .= " ) group by request_id ";
        $sql .= ")c";
        //$params = array('operater'=>$userid,'dept'=>$deptid);
        return self::querySql($sql, array(),'count');

    }


    /**
     *
     * @param type $userid
     * @param type $deptid
     * @param type $page   第几页
     * @param type $page_size  每页多少数据
     * @return type
     */
    public static function find_need_show_form_info($page = 1,$page_size = 15){
        $userid = Yii::app()->user->id;
        $deptid = Yii::app()->user->dept;
        if (empty($userid) || empty($deptid)){
            array();
        }
        $sql = "select request_id,next_status,updated from ( ";
        $sql .= "   select request_id,next_status,updated from (select request_id,next_status,updated from request_process where request_id in (SELECT id FROM work_form_request WHERE `status` != 999) order by id desc )tab group by request_id) t ";
        $sql .= "   where t.next_status in ( ";
        $sql .= " select node_id from node_operate where term = 0 and `type` = 0 ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 1 and  operater = '".$deptid."' ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 2 and  operater = '".$userid."' ";
        $sql .= " union all select node_id from node_operate where term = 0 and `type` = 3 and  operater in (select roleid from role_info where userid = '".$userid."') ";

        $subIds = LogicUser::get_sub_of_leader();  //获取上级领导下所有的下属
        if (!empty($subIds)){
            $request_ids = LogicFormRequest::get_work_by_uids($subIds);   //根据下属成员ID获取除办结以外正在审批的所有请求ID
            if (!empty($request_ids)){
                $next_request = self::get_new_data_by_request_ids($request_ids);

                if (!empty($next_request)){
                    $sql .= " union all select node_id from node_operate where term = 0 and `type` = 4 and ";
                    $sql .= " node_id in ( ".implode(',',$next_request)." )";
                    $sql .= " and t.request_id in (".implode(',',$request_ids).")";
                    $sql .= "   group by node_id";
                }
            }
        }

        $sql .= " ) group by request_id order by updated desc";
        if (!empty($page) && !empty($page_size)){
            $offset = ($page - 1)*$page_size;
            $sql .= " limit $offset , $page_size";
        }
        //$params = array('operater'=>$userid,'dept'=>$deptid);
        return self::querySql($sql);

    }

    public static function get_new_data_by_request_ids($request_ids){
        if (empty($request_ids)){
            return array();
        }
        if (is_array($request_ids)){
            $ids = implode(',',$request_ids);
        }else{
            $ids = $request_ids;
        }
        $sql = 'select next_status from ';
        $sql .= ' (select * from (select * from '.self::$tableName.' where request_id in ('.$ids.') order by id desc )tab group by request_id ) z ';
        $sql .= ' where z.next_status != "" group by next_status ';
        return self::querySql($sql,array(),'column');
    }

    /**
     * 根据登录的用户ID获取自己所有已办事宜的请求ID总数
     * @return type
     */
    public static function get_data_by_userid_count(){
        $sql = "select count(1) FROM ( select count(1) from ".self::$tableName." where operate = :operate group by request_id ) t";
        $params = array('operate'=>Yii::app()->user->id);
        return self::querySql($sql, $params,'count');
    }
    /**
     * 根据登录的用户ID获取自己所有已办事宜的请求ID
     * @return type
     */
    public static function get_data_by_userid($page, $page_size){
        $sql = "select request_id from ".self::$tableName." where operate = :operate group by request_id order by updated desc ";
        if (!empty($page) && !empty($page_size)){
            $offset = ($page - 1)*$page_size;
            $sql .= " limit $offset , $page_size";
        }
        $params = array('operate'=>Yii::app()->user->id);
        return self::querySql($sql, $params,'column');
    }

    /**
     * 根据申请ID获取最新的当前状态
     * @param type $ids
     * @return type
     */
    public static function get_new_status_by_ids($ids){
        if (empty($ids)){
            return array();
        }
        if (is_array($ids)){
            $ids = implode(',', $ids);
        }
        $sql = "select * from (select request_id,`status` from ".self::$tableName." where request_id in (".$ids.") order by updated desc )t GROUP BY request_id";
        return self::querySql($sql);
    }


    public static function check_show_by_request_id_uid($request_id){
        if (empty($request_id)){
            return array();
        }
        $sql = "select count(1) from ".self::$tableName." where request_id = :request_id and operate = :operate";
        $params = array('request_id'=>$request_id , 'operate'=>Yii::app()->user->id);
        return self::querySql($sql,$params,'count');
    }



}
