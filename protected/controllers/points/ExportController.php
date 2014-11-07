<?php
/**
 * 易班人积分
 * @author JohNnY 
 * 
 */
class ExportController extends WebController {
    
    public function beforeAction($action) {        
        if (!Bll_Author::check_ybr_author()) {            
            throw new CHttpException('500','无权限访问');
        }
        return true;
    }
    
    public function actionIndex(){
        $params = $this->params();
        
        if (!empty($params)){
            $data = $this->get_data($params);
            if (!empty($data)){
                $dept = $this->get_dept($data);                
                $this->excel($data,$dept);
            }
        }

        $this->render('export');        
    }
    
    private function excel($data,$dept){
        $objPHPExcel = Pexcel::autoload();
        $_index = 1 ;
        foreach ($this->_build_excel_header() as $Key => $Val){                
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($Key.$_index, $Val);
        }
        $_index++ ;

        if (!empty($data)){
            foreach ($data as $dataKey => $dataVal){     
                $info = array();
                $info['A'] = $_index - 1;
                $info['B'] = $dataVal['uname'];
                $info['C'] = !empty($dept[$dataVal['uid']]) ? $dept[$dataVal['uid']] : '未知';
                $info['D'] = $dataVal['s'];
                $info['E'] = self::get_star_lv($dataVal['s']);  
                foreach ($info as $infoKey => $infoVal){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($infoKey.$_index, $infoVal);
                }
                $_index++;
                
            }
        }

        $objPHPExcel->getActiveSheet()->setTitle('积分统计');  
        Pexcel::save_excel($objPHPExcel,'积分统计');
        exit;
    }
    
    //获取星级
    static public function get_star_lv($score){
        if ($score >= 100 && $score < 300){
            return '一星易班人';
        }else if ($score >= 300 && $score < 600){
            return '二星易班人';
        }else if ($score >= 600 && $score < 1000){
            return '三星易班人';
        }else if ($score >= 1000 && $score < 2000){
            return '四星易班人';
        }else if ($score >= 2000){
            return '五星易班人';
        }else{
            return '';            
        }
    }
    
    /**
     * 文件头
     * @return array
     */
    private function _build_excel_header() {
        return array("A"=>"序号","B"=>"姓名","C"=>"部门","D"=>"积分","E"=>"星级");
    }
    
    private function get_dept($data){
        foreach($data as $dataKey => $dataVal){
            $uids[] = $dataVal['uid'];
        }
        $userArr = LogicUser::get_dept_by_userids($uids);
        return $this->_init_arr($userArr);
    }
    
    private function get_data($params){
        //var_dump($params);
        $data = array();
        switch ($params['s_type']){
            case '1':  //按月
                $data = LogicPointsInfo::get_score_uid_by_term($params['s_type'],$params['m_date']);
                break;
            case '2':  //按年
                $data = LogicPointsInfo::get_score_uid_by_term($params['s_type'],$params['y_date']);
                break;
            case '3':  //累计
                $data = LogicPointsInfo::get_score_uid_by_term();
                break;
            default :
                break;
        }
        return $data;
    }
    
    private function _init_arr($userArr){
        if (empty($userArr)){
            return array();
        }
        foreach ($userArr as $Key => $Val){
            $result[$Val['uid']] = $Val['dept_cn'];
        }
        return $result;
    }
    

}