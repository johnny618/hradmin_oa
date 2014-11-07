<?php
class AttendController extends WebController {

    public function actionIndex(){
        //权限判断
        if (!in_array(Yii::app()->user->id, MyConst::$attendance_users)){
            throw new CHttpException(500,'无权限访问');
        }     
        Pexcel::set_val();
        $this->render('list');
    }
    
    public function actionAjax(){
        $params = $this->params(); 
        $res = $this->_res;
        switch($params['type']) {            
            case 'export':
                $test = array(0=>array('10000405','2013-07-29 11:00:00'),
                    1=>array('10000405','2013-07-30 11:00:00'),
                    2=>array('10000405','2013-07-25 11:00:00'),
                    3=>array('10000406','2013-07-28 11:00:00'),
                    4=>array('10000407','2013-07-29 11:00:00'),
                    );

                //attendance::set_val();
                
                $res = $this->init_res();
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