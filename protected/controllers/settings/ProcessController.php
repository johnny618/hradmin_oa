<?php
/**
 * 出口控制器
 * @author JohnnyLin
 *
 */
class ProcessController extends WebController {    
    
    /**
     * 出口列表
     * $id 为表单ID
     */
    public function actionIndex($id) {       
        $deptArr = API_OA::get_all_dept();  //部门接口        
        $FormNode = Bll_Form::get_form_node_by_fid($id);
        $AllFormNode = $this->init_node_arr($FormNode);        
        $FormProcess = FormProcess::model()->findAll('fid=:fid',array('fid'=>$id));              
        $this->render('process_list',array('Nodelist'=>$FormNode,'AllNodelist'=>$AllFormNode,'ProcessList'=>$FormProcess,'fid'=>$id,'deptArr'=>$deptArr));
    }
     
    private function init_node_arr($arr){
        if (empty($arr)){
            return array();
        }
        $result['0'] = '请选择目标节点';
        foreach($arr as $arrKey => $arrVal){
            $result[$arrVal['id']] = $arrVal['name'];
        }                
        return $result;
    }
    
    public function actionAjax(){
        $params = $this->params(); 
        $res = $this->_res;     
        
        switch($params['type']) {
            case 'addProcessData':               
                if (!empty($params['fid'])){        
                     //data 0-是否退回 1-开始节点ID 2- 出口名称 3-目标节点ID 
                    foreach($params['data'] as $dataKey => $dataVal){
                        if (!empty($dataVal[0]) && !empty($dataVal[1]) && !empty($dataVal[2])  && !empty($dataVal[3]) ){
                            $formprocess = new FormProcess();
                            $formprocess->fid = $params['fid'];                             
                            $formprocess->isback = ($dataVal[0] == 'true') ? 1 : 0 ;  
                            $formprocess->init_id = $dataVal[1];
                            $formprocess->next_goal = $dataVal[2];                            
                            $formprocess->node_id = $dataVal[3];
                            $formprocess->save();
                        }
                    }
                }
                $res = $this->init_res();
                break;
            case 'modifyProcessData':
                if (!empty($params['data'])){
                    //data 0-是否退回 1-开始节点ID 2- 出口名称 3-目标节点ID  4-流程ID  
                    foreach($params['data'] as $dataKey => $dataVal){    
                        if (!empty($dataVal[0]) && !empty($dataVal[1]) && !empty($dataVal[2])  && !empty($dataVal[3]) && !empty($dataVal[4]) ){
                            $isback = ($dataVal[0] == 'true') ? 1 : 0;                               
                            $DataArr = array('isback'=>$isback,
                                'init_id'=>$dataVal[1],
                                'next_goal'=>$dataVal[2],
                                'node_id'=>$dataVal[3]);
                            $WhereArr = array('id'=>$dataVal[4]);
                            LogicFormProcess::modify_form_process_by_id($DataArr,$WhereArr);    
                        }else{
                            Bll_Form::delete_process_and_nodeterm($dataVal[4],$params['fid']);
                        }
                    }
                    $res = $this->init_res();
                }
                break;
            case 'getItemData':
                if (!empty($params['fid'])){
                    $html = '<table width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                            	<th width="6%"></th>
                            	<th width="12%"><h4 class="etne_h4">字段</h4></th>                                
                                <th width="16%"><h4>条件</h4></th>
                                <th width="50%"><h4></h4></th>
                            </tr>';
                    $result = Bll_Form::get_form_item_data_by_formid($params['fid']);                          
                    if (!empty($result)){
                        foreach($result as $resultKey => $resultVal){
                            $html .= '<tr><td><input b="'.$resultVal['id'].'" ';
                            if (in_array($resultVal['field_attr'], array_keys(MyConst::$formItemTerm))){
                                $html .= 't="'.$resultVal['field_attr'].'" ';
                            }else if($resultVal['field_type'] == '4'){
                                $html .= 't="'.$resultVal['field_type'].'" ';
                            }                                    
                            $html .= 'id="chk_'.$resultVal['id'].'" class="etne_check" type="checkbox" name="cdn_check" /></td>';
                            $html .= '<td>'.$resultVal['field_name'].'</td>';
                            if (in_array($resultVal['field_attr'], array_keys(MyConst::$formItemTerm))){
                                $html .= $this->returnTermHtml($resultVal['field_attr'],$resultVal['id']);    
                            }else if($resultVal['field_type'] == '4'){
                                $html .= $this->returnTermHtmlByFieldType($resultVal['field_type'],$resultVal['id'],$resultVal['field_body']);    
                            }                                                    
                            $html .= '</tr>';
                        }                        
                    }   
                    $html .= '</table> ';
                    $res = $this->init_res($html);
                }
                break;
            case 'addnodeterm':                     
                //删除node_term表中原来条件设置
                $WhereArr = array('fid'=>$params['fid'],
                    'node_id'=>$params['nodeid'],
                    'item_id'=>$params['itemid'],
                    'term_type'=>$params['itemtype']);
                Bll_Form::delete_node_term_old($WhereArr);                
                $result = '';
                //'101'=>'申请人','102'=>'部门', '103'=>'数字' '104'=>'角色'
                if ($params['itemtype'] == '103'){
                    if (!empty($params['ltext'])) {
                        $DataArrL = array('fid'=>$params['fid'],
                            'node_id'=>$params['nodeid'],
                            'item_id'=>$params['itemid'],
                            'term'=>$params['lselect'],
                            'term_content'=>$params['ltext'],
                            'term_type'=>$params['itemtype']
                        );
                        $result = LogicNodeTerm::insert_node_term($DataArrL);
                    }
                    if (!empty($params['rtext'])) {
                        $DataArrR = array('fid'=>$params['fid'],
                            'node_id'=>$params['nodeid'],
                            'item_id'=>$params['itemid'],
                            'term'=>$params['rselect'],
                            'term_content'=>$params['rtext'],
                            'term_type'=>$params['itemtype']
                        );
                        $result = LogicNodeTerm::insert_node_term($DataArrR);
                    }
                }else if ($params['itemtype'] == '4'){
                    if (!empty($params['termcontent'])){
                        //添加node_term表 新条件设置                    
                        $DataArr = array('fid'=>$params['fid'],
                            'node_id'=>$params['nodeid'],
                            'item_id'=>$params['itemid'],
                            'term'=>$params['term'],
                            'term_content'=>$params['termcontent'],
                            'term_type'=>$params['itemtype']
                        );                
                        $result = LogicNodeTerm::insert_node_term($DataArr);
                    }         
                }else{                         
                    if (!empty($params['termcontent'])){
                        //添加node_term表 新条件设置                    
                        $DataArr = array('fid'=>$params['fid'],
                            'node_id'=>$params['nodeid'],
                            'item_id'=>$params['itemid'],
                            'term'=>$params['term'],
                            'term_content'=>implode(',', array_unique($params['termcontent'])),
                            'term_type'=>$params['itemtype']
                        );                          
                        $result = LogicNodeTerm::insert_node_term($DataArr);
                    }                    
                }
                $this->init_res($result);
                break;
            case 'saveprocessone':   //点击添加节点时触发 添加一条数据
                if (!empty($params['fid']) && !empty($params['initid'])){
                    $DataArr = array('fid'=>$params['fid'],'init_id'=>$params['initid']);                    
                    LogicFormProcess::insert_form_process($DataArr);
                    $result = LogicFormProcess::get_new_id_for_form_process();
                    $res = $this->init_res($result);
                }                    
                break;
            case 'getTermData':
                if (!empty($params['nodeid']) && !empty($params['fid'])){
                    //获取条件
                    $dataTerm = Bll_Form::get_node_term_by_fid_nodeid($params['fid'],$params['nodeid']);                        
                    $html = '';
                    if(!empty($dataTerm)){
                        $html = '<span>(条件：';                        
                        foreach($dataTerm as $dataTermKey => $dataTermVal){                            
                            if ($dataTermVal['term_type'] == '101'){
                                $html .= ' '.$dataTermVal['field_name'].MyConst::$_TermType[$dataTermVal['term_type']][$dataTermVal['term']];
                                $userid = explode(',', $dataTermVal['term_content']);
                                foreach($userid as $useridVal){
                                    $api_info = API_OA::get_OA_info_by_id($useridVal);
                                    $userArr[] = $api_info['displayName'];                                    
                                }
                                $html .= implode(',', $userArr);
                            }else if ($dataTermVal['term_type'] == '102'){
                                $deptAll = API_OA::get_all_dept();                                
                                $html .= ' &nbsp;&nbsp;&nbsp;'.$dataTermVal['field_name'].MyConst::$_TermType[$dataTermVal['term_type']][$dataTermVal['term']];
                                $deptid = explode(',', $dataTermVal['term_content']);
                                foreach($deptid as $deptidVal){
                                    $deptArr[] = $deptAll[$deptidVal];
                                }
                                $html .= implode(',', $deptArr);
                            }else if ($dataTermVal['term_type'] == '104'){                                                              
                                $html .= ' &nbsp;&nbsp;&nbsp;'.$dataTermVal['field_name'].MyConst::$_TermType[$dataTermVal['term_type']][$dataTermVal['term']]; 
                                $roleid = explode(',', $dataTermVal['term_content']);
                                foreach($roleid as $roleidVal){
                                    $api_info = LogicRole::get_rolename_by_id($roleidVal);
                                    $roleArr[] = $api_info;                                    
                                }
                                $html .= implode(',', $roleArr);
                                //$html .= LogicRole::get_rolename_by_id($dataTermVal['term_content']);
                            }else if ($dataTermVal['term_type'] == '4'){
                                $html .= ' &nbsp;&nbsp;&nbsp;'.$dataTermVal['field_name'].':&nbsp;'.MyConst::$_TermType[$dataTermVal['term_type']][$dataTermVal['term']];   
                                $html .= $dataTermVal['term_content'];
                            }else{
                                $html .= ' '.$dataTermVal['field_name'].MyConst::$_TermType[$dataTermVal['term_type']][$dataTermVal['term']].$dataTermVal['term_content'];                           
                            }                                
                        }
                        $html .= '&nbsp;)</span>';
                    }                    
                    $res = $this->init_res($html);
                }
                break;
            case 'delete':                
                if (!empty($params['id']) && !empty($params['fid'])){
                    Bll_Form::delete_process_and_nodeterm($params['id'],$params['fid']);                    
                    $res = $this->init_res();
                }
                break;
            default :
                $res = $this->_res;
                break;
        }
        echo json_encode($res);
        exit;        
    }
    
    private function returnTermHtmlByFieldType($field_attr,$id,$field_body){
        $html = '';
        if ($field_attr == '4'){
            $html .= '<td>
                            <div class="etne_select">
                                <select class="fl" name="size">
                                    <option value="=">等于</option>
                                    <option value="!=">不等于</option>
                                </select>                                
                            </div>
                        </td>                                                     
                        <td>
                            <select style="width:400px;"  name="size">
                                <option value=""></option>';
            $_field_body = json_decode($field_body);            
            foreach ($_field_body as $_field_bodyKey => $_field_bodyVal){
                $html .= ' <option value="'.$_field_bodyKey.'">'.$_field_bodyVal.'</option>';
            }
            $html .='</select> </td>';
        }
        return $html ;
    }
    
    private function returnTermHtml($field_attr,$id){
        $html = '';
        if ($field_attr == '103'){
            $html .= '<td>
                            <div class="etne_select">
                                <select class="fl" name="size">
                                    <option value=">">大于</option>
                                    <option value=">=">大于或等于</option>
                                    <option value="<">小于</option>
                                    <option value="<=">小于或等于</option>
                                    <option value="=">等于</option>
                                    <option value="!=">不等于</option>
                                </select>
                                <input id="ltext_'.$id.'" onblur="javascript:chk_text(\''.$id.'\',\'l\');" onkeyup="javascript:chk_text(\''.$id.'\',\'l\');" 
                                    class="etne_names fl" type="text" name="etne_text" />
                            </div>
                        </td>                                                     
                        <td>
                            <select class="fl"  name="size">
                                <option value=">">大于</option>
                                <option value=">=">大于或等于</option>
                                <option value="<">小于</option>
                                <option value="<=">小于或等于</option>
                                <option value="=">等于</option>
                                <option value="!=">不等于</option>
                            </select>
                                <input id="rtext_'.$id.'" onblur="javascript:chk_text(\''.$id.'\',\'r\');" onkeyup="javascript:chk_text(\''.$id.'\',\'l\');" 
                                    class="etne_names fl" type="text" name="etne_text" />
                        </td>';
        }else{
            $html .= ' <td>
                            <div class="etne_select">
                                <select name="conditions">
                                    <option value="=">属于</option>
                                    <option value="!=">不属于</option>
                                </select>
                            </div>
                        </td>
                        <td>';
            if ($field_attr == '102'){
                $html .= '<a onclick="javascript:showDeptDiv(\''.$id.'\');" class="people_open"></a> <span class="fl" id="selectStr'.$id.'"></span>';
            }else if($field_attr == '101'){
                $html .= '<div style="float:left;"><a onclick="javascript:showPersonDiv(\''.$id.'\');" class="people_open"></a> <span class="fl" id="selectStr'.$id.'"></span></div><div class="clearfix"></div>';
                $html .= '<div style="float:left;"><a onclick="javascript:showRoleDiv(\''.$id.'\');" class="people_open"></a> <span class="fl" id="roleStr'.$id.'"></span><label href="#" onclick="javascript:clsspan(\'roleStr'.$id.'\');" style="cursor:pointer;" >清除</label></div>';
            }
                
//            else if($field_attr == '104')
//                $html .= '<a onclick="javascript:showRoleDiv(\''.$id.'\');" class="people_open"></a> <span class="fl" id="selectStr'.$id.'"></span>';
            $html .=  '</td>';                                       
        }
        return $html;
    }
    
    private $_res = array(
        "code" => "error",
        "mes" => "操作失败！",
        "info" => array(),
    );
    
    private function init_res($result = null){
        $_res = array(
            "code" => "success",
            "mes" => "成功！",
            "info" => $result,
        );
        return $_res;
    }
    
}