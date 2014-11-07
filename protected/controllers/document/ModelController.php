<?php
/**
 * 文档权限管理
 * @author JohNnY 
 * 
 */
class ModelController extends WebController {
    public function beforeAction($action) {        
        if (!Bll_Author::check_ybr_document_author()) {            
            throw new CHttpException('500','无权限访问');
        }
        return true;
    }
    
    public function actionIndex(){  
        $this->render('list');
    }
    
    public function actionEdit(){        
        $params = $this->params();        
        if (empty($params['tid'])){
            throw new CHttpException('500','无访问参数');
        }
        $deptArr = API_OA::get_all_dept();  //部门接口   
        $data = LogicDocAuthority::get_user_info_by_tid($params['tid']);              
        $this->render('edit',array('deptArr'=>$deptArr,'tid'=>$params['tid'],'data'=>$data));
    }

    public function actionAjax(){
        $params = $this->params();          
        $res = $this->_res;             
        switch($params['type']) {           
            case 'add_data':
                if (!empty($params['tid']) ){
                    //根据模块ID删除原来的数据
                    $WhereArr = array('tid'=>$params['tid']);
                    LogicDocAuthority::delete_data_info($WhereArr);
                    //添加新数据
                    if (!empty($params['ids'])){
                        foreach($params['ids'] as $Val){
                            $DataArr = array(
                                'tid'=>$params['tid'],
                                'uid'=>$Val['0'],
                                'uname'=>$Val[1],
                                'creater'=>  Yii::app()->user->id,
                                'created'=>time(),
                            );
                            LogicDocAuthority::insert_data_row($DataArr);
                        }
                    }                    
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