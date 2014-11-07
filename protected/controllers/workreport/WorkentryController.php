<?php
/**
 * 每日工作小结
 * @author JohNnY 
 * 
 */
class WorkentryController extends WebController {

    public function actionIndex(){
        $params = $this->params();   
        $error = '';    
        if(!empty($params['workdate']) && !empty($params['tip'])){
            
            $check_count = LogicWorkReport::check_data_by_date(strtotime($params['workdate']));
            if (empty($check_count)){
                $late = 0;
                $r_hours = floor((time()-strtotime($params['workdate'])) /3600);   
                if (in_array(date('w',time()),array(2,3,4,5) )){
                    if ($r_hours >= 33 ){
                        $late = 1;
                    }
                }else if (date('w',time()) == 1){
                    if ($r_hours >= 81 ){
                        $late = 1;
                    }
                }
                
                if (!empty($late)){
                    $DataArr = array('uid'=> Yii::app()->user->id,
                        'uname'=>Yii::app()->user->name,
                        'report'=>htmlspecialchars(MyTool::html_to_code($params['tip'])),
                        'reportTime'=>strtotime($params['workdate']),
                        'late'=>1,
                        'created'=>time()
                    );
                }else{
                    $DataArr = array('uid'=> Yii::app()->user->id,
                        'uname'=>Yii::app()->user->name,
                        'report'=>htmlspecialchars(MyTool::html_to_code($params['tip'])),
                        'reportTime'=>strtotime($params['workdate']),                    
                        'created'=>time()
                    );
                }
                $result = LogicWorkReport::insert_work_report_data($DataArr);
                
                if (!empty($result)){ //添加成功 到自己列表页
                    $error = 'success';
                }
            }else{
                $error = $params['workdate'].'工作小结已存在';
            }
        }        
        $this->render('report',array('error'=>$error));
    }

    public function actionEdit($id){        
        if (empty($id)){
            throw new CHttpException(404, '页面不存在');
        }                      
        $params = $this->params();  
        $reportinfo = LogicWorkReport::get_work_report_info_by_id($id);   
        
        if (!empty($params['id']) && !empty($params['workdate']) && !empty($params['tip'])){              
            $late = 0;
            $r_hours = floor(($reportinfo['created']-strtotime($params['workdate'])) /3600);   
            if (in_array(date('w',time()),array(2,3,4,5) )){
                if ($r_hours >= 33 ){
                    $late = 1;
                }
            }else if (date('w',time()) == 1){
                if ($r_hours >= 81 ){
                    $late = 1;
                }
            }
                        
            $dataArr = array('report'=>htmlspecialchars(MyTool::html_to_code($params['tip'])) , 'reportTime'=>strtotime($params['workdate']) , 'late'=>$late);
            $whereArr = array('id'=>$params['id']);
            $result = LogicWorkReport::update_work_report_data($dataArr,$whereArr);

            echo '<script type="text/javascript">location.href="'.Yii::app()->createUrl('/workreport/mywork/list/').'"</script>';
            exit;
                          
        }
        
                       
        $this->render('modify',array('row'=>$reportinfo));
    }
    
    public function actionAjax(){
        $params = $this->params();        
        $res = $this->_res;             
        switch($params['type']) {
            case 'checkdate':
                if (!empty($params['id']) && !empty($params['date']) ){
                    $result = LogicWorkReport::check_workdate(strtotime($params['date']),$params['id']);
                    if (empty($result)){
                        $res = $this->init_res($result);
                    }
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