<?php
/**
 * 表单
 * @author JohnnyLin
 *
 */
class FormnodeController extends WebController {

    
    public function actionBase(){
        $this->render('setbase');
    }

    public function actionDefault(){
        $this->render('default');
    }

    /**
     * 表单节点列表
     */
    public function actionIndex($id) {
        $FormNode = FormNode::model()->findAll('fid=:fid',array('fid'=>$id));    
        $this->render('node_list',array('list'=>$FormNode, 'id' => $id));
    }

    public function actionFieldEdit($id) {
        $NodeData = FormNode::instance()->findByPk($id);
        $showFieldArr = explode(',', $NodeData->show);
        $editFieldArr = explode(',', $NodeData->edit);
        $notnullFieldArr = explode(',', $NodeData->notnull);
        $FieldData = WorkFormItem::instance()->findAll('fid=:fid and type=0 and field_attr not in (101,102)',array('fid'=>$NodeData->fid));

        $params = $this->params();
        if (isset($params['showfields']) || isset($params['editfields']) || isset($params['notnullfields']) ){
            $NodeData->show = $params['showfields'];
            $NodeData->edit = $params['editfields'];
            $NodeData->notnull = $params['notnullfields'];
            $NodeData->save();
            $this->redirect($this->createUrl('/settings/formnode/index/'.$NodeData->fid));
        }

        $this->render('node_field', array('list' => $FieldData,'FieldArr'=>$showFieldArr,'editArr'=>$editFieldArr,'notnullArr'=>$notnullFieldArr,'fid'=>$NodeData->fid));
    }

    public function actionOperate($id) {
        $deptArr = API_OA::get_all_dept();
        $NodeData = FormNode::instance()->findByPk($id);
        $nodeoperateData = LogicNodeOperate::get_data_by_id($id);
        $this->render('node_operate', array('operater' => $NodeData->name,'fid'=>$NodeData->fid,'deptArr'=>$deptArr,
            'id'=>$id,'oldoperate'=>$nodeoperateData,'operateType'=>$this->operate_type,'operateZhType'=>$this->operateZh_type));
    }

    public function actionNodeSetup($id){
        $formnode = LogicFormNode::get_form_node_by_fid($id);
        $this->render('node_setup',array('fid'=>$id,'dataArr'=>$formnode));
    }


    public function actionAjax(){
        $params = $this->params();
        $res = $this->_res;
        switch($params['type']) {
            case 'getdeptinfo':
                if (!empty($params['deptid'])){
                    $result = API_OA::get_employees_by_dept($params['deptid']);                                        
                    $html = '';
                    foreach($result as $resultKey => $resultVal){
                        $html .= '<li><span style="cursor:pointer" id="e_'.$resultKey.'" class="fl" ondblclick="javascript:addemployee(this)" data-id="' .$resultKey  . '">'.$resultVal.'</span></li>';
                    }
                    $res = $this->init_res($html);
                }
                break;
            case 'adddata':
                //删除原来数据
                $WhereArr = array('node_id'=>$params['nodeid']);
                LogicNodeOperate::delete_node_operate_by_id($WhereArr);
                if (!empty($params['data']) && !empty($params['nodeid']) ){
                    //添加新数据 data 0-是否包含（0 包含 1不包含 ） 1- 添加ID 2-添加类型 3-添加操作者的中文名
                    $data = MyTool::array_unique_fb($params['data']);
                    foreach($data as $dataKey => $dataVal){
                        $nodeoperate = new NodeOperate();
                        $nodeoperate->node_id = $params['nodeid'];
                        $nodeoperate->term = $dataVal[0];
                        $nodeoperate->operater = $dataVal[1];
                        $nodeoperate->type = $this->init_type($dataVal[2]);
                        $nodeoperate->operater_zh = $dataVal[3];
                        $nodeoperate->save();
                        if ($dataVal[1] == '0'){ break ;}
                    }
                }
                $res = $this->init_res();
                break;
            case 'addNodeData':
                if (!empty($params['data'])  && !empty($params['fid'])){
                    foreach($params['data'] as $dataKey => $dataVal){
                        if (!empty($dataVal[0]) && trim($dataVal[1]) != '' ){
                            $DataArr = array('fid'=>$params['fid'],'name'=>$dataVal[0],'type'=>$dataVal[1]);
                            LogicFormNode::insert_form_node($DataArr);
                        }
                    }
                }
                $res = $this->init_res();
                break;
            case 'modifyNodeData':
                if (!empty($params['data'])  && !empty($params['fid'])){
                    foreach($params['data'] as $dataKey => $dataVal){
                        if (  !empty($dataVal[0]) && !empty($dataVal[1]) && trim($dataVal[2]) != ''  ){
                            $WhereArr = array('fid'=>$params['fid'],'id'=>$dataVal[0]);
                            $DataArr = array('name'=>$dataVal[1],'type'=>$dataVal[2]);
                            LogicFormNode::modify_form_node_by_id_fid($DataArr,$WhereArr);
                        }
                    }
                }
                $res = $this->init_res();
                break;
            case 'deleteNodeData':
                if (!empty($params['data'])  && !empty($params['fid'])){
                    $WhereArr = array('id'=>$params['data'],'fid'=>$params['fid']);
                    $result = LogicFormNode::delete_form_node_by_id_fid($WhereArr);
                }
                $res = $this->init_res($result);
                break;
            default :
                $res = $this->_res;
                break;
        }
        echo json_encode($res);
        exit;
    }

    private function init_type($type){
        switch ($type){
            case 'tdept':
                $result = 1;
                break;
            case 'tperson':
                $result = 2;
                break;
            case 'trole':
                $result = 3;
                break;
            case 'tlender':
                $result = 4;
                break;
            case 'tall':
            default :
                $result = 0;
                break;
        }
        return $result;
    }

    private $operate_type = array('0'=>'tall',
        '1'=>'tdept',
        '2'=>'tperson',
        '3'=>'trole',
        '4'=>'tlender');

    private $operateZh_type = array('0'=>'所有人',
        '1'=>'部门',
        '2'=>'人力资源',
        '3'=>'角色',
        '4'=>'上级');

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