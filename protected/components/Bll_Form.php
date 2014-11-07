<?php

class Bll_Form{

    public static function get_form_node_by_fid($fid){
        if(empty($fid)){
           return array();
        }
        return LogicFormNode::get_form_node_by_fid($fid);
    }

     public static function get_current_node_by_requestId($request_id) {
        if (!$request_id) {
            return array();
        }
        $result = Yii::app()->db->createCommand('select `status` from ' . RequestProcess::model()->tableName() . ' where request_id =' . $request_id . ' order by id desc limit 1')->queryRow();
        if (!$result) {
            return array();
        }
        return $result['status'];
     }


    public static function get_form_item_data_by_formid($fid){
        if(empty($fid)){
           return array();
        }
        return LogicFormItem::get_form_item_data_by_formid($fid);
    }


    public static function delete_process_and_nodeterm($id,$fid){
        if (!empty($id) && !empty($fid)){
            LogicFormProcess::delete_form_process_by_id($id);
            $WhereArr = array('fid'=>$fid,'node_id'=>$id);
            self::delete_node_term_old($WhereArr);
        }

    }

    public static function delete_node_term_old($WhereArr){
        LogicNodeTerm::delete_node_term_by_idArr($WhereArr);
    }

    //获取类型数据
    public static function get_from_type(){
        $formType = LogicWorkForm::get_data_all();
        if (empty($formType)){
            return array();
        }
        foreach ($formType as $formTypeKey => $formTypeVal){
            if ($formTypeVal['pid'] == '0'){
                $parentData[$formTypeVal['id']] = $formTypeVal;
            }else{
                $childData[$formTypeVal['pid']][$formTypeVal['id']] = $formTypeVal;
            }
        }
        foreach($parentData as $parentDataKey => $parentDataVal){
            if (!empty($childData[$parentDataKey])){
                $parentData[$parentDataKey]['child'] = $childData[$parentDataKey];
            }
        }
        return $parentData;
    }

    public static function get_node_term_by_fid_nodeid($fid,$nodeid){
        if (empty($fid) && empty($nodeid)){
            return array();
        }
        $dataTerm = LogicNodeTerm::get_node_term_by_fid_nodeid($fid,$nodeid);
        if (empty($dataTerm)){
            return array();
        }
        $itemids = array();
        foreach($dataTerm as $dataTermKey => $dataTermVal){
            $itemids[] = $dataTermVal['item_id'];
        }
        $itemids = array_unique($itemids);
        $dataItem = LogicFormItem::get_form_item_data_by_id($itemids);
        $_dataItem = self::init_item_arr($dataItem);
        foreach($dataTerm as $dataTermKey => $dataTermVal){
            if (!empty($_dataItem[$dataTermVal['item_id']])){
                $dataTerm[$dataTermKey]['field_name'] = $_dataItem[$dataTermVal['item_id']];
            }
        }
        return $dataTerm;
    }

    private static function init_item_arr($dataItem){
        $result = array();
        foreach($dataItem as $dataItemKey => $dataItemVal){
            $result[$dataItemVal['id']] = $dataItemVal['field_name'];
        }
        return $result;
    }


    public static function getDoneListCount(){
        return LogicRequestProcess::get_data_by_userid_count();
    }

    public static function getDoneList($currentPage, $page_size){
        $requestArr = LogicRequestProcess::get_data_by_userid($currentPage, $page_size);

        if (empty($requestArr)){
            return array();
        }
        return LogicFormRequest::get_done_list_by_request_id($requestArr);
    }


    public static function getMonitorCount($startTime,$endTime,$title,$nodetype,$createrid,$fid){
        return LogicFormRequest::getMonitorCount($startTime,$endTime,$title,$nodetype,$createrid,$fid);
    }

    public static function getMonitorList($startTime,$endTime,$title,$nodetype,$createrid,$fid,$currentPage, $page_size = 15){
        $data = LogicFormRequest::getMonitorList($startTime,$endTime,$title,$nodetype,$createrid,$fid,$currentPage, $page_size);
        foreach ($data as $dataKey => $dataVal){
            $ids[] = $dataVal['id'];
        }

        if (empty($ids)){
            return array();
        }

        $_statusArr = array();
        $status = LogicRequestProcess::get_new_status_by_ids($ids);
        foreach($status as $statusArrKey => $statusArrVal){
            $_statusArr[] = $statusArrVal['status'];
        }
        $statusArr = array_unique($_statusArr);

        $names = LogicFormNode::get_names_by_ids($statusArr);
        $operater = LogicFormProcess::_get_next_nodes($statusArr);
        foreach($names as $namesKey => $namesVal){
            $nameArr[$namesVal['id']] = $namesVal['name'];
        }
        foreach($operater as $operaterKey => $operaterVal){
            $operaterArr[$operaterVal['node_id']] = $operaterVal['next_goal'];
        }

        foreach ($status as $statusKey => $statusVal){
            $datainfo[$statusVal['request_id']]['operater'] = !empty($operaterArr[$statusVal['status']]) ? $operaterArr[$statusVal['status']] : '';
            $datainfo[$statusVal['request_id']]['nodename'] = !empty($nameArr[$statusVal['status']]) ? $nameArr[$statusVal['status']] : '';
        }

        foreach ($data as $dataKey => $dataVal){
            $data[$dataKey]['operater'] = !empty($datainfo[$dataVal['id']]['operater']) ? $datainfo[$dataVal['id']]['operater'] : '';
            $data[$dataKey]['nodename'] = !empty($datainfo[$dataVal['id']]['nodename']) ? $datainfo[$dataVal['id']]['nodename'] : '';
        }
        return $data;
    }



    /*************************   华丽的分割线   *******************************/


    public static function find_init_node_id($fid,$request_id=''){
        $init_ids = LogicFormNode::get_init_node_by_fid($fid);
        $next_node = LogicFormProcess::get_next_nodes_by_ids_and_fid($init_ids,$fid);
        if (count($next_node) == 1){
            return $next_node[0];
        }
        $node_info = LogicNodeOperate::get_data_by_id($next_node);
        $result = '';
        foreach($node_info as $node_infoKey => $node_infoVal){
            switch ($node_infoVal['type']){
                case '1':
                    if ($node_infoVal['term'] == '0' && Yii::app()->user->dept == $node_infoVal['operater']){
                        $result = $node_infoVal['node_id'];
                    }
                    break;
                case '2':
                    if ($node_infoVal['term'] == '0' && Yii::app()->user->id == $node_infoVal['operater']){
                        $result = $node_infoVal['node_id'];
                    }
                    break;
                case '3':
                    $is_exite = LogicRoleInfo::check_user_is_exite($node_infoVal['operater']);
                    if ($node_infoVal['term'] == '0' && !empty($is_exite) ){
                        $result = $node_infoVal['node_id'];
                    }
                    break;
                case '4':
                    if (!empty($request_id)){
                        $uid = LogicFormRequest::get_uid_by_id($request_id);
                        $is_exite = LogicUser::check_user_is_exite($uid);
                        if ($node_infoVal['term'] == '0' && !empty($is_exite) ){
                            $result = $node_infoVal['node_id'];
                        }
                    }
                    break;
                case '0':
                default :
                    if (empty($result) && $node_infoVal['term'] == '0' && $node_infoVal['operater'] == '0'){
                        $result = $node_infoVal['node_id'];
                    }
                    break;
            }
        }
        return $result;
    }

    public static function find_handle_form(){
        if (empty(Yii::app()->user->id) || empty(Yii::app()->user->dept)){
            return array();
        }

        $request_ids =  LogicRequestProcess::find_examine_from();
        if (empty($request_ids)){
            return array();
        }

        foreach ($request_ids as  $request_idsKey => $request_idsVal){
            $request[$request_idsVal['status']][] = $request_idsVal['request_id'];
            $status_arr[] = $request_idsVal['status'];
        }
        $data = LogicFormProcess::get_next_nodes($status_arr);
        $_data = self::_init_array($data);

        $node_ids = LogicNodeOperate::find_handle_node(Yii::app()->user->id, Yii::app()->user->dept);
        $need_ids = array();
        foreach($_data as  $_dataKey => $_dataVal){
            $temp = array_intersect($_dataVal,$node_ids);
            if (!empty( $temp )){
                $need_ids[$_dataKey] = $_dataKey;
            }
        }
        return array_intersect_key($request,$need_ids);
    }

    private static function _init_array($arr){
        $result = array();
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal['init_id']][] = $arrVal['node_id'];
        }
        return $result;
    }


    public static function get_form_info_by_request_id($request_id,$nodeid = null){
        $fid = LogicFormRequest::get_form_id_by_id($request_id);
        $formInfo = LogicFormProcess::get_form_info_by_fid($fid);
        if (empty($formInfo)){
            return array();
        }
        $result = array();
        foreach($formInfo as $formInfoKey => $formInfoVal){
            $node_ids[] = $formInfoVal['id'];
            $result[$formInfoVal['init_id']][$formInfoVal['node_id']] = $formInfoVal;
        }
        $operateData = LogicNodeOperate::get_data_by_id($node_ids);
        $_operateData = MyTool::init_key_of_arrays($operateData,'node_id');
        $termData = LogicNodeTerm::get_node_term_by_fid_nodeidArr($fid,$node_ids);
        $_termData = MyTool::init_key_of_arrays($termData, 'node_id');
        foreach($result as $resultKey => $resultVal){
            foreach($resultVal as $resultValKey => $resultValVal){
                if (!empty($_operateData[$resultValVal['id']])){
                    $result[$resultKey]['operate'] = $_operateData[$resultValVal['id']];
                }
                if (!empty($_termData[$resultValVal['id']])){
                    $result[$resultKey]['term'] = $_termData[$resultValVal['id']];
                }
            }
        }

        if (!empty($nodeid)){
            $next_nodeid = LogicRequestProcess::get_next_status_by_status($request_id,$nodeid);
            if (!empty($next_nodeid)){
                $nodeInfo = LogicFormNode::get_next_form_node_by_fid_id($fid,$result[$nodeid][$next_nodeid]['node_id']);
                $result[$nodeid][$next_nodeid]['nodeinfo'] = $nodeInfo;
                if (!empty($result[$nodeInfo['id']])){
                    $result[$nodeid][$next_nodeid]['nextinfo'] = $result[$nodeInfo['id']];
                }
                return $result[$nodeid][$next_nodeid];
            }

        }

        return $result;
    }

    public static function get_leaderinfo_by_id($uid){
        if (empty($uid)){
            return '';
        }
        $leaderid = LogicUser::get_leader_by_userid($uid); 
        return LogicUser::get_info_by_userid($leaderid);
    }


    public static function find_need_show_form_info($page = 1,$page_size = 15){
        return LogicRequestProcess::find_need_show_form_info($page,$page_size);
    }

    public static function find_need_show_form_count(){
        return LogicRequestProcess::find_need_show_form_count();
    }


    public static function run_process($request_id,$status){
        $cur_id = LogicRequestProcess::get_status_by_next_id($request_id,$status);      //根据当前节点获取上一节点 ， 来判断下一个节点是多节点还是单节点
        $next_ids = LogicRequestProcess::get_next_ids_by_status($request_id,$cur_id);   //获取所有多节点ID
        $_next_ids = LogicRequestProcess::_get_next_ids_by_status($request_id,$cur_id); //已经完成的多节点
        $un_next_ids = array_unique(array_filter(array_diff($next_ids,$_next_ids)));                               //去除已完成的节点        
        $nodecount =  count($un_next_ids);
        $nodeArr = $ids = array();

        if ($nodecount > 1){
            $diff_ids = array_diff($next_ids,array($status));
            $next_ids = LogicFormProcess::_get_next_nodes($diff_ids);
            foreach($next_ids as $arrKey => $arrVal){
                $nodeArr[$status][$arrVal['id']] = $arrVal['node_id'];
                $ids[] = $arrVal['id'];
            }
        }else{
            $next_ids = LogicFormProcess::get_next_nodes($status);
            if (empty($next_ids)){
                return $status;
            }
            foreach($next_ids as $arrKey => $arrVal){
                $nodeArr[$arrVal['init_id']][$arrVal['id']] = $arrVal['node_id'];
                $ids[] = $arrVal['id'];
            }
        } 
        $termArr = MyTool::init_key_of_arrays(LogicNodeTerm::get_node_term_by_nodeidArr($ids), 'node_id');
        $result = array();        
        foreach ($nodeArr[$status] as $nodeArrKey => $nodeArrVal){
            if (!empty($termArr[$nodeArrKey])){
                $items = array();
                foreach ($termArr[$nodeArrKey] as $termArrVal){                 
                    if ($termArrVal['term_type'] == '103'){
                        $items = $termArrVal['item_id'];                        
                        $fieldName = LogicFormItem::get_db_field_name_by_id($items);                        
                        $result[$nodeArrVal][$nodeArrKey][$fieldName][] = $termArrVal;
                    }else{
                        $result[$nodeArrVal][$nodeArrKey][$nodeArrKey] = $termArr[$nodeArrKey];
                    }
                }
            }else{
                $result[$nodeArrVal][$nodeArrKey] = $nodeArrVal;
            }
        }            
        return $result;

    }

    public static function check_operation($status,$request_id){            
        $bool  = false;   //是否有权限操作当前节点
        if (!empty($status) && !empty($request_id)){
            $nodeinfo = LogicNodeOperate::get_data_by_id($status);            
            $bool = self::check_operation_term($nodeinfo,$request_id);
        }
        return $bool;
    }

    public static function check_operation_term($nodeinfo,$request_id = ''){
        $bool = false;
        if (!empty($nodeinfo)){
            foreach($nodeinfo as $nodeinfoKey => $nodeinfoVal){
                switch ($nodeinfoVal['type']){
                    case '0':
                        if (empty($result) && $nodeinfoVal['term'] == '0' && $nodeinfoVal['operater'] == '0'){
                            $bool = true;
                        }
                        break;
                    case '1':
                        if ($nodeinfoVal['term'] == '0' && Yii::app()->user->dept == $nodeinfoVal['operater']){
                            $bool = true;
                        }
                        break;
                    case '2':
                        if ($nodeinfoVal['term'] == '0' && Yii::app()->user->id == $nodeinfoVal['operater']){
                            $bool = true;
                        }
                        break;
                    case '3':
                        $is_exite = LogicRoleInfo::check_user_is_exite($nodeinfoVal['operater']);                
                        if ($nodeinfoVal['term'] == '0' && !empty($is_exite) ){
                            $bool = true;
                        }
                        break;
                    case '4':
                        $uid = LogicFormRequest::get_uid_by_id($request_id);
                        $is_exite = LogicUser::check_user_is_exite($uid);
                        if ($nodeinfoVal['term'] == '0' && !empty($is_exite) ){
                            $bool = true;
                        }
                        break;
                    default :
                        break;
                }
            }
        }
        
        return $bool;

    }

    public static function check_next_node($request_id,$status){
        $cur_id = LogicRequestProcess::get_status_by_next_id($request_id,$status);
        $next_ids = LogicRequestProcess::get_next_ids_by_status($request_id,$cur_id);
        $result = array();
        foreach($next_ids as $next_idsKey => $next_idsVal){
            if ($next_idsVal != $status){
                $result[] = $next_idsVal;
            }
        }
        return $result;
    }

    public static function close_user($uid){
        if (empty($uid)){
            return array();
        }
        $result = array();
        $r_mail = API_OA::close_mail($uid);
        if ($r_mail == 'ok'){
            $result['mail'] = 'ok';
        }else{
            $result['mail'] = 'error';
        }
        $result['user'] = 'ok';
        return $result;
    }


}
