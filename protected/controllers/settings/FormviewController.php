<?php
/**
 * 出口控制器
 * @author JohnnyLin
 *
 */
class FormviewController extends WebController {

    /**
     * 图形界面列表
     * $params['fid'] 为表单ID
     * $params['stauts'] 当前的节点
     *
     */
    public function actionIndex() {
        $params = $this->params();
        if (empty($params['fid'])){
            throw new CHttpException(404, '页面不存在');
        }

        $data = LogicFormProcess::get_form_info_by_fid($params['fid']);
        if (empty($data)){
            exit;
        }
       
        foreach ($data as $dataKey => $dataVal){
            $nodeids[] = $dataVal['init_id'];
            $nodeids[] = $dataVal['node_id'];
            
            $dataArr[$dataKey]['parent'] = $dataVal['init_id'];
            $dataArr[$dataKey]['child'] = $dataVal['node_id'];
            
            $_dataArr[$dataVal['id']]['parent'] = $dataVal['init_id'];
            $_dataArr[$dataVal['id']]['child'] = $dataVal['node_id'];
            
            $ids[] = $dataVal['id']; //根据此ID关联条件表NODE_ID
        }

        $unique_ids = array_unique($nodeids);     
        $node_operate = MyTool::init_key_of_arrays(LogicNodeOperate::get_data_by_id($unique_ids),'node_id');  //根据节点ID获取操作人
        if (!empty($params['requestid'])){            
            $node_term = MyTool::init_key_of_arrays(LogicNodeTerm::get_node_term_by_nodeidArr($ids), 'node_id'); 
            $Request = WorkFormRequest::instance()->findByPk($params['requestid']);            
            if (!empty($node_term) && !empty($_dataArr)){
                $data_term = $this->init_arr_term($_dataArr,$node_term);  
                $dataArr = $this->filter_term_node($Request,$data_term);                          
            }
            $operateArr = $this->init_arr_operate($node_operate,$Request);
                           
        }      
        $_nodeids = LogicFormNode::get_names_by_ids($unique_ids);
        $viewname = LogicWorkForm::get_data_by_id($params['fid']);
        $nodedata = $this->_init_arr($_nodeids,$viewname);
        //new Tree(根目录的名字);
        //根目录的ID自动分配为0        
        array_unshift($dataArr,array('parent'=>0,'child'=>$dataArr[0]['parent']));
        $dataArr = $this->init_arr_child_sub($dataArr);                
        $Tree = new Tree($nodedata[$dataArr[0]['parent']] );
        foreach($dataArr as $dataArrKey => $dataArrVal){
            //setNode(目录ID,上级ID，目录名字);
            $Tree->setNode($dataArrVal['child'], $dataArrVal['parent'], $nodedata[$dataArrVal['child']] );
        }
        //getChilds(指定目录ID);
        //取得指定目录下级目录.如果没有指定目录就由根目录开始
        $category = $Tree->getChilds();       
        //遍历输出        
        $html = '';           
        $oldid = '';
        $spacenum = 0;
        $red = false;
        foreach ($category as $key=>$id){
            if ($oldid != $id){
                if (!empty($operateArr)){
                    ++$spacenum;

                    if ($red){
                        if (!empty($id) && !empty($operateArr[$id])){
                            //$Request->uname 申请人名称
                            if ($spacenum === 1){
                                $html .= "<span style='color:red'>".str_repeat("|-",$spacenum).$Tree->getValue($id)."</span>&nbsp;&nbsp;[&nbsp;".  $Request->uname."&nbsp;]<br />\n";
                            }else{
                                $html .= "<span style='color:red'>".str_repeat("|-",$spacenum).$Tree->getValue($id)."</span>&nbsp;&nbsp;[&nbsp;".  implode(',', $operateArr[$id])."&nbsp;]<br />\n";
                            }
                        }else{
                            $html .= "<span style='color:red'>".str_repeat("|-",$spacenum).$Tree->getValue($id)."</span><br />\n";
                        }
                        $red = false;
                    }else{
                        if (!empty($id)  && !empty($operateArr[$id])){
                            if ($spacenum === 1){
                                $html .= str_repeat("|-",$spacenum).$Tree->getValue($id)."</span>&nbsp;&nbsp;[&nbsp;".  $Request->uname."&nbsp;]<br />\n";
                            }else{
                                $html .= str_repeat("|-",$spacenum).$Tree->getValue($id)."&nbsp;&nbsp;[&nbsp;".  implode(',', $operateArr[$id])."&nbsp;]<br />\n";
                            }
                        }else{
                            $html .= str_repeat("|-",$spacenum).$Tree->getValue($id)."<br />\n";
                        }
                    }


                    if (!empty($params['status']) && $params['status'] == $id ){
                        $red = true;
                    }
                    
                }else{                
                    $html .= $Tree->getLayer($id , '|-').$Tree->getValue($id)."<br />\n";     
                }
            }            
            $oldid = $id;
        }

        if (isset($params['viewtype'])) {
            header("Content-type: text/html; charset=utf-8");
            echo $html;exit;
        }

        $this->render('showview',array('id'=>$params['fid'],'html'=>$html));  //原来的视图文件
        exit;
    }

    private function _init_arr($arr,$viewname = ''){
        if (empty($arr)){
            return array();
        }
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal['id']] = $arrVal['name'];
        }
        if (!empty($viewname)){
            $result[0] = $viewname;
            return $result;
        }
        $result[0] = 'start';
        return $result;
    }

    private function init_arr_child_sub($dataArr){                
        if (empty($dataArr)){
            return array();
        }
        $nextVal = 0;
        $result = array();
        foreach($dataArr as $dataArrKey => $dataArrVal){            
            foreach($dataArr as $dataArrKey => $dataArrVal){       
                if ($nextVal == $dataArrVal['parent']){
                    $result[] =  $dataArrVal;
                    $nextVal = $dataArrVal['child'];
                }
            }
        } 
        return $result;
    }
    
    private function init_arr_term($data,$term){        
        foreach($data as $dataKey => $dataVal){
            if (!empty($term[$dataKey])){
                $data[$dataKey]['term'] = $term[$dataKey];
            }
        }
        return $data;
    }
    
    /**
     * 拼接操作人条件
     * @param type $arr
     * @param type $Request
     * @return type
     */
    public static function init_arr_operate($arr,$Request){
        if (empty($arr)){
            return array();
        }        
        $leaderInfo = Bll_Form::get_leaderinfo_by_id($Request->uid);              
        $roleids = array();        
        //获取所有角色ID
        foreach ($arr as $arrKey => $arrVal){
            foreach ($arrVal as $arrValVal){
                if ($arrValVal['type'] == '3'){
                    $roleids[] = $arrValVal['operater'];
                }
            }
        }
        
        //根据角色获取角色人员
        if (!empty($roleids)){
            $dataRole = LogicRoleInfo::get_uids_by_roleids($roleids);            
            foreach($dataRole as $dataRoleVal){
                $RoleArr[$dataRoleVal['roleid']][] = $dataRoleVal['userid'];
                $uids[] = $dataRoleVal['userid'];
            }            
            $userinfo = MyTool::_init_key_of_array(LogicUser::get_info_by_userids($uids), 'uid','uname');                        
            foreach ($RoleArr as $RoleArrKey => $RoleArrVal){
                foreach ($RoleArrVal as $RoleArrValKey => $RoleArrValVal){
                    $RoleArr[$RoleArrKey][$RoleArrValKey] = $userinfo[$RoleArrValVal];
                }
            }            
        }

        //拼接操作人数据
        foreach ($arr as $arrKey => $arrVal){
            foreach ($arrVal as $arrValVal){
                switch ($arrValVal['type']) {
                    case '0'://所有人
                    case '1'://部门
                    case '2'://个人
                        $result[$arrKey][] = $arrValVal['operater_zh'];
                        break;
                    case '3': //角色
                        $result[$arrKey][] = implode(',', $RoleArr[$arrValVal['operater']]);
                        break;
                    case '4': //上级
                        $result[$arrKey][] = !empty($leaderInfo['uname']) ? $leaderInfo['uname'] : '';
                        break;
                    default:
                        break;
                }                
            }
        }        
        return $result;
    }

    public static function filter_term_node($Request,$data_term){
        $result = $nodeids = $has_operation_next_ids = array();
        $i = 0;    
        foreach ($data_term as $data_termKey => $DataArr) {
            if (empty($result)){
                $i = 0;   
            }            
            if (empty($DataArr['term'])){
                $result[$i]['parent'] = $DataArr['parent'];
                $result[$i]['child'] = $DataArr['child'];    
            }else{
                foreach($DataArr['term'] as $DataArrValVal){                        
                    if (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 101) {
                        if ($DataArrValVal['term'] == '=' && in_array($Request->uid, explode(', ', $DataArrValVal['term_content']))) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } elseif ($DataArrValVal['term'] == '!=' && !in_array($Request->uid, explode(', ', $DataArrValVal['term_content']))) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } else{
                            unset($result[$i]);break;
                        }
                    } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 102) {
                        if ($DataArrValVal['term'] == '=' && in_array($Request->dept, explode(',', $DataArrValVal['term_content']))) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } elseif ($DataArrValVal['term'] == '!=' && !in_array($Request->dept, explode(',', $DataArrValVal['term_content']))) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } else{
                            unset($result[$i]);break;
                        }
                    } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 104) {
                        $r = Yii::app()->db->createCommand('select count(id) as c from role_info where roleid in (' . $DataArrValVal['term_content'] . ') and userid=' . $Request->uid)->queryRow();                        
                        if ($DataArrValVal['term'] == '=' && $r['c'] > 0) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } else if ($DataArrValVal['term'] == '!=' && $r['c'] == 0) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } else{
                            unset($result[$i]);break;
                        }
                    } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 103) { 
                        $body = $Request->body;
                        $body_field = WorkFormItem::model()->findByPk($DataArrValVal['item_id']);
                        if (!$body_field) {
                            self::exitWithCodeAndMsg(1, '条件字段不存在');
                        }          
                        if (Validate::compare($body[$body_field->db_field_name], $DataArrValVal['term_content'], $DataArrValVal['term'])) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];                            
                        } else{
                            unset($result[$i]);break;
                        }
                    } elseif (isset($DataArrValVal['term_type']) && $DataArrValVal['term_type'] == 4) {                                        
                        $body = $Request->body;                                                
                        $body_field = WorkFormItem::model()->findByPk($DataArrValVal['item_id']);
                        if ($DataArrValVal['term'] == '=' && $body[$body_field->db_field_name] == $DataArrValVal['term_content']) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } elseif ($DataArrValVal['term'] == '!=' && $body[$body_field->db_field_name] != $DataArrValVal['term_content']) {
                            $result[$i]['parent'] = $DataArr['parent'];
                            $result[$i]['child'] = $DataArr['child'];
                        } else{
                            unset($result[$i]);break;
                        }
                    }
                }
            }

            $i++;
        }
        return $result;
    }
}